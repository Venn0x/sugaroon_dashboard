<?php
session_start();
define('wcode.ro',true);

error_reporting(E_ALL);
ini_set("display_errors", 1);

spl_autoload_register(function ($class) {
    include 'inc/' . $class . '.inc.php';
});

Config::init()->getContent();
?>