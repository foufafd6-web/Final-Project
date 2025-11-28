<?php
header('Content-Type:application/json');
include 'db.php';

if(!isset($_GET['product_id'])|| $_GET['product_id']===""){
    echo json_encode([
        "status"=>"error",
        "message"=>"product_id is required"
    ]);
    exit;
}
$product_id =intval($_GET['product_id']);
$query =$conn->prepare("SELECT * FROM orders WHERE id =? ORDER BY id DESC LIMIT 10");
$query->bind_param("i",$product_id);
$query->execute();
$result= $query->get_result();

$orders=[];
if($result &&$result->num_rows > 0){
    while($row=$result->fetch_assoc()){
        $orders[]=$row;
    }
    echo json_encode([
        "status"=>"success",
        "orders"=>$orders
    ]);
} else {
    echo json_encode([
        "status"=>"success",
        "orders"=>[]
    ]);
}
?>