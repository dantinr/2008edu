<?php
namespace app\user\controller;

use think\Db;
use think\Request;

class Index
{
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
        echo '<pre>';print_r($request->post());echo '</pre>';

    }
}
