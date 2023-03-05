<?php

// Подключение всех функций
require 'connect.php';
require 'functions/generalFun.php';
require 'functions/adminFun.php';
require 'functions/waiterFun.php';
require 'functions/cookerFun.php';

// Настройки доступности
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Настройки ресурсов и данных
$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$parms = explode('/', $q);

$type = $parms[0];
$id = $parms[1];
$active = $parms[2];

$data = json_decode(file_get_contents("php://input"), true);

// Страница не найдена
function not_found(){
    $resNotFound = [
        "message" => [
            "code" => 404,
            "message" => "Page not found"
        ]
    ];

    http_response_code(404);
    return json_encode($resNotFound);
}

// Роутинг
switch($method){
    case "GET":

        switch($type){
            case "user":
                if($id){
                    getOneRecord($connect, $id);
                } else{
                    getRecords($connect);
                }
                break;
                
            case "test":
                getTest($connect);
                break;

            case "logout":    
                logoutUser($connect);
                break;     
            
            default:
                echo not_found();
                break;

        }

    break;

    case "POST":

        switch($type){
            case "user":
                addRecord($connect, $_POST);
                break;

            case "login":
                loginUser($connect, $data);
                break;

            case "work-shift":
                if($active === 'open'){
                    openWorkShift($connect, $id);
                } 
                
                elseif($active === 'close'){
                    closeWorkShift($connect, $id);
                } 
    
                elseif($active === 'user'){
                    addUserInShift($connect, $data, $id);
                }
                
                elseif(empty($active) && empty($id)){
                    addWorkShift($connect, $data);
                }
                else{
                    echo not_found();
                }
                break;
            
            default:
                echo not_found();
        }

    break;
}

?>