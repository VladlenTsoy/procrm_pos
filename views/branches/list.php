<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                     <div class="_buttons">
                        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#branch_modal"><?php echo _l('new_branch'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                    <hr class="hr-panel-heading" />
                    <div class="clearfix"></div>
                    <?php render_datatable([
                        _l('branch_name'),
                        _l('branch_address'),
                        _l('options'),
                        ], 'product-branch'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('products/branches/modal'); ?>
<?php init_tail(); ?>
<script>
   $(function(){
        initDataTable('.table-product-branch', window.location.href, [1], [1]);
   });
</script>
</body>
</html>
