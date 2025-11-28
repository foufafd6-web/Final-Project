<?php
header('Content-Type:application/json');
include 'db.php';
if(!isset($_GET['id']) || $_GET['id'] === "") {
    echo json_encode([
        "status"=> "error",
        "message"=> "Product ID is required"
    ]);
    exit;
}
$id = intval($_GET['id']);
$query =$conn->prepare("SELECT * FROM products WHERE id =?");
$query->bind_param("i",$id);
$query->execute();
$result= $query->get_result();

if($result && $result->num_rows> 0){
    $product =$result->fetch_assoc();
    echo json_encode([
        "status"=>"success",
        "data"=>$product
    ]);
} else{
    echo json_encode([
        "status"=>"error",
        "message"=>"product not found"
    ]);
}
?>