<?php
    $user = 'root';
    $pass = '123456abc';
    $pdo = new PDO('mysql:host=localhost;dbname=edu2008', $user, $pass,[PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8']);

    $user_id = $_GET['id'];
    $sql = "select * from p_users where uid=".$user_id;
    echo $sql;echo '</br>';

    $res = $pdo->query($sql);
    $data = $res->fetchAll(PDO::FETCH_ASSOC);

    //echo '<pre>';print_r($data);echo '</pre>';

    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr><th>用户ID</th><th>用户名</th><th>Email</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach($data as $k=>$v){
        echo "<tr><td>{$v['uid']}</td><td>{$v['user_name']}</td><td>{$v['email']}</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
