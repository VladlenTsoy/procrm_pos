<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('pos_model');
        $this->load->model('staff_model');
        $this->load->model('leads_model');
        $this->load->model('branch_model');
    }

    public function index()
    {
        if (has_permission('reports', '', 'view')) {
            $post = $this->input->post();

            $data = [
                'branch_list' => $this->branch_model->get(),
                'staff_list' => $this->staff_model->get('', ['active' => 1]),
                'lead_list' => $this->leads_model->get('', [])
            ];

            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data(module_views_path('products', 'reports/table'), ['post' => $post]);
            }
            $data['title'] = _l('reports');
            $this->load->view('products/reports/list', $data);
        } else {
            access_denied('reports');
        }
    }

    public function details($id = false)
    {
        if (!is_admin()) {
            access_denied('Delete Product');
        }
        if (!$id) {
            redirect(admin_url('products/reports'));
        }
        $this->app_css->add('custom-css', module_dir_url(PRODUCTS_MODULE_NAME, 'assets/css/custom.css'));


        $data['biller'] = $this->staff_model->get(get_staff_user_id());
        $data['pos_sale'] = $this->pos_model->get($id);
        $data['lead'] = $this->leads_model->get($data['pos_sale']->lead_id);
        $data['branch'] = $this->branch_model->get($data['pos_sale']->branch_id);
        $data['sale_products'] = $this->pos_model->get_products_by_pos($id);
        $data['pos_settings'] = $this->pos_model->get_settings();
        $data['title'] = _l('more_about_reports');
        $this->load->view('products/reports/details', $data);
    }
}
