<?php

//使用 mysqli 连接MySQL 数据库

$user = 'lisi';
$pass = '123456';
$host = '127.0.0.1';
$db = 'edu2008';

//连接MySQL
$mysqli = new mysqli($host, $user, $pass, $db);

//写sql语句
$sql = "select * from p_users where uid=" . $_GET['id'];
echo $sql;echo '</br>';

//执行sql语句 , 获取结果集
$res = $mysqli->query($sql);
var_dump($res);echo '</br>';

//在结果集中获取数据
$data = $res->fetch_all(MYSQLI_ASSOC);
echo '<pre>';print_r($data);echo '</pre>';

