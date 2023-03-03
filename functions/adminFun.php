<?php

// Функция для вывода всех записей из БД
function getRecords($connect)
{
    $users = mysqli_query($connect, "SELECT * FROM `users`");

    $userList = [];

    while($user = $users -> fetch_assoc()){
        $userList["users"][] = $user;
    }

    echo json_encode($userList);
}

// Функция для вывода одной записи из БД по id
function getOneRecord($connect, $id)
{
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id';");

    if(mysqli_num_rows($user) === 0){
        $response = [
            "status" => false,
            "message" => "Record not found"
        ];

        http_response_code(404);
        echo json_encode($response);
    }
    else{
        $user = mysqli_fetch_assoc($user);
        echo json_encode($user);
    }
}

// Добавление новой записи в БД
function addRecord($connect, $data){
    $name = $data['name'];
    $surname = $data['surname'];
    $email = $data['email'];
    $password = $data['password'];
    $status = $data['status'];
    $group = $data['group'];

    mysqli_query($connect, "INSERT INTO `users`(`id`, `name`, `surname`, `email`, `password`, `token`, `status`, `group`) VALUES (NULL,'$name','$surname','$email','$password', '', '$status', '$group')");

    $response = [
        "status" => true,
        "message" => "Record created"
    ];

    http_response_code(201);
    echo json_encode($response);
}

// Добавление смены в БД
function addWorkShift($connect, $data){
    $start = $data["start"];
    $end = $data["end"];

    mysqli_query($connect, "INSERT INTO `work_shift`(`id`, `start`, `end`, `id_user`, `status`) VALUES (NULL,'$start','$end', '', '')");
    // $id = mysqli_query($connect, "SELECT `id` FROM `work_shift` WHERE `start` = '$start' AND `end` = '$end';");

    // $id = mysqli_fetch_assoc($id);

    $id = mysqli_insert_id($connect);

    $response = [
        "id" => /*$id["id"]*/ $id,
        "start" => $start,
        "end" => $end,
    ];

    http_response_code(201);
    echo json_encode($response);
}


// Функция открытия смены
function openWorkShift($connect, $id){
    $works = mysqli_query($connect, "SELECT active FROM `work_shift` WHERE `active` = 'true'");

    if(mysqli_num_rows($works) > 0){
        
        $response = [
            "error" => [
                "code" => 403,
                "message" => "Error",
            ]
        ];

        http_response_code(403);
        echo json_encode($response);

    } else{
        mysqli_query($connect, "UPDATE `work_shift` SET `active`='true' WHERE `id`='$id'");
        $allWorks = mysqli_query($connect, "SELECT * FROM `work_shift` WHERE `id`='$id'");

        $allWorks = mysqli_fetch_assoc($allWorks);


        $response = [
            "data" => [
                "id" => $id,
                "start" => $allWorks["start"],
                "end" => $allWorks["end"],
                "active" => $allWorks["active"],
            ]
        ];

        echo json_encode($response);
    }
}

// Функция закрытия смены
function closeWorkShift($connect, $id){
    $allWorks = mysqli_query($connect, "SELECT `active` FROM `work_shift` WHERE `id`='$id'");
    $active = mysqli_fetch_assoc($allWorks);

    if($active["active"] === "false"){
        
        $response = [
            "error" => [
                "code" => 403,
                "message" => "Error",
            ]
        ];

        http_response_code(403);
        echo json_encode($response);

    } else{
        mysqli_query($connect, "UPDATE `work_shift` SET `active`='false' WHERE `id`='$id'");

        $allWorks = mysqli_query($connect, "SELECT * FROM `work_shift` WHERE `id`='$id'");
        $works = mysqli_fetch_assoc($allWorks);

        $response = [
            "data" => [
                "id" => $id,
                "start" => $works["start"],
                "end" => $works["end"],
                "active" => $works["active"],
            ]
        ];

        echo json_encode($response);
    }
}

// Добавление пользователя на смену
function addUserInShift($connect, $data, $idShift){
    $userId = $data["id"];

    $allUsers = mysqli_query($connect, "SELECT * FROM `users` WHERE `status`='working'");

    if(mysqli_num_rows($allUsers) > 0){

        $allShift = mysqli_query($connect, "SELECT `status` FROM `work_shift` WHERE `id_user`='$userId'");
        $statusShift = mysqli_fetch_assoc($allShift);

        if($statusShift["status"] != 'added'){
            mysqli_query($connect, "UPDATE `work_shift` SET `status`='added', `id_user` = '$userId' WHERE `id`='$idShift'");

            $response = [
                "data" => [
                    "id_user" => $userId,
                    "status" => "added",
                ]
            ];

            echo json_encode($response);
        }
        else{
            $response = [
                "error" => [
                    "code" => 403,
                    "message" => "Forbidden. The worker is already on shift!",
                ]
            ];

            http_response_code(403);
            echo json_encode($response);
        }
        
    }
}

function getOrders($connect, $id){
    $allShift = mysqli_query($connect, "SELECT * FROM `work_shift` WHERE `id`='$id'");
    $allOrders = mysqli_query($connect, "SELECT * FROM `orders` WHERE `id_shift`='$id'");

    $amount_for_all = 0;

    $shifts = mysqli_fetch_assoc($allShift);
    
    $orderList = [];

    while($order = $allOrders -> fetch_assoc()){
        $orderList[] = $order;
        $amount_for_all += $order["price"];
    } 

    $response = [
        "data" => [
            "id" => $id,
            "start" => $shifts["start"],
            "end" => $shifts["end"],
            "active" => $shifts["active"],
            "orders" => $orderList,

            "amount_for_all" => $amount_for_all,
        ]
    ];

    echo json_encode($response);
}

?>