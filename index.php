<?php

require 'connect.php';
require 'functions/generalFun.php';
require 'functions/adminFun.php';
require 'functions/waiterFun.php';
require 'functions/cookerFun.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

// Роутинг
$q = $_GET['q'];
$parms = explode('/', $q);

$type = $parms[0];
$id = $parms[1];
$active = $parms[2];

switch($method){
    case "GET":
        if($type === "users"){
            if($id){
                getOneRecord($connect, $id);
            } else{
                getRecords($connect);
            }
        }

        if($type === "logout"){
            logoutUser($connect);
        }

    break;

    case "POST":
        if($type === "users"){
            addRecord($connect, $_POST);
        }

        if($type === "login"){
            loginUser($connect, $_POST);
        }

        if($type === "work-shift"){
            if($active === 'open'){
                openWorkShift($connect, $id);
            } 
            
            elseif($active === 'close'){
                closeWorkShift($connect, $id);
            } 

            elseif($active === 'user'){
                addUserInShift($connect, $_POST, $id);
            }
            
            else{
                addWorkShift($connect, $_POST);
            }
        }

    break;
}

?>