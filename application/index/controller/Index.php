<?php
namespace app\index\controller;
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
        return view();
    }


    /**
     * @return
     */
    public function seat()
    {
        $list = Db::table('p_seats')->all();
        //echo '<pre>';print_r($list);echo '</pre>';
        $data = [
            'list'  => $list
        ];
        return view('seat',$data);
    }

    public function reserve(Request $request)
    {
        $id = $request->post('id');
        Db::table('p_seats')->where('id',$id)->update(['status'=>1,'add_time'=>time()]);
        $response = [
            'errno' => 0,
            'msg'   => 'ok'
        ];

        echo json_encode($request);
    }


}
