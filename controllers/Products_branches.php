<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Products_branches extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('products/products_branch_model');
    }
    public function index()
    {
        if (!is_admin()) {
            access_denied('Product Branch');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('products', 'tables/product_branch'));
        }
        $data['title'] = _l('products_branches');
        $this->load->view('products/products_branches', $data);
    }
    public function branch()
    {
        if (!is_admin()) {
            access_denied('Product Branch');
        }
        $this->load->library('form_validation');
        if ($this->input->is_ajax_request()) {
            $data              = $this->input->post();
            $original_branch = (object) [];
            if (!empty($data['p_branch_id'])) {
                $original_branch = $this->products_branch_model->get($data['p_branch_id']);
                if ($original_branch->p_branch_name != $data['p_branch_name']) {
                    $this->form_validation->set_rules('p_branch_name', 'Branch name', 'required|is_unique[product_branches.p_branch_name]');
                }
            } else {
                $this->form_validation->set_rules('p_branch_name', 'Branch name', 'required|is_unique[product_branches.p_branch_name]');
            }
            $this->form_validation->set_rules('p_branch_address', 'Description', 'required');
            if (false == $this->form_validation->run()) {
                echo json_encode([
                    'success' => false,
                    'message' => validation_errors(),
                ]);
                return;
            }
            if ('' == $data['p_branch_id']) {
                $id      = $this->products_branch_model->add($data);
                $message = $id ? _l('added_successfully', _l('products_branches')) : '';
                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $data['p_branch_name'],
                ]);
            } else {
                $success = $this->products_branch_model->edit($data);
                $message = '';
                if (true == $success) {
                    $message = _l('updated_successfully', _l('products_branches'));
                }
                echo json_encode([
                    'success' => $success,
                    'message' => $message,
                ]);
            }
        }
    }
    public function delete_branch($id)
    {
        if (!is_admin()) {
            access_denied('Delete Product Branch');
        }
        if (!$id) {
            redirect(admin_url('products/products_branches'));
        }
        $response = $this->products_branch_model->delete($id);
        if (true == $response) {
            set_alert('success', _l('deleted', _l('products_branches')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('products_branches')));
        }
        redirect(admin_url('products/products_branches'));
    }
}
