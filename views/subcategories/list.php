<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#subcategory_modal"><?php echo _l('new_subcategory'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable([
                        _l('subcategory_name'),
                        _l('subcategory_description'),
                        _l('category'),
                        _l('options'),
                        ], 'product-subcategory'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('products/subcategories/modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-product-subcategory', window.location.href, [1], [1]);
   });
</script>
</body>
</html>
