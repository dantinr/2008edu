<?php
namespace app\goods\controller;
use think\Db;
use think\Controller;

class Index
{
    /**
     * 商品
     */
    public function index()
    {

    }

    /**
     * 商品列表页
     */
    public function goodslist()
    {
        $sql = "select * from p_goods limit 0,5";
        $list = Db::query($sql);

        //echo '<pre>';print_r($list);echo '</pre>';

        echo "<ul>";
        foreach($list as $k=>$v)
        {
            echo "<li>";
            echo "商品名：". $v['goods_name'];
            echo "</li>";
        }
        echo "</ul>";

        //return view('goods-list',$list);
    }

}
