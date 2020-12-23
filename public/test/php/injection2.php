<?php

    // SQL 查询注入  get传参为整型

    $user = 'lisi';
    $pass = '123456';
    $host = '127.0.0.1';
    $db = 'edu2008';

    //连接MySQL
    $mysqli = new mysqli($host, $user, $pass, $db);

    $sql = "select * from p_users where uid=" .  $_GET['id'];

    echo $sql;echo '</br>';

    $res = $mysqli->query($sql);


    var_dump($res);


