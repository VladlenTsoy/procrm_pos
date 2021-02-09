<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s " id="TableData">
          <div class="panel-body">
            <?php if (has_permission('products', '', 'create')) { ?>
            <a href="<?php echo admin_url('products/add_product'); ?>" class="btn btn-info pull-left display-block">
              <?php echo _l('new_product'); ?>
            </a>
            <?php } ?>
          </div>  
        </div>
        <div class="row">
          <div class="col-md-12" id="panel">
           <div class="panel_s">
              <div class="panel-body">
                <?php
                $table_data = [
                    _l('name'),
                    _l('image'),
                    _l('barcode'),
                    _l('description'),
                    _l('price'),
                    _l('quantity'),
                    _l('branch'),
                    _l('category'),
                    _l('subcategory'),
                  ];
                  render_datatable($table_data, ($class ?? 'products')); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <?php init_tail(); ?>
<script type="text/javascript">
  $(function(){
    initDataTable('.table-products', window.location.href,'undefined','undefined','');
  });     
</script>
