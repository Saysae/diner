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
        //we are setting so we can save user data so data can be saved if they refresh or go back
        $f3->set('userFood', $food);
        //$meal = "";
/*        if(isset($_POST['meal'])){
            $meal = $_POST['meal'];
        }*/
        //short hand
        $meal = isset($_POST['meal']) ? $_POST['meal'] : "";

        //adding user selection to fat free hive
        $f3->set('userMeal', $meal);

        //If data is valid
        if(validFood($food)){
            //Move orderForm1 data from POST to SESSION
            //Store it in the session array
            $_SESSION['food'] = $food;
            //redirect to order2 route

        }else { //data is not valid -> store an error message
            $f3->set('errors["food"]', 'Please enter a food with at least 2 characters');
        }
        if(validMeal($meal)){
            //Store it in the session array
            $_SESSION['meal'] = $meal;
        }else {
            $f3->set('errors["meal"]', 'meal selection is invalid');
        }

        //redirect to order2 route if there are no errors
        if(empty($f3->get('errors'))){
            header('location: order2'); //header uses GET
        }

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