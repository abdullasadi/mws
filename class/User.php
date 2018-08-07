<?php
	class User extends Db{


	public function login($un,$pw){
			$pw = md5($pw);
			$this->query = $this->handeller->query("SELECT * FROM `users` WHERE (email = '$un' AND password = '$pw')");
			$row = $this->query->rowCount();

				if($row > 0){
					$this->data = array($this->user_session_id(),$this->user_agent(),$this->user_ip(),1,$un,$pw);

					$this->query2 = $this->handeller->prepare("UPDATE `users` SET user_session_id = ?, user_agent = ?, user_ip = ?, stage = ? WHERE (email = ? AND password = ?)");
					$this->query2->execute($this->data);

					$this->query3 = $this->handeller->query("SELECT * FROM `users` WHERE (email = '$un' AND password = '$pw')");
					$row = $this->query3->fetch(PDO::FETCH_ASSOC);
					$_SESSION['admin'] = $row;
					Toast::set_toast('success','Login Success!','Welcome! '.$row['f_name'].' '.$row['l_name']);
					$this->url_return(array('index.php',$this->secure_token($row['user_session_id'])));
					}else{
						Toast::set_toast('error','Invalid Access!','Please check your email or password');
						$this->url_return(array('login.php'));
						}
			}

		public function check_login(){
			if(!isset($_SESSION['admin'])){
				Toast::set_toast('error','Access Denied!','Please Login to continue!!');
				return $this->url_return(array('login.php'));
				}
			}

		public function check_token($tkn){
			if($tkn != md5($_COOKIE["PHPSESSID"])){
				session_destroy();
				session_unset();
				Toast::set_toast('error','Access Denied!','Invalid Admin token!!');
				return $this->url_return(array('login.php'));
				}
			}


		public function log_out(){
			if((isset($_GET['log-out'])) && ($_GET['log-out'] == 'true') && ($_GET['token'] == $this->secure_token($_COOKIE['PHPSESSID']))){
				session_destroy();
				session_unset();
				Toast::set_toast('error','Loged Out','Invalid Admin token!!');
				return $this->url_return(array('login.php'));
				}
		}

		public function admin_data($data){
			$this->data = $_SESSION['admin'];
			return $this->data[$data];
			}



	}

	?>
