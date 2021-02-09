<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Products_branch_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('p_branch_id', $id);
            $branch = $this->db->get(db_prefix().'product_branches')->row();
            return $branch;
        }
        $branches = $this->db->get(db_prefix().'product_branches')->result_array();
        return $branches;
    }
    public function add($data)
    {
        $this->db->insert(db_prefix().'product_branches', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('Product Branch Added[ID:'.$insert_id.', '.$data['p_branch_name'].', Staff id '.get_staff_user_id().']');
            return $insert_id;
        }
        return false;
    }
    public function edit($data)
    {
        $this->db->where('p_branch_id', $data['p_branch_id']);
        $res = $this->db->update(db_prefix().'product_branches', [
            'p_branch_name'        => $data['p_branch_name'],
            'p_branch_address' => $data['p_branch_address'],
        ]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Branch updated[ID:'.$data['p_branch_id'].', '.$data['p_branch_name'].', Staff id '.get_staff_user_id().']');
        }
        return $res;
    }
    public function delete($id)
    {
        $original_branch = $this->get($id);
        $this->db->where('p_branch_id', $id);
        $this->db->delete(db_prefix().'product_branches');
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Branch deleted[ID:'.$id.', '.$original_branch->p_branch_name.', Staff id '.get_staff_user_id().']');
            return true;
        }
        return false;
    }
}
