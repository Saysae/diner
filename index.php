<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start a session
session_start();

//Require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once ('model/validation.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    //echo "Diner project";

    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a breakfast route
$f3->route('GET /breakfast', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define a lunch route
$f3->route('GET /lunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/lunch.html');
});

//Define a lunch route
$f3->route('GET /breakfast/brunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define an order route
$f3->route('GET|POST /order', function($f3) {
    //echo "Order page";
    var_dump ($_POST);

    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Get the food from the post array
        $food = $_POST['food'];
        //If data is valid
        if(validFood($food)){
            //Move orderForm1 data from POST to SESSION
            //Store it in the session array
            $_SESSION['food'] = $food;

            //redirect to order2 route
            header('location: order2');
        } else{ //data is not valid -> store an error message
            $f3->set('errors["food"]', 'Please enter a food with at least 2 characters');
        }

        $_SESSION['meal'] = $_POST['meal'];

    }


    $f3->set('meals', getMeals());

    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

//Define an order2 route
$f3->route('GET|POST /order2', function($f3) {
    //echo "Order page";


    //add data to the hive
    $f3->set('conds', getConds());

    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

//Define a summary route
$f3->route('GET|POST /summary', function() {
    var_dump($_POST);
    if(empty($_POST['conds'])){
        $conds = "none selected";
    } else {
        $conds = implode(", ", $_POST['conds']);
    }
    $_SESSION['conds'] = $conds;

    $view = new Template();
    echo $view->render('views/summary.html');
});

//Define a summary route -> orderSummary.html

//Run fat-free
$f3->run();