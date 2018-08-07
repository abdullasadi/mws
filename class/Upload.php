<?php 
class Upload{
	
	public static function image($img = null){
		if($img){
			if ((($_FILES[$img]["type"] == "image/gif")
			|| ($_FILES[$img]["type"] == "image/jpeg")
			|| ($_FILES[$img]["type"] == "image/jpg")
			|| ($_FILES[$img]["type"] == "image/pjpeg")
			|| ($_FILES[$img]["type"] == "image/x-png")
			|| ($_FILES[$img]["type"] == "image/png"))
			&& ($_FILES[$img]["size"] < 2000000))
			  {
			  if ($_FILES[$img]["error"] > 0)
				{
				$error = 10;
				return $error;
				}
			  else
				{
				$rnd = rand(0,99999);		
				if (file_exists('image/'. $_FILES[$img]["name"]))
				  {
				      move_uploaded_file($_FILES[$img]["tmp_name"],'image/'. $rnd. $_FILES[$img]["name"]);
					  return 'image/'. $rnd . $_FILES[$img]["name"];
					  
				  }
				else
				  {
					  move_uploaded_file($_FILES[$img]["tmp_name"],'image/'. $_FILES[$img]["name"]);
					  return 'image/'. $_FILES[$img]["name"];
				  }
				}
			  }
			else
			  {
			 $error = 10;
			  return $error;
			  }
			}
		
		return false;
	}


}		
?>