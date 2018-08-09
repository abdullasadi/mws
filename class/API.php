<?php
/**
 *
 */
class API extends Db{

  private $api_key;
  private $api_secret;

  public function dvr_api($start) {
    $post = [
        'api_key' => 'Maruf',
        'api_secret' => '77b55e1c91cc0daf73662d4b2dac7ec5b0344e90',
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
        'api_key' => 'Maruf',
        'api_secret' => '77b55e1c91cc0daf73662d4b2dac7ec5b0344e90',
    ];

    $ch = curl_init('hitechwebdesign.net:5000/product/Maruf/77b55e1c91cc0daf73662d4b2dac7ec5b0344e90/'.$id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    // $response = json_encode($response);
    $response = json_decode($response, true);

    if($response['status'] == '200' && is_array($response['product'])) {
      $product = $response['product'];
      $model = $product['model'];

      $s_qry = $this->handeller->query("SELECT * FROM `products` WHERE p_model='$model'");
      $s_count = $s_qry->rowCount();

      if($s_count > 0) {
        echo '{"status": "error", "message": "Product already in the system", "head": "Import Error"}';
      } else {
        $add_qry = $this->handeller->query("INSERT INTO products SET p_source = 'security', p_title = '$product[name]', p_fulldes = '$product[description]', p_images = '$product[image]', p_cost_price = '', p_lowest_range = '', p_profit = '', p_ean = '$product[ean]', p_upc = '$product[upc]', p_model = '$product[model]', p_mpn = '$product[mpn]', p_dem = '', p_weight = '$product[weight]', p_brand = '', p_marketid = '', p_marketurl = '', p_self_id = '', p_self_url = '', p_qty = '$product[quantity]', p_rank = '', p_saleprice = '', p_batch_id = '', p_amazon_status = '', p_status = '', time = ''");

        if($add_qry) {
          echo '{"status": "success", "message": "Data has been imported", "head": "Import Success"}';
        } else {
          echo '{"status": "error", "message": "Product already in the system", "head": "Import Error"}';
        }
      }

    } else {
      echo '{"status": "error", "message": "Error while importing data", "head": "Import Error"}';
    }


  }
}





























// asfda
