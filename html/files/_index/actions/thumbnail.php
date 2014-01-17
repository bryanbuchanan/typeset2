<?

// Increase memory limit, if possible
ini_set("memory_limit", "200M");

if ($_POST):

	include "../config.php";
	include "../library/functions.php";

	// Get file details
	$file = $_POST['file'];
	$path_info = pathinfo($file);
	$ext = strtolower($path_info['extension']);
	$name = preg_replace("#\." . $ext . "$#i", "", $file);	
	
	// Get locations
	$current_path = $_POST['current_path'];
	$original = "$home_folder/$current_path/$file";
	$thumbnail = "$home_folder/$index_folder/thumbs/$current_path/$name.jpg";
	
	// Check if thumb exists or is old
	if (!is_file($thumbnail)
	or filemtime($original) > filemtime($thumbnail)):
				
		if ($ext == "jpg"
		or $ext == "jpeg"
		or $ext == "gif"
		or $ext == "png"):
	
			$image_stats = GetImageSize($original); 
			$org_w = $image_stats[0]; 
			$org_h = $image_stats[1];
		
			if ($org_w > $org_h):
				$new_w = 250; 
				$new_h = floor ($new_w * $org_h / $org_w);
			else:
				$new_h = 250; 
				$new_w = floor ($new_h * $org_w / $org_h);
			endif;
			
			// Grab graphics from original file
			if ($ext == "jpg" or $ext == "jpeg"): $src_img = imagecreatefromjpeg($original);
			elseif ($ext == "gif"): $src_img = imagecreatefromgif($original); 
			elseif ($ext == "png"): $src_img = imagecreatefrompng($original); 
			elseif ($ext == "psd"):
				include_once('includes/classPhpPsdReader.php');
				$src_img = imagecreatefrompsd($original);
			else:
				echo "no extension";
			endif;
			
			// Create new image
			$dst_img = imagecreatetruecolor($new_w, $new_h); 
			imagecopyresampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img)); 
			imagejpeg($dst_img, $thumbnail, 80); 
			imagedestroy($dst_img); 
			imagedestroy($src_img);
		
		endif;
		
	endif;
	
	respond("success", "$name.jpg");
			
endif;

?>