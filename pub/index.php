<?php

require_once('./../scr/config.php');

use Steampixel\Route;

Route::add('/', function() {
    echo "strona główna";
});
Route::run('/AGHP4/projekt/pub');

?>