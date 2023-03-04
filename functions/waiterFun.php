<?php
    function createOrder($connect, $data){
        $work_shift_id = $data["work_shift_id"];
        $table_id = $data["table_id"];
        $number_of_person = $data["number_of_person"];

        $shifts = mysqli_query($connect, "SELECT * FROM `work_shift` WHERE `id`='$work_shift_id' AND `active`='true'");

        if(mysqli_num_rows($shifts) > 0){
            $shift_fields = mysqli_fetch_assoc($shifts);

            $user_id = $shift_fields["id_user"];
            $users = mysqli_query($connect, "SELECT `surname` FROM `users` WHERE `id`='$user_id'");
            $user_fields = mysqli_fetch_assoc($users);

            $surn = $user_fields["surname"];
            $date = date('d.m.Y H:i:s');

            mysqli_query($connect, "INSERT INTO `orders`(`id`, `table_number`, `shift_workers`, `create_at`, `status`, `price`, `id_shift`) VALUES (NULL,'$table_id','$surn','$date','Принят', 0, '$work_shift_id')");
            $orders = mysqli_query($connect, "SELECT * FROM `orders`");
            $order_fields = mysqli_fetch_assoc($orders);

            $response = [
                "data" => [
                    "id" => $order_fields["id"],
                    "table" => "Столик №" . $order_fields["table_number"],
                    "shift_workers" => $order_fields["shift_workers"],
                    "create_at" => $order_fields["create_at"],
                    "status" => $order_fields["status"],
                    "price" => $order_fields["price"] 
                ]
            ];

            echo json_encode($response);
        }
        
    }
