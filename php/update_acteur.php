<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Modifier un acteur</title>
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
      <h3 class="t3 text-uppercase text-center">Modifier un acteur</h3>
      <br/><br/>
      <form id="update_acteur" action="./gestion_acteur_req.php" method=POST>
        <div id="table_update_acteur">
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
                echo "<td><input type='radio' id='u_acteur_id' name='u_acteur_id' value='".$ligne["id"]."' /></td>";
                echo "<td id='prenom".$ligne["id"]."'>".$ligne["prenom"]."</td>";
                echo "<td id='nom".$ligne["id"]."'>".$ligne["nom"]."</td>";
                echo "<td id='date_naissance".$ligne["id"]."'>".$ligne["date_naissance"]."</td>";
                echo "</tr>";
                $ligne=pg_fetch_array($resultat);
              }
            ?>
          </table>
          <div class="text-center">
            <button id="button_table_update" type="button" class="btn btn-primary col-6">Modifier cet acteur</button>
          </div>
          <br/><br/>
        </div>
            
        <div id="div_form_update" style="display:none;">
          <div class="row">
            <div class="form-group col-sm-6 col-12">
              <label for="a_prenom" class="col-form-label">Prénom :</label>
              <input type="text" class="form-control" id="u_prenom" name="u_prenom" placeholder="ex : Clint" required>
            </div>
            <div class="form-group col-sm-6 col-12">
              <label for="a_nom" class="col-form-label">Nom :</label>
              <input type="text" class="form-control" id="u_nom" name="u_nom" placeholder="ex : Eastwood" required>
            </div>
          </div>
          <br/>
            
          <div class="form-group row">
            <label for="a_date_naissance" class="col-form-label col-lg-3 col-12">Date de naissance :</label>
            <div class="col-lg-9 col-12">
              <input type="date" class="form-control" id="u_date_naissance" name="u_date_naissance">
            </div>
          </div>
          <br/><br/>
            
          <div class="text-center">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id_acteur_value" id="id_acteur_value">
            <button type="submit" class="btn btn-primary col-6">Modifier cet acteur</button>
            <br/><br/>
            <button id="annuler" type="button" class="btn btn-dark col-6">Annuler</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

<script>
    var button_table_update = document.getElementById("button_table_update");
    var table_update_acteur = document.getElementById("table_update_acteur");
    var div_form_update = document.getElementById("div_form_update");
    var annuler = document.getElementById("annuler");
    
    button_table_update.onclick = function() {
      table_update_acteur.style.display = 'none';
      div_form_update.style.display = 'block';
      
      var boutons = document.getElementsByName("u_acteur_id");
      var id_acteur;
      for(var i = 0; i < boutons.length; i++){
        if(boutons[i].checked) id_acteur = boutons[i].value;
      }
      document.getElementById("id_acteur_value").value = id_acteur; // Pour le champ caché qui récupère l'id de l'acteur
      var nom_acteur = document.getElementById(("nom").concat(id_acteur)).innerHTML;
      var prenom_acteur = document.getElementById(("prenom").concat(id_acteur)).innerHTML;
      var date_naissance_acteur = document.getElementById(("date_naissance").concat(id_acteur)).innerHTML;
      
      document.getElementById("u_nom").value = nom_acteur;
      document.getElementById("u_prenom").value = prenom_acteur;
      document.getElementById("u_date_naissance").value = date_naissance_acteur;
    };
    
    annuler.onclick = function() {
      table_update_acteur.style.display = 'block';
      div_form_update.style.display = 'none';        
    };
</script>
</html>