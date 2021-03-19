<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Mon profil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profil.css">
  </head>
  <body>
    <?php
      include("connexion.php");
      include("navbar.php");
      if(isset($_SESSION["session"])) { 
        $login = $_SESSION["session"];
    ?>
    <h1>Mon profil</h1>
    <h2>Mes informations personnelles</h2>
    <?php
      $cmd = "Select * from utilisateur where login='$login';";
      if($result = pg_query($connect, $cmd)) {
        $ligne = pg_fetch_array ( $result );
        $id = $ligne["id"];
        $nom = $ligne["nom"];
        $prenom = $ligne["prenom"];
        $mail = $ligne["mail"];
        $login = $ligne["login"];
        $role = $ligne["role"];
        $abonne = $ligne["abonne"];
        if ($abonne=="oui") {
          $button_d="<a class=\"btn btn-outline-danger\" aria-pressed=\"false\" href=\"unsubscribeUser.php?id=$id\" onclick=\"javascript: return confirm('Êtes vous sûr de vouloir vous désabonner ?');\">Se désabonner</a>";
        } else {
          $button_d="<a href=\"#\" class=\"btn btn-secondary disabled\" role=\"button\" aria-disabled=\"true\">Désabonné</a>";
        }
      } 
    ?>
    <table class="table table1">
      <tbody>
        <tr>
          <th scope="row">Nom</th>
          <td><?php echo $nom ?></td>
        </tr>
        <tr>
          <th scope="row">Prénom</th>
          <td><?php echo $prenom ?></td>
        </tr>
        <tr>
          <th scope="row">E-mail</th>
          <td><?php echo $mail ?></td>
        </tr>
        <tr>
          <th scope="row">Login</th>
          <td><?php echo $login ?></td>
        </tr>
        <tr>
          <th scope="row">Rôle</th>
          <td><?php echo $role ?></td>
        </tr>
      </tbody>
    </table>
    <div>
        <?php echo $button_d ?>
    </div>
    
    <h2>Mon historique</h2>
    <table class="table table-bordered table2">
      <thead>
        <tr>
          <th scope="col">Titre</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $cmd = "select titre, t.date from utilisateur u, film f, video v, telecharge t where u.id = t.utilisateur and f.id = v.film and v.id = t.video and u.id in (select id from utilisateur where login='$login') order by date desc;";
          if($result = pg_query($connect, $cmd)) {
              while ($ligne = pg_fetch_array ( $result )) {
                  $titre = $ligne["titre"]; 
                  $date = $ligne["date"];
                  echo "<tr><td>$titre</td><td>$date</td></tr>";
              }  
          }
        ?>
      </tbody>
    </table>
  </body>   
  <?php } else { ?>
    <script>
      window.location.replace("../connexion.html?c=1");
    </script>
  <?php } ?>
</html>