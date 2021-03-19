<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Ajouter un film</title>
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
    
  <?php
    switch($_POST["action"]) {
      case 'add': 
        // ------------------ Insertion d'un acteur ------------------ 
        if(isset($_POST["a_nom"]) && !empty($_POST["a_nom"]) && isset($_POST["a_prenom"]) && !empty($_POST["a_prenom"]) && isset($_POST["a_date_naissance"]) && !empty($_POST["a_date_naissance"])){
               
        $insertion_acteur="insert into acteur values(DEFAULT,'".$_POST["a_nom"]."','".$_POST["a_prenom"]."','".$_POST["a_date_naissance"]."');";
        $res1=pg_query($connect,$insertion_acteur);
                
        if (!$res1){
          echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
          echo "<p>Erreur lors de l'ajout de l'acteur.</p>";
        }
        else{
          echo '<h3 class="t3 text-uppercase">Acteur ajouté !</h3><br/><br/><br/>';
          echo '<p>Cet acteur a été ajouté avec succès ! </p>';
        }
        }
        else{
          echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
          echo "<p>Données manquantes</p>";
        }
        break;
        
        
      // ------------------ Modification d'un acteur ------------------ 
      case 'update':
        if(isset($_POST["u_nom"]) && !empty($_POST["u_nom"]) && isset($_POST["u_prenom"]) && !empty($_POST["u_prenom"]) && isset($_POST["u_date_naissance"]) && !empty($_POST["u_date_naissance"]) && isset($_POST["id_acteur_value"]) && !empty($_POST["id_acteur_value"])){
          $modification = "update acteur set nom='".$_POST["u_nom"]."', prenom='".$_POST["u_prenom"]."', date_naissance='".$_POST["u_date_naissance"]."' where id=".$_POST["id_acteur_value"].";";
          $res2=pg_query($connect,$modification);
                              
          if (!$res2){
            echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
            echo "<p>Erreur lors de la modification de l'acteur.</p>";
          }
          else{
            echo '<h3 class="t3 text-uppercase">Acteur modifié !</h3><br/><br/><br/>';
            echo '<p>Cet acteur a été modifié avec succès ! </p>';
          }
        }
        else{
          echo '<h3 class="t3 text-uppercase">Erreur</h3><br/><br/><br/>';
          echo "<p>Données manquantes</p>";
        }    
        break;
                
        
        // ------------------ Suppression d'un acteur ------------------ 
        case 'delete':
          $suppression = pg_query_params($connect,'delete from acteur where id = $1;',array($_POST["d_acteur_id"])); 
                   
          if (!$suppression){
            echo "<h3 class='t3 text-uppercase'>Erreur lors de la suppression</h3><br/><br/><br/>";
            echo "<p>Erreur lors de la suppression de l'acteur.</p>";
          }else{
            echo '<h3 class="t3 text-uppercase">Acteur supprimé !</h3><br/><br/><br/>';
            echo '<p>Cet acteur a été supprimé avec succès ! </p>';
          }
                    
          break;
    }
  ?>

  <br/><br/><br/>
   
  <a href="../gestion_acteur.html">Retour à la page précédente</a>
  </div>
</body>
</html>
