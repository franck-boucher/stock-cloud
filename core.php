<?php
	session_start();

	if(!isset($_SESSION['pwd']))
	{
		$_SESSION['pwd'] = 'disconnected';
	}

	function taille_fichier($fichier)
	{
		$taille_fichier = filesize($fichier);
		if ($taille_fichier >= 1073741824) 
		{
			$taille_fichier = round($taille_fichier / 1073741824 * 100) / 100 . " Go";
		}
		elseif ($taille_fichier >= 1048576) 
		{
			$taille_fichier = round($taille_fichier / 1048576 * 100) / 100 . " Mo";
		}
		elseif ($taille_fichier >= 1024) 
		{
			$taille_fichier = round($taille_fichier / 1024 * 100) / 100 . " Ko";
		}
		else 
		{
			$taille_fichier = $taille_fichier . " octet(s)";
		} 
		return $taille_fichier;
	}

	function check_password($str)
	{
		$file = fopen('password.txt', 'r+');
		$line = fgets($file);
		if(sha1($str) === $line)
		{
			$bool = TRUE;
		}
		else
		{
			$bool = FALSE;
		}
		fclose($file);

		return $bool;
	}

	function new_password($str1, $str2)
	{
		$file = fopen('password.txt', 'w+');
		$line = fgets($file);
		if(sha1($str1) === $line)
		{
			fputs($file, sha1($str2));
			$bool = TRUE;
		}
		else
		{
			$bool = FALSE;
		}
		fclose($file);

		return $bool;
	}

	function icon($str)
	{
		$extension = end(explode('.', $str));

		switch ($extension) {
			// fichiers audio
		    case 'aif':
		    case 'iff':
		    case 'm3u':
		    case 'm4a':
		    case 'mid':
		    case 'mp3':
		    case 'mpa':
		    case 'ra':
		    case 'wav':
		    case 'wma':
		    case 'flac':
		    case 'alac':
		        $icon = "glyphicon glyphicon-music";
		        break;

		    // fichiers video
		    case '3g2':
		    case '3gp':
		    case 'asf':
		    case 'asx':
		    case 'avi':
		    case 'flv':
		    case 'mkv':
		    case 'mov':
		    case 'mp4':
		    case 'mpg':
		    case 'rm':
		    case 'swf':
		    case 'vob':
		    case 'wmv':
		        $icon = "glyphicon glyphicon-film";
		        break;

		    // fichiers image
		    case 'bmp':
		    case 'dxf':
		    case 'eps':
		    case 'gif':
		    case 'jpeg':
		    case 'jpg':
		    case 'tiff':
		    case 'tif':
		    case 'png':
		    case 'jpe':
		    case 'jfif':
		    case 'tga':
		    case 'dds':
		    case 'raw':
		        $icon = "glyphicon glyphicon-picture";
		        break;

		    // fichiers web
		    case 'html':
		    case 'htm':
		    case 'xhtml':
		    case 'xht':
		    case 'xml':
		        $icon = "glyphicon glyphicon-link";
		        break;

		    // fichiers texte
		    case 'txt':
		    case 'doc':
		    case 'rtf':
		    case 'docx':
		    case 'page':
		    case 'odt':
		        $icon = "glyphicon glyphicon-align-left";
		        break;

		    // fichiers compressé
		    case 'rar':
		    case 'zip':
		    case '7zip':
		    case 'sit':
		    case 'gz':
		    case '7zip':
		        $icon = "glyphicon glyphicon-compressed";
		        break;

		    default:
		        $icon = "glyphicon glyphicon-file";
		        break;
		}

		return $icon;
	}



?>