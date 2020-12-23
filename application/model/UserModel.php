<?php
    namespace app\model;

    use think\Model;            //继承 TP的 model

    class UserModel extends Model
    {
        //指定model使用的表名
        protected $table = 'p_users';
        //指定 表的主键
        protected $pk = 'uid';

    }
