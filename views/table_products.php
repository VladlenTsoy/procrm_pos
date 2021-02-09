<?php
defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'name',
    'image_url',
    'barcode',
    'description',
    'price',
    'quantity_number',
    'branchName',
    'categoryName',
    'subcategoryName'
];
$sIndexColumn = 'id';
$sTable       = db_prefix().'product_master';
$filter    = [];
$where     = [];
$statusIds = [];
$join = [
    'LEFT JOIN (
	SELECT id as branchId, name as branchName FROM '.db_prefix().'product_branches
) as b ON b.branchId = '.db_prefix().'product_master.branch_id
LEFT JOIN (
	SELECT id as catId, name as categoryName FROM '.db_prefix().'product_categories
) as c ON c.catId = '.db_prefix().'product_master.category_id
LEFT JOIN (
	SELECT id as subCatId, name as subcategoryName FROM '.db_prefix().'product_categories
) as sc ON sc.subCatId = '.db_prefix().'product_master.subcategory_id',
];
$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id']);
$output  = $result['output'];
$rResult = $result['rResult'];
$CI = &get_instance();
$settings = $CI->db->get(db_prefix().'pos_settings')->row();
foreach ($rResult as $aRow) {
    $row        = [];
    $outputName = '<a href="#">'.$aRow['name'].'</a>';
    $outputName .= '<div class="row-options">';
    if (has_permission('products', '', 'delete')) {
        $outputName .= ' <a href="'.admin_url('products/edit/'.$aRow['id']).'" class="_edit">'._l('edit').'</a>';
        $outputName .= '| <a href="'.admin_url('products/delete/'.$aRow['id']).'" class="text-danger _delete">'._l('delete').'</a>';
    }
    $outputName .= '</div>';
    $row[]              = $outputName;
    $row[]              = "<img src='".module_dir_url('products', 'uploads')."/{$aRow['image_url']}' class='img-thumbnail img-responsive zoom' onerror=\"this.src='".module_dir_url('products', 'uploads')."/image-not-available.png'\">";
    $row[]              = $aRow['barcode'];
    $row[]              = $aRow['description'];
    $row[]              = $aRow['price'] . ' ' . $settings->currency;
    $row[]              = $aRow['quantity_number'];
    $row[]              = $aRow['branchName'];
    $row[]              = $aRow['categoryName'];
    $row[]              = $aRow['subcategoryName'];
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
