<?php

//使用 mysqli 连接MySQL 数据库

$user = 'lisi';
$pass = '123456';
$host = '127.0.0.1';
$db = 'edu2008';

//连接MySQL
$mysqli = new mysqli($host, $user, $pass, $db);

//写sql语句
$sql = "delete from order_info where order_id=" . $_GET['id'];

//预处理
$res = $mysqli->prepare($sql);

//执行
$data = $res->execute();

//检测sql执行影响的行数
$row = $res->affected_rows;
echo "影响的行数： ". $row;echo '</br>';



