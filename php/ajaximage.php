<?php
//Répertoire ou seront placés les images
$pathTo 	= "../img/uploads/";
$maxSize 	= '0.5'; //en Mo

// récupère l'extension du fichier
function getExtension($str)
{
	$i = strrpos($str,".");
	if (!$i)
	{
		return "";
	}
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);
	return $ext;
}

function cleanFileName ($chaine, $extension)
{
	
	setlocale(LC_ALL, 'fr_FR');

	$chaine = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $chaine);

	$chaine = preg_replace('#[^0-9a-z]+#i', '-', $chaine);

	while(strpos($chaine, '--') !== false)
	{
		$chaine = str_replace('--', '-', $chaine);
	}

	$chaine = trim($chaine, '-');
	$chaine = strtolower($chaine);
	$chaine = preg_replace("@(-$extension)@", "", $chaine); //pour afficher l'extension
	return $chaine;
}

$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");

$valid_formats = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/bmp");


if(isset($_POST) AND $_SERVER['REQUEST_METHOD'] == "POST")
{
	$images = $_FILES['imgUpload']; 

	$count = count($images['name']);

	$msgError = $msgSuccess = '';
	$error = 0;
	$uploaded = 0;
	for ($i=0; $i < $count; $i++) 
	{ 
		# code...
		$type = $images['type'][$i];
		$name = $images['name'][$i];
		$size = $images['size'][$i];

		if(strlen($name))
		{
			$ext = getExtension($name);
			if(in_array($type,$valid_formats))
			{
				// Vérification de la taille de l'image
				if($size < (1024* (1024 * $maxSize)) ) 
				{
					$newImageUploaded = cleanFileName($name, $ext).'-'.time().'.'.$ext;
					$tmp = $images['tmp_name'][$i];
					if(move_uploaded_file($tmp, $pathTo.$newImageUploaded))
					{
						$msgSuccess .= "<img src='../img/uploads/".$newImageUploaded."' class='preview'>";
						$uploaded = 1;
					}
					else
					{
						$error = 1;
						$msgError .=  "Erreur";	
					}
					
				}
				else
				{
					$error = 1;
					$msgError .=  "L'image ne doit pas dépasser la taille de ". 1000 * $maxSize ."Ko"; 
				}
			}
			else
			{
				$error = 1;
				$msgError .=  "Format de fichier invalide ...\n"; 
			}
		}
	}
	if ($uploaded == 1)
	{
		echo $msgSuccess;
	}
	else if ($uploaded == 0 && $error == 1)
	{
		echo $msgError;
	}
	else {
		//echo $msgSuccess;
	}

	exit();
}
?>