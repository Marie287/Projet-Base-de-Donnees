<?php 
  if(isset($_SESSION["session"])) {
    $login = $_SESSION["session"];
    $cmd = "Select role from utilisateur where login='$login';";
    if($result = pg_query($connect, $cmd)) {
      $ligne = pg_fetch_array ( $result );
      $role = $ligne["role"];
      if($role != "moderateur") { ?>
        <script>
          window.location.replace("../forbidden.html");
        </script>
      <?php }
    }
  } else { ?>
    <script>
      window.location.replace("../connexion.html?c=1");
    </script>
  <?php }
?>