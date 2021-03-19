<?php
  include("connexion.php");
  if(isset($_GET["id"])) {
    $id=$_GET["id"];
  }
  $cmd = "Update utilisateur set abonne='non' where id=$id;";
  $result = pg_query($connect, $cmd);
  if(!$result) {
    echo "Erreur SQL" ;
    exit ; ?>
    <script>
            window.location.replace("./profil.php");
    </script>
  <?php
  } else { ?>
    <script>
            window.location.replace("./profil.php");
    </script>
  <?php }
?>
