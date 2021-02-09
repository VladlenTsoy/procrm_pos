<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Categories extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('products/branch_model');
        $this->load->model('products/category_model');
    }
    public function index()
    {
        if (!is_admin()) {
            access_denied('Product Category');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('products', 'categories/table'));
        }
        $data['branches'] = $this->branch_model->get();
        $data['title'] = _l('products_categories');
        $this->load->view('products/categories/list', $data);
    }
    public function category()
    {
        if (!is_admin()) {
            access_denied('Product Category');
        }
        $this->load->library('form_validation');

         if ($this->input->is_ajax_request()) {
             $data              = $this->input->post();
             $original_category = (object) [];
             if (!empty($data['category_id'])) {
                 $original_category = $this->category_model->get(intval($data['category_id']));
                 if ($original_category->name != $data['category_name']) {
                     $this->form_validation->set_rules('category_name', 'Category name', 'required|is_unique[product_categories.name]');
                 }
             } else {
                 $this->form_validation->set_rules('category_name', 'Category name', 'required|is_unique[product_categories.name]');
             }
             $this->form_validation->set_rules('branch_ids[]', 'product branch', 'required');
             $this->form_validation->set_rules('category_description', 'Description', 'required');
             if (false == $this->form_validation->run()) {
                 echo json_encode([
                     'success' => false,
                     'message' => validation_errors(),
                 ]);
                 return;
             }
             if ('' == $data['category_id']) {
                 $id      = $this->category_model->add($data);
                 $message = $id ? _l('added_successfully', _l('products_category')) : '';
                 echo json_encode([
                     'success' => $id ? true : false,
                     'message' => $message,
                     'id'      => $id,
                     'name'    => $data['category_name'],
                 ]);
             } else {
                 $success = $this->category_model->edit($data);
                 $message = '';
                 if (true == $success) {
                     $message = _l('updated_successfully', _l('products_category'));
                 }
                 echo json_encode([
                     'success' => $success,
                     'message' => $message,
                 ]);
             }
         }
    }
    public function delete($id)
    {
        if (!is_admin()) {
            access_denied('Delete Product Category');
        }
        if (!$id) {
            redirect(admin_url('products/categories'));
        }
        $response = $this->category_model->delete($id);
        if (true == $response) {
            set_alert('success', _l('deleted', _l('products_category')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('products_category')));
        }
        redirect(admin_url('products/categories'));
    }

    // subcategory
    public function subcategory()
    {
        if (!is_admin()) {
            access_denied('Product Subcategory');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('products', 'subcategories/table'));
        }
        $data['categories'] = $this->category_model->get();
        $data['title'] = _l('products_subcategories');
        $this->load->view('products/subcategories/list', $data);
    }
    public function add_edit_subcategory()
    {
        if (!is_admin()) {
            access_denied('Product Subcategory');
        }
        $this->load->library('form_validation');

        if ($this->input->is_ajax_request()) {
            $data              = $this->input->post();
            $original_subcategory = (object) [];
            if (!empty($data['subcategory_id'])) {
                $original_subcategory = $this->category_model->get_subcategory($data['subcategory_id']);
                if ($original_subcategory->name != $data['subcategory_name']) {
                    $this->form_validation->set_rules('subcategory_name', 'Subcategory name', 'required|is_unique[product_categories.name]');
                }
            } else {
                $this->form_validation->set_rules('subcategory_name', 'Subcategory name', 'required|is_unique[product_categories.name]');
            }
            $this->form_validation->set_rules('category_id', 'product category', 'required');
            $this->form_validation->set_rules('subcategory_description', 'Description', 'required');
            if (false == $this->form_validation->run()) {
                echo json_encode([
                    'success' => false,
                    'message' => validation_errors(),
                ]);
                return;
            }
            if ('' == $data['subcategory_id']) {
                $id      = $this->category_model->add_subcategory($data);
                $message = $id ? _l('added_successfully', _l('products_subcategory')) : '';
                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $data['subcategory_name'],
                ]);
            } else {
                $success = $this->category_model->edit_subcategory($data);
                $message = '';
                if (true == $success) {
                    $message = _l('updated_successfully', _l('products_subcategory'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
    }
    public function delete_subcategory($id)
    {
        if (!is_admin()) {
            access_denied('Delete Product Subcategory');
        }
        if (!$id) {
            redirect(admin_url('products/categories/subcategory'));
        }
        $response = $this->category_model->delete_subcategory($id);
        if (true == $response) {
            set_alert('success', _l('deleted', _l('products_subcategory')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('products_subcategory')));
        }
        redirect(admin_url('products/categories/subcategory'));
    }
}
