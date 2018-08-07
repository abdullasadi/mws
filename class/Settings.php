<?php 
class Settings extends Db{
		
	
		
		
	public function get_amazon_prime_account($key){
		$user_id = $_SESSION['admin']['u_id'];
		$sql = $this->handeller->query("SELECT * FROM amazon_account WHERE user_id='$user_id'");
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		return $row[$key];
		}
		
		
	public function save_amazon_prime_account($email,$pass,$id){
		$sql = $this->handeller->query("UPDATE amazon_account SET email='$email', password='$pass' WHERE id='$id'");		
		return $sql;
		}
		
		
	public function get_amazon_update_process($key){
		$sql = $this->handeller->query("SELECT * FROM `update-process`");		
		$row = $sql->fetch(PDO::FETCH_ASSOC);
		return $row[$key];
		}

}
?>