<?php 
class Toast{
	
		
	
	public static function set_toast($status,$head,$msg){
		$data = array('status'=>$status,'head'=>$head,'msg'=>$msg);
		$_SESSION['notify'] = $data;		
		return false;
	}
	
	private static function set_toast_value($path = null){
		if($path && isset($_SESSION['notify'])){
			$config = $_SESSION;	
			$path = explode('/',$path);	
			
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}	
			}
			
			return $config;
		}
		
		return false;
	}
	
	
	public static function get(){
		$notify['status'] = Toast::set_toast_value('notify/status');
		$notify['head'] = Toast::set_toast_value('notify/head');
		$notify['text'] = Toast::set_toast_value('notify/msg');
		$_SESSION['notify'] = false;
		return $notify;
	}



}
?>