<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'p_category_name',
    'p_category_description',
    'p_branch_name',
    'p_branch_id'
];
$sIndexColumn = 'p_category_id';
$sTable       = db_prefix().'product_categories';
$filter = [];
$where = [];
$statusIds = [];
$join = [
    'LEFT JOIN ' . db_prefix() . 'product_branches ON ' . db_prefix() . 'product_branches.p_branch_id=' . db_prefix() . 'product_categories.product_branch_id',
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['p_category_id']);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); ++$i) {
        if($aColumns[$i] != 'p_branch_id') {
            $_data = '<a href="#" data-toggle="modal" data-target="#product_category_modal" data-id="'.$aRow['p_category_id'].' " data-branch="'.$aRow['p_branch_id'].'">'.$aRow[$aColumns[$i]].'</a>';
            $row[] = $_data;
        }
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#product_category_modal', 'data-id' => $aRow['p_category_id'], 'data-branch' => $aRow['p_branch_id']]);
    $row[]   = $options .= icon_btn('products/products_categories/delete_category/'.$aRow['p_category_id'], 'remove', 'btn-danger _delete');
    $output['aaData'][] = $row;
}
