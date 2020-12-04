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
        $user_name = $request->post('user_name');       // $_POST['user_name']
        $mobile = $request->post('mobile');
        $email = $request->post('email');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //验证两次输入的密码是否一致
        if($pass1 != $pass2)
        {
            echo "两次输入的密码不一致";die;
        }

        //验证用户名是否存在
        $u = Db::table('p_users')->where(['user_name'=>$user_name])->find();
        if($u)
        {
            echo "用户名已存在";die;
        }

        //验证手机号是否已存在
        $u = Db::table('p_users')->where(['mobile'=>$mobile])->find();
        if($u)
        {
            echo "手机号已存在";die;
        }

        //验证Email是否已存在
        $u = Db::table('p_users')->where(['email'=>$email])->find();
        if($u)
        {
            echo "Email已存在";die;
        }

        $user_info = [
            'user_name' => $user_name,
            'mobile'    => $mobile,
            'email'     => $email,
            'pass'      => password_hash($pass1,PASSWORD_BCRYPT),
            'reg_time'  => time()
        ];

        // 用户信息入库
        $uid = Db::table('p_users')->insertGetId($user_info);
        if($uid>0){
            echo "注册成功： ". $uid;echo '</br>';
        }else{
            echo "注册失败";
        }

    }


    /**
     * 注册页面 View
     */
    public function login()
    {
        return view();
    }


    public function loginDo()
    {
        // 用户名  +  手机号  +  Email

        // 密码验证
        password_verify();

        //将用户信息保存在 session中
    }
}
