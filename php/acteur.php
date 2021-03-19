<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Netflix 2</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<?php
    if(isset($_GET["acteurid"])) {
      $idacteur = $_GET["acteurid"];
			include("connexion.php");
	    include("navbar.php"); //les informations de connexion sont stockées dans le fichier connexion.php

			$sql="select * from acteur  where acteur.id = $idacteur;";

			$resultat=pg_query($connect,$sql);

			if (!$resultat){
        echo "Probleme lors du lancement de la requête";
        exit;
      }
			else{
				$ligne=pg_fetch_array($resultat);
				$nom = $ligne["nom"];
				$prenom = $ligne["prenom"];
				$date = $ligne["date_naissance"];

      	echo "<h3 class=\"t3 text-uppercase text-center\">$prenom $nom</h3>";
			 
				echo "<h4><strong>Informations</strong></h4>";
				echo "<p><strong>Date de naissance :</strong> $date</p>"; ;

   	  }
		}
		else echo "On cherche quel acteur la?";
  ?>

	<h4><strong>Rôles</strong></h4>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th scope="col">Film</th>
			<th scope="col">Nom du rôle</th>
		</tr>
		</thead>
		<tbody>

 		<?php
			if(isset($_GET["acteurid"])) {
				$idacteur = $_GET["acteurid"];

				if (!$connect){
					echo "Probleme connexion a  la base";
					exit;
				}

				$sql="select titre, libelle,film.id from film, role where film.id = role.film and role.acteur = $idacteur;";
				$resultat=pg_query($connect,$sql);

				if (!$resultat){
					echo "Probleme lors du lancement de la requête";
					exit;
				}
				else{
					$ligne=pg_fetch_array($resultat);
					while ($ligne){
						$titre = $ligne["titre"];
						$libelle = $ligne["libelle"];
						$id= $ligne["id"];
						echo "<tr><td><a href = film.php?film=$id>$titre</a></td><td>";
						echo "     $libelle</td></tr>";			 
						$ligne=pg_fetch_array($resultat);
					}
				}
			}
			else echo "On cherche quel acteur la?";
	  ?>

		</tbody>
	</table>
</body>
</html>