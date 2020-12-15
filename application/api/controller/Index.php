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
        public function check(Request $request)
        {
            $name = $request->get('name');
            $email = $request->get('email');
            $mobile = $request->get('mobile');


            //检测Email
            if($email)
            {
                $u = Db::table('p_users')->where("email",$email)->find();
                if($u)
                {
                    $response = [
                        'errno' => 300002,
                        'msg'   => 'Email已存在'
                    ];
                }else{
                    $response = [
                        'errno' => 0,
                        'msg'   => 'EMail可以使用'
                    ];

                }

                echo json_encode($response);
            }

            //检测用户名
            if($name)
            {
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

            //检测电话号
            if($mobile)
            {
                $u = Db::table('p_users')->where("mobile",$mobile)->find();

                if($u)
                {
                    $response = [
                        'errno' => 300003,
                        'msg'   => '电话号已存在'
                    ];
                }else{

                    $response = [
                        'errno' => 0,
                        'msg'   => '电话号可以使用'
                    ];

                }

                echo json_encode($response);        //返回 JSON字符串
            }

        }
    }
