<?php
require_once('inc/middleware.php');



require('inc/header.php');
require('inc/navbar.php');

?>

<div class="page-wrapper">
  <div class="container-fluid">
    <!-- Title -->
    <div class="row heading-bg">
      <div class="col-md-6">
        <h5 class="txt-dark">Import From Petra</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-md-6">
        <div class="d-flex-justify-end">
          <button class="btn  btn-primary mr-2 dvr">Import</button>
        </div>
      </div>
      <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->
    <div class="row">

      <!-- Bordered Table -->
      <div class="col-sm-12">
        <div class="panel panel-default card-view">
          <div class="panel-wrapper collapse in">
            <div class="panel-body">
              <div class="table-wrap mt-40">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Model</th>
                        <th>Quantity</th>
                        <th class="text-nowrap">Action</th>
                      </tr>
                    </thead>
                    <tbody class="product-tr">

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="btn-group mt-4 pull-right table-pagination">

							</div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Bordered Table -->

    </div>
  </div>
</div>

<?php
  require('inc/scripts.php');
?>


<?php

require('inc/footer.php');

?>
