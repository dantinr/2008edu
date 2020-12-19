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


}
