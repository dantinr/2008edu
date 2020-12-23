<?php

    //实例化 pdo
    $dsn = 'mysql:host=127.0.0.1;dbname=edu2008';
    $user = 'lisi';
    $pass = '123456';
    $dbh = new PDO($dsn, $user, $pass);

    //设置 编码
    $dbh->query('set names utf8');


    //查询数据
    $sql = 'select * from p_users where uid=' .  $_GET['id'];
    echo $sql;echo '</br>';


    //得到结果集
    $res = $dbh->query($sql);
    var_dump($res);

    //在结果集中获取数据
    $data = $res->fetchAll(PDO::FETCH_ASSOC);

    echo '<pre>';print_r($data);echo '</pre>';

