<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>
    <?php
      switch($_GET["t"]){
        case "af": echo 'Ajouter un film'; break;
        case "uf": echo 'Modifier un film'; break;
        case "ae": echo 'Ajouter un épisode'; break;
        case "ue": echo 'Modifier un épisode'; break;
      }
    ?>
  </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/ajout_film.css">
</head>
<body>
  <?php
    include("connexion.php");
    include("navbar.php");
    include("verifyAccess.php"); ?>

    <div class="container mx-auto col-lg-12 col-12">
      <br/><a href="./gestion_films.php">Retour</a><br/><br/><br/>
      <h3 class="t3 text-uppercase text-center">
        <?php
          if(isset($_GET["t"])){
            if($_GET["t"] == "uf" || $_GET["t"] == "ue"){
              $sql_u="select * from film where id = ".$_GET["id"].";";
              $res_u=pg_query($connect,$sql_u);
              if (!$res_u){ echo "Probleme lors du lancement de la requête"; exit; }
              else $film_to_update=pg_fetch_array($res_u);
            }
            switch($_GET["t"]){
              case "af": echo 'Ajouter un film'; break;
              case "uf": echo 'Modifier un film : '.$film_to_update["titre"]; break;
              case "ae": echo 'Ajouter un épisode'; break;
              case "ue": echo 'Modifier un épisode : '.$film_to_update["titre"]; break;
            }
          }
        ?>
      </h3>
      <br/>
      <?php
        if(isset($_GET["ids"])){
          $sql_id_serie="select * from serie where id = ".$_GET["ids"].";";
          $sql_id_serie2 = pg_query($connect,$sql_id_serie);
          $id_serie = pg_fetch_array($sql_id_serie2);
          if (!$id_serie){ echo "Probleme lors du lancement de la requête"; exit; }
          echo "<h5 class='text-center text-uppercase t3'><b>Série : </b>".$id_serie["titre"]."</h5>";
        }
      ?>
      <br/><br/>
    
      <form action="./ajout_film_req.php" method=POST class="mx-auto col-lg-7 col-12">
        <h6 class="t4 text-uppercase">Informations générales</h6><hr>
        <?php
          if(isset($_GET["ids"])){
            $num_dernier_ep="select max(numero) from episode where serie=".$id_serie["id"].";";
            $num_dernier_ep2=pg_query($connect,$num_dernier_ep);
            $num_dernier_ep3=pg_fetch_array($num_dernier_ep2);
            echo '<div class="form-group row">
              <label for="f_numero" class="col-form-label col-lg-3 col-12">Numéro de l\'épisode :</label>
              <div class="col-lg-9 col-12">
                <input type="text" class="form-control" name="f_numero" placeholder="ex : 1" value="';
                if(isset($_GET["num"])) echo $_GET["num"];
                echo '" required>
                <small id="emailHelp" class="form-text text-muted">Numéro du dernier épisode : '.$num_dernier_ep3[0].'</small>
                </div></div><br/>
                <input type="hidden" id="id_serie" name="id_serie" value="'.$_GET["ids"].'">';
            }
        ?>

        <div class="form-group row">
          <label for="f_titre" class="col-form-label col-lg-3 col-12">Titre :</label>
          <div class="col-lg-9 col-12">
            <input type="text" class="form-control" name="f_titre" placeholder="ex : Cars 3" 
            <?php if(isset($film_to_update)) echo 'value="'.$film_to_update["titre"].'"'; ?>
            required>
          </div>
        </div>
        <br/>
        
        <div class="form-group row">
          <label for="f_date_sortie" class="col-form-label col-lg-3 col-12">Date de sortie :</label>
          <div class="col-lg-9 col-12">
            <input type="date" class="form-control" name="f_date_sortie"
            <?php if(isset($film_to_update) && !empty($film_to_update["date_sortie"])) echo 'value="'.$film_to_update["date_sortie"].'"'; ?>
            >
          </div>
        </div>
        <br/>
        
        <div class="form-group row">
          <label for="f_duree" class="col-form-label col-lg-3 col-12">Durée :</label>
          <div class="col-lg-9 col-12">
            <input type="number" class="form-control" name="f_duree" placeholder="ex : 180 min"
            <?php if(isset($film_to_update) && !empty($film_to_update["duree"])) echo 'value="'.$film_to_update["duree"].'"'; ?>
            >
          </div>
        </div>
        <br/>
        
        <div class="form-group row">
          <label for="f_categorie" class="col-form-label col-lg-3 col-12">Catégorie :</label>
          <div class="col-lg-9 col-12">
            <select class="custom-select" name="f_categorie" required>
              <option value="">Sélectionnez une catégorie</option>
               
              <?php
                  $sql="select id, libelle from categorie;";
                $resultat=pg_query($connect,$sql);
                if (!$resultat){
                  echo "Probleme lors du lancement de la requête";
                  exit;
                }
                else{
                  $ligne=pg_fetch_array($resultat);
                  while ($ligne){
                    echo '<option value="' . $ligne["id"].'" ';
                    if(isset($film_to_update) && $ligne["id"] == $film_to_update["categorie"]) echo 'selected';
                    echo '>'.$ligne["libelle"].'</option>';
                    $ligne=pg_fetch_array($resultat);
                  }
                }                
                ?>
                
            </select>
          </div>
        </div>
        <br/>
        
        <div class="form-group row">
          <label for="f_resume" class="col-lg-3 col-12">Résumé :</label>
          <div class="col-lg-9 col-12">
            <textarea class="form-control" name="f_resume" rows="5" placeholder="Ecrivez le résumé du film ici..." 
            ><?php if(isset($film_to_update) && !empty($film_to_update["resume"])) echo $film_to_update["resume"] ?></textarea>
          </div>
        </div>
        <br/><br/><br/>
        
        <h6 class="t4 text-uppercase">Acteurs</h6>
        <table class="table text-center" id="liste_acteurs">
            <tr>
              <th></th>
              <th>Nom Prénom</th>
              <th>Rôle</th>
              <th></th>
            </tr>

            <?php
              if(isset($_GET["id"])){
                $sql1="select * from role where film =".$_GET["id"].";";
                $tous_acteurs=pg_query($connect,$sql1);
                if (!$tous_acteurs){ echo "Probleme lors du lancement de la requête"; exit; }
                else{
                  $ligne=pg_fetch_array($tous_acteurs);
                  while ($ligne){
                    $sql2="select * from acteur where id =".$ligne["acteur"].";";
                    $infos_acteur=pg_query($connect,$sql2);
                    if (!$infos_acteur){ echo "Probleme lors du lancement de la requête"; exit; }
                    else{
                      $infos_acteur_2=pg_fetch_array($infos_acteur);
                      echo '<tr id="'.$infos_acteur_2["id"].'">';
                      echo '<td>'.$infos_acteur_2["id"].'</td>';
                      echo '<td>'.$infos_acteur_2["prenom"].' '.$infos_acteur_2["nom"].'</td>';
                      echo '<td>'.$ligne["libelle"].'</td>';
                      echo '<td>';
                      echo '<button title="Supprimer cet acteur" class="btn" type="button" onclick="removeActeur('.$ligne["acteur"].');">X</button>';
                      echo '</td></tr>';
                    }
                    $ligne=pg_fetch_array($tous_acteurs);
                  }
                }
                  
              }
            ?>
        </table>
            
        <div class="form-group row">
          <div class="col-sm-6 col-12">
            <select class="custom-select" id="f_acteur_np" name="f_acteur_np">
              <option selected>Choisissez un acteur parmi la liste</option>
              <?php
                  $sql="select id, nom, prenom from acteur;";
                  $resultat=pg_query($connect,$sql);
                  if (!$resultat){
                      echo "Probleme lors du lancement de la requête ici";
                      exit;
                  }
                  else{
                      $ligne=pg_fetch_array($resultat);
                      while ($ligne){
                          echo '<option value='. $ligne["id"].'>'.$ligne["prenom"].' '.$ligne["nom"].'</option>';
                          $ligne=pg_fetch_array($resultat);
                      }
                  }
              ?>
                    
            </select>
          </div>
          <div class="col-sm-6 col-12">
            <input type="text" class="form-control" id="f_acteur_role" name="f_acteur_role" placeholder="Rôle">
          </div>
          <div id="erreurs_acteurs" class="text-center col-12 mt-2"></div>
          <input type="hidden" id="tab_acteurs" name="tab_acteurs" value="">
        </div>

        <div class="text-center">
          <button id="b_ajout_acteur" type="button" class="btn btn-secondary">Ajouter cet acteur</button>
        </div>
        <br/><br/><br/>
        
        <h6 class="t4 text-uppercase">Bande-annonce</h6><hr>
        <p>Vous pouvez renseigner l'url de plusieurs bande-annonces dans plusieurs formats : </p>
        <?php
          $sql="select id, libelle from format;";
          $liste_formats=pg_query($connect,$sql);
          if (!$liste_formats){
            echo "Probleme lors du lancement de la requête";
            exit;
          }
          else{
            $ligne=pg_fetch_array($liste_formats);
            while ($ligne){
              echo '<div class="form-group row">';
              echo '<label for="f_format_ba_'.$ligne["id"].'" class="col-sm-3 col-form-label"> Format '.$ligne["libelle"].' : </label>';
              echo '<div class="col-sm-9">';
              echo '<input type="url" class="form-control" name="f_format_ba_'.$ligne["id"].'" placeholder="URL"';
              
              /* Si modification d'un film */
              if(isset($film_to_update)){
                $ba_sql=pg_query($connect,"select url from video where film=".$film_to_update["id"]." and type='ba' and format=".$ligne["id"].";");
                $ba = pg_fetch_array($ba_sql)[0];
                if($ba) echo "value = '".$ba."'";
              }
              echo '></div></div>';
              $ligne=pg_fetch_array($liste_formats);
            }
          }                
        ?>
        <br/><br/><br/>
        <h6 class="t4 text-uppercase">Vidéo du film à télécharger</h6><hr>
        <p>Vous pouvez renseigner l'url de plusieurs vidéos du même film dans plusieurs formats : </p>
        <?php
          $sql="select id, libelle from format;";
          $liste_formats=pg_query($connect,$sql);
          if (!$liste_formats){
              echo "Probleme lors du lancement de la requête";
              exit;
          }
          else{
            $ligne=pg_fetch_array($liste_formats);
            while ($ligne){
              echo '<div class="form-group row">';
              echo '<label for="f_format_v_'.$ligne["id"].'" class="col-sm-3 col-form-label"> Format '.$ligne["libelle"].' : </label>';
              echo '<div class="col-sm-9">';
              echo '<input type="url" class="form-control" name="f_format_v_'.$ligne["id"].'" placeholder="URL"';
              
              /* Si modification d'un film */
              if(isset($film_to_update)){
                $vid_sql=pg_query($connect,"select url from video where film=".$film_to_update["id"]." and type='film' and format=".$ligne["id"].";");
                $vid = pg_fetch_array($vid_sql)[0];
                if($vid) echo "value = '".$vid."'";
              }
              
              echo '></div></div>';
              $ligne=pg_fetch_array($liste_formats);
            }
          }                
        ?>
        <br/><br/><br/>
      
        <?php
          if(isset($_GET["id"])) echo '<input type="hidden" id="id_update" name="id_update" value="'.$_GET["id"].'">';
        ?>
      
        <div class="text-center">
          <button type="submit" class="btn btn-success btn-block">Enregistrer</button>
        </div>
        
      </form>

