<?php
declare(strict_types=1);
include 'OffersInterface.php';


class Offers implements OffersInterface
{
    private $prices; 
    private $cart;
/*
assign param
@param Cart $cart

*/
    public function __construct(Cart $cart)
    {
        $this->prices = include './DataSource.php';
        $this->cart = $cart;

    }

/*
calaculat 10% offers on shoes
@return string 

*/
    public function shoesTenpercent(){
       $offerPrice =  $this->prices['Shoes'] * 10 / 100;
       return $offerPrice;
    }

/*
calaculat t-shirt offers
@param items []
@param $item_count []
@return string

*/
    public function twoTshirtsGetJacketHalf()
    {
        if(in_array('T-shirt', $this->cart->items)  && in_array('Jacket',$this->cart->items) && $this->cart->productCount['T-shirt'] >= 2){

            $offerPrice = 0;
            if( $this->cart->productCount['T-shirt'] / $this->cart->productCount['Jacket'] >= 2 ){
             $offerPrice =   $this->prices['Jacket'] * $this->cart->productCount['Jacket'] /2;
            }elseif(intval($this->cart->productCount['T-shirt'] / $this->cart->productCount['Jacket']) == 1 ){
             $offerPrice =  ($this->cart->productCount['Jacket']-1) * $this->prices['Jacket'] /2;
            }
     
             return $offerPrice;
            }
        
    }
/*
determind if this cart has offer
@return bool
*/

    public function IsThisCartHasOffer():bool
    {
        if(in_array('Shoes', $this->cart->items) ||
         in_array('T-shirt', $this->cart->items) &&
         $this->cart->productCount['T-shirt'] >= 2 ){
            return true;
         }
         return false;
    }


}