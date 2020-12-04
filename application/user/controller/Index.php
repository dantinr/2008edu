<?php
namespace app\user\controller;

use think\Db;

class Index
{
    public function abc()
    {
        echo __METHOD__;
        $u = Db::table('p_users')->where(['user_id'=>10])->find();
        echo '<pre>';print_r($u);echo '</pre>';

    }
}
