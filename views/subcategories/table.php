<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'name',
    'description',
    'parentCategory',
    'categoryId',
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'product_categories';
$filter = [];
$where = [];
$statusIds = [];
$join = [
    'LEFT JOIN
    (SELECT name as parentCategory, id as categoryId FROM '.db_prefix().'product_categories WHERE parent_id = 0) as parentCat 
     ON parentCat.categoryId = parent_id
     WHERE parent_id > 0'
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$catIds = [];
foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); ++$i) {
        if($aColumns[$i] != 'categoryId'){
            $_data = '<a href="#" data-toggle="modal" data-target="#subcategory_modal" data-id="'.$aRow['id'].' " data-category="'.$aRow['categoryId'].'">'.$aRow[$aColumns[$i]].'</a>';
            $row[] = $_data;
        }
    }
    $options = icon_btn('#', 'pencil-square-o', 'btn-default', ['data-toggle' => 'modal', 'data-target' => '#subcategory_modal', 'data-id' => $aRow['id'], 'data-category' => $aRow['categoryId']]);
    $row[]   = $options .= icon_btn('products/categories/delete_subcategory/'.$aRow['id'], 'remove', 'btn-danger _delete');
    $output['aaData'][] = $row;
}
