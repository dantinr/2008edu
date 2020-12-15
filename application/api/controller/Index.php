<?php
    namespace app\api\controller;
    use think\Db;
    use think\Request;

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


        public function form1()
        {
            echo '<pre>';print_r($_POST);echo '</pre>';
            //接收文件
            $files = $_FILES;
            echo '<pre>';print_r($_FILES);echo '</pre>';
        }

        /**
         * 验证用户名是否存在
         */
        public function checkname(Request $request)
        {
            $name = $request->get('name');
            $u = Db::table('p_users')->where("user_name",$name)->find();

            if($u)
            {
                $response = [
                    'errno' => 300001,
                    'msg'   => '用户名已存在'
                ];
            }else{

                $response = [
                    'errno' => 0,
                    'msg'   => '可以使用'
                ];

            }

            echo json_encode($response);        //返回 JSON字符串

        }
    }
