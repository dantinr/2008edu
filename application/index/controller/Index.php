<?php
namespace app\index\controller;
use app\model\OrderModel;
use app\model\UserModel;
use think\Db;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index0()
    {
        $uid = session('uid');
        //判断用户是否登录
        if(empty($uid))       // 未登录 跳转至登录页面
        {
            return redirect('/index.php?s=user/index/login');
        }else{       // 已登录 跳转至个人中心
            return redirect('/index.php?s=user/index/center');
        }

    }


    public function liebiao()
    {
        $offset = 5;               // 每页显示的数据数量

        $list = Db::name('p_goods')->paginate($offset);

        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
        return $this->fetch();
    }


    /**
     * 网站首页
     */
    public function index()
    {
        $user = session('name');

        //获取课程列表  分类是php的课程
        $php_list = Db::table('p_goods')
            ->field('goods_id,goods_name,click_count')
            ->where(['cat_id'=>52])->limit(12)->select();

        foreach ($php_list as $k=>&$v){
            $v['goods_name'] = mb_substr($v['goods_name'],0,15) . '...';
        }

        //获取 javascript 分类的课程
        $js_list = Db::table('p_goods')
            ->field('goods_id,goods_name,click_count')
            ->where(['cat_id'=>780])->limit(12)->select();

        foreach ($js_list as $k=>&$v){
            $v['goods_name'] = mb_substr($v['goods_name'],0,15) . '...';
        }

        $data = [
            'user'          => $user,
            'php_course'    => $php_list,
            'js_course'     => $js_list
        ];
        return view('index',$data);
    }


    /**
     * @return
     */
    public function seat()
    {
        $list = Db::table('p_seats')->all();
        foreach ($list as $k=>&$v){
            $v['price'] = $v['price'] / 100 . '.00';        //格式化价格显示
        }
        $data = [
            'list'  => $list
        ];
        return view('seat',$data);
    }

    /**
     * 预订座位
     * @param Request $request
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function reserve(Request $request)
    {
        $id = $request->post('id');
        Db::table('p_seats')->where('id',$id)->update(['status'=>1,'add_time'=>time()]);
        $response = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        echo json_encode($response);
    }

    /**
     * 一键重置
     */
    public function reserveCancel()
    {
        Db::table('p_seats')->where('id','>',0)->update(['status'=>0]);
        $response = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        echo json_encode($response);
    }


    public function u()
    {

        // 找出订单表中最新支付的一个订单
        $o = OrderModel::where('pay_time','>',0)
            ->order('order_id','desc')
            ->limit(1)
            ->select();
        echo '<pre>';print_r($o->toArray());echo '</pre>';
        die;

        // 统计订单表中所有已支付订单的总金额
        $total = OrderModel::where('pay_time','>',0)->sum('money_paid');
        var_dump($total);
        die;

        // 找出订单表中已支付的订单中订单金额最大的前10个订单
        $list = OrderModel::where('pay_time','>',0)
            ->field('order_id,order_sn,money_paid,user_id')
            ->order('money_paid','desc')
            ->limit(10)
            ->select()
            ->toArray();

        echo '<pre>';print_r($list);echo '</pre>';


    }

    public function u2()
    {

        $info = [
            'user_name' => 'zhangsan111',
            'email'     => 'zhangsan111@qq.com',
            'mobile'    => '13111112222',
        ];

        $u = UserModel::create($info);
        echo $u->uid;
        die;

        $user = new UserModel();
        $user->user_name = 'zhangsan';
        $user->age = 22;
        $user->mobile = '13312344321';
        $user->email = 'zhangsan@qqq.com';
        $res = $user->save();
        var_dump($res);echo '</br>';
        $id = $user->uid;
        var_dump($id);
    }




    public function u3()
    {
        //第二种 调用静态方法create
        $user = UserModel::create([
            'user_name'  =>  'zhangsan333',
            'email' =>  'zhangsan333@qq.com'
        ]);

        echo $user->uid; // 获取自增ID


        die;


        // 第一种 属性赋值
        $user           = new UserModel();
        $user->user_name     = 'zhangsan222';
        $user->age           = 22;
        $user->mobile        = '13312345678';
        $user->email        = 'zhangsan22@qq.com';
        $res = $user->save();

        $id = $user->uid;           //获取自增的id
        var_dump($id);

    }

}
