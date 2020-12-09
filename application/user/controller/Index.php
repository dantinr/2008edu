<?php
namespace app\user\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use app\user\model\User;

class Index extends Controller
{

    public function test()
    {
        $u = User::where('uid','=',3)->find();
        echo '<pre>';print_r($u);echo '</pre>';
        echo __METHOD__;die;
        return redirect('/index.php?s=user/index/login');
    }

    /**
     * 用户注册 View
     */
    public function reg()
    {
        return view();
    }


    /**
     * 用户注册
     */
    public function regDo(Request $request)
    {

        $user_name = $request->post('user_name');       // $_POST['user_name']
        $mobile = $request->post('mobile');
        $email = $request->post('email');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //验证两次输入的密码是否一致
        if($pass1 != $pass2)
        {
            echo "两次输入的密码不一致";die;
        }

        //验证用户名是否存在
        $u = Db::table('p_users')->where(['user_name'=>$user_name])->find();
        if($u)
        {
            echo "用户名已存在";die;
        }

        //验证手机号是否已存在
        $u = Db::table('p_users')->where(['mobile'=>$mobile])->find();
        if($u)
        {
            echo "手机号已存在";die;
        }

        //验证Email是否已存在
        $u = Db::table('p_users')->where(['email'=>$email])->find();
        if($u)
        {
            echo "Email已存在";die;
        }

        $user_info = [
            'user_name' => $user_name,
            'mobile'    => $mobile,
            'email'     => $email,
            'pass'      => password_hash($pass1,PASSWORD_BCRYPT),
            'reg_time'  => time()
        ];

        // 用户信息入库
        $uid = Db::table('p_users')->insertGetId($user_info);
        if($uid>0){
            echo "注册成功： ". $uid;echo '</br>';
            //注册成功后重定向至登录页面
            redirect('/index.php?s=user/index/login');

        }else{
            echo "注册失败";
        }

    }


    /**
     * 注册页面 View
     */
    public function login()
    {
        //判断是否已登录
        $uid = session('uid');
        if($uid)        // 已登录
        {
            $this->success('您已登录，正在跳转至个人中心','/index.php?s=user/index/center');
        }else{  // 未登录
            return view();
        }

    }


    /**
     * 登录逻辑
     */
    public function loginDo()
    {
        $name = $_POST['user_name'];    // 可能是 用户名或Email或手机号
        $pass = $_POST['pass'];
        $now = time();

        //检查用户是否被锁定 查看登录记录表中一小时内三条记录 是否都是错误的登录
        $login_records = Db::table('p_login_history')->where('user_name','=',$name)
            ->where('status','=',0)
            ->where('login_time','>',$now-3600)
            ->order('id','desc')->all();

        if( count($login_records) >=3 )     // 一小时内错误次数超过三次 禁止用户登录
        {
            $this->error("密码错误次数太多，账户已被锁定");
            exit;
        }


        //查询数据库中记录
        $u = Db::table('p_users')->where(['user_name'=>$name])
            ->whereOr(['email'=>$name])
            ->whereOr(['mobile'=>$name])
            ->find();

        if($u)      //用户存在
        {
            //验证密码
            if( password_verify($pass,$u['pass']) ){

                //更新最后登录时间
                Db::table('p_users')->where(['uid'=>$u['uid']])->update(['last_login'=>$now]);
                //保存 登录信息
                session('name',$u['user_name']);
                session('uid',$u['uid']);
                session('login_time',date('Y-m-d H:i:s',$now));

                //记录登录成功的信息
                $login_info = [
                    'uid'           => $u['uid'],
                    'user_name'     => $u['user_name'],
                    'login_time'    => $now,
                    'status'        => 1
                ];
                Db::table('p_login_history')->insert($login_info);

                $this->success('登录成功', '/index.php?s=user/index/center');

            }else{
                //记录登录错误
                $error_info = [
                    'uid'           => $u['uid'],
                    'user_name'     => $u['user_name'],
                    'login_time'    => $now,
                    'status'        => 0
                ];
                Db::table('p_login_history')->insert($error_info);
                $this->error('用户名或密码错误');
            }

        }else{
            $this->error('用户不存在');
        }

    }


