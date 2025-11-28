<?php
header('Content-Type:application/json');
include 'db.php';//include database connection
//validate the request
if(!isset($_GET['id']) || $_GET['id'] === "") {
    echo json_encode([
        "status"=> "error",
        "message"=> "Product ID is required"
    ]);
    exit;
}
//clean the input
$id = intval($_GET['id']);
//run sql query
$query =$conn->prepare("SELECT * FROM products WHERE id =?");
$query->bind_param("i",$id);
$query->execute();
$result= $query->get_result();
//return product if exist
if($result && $result->num_rows> 0){
    $product =$result->fetch_assoc();
    echo json_encode([
        "status"=>"success",
        "data"=>$product
    ]);
} else{ //return error if doesnt exist
    echo json_encode([
        "status"=>"error",
        "message"=>"product not found"
    ]);
}
?>