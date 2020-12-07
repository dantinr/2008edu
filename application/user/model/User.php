<?php
namespace app\user\model;

use think\Model;


class User extends Model
{
    protected $table = 'p_users';           //指定model的表名
    protected $pk = 'uid';                  // 表的主键

}
