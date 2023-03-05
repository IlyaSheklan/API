<?php

function checkCookerToken($connect){
    $jwr = explode(' ', getallheaders()["Authorization"]);
    $token = $jwr[1];

    $cooker = mysqli_query($connect, "SELECT `token`, `group` FROM `users` WHERE `token`='".$token."'");
    $user = mysqli_fetch_assoc($cooker);

    if(mysqli_num_rows($cooker) > 0){
        if($user['group'] == 'Cooker'){
            return true;
        }
        else{
            echo 'error 403 Forbidden';
        }
    }
    else{
        echo 'error 403 login';
    }
}


?>