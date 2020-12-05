<?php
namespace app\user\controller;

use think\Db;
use think\Request;
use think\Session;

class Index
{

    public function test()
    {
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
        return view();
    }


    /**
     * 登录逻辑
     */
    public function loginDo()
    {
        $name = $_POST['user_name'];    // 可能是 用户名或Email或手机号
        $pass = $_POST['pass'];

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
                Db::table('p_users')->where(['uid'=>$u['uid']])->update(['last_login'=>time()]);
                //保存 登录信息
                $_SESSION['user_name'] = $u['user_name'];
                $_SESSION['uid'] = $u['uid'];

                session('name',$u['user_name']);
                session('uid',$u['uid']);


                echo "登录成功";

            }else{
                echo '<pre>';print_r($_SESSION);echo '</pre>';
                echo "密码错误";
            }

        }else{
            echo "用户不存在";
        }

    }


    /**
     * 个人中心
     */
    public function center()
    {

        if(isset($_SESSION['uid']))
        {
            echo "欢迎： ". $_SESSION['user_name'];
        }else{
            echo "请先登录";
        }
    }
}
