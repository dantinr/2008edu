<?php
    namespace app\api\controller;
    use think\Db;

    class Index
    {


        public function index()
        {

        }

        /**
         * 获取商品列表
         */
        public function goodslist()
        {
            $offset = 5;
            $list = Db::table('p_goods')->paginate($offset);
            $data = $list->getCollection();
            echo json_encode($data);
        }
    }
