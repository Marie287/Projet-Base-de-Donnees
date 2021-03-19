<?php
	session_start();
	  if(isset($_SESSION["session"])) { 
	    $login = $_SESSION["session"];
		}
	 	if(isset($_GET["film"])&&isset($_GET["video"] )) {
	  	$idfilm = $_GET["film"];
	  	$idvid = $_GET["video"];
	  	include("connexion.php");
		
			$sql="select url,format,libelle,type from film,video,format  where film.id = $idfilm and film.id = video.film and video.format = format.id and video.id =$idvid;";
			$resultat=pg_query($con,$sql);
		
			if (!$resultat){
	  	  echo "Probleme lors du lancement de la requête";
	  	  exit;
			}
			else{
				$ligne=pg_fetch_array($resultat); 		
				$url = $ligne["url"];
				$file_name = basename($url);
				$format = $ligne["libelle"];
				$type = $ligne["type"];
			
				if($type != "film" || isset($_SESSION["session"])) {
				header("Content-disposition: attachment; filename=$file_name");
				header("Content-type:video/$format");
				readfile($url);
				} else echo "Il faut etre connecté pour telecharger un film.";
			
			}
		}
	if(isset($_SESSION["session"])) {
		$sql="select id from utilisateur where login='$login'";
		$resultat=pg_query($con,$sql);
	
		if (!$resultat){
	    echo "Probleme lors du lancement de la requête login";
	    exit;
	  }
		else{
			$ligne=pg_fetch_array($resultat);
			$id = $ligne["id"];
		}
	
		$sql="INSERT INTO Telecharge VALUES($id, $idvid, CURRENT_TIMESTAMP(2));";
		$resultat=pg_query($con,$sql);
	
		if (!$resultat){
	    echo "Probleme lors du lancement de la requête insert";
	    exit;
	  }
	}
?>
