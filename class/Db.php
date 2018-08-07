<?php
class Db extends PDO{
	public $handeller;
	public $query;
	public $arrays;
	public $arrays2;
	public $arrays3;
	public $query2;
	public $query3;
	public $loged;

	private $user_ip;
	private $user_session_id;
	private $user_agent;

	protected $data;
	protected $error;


	/*-------------- End Proparty Area -------------*/

	/*-------------- Methodes Area -------------*/

	public function __construct(){
		$host = Config::get('mysql.host');
		$user = Config::get('mysql.user');
		$pass = Config::get('mysql.pass');
		$db = Config::get('mysql.db');
			try{
				$this->handeller = new PDO("mysql:host={$host}; dbname={$db}", $user, $pass);
				$this->handeller->getAttribute(PDO::ATTR_ERRMODE);
				}catch(PDOException $e){
					die($e);
					}


		}



		public function url_return(array $a){
			$this->data = header('location:'.$a[0].'?token='.$a[1]);
			return $this->data;
			}

		public function url_returns(array $a){
			$this->data = header('location:'.$a[0].'?msg='.$a[1].'&type='.$a[2].'&token='.$a[3]);
			return $this->data;
			}

		public function fontendurl_return(array $a){
			$this->data = header('location:'.$a[0].'?msg='.$a[1]);
			return $this->data;
			}

		protected function user_ip(){
			$this->data = $_SERVER['REMOTE_ADDR'];
			return $this->data;
			}

		protected function user_session_id(){
			$this->data = $_COOKIE["PHPSESSID"];
			return $this->data;
			}

		protected function user_agent(){
			$this->data = $_SERVER['HTTP_USER_AGENT'];
			return $this->data;
			}

		public function secure_token($tk){
			$this->data = md5($tk);
			return $this->data;
			}




	public function get_clean_url($str) {
		$this->arrays = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
		$this->arrays= strtolower(trim($this->arrays, '-'));
		$this->arrays = preg_replace("/[\/_|+ -]+/", '-', $this->arrays);
		return $this->arrays;
		}


	public static function email_temp($to,$sms,$sub){
			$message = $sms;
			$headers = "From: Real Estate \r\n" .
		   'Reply-To: '. $_['base_url']. "\r\n" .
		   'X-Mailer: PHP/' . phpversion();
			$message = wordwrap($message, 70, "\r\n");
			mail($to, $subject, $message, $headers);
	}


}
?>
