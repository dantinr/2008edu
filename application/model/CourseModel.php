<?php
    namespace app\model;

    use think\Model;

    class CourseModel extends Model
    {
        //指定model使用的表名
        protected $table = 'p_course';
        //指定 表的主键
        protected $pk = 'course_id';

    }
