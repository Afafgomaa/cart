<?php
include 'src/Bill.php';



class createCart
{
    public function __construct($cartItems,$cuur){
       $bill =  new Bill(new Cart($cartItems,$cuur));
       $bill->printBill();
    }

}


echo "write your items and currency here: ";
$handle = fopen ("php://stdin","r");
$line = fgets($handle);

   if(in_array('createCart', $array = explode(' ',trim($line) )) ){
     $currency = explode('=',$array[1]);
     $items    = $array;
    // print_r($array);
    new createCart(array_splice($items,2,count($items)),$currency[1]);
    exit;
   }
    





// // $items = ['T-shirt', 'T-shirt', 'shoes','Jacket'];
// $items = ['T-shirt', 'T-shirt', 'shoes','Jacket', 'Jacket','Jacket','T-shirt','T-shirt','T-shirt' ,'T-shirt'];
// new Client($items,'USD');

