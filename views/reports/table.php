<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'sale_date',
    'id',
    'leadName',
    'biller_id',
    'branchName',
    'total_quantity',
    'total_discount',
    'shipping_cost',
    'total_tax',
    'total_price',
    'grand_total',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'product_pos_sales';
$filter    = [];
$where     = [];
$statusIds = [];
$join = [
    'LEFT JOIN (
	SELECT id as leadId, name as leadName FROM '.db_prefix().'leads
) as l ON l.leadId = '.db_prefix().'product_pos_sales.lead_id',
    'LEFT JOIN (
	SELECT id as branchId, name as branchName FROM '.db_prefix().'product_branches
) as b ON b.branchId = '.db_prefix().'product_pos_sales.branch_id'
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where);
$output  = $result['output'];
$rResult = $result['rResult'];
$CI = &get_instance();
$settings = $CI->db->get(db_prefix().'pos_settings')->row();
foreach ($rResult as $aRow) {
    $row        = [];
    for ($i = 0; $i < count($aColumns); ++$i) {
        $_columnData = $aRow[$aColumns[$i]];
        if($aColumns[$i] != 'id' && $aColumns[$i] != 'leadName' &&
            $aColumns[$i] != 'total_quantity' && $aColumns[$i] != 'sale_date' &&
            $aColumns[$i] != 'biller_id' && $aColumns[$i] != 'branchName') {
            $_columnData .= ' '. $settings->currency;
        }
        if($aColumns[$i] == 'sale_date' && $_columnData) {
            $date = date_create($_columnData);
            $_columnData = $date->format('d-m-Y');
        }
        if($aColumns[$i] == 'biller_id' && $_columnData) {
            $_columnData = get_staff($_columnData)->firstname;
        }
        $_data = '<a href="'. admin_url('products/reports/details/'.$aRow['id']) .'">'.$_columnData.'</a>';
        $row[] = $_data;
    }
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
