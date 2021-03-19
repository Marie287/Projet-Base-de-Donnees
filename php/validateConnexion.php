<?php
  include("connexion.php");
  if(isset($_POST["login"])) {
    $login=$_POST["login"];
  } if(isset($_POST["mdp"])) {
    $mdp=$_POST["mdp"];
  }
  if($login && $mdp) {
    $cmdSQL = "Select * from utilisateur where login='$login' and mdp='$mdp';";
    if(pg_num_rows(pg_query($connect, $cmdSQL)) == 1) {
      session_start();
      $_SESSION["session"]=$login; ?>
      <script>
        window.location.replace("./liste.php");
      </script>
      <?php 
    } else { ?>
      <script>
        window.location.replace("../connexion.html?e=1");
      </script>
      <?php }
  } else {
    echo "Paramètre non renseigné.";
  }
?>