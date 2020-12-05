<?php
    // talk is cheap , show me the code

    session_start();        // 开启 会话

    $_SESSION['name'] = 'zhangsan';
    $_SESSION['uid'] = 1234;

    echo '<pre>';print_r($_SESSION);echo '</pre>';