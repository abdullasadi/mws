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

    $ch = curl_init('http://hitechwebdesign.net:5000/Maruf/77b55e1c91cc0daf73662d4b2dac7ec5b0344e90/'.$start);
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
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_encode($response);
    $response = json_decode($response, true);
    // if($response['status'] == '200' && isset($response['products'])) {
    //   echo '{"status": "success", "message": "data found"}';
    // } else {
    //   echo '{"status": "error", "message": "data not found"}';
    // }
    print_r($response);
  }
}





























// asfda
