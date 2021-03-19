<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Netflix 2</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<?php
		include("navbar.php");
		include("connexion.php");
	?>
  <div class="container col-12">
		<br/>
  	<?php
  		if(isset($_GET["film"])) {
  			$idfilm = $_GET["film"];
				
				$sql="select * from film, categorie  where film.id = $idfilm and categorie.id = film.categorie;";	
				$resultat=pg_query($connect,$sql);

				if (!$resultat){
  			  echo "Probleme lors du lancement de la requête";
  			  exit;
  			}
				else {
					$ligne=pg_fetch_array($resultat);
  				while ($ligne){
						$titre = $ligne["titre"];
						$resume = $ligne["resume"];
						$date = $ligne["date_sortie"];
						$duree = $ligne["duree"];
						$cat = $ligne["libelle"];
  			    echo "<h3 class=\"t3 text-uppercase text-center\">$titre</h3>";
						echo "<h4><strong>Résumé</strong></h4>";
						echo "<p>$resume</p>";
						echo "<h4><strong>Informations</strong></h4>";
						echo "<p><strong>Date de sortie :</strong> $date</p>"; 
						echo "<p><strong>Durée :</strong> $duree minutes</p>";
						echo "<p><strong>Catégorie :</strong> $cat</p>";
  			    $ligne=pg_fetch_array($resultat);
  			 	}
  			}
  		}
									
			else {
				echo "On cherche quel film la?";
			}
  	?>
		<h4><strong>Acteurs</strong></h4>
		<table class="table table-bordered">
			<tbody>
				<?php
					if(isset($_GET["film"])) {
						$idfilm = $_GET["film"];
					
						if (!$connect){
							echo "Probleme connexion a  la base";
							exit;
						}
						
						$sql="select nom,prenom,acteur.id from film, role, acteur  where film.id = $idfilm and film.id =role.film and role.acteur = acteur.id;";
						$resultat=pg_query($connect,$sql);
						
						if (!$resultat){
						echo "Probleme lors du lancement de la requête";
						exit;
						}
						else{
							$ligne=pg_fetch_array($resultat);
							while ($ligne){									
								$acteurnom = $ligne["nom"];
								$acteurprenom = $ligne["prenom"];
								$acteurid = $ligne["id"];
								echo "<tr><td><a href='acteur.php?acteurid=$acteurid'>&#8594; $acteurprenom $acteurnom</a></td><tr>";
								$ligne=pg_fetch_array($resultat);
							}
						}
  	    	}
					else echo "On cherche quel film la?";
				?>
			</tbody>
		</table>
		<h4><strong>Téléchargements</strong><h4>

		<?php
			if(isset($_GET["film"])) {
				$idfilm = $_GET["film"];

				if (!$connect){
					echo "Probleme connexion a  la base";
				exit;
				}

				$sql="select url,video.id,format.libelle from film,video,format  where film.id = $idfilm and film.id = video.film and video.format = format.id and type='ba';";
				$resultat=pg_query($connect,$sql);

  			if (!$resultat){
					echo "Probleme lors du lancement de la requête";
					exit;
				}
				else{
					echo "<h5><strong>Bande annonces</strong></h5>";
					echo "<table class=\"table table-bordered\"><tbody>";
					$ligne=pg_fetch_array($resultat);
						while ($ligne){
							$url = $ligne["url"];
							$file_name = basename($url);
							$idvid = $ligne["id"];
							$format = $ligne["libelle"];
							echo "<tr><td><a href='download.php?film=$idfilm&video=$idvid'>&#8594; $file_name</a></td></tr>";
						}
					echo "</tbody></table>";
				}
			}
			if(isset($_SESSION["session"])) { 
				$login = $_SESSION["session"];
				if(isset($_GET["film"])) {
					$idfilm = $_GET["film"];
					if (!$connect){
						echo "Probleme connexion a  la base";
						exit;
					}

					$sql="select url,video.id,format.libelle from film,video,format  where film.id = $idfilm and film.id = video.film and video.format = format.id and type='film';";
					$resultat=pg_query($connect,$sql);

					if (!$resultat){
						echo "Probleme lors du lancement de la requête";
						exit;
						}
					else{
						echo "<h5><strong>Films</strong></h5>";
						echo "<table class=\"table table-bordered\"><tbody>";
						$ligne=pg_fetch_array($resultat);
						while ($ligne){
							$url = $ligne["url"];
							$file_name = basename($url);
							$idvid = $ligne["id"];
							$format = $ligne["libelle"];
							echo "<tr><td><a href='download.php?film=$idfilm&video=$idvid'>&#8594; $file_name</a></td></tr>";
							$ligne=pg_fetch_array($resultat);
						}
						echo "</tbody></table>";
					}
				}
			}
		?>	
	</div>
</body>
</html>