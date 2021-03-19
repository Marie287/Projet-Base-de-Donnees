<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>
    <?php
      if(isset($_GET["id"])) echo "Modifier une série";
      else echo "Ajouter une série";
    ?>
  </title>
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
    <br/><a href="./gestion_films.php">Retour</a><br/><br/>
    <div class="block_div shadow">
      <h3 class="t3 text-uppercase text-center">
        <?php
          if(isset($_GET["id"])){
            echo 'Modifier une série';
            $sql_u="select * from serie where id = ".$_GET["id"].";";
            $res_u=pg_query($connect,$sql_u);
            if (!$res_u){
              echo "Probleme lors du lancement de la requête";
              exit;
            }
            else $serie_to_update=pg_fetch_array($res_u);
          }
          else echo 'Ajouter une nouvelle série';
        ?>
      </h3>
      <br/><br/><br/>
      <form action="./gestion_serie_req.php" method=POST>
        <div class="form-group row">
          <label for="s_titre" class="col-form-label col-lg-3 col-12">Titre :</label>
          <div class="col-lg-9 col-12">
            <input type="text" class="form-control" name="s_titre" placeholder="ex : Cars 3" 
            <?php if(isset($_GET["id"])) echo 'value="'.$serie_to_update["titre"].'"'; ?>
            required>
          </div>
        </div>
        <br/>
        <div class="form-group row">
          <label for="s_date_sortie" class="col-form-label col-lg-3 col-12">Date de sortie :</label>
          <div class="col-lg-9 col-12">
            <input type="date" class="form-control" name="s_date_sortie"
            <?php if(isset($_GET["id"]) && !empty($serie_to_update["date_sortie"])) echo 'value="'.$serie_to_update["date_sortie"].'"'; ?>
            >
          </div>
        </div>
        <br/>
        <div class="form-group row">
          <label for="s_resume" class="col-lg-3 col-12">Résumé :</label>
          <div class="col-lg-9 col-12">
            <textarea class="form-control" name="s_resume" rows="5" placeholder="Ecrivez le résumé du film ici..." 
            ><?php if(isset($_GET["id"]) && !empty($serie_to_update["resume"])) echo $serie_to_update["resume"] ?></textarea>
          </div>
        </div>
        <br/><br/>
          
        <div class="text-center">
          <input type="hidden" id="action" name="action" value="<?php if(isset($_GET["id"])) echo 'update'; else echo 'add';?>">
          <input type="hidden" id="id_update" name="id_update" value="<?php if(isset($_GET["id"])) echo $_GET["id"];?>">
          <button type="submit" class="btn btn-success col-6">Enregistrer</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>