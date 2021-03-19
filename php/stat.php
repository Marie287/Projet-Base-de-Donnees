<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Statistique</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profil.css">
  </head>
  <body>
    <?php 
      include("connexion.php");
      include("navbar.php");
      include("verifyAccess.php"); 
      $filter1 = "date";
      $filter2 = "dl";
      $order = "DESC";
      $o=1;
  
      if(isset($_GET["f"]) && (($_GET["f"] == "user") || ($_GET["f"] == "titre1"))) {
        $filter1=$_GET["f"];
      }
      if(isset($_GET["f"]) && (($_GET["f"] == "dl") || ($_GET["f"] == "titre2"))) {
        $filter2=$_GET["f"];
      }
      if(isset($_GET["o"]) && $_GET["o"] == 1) {
        $o = 2;
      } else if (isset($_GET["o"]) && $_GET["o"] == 2) {
        $o = 1;
        $order = "ASC";
      }
    ?>
    <h1>Statistique du site</h1>
    <h2>Historique de téléchargement global</h2>
    <table class="table table-bordered table2">
      <thead>
        <tr>
          <th scope="col"><a href="./stat.php?f=login&o=<?php echo $o ?>">Utilisateur</a></th>
          <th scope="col"><a href="./stat.php?f=titre1&o=<?php echo $o ?>">Titre</a></th>
          <th scope="col"><a href="./stat.php?o=<?php echo $o ?>">Date</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $cmd = "select login, titre as titre1, t.date from utilisateur u, film f, video v, telecharge t where u.id = t.utilisateur and f.id = v.film and v.id = t.video order by $filter1 $order;";
          if($result = pg_query($connect, $cmd)) {
            while ($ligne = pg_fetch_array ( $result )) {
              $login = $ligne["login"];
              $titre = $ligne["titre1"]; 
              $date = $ligne["date"];
              echo "<tr><td>$login</td><td>$titre</td><td>$date</td></tr>";
            }  
          }
        ?>
      </tbody>
    </table>
    <h2>Nombre de téléchargements par film</h2>
    <table class="table table-bordered table2">
      <thead>
        <tr>
          <th scope="col"><a href="./stat.php?f=titre2&o=<?php echo $o ?>">Titre</a></th>
          <th scope="col"><a href="./stat.php?f=dl&o=<?php echo $o ?>">Téléchargements</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $cmd = "select titre as titre2, Count(*) as dl from film f, video v, telecharge t where f.id=v.film and v.id=t.video group by titre order by $filter2 $order;
          ";
          if($result = pg_query($connect, $cmd)) {
            while ($ligne = pg_fetch_array ( $result )) {
              $titre2 = $ligne["titre2"]; 
              $dl = $ligne["dl"];
              echo "<tr><td>$titre2</td><td>$dl</td></tr>";
            }  
          }
        ?>
      </tbody>
    </table>
</body>