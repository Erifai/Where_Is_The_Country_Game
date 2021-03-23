<?php
include_once('../jeuBase.php');
  $connection = mysqli_connect("localhost","root", "","espace_membre");
  $id_pays = (isset($_GET['id_pays']) ? intval($_GET['id_pays']) : 172);
  $query = "SELECT * FROM mespays WHERE  Nom_continent='Europe' AND id_pays>='$id_pays' order by rand() limit 1 ";
  $result = mysqli_query($connection, $query); ?>
     