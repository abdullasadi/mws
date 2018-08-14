<?php

class PetraApi extends Db {
  public function ImportCSV2Array($filename){
    $row = 0;
    $col = 0;
    $count = 0;

    $handle = @fopen($filename, "r");
    if ($handle){
        while (($row = fgetcsv($handle, 4096)) !== false){

            if($count > 1){
              if (empty($fields)){
                  $fields = $row;
                  continue;
              }

              foreach ($row as $k=>$value){
                  $results[$col][$fields[$k]] = $value;
              }

            }
            $col++;
            $count++;
            unset($row);

        }

        if (!feof($handle)){
            echo "Error: unexpected fgets() failn";
        }
        fclose($handle);
    }

    return $results;
  }

  public function petraClient() {
    ignore_user_abort(true);
    set_time_limit(0);
    unlink('files/data.csv');
    $login_url = "https://prod.petra.com/index.php/index/login";
    $csv_url = "https://prod.petra.com/index.php/index/download";
    $username = 'dvrunlimited@yahoo.com';
    $password = 'Jasmine!@#1';

    $postinfo = "username=".$username."&password=".$password;




    $dir = $_SERVER['DOCUMENT_ROOT']."/coockies";
    $cookie_file_path = $dir."/cookie.txt";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $login_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    curl_exec($ch);
    curl_setopt($ch, CURLOPT_URL, $csv_url);
    $csv = curl_exec($ch);
    curl_close($ch);


   file_put_contents('files/data.csv', $csv);





    $prods = $this->ImportCSV2Array('files/data.csv');

    foreach($prods as $row){
    	 	$sku = $row['PETRA SKU'];
    		$seller_sku = $row['VENDOR SKU'];
    		$name = $row['DESCRIPTION'];
    		$upc = $row['UPC'];
    		$description = $row['LONG DESC'];
    		$brand = $row['BRAND NAME'];
        $cost_price = $row['PRICE'];
    		$qty = $row['AVAILABLE'];
    		$category = $row['PRODUCT CLASS'];
    		$weight = $row['ESTIMATED SHIP WEIGHT'];
    		$lenth = $row['LENGTH'];
    		$width = $row['WIDTH'];
    		$height = $row['HEIGHT'];
    		$returnable = $row['RETURNABLE'];
    		$refurbish = $row['REFURB'];
    		$image = $row['IMAGE URL'];
        $bullets = $row['SPECS'];



        $add_qry = $this->handeller->query("INSERT INTO `petra_products` (`pt_sku`, `pt_seller_sku`, `pt_name`, `pt_upc`, `pt_description`, `pt_brand`, `pt_cost_price`, `pt_qty`, `pt_category`, `pt_weight`, `pt_lenth`, `pt_width`, `pt_height`, `pt_returnable`, `pt_refurbish`, `pt_image`, `pt_bullet1`, `pt_bullet2`, `pt_bullet3`, `pt_bullet4`, `status`) VALUES ('$sku', '$seller_sku', '$name', '$upc', '$description', '$brand', '$cost_price', '$qty', '$category', '$weight', '$lenth', '$width', '$height', '$returnable', '$refurbish', '$image', '$bullets', '0', '0', '0', '1')");
  		}
  }

  // public function petra_data($id) {
  //   $post = [
  //       'api_key' => 'Maruf',
  //       'api_secret' => '77b55e1c91cc0daf73662d4b2dac7ec5b0344e90',
  //   ];
  //
  //   $ch = curl_init('hitechwebdesign.net:5000/petra_products/Maruf/77b55e1c91cc0daf73662d4b2dac7ec5b0344e90/'.$id);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  //   $response = curl_exec($ch);
  //   curl_close($ch);
  //   // $response = json_encode($response);
  //   echo $response;
  // }

