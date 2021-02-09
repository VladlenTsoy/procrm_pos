<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo htmlspecialchars($title); ?>
                        </h4>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading"/>
                        <div class="clearfix"></div>
                        <div class="row dataTables_filter_buttons">
                            <?php echo render_select('filter_date', $staff_list, ['id', 'name'], _l('filter_by_date'), '', [], [], 'col-md-3') ?>
                            <?php echo render_select('branch_id', $branch_list, ['id', 'name'], _l('filter_by_branch'), '', [], [], 'col-md-3') ?>
                            <?php echo render_select('staff_id', $staff_list, ['id', 'name'], _l('filter_by_staff'), '', [], [], 'col-md-3') ?>
                            <?php echo render_select('lead_id', $lead_list, ['id', 'name'], _l('filter_by_lead'), '', [], [], 'col-md-3') ?>
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
        initDataTable('.table-pos-sales', window.location.href, [1], [1]);

    });
</script>
</body>
</html>
