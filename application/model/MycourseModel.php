<?php
    namespace app\model;

    use think\Model;

    class MycourseModel extends Model
    {
        //指定model使用的表名
        protected $table = 'my_course';
        //指定 表的主键
        protected $pk = 'id';

    }
