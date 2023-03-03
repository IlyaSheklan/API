<?php

// Генерация jw токена
function get_token() {
	$token = md5(microtime() . 'salt' . time());
	return $token;
}

// Аунтефикация пользователя
function loginUser($connect, $data){
    $login = $data['name'];
    $password = $data['password'];

    $loginDB = mysqli_query($connect, "SELECT * FROM `users` WHERE `name` = '$login' AND `password` = '$password'");
   
    if(mysqli_num_rows($loginDB) !== 0){
        $token = get_token();
        $response = [
            "data" => [
                "user_token" => $token,
            ]
        ];

        $user = mysqli_fetch_assoc($loginDB);
        $idUser = $user["id"];

        mysqli_query($connect, "UPDATE `users` SET `token`='$token' WHERE `id` = '$idUser' ");

        http_response_code(200);
        echo json_encode($response);
    }
    else{
        $response = [
            "error" => [
                "code" => 401,
                "message" => "Authentication failed",
            ]
        ];

        http_response_code(401);
        echo json_encode($response);
    }
}

// Выход пользователя из системы
function logoutUser($connect){

    mysqli_query($connect, "UPDATE `users` SET `token`=' ' WHERE `token` IS NOT NULL ");
    $response = [
        "data" => [
            "message" => "logout",
        ]
    ];

    echo json_encode($response);
}

?>