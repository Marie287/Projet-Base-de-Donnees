<?php
  function connect(){
    $con=pg_connect("host=serveur-etu.polytech-lille.fr user=mbruggem port=5432 password=postgres dbname=mbruggemprojetbd");
    return $con;
  }
  $connect=connect();
  if (!$connect) {
    echo "Erreur de connexion" ;
    exit ;
  }
?>