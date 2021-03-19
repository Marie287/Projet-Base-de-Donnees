<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Supprimer un acteur</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/ajout_film.css">
</head>
<body>
	<?php
    include("connexion.php");
    include("navbar.php");
  ?>

  <div class="container mx-auto col-lg-6 col-12">
    <?php include("verifyAccess.php"); ?>
    <br/><a href="./page_moderation.php">Retour</a><br/><br/>
    <div class="block_div shadow">
      <h3 class="t3 text-uppercase text-center">Supprimer un acteur</h3>
      <br/><br/>

      <form id="update_acteur" action="./gestion_acteur_req.php" method=POST>
        <table class="table">
          <tr>
          <th></th>
          <th>Prénom</th>
          <th>Nom</th>
          <th>Date de naissance</th>
        </tr>
        <?php             
          $sql="select * from acteur;";
          $resultat=pg_query($connect,$sql);
          if (!$resultat){ echo "Probleme lors du lancement de la requête"; exit; }
          $ligne=pg_fetch_array($resultat);

          while ($ligne){
            echo "<tr>";
            echo "<td><input type='radio' name='d_acteur_id' value='".$ligne["id"]."' /></td>";
            echo "<td>".$ligne["prenom"]."</td>";
            echo "<td>".$ligne["nom"]."</td>";
            echo "<td>".$ligne["date_naissance"]."</td>";
            echo "</tr>";
            $ligne=pg_fetch_array($resultat);
          }
        ?>
        </table>
        <br/><br/>
        <div class="text-center">
          <input type="hidden" name="action" value="delete">
          <button type="submit" class="btn btn-danger col-6">Supprimer cet acteur</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>