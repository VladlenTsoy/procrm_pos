<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'name',
    'description',
    'branchNames',
    'branchIds',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'product_categories';
$filter = [];
$where = [];
$statusIds = [];
$join = [
    'LEFT JOIN
    (SELECT GROUP_CONCAT(id ORDER BY id ASC) as branchIds, GROUP_CONCAT(name ORDER BY id ASC SEPARATOR ", ") as branchNames, category_id FROM '.db_prefix().'product_branches, '.db_prefix().'product_branch_and_category where '.db_prefix().'product_branches.id = '.db_prefix().'product_branch_and_category.branch_id
GROUP BY category_id) as bc ON bc.category_id = '.db_prefix().'product_categories.id WHERE parent_id = 0'
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$catIds = [];
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); ++$i) {
        if($aColumns[$i] != 'branchIds'){
            $_data = '<a href="#" data-toggle="modal" data-target="#category_modal" data-id="'.$aRow['id'].' " data-branch="'.$aRow['branchIds'].'">'.$aRow[$aColumns[$i]].'</a>';
            $row[] = $_data;
        }
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#category_modal', 'data-id' => $aRow['id'], 'data-branch' => $aRow['branchIds']]);
    $row[]   = $options .= icon_btn('products/categories/delete/'.$aRow['id'], 'remove', 'btn-danger _delete');
    $output['aaData'][] = $row;
}
