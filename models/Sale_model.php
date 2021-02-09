<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Sale_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('p_sales_id', $id);
            $product_sale = $this->db->get(db_prefix().'product_sales')->row();
            return $product_sale;
        }
        $product_sales = $this->db->get(db_prefix().'product_sales')->result_array();
        return $product_sales;
    }
    public function add($data)
    {
        $this->db->insert(db_prefix().'product_sales', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('POS Sale Added[ID:'.$insert_id.', Staff id '.get_staff_user_id().']');
            return $insert_id;
        }
        return false;
    }
}
