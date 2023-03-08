<?php

require_once('./../scr/config.php');

use Steampixel\Route;

Route::add('/', function() {
    global $twig;
    $postArray = Post::getPage();
    $twigData = array("postArray" => $postArray, 
    "pageTitle" => "strona główna"); 
    $twig->display("index.html.twig",$twigData);
});
Route::add('/upload', function() {
    global $twig;
    $postArray = Post::getPage();
    $twigData = array("postArray" => $postArray, 
    "pageTitle" => "strona główna"); 
    $twig->display("upload.html.twig");
});

Route::add('/upload', function(){
    global $twig;
    if(isset($_POST['submit']))  {
        Post::upload($_FILES['uploadedFile']['tmp_name']);
    }
    header("Location: http://localhost/AGHP4/projekt/pub");
}, 'post');
Route::run('/AGHP4/projekt/pub');

?>