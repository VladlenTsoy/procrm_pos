<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="_filters _hidden_inputs hidden">
                    <?php echo form_hidden('filters_from_date'); ?>
                    <?php echo form_hidden('filters_to_date'); ?>
                    <?php echo form_hidden('filters_branch_id'); ?>
                    <?php echo form_hidden('filters_staff_id'); ?>
                    <?php echo form_hidden('filters_lead_id'); ?>
                </div>
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo htmlspecialchars($title); ?>
                        </h4>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading"/>
                        <div class="clearfix"></div>
                        <div class="row dataTables_filter_buttons">
                            <?php echo render_date_input('from_date','from_date','', [], [], 'col-md-3 col-sm-6 col-xs-12'); ?>
                            <?php echo render_date_input('to_date','to_date','', [], [], 'col-md-3 col-sm-6 col-xs-12'); ?>
                            <?php echo render_select('branch_id', $branch_list, ['id', 'name'], _l('filter_by_branch'), '', [], [], 'col-md-3 col-sm-6 col-xs-12') ?>
                            <?php echo render_select('staff_id', $staff_list, ['staffid', 'full_name'], _l('filter_by_staff'), '', [], [], 'col-md-3 col-sm-6 col-xs-12') ?>
                            <?php echo render_select('lead_id', $lead_list, ['id', 'name'], _l('filter_by_lead'), '', [], [], 'col-md-3 col-sm-6 col-xs-12') ?>
                        </div>
                        <?php render_datatable([
                            _l('date'),
                            _l('sale_num'),
                            _l('lead'),
                            _l('biller'),
                            _l('branch'),
                            _l('total_quantity'),
                            _l('total_discount'),
                            _l('shipping_cost'),
                            _l('total_tax'),
                            _l('price'),
                            _l('grand_total'),
                        ], 'pos-sales'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function () {
        const StaffServerParams = {
            from_date: '[name="filters_from_date"]',
            to_date: '[name="filters_to_date"]',
            branch_id: '[name="filters_branch_id"]',
            staff_id: '[name="filters_staff_id"]',
            lead_id: '[name="filters_lead_id"]',
        }

        const table = initDataTable('.table-pos-sales', window.location.href, [1], [1], StaffServerParams);

        $('[name="from_date"]').change(function (e) {
            $('[name="filters_from_date"]').val($(e.currentTarget).val())
            table.ajax.reload();
        })

        $('[name="to_date"]').change(function (e) {
            $('[name="filters_to_date"]').val($(e.currentTarget).val())
            table.ajax.reload();
        })

        $('[name="branch_id"]').change(function (e) {
            $('[name="filters_branch_id"]').val($(e.currentTarget).val())
            table.ajax.reload();
        })

        $('[name="staff_id"]').change(function (e) {
            $('[name="filters_staff_id"]').val($(e.currentTarget).val())
            table.ajax.reload();
        })

        $('[name="lead_id"]').change(function (e) {
            $('[name="filters_lead_id"]').val($(e.currentTarget).val())
            table.ajax.reload();
        })
    });
</script>
</body>
</html>
