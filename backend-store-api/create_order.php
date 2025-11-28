<?php
//return json not html
header('Content-Type: application/json');
include 'db.php';
//read json input 
$data = json_decode(file_get_contents("php://input"), true);
//validate json 
if (!$data) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid JSON"
    ]);
    exit;
}
//extract values from json
$product_id= $data["product_id"]??"";
$quantity= $data["quantity"]??"";
$customer_name=$data["customer_name"]??"";
//validate required files
if($product_id === "" || $quantity === "" || $customer_name==="") {
    echo json_encode([
        "status" =>"error",
        "message"=>"product_id, quantity,and customer_name are required"
    ]);
    exit;
} 


//get product price
$query =$conn->prepare("SELECT * FROM products WHERE id =?");
$query->bind_param("i",$product_id);//bind the product id
$query->execute();
$result= $query->get_result();
//error if product doesnt exist
if($result->num_rows ==0) {
   echo json_encode([
        "status"=>"error",
        "message" => "Product not found"
    ]);
    exit;
}
//calculate total price
$product=$result->fetch_assoc();
$price=floatval($product["price"]);
$total=$price * $quantity;

//insert order into database
$query = $conn->prepare("INSERT INTO orders (product_id, quantity, customer_name, total_price)  VALUES (?, ?, ?, ?)");
$query->bind_param("iisd",$product_id,$quantity,$customer_name,$total);//bind values
//execute then return response
if($query->execute()){
    echo json_encode([
        "status"=>"success",
        "message" => "Order created",
        "order_id"=>$query->insert_id
    ]);
} else {
    echo json_encode([
         "status" =>"error",
         "message"=>"Failed to create order"
    ]);
}
?>