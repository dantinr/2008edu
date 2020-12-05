<?php
namespace app\index\controller;
use think\Db;
use think\Controller;

class Index
{
    public function index()
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

}
