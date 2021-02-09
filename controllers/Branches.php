<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Branches extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('products/branch_model');
    }
    public function index()
    {
        if (!is_admin()) {
            access_denied('Product Branch');
        }
        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('products', 'branches/table'));
        }
        $data['title'] = _l('products_branches');
        $this->load->view('products/branches/list', $data);
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
            if (!empty($data['branch_id'])) {
                $original_branch = $this->branch_model->get($data['branch_id']);
                if ($original_branch->name != $data['branch_name']) {
                    $this->form_validation->set_rules('branch_name', 'Branch name', 'required|is_unique[product_branches.name]');
                }
            } else {
                $this->form_validation->set_rules('branch_name', 'Branch name', 'required|is_unique[product_branches.name]');
            }
            $this->form_validation->set_rules('branch_address', 'Description', 'required');
            if (false == $this->form_validation->run()) {   
                echo json_encode([
                    'success' => false,
                    'message' => validation_errors(),
                ]);
                return;
            }
            if ('' == $data['branch_id']) {
                $id      = $this->branch_model->add($data);
                $message = $id ? _l('added_successfully', _l('product_branch')) : '';
                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'branch_id'      => $id,
                    'branch_name'    => $data['branch_name'],
                ]);
            } else {
                $success = $this->branch_model->edit($data);
                $message = '';
                if (true == $success) {
                    $message = _l('updated_successfully', _l('product_branch'));
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
            access_denied('Delete Product Branch');
        }
        if (!$id) {
            redirect(admin_url('products/branches'));
        }
        $response = $this->branch_model->delete($id);
        if (true == $response) {
            set_alert('success', _l('deleted', _l('product_branch')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('product_branch')));
        }
        redirect(admin_url('products/branches'));
    }
}
