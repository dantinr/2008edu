<?php
    namespace app\model;

    use think\Model;

    class OrderModel extends Model
    {
        //指定model使用的表名
        protected $table = 'order_info';
        //指定 表的主键
        protected $pk = 'order_id';

    }
