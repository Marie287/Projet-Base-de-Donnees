<?php
  include("connexion.php");
  if(isset($_POST["nom"])) {
    $nom=$_POST["nom"];
  } if(isset($_POST["prenom"])) {
    $prenom=$_POST["prenom"];
  } if(isset($_POST["email"])) {
    $email=$_POST["email"];
  } if(isset($_POST["login"])) {
    $login=$_POST["login"];
  } if(isset($_POST["mdp"])) {
    $mdp=$_POST["mdp"];
  }

  if($nom && $prenom && $email && $login && $mdp) {
    $cmdSQL = "Select * from utilisateur where mail='$email';";
    if(pg_num_rows(pg_query($connect, $cmdSQL)) == 0) {
      $cmdSQL = "Select * from utilisateur where login='$login'";
      if(pg_num_rows(pg_query($connect, $cmdSQL)) == 0) {
        $cmdSQL = "Insert into utilisateur values(default, '$nom', '$prenom', '$email', '$login', '$mdp', 'abonne', 'oui');";
        $result = pg_query($connect, $cmdSQL);
        if(!$result) {
          echo "Erreur SQL" ;
          exit ;
        } else { ?>
          <script>
            window.location.replace("../connexion.html?i=1&l=<?php echo $login; ?>");
          </script>
        <?php }
      } else { ?>
        <script>
          window.location.replace("../inscription.html?l=1&prenom=<?php echo $prenom ?>&nom=<?php echo $nom ?>&mail=<?php echo $email ?>&login=<?php echo $login ?>");
        </script>
      <?php
      }
    }
    else { ?>
      <script>
        window.location.replace("../inscription.html?e=1&prenom=<?php echo $prenom ?>&nom=<?php echo $nom ?>&mail=<?php echo $email ?>&login=<?php echo $login ?>");
      </script>
      <?php
    }
  } else {
    echo "Paramètre non renseigné.";
  }
?>