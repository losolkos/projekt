<?php
require_once('./../vendor/autoload.php');
$db = new mysqli("localhost", "root", "", "pub");
require("Post.class.php");
$loader = new Twig\Loader\FilesystemLoader('./../scr/templates');

$twig = new Twig\Environment($loader);

?>