<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>