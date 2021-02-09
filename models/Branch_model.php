<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Branch_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            $branch = $this->db->get(db_prefix().'product_branches')->row();
            return $branch;
        }
        $branches = $this->db->get(db_prefix().'product_branches')->result_array();
        return $branches;
    }
    public function add($data)
    {
        $this->db->insert(db_prefix().'product_branches', [
            'name'    => $data['branch_name'],
            'address' => $data['branch_address'],
        ]);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('Product Branch Added[ID:'.$insert_id.', '.$data['branch_name'].', Staff id '.get_staff_user_id().']');
            return $insert_id;
        }
        return false;
    }
    public function edit($data)
    {
        $this->db->where('id', $data['branch_id']);
        $res = $this->db->update(db_prefix().'product_branches', [
            'name'    => $data['branch_name'],
            'address' => $data['branch_address'],
        ]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Branch updated[ID:'.$data['branch_id'].', '.$data['branch_name'].', Staff id '.get_staff_user_id().']');
        }
        return $res;
    }
    public function delete($id)
    {
        $original_branch = $this->get($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'product_branches');
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Branch deleted[ID:'.$id.', '.$original_branch->name.', Staff id '.get_staff_user_id().']');
            return true;
        }
        return false;
    }
}
