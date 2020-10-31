<?php
// namespace UnitTestFiles\Test;

use PHPUnit\Framework\TestCase;

include './src/Bill.php';



class BillTest extends TestCase
{

    function setUp() {
        $items = ['T-shirt', 'T-shirt', 'shoes','Jacket'];
        $this->cart = new Cart($items,'USD');
        $this->bill = new Bill($this->cart);
        $this->offer= new Offers($this->cart);
    }
    
public function testcalculateSubTotal()
{

    $this->assertEquals($this->bill->calculateSubTotal(), 66.96);
}

public function testcalculateTaxes(){

    $this->assertEquals($this->bill->calculateTaxes(), 9.37);

  }

 public function testtotal()
 {
    $this->assertEquals($this->bill->total(),63.836);

 }


}