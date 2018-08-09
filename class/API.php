<?php
/**
 *
 */
class API extends Db {

  private $api_key;
  private $api_secret;

  function __construct() {
    $this->api_key = 'Maruf';
    $this->api_secret = '77b55e1c91cc0daf73662d4b2dac7ec5b0344e90';
  }

  public function dvr_api($start) {
    $post = [
        'api_key' => $this->api_key,
        'api_secret' => $this->api_secret,
    ];

    $ch = curl_init('http://hitechwebdesign.net:5000/products/Maruf/77b55e1c91cc0daf73662d4b2dac7ec5b0344e90/'.$start);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
  }


  public function dvr_import($id) {
    $post = [
        'api_key' => $this->api_key,
        'api_secret' => $this->api_secret,
    ];

    $ch = curl_init('hitechwebdesign.net:5000/product/Maruf/77b55e1c91cc0daf73662d4b2dac7ec5b0344e90/'.$id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    // $response = json_encode($response);
    $response = json_decode($response, true);

    if($response['status'] == '200' && is_array($response['product'])) {
      $db = new Db;
      $product = $response['product'];
      $model = $product['model'];

      $searchqry = $db->handeller->query("SELECT * FROM `products` WHERE model='$model'");
      $s_count = $searchqry->rowCount();

      if($s_count > 0) {
        echo '{"status": "error", "message": "Product already in the system", "head": "Import Error"}';
      } else {
        echo '{"status": "success", "message": "Data has been imported", "head": "Import Success"}';
      }

    } else {
      echo '{"status": "error", "message": "Error while importing data", "head": "Import Error"}';
    }


  }
}





























// asfda
