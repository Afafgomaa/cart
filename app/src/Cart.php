<?php


class Cart
{
    public $items = [];
    public $currency;
    public $productCount = [];
/*
handel cart item to match our stock
transform item name to frist string uppercase
calaculat items count in cart
@param items []
@param currency string
@return void


*/
    public function __construct($items,$currency){
        $this->items     = $items;
        $this->currency = strtoupper($currency);

     $this->transformItemNameToUpper();
     $this->countProductInCart();

    }

    private function transformItemNameToUpper()
    {
        $this->items =  array_map(function($item){
           return ucfirst($item);
           },$this->items);
    }

    private function countProductInCart()
    {
        $this->productCount = array_count_values($this->items);
    }
    

    
}
