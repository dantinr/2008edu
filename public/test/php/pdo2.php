<?php

    //实例化 pdo
    $dsn = 'mysql:host=127.0.0.1;dbname=edu2008';
    $user = 'lisi';
    $pass = '123456';
    $dbh = new PDO($dsn, $user, $pass);

    //设置 编码
    $dbh->query('set names utf8');


    //查询数据
    $sql = "delete from order_info where order_id=" .  $_GET['oid'];
    $sql = "select * from order_info where order_id=" .  $_GET['oid'];
    echo $sql;echo '</br>';

    //预处理
    $res = $dbh->prepare($sql);

    //执行 增删改 SQL
    $data = $res->execute();
    $rows = $res->fetchAll(PDO::FETCH_ASSOC);       //以关联数组的形式返回记录
    echo '<pre>';print_r($rows);echo '</pre>';

    //检测影响的行数
    $affect_row = $res->rowCount();
    echo "影响的行数: " .$affect_row;echo '</br>';


