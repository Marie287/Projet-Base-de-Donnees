<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Ajouter un film</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/ajout_film.css">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="./liste.php">Accueil</a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="./profil.php">Mon profil</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mx-auto col-lg-6 col-12">
    <?php
      include("connexion.php");
      include("navbar.php");
      include("verifyAccess.php"); 
              
      if(isset($_GET["id"])) $id = $_GET["id"];
      else echo "Problème d'initialisation";
      
      $suppression = pg_query_params($connect,'delete from film where id = $1;',array($id)); 
                      
      if (!$suppression){
          echo "<h3 class='t3 text-uppercase'>Erreur</h3><br/><br/><br/>";
          echo "<p>Erreur lors de la suppression du film.</p>";
      }else{
          echo '<h3 class="t3 text-uppercase">Film supprimé !</h3><br/><br/><br/>';
          echo '<p>Ce film a été supprimé avec succès ! </p>';
      }
    ?>
    <br/><br/><br/>
    
    <a href="./gestion_films.php">Retour à la page précédente</a>
    </div>
</body>

</html>