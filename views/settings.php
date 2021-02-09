<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('currency'); ?>"></i>
        <?php echo render_input('settings[currency]', 'Currency', get_option('currency'), 'text', ['required'=>true]); ?>
        <hr />
        <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('Keyboard active'); ?>"></i>
        <?php echo render_yes_no_option('keyboard_active', 'Keyboard Active')?>
        <hr />
        <i class="fa fa-question-circle pull-left" data-toggle="tooltip" data-title="<?php echo _l('tax_percentage'); ?>"></i>
        <?php echo render_input('settings[tax_percentage]', 'Tax %', get_option('tax_percentage'), 'number', ['required'=>true]); ?>
    </div>
</div>