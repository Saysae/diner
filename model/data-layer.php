<?php

/* diner/model/data-layer.php
 * Returns the data for the diner app
 */

class DataLayer
{
    //static methods do not access instance data (fields)
    // Get the meals for the order form
    static function getMeals(){
        return array("breakfast", "brunch", "lunch", "dinner");
    }

    static function getConds(){
        return array("ketchup", "mayo", "mustard", "sriracha", "kimchi");
    }
}