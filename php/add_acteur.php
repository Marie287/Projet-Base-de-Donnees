<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Ajouter un acteur</title>
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
    <br/><a href="./page_moderation.php">Retour</a><br/><br/>
      
    <div class="block_div shadow">
      <h3 class="t3 text-uppercase text-center">Ajouter un nouvel acteur</h3>
      <br/><br/><br/>
      <form action="./gestion_acteur_req.php" method=POST>
        <div class="row">
          <div class="form-group col-sm-6 col-12">
            <label for="a_prenom" class="col-form-label">Prénom :</label>
            <input type="text" class="form-control" name="a_prenom" placeholder="ex : Clint" required>
          </div>
        <div class="form-group col-sm-6 col-12">
            <label for="a_nom" class="col-form-label">Nom :</label>
            <input type="text" class="form-control" name="a_nom" placeholder="ex : Eastwood" required>
          </div>
        </div>
        <br/>
          
        <div class="form-group row">
          <label for="a_date_naissance" class="col-form-label col-lg-3 col-12">Date de naissance :</label>
          <div class="col-lg-9 col-12">
            <input type="date" class="form-control" name="a_date_naissance">
          </div>
        </div>
        <br/><br/>
          
        <div class="text-center">
          <input type="hidden" name="action" value="add">
          <button type="submit" class="btn btn-success col-6">Enregistrer</button>
        </div>
          
      </form>
    </div>
  </div>
</body>
</html>