  public function get_data($start) {
    $products = array();
    $totalQry = $this->handeller->query("SELECT * FROM `petra_products` WHERE pt_sku NOT IN (SELECT p_model FROM products)");
    $totalCount = $totalQry->rowCount();
    $qry = $this->handeller->query("SELECT * FROM `petra_products` WHERE pt_sku NOT IN (SELECT p_model FROM products) ORDER BY pt_id ASC LIMIT $start, 100");
    $rows = $qry->fetchAll(PDO::FETCH_ASSOC);
    foreach($rows as $row){
      $p = [
        'pt_id' => $row['pt_id'],
        'pt_name' => $row['pt_name'],
        'pt_image' => $row['pt_image'],
        'pt_cost_price' => $row['pt_cost_price'],
        'pt_brand' => $row['pt_brand'],
        'pt_qty' => $row['pt_qty'],
        'pt_returnable' => $row['pt_returnable'],
        'pt_refurbish' => $row['pt_refurbish']
      ];
      array_push($products, $p);
    }
    $response = [
      'status' => '200',
      'totalCount' => $totalCount,
      'products' => $products,
    ];
    echo json_encode($response);
  }

  public function importData($id) {
    $queryData = $this->handeller->query("SELECT * FROM `petra_products` WHERE pt_id = '$id'");
    $row = $queryData->fetch(PDO::FETCH_ASSOC);

    $name = $row['pt_description'];
    $sku = $row['pt_sku'];
    $upc = $row['pt_upc'];
    $desc = '';
    $brand = $row['pt_brand'];
    $cost_price = $row['pt_cost_price'];
    $weight = $row['pt_weight'];
    $height = $row['pt_height'];
    $lenth = $row['pt_lenth'];
    $width = $row['pt_width'];
    $category = $row['pt_category'];
    $image = $row['pt_image'];
    $qty = $row['pt_qty'];

    $name = str_replace('(TM)', '', $name);
    $name = str_replace('(R)', '', $name);
    $name = str_replace('GOPRO', '', $name);
    $desc = $name;

    $brand = str_replace('(TM)', '', $brand);
    $brand = str_replace('(R)', '', $brand);
    $brand = str_replace('GOPRO', '', $brand);


    if($row['pt_cost_price'] <= '10'){
			$price = (((50/100) * $row['pt_cost_price']) + $row['pt_cost_price'])+7;
		}elseif($row['pt_cost_price'] >= '11' && $row['pt_cost_price'] <= '30'){
			$price = (((30/100) * $row['pt_cost_price']) + $row['pt_cost_price'])+7;
		}elseif($row['pt_cost_price'] >= '31' && $row['pt_cost_price'] <= '60'){
			$price = (((20/100) * $row['pt_cost_price']) + $row['pt_cost_price'])+7;
		}else{
			$price = (((20/100) * $row['pt_cost_price']) + $row['pt_cost_price'])+7;
		}

    if($weight > '5'){
			$price = $price + 10;
		}

    if($category === 'Appliance Accessories, Tools & RTO'){
  		$cats = "appliance-replacement-parts";
		}elseif($category === 'Automotive, Marine & GPS'){
			$cats = "vehicle-electronics";
		}elseif($category === 'Cell Phones & Accessories '){
			$cats = "cell-phone-accessories";
		}elseif($category === 'Computer Peripherals & Home Office'){
			$cats = "computer-and-mobile-device-repair-kits";
		}elseif($category === 'Home Theater & Custom Install'){
			$cats = "audio-video-cables-and-connectors";
		}elseif($category === 'Housewares & Personal Care'){
			$cats = "handheld-personal-digital-assistants";
		}elseif($category === 'Outdoor, Recreation & Fitness'){
			$cats = "handheld-personal-digital-assistants";
		}elseif($category === 'Portable & Personal Electronics'){
			$cats = "handheld-personal-digital-assistants";
		}else{
			$cats = "audio-video-cables-and-connectors";
		}

    if($weight <= '10' && $lenth <= '23' && $height <= '23' && $width <= '23' && $row['pt_returnable'] == 'Y' && $row['pt_refurbish'] == 'N') {
      $addData = $this->handeller->query("INSERT INTO `products` (`p_source`, `p_title`, `p_fulldes`, `p_image`, `p_category`, `p_cost_price`, `p_lowest_range`, `p_profit`, `p_ean`, `p_upc`, `p_model`, `p_mpn`, `p_length`, `p_width`, `p_height`, `p_weight`, `p_brand`, `p_self_id`, `p_qty`, `p_saleprice`, `p_batch_id`, `p_amazon_status`, `p_status`, `time`) VALUES ('petra', '$name', '$desc', '$image', '$cats', '$cost_price', '', '', '', '$upc', '$sku', '', '$lenth', '$width', '$height', '$width', '$brand', '', '$qty', '$price', '', '', '', NOW())");
    }
  }
}
