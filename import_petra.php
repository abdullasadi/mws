<?php
require_once('inc/middleware.php');

$petra = new PetraApi;

if(Config::get('base.request_method') == 'POST') {
  $ids = $_POST['checkbox'];
  foreach ($ids as $id) {
    $petra->importData($id);
  }

  header('location:import_petra.php?token=' . Config::get('csrf_token'));
}

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
          <button class="btn btn-primary mr-2 petra">Import</button>
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
                <form class="petraForm" action="import_petra.php" method="post">
                  <table class="table table-hover table-bordered mb-0">
                    <thead>
                      <tr>
                        <th>
                          <input id="selectAll" type="checkbox">
                        </th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th class="text-nowrap">Action</th>
                      </tr>
                    </thead>
                      <input type="hidden" name="token" value="<?php echo Config::get('csrf_token'); ?>">
                      <tbody class="product-tr">

                      </tbody>
                  </table>
                </form>
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
  (function() {
     $('.product-tr').append(`
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
       contex: this,
       data: {
         'token': '<?php echo Config::get('csrf_token'); ?>',
         'type': 'petra_data',
         'start': 1
       }
     }).done(function(results) {
       // console.log(results);
       $('.product-tr').empty();
       for(let product of results.products) {
         let checkboxHtml;
         let importButton;
         if(product.pt_returnable == 'Y' && product.pt_refurbish == 'N') {
           checkboxHtml = `<td>
             <input id="checkbox1" class="selectAll" type="checkbox" name="checkbox[]" value="${ product.pt_id }">
           </td>`;
           importButton = `<td class="text-nowrap">
             <button data-id="${ product.pt_id }" class="btn btn-info btn-outline btn-icon right-icon import-btn"><span>Import</span><i class="fa fa-cloud-upload"></i></button>
           </td>`
         } else {
           checkboxHtml = `<td></td>`;
           importButton = `<td class="text-nowrap"></td>`
         }
         $('.product-tr').append(`<tr>
           ${checkboxHtml}
           <td class="product-img-td">
             <img class="product-table-img" src="${product.pt_image}" alt="">
           </td>
           <td>${product.pt_name}</td>
           <td>$${product.pt_cost_price}</td>
           <td>${product.pt_brand}</td>
           <td>${product.pt_qty}</td>
           ${importButton}
         </tr>`);
       }

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
     });

  })();

  $( document ).on('click', '.pagination-btn',function() {
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
        'type': 'petra_data',
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
        let checkboxHtml;
        let importButton;
        if(product.pt_returnable == 'Y' && product.pt_refurbish == 'N') {
          checkboxHtml = `<td>
            <input id="checkbox1" class="selectAll" type="checkbox" name="checkbox[]" value="${ product.pt_id }">
          </td>`;
          importButton = `<td class="text-nowrap">
            <button data-id="${ product.pt_id }" class="btn btn-info btn-outline btn-icon right-icon import-btn"><span>Import</span><i class="fa fa-cloud-upload"></i></button>
          </td>`
        } else {
          checkboxHtml = `<td></td>`;
          importButton = `<td class="text-nowrap"></td>`
        }
        $('.product-tr').append(`
          <tr>
            ${checkboxHtml}
            <td class="product-img-td">
              <img class="product-table-img" src="${product.pt_image}" alt="">
            </td>
            <td>${product.pt_name}</td>
            <td>$${product.pt_cost_price}</td>
            <td>${product.pt_brand}</td>
            <td>${product.pt_qty}</td>
            <td class="text-nowrap">
              <button data-id="${ product.pt_id }" class="btn btn-info btn-outline btn-icon right-icon import-btn"><span>Import</span><i class="fa fa-cloud-upload"></i></button>
            </td>
          </tr>
        `);
      }
    });
  })



  $('#selectAll').on('click',function(){
        if(this.checked){
            $('.selectAll').each(function(){
                this.checked = true;
            });
        }else{
             $('.selectAll').each(function(){
                this.checked = false;
            });
        }
    });


    // Import Button click
    $(document).on('click', '.petra', function() {
      $('.petraForm').submit();
    });



</script>

<?php

require('inc/footer.php');

?>
