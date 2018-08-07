<?php 
class Filter{
	
			
	
	public static function remove_text($name,$text){
		$db = new Db;
		$text = self::encode($text);
		$sql = $db->handeller->query("SELECT * FROM filter WHERE name='$name'");
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		$text = str_replace($row['text'],'',$text);		
		return $text;
	}
	
	
	public static function replace($find,$replace,$soures){		
		$text = str_replace($find,$replace,$soures);		
		return $text;
	}
	
	
	public static function replace_temp($find,$replace,$soures){		
		$text = str_replace($find,Self::encode($replace),$soures);		
		return $text;
	}
	
	
	
	public static function encode($text){
		$text = htmlentities($text,ENT_QUOTES);
		return $text;
	}
	



}
?>