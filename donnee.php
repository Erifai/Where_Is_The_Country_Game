<?php
include_once('../jeuBase.php');
  $connection = mysqli_connect("localhost","root", "","espace_membre");
  $id_pays = (isset($_GET['id_pays']) ? intval($_GET['id_pays']) : 1);
  $query = "SELECT * FROM pays WHERE id_pays>='$id_pays' limit 1 ";
  $result = mysqli_query($connection, $query); ?>
     