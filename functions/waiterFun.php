<?php

function checkWaiterToken($connect){
    $jwr = explode(' ', getallheaders()["Authorization"]);
    $token = $jwr[1];

    $waiter = mysqli_query($connect, "SELECT `token`, `group` FROM `users` WHERE `token`='".$token."' ");
    $user = mysqli_fetch_assoc($waiter);

    if(mysqli_num_rows($waiter) > 0){
        if($user['group'] == 'Waiter'){
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

function getTest($connect){
    checkWaiterToken($connect);
}

?>