<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Netflix 2</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <?php
    include("connexion.php");
    include("navbar.php");
  ?>
  <div class="container col-12">
    </br>

    <h3 class="t3 text-uppercase text-center">Liste de films</h3></br>
    <ul>
      <form action="liste.php" method=POST>
        <div class="form-group row">
          <label for="f_acteur" class="col-form-label col-lg-2 col-12">Titre:</label>
          <div class="col-lg-3 col-12">
            <input type="text" name="titre">
          </div>
        </div>
        <div class="form-group row">
          <label for="f_acteur" class="col-form-label col-lg-2 col-12">Resume:</label>
          <div class="col-lg-3 col-12">
            <input type="text" name="resume">
          </div>
        </div>
        <div class="form-group row">
          <label for="f_acteur" class="col-form-label col-lg-2 col-12">Acteur:</label>
          <div class="col-lg-3 col-12">
            <input type="text" name="acteur">
          </div>
	      </div>
	      <div class="form-group row">
          <label for="f_categorie" class="col-form-label col-lg-2 col-12">Catégorie:</label>
            <div class="col-lg-3 col-12">
              <select class="custom-select"  name="categorie" >
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
                      echo '<option value=' . $ligne["id"] . '>' . $ligne["libelle"] . '</option>';
                      $ligne=pg_fetch_array($resultat);
                    }
                  }                
                ?>
              </select>
            </div>
	        <div class="col-lg-3 col-12"> <input type="submit" value="Recherche"  ></div>
        </div>
      </form>
	  </ul>
	  <table class="table table-bordered table2">
      <thead>
        <tr>
          <th scope="col">Titre des films</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (!$connect){                       
            echo "Probleme connexion a la base";                        
            exit;                      
          }
         
          $request = "select distinct titre,film.id from film left join role on film.id = role.film  left join acteur on acteur.id = role.acteur where 
           film.id not in (select film from episode) ";
         
          if(isset($_POST['categorie']) && $_POST['categorie'] != "") {
            $categorie = $_POST["categorie"];
            $request .=  " and categorie = $categorie";
          }
          if(isset($_POST['titre'])  && $_POST['titre'] != "") {
            $titre = "'%" . $_POST["titre"] . "%'";
            $request .=  " and titre like $titre ";
          }
          if(isset($_POST['resume'])  && $_POST['resume'] != "") {
            $resume = "'%" . $_POST["resume"] . "%'";
            $request .=  " and resume like $resume ";
          }

          if(isset($_POST['acteur'])  && $_POST['acteur'] != "") {
            $acteur = "'%" . $_POST["acteur"] . "%'";
            $request .=  " and (nom like $acteur or prenom like $acteur) ";
          }
          $request .= " order by titre;";

          $result = pg_query($request);
          if($result) {
            $ligne = pg_fetch_array($result);
            while($ligne) {
              $titre = $ligne["titre"];
              $id = $ligne["id"];
              echo "<tr><td><a href=\"film.php?film=$id\">&#8594; $titre</a></td></tr>";
              $ligne = pg_fetch_array($result);
            }
          }
          else { echo "erreur de requete";}

        ?>
      </tbody>
    </table>

    <br/><br/><br/>
    <table class="table table-bordered table2">
      <tr>
        <th>Titre des séries</th>
      </tr>
      <?php
        $request = "select distinct serie.id as id_s, serie.titre as titre from film  join episode on episode.film = film.id  join serie on episode.serie=serie.id  join role on film.id = role.film  
        left join acteur on acteur.id = role.acteur
          where film.id  in (select film from episode) ";
        if(isset($_POST['categorie']) && $_POST['categorie'] != "") {
          $categorie = $_POST["categorie"];
          $request .=  " and categorie = $categorie";
        }
        if(isset($_POST['titre'])  && $_POST['titre'] != "") {
          $titre = "'%" . $_POST["titre"] . "%'";
          $request .=  " and serie.titre like $titre ";   
        }
        if(isset($_POST['resume'])  && $_POST['resume'] != "") {
          $resume = "'%" . $_POST["resume"] . "%'";
          $request .=  " and serie.resume like $resume ";
        }
        if(isset($_POST['acteur'])  && $_POST['acteur'] != "") {
          $acteur = "'%" . $_POST["acteur"] . "%'";
          $request .=  " and (nom like $acteur or prenom like $acteur) ";
        }
        $request .= ";";
          
        $resultat=pg_query($connect,$request);
        if (!$resultat){ echo "Probleme lors du lancement de la requête"; exit; }
        $ligne=pg_fetch_array($resultat);
            
        while ($ligne){
          $id=$ligne["id_s"];
          echo '<tr><td><a href="film.php?s=1&film='.$id.'">&#8594; '.$ligne["titre"].'</a></td>';
          $ligne=pg_fetch_array($resultat);
        }
      ?>
    </table>

</div>
</body>
</html>