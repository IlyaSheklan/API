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

$data = json_decode(file_get_contents("php://input"), true);

switch($method){
    case "GET":
        if($type === "user"){
            if($id){
                getOneRecord($connect, $id);
            } else{
                getRecords($connect);
            }
        }

        if($type === "logout"){
            logoutUser($connect);
        }

        if($type === "work-shift"){

            if($active === 'open'){
                openWorkShift($connect, $id);
            } 
            
            if($active === 'close'){
                closeWorkShift($connect, $id);
            } 

            if($active === 'order'){
                getOrders($connect, $id);
            }
        }

    break;

    case "POST":
        if($type === "user"){
            addRecord($connect, $_POST);
        }

        if($type === "login"){
            loginUser($connect, $data);
        }

        if($type === "work-shift"){
           
            if($active === 'user'){
                addUserInShift($connect, $data, $id);
            }
            
            else{
                addWorkShift($connect, $data);
            }
        }

        if($type === "order"){
            createOrder($connect, $data);
        }

    break;
}

?>