<?php

include 'Cart.php';
include 'Offers.php';
include './DataSource.php';
include 'BillBuilderInterface.php';
class Bill implements BillBuilderInterface
{

    public $items = [];
    private $finalitemsCount;
    private $stock = [];
    private $currencies;
    private $default_currency = 'USD';
    private $postion_currency_left;
    private $postion_currency_right;
    private $currency;
    private $symbol;
    private $symbols;
    private $cart;
    
    
    public function __construct(cart $cart)
    {
        $this->stock    = include './DataSource.php';
        $this->currencies = include './dataSourecCurrencey.php';
        $this->symbols = include './symbolCurrency.php';
        $this->symbol = $cart->currency;
        $this->items    = $cart->items;
        $this->cart = $cart;
        $this->currency();
        $this->createCurrencySymbal();
        // return mateched items from stock and cart items
        $arrayMatched  = array_intersect(array_keys($this->stock),$this->items);
        $this->finalitemsCount  = array_combine(array_values($arrayMatched),array_values($cart->productCount));
    }

    public function printBill()
    {
     echo "Subtotal:$this->postion_currency_left ".$this->calculateSubTotal()  ." $this->postion_currency_right \n";
     echo "Taxes: $this->postion_currency_left " . $this->calculateTaxes() ." $this->postion_currency_right \n";
    if($this->calculateDiscounts()->IsThisCartHasOffer() == true){
        echo "Discounts: \n";
        if(in_array('Shoes', $this->items)){
            echo "10% off shoes:$this->postion_currency_left -". $this->calculateDiscounts()->shoesTenpercent() * $this->currency ." $this->postion_currency_right \n" ;
        }
       
        if(in_array('T-shirt', $this->items)  && in_array('Jacket',$this->items) && $this->cart->productCount['T-shirt'] >= 2)
           echo "50% off jacket:$this->postion_currency_left -".$this->calculateDiscounts()->twoTshirtsGetJacketHalf() * $this->currency ." $this->postion_currency_right \n";
    
        }
     echo "Total:$this->postion_currency_left " .$this->total() ." $this->postion_currency_right \n";
     $this->createCurrencySymbal();
    }

   
    public function calculateSubTotal(){
        $total = 0;
        foreach($this->finalitemsCount as $key => $value){
            $total += $this->stock[$key] * $value * $this->currency;
        }
    
        return $total;


    }
    public function calculateTaxes(){
      return  number_format($this->calculateSubTotal() * 14 / 100 , 2, '.', ',');

    }
    public function calculateDiscounts(){
       return new Offers($this->cart);

    }
    public function currency(){
     $this->currency  =  in_array($this->cart->currency,array_keys($this->currencies)) ? $this->currencies[$this->cart->currency] : $this->currencies[$this->default_currency];

    }

    public function total()
    {
      
      return  $this->calculateSubTotal() + $this->calculateTaxes() 
             - $this->totalDiscount();
    }

    public function createCurrencySymbal(){

        if($this->symbols[$this->symbol]['postion'] == 'left'){
            $this->postion_currency_left = $this->symbols[$this->symbol]['symbol'];
        }else{
            $this->postion_currency_right =  $this->symbols[$this->symbol]['symbol'];
        }
   

    }
    public function totalDiscount()
    {
      return  $this->calculateDiscounts()->shoesTenpercent() +
              $this->calculateDiscounts()->twoTshirtsGetJacketHalf() 
             * $this->currency;
    }
}