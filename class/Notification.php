<?php 
class Notification extends Db{
		
	
	public function create($notify_name,$notify_text,$priority,$user_id,$n_status){
		$sql = $this->handeller->query("INSERT INTO `notification` (`n_name`, `n_text`, `n_priority`, `n_u_id`, `n_status`,`n_time`) VALUES ('$notify_name', '$notify_text', '$priority', '$user_id', '$n_status',NOW())");
		return $sql;
	}
	
	
	public function unseen_count(){
		$user_id = $_SESSION['admin']['u_id'];
		$sql = $this->handeller->query("SELECT * FROM notification WHERE n_u_id='$user_id' AND n_status='0'");
		$row = $sql->rowCount();
		return $row;
		}
		
		
		
	
	public function unseen_list(){
		$user_id = $_SESSION['admin']['u_id'];
		$sql = $this->handeller->query("SELECT * FROM notification WHERE n_u_id='$user_id' AND n_status='0' ORDER BY n_id DESC");
		return $sql;
		}
		
	public function seen_list(){
		$user_id = $_SESSION['admin']['u_id'];
		$sql = $this->handeller->query("SELECT * FROM notification WHERE n_u_id='$user_id' AND n_status='1' ORDER BY n_id DESC");
		return $sql;
		}	
		
		
	public function make_viewed(){
		$user_id = $_SESSION['admin']['u_id'];
		$sql = $this->handeller->query("UPDATE notification SET n_status='1'  WHERE n_u_id='$user_id' AND n_status='0'");
		return $sql;
		}
	


}
?>