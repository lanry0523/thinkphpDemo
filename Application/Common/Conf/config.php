<?php

$config = array();
// 加载数据库中的配置与数据库配置
if(file_exists(APP_ROOT_PATH.'public/db/db_config.php'))
{
    //定义DB
    require APP_ROOT_PATH . 'public/db/db.php';
    $dbcfg = require APP_ROOT_PATH . "public/db/db_config.php";
    $db = new MySQLDB($dbcfg);
    $GLOBALS['db'] = $db;
    $config = array_merge($config,$dbcfg);
}
if(file_exists(APP_ROOT_PATH.'public/http/http.class.php')){
    require APP_ROOT_PATH . 'public/http/http.class.php';
    $http = new http();
    $GLOBALS['http']= $http;
}
?>