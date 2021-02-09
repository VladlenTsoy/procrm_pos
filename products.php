<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: PROCRM POS
Description: PROCRM POS module for retails and restaurants
Version: 1.0.0
Requires at least: 2.3.*
Author: Akmaljon Abdirakhimov
*/

//Module name
define('PRODUCTS_MODULE_NAME', 'products');

// Define upload folder location
define('PRODUCT_MODULE_UPLOAD_FOLDER', module_dir_path(PRODUCTS_MODULE_NAME, 'uploads/'));

// Get codeigniter instance
$CI = &get_instance();

// Register activation module hook
register_activation_hook(PRODUCTS_MODULE_NAME, 'products_module_activation_hook');
function products_module_activation_hook()
{
    $CI = &get_instance();
    require_once __DIR__.'/install.php';
}

// Register language files, must be registered if the module is using languages
register_language_files(PRODUCTS_MODULE_NAME, [PRODUCTS_MODULE_NAME]);

// Load module helper file
$CI->load->helper(PRODUCTS_MODULE_NAME.'/products');

// Load module Library file
 $CI->load->library(PRODUCTS_MODULE_NAME.'/'.'products_lib');

// Inject css file for products module
hooks()->add_action('app_admin_head', 'products_add_head_components');
function products_add_head_components()
{
    // Check module is enable or not (refer install.php)
    if ('1' == get_option('products_enabled')) {
        $CI = &get_instance();
        echo '<link href="'.module_dir_url('products', 'assets/css/sweetalert.min.css').'"  rel="stylesheet" type="text/css" />';
        echo '<link href="'.module_dir_url('products', 'assets/css/keyboard.min.css').'"  rel="stylesheet" type="text/css" />';
        echo '<link href="'.module_dir_url('products', 'assets/css/products.css').'"  rel="stylesheet" type="text/css" />';
    }
}

// Inject sidebar menu and links for products module
hooks()->add_action('admin_init', 'products_module_init_menu_items');
function products_module_init_menu_items()
{
    $CI = &get_instance();

    if (has_permission('products', '', 'view')) {
		$CI->app_menu->add_sidebar_menu_item('pos_sales', [
                'name'     => _l('pos_sales'),
                'icon'     => 'fa fa-shopping-basket',
                'href'     => admin_url('#'),
				'position' => 2,
        ]);
		
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'pos',
            'name'     => _l('POS'),
            'href'     => admin_url('products/pos'),
            'position' => 1,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'pos-sales-reports',
            'name'     => _l('sales-reports'),
            'href'     => admin_url('products/reports'),
            'position' => 2,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'products',
            'name'     => _l('products'),
            'href'     => admin_url('products'),
            'position' => 3,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'branches',
            'name'     => _l('products_branches'),
            'href'     => admin_url('products/branches'),
            'position' => 4,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'categories',
            'name'     => _l('products_categories'),
            'href'     => admin_url('products/categories'),
            'position' => 5,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'subcategories',
            'name'     => _l('products_subcategories'),
            'href'     => admin_url('products/categories/subcategory'),
            'position' => 6,
        ]);
    }

    if (has_permission('products', '', 'view')) {
        $CI->app_menu->add_sidebar_children_item('pos_sales', [
            'slug'     => 'pos_settings',
            'name'     => _l('pos_settings'),
            'href'     => admin_url('products/pos/settings'),
            'position' => 6,
        ]);
    }

}

// Inject upload folder location for products module
hooks()->add_filter('get_upload_path_by_type', 'product_upload_folder', 10, 2);
function product_upload_folder($path, $type)
{
    if ('products' == $type) {
        return PRODUCT_MODULE_UPLOAD_FOLDER;
    }
}