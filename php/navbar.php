<?php
  session_start();

  echo "<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">";
  echo "<a class=\"navbar-brand\" href=\"./liste.php\">Accueil</a>";
  echo "<div class=\"collapse navbar-collapse\" id=\"navbarTogglerDemo03\">";
  echo "<ul class=\"navbar-nav mr-auto mt-2 mt-lg-0\">";

  if(isset($_SESSION["session"])) {
    $login = $_SESSION["session"];
    $cmd = "Select role from utilisateur where login='$login';";
    if($result = pg_query($connect, $cmd)) {
      $ligne = pg_fetch_array ( $result );
      $role = $ligne["role"];
      if($role == "moderateur") {
        echo "<li class=\"nav-item\">";
        echo "<a class=\"nav-link\" href=\"./page_moderation.php\">Page de modération</a>";
        echo "</li>";
      }
    }    
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"./profil.php\">Mon profil</a></li></ul>";
  } else {
    echo "</ul><ul class=\"navbar-nav ml-auto mt-2 mt-lg-0\">
    <li class=\"nav-item\">
        <a class=\"nav-link\" href=\"../connexion.html\">Connexion</a>
    </li>
    <li class=\"nav-item\">
        <a class=\"nav-link\" href=\"../inscription.html\">Inscription</a>
    </li>
    </ul>";
  }
  echo "</div>
  </nav>";
?>