    /**
     * 个人中心
     */
    public function center()
    {

        $name = session('name');        //取 session中的 name字段
        $uid = session('uid');
        if($name)
        {

            //获取用户信息
            $u = Db::table('p_users')->where("uid",'=',$uid)->find();

            //判断用户是否已签到过
            $today = strtotime( date('Y-m-d') ) ;     // 今天开始时的时间戳
            $record = Db::table('p_qiandao')->where('uid','=',$uid)
                ->where("add_time",'>=',$today)->find();

            if($record){        //用户签到过
                $qiandao = 1;
                $qiandao_time = date('Y-m-d H:i:s' ,$record['add_time']);
            }else{
                $qiandao = 0;
                $qiandao_time = 0;
            }

            //在模板中显示用户信息
            $user_info = [
                'user_name' => $name,
                'time'      => date('Y-m-d H:i:s'),
                'login_time'    => session('login_time'),
                'qiandao'   => $qiandao,        //签到状态
                'qiandao_time'   => $qiandao_time,        //签到时间
                'score'     => $u['score'],
                'avatar'    => $u['avatar'],            //头像
            ];
            return view('center',$user_info);
        }else{
            echo "请先登录";
        }
    }

    /**
     * 退出登录 清空session中的登录信息
     */
    public function logout()
    {
        session('name',null);
        session('uid',null);

        return redirect('/index.php?s=user/index/login');

    }

    /**
     * 用户签到
     */
    public function qiandao()
    {

        // 1 获取用户uid
        $uid = session('uid');

        //判断用户是否已签到过
        $today = strtotime( date('Y-m-d') ) ;     // 今天开始时的时间戳
        // select * from qiandao where uid=123 and add_time>=$today
        $record = Db::table('p_qiandao')->where('uid','=',$uid)
            ->where("add_time",'>=',$today)->all();


        if($record)     // 已经签到过了
        {
            $this->error("您已经签到过了");
        }else{

            //赠送 100 积分
            Db::table('p_users')->where('uid','=',$uid)->setInc('score',100);

            // 签到信息入库 uid  签到时间
            $id = Db::table('p_qiandao')->insertGetId(['uid'=>$uid,'add_time'=>time()]);
            if($id)
            {
                $this->success("签到成功");
            }
        }


    }

    /**
     * 修改密码
     */
    public function changePass()
    {
        return view('change-pass');
    }

    public function changepass2(Request $request)
    {
        $uid = session('uid');
        $pass0 = $request->post('pass0');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //密码不能为空
        if(empty($pass0) || empty($pass1) || empty($pass2))
        {
            $this->error("密码不能为空");
        }

        //两个新密码是否一致
        if($pass1 != $pass2)
        {
            $this->error('新密码不一致');
        }

        //获取用户信息
        $u = Db::table('p_users')->where(['uid'=>$uid])->find();
        //验证当前密码是否正确
        $status = password_verify($pass0,$u['pass']);
        if(!$status)
        {
            $this->error("当前密码不正确");
        }

        // 生成新密码
        $new_pass = password_hash($pass1,PASSWORD_BCRYPT);

        //更新用户表中的用户密码
        Db::table('p_users')->where("uid",'=',$uid)->update(['pass'=>$new_pass]);

        //修改成功后 清空session中的登录信息 重新登录
        session('user_name',null);
        session('uid',null);
        $this->success("密码修改成功",'/');
    }


    /**
     * 上传头像
     */
    public function uploadAvatar()
    {
        return view('upload-avatar');
    }

    public function uploadavatar2(Request  $request)
    {

        $uid = session('uid');
        $save_path = 'uploads/';            //文件的保存路径  public/uploads

        $file = request()->file('image');   //接收文件
        $info = $file->move($save_path);
        if($info){
            // 成功上传后 获取上传信息
            $file_path = $save_path . $info->getSaveName();

            //更新用户表 头像字段
            Db::table('p_users')->where(['uid'=>$uid])->update(['avatar'=>$file_path]);

            $this->success("头像上传成功");
        }else{
            // 上传失败获取错误信息
            echo $file->getError();echo '</br>';
        }
    }

}
