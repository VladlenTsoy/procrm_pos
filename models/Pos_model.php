<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Pos_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $product_pos_sale = $this->db->get(db_prefix().'product_pos_sales')->row();
            return $product_pos_sale;
        }
        $product_pos_sales = $this->db->get(db_prefix().'product_pos_sales')->result_array();
        return $product_pos_sales;
    }

    public function get_products_by_pos($id = false)
    {
        if (is_numeric($id)) {
            $products = $this->db->query('SELECT productName, quantity, discount, total_price FROM '.db_prefix().'product_sales 
                LEFT JOIN (SELECT id, name as productName from '.db_prefix().'product_master) as p ON p.id = '.db_prefix().'product_sales.product_id WHERE pos_id='.$id)->result_array();
            return $products;
        }
    }

    public function add($data)
    {
        $this->db->insert(db_prefix().'product_pos_sales', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('POS Sale Added[ID:'.$insert_id.', Staff id '.get_staff_user_id().']');
            return $insert_id;
        }
        return false;
    }

    public function get_settings()
    {
        return $this->db->get(db_prefix().'pos_settings')->row();
    }

    public function update_settings($data)
    {
        $result = $this->db->update(db_prefix().'pos_settings', $data);

        if ($this->db->affected_rows() > 0) {
            log_activity('Product Details updated[ currency: '.$data['currency'].', '.$data['is_keyboard_active'].','.$data['tax_rate'].', Staff id '.get_staff_user_id().' ]');
            return true;
        }
        return $result;
    }
}
