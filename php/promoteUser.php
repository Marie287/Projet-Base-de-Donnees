<?php
  include("connexion.php");
  if(isset($_GET["id"])) {
    $id=$_GET["id"];
  }
  $cmd = "Update utilisateur set role='moderateur' where id=$id;";
  $result = pg_query($connect, $cmd);
  if(!$result) {
    echo "Erreur SQL" ;
    exit ; ?>
    <script>
      window.location.replace("./modifyUser.php?v=2");
    </script>
  <?php
  } else { ?>
    <script>
      window.location.replace("./modifyUser.php?v=3");
    </script>
  <?php } ?>