<?php
$host ="localhost";
$dbname ="mini_store";
$username ="root";
$password ="";
//create connection
$conn = new mysqli($host,$username,$password,$dbname);
//check connection
if($conn->connect_error){
    //if there is an error return json
    die(json_encode([
        "status" => "error",
        "message" =>"connection failed: " .$conn->connect_error
    ]));

}
?>