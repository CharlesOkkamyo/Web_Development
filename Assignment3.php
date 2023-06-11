<?php

class EasyPay {
    private $balance;
    
    public function __construct($balance = 0) {
        $this->balance = $balance;
    }
    
    public function topUp($amount) {
        $this->balance += $amount;
        echo "Top-up successful. Current balance: " . $this->balance . PHP_EOL;
    }
    
    public function withdraw($amount) {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Withdrawal successful. Current balance: " . $this->balance . PHP_EOL;
        } else {
            echo "Insufficient balance." . PHP_EOL;
        }
    }
    
    public function transfer($amount, $recipient) {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            $recipient->balance += $amount;
            echo "Transfer successful. Current balance: " . $this->balance . PHP_EOL;
        } else {
            echo "Insufficient balance." . PHP_EOL;
        }
    }
    
    public function purchase($amount) {
        if ($amount <= $this->balance) {
            $this->balance -= $amount;
            echo "Purchase successful. Current balance: " . $this->balance . PHP_EOL;
        } else {
            echo "Insufficient balance." . PHP_EOL;
        }
    }
    
    public function getBalance() {
        return $this->balance;
    }
}

// Example usage:

// Create two EasyPay instances
$customer1 = new EasyPay(1000);
$customer2 = new EasyPay(500);

// Top-up
$customer1->topUp(500);

// Withdraw
$customer1->withdraw(200);

// Transfer
$customer1->transfer(300, $customer2);

// Purchase
$customer2->purchase(100);

// Get balance
echo "Customer 1 balance: " . $customer1->getBalance() . PHP_EOL;
echo "Customer 2 balance: " . $customer2->getBalance() . PHP_EOL;

?>
