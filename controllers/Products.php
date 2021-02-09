<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('products_model');
        $this->load->model('branch_model');
        $this->load->model('category_model');
    }

    public function index()
    {
        if (!has_permission('products', '', 'view')) {
            access_denied('products View');
        }
        close_setup_menu();

        $data['title'] = _l('products');
        if (has_permission('products', '', 'view')) {
            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data(module_views_path('products', 'table_products'));
            }
            $data['title']         = _l('products');
            $this->load->view('list_products', $data);
        } else {
            access_denied('products');
        }
    }

    public function add_product()
    {
        if (!has_permission('products', '', 'view')) {
            access_denied('products View');
        }
        close_setup_menu();
        if (has_permission('products', '', 'view')) {
            $post=$this->input->post();
            if (!empty($post)) {
                $this->form_validation->set_rules('product_name', 'product name', 'required');
                $this->form_validation->set_rules('product_code', 'product code', 'required|is_unique[product_master.barcode]');
                $this->form_validation->set_rules('product_description', 'product description', 'required');
                $this->form_validation->set_rules('branch_id', 'product branch', 'required');
                $this->form_validation->set_rules('category_id', 'product category', 'required');
                $this->form_validation->set_rules('price', 'product price', 'required');
                $this->form_validation->set_rules('quantity_number', 'product quantity', 'required');
                if (false == $this->form_validation->run()) {
                    set_alert('danger', preg_replace("/\r|\n/", '', validation_errors()));
                } else {
                    $data = [
                        'name'                => $post['product_name'],
                        'barcode'             => $post['product_code'],
                        'description'         => $post['product_description'],
                        'branch_id'           => $post['branch_id'],
                        'category_id'         => $post['category_id'],
                        'subcategory_id'      => $post['subcategory_id'],
                        'price'               => $post['price'],
                        'quantity_number'     => $post['quantity_number'],
                    ];
                    $inserted_id=$this->products_model->add_product($data);
                    if ($inserted_id) {
                        handle_product_upload($inserted_id);
                        set_alert('success', 'Product Added successfully');
                        redirect(admin_url('products'), 'refresh');
                    } else {
                        set_alert('warning', _l('Error Found - Product not inserted'));
                    }
                }
            }
            $data['title']   = _l('add_new', 'product');
            $data['action']  = _l('products');
            $data['branches'] = $this->branch_model->get();
            $data['categories'] = $this->category_model->get_by_branch();
            $data['subcategories'] = $this->category_model->get_subcategory();
            $this->load->view('products/add_product', $data);
        } else {
            access_denied('products');
        }
    }
    public function edit($id)
    {
        if (has_permission('products', '', 'view')) {
            $original_product = $data['product'] = $this->products_model->get_by_id_product($id);
            if (empty($original_product)) {
                set_alert('danger', _l('not_found_products'));
                redirect(admin_url('products'), 'refresh');
            }
            $post=$this->input->post();
            if (!empty($post)) {
                $this->form_validation->set_rules('product_name', 'product name', 'required');
                $this->form_validation->set_rules('product_code', 'product code', 'required');
                if ($original_product->barcode != $post['product_code']) {
                    $this->form_validation->set_rules('product_code', 'product code', 'required|is_unique[product_master.barcode]');
                }
                $this->form_validation->set_rules('product_description', 'product description', 'required');
                $this->form_validation->set_rules('branch_id', 'product branch', 'required');
                $this->form_validation->set_rules('category_id', 'product category', 'required');
                $this->form_validation->set_rules('price', 'product price', 'required');
                $this->form_validation->set_rules('quantity_number', 'product quantity', 'required');
                if (false == $this->form_validation->run()) {
                    set_alert('danger', preg_replace("/\r|\n/", '', validation_errors()));
                } else {
                    $data = [
                        'name'                => $post['product_name'],
                        'barcode'             => $post['product_code'],
                        'description'         => $post['product_description'],
                        'branch_id'           => $post['branch_id'],
                        'category_id'         => $post['category_id'],
                        'subcategory_id'      => $post['subcategory_id'],
                        'price'               => $post['price'],
                        'quantity_number'     => $post['quantity_number'],
                    ];
                    $result=$this->products_model->edit_product($data, $id);
                    handle_product_delete_file($id, false);
                    handle_product_upload($id);
                    if ($result) {
                        set_alert('success', 'Product Updated successfully');
                        redirect(admin_url('products'), 'refresh');
                    } else {
                        set_alert('warning', _l('Error Found Or You Have not made any changes'));
                    }
                }
            }
            $data['title']   = _l('edit', 'product');
            $data['branches'] = $this->branch_model->get();
            $data['categories'] = $this->category_model->get_by_branch();
            $data['subcategories'] = $this->category_model->get_subcategory();
            $this->load->view('products/add_product', $data);
        } else {
            access_denied('products');
        }
    }
    public function delete($id)
    {
        if (!is_admin()) {
            access_denied('Delete Product');
        }
        if (!$id) {
            redirect(admin_url('products'));
        }
        handle_product_delete_file($id, true);
        $response = $this->products_model->delete_by_id_product($id);
        if (true == $response) {
            set_alert('success', _l('deleted', _l('products')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('products')));
        }
        redirect(admin_url('products'));
    }
}
