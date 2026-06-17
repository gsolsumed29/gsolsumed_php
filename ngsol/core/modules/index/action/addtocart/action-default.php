<?php
session_start(); //start session

############# add products to session #########################
if(isset($_POST["product_code"]))
{
    foreach($_POST as $key => $value){
        $new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING); //create a new product array 
    //$this->user="mosqueda_katana";$this->pass="@eGE)wf?KC@z";$this->host="localhost";$this->ddbb="mosqueda_katana";
    }
    
    $db_username        = 'root'; //MySql database username
    $db_password        = ''; //MySql dataabse password
    $db_name            = 'dev'; //MySql database name
    $db_host            = 'localhost'; //MySql hostname or IP

    
    $mysqli_conn = new mysqli($db_host, $db_username, $db_password,$db_name); //connect to MySql
    if ($mysqli_conn->connect_error) {//Output any connection error
        die('Error : ('. $mysqli_conn->connect_errno .') '. $mysqli_conn->connect_error);
    }

   $numero = $new_product['plan_num'];
   $total_items = 1;
    if(isset($_SESSION["products"])){
    $total_items = count($_SESSION["products"]);
    }
    if($total_items == $numero){
        die(json_encode(array('items'=>$total_items,'numero'=>$numero))); //output json 
       // die(json_encode(array('respuesta'=>'e'))); //output json 
    }else{
    $statement = $mysqli_conn->prepare("SELECT nombrePlato,id FROM plato WHERE id=? LIMIT 1");
    $statement->bind_param('s', $new_product['product_code']);
    $statement->execute();
    $statement->bind_result($nombrePlato, $id); 
    
    while($statement->fetch()){ 
        $new_product["product_name"] = $nombrePlato; //fetch product name from database
        $new_product["product_codigo"] = $id;  //fetch product price from database
        $new_product["operacion"] = rand(1, 999);;  //fetch product price from database      
        $_SESSION["products"][$new_product['operacion']] = $new_product; //update products with new item array   
    }
    
    $total_items = count($_SESSION["products"]); //count total items

    die(json_encode(array('items'=>$total_items,'numero'=>$numero))); //output json 
    }
}

################## list products in cart ###################
if(isset($_POST["load_cart"]) && $_POST["load_cart"]==1)
{



    if(isset($_SESSION["products"]) && count($_SESSION["products"])>0){ //if we have session variable
     
  $cart_box ="";
        foreach($_SESSION["products"] as $product){ //loop though items and prepare html content
       
            //set variables to use them in HTML content below
            $product_name = $product["product_name"]; 
            $product_code = $product["product_codigo"];           
            $product_operacion = $product["operacion"];    
   

              $cart_box .= '<div class="col-md-12">';
              $cart_box .= '<div class="card card-outline card-success">';
                $cart_box .= '<div class="card-header">';
                  $cart_box .= '<h3 class="card-title">'.  $product_name .'</h3>';
                  $cart_box .= '<div class="card-tools">';
                    $cart_box .= '<button type="button" class="btn btn-tool" data-card-widget="collapse"><a href="#" class="remove-item" data-code='.$product_operacion.'><i class="fas fa-trash"></a></i>';
                    $cart_box .= '</button>';
                  $cart_box .= '</div>';          
                $cart_box .= '</div>';            
             
            
              $cart_box .= '</div>';
           
            $cart_box .= '</div>';


 
        }
      
        die($cart_box); //exit and output content
    }else{
        die(""); //we have empty cart
    }
}################## list products in cart ###################
if(isset($_POST["load_vacio"]))
{
    if(isset($_SESSION["products"])){ //if we have session variable
        unset($_SESSION["products"]);
        die(""); //we have empty cart
    }
}

################# remove item from shopping cart ################
if(isset($_GET["remove_code"]) && isset($_SESSION["products"]))
{
    $product_code   = filter_var($_GET["remove_code"], FILTER_SANITIZE_STRING); //get the product code to remove

    if(isset($_SESSION["products"][$product_code]))
    {
        unset($_SESSION["products"][$product_code]);
    }
    
    $total_items = count($_SESSION["products"]);
    die(json_encode(array('items'=>$total_items,'cantidad'=>'0')));
}

/*
$op = $_GET["op"];
$plan_id = $_GET["plan_id"];
$numeroPlatos = $_GET["numeroPlatos"];
if($numeroPlatos==0){
	$resta = 0;
	Core::redir("index.php?view=time&plan_id=$plan_id&pl=$resta&p=2&r=1&op=$op?");
}else{
if(!isset($_SESSION["cart"])){	
	$resta = $numeroPlatos -1 ;
	$_SESSION["cart"] = array( array("product_id"=>$_GET["product_id"],"q"=>$op ));
	$op = $op+1;

}else{	
	$resta = $numeroPlatos -1 ;
	$products = $_SESSION["cart"];
	$news = array();
	$newp = array("product_id"=>$_GET["product_id"],"q"=>$op);
	$op = $op+1;
	array_push($products, $newp);
	$_SESSION["cart"]=$products;
	
	
}
if($_GET["href"]=="time"){
	Core::redir("index.php?view=time&plan_id=$plan_id&pl=$resta&op=$op");
	}
}*/
?>