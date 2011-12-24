<?php

$width=intval($_GET['width']);
$height=intval($_GET['height']);
$img = 'files/uploads/'.$_GET['folder'].'/'.$_GET['filename'].'.'.$_GET['ext'];
$dest = 'files/thumbs/'.$_GET['folder'].'/'.$_GET['filename'].'_'.$width.'x'.$height.'.'.$_GET['ext'];

if(!file_exists($img))
{
    exit('fichier non trouvé : '.$img) ;
}

$folders = explode('/',$_GET['folder']);
$folder='';
foreach($folders as $f)
{
    $folder.=$f.'/';
    if(!is_dir('files/thumbs/'.$folder))
    {
        mkdir('files/thumbs/'.$folder);
    }
}


if(!file_exists($dest))
{
    Image::resize($img,$dest,$width,$height);
}

header("Content-type:image/".$_GET['ext']);

echo file_get_contents($dest);

class Image{

	public static $useGD = true; // On utilise la librairie GD ?
    public static $quality = 90; 
	
	/**
	* Permet de redimensionner/cropper une image
	* @param $img String Chemin absolu de l'image d'origine
	* @param $dest String Chemin absolu de l'image générée (.jpg)
	* @param $largeur Int Largeur de l'image générée, si 0 cette valeur sera calculé en fonction de la hauteur
	* @param $hauteur Int Hauteur de l'image générée, si 0 cette valeur sera calculé en fonction de la largeur
	* Si largeur et hauteur = 0 l'image gardera son format d'origine mais sera convertie en JPG
	**/
	public static function resize($img,$dest,$largeur=0,$hauteur=0){
		// On récupère les dimensions de l'image
		$dimension=getimagesize($img);
		$ratio = $dimension[0] / $dimension[1];	// Et son ratio
		
		// On trouve les dimension finale 
		// (si on a passé 0 en paramètre c'est que l'on veut que le paramètre s'adapte pour conserver le ratio)
		if($largeur==0 && $hauteur==0){ $largeur = $dimension[0]; $hauteur = $dimension[1]; }
		else if($hauteur==0){ $hauteur = round($largeur / $ratio); }
		else if($largeur==0){ $largeur = round($hauteur * $ratio); }
		
		// Si on doit "cropper" l'image on cherche de cb de px on doit décaler l'image miniatures pour la centrer
		if($dimension[0]>($largeur/$hauteur)*$dimension[1] ){ $dimY=$hauteur; $dimX=round($hauteur*$dimension[0]/$dimension[1]); $decalX=($dimX-$largeur)/2; $decalY=0;}
		if($dimension[0]<($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=round($largeur*$dimension[1]/$dimension[0]); $decalY=($dimY-$hauteur)/2; $decalX=0;}
		if($dimension[0]==($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=$hauteur; $decalX=0; $decalY=0;}
		
		// On crée l'image avec la librairie GD
		if(self::$useGD){
			$miniature =imagecreatetruecolor ($largeur,$hauteur);
			if(substr($img,-4)==".jpg" || substr($img,-5)==".jpeg" || substr($img,-4)==".JPG"){
			    $image = imagecreatefromjpeg($img);
			    imagecopyresampled($miniature,$image,-$decalX,-$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
			    imagejpeg($miniature,$dest,self::$quality);
			}
			if(substr($img,-4)==".png" || substr($img,-4)==".PNG"){
			    $image = imagecreatefrompng($img);
			    imagecolortransparent($miniature, imagecolorallocatealpha($miniature, 0, 0, 0, 127));
			    imagealphablending($miniature, false);
			    imagesavealpha($miniature, true);
			    imagecopyresampled($miniature,$image,-$decalX,-$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
			    imagepng($miniature,$dest,(int)(self::$quality/10));
			}
			if(substr($img,-4)==".gif" || substr($img,-4)==".GIF"){
			    $image = imagecreatefromgif($img);
			    imagecolortransparent($miniature, imagecolorallocatealpha($miniature, 0, 0, 0, 127));
			    imagealphablending($miniature, false);
			    imagesavealpha($miniature, true);
			    imagecopyresampled($miniature,$image,-$decalX,-$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
			    imagegif($miniature,$dest,self::$quality);
			}

			
			return true;
			
		// Ou on utilise imagemagick
		}else{
			$cmd = '/usr/bin/convert -resize '.$dimX.'x'.$dimY.' "'.$img.'" "'.$dest.'"';
			shell_exec($cmd);

			$cmd = '/usr/bin/convert -gravity Center -quality '.self::$quality.' -crop '.$largeur.'x'.$hauteur.'+0+0 -page '.$largeur.'x'.$hauteur.' "'.$dest.'" "'.$dest.'"';
			shell_exec($cmd);
		}
         return true;
	}
}

?>