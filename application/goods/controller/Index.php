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

        $page = $_GET['page'];          // 获取当前的页号
        $size = 10;                     //每页展示记录数

        echo "当前页号：". $page;echo '</br>';

        $start = ($page-1) * $size;     // 1=>0 2=>10 3 20

        $sql = "select * from p_goods limit $start,$size";
        echo "sql语句： ". $sql;

        $list = Db::query($sql);

        echo "<ul>";
        foreach($list as $k=>$v)
        {
            echo "<li>";
            echo  '(' . $v['goods_id'] .')'. "商品名：". $v['goods_name'];
            echo "</li>";
        }
        echo "</ul>";

    }

}
