<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <title>Gestion films / séries</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/ajout_film.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
  <?php
    include("connexion.php");
    include("navbar.php");
    include("verifyAccess.php")
  ?>

  <div class="container mx-auto col-lg-6 col-12">
    <div class="block_div shadow">
      <h3 class="t3 text-uppercase text-center">Gestion des films</h3>
      <br/><br/>
      <div class="text-center"><a type="button" class="btn btn-success" href="./ajout_film.php?t=af">Ajouter un nouveau film</a></div>
      <br/><br/>
      
      <table class="table">
        <tr>
          <th>Titre</th>
          <th>Date de sortie</th>
          <th>Durée</th>
          <th>Catégorie</th>
          <th></th>
          <th></th>
        </tr>
        <?php  
          $icon_trash = '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg>';
          $icon_update = '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/></svg>';
          $sql="select * from film where id not in (select film from episode);";
          $resultat=pg_query($connect,$sql);
          if (!$resultat){ echo "Probleme lors du lancement de la requête"; exit; }
          $ligne=pg_fetch_array($resultat);
          while ($ligne){
            $sql2="select libelle from categorie where id =".$ligne["categorie"].";";
            $res2=pg_query($connect,$sql2);
            if (!$res2){ echo "Probleme lors du lancement de la requête"; exit; }
            $categ=pg_fetch_array($res2)[0];
            echo "<tr>";
            echo "<td id='titre".$ligne["id"]."'>".$ligne["titre"]."</td>";
            echo "<td id='date_sortie".$ligne["id"]."'>".$ligne["date_sortie"]."</td>";
            echo "<td id='duree".$ligne["id"]."'>".$ligne["duree"]." min</td>";
            echo "<td id='categorie".$ligne["id"]."'>".$categ."</td>";
            echo "<td><button type='button' class='btn bstyle' title='Modifier ce film' onclick='location.href = \"./ajout_film.php?t=uf&id=".$ligne["id"]."\"'>".$icon_update."</button>";
            echo "<td><a type='button' class='btn bstyle' aria-pressed='false' onclick='javascript: return confirm(\"Voulez-vous vraiment supprimer ce film ?\")' title='Supprimer ce film' href='./ajout_film_req.php?t=s&id=".$ligne["id"]."'>".$icon_trash."</a>";
            echo "</tr>";
            $ligne=pg_fetch_array($resultat);
          }
        ?>
      </table>
      <br/><br/>
    </div>
    <br/><br/>
    <div class="block_div shadow">
      <h3 class="t3 text-uppercase text-center">Gestion des Séries</h3>
      <br/><br/>
      <div class="text-center"><a type="button" class="btn btn-success" href="./gestion_serie.php">Ajouter une nouvelle série</a></div>
      <br/></br>
      <?php  
          // ---------- Infos sur la série ----------
          $sql="select * from serie;";
          $resultat=pg_query($connect,$sql);
          if (!$resultat){ echo "Probleme lors du lancement de la requête"; exit; }
          $ligne=pg_fetch_array($resultat);
          while ($ligne){
            $id_serie = $ligne["id"];
            $sql_nb_ep="select count(numero) from episode where serie=".$id_serie.";";
            $res_nb_ep=pg_query($connect,$sql_nb_ep);
            $nb_ep=pg_fetch_array($res_nb_ep)[0];
            echo '<div class="une_serie"><p class="titre_serie">'.$ligne["titre"].'</p>
              <p class="row"><span class="col-6"><b>Date de sortie :</b> '.$ligne["date_sortie"].'</span>
              <span class="col-6"><b>Nombre d\'épisodes : </b>'.$nb_ep.'</span></p>
              <div class="row"><div class= "col-6"><a href="./gestion_serie.php?id='.$id_serie.'"> Modifier les informations de cette série</a></div>';        
            // ---------- Episodes ----------
            echo '<div class="col-6"><button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#collapse'.$id_serie.'" 
              aria-expanded="false" aria-controls="collapse'.$id_serie.'">Gérer les épisodes</button></div></div><br/>
              <div class="row"><div class="col"><div class="collapse multi-collapse c5" id="collapse'.$id_serie.'"><div class="card card-body">
              <h6 class="t5 text-uppercase">Épisodes</h6>';
            $sql_ep="select * from film, episode where episode.film = film.id and serie=".$id_serie.";";
            
            $resultat_ep=pg_query($connect,$sql_ep);
            if (!$resultat_ep){ echo "Probleme lors du lancement de la requête"; exit; }
            $un_ep=pg_fetch_array($resultat_ep);
            if(!$un_ep) echo "<p class='text-center'>Aucun épisode</p>";
            else{
              echo '<table class="table"> <tr> <th>Numéro episode</th><th>Titre</th><th>Date de sortie</th><th>Durée</th><th>Catégorie</th><th></th><th></th></tr>';
              while ($un_ep){ 
                $sql3="select libelle from categorie where id =".$un_ep["categorie"].";";
                $res3=pg_query($connect,$sql3);
                if (!$res3){ echo "Probleme lors du lancement de la requête"; exit; }
                $categ=pg_fetch_array($res3)[0];
                echo "<tr>
                  <td id='numero".$un_ep["id"]."'>".$un_ep["numero"]."</td>
                  <td id='titre".$un_ep["id"]."'>".$un_ep["titre"]."</td>
                  <td id='date_sortie".$un_ep["id"]."'>".$un_ep["date_sortie"]."</td>
                  <td id='duree".$un_ep["id"]."'>".$un_ep["duree"]." min</td>
                  <td id='categorie".$un_ep["id"]."'>".$categ."</td>
                  <td><button type='button' class='btn bstyle' title='Modifier cet épisode' onclick='location.href = \"./ajout_film.php?t=ue&ids=".$id_serie."&num=".$un_ep["numero"]."&id=".$un_ep["id"]."\"'>".$icon_update."</button>
                  <td><a type='button' class='btn bstyle' aria-pressed='false' 
                  onclick='javascript: return confirm(\"Voulez-vous vraiment supprimer cet épisode ?\")' title='Supprimer cet épisode' href='./gestion_films_req.php??t=s&id=".$un_ep["id"]."'>".$icon_trash."</a>
                  </tr>";
                $un_ep=pg_fetch_array($resultat_ep);
              }
              echo '</table>';
            }
            echo '<br/><div class="text-center"><a type="button" class="btn btn-success" href="./ajout_film.php?t=ae&ids='.$id_serie.'">Ajouter un épisode</a></div>
              </div></div></div></div>
              <br></div>';
            // Passer à la série suivante
            $ligne=pg_fetch_array($resultat);
          }
      ?>
      <br/><br/>
    </div>
  </div>
</body>
</html>