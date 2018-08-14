<?php
class Products extends Db {
  public function getProducts() {
    $products = array();
    $productsQry = $this->handeller->query("SELECT * FROM `products`");
    $rows = $productsQry->fetchAll(PDO::FETCH_ASSOC);

    foreach($rows as $row){
      $p = [
        'model' => $row['p_model']
      ];
      array_push($products, $p);
    }

    return $products;
  }
}
