<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Category_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where(['id' => $id, 'parent_id' => 0]);
            $category = $this->db->get(db_prefix().'product_categories')->row();
            return $category;
        }
        $this->db->where(['parent_id' => 0]);
        $categories = $this->db->get(db_prefix().'product_categories')->result_array();
        return $categories;
    }
    public function get_by_branch()
    {
        $categories = $this->db->query('SELECT id, name, GROUP_CONCAT(branch_id) as branchIds FROM '.db_prefix().'product_categories as c 
            LEFT JOIN '.db_prefix().'product_branch_and_category as bc ON bc.category_id = c.id
            WHERE parent_id = 0 
            GROUP BY c.id
            ORDER BY c.id ASC')->result_array();
//        $categories = $this->db->get(db_prefix().'product_categories')->result_array();
        return $categories;
    }
    public function add($data)
    {
        $this->db->insert(db_prefix().'product_categories', [
            'name'        => $data['category_name'],
            'description' => $data['category_description'],
        ]);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('Product Category Added[ID:'.$insert_id.', '.$data['category_name'].', Staff id '.get_staff_user_id().']');
            foreach ($data['branch_ids'] as $branch_id) {
                $this->db->insert(db_prefix().'product_branch_and_category', [
                    'branch_id'   => $branch_id,
                    'category_id' => $insert_id,
                ]);
            }
            return $insert_id;
        }
        return false;
    }
    public function edit($data)
    {
        $this->db->where('id', $data['category_id']);
        $res = $this->db->update(db_prefix().'product_categories', [
            'name'        => $data['category_name'],
            'description' => $data['category_description'],
        ]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Category updated[ID:'.$data['category_id'].', '.$data['category_name'].', Staff id '.get_staff_user_id().']');
            $this->db->where(['category_id' => $data['category_id']]);
            $this->db->delete(db_prefix().'product_branch_and_category');
            foreach ($data['branch_ids'] as $branch_id) {
                $this->db->insert(db_prefix().'product_branch_and_category', [
                    'branch_id'   => $branch_id,
                    'category_id' => $data['category_id'],
                ]);
            }
        }
        return $res;
    }
    public function delete($id)
    {
        $original_category = $this->get($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'product_categories');
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Category deleted[ID:'.$id.', '.$original_category->name.', Staff id '.get_staff_user_id().']');
            $this->db->where(['category_id' => $id]);
            $this->db->delete(db_prefix().'product_branch_and_category');
            return true;
        }
        return false;
    }

    //subcategory
    public function get_subcategory($id = false)
    {
        if (is_numeric($id)) {
            $this->db->where(['id' => $id, 'parent_id > ' => 0]);
            $subcategory = $this->db->get(db_prefix().'product_categories')->row();
            return $subcategory;
        }
        $this->db->where(['parent_id > ' => 0]);
        $subcategories = $this->db->get(db_prefix().'product_categories')->result_array();
        return $subcategories;
    }
    public function add_subcategory($data)
    {
        $this->db->insert(db_prefix().'product_categories', [
            'parent_id'   => $data['category_id'],
            'name'        => $data['subcategory_name'],
            'description' => $data['subcategory_description'],
        ]);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            log_activity('Product Subcategory Added[ID:'.$insert_id.', '.$data['subcategory_name'].', Staff id '.get_staff_user_id().']');
            return $insert_id;
        }
        return false;
    }
    public function edit_subcategory($data)
    {
        $this->db->where('id', $data['subcategory_id']);
        $res = $this->db->update(db_prefix().'product_categories', [
            'parent_id'   => $data['category_id'],
            'name'        => $data['subcategory_name'],
            'description' => $data['subcategory_description'],
        ]);
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Subcategory updated[ID:'.$data['subcategory_id'].', '.$data['subcategory_name'].', Staff id '.get_staff_user_id().']');
        }
        return $res;
    }
    public function delete_subcategory($id)
    {
        $original_category = $this->get($id);
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'product_categories');
        if ($this->db->affected_rows() > 0) {
            log_activity('Product Category deleted[ID:'.$id.', '.$original_category->name.', Staff id '.get_staff_user_id().']');
            $this->db->where(['category_id' => $id]);
            $this->db->delete(db_prefix().'product_branch_and_category');
            return true;
        }
        return false;
    }
}
