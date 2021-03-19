<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Page de modération</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/ajout_film.css">
</head>
<body>
  <?php
    include("connexion.php");
    include("navbar.php");
    include("verifyAccess.php");
  ?>

  <div class="container mx-auto col-lg-6 col-12">
    <h3 class="t3 text-uppercase text-center">Page de modération</h3><hr><br/><br/>
    <ul style="list-style-type:circle;">
      <li><a href="./modifyUser.php">Gérer les utilisateurs</a></li>
      <li><a href="./stat.php">Page de statistiques</a></li>
      <li><a href="./gestion_films.php">Gestion des films et des séries</a></li>
    </ul>
    <div class="shadow div1">
      <h6 class="t3 text-uppercase">Gestion des acteurs</h6>
      <ul style="list-style-type:circle;">
          <li><a href="./add_acteur.php">Ajouter un nouvel acteur</a></li>
          <li><a href="./update_acteur.php">Modifier un acteur</a></li>
          <li><a href="./delete_acteur.php">Supprimer un acteur</a></li>
      </ul>
    </div>
  </div>
</body>
</html>