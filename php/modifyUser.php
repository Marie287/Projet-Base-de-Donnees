<?php
  $filter = "id";
  $order = "ASC";
  $o=1;
  if(isset($_GET["f"]) && (($_GET["f"] == "nom") || ($_GET["f"] == "prenom") || ($_GET["f"] == "mail") || ($_GET["f"] == "login") || ($_GET["f"] == "role") || ($_GET["f"] == "abonne"))) {
    $filter=$_GET["f"];
  }
  if(isset($_GET["o"]) && $_GET["o"] == 1) {
    $o = 2;
  } else if (isset($_GET["o"]) && $_GET["o"] == 2) {
    $o = 1;
    $order = "DESC";
  }
?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Modification des utilisateurs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/modifyUser.css">
  </head>

  <body>
		<?php
      include("connexion.php");
      include("navbar.php"); 
		  include("verifyAccess.php");
    ?>

    <div class="container col-12">
      <div id="alert-r" class="alert alert-success" role="alert" hidden>
        L'utilisateur a bien été supprimé.
      </div>
      <div id="alert-p" class="alert alert-success" role="alert" hidden>
        L'utilisateur a bien été promu.
      </div>
      <div id="alert-s" class="alert alert-success" role="alert" hidden>
        L'utilisateur a bien été réabonné.
      </div>
      <div id="alert-l" class="alert alert-danger" role="alert" hidden>
        Erreur SQL.
      </div>
      <h1>Page de modération des utilisateurs</h1>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?o=<?php echo $o ?>">N°</a></th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=nom&o=<?php echo $o ?>">Nom</th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=prenom&o=<?php echo $o ?>">Prénom</th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=mail&o=<?php echo $o ?>">E-mail</th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=login&o=<?php echo $o ?>">Nom d'utilisateur</th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=role&o=<?php echo $o ?>">Rôle</th>
            <th scope="col"><a href="http://serveur-etu.polytech-lille.fr/~lantoine/projetbd/modifyUser.php?f=abonne&o=<?php echo $o ?>">Abonné</th>
            <th scope="col">Promouvoir</th>
            <th scope="col">Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $cmd = "Select * from utilisateur order by $filter $order;";
            if($result = pg_query($connect, $cmd)) {
              while ($ligne = pg_fetch_array ( $result )) {
                $id = $ligne["id"];
                $nom = $ligne["nom"];
                $prenom = $ligne["prenom"];
                $mail = $ligne["mail"];
                $login = $ligne["login"];
                $role = $ligne["role"];
                $abonne = $ligne["abonne"];
                if ($abonne!="oui") {
                  $button_r="<a class=\"btn btn-outline-warning\" aria-pressed=\"false\" href=\"subscribeUser.php?id=$id\" onclick=\"javascript: return confirm('Êtes vous sûr de vouloir réabonner cet utilisateur ?');\">Réabonner</a>";
                } else if($role!="moderateur") {
                  $button_r="<a class=\"btn btn-outline-success\" aria-pressed=\"false\" href=\"promoteUser.php?id=$id\" onclick=\"javascript: return confirm('Êtes vous sûr de vouloir promouvoir cet utilisateur au rang de modérateur ?');\">Promouvoir</a>";
                } else {
                  $button_r="<a href=\"#\" class=\"btn btn-success disabled\" role=\"button\" aria-disabled=\"true\">Promu</a>";
                }
                echo "<tr><th scope=\"row\">$id</th><td>$nom</td><td>$prenom</td><td>$mail</td><td>$login</td><td>$role</td><td>$abonne</td><td>$button_r</td><td><a class=\"btn btn-outline-danger\" aria-pressed=\"false\" href=\"deleteUser.php?id=$id\" onclick=\"javascript: return confirm('Êtes vous sûr de vouloir supprimer cet utilisateur ?');\">Supprimer</a></td></tr>";
              }
            } else {
              echo "Erreur SQL";
              exit;
            }
          ?>
        </tbody>
      </table>
    </div>
  </body>

  <script>
    function getParameterByName(name, url = window.location.href) {
      name = name.replace(/[\[\]]/g, '\\$&');
      var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
      results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
    var v = getParameterByName('v');
    let alertr = document.getElementById('alert-r');
    let alertp = document.getElementById('alert-p');
    let alertl = document.getElementById('alert-l');
    let alerts = document.getElementById('alert-s');
    if (v != null && v != "" && v == 1) {
      alertr.removeAttribute('hidden');
    } else if (v != null && v != "" && v == 2) {
      alertl.removeAttribute('hidden');
    } else if (v != null && v != "" && v == 3) {
      alertp.removeAttribute('hidden');
    } else if (v != null && v != "" && v == 4) {
      alerts.removeAttribute('hidden');
    }
  </script>
</html>