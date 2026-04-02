<?php

require_once __DIR__ . '/stripe-php-17.2.1/init.php';

session_start();

$stripe_secret_key = "sk_test_51RSfVJ2fV9yG3IdHiFXw9brD1GP2gXYA8dvAdjmP6BZBJ5kmPq4VmLlPtPscmvfG1iCaM2bjVLrRWPp04OPTqsPI00Y2goQpsy";

\Stripe\Stripe::setApiKey($stripe_secret_key);

try{

    $checkout_session = \stripe\checkout\Session::create([
        "mode" => "payment",
        "success_url" => "http://151.80.57.110/CarMate/validation_paiement.php",
        "cancel_url" => "http://151.80.57.110/CarMate/echec_paiement.php",
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "eur",
                    "unit_amount" => $_SESSION['total']*100,
                    "product_data" => [
                        "name" => "Produits du Garage CarMate"
                    ]
                ]
            ]
        ]
    ]);

    http_response_code(303);
    header("location:" . $checkout_session->url);
    exit();

} catch(\Stripe\Exception\ApiErrorException $e){

    header("location:https://carmate.site//CarMate/echec_paiement.php");
    exit();
}