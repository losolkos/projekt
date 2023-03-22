<?php

require_once('./../scr/config.php');
session_start();
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
        Post::upload($_FILES['uploadedFile']['tmp_name'], $_POST['title'], $_POST['userid']);
    }
    header("Location: http://localhost/AGHP4/projekt/pub");
}, 'post');

Route::add('/register', function(){
    global $twig;
    $twigData = array("pageTitle" => "Zarejestruj użytkownika");
    $twig->display("register.html.twig", $twigData);
    });
    
    Route::add('/register', function(){
        global $twig;
        if(isset($_POST['submit'])){
            User::register($_POST['emeil'], $_POST['password']);
            header("Location: http://localhost/AGHP4/projekt/pub");
        }
    }, 'post');

    Route::add('/login', function(){
        global $twig;
        $twigData = array("pageTitle" => "Zaloguj użytkownika");
        $twig->display("login.html.twig", $twigData);

    });
    Route::add('/login', function() {
        global $twig;
        if(isset($_POST['submit'])) {
            User::login($_POST['emeil'], $_POST['password']);
        }
        header("Location: http://localhost/AGHP4/projekt/pub");
    
    }, 'post');
Route::run('/AGHP4/projekt/pub');

?>