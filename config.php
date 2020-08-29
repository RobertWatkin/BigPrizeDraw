<?php
// Product Information
$productName = "test";
$productID = "TST1234";
$productPrice = 10;
$currency = "gbp";

// Convert product price to cent
$stripeAmount = round($productPrice*100, 2);

// Stripe API config
define('STRIPE_API_KEY', 'sk_test_51HIxCQCG8x48gIUwWGuzT8sFl8fe9fq8JeMEJYQGNANeMcEJEtMP1eWemwH92R9uechhaIr2VxPv2heZWzJ5PZUv00OauHqADC');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51HIxCQCG8x48gIUwJZsj53L1hp3f2G9M5rc7Vu9XKLcUqIpkGfJRBeYol1qPYlvjzI2zON0lqKZZtV7haPMJQSCb00saTDo6Z9');
define('STRIPE_SUCCESS_URL', 'index.php');
define('STRIPE_CANCEL_URL', 'checkout.php');