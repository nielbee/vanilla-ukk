<?php

include("./connection.php");

header('Content-Type: application/json');  
 header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');

if (isset($_POST["artist"]) && isset($_POST["title"]) && isset($_POST["lyric"])){
    
    if(validate_token($_POST["token"])["token_is_valid"]){
        uploadfile();
    }
    else{
        echo json_encode(["status" => "error", "message" => "invalid token"]);  
    } 
    
}
else{
    echo json_encode(["status" => "error", "message" => "artist, title and lyric required"]);
}






















function uploadfile(){
    $target_dir = "./music_files/";
    
    $uploadedFile = $_FILES["music_file"]["name"];
    $ext = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

    if ($ext !== "mp3") {
        echo json_encode(["status" => "error", "message" => "Only .mp3 files are allowed."]);
        return;
    }

    else {
        $id = strtolower($_POST["artist"]."-".$_POST["title"].".mp3");
        if(move_uploaded_file(($_FILES["music_file"]["tmp_name"]), $target_dir.$id)){
            
            echo json_encode(["status" => "success", "message" => "uploaded successfully."]);
            
            // writing music information on database 
            $query = "insert into music VALUES (:id,:artist,:title,:lyric,:file);";
            $pdo = connection();
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(":id",$id) ;
            $stmt->bindValue(":artist",$_POST["artist"]) ;
            $stmt->bindValue(":title",$_POST["title"]) ;
            $stmt->bindValue(":lyric",$_POST["lyric"]) ;
            $stmt->bindValue(":file",$id) ;
            $stmt->execute() ;
        
        }
        else{
            echo json_encode(["status" => "error", "message" => "error uploading file : ". var_dump($_FILES["music_file"])]);
        
    
        }
        
    }
}