<?php
// require_once('inc/middleware.php');



require('inc/header.php');
require('inc/navbar.php');
?>

<div class="page-wrapper">
  <div class="container-fluid">
    <!-- Title -->
    <div class="row heading-bg">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h5 class="txt-dark">Products Table</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
        <li><a href="index.html">Dashboard</a></li>
        <li><a href="#"><span>table</span></a></li>
        <li class="active"><span>basic table</span></li>
        </ol>
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
                        <th>Status</th>
                        <th class="text-nowrap">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="product-img-td">
                          <img class="product-table-img" src="http://via.placeholder.com/150x150" alt="">
                        </td>
                        <td>Lunar probe project</td>
                        <td>124$</td>
                        <td>May 15, 2015</td>
                        <td>In Stock</td>
                        <td class="text-nowrap"><a href="#" class="mr-25" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a> <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
require('inc/footer.php');

?>