<?php

function connection() {
    try {
        $pdo = new PDO('sqlite:database/db.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function generate_token($user,$password){
    $usercount = 0;

    $pdo = connection();
    $query = "select * from user where email = :user and password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(":user", $user);
    $stmt->bindValue(":password", $password);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usercount++;
    }
    // return $token;


    if ($usercount > 0) {
        $token = bin2hex(random_bytes(32));
        $query = "insert into token values (:user,:token) ON CONFLICT (user_id) DO UPDATE SET 
                  token = :token;";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(":user", $user);
        $stmt->bindValue(":token", $token);
        $stmt->execute();
        return json_encode(["status"=>"success",
                                    "token"=>$token]);
    }

    else {
        return json_encode(["status"=>"error",
                                    "message"=>"wrong username / password"]);
    }
   
}

function validate_token($token){
    $user = "";
    $pdo = connection();
    $query = "select * from token where token = :token";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(":token", $token);
    $stmt->execute();
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $count++;
        $user = $row["user_id"];
    }

    if ($count > 0) {
        return ["user"=>$user,"token_is_valid"=>true];
    }
    else {
        return ["user"=>$user,"token_is_valid"=>false];
    }
}