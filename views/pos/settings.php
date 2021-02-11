<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div id="pos_page" class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin">
                                    <?php echo htmlspecialchars($title); ?>
                                </h4>
                                <hr class="hr-panel-heading"/>
                                <?php echo form_open_multipart(admin_url('products/pos/update_settings'), ['id' => 'pos_settings_form']); ?>
                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip"
                                   data-title="<?php echo _l('currency'); ?>"></i>
                                <?php echo render_input('currency', _l('currency'), $settings->currency ?? '', 'text'); ?>
                                <hr/>
                                <div class="form-group">
                                    <label for="is_keyboard_active" class="control-label clearfix">
                                        <i class="fa fa-question-circle pull-left" data-toggle="tooltip"
                                           data-title="<?php echo _l('keyboard_active'); ?>"></i>
                                        <?php echo _l('keyboard_active') ?>
                                    </label>
                                    <div class="radio radio-primary radio-inline">
                                        <input type="radio" id="y_opt_1_is_keyboard_active" name="is_keyboard_active"
                                               value="1" <?php if ($settings->is_keyboard_active == 1) {
                                            echo 'checked';
                                        } ?>>
                                        <label for="y_opt_1_is_keyboard_active">
                                            <?php echo _l('settings_yes') ?>
                                        </label>
                                    </div>
                                    <div class="radio radio-primary radio-inline">
                                        <input type="radio" id="y_opt_2_is_keyboard_active" name="is_keyboard_active"
                                               value="0" <?php if ($settings->is_keyboard_active == 0) {
                                            echo 'checked';
                                        } ?>>
                                        <label for="y_opt_2_is_keyboard_active">
                                            <?php echo _l('settings_no'); ?>
                                        </label>
                                    </div>
                                </div>
                                <hr/>
                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip"
                                   data-title="<?php echo _l('tax_rate'); ?>"></i>
                                <?php echo render_input('tax_rate', _l('tax_rate'), $settings->tax_rate ?? '', 'number'); ?>

                                <hr/>
                                <h4>Сотрудники</h4>

                                <table class="table">
                                    <thead>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Имя</th>
                                    <th>Филиал</th>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($staffs as $staff) { ?>
                                        <tr>
                                            <td><?php echo $staff['staffid'] ?></td>
                                            <td>
                                                <?php echo staff_profile_image($staff["staffid"], ['staff-profile-image-small']) ?>
                                            </td>
                                            <td><?php echo $staff['full_name'] ?></td>
                                            <td>
                                                <?php echo render_select('branch[' . $staff['staffid'] . ']', $branches, ['id', 'name'], '', $staff['pos_branch_id']) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>

                                <button type="submit"
                                        class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>
