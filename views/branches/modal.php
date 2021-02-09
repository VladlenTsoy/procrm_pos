<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="branch_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l('edit_branch_heading'); ?></span>
                    <span class="add-title"><?php echo _l('new_branch_heading'); ?></span>
                </h4>
            </div>
            <?php echo form_open('products/branches/branch', ['id'=>'branch-modal-form']); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('branch_name', 'branch_name'); ?>
                        <?php echo render_textarea('branch_address', 'branch_address'); ?>
                        <?php echo form_hidden('branch_id'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo module_dir_url('products','assets/js/modals.js') ?>"></script>
