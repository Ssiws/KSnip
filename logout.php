<?php 
    require 'class/class.session.php'; Session::init();

    Session::logout();
    header('Location: login.php');
?>