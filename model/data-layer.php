<?php

/* diner/model/data-layer.php
 * Returns the data for the diner app
 */

// Get the meals for the order form
function getMeals(){
    return array("breakfast", "brunch", "lunch", "dinner");
}

function getConds(){
    return array("ketchup", "mayo", "mustard", "sriracha", "kimchi");
}