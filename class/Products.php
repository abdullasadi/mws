<?php
class Products extends Db {
  public function getProducts() {
    $products = array();
    $productsQry = $this->handeller->query("SELECT * FROM `products`");
    $rows = $productsQry->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row){
      $p = [
        'name' =>  $row['p_title'],
        'image' => $row['p_image'],
        'price' => $row['p_saleprice'],
        'cost_price' => $row['p_cost_price'],
        'model' => $row['p_model']
      ];
      array_push($products, $p);
    }

    echo json_encode($products);
  }
}
