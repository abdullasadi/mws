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
        <h5 class="txt-dark">Import From Dvr</h5>
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

<script type="text/javascript">

  $(document).on('click', '.dvr', function() {
    $('.product-tr').html(`
      <tr class="center">
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
      </tr>
      `);
    $.ajax({
      url: "ajax_request.php",
      type: 'POST',
      dataType: 'json',
      data: {
        'token': '<?php echo Config::get('csrf_token'); ?>',
        'type': 'dvr_action',
        'start': 1
      }
    }).done(function(results) {
      $('.product-tr').empty();
      var total = results.totalCount;
      var perPage = Math.ceil(total / 100);
      // pagination
      for(var i = 1; i <= perPage; i++) {
        if(i == 1) {
          $('.table-pagination').append(`
            <button data-start=${i} type="button" class="btn btn-info pagination-btn">${i}</button>
          `)
        } else {
          $('.table-pagination').append(`
            <button data-start=${i} type="button" class="btn btn-default btn-outline pagination-btn">${i}</button>
          `)
        }
      }
      // Table
      for(let product of results.products) {
        $('.product-tr').append(`
          <tr>
            <td class="product-img-td">
              <img class="product-table-img" src="https://dvrunlimited.com/image/${product.image}" alt="">
            </td>
            <td>${product.name}</td>
            <td>$${product.price}</td>
            <td>${product.model}</td>
            <td>${product.quantity}</td>
            <td class="text-nowrap">
              <button data-id="${ product.product_id }" class="btn btn-info btn-outline btn-icon right-icon import-btn"><span>Import</span><i class="fa fa-cloud-upload"></i></button>
            </td>
          </tr>
        `)
      }
    });
  });


  // On click Pagination
  $(document).on('click', '.pagination-btn', function() {
    $('.table-pagination').empty();
    $('.product-tr').empty();
    $('.product-tr').html(`
      <tr class="center">
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
        <td>
          <i class="fa fa-spin fa-spinner"></i>
        </td>
      </tr>
      `);
    let start = $(this).attr('data-start');
    $.ajax({
      url: "ajax_request.php",
      type: 'POST',
      dataType: 'json',
      contex: this,
      data: {
        'token': '<?php echo Config::get('csrf_token'); ?>',
        'type': 'dvr_action',
        'start': start
      }
    }).done(function(results) {
      $('.product-tr').empty();
      var total = results.totalCount;
      var perPage = Math.ceil(total / 100);
      // pagination
      for(var i = 1; i <= perPage; i++) {
        if(start == i) {
          $('.table-pagination').append(`
            <button data-start=${i} type="button" class="btn btn-info pagination-btn">${i}</button>
          `)
        } else {
          $('.table-pagination').append(`
            <button data-start=${i} type="button" class="btn btn-default btn-outline pagination-btn">${i}</button>
          `)
        }
      }
      // Table
      for(let product of results.products) {
        $('.product-tr').append(`
          <tr>
            <td class="product-img-td">
              <img class="product-table-img" src="https://dvrunlimited.com/image/${product.image}" alt="">
            </td>
            <td>${product.name}</td>
            <td>$${product.price}</td>
            <td>${product.model}</td>
            <td>${product.quantity}</td>
            <td class="text-nowrap">
              <button data-id="${ product.product_id }" class="btn btn-info btn-outline btn-icon right-icon import-btn"><span>Import</span><i class="fa fa-cloud-upload"></i></button>
            </td>
          </tr>
        `)
      }
    });
  });
  // end click Pagination

  $(document).on('click', '.import-btn', function() {
    let p_id = $(this).attr('data-id');
    $.ajax({
      url: "ajax_request.php",
      type: 'POST',
      dataType: 'json',
      contex: this,
      data: {
        'token': '<?php echo Config::get('csrf_token'); ?>',
        'type': 'dvr_import',
        'p_id': p_id
      }
    }).done(function(results) {
      //console.log(results);
      $.toast({
    		heading: results.head,
    		text: results.message,
    		position: 'top-right',
    		loaderBg:'#fec107',
    		icon: results.status,
    		hideAfter: 3500,
    		stack: 6
    	});

    });


  });

</script>



<?php

require('inc/footer.php');

?>
