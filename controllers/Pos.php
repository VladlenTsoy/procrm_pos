<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pos extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('leads_model');
        $this->load->model('pos_model');
        $this->load->model('sale_model');
        $this->load->model('products_model');
        $this->load->model('category_model');
        $this->load->model('branch_model');
        $this->load->model('staff_model');
    }

    public function index()
    {
        $staffId = get_staff_user_id();
        $staff = $this->staff_model->get($staffId);

        if (!is_admin() || !isset($staff->pos_branch_id)) {
            access_denied('Pos');
        }

        $this->app_css->add('pos-css', module_dir_url(PRODUCTS_MODULE_NAME, 'assets/css/pos.css'));
        $this->app_css->add('calculator-css', module_dir_url(PRODUCTS_MODULE_NAME, 'assets/css/calculator.css'));
        $_branch = $this->branch_model->get($staff->pos_branch_id);

        $data['leads'] = $this->leads_model->get();
        $data['products_list'] = $this->products_model->get_by_id_product();
        $data['branches_list'] = $this->branch_model->get();
        $data['branch_selected'] = $_branch;
        $data['categories_list'] = $this->category_model->get_by_branch();
        $data['subcategories_list'] = $this->category_model->get_subcategory();
        $data['settings'] = $this->pos_model->get_settings();
        $data['pos_branch_id'] = $staff->pos_branch_id;
        $data['title'] = _l('pos');
        $this->load->view('products/pos/sale', $data);
    }

    public function add_sale()
    {
        $data = $this->input->post();
        $data['biller_id'] = get_staff_user_id();

        $biller = $this->staff_model->get(get_staff_user_id());

        $date = date("Y-m-d H:i:s");

        switch ($data['payment_method']) {
            case 0:
                $data['payment_method'] = 'cash';
                break;
        }

        $pos_sale_id = $this->pos_model->add([
            'lead_id' => $data['lead_id'],
            'biller_id' => $data['biller_id'],
            'branch_id' => $data['branch_id'],
            'items' => $data['items'],
            'total_quantity' => $data['total_quantity'],
            'total_discount' => $data['total_discount'],
            'total_tax' => $data['total_tax'],
            'total_price' => $data['total_price'],
            'return_change' => $data['return_change'],
            'grand_total' => $data['grand_total'],
            'order_tax_rate' => $data['order_tax_rate'],
            'shipping_cost' => $data['shipping_cost'],
            'shipping_driver_id' => $data['shipping_driver_id'],
            'payment_method' => $data['payment_method'],
            'paid_amount' => $data['paid_amount'],
            'sale_notes' => $data['sale_notes'],
            'sale_date' => $date,
        ]);

        if ($pos_sale_id) {

            $logoName = get_option('company_logo');
            if (get_option('company_logo_dark') != '') {
                $logoName = get_option('company_logo_dark');
            }
            $img = '';
            if ($logoName) {
                $path = COMPANY_FILES_FOLDER . '/' . $logoName;
                $imgData = base64_encode(file_get_contents($path));
                // Format the image SRC:  data:{mime};base64,{data};
                $src = 'data:image/png;base64,' . $imgData;
                $img = '<img style="max-width: 150px; max-height: 50px; -webkit-filter: grayscale(100%);filter: grayscale(100%);" src=' . $src . ' />';
            } else {
                $img = get_option('companyname');
            }

            $pos_settings = $this->pos_model->get_settings();

            $ticket = '<div class="col-md-12">
                        <div class="text-center">
                            <p>
                                ' . $img . '
                            </p>
                            <p style="font-weight: 500;">
                                <span>' . get_option('invoice_company_address') . '</span>
                                <br>
                                <span>' . get_option('invoice_company_city') . ', ' . get_option('invoice_company_postal_code') . '</span>
                                <br>
                            </p>
                        </div>
                        <div style="clear:both;">
                    </div>
                    <div style="clear:both;">
                        <table class="table" cellspacing="0" border="0" style="margin: 0">
                            <tbody>
                                <tr>
                                    <td style="text-align:left; padding:0; border: none;">' . _l("sale_num") . ' № ' . $pos_sale_id . '</td>
                                    <td style="padding:0; text-align:right; border: none;">' . $date . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; padding:0;border: none;">' . _l("cashier") . '</td>
                                    <td style="padding:0; text-align:right;border: none;">' . $biller->firstname . '</td>
                                </tr>
                                <tr>
                                    <td style="text-align:left; padding:0;border: none;">' . _l("lead") . '</td>
                                    <td style="padding:0; text-align:right;border: none;">' . $data['lead_name'] . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="clear:both;">
                        <div style="clear:both;">
                            <table class="table" cellspacing="0" border="0" style="margin-top: 10px">
                                <thead>
                                    <tr>
                                        <th style="border: none; text-align:left; padding-top:5px;">' . _l("product") . ' (#)</th>
                                        <th style="border: none; text-align:right; padding-top:5px;">' . _l("total") . '</th>
                                    </tr>
                                </thead>
                            <tbody>';

            for ($i = 0; $i < count($data['product_ids']); $i++) {
                $this->sale_model->add([
                    'pos_id' => $pos_sale_id,
                    'product_id' => $data['product_ids'][$i],
                    'quantity' => $data['product_quantities'][$i],
                    'discount' => $data['product_discounts'][$i],
                    'total_price' => $data['product_total_prices'][$i],
                ]);
                $product = $this->products_model->get_by_id_product($data['product_ids'][$i]);
                $this->products_model->edit_product([
                    'quantity_number' => ($product->quantity_number - $data['product_quantities'][$i])
                ], $data['product_ids'][$i]);

                $ticket .=
                    '<tr>
                    <td style="text-align:left; padding-top:5px;">' . $data['product_names'][$i] . ' (' . $data['product_quantities'][$i] . ')</td>
                    <td style="padding-top:5px; text-align:right;">' . number_format((float)($data['product_total_prices'][$i]), 2, '.', '') . ' ' . $pos_settings->currency . '</td>
                 </tr>';
            }

            $ticket .=
                '</tbody>
            </table>
            <table class="table" cellspacing="0" border="0" style="margin-bottom:8px;">
                <tbody>
                    <tr>
                        <td style="text-align:left; padding-top:5px;">' . _l("total_items") . ' (' . $data['total_quantity'] . ')</td>
                        <td style="padding-top:5px; text-align:right;">' . $data['total_price'] . ' ' . $pos_settings->currency . '</td>
                    </tr>';

            // discount amount
            if (intval($data['total_discount'])) {
                $ticket .=
                    '<tr>
                    <td style="text-align:left; padding-top:5px;">' . _l("discount") . '</td>
                    <td style="padding-top:5px; text-align:right;">' . $data['total_discount'] . '</td>
                 </tr>';
            }

            // tax amount and rate
            if (intval($data['total_tax'])) {
                $ticket .=
                    '<tr>
                    <td style="text-align:left; padding-top:5px;">' . _l("tax") . ' (' . $pos_settings->tax_rate . '%)</td>
                    <td style="padding-top:5px; text-align:right;">' . $data['total_tax'] . ' ' . $pos_settings->currency . '</td>
                 </tr>';
            }

            // shipping cost
            if (intval($data['shipping_cost'])) {
                $ticket .=
                    '<tr>
                    <td style="text-align:left; padding-top:5px;">' . _l("shipping") . '</td>
                    <td style="padding-top:5px; text-align:right;">' . $data['shipping_cost'] . ' ' . $pos_settings->currency . '</td>
                 </tr>';
            }

            // total amount to pay
            $ticket .=
                '<tr>
                <td style="text-align:left; font-weight:500; padding-top:5px;">' . _l("grand_total") . '</td>
                <td style="border-top:1px dashed #000; padding-top:5px; text-align:right; font-weight:500;">' . number_format((float)$data['grand_total'], 2, '.', '') . ' ' . $pos_settings->currency . '</td>
             </tr>
             <tr>';

            // payments
            switch ($data['payment_method']) {
                case 'cash':
                    $ticket .=
                        '<td style="text-align:left; font-weight:500; padding-top:5px;">' . _l("paid") . '</td>
                             <td style="padding-top:5px; text-align:right; font-weight:500;">' . number_format((float)$data['paid_amount'], 2, '.', '') . ' ' . $pos_settings->currency . '</td>
                        </tr>
                        <tr>
                            <td style="text-align:left; font-weight:500; padding-top:5px;">' . _l("change") . '</td>
                            <td style="padding-top:5px; text-align:right; font-weight:500;">' . number_format((float)$data['return_change'], 2, '.', '') . ' ' . $pos_settings->currency . '</td>
                        </tr>
                        <tr>
                            <td style="text-align:left; font-weight:500; padding-top:5px;">' . _l("payment_method") . '</td>
                            <td style="padding-top:5px; text-align:right; font-weight:500;">' . _l($data['payment_method']) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>';
                    break;
            }

            // ticket footer
            $ticket .= '<div style="border-top:1px solid #000; padding-top:10px; font-weight: 500;">
                <span style="float: left; margin-bottom: 1em;">' . get_option('companyname') . '</span><span style="float: right; margin-bottom: 1em;">' . _l("tel") . ' ' . get_option('invoice_company_phonenumber') . '</span><div style="clear:both;"><div class="text-center" style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;">' . _l('thank_you') . '</div></div>';

            echo $ticket;
        } else {
            echo _l('NotFoundError');
        }
    }

    public function add_product()
    {
        if (!has_permission('products', '', 'view')) {
            access_denied('products View');
        }
        close_setup_menu();
        if (has_permission('products', '', 'view')) {
            $post = $this->input->post();
            if (!empty($post)) {
                $this->form_validation->set_rules('new_product_name', 'product name', 'required');
                $this->form_validation->set_rules('new_product_code', 'product code', 'required|is_unique[product_master.barcode]');
                $this->form_validation->set_rules('new_product_description', 'product description', 'required');
                $this->form_validation->set_rules('new_branch_id', 'product branch', 'required');
                $this->form_validation->set_rules('new_category_id', 'product category', 'required');
                $this->form_validation->set_rules('new_price', 'product price', 'required');
                $this->form_validation->set_rules('new_quantity_number', 'product quantity', 'required');
                if (false == $this->form_validation->run()) {
                    set_alert('danger', preg_replace("/\r|\n/", '', validation_errors()));
                } else {
                    $data = [
                        'name' => $post['new_product_name'],
                        'barcode' => $post['new_product_code'],
                        'description' => $post['new_product_description'],
                        'branch_id' => $post['new_branch_id'],
                        'category_id' => $post['new_category_id'],
                        'subcategory_id' => $post['new_subcategory_id'],
                        'price' => $post['new_price'],
                        'quantity_number' => $post['new_quantity_number'],
                    ];
                    $inserted_id = $this->products_model->add_product($data);
                    if ($inserted_id) {
                        handle_product_upload($inserted_id);
                        set_alert('success', 'Product Added successfully');
                        redirect(admin_url('products/pos'), 'refresh');
                    } else {
                        set_alert('warning', _l('Error Found - Product not inserted'));
                    }
                }
            }
        } else {
            access_denied('products');
        }
    }

    public function settings()
    {
        $data['settings'] = $this->pos_model->get_settings();
        $data['staffs'] = $this->staff_model->get('', ['active' => 1]);
        $data['branches'] = $this->branch_model->get();
        $data['title'] = _l('pos_settings');
        $this->load->view('products/pos/settings', $data);
    }

    public function update_settings()
    {
        $data = $this->input->post();
        if ($data) {
            $success = $this->pos_model->update_settings([
                'currency' => $data['currency'],
                'is_keyboard_active' => $data['is_keyboard_active'],
                'tax_rate' => $data['tax_rate'],
            ]);

            if (isset($data['branch'])) {
                foreach ($data['branch'] as $key => $item)
                    if ($this->db->field_exists('pos_branch_id', db_prefix() . 'staff')) {
                        $this->db->where('staffid', $key);
                        $this->db->update(db_prefix() . 'staff', ['pos_branch_id' => $item === '' ? null : $item]);
                    }
            }

            if ($success) {
                set_alert('success', _l('pos_settings_updated'));
            } else {
                set_alert('warning', _l('pos_settings_update_error'));
            }
        }
        return redirect(admin_url('products/pos/settings'), 'refresh');
    }
}
