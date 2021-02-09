<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = ['p_branch_name', 'p_branch_address'];
$sIndexColumn = 'p_branch_id';
$sTable       = db_prefix().'product_branches';
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], ['p_branch_id']);
$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); ++$i) {
        $_data = '<a href="#" data-toggle="modal" data-target="#product_branch_modal" data-id="'.$aRow['p_branch_id'].'">'.$aRow[$aColumns[$i]].'</a>';
        $row[] = $_data;
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#product_branch_modal', 'data-id' => $aRow['p_branch_id']]);
    $row[]   = $options .= icon_btn('products/products_branches/delete_branch/'.$aRow['p_branch_id'], 'remove', 'btn-danger _delete');
    $output['aaData'][] = $row;
}
