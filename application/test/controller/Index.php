<?php
namespace app\test\controller;
use app\model\UserModel;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        echo __METHOD__;
    }

    public function u()
    {
        $u = UserModel::where(['uid'=>8])->find()->toArray();
        echo '<pre>';print_r($u);echo '</pre>';
    }
}
