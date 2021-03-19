<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>
    <?php
      if($_POST["action"] == "update") echo "Modifier une série";
      else echo "Ajouter un film";
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
  
  <?php            
    $erreurs = "";
    // Si l'action est la modification d'un film = récupération de l'id
    if($_POST["action"] == "update") $id_serie_ajout = $_POST["id_update"];
    // Si c'est un ajout,  création d'un nouvel id
    else{
      $req1 = "select max(id) from serie;";
      $res_req1=pg_query($connect,$req1);
      $id_derniere_serie= pg_fetch_array($res_req1)[0];
      $id_serie_ajout =  $id_derniere_serie + 1;
    }
            
             
    if(isset($_POST["s_titre"]) && !empty($_POST["s_titre"])){ // Uniquement titre obligatoire
      $titre_modifie = str_replace("'", "''", $_POST["s_titre"]); // Remplacer ' par ''   pour permettre insertion apostrophe dans string SQL
      switch($_POST["action"]) {
        // ------------------ MODIFICATION ------------------
        case 'update': 
          $insertion_titre="update serie set titre='".$titre_modifie."' where id =".$id_serie_ajout.";";
          $res_titre=pg_query($connect,$insertion_titre);
          if (!$res_titre) $erreurs = $erreurs . "<p>Erreur lors de la modification de la série</p>";
          break;
        case "add":
          // ------------------ INSERTION ------------------
          $insertion_serie="insert into serie(id,titre) values(".$id_serie_ajout.",'".$titre_modifie."');";
          $res1=pg_query($connect,$insertion_serie);
          if (!$res1) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la série</p>";
          break;
      }
      // Gestion des champs non obligatoires :
      if(isset($_POST["s_date_sortie"]) && !empty($_POST["s_date_sortie"])){ // Si une date de sortie est renseignée
        $insertion_serie_date="update serie set date_sortie='".$_POST["s_date_sortie"]."' where id=".$id_serie_ajout.";";
        $res2=pg_query($connect,$insertion_serie_date);
        if (!$res2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la date de sortie de la série</p>";
      }
      if(isset($_POST["s_resume"]) && !empty($_POST["s_resume"])){ // Si le champ résumé est non vide
        $resume_modifie = str_replace("'", "''", $_POST["s_resume"]); // Remplacer ' par ''   pour permettre insertion apostrophe dans string SQL
        $insertion_film_resume="update serie set resume='".$resume_modifie."' where id=".$id_serie_ajout.";";
        $res3=pg_query($connect,$insertion_film_resume);
        if (!$res3) $erreurs = $erreurs . "<p>Erreur lors de l'ajout du résumé de la série</p>";
      }
    }



    // ------------------ Affichage Erreur ou Succès ------------------
    if($erreurs != ""){
      echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
      echo $erreurs;
    }
    else{
      switch($_POST["action"]) {
        case 'update':
          echo '<h3 class="t3 text-uppercase">Série modifiée !</h3><br/><br/><br/>';
          echo '<p>Votre série a été modifiéé avec succès ! </p>';
          break;
        case 'add':
          echo '<h3 class="t3 text-uppercase">Série ajoutée !</h3><br/><br/><br/>';
          echo '<p>Votre série a été ajoutéé avec succès ! </p>';
          break;
      }
    }
  ?>

  <br/><br/><br/>
  </div>
</body>
</html>