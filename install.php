<?php

defined('BASEPATH') or exit('No direct script access allowed');

add_option('products_enabled', 1);
$CI->db->query('SET foreign_key_checks = 0');
 if (!$CI->db->table_exists(db_prefix().'product_master')) {

     $CI->db->query('CREATE TABLE `'.db_prefix().'product_master` (
      `id` INT NOT NULL AUTO_INCREMENT ,
      `name` VARCHAR(200) NOT NULL , 
      `description` VARCHAR(200) NOT NULL , 
      `barcode` VARCHAR(200) NOT NULL , 
      `branch_id` INT NOT NULL , 
      `category_id` INT NOT NULL , 
      `subcategory_id` INT , 
      `price` DECIMAL(15,2) NOT NULL , 
      `quantity_number` INT NOT NULL ,
      `image_url` VARCHAR(200) NULL DEFAULT NULL ,
       PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
 }

 // all root categories will have a parent_id 0
if (!$CI->db->table_exists(db_prefix().'product_categories')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'product_categories` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`parent_id` INT NOT NULL DEFAULT 0, 
		`name` VARCHAR(50) NOT NULL ,
		`description` TEXT NOT NULL , 
		PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
}

if (!$CI->db->table_exists(db_prefix().'product_branches')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'product_branches` (
		`id` INT NOT NULL AUTO_INCREMENT , 
		`name` VARCHAR(50) NOT NULL ,
		`address` TEXT NOT NULL ,  
		PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
}

if (!$CI->db->table_exists(db_prefix().'product_branch_and_category')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'product_branch_and_category` (
		`branch_id` INT NOT NULL ,
		`category_id` INT NOT NULL ,
		PRIMARY KEY (`branch_id`,`category_id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
}

if (!$CI->db->table_exists(db_prefix().'product_pos_sales')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'product_pos_sales` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`lead_id` INT NOT NULL ,  
		`biller_id` INT NOT NULL ,  
		`branch_id` INT NOT NULL ,  
		`items` INT NOT NULL ,  
		`total_quantity` INT NOT NULL ,  
		`total_discount` decimal(11,2),  
		`total_tax` decimal(11,2),  
		`total_price` decimal(11,2) NOT NULL ,  
		`return_change` decimal(11,2) NOT NULL ,  
		`grand_total` decimal(11,2) NOT NULL ,  
		`order_tax_rate` INT ,  
		`shipping_cost` decimal(11,2) ,  
		`shipping_driver_id` INT ,  
		`paid_amount` decimal(11,2) NOT NULL ,  
		`payment_method` VARCHAR(50) NOT NULL ,
		`sale_notes` VARCHAR(200) NOT NULL ,
		`sale_date` VARCHAR(200) NOT NULL ,
		PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
}

if (!$CI->db->table_exists(db_prefix().'product_sales')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'product_sales` (
		`id` INT NOT NULL AUTO_INCREMENT , 
		`pos_id` INT NOT NULL ,
		`product_id` INT NOT NULL ,  
		`quantity` INT NOT NULL ,  
		`discount` INT ,  
		`total_price` decimal(11,2) NOT NULL ,  
		PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');
}

if (!$CI->db->table_exists(db_prefix().'pos_settings')) {
    $CI->db->query('CREATE TABLE `'.db_prefix().'pos_settings` (
		`id` INT NOT NULL AUTO_INCREMENT , 
		`currency` VARCHAR(50) ,  
		`is_keyboard_active` TINYINT(1) NOT NULL DEFAULT 0,  
		`tax_rate` decimal(11,2) ,  
		PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET='.$CI->db->char_set.';');

    $CI->db->insert(db_prefix().'pos_settings', [
        'currency' => null,
        'is_keyboard_active' => 0,
        'tax_rate' => null
    ]);
}