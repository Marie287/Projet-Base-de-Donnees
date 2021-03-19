<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>
    <?php
      if(isset($_POST["id_update"])) echo "Modifier un film";
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
        if(isset($_POST["id_update"])) $id_film_ajout = $_POST["id_update"];

        // Si c'est un ajout,  création d'un nouvel id
        else{
          $req1 = "select max(id) from film;";
          $res_req1=pg_query($connect,$req1);
          $id_dernier_film= pg_fetch_array($res_req1)[0];
          $id_film_ajout =  $id_dernier_film + 1;
        }


        // ----------------- DELETE -----------------
        if(isset($_GET["t"]) && $_GET["t"]=="s"){
          $suppression = pg_query_params($connect,'delete from film where id = $1;',array($_GET["id"])); 
          if (!$suppression) $erreurs = $erreurs . "<h3 class='t3 text-uppercase'>Erreur</h3><br/><br/><br/><p>Erreur lors de la suppression du film.</p>";
        }
        // -----------------------------------------
        else{
          if(isset($_POST["f_titre"]) && !empty($_POST["f_titre"]) && isset($_POST["f_categorie"]) && !empty($_POST["f_categorie"])){ // Uniquement titre et catégories obligatoires
        
            $titre_modifie = str_replace("'", "''", $_POST["f_titre"]); // Remplacer ' par ''   pour permettre insertion apostrophe dans string SQ
            // ----------------- UPDATE -----------------
            if(isset($_POST["id_update"])){
              $insertion_titre="update film set titre='".$titre_modifie."' where id =".$id_film_ajout.";";
              $insertion_categ="update film set categorie=".$_POST["f_categorie"]." where id =".$id_film_ajout.";";
              $res_titre=pg_query($connect,$insertion_titre);
              $res_categ=pg_query($connect,$insertion_categ);
              if (!$res_titre || !$res_categ) $erreurs = $erreurs . "<p>Erreur lors de l'ajout du film</p>"
              //Si c'est un épisode
              if(isset($_POST["id_serie"]) && !empty($_POST["id_serie"])){
                // Récupération de son numéro d'épisode actuel
                $son_num = "select numero from episode where film=".$id_film_ajout.";";
                $son_num2=pg_query($connect,$son_num);
                $son_num3=pg_fetch_array($son_num2)
                // Vérifier si le numéro d'épisode existe déjà ou non (autre que son numéro actuel)
                $test_num_ep="select exists(select * from episode where serie=".$_POST["id_serie"]." and numero=".$_POST["f_numero"]." and numero !=".$son_num3[0].");";
                $res_test_num_ep=pg_query($connect,$test_num_ep);
                $res_test_num_ep2=pg_fetch_array($res_test_num_ep);
                if($res_test_num_ep2[0] == "t") $erreurs = $erreurs . "<p>Ce numéro d'épisode existe déjà pour cette série</p>";
                else{
                  $sql1="update episode set serie=".$_POST["id_serie"]." where film=".$id_film_ajout.";";
                  $sql2="update episode set numero=".$_POST["f_numero"]."where film=".$id_film_ajout.";";
                  $res1=pg_query($connect,$sql1);
                  $res2=pg_query($connect,$sql2);
                  if (!$res1 || !$res2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de l'épisode de série</p>";
                }
              }
            }
            // -----------------------------------------
    
            // ----------------- ADD -----------------
            else{
              //Si c'est un épisode
              if(isset($_POST["id_serie"]) && !empty($_POST["id_serie"])){
                // Vérifier si le numéro d'épisode existe déjà ou non
                $test_num_ep="select exists(select * from episode WHERE serie=".$_POST["id_serie"]." and numero=".$_POST["f_numero"].");";
                $res_test_num_ep=pg_query($connect,$test_num_ep);
                $res_test_num_ep2=pg_fetch_array($res_test_num_ep);
                if($res_test_num_ep2[0] == "t") $erreurs = $erreurs . "<p>Ce numéro d'épisode existe déjà pour cette série</p>";
                else{
                  $insertion_film="insert into film(id,titre,categorie) values(".$id_film_ajout.",'".$titre_modifie."',".$_POST["f_categorie"].");";
                  $res1=pg_query($connect,$insertion_film);
                  if (!$res1) $erreurs = $erreurs . "<p>Erreur lors de l'ajout du film</p>";
                  $insertion_episode="insert into episode values(".$_POST["id_serie"].",".$id_film_ajout.",".$_POST["f_numero"].");";
                  $res2=pg_query($connect,$insertion_episode);
                  if (!$res2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de l'épisode de série</p>";
                }
              }else{
                $insertion_film="insert into film(id,titre,categorie) values(".$id_film_ajout.",'".$titre_modifie."',".$_POST["f_categorie"].");";
                $res1=pg_query($connect,$insertion_film);
                if (!$res1) $erreurs = $erreurs . "<p>Erreur lors de l'ajout du film</p>";
              }
            }
            // -----------------------------------------
    
            // Gestion des champs non obligatoires :
            if(!empty($_POST["f_date_sortie"])){ // Si une date de sortie est renseignée
                $insertion_film_date="update film set date_sortie='".$_POST["f_date_sortie"]."' where id=".$id_film_ajout.";";
                $res2=pg_query($connect,$insertion_film_date);
                if (!$res2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la date de sortie du film</p>";
            }
            if(!empty($_POST["f_resume"])){ // Si le champ résumé est non vide
                $resume_modifie = str_replace("'", "''", $_POST["f_resume"]); // Remplacer ' par ''   pour permettre insertion apostrophe dans string SQL
                $insertion_film_resume="update film set resume='".$resume_modifie."' where id=".$id_film_ajout.";";
                $res3=pg_query($connect,$insertion_film_resume);
                if (!$res3) $erreurs = $erreurs . "<p>Erreur lors de l'ajout du résumé du film</p>";
            }
            if(!empty($_POST["f_duree"])){ // Si une durée a été précisée
                $insertion_film_duree="update film set duree='".$_POST["f_duree"]."' where id=".$id_film_ajout.";";
                $res4=pg_query($connect,$insertion_film_duree);
                if (!$res4) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la durée du film</p>";
             }
          }
                
                
                
          // ------------------ Insertion des bandes-annonce et vidéos du film ------------------
          $req2="select id from format;"; // Récupération de tous les id de format
          $liste_id_format=pg_query($connect,$req2);
          if (!$liste_id_format){
            $erreurs = $erreurs . "<p>Erreur lors de la requête de récupération des formats vidéo</p>";
            exit;
          }
          else{
            // Parcourir tous les formats et vérifier si un champ avec ce format a été rempli ou non
            $ligne=pg_fetch_array($liste_id_format);
            while ($ligne){ // Si oui faire l'insertion
              $format_video = $ligne["id"];
              
              // Si c'est une Bande-annonce
              if(isset($_POST["f_format_ba_".$ligne["id"]]) && !empty($_POST["f_format_ba_".$format_video])){
                // Si il faut modifier
                if(isset($_POST["id_update"])){
                  // Vérification si une bande annonce existe déjà dans ce format
                  $verification_ba = "select * from video where format=".$format_video." and film=". $id_film_ajout." and type='ba';";
                  $verification_ba2=pg_query($connect,$verification_ba);
                  if (!$verification_ba2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la bande-annonce du film</p>";
                  $verification_ba3 = pg_fetch_array($verification_ba2);
                  if(empty($verification_ba3)){
                    $insertion_ba="insert into video values(DEFAULT,'".$_POST["f_format_ba_".$format_video]."','ba',". $id_film_ajout.",".$format_video.");";
                    $res_ba=pg_query($connect,$insertion_ba);
                    if (!$res_ba) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la bande-annonce du film</p>";
                  }
                  else{
                    $update_ba="update video set url='".$_POST["f_format_ba_".$format_video]."' where film=". $id_film_ajout." and format=".$format_video." and type='ba';";
                    $update_ba2=pg_query($connect,$update_ba);
                    if (!$update_ba2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la bande-annonce du film</p>";
                  }
                    
                }else{
                  $insertion_ba="insert into video values(DEFAULT,'".$_POST["f_format_ba_".$format_video]."','ba',". $id_film_ajout.",".$format_video.");";
                  $res_ba=pg_query($connect,$insertion_ba);
                  if (!$res_ba) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la bande-annonce du film</p>";
                }
              }
                
                
              // Si c'est la vidéo d'un film
              if(isset($_POST["f_format_v_".$ligne["id"]]) && !empty($_POST["f_format_v_".$format_video])){
                $format_video = $ligne["id"];
                // Vérification si une bande annonce existe déjà dans ce format
                $verification_film = "select * from video where format=".$format_video." and film=". $id_film_ajout." and type='film';";
                $verification_film2=pg_query($connect,$verification_film);
                if (!$verification_film2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la vidéo du film</p>";
                $verification_film3 = pg_fetch_array($verification_film2);
                if(empty($verification_film3)){
                  $insertion_film="insert into video values(DEFAULT,'".$_POST["f_format_v_".$format_video]."','film',". $id_film_ajout.",".$format_video.");";
                  $res_film=pg_query($connect,$insertion_film);
                  if (!$res_film) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la vidéo du film</p>";
                }
                else{
                  $update_film="update video set url='".$_POST["f_format_v_".$format_video]."' where film=". $id_film_ajout." and format=".$format_video." and type='film';";
                  $update_film2=pg_query($connect,$update_film);
                  if (!$update_film2) $erreurs = $erreurs . "<p>Erreur lors de l'ajout de la vidéo du film</p>";
                }
              }
              $ligne=pg_fetch_array($liste_id_format); // Passage au format suivant
            }
          }           
                
                
          // ------------------ Insertion des acteurs dans la table Role ------------------ 
          $test = json_decode($_POST["tab_acteurs"]);
          if(!empty($test)) {
            foreach ($test as $value) {
              $id_acteur = $value->{'id'};
              $role = $value->{'role'};
              $insertion_role="insert into role values(".$id_acteur.",".$id_film_ajout.",'". $role."');";
              $res_insertion_role=pg_query($connect,$insertion_role);
              if (!$res_insertion_role) $erreurs = $erreurs . "<p>Erreur dans l'attribution des rôles</p>";
                
            }
          }
        }
            
            
            
        // ------------------ Affichage Erreur ou Succès de l'ajout ------------------
        if($erreurs != ""){
          echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
          echo $erreurs;
        }
        else{
          if(isset($_POST["id_update"])){
            if(isset($_POST["id_serie"]) && !empty($_POST["id_serie"])) echo '<h3 class="t3 text-uppercase">Episode modifié !</h3><br/><br/><br/> <p>Votre épisode a été modifié avec succès ! </p>';
            else echo '<h3 class="t3 text-uppercase">Film modifié !</h3><br/><br/><br/> <p>Votre film a été modifié avec succès ! </p>';
          }
          else if(isset($_GET["t"]) && $_GET["t"]=="s") echo "<h3 class='t3 text-uppercase'>Film supprimé !</h3><br/><br/><br/><p>Ce film a été supprimé avec succès ! </p>";
          else{
            if(isset($_POST["id_serie"]) && !empty($_POST["id_serie"])) echo '<h3 class="t3 text-uppercase">Episode ajouté !</h3><br/><br/><br/> <p>Votre épisode a été ajouté avec succès ! </p>';
            else echo '<h3 class="t3 text-uppercase">Film ajouté !</h3><br/><br/><br/> <p>Votre film a été ajouté avec succès ! </p>';
          }
        }
      ?>

      <br/><br/><br/>
      </div>
</body>
</html>
