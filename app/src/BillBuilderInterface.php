<?php


interface BillBuilderInterface
{
    public function calculateSubTotal();
    public function calculateTaxes();
    public function calculateDiscounts();
    public function currency();
    public function printBill();

}