<script>
  window.onload = function(){
    f_acteur_role = document.getElementById("f_acteur_role");
    f_acteur_np = document.getElementById("f_acteur_np");
    b_ajout_acteur = document.getElementById("b_ajout_acteur");
    
    tab_acteurs = document.getElementById("tab_acteurs");
    
    array_acteurs = [];
    erreurs_acteurs = document.getElementById("erreurs_acteurs");
    var liste_acteurs = document.querySelectorAll("#liste_acteurs tr");
    for (i=1; i < liste_acteurs.length; i++) {
      var id = liste_acteurs[i].querySelectorAll("td")[0].innerHTML;
      var role = liste_acteurs[i].querySelectorAll("td")[2].innerHTML;
      var tab = {
          "id" : id,
          "role" : role
      };
      array_acteurs.push(tab);
      tab_acteurs.value = JSON.stringify(array_acteurs);
    }
      
    b_ajout_acteur.onclick = function() {
      erreurs_acteurs.innerHTML = "";
      
      if(f_acteur_np.value != "Choisissez un acteur parmi la liste" && f_acteur_role.value != ""){
        if(!checkActeurinArray(f_acteur_np.value)){
          var tab = {
              "id" : f_acteur_np.value,
              "role" : f_acteur_role.value
          };
          array_acteurs.push(tab);
          tab_acteurs.value = JSON.stringify(array_acteurs);
          
          var tableRef = document.getElementById("liste_acteurs");
          var newRow = tableRef.insertRow(-1);
          
          newRow.setAttribute("id", f_acteur_np.value);
              
          var col0 = newRow.insertCell(0);
          var col0_val = document.createTextNode(f_acteur_np.value);
          col0.appendChild(col0_val);
          
          var col1 = newRow.insertCell(1);
          var col1_val = document.createTextNode(f_acteur_np.options[f_acteur_np.selectedIndex].text);
          col1.appendChild(col1_val);
              
          var col2 = newRow.insertCell(2);
          var col2_val = document.createTextNode(f_acteur_role.value);
          col2.appendChild(col2_val);
          
          var col3 = newRow.insertCell(3);
          var b_html = "<button type='button' class='btn'>X</button>";
          col3.insertAdjacentHTML(
              "beforeend",
              "<button type='button' title='Supprimer cet acteur' class='btn' onclick='removeActeur(".concat(f_acteur_np.value).concat(");' >X</button>")
          );
        }
        else erreurs_acteurs.innerHTML = "Cet acteur a déjà été choisi";
      }
      else erreurs_acteurs.innerHTML = "Champs invalides";
    }
  }
    
    function removeActeur(id){
      document.getElementById(id).remove();
      for (var i = array_acteurs.length - 1; i >= 0; i--) {
        if (array_acteurs[i].id == id) array_acteurs.splice(i, 1);
      }
      erreurs_acteurs.innerHTML = "";
      tab_acteurs.value = JSON.stringify(array_acteurs);
    }
    
    function checkActeurinArray(id){
      for (var i = array_acteurs.length - 1; i >= 0; i--) {
        if (array_acteurs[i].id == id) return 1;
      }
      return 0;
    }

</script>
    
</div>
</body>

</html>