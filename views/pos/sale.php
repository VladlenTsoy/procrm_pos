<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div id="pos_page" class="content">
        <div class="row">
            <audio id="scannerBeepSoundClip" preload="auto">
                <source src="<?php echo module_dir_url(PRODUCTS_MODULE_NAME, 'assets/audio/scanner_beep.mp3')?>"/>
            </audio>
            <audio id="deleteProductSoundClip" preload="auto">
                <source
                    src="<?php echo module_dir_url(PRODUCTS_MODULE_NAME, 'assets/audio/beep-07.mp3')?>" />
            </audio>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 id="currentSelectedBranch" class="no-margin relative">
                            <?php echo _l('branch') ?>: <span></span>
                            <i onclick="initPOS()" id="editBranchBtn" class="fa fa-pencil"></i>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Orders list -->
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="card">
                            <div class="card-body" style="padding-bottom: 0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo render_select('lead_id', $leads, ['id', 'name'], '', !empty(set_value('id')) ? set_value('id') : '', ['title'=> _l('select_lead'), 'class'=>'pos-selectpicker']); ?>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" onclick="init_lead(); "
                                                    class="btn pos-transparent-btn" data-toggle="modal"
                                                    data-target="#addCustomer"><i class="fa fa-user-plus"></i><?php echo _l('new_lead'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn"
                                                    data-toggle="modal" data-target="#notes-modal"><i
                                                        class="fa fa-pencil"></i><?php echo _l('note'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn"
                                                    data-toggle="modal" data-target="#addShipping"><i
                                                        class="fa fa-truck"></i><?php echo _l('shipping'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn"
                                                    data-toggle="modal" data-target="#addNewProductModal"><i
                                                        class="fa fa-plus"></i><?php echo _l('item'); ?></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="table-responsive transaction-list">
                                                <table id="products-table" class="table order-list table-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-3"><?php echo _l('product')?>
                                                            </th>
                                                            <th class="col-sm-3"><?php echo _l('quantity')?>
                                                            </th>
                                                            <th class="col-sm-2"><?php echo _l('price')?>
                                                            </th>
                                                            <th class="col-sm-2"><?php echo _l('discount')?>%
                                                            </th>
                                                            <th class="col-sm-1"><?php echo _l('total')?>
                                                            </th>
                                                            <th class="col-sm-1"><?php echo _l('action')?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none;">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_qty" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_discount" value="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="total_price" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="item" />
                                                    <input type="hidden" name="order_tax" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="grand_total" />
                                                    <input type="hidden" name="coupon_discount" />
                                                    <input type="hidden" name="sale_status" value="1" />
                                                    <input type="hidden" name="coupon_active">
                                                    <input type="hidden" name="coupon_id">
                                                    <input type="hidden" name="coupon_discount" />

                                                    <input type="hidden" name="pos" value="1" />
                                                    <input type="hidden" name="draft" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 totals"
                                            style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
                                            <div class="row" style="border-bottom: 1px solid #f5f5f5">
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('items')?>
                                                    </span><span id="item">0</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('total')?>
                                                    </span><span id="subtotal">0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('discount')?>
                                                    </span><span id="discount">0.00</span>
                                                </div>
                                            </div>
                                            <div class="row" style="border-bottom: 1px solid #f5f5f5">
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('coupon')?>
                                                        <button type="button" class="btn btn-link" data-toggle="modal"
                                                            data-target="#coupon-modal"><i
                                                                class="fa fa-pencil"></i></button></span><span
                                                        id="coupon-text">0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('shipping')?>
                                                        <button type="button" class="btn btn-link" data-toggle="modal"
                                                            data-target="#shipping-cost-modal"><i
                                                                class="fa fa-pencil"></i></button></span><span
                                                        id="shipping-cost">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-amount">
                                <h2><?php echo _l('grand_total') ?>:
                                    <span id="grand-total">0.00</span>
                                </h2>
                            </div>
                            <div class="additional-options">
                                <div class="row">
                                    <div class="column-5 col-md-6">
                                        <button style="background: #0984e3" type="button"
                                            class="btn btn-custom payment-btn" id="paymentBtn"><i
                                                class="fa fa-credit-card"></i> <?php echo _l('pay') ?></button>
                                    </div>
                                    <div class="column-5 col-md-6">
                                        <button style="background-color: #d63031;" type="button" class="btn btn-custom"
                                            id="cancel-btn"><i class="fa fa-close"></i> <?php echo _l('cancel') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- notes modal -->
            <div id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('note') ?>
                            </h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea type="text" name="notes" class="form-control" rows="10"
                                    maxlength="200"></textarea>
                            </div>
                            <button type="button" name="notes_btn" class="btn btn-primary" data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- add new product modal -->
            <div id="addNewProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('new_product') ?>
                            </h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <?php echo form_open_multipart('products/pos/add_product'); ?>
                        <div class="modal-body">
                            <?php echo render_input('new_product_name', 'product_name', $product->name ?? ''); ?>
                            <div class="form-group" app-field-wrapper="new_product_code">
                                <label for="new_product_code" class="control-label"> <small class="req text-danger">*
                                    </small><?php echo _l('product_code') ?></label>
                                <div class="relative">
                                    <input type="text" id="new_product_code" name="new_product_code"
                                        class="form-control"
                                        value="<?php echo $product->barcode ?? '' ?>">
                                    <span id="productAddBarcodeBtn" class="btn btn-info">
                                        <i>
                                            <svg id="Capa_1" stroke="white" stroke-width="10"
                                                enable-background="new 0 0 512 512" height="20"
                                                style="width: 20px; height: 20px; vertical-align: middle;"
                                                viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg">
                                                <g>
                                                    <path
                                                        d="m196.992 234.287h-179.497c-9.646 0-17.495 7.848-17.495 17.495v119.687c0 9.646 7.849 17.495 17.495 17.495h179.497c9.646 0 17.494-7.848 17.494-17.495v-119.687c0-9.647-7.847-17.495-17.494-17.495zm2.494 137.182c0 1.375-1.119 2.495-2.494 2.495h-179.497c-1.376 0-2.495-1.119-2.495-2.495v-119.687c0-1.375 1.119-2.495 2.495-2.495h179.497c1.375 0 2.494 1.119 2.494 2.495z" />
                                                    <path
                                                        d="m163.051 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z" />
                                                    <path
                                                        d="m135.147 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z" />
                                                    <path
                                                        d="m107.243 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z" />
                                                    <path
                                                        d="m51.436 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z" />
                                                    <path
                                                        d="m504.5 349.42h-23.53c-21.212 0-38.47 17.258-38.47 38.47v39.58c0 12.941-10.524 23.47-23.46 23.47h-19.39c-16.474 0-29.987-12.894-30.994-29.119l17.764-3.852c20.438-4.437 33.971-23.44 31.472-44.24l-23.227-185.612c14.005-3.713 26.685-11.597 36.248-22.685 11.289-13.089 17.506-29.828 17.506-47.132 0-39.833-32.402-72.24-72.229-72.24h-43.01c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h43.011c31.557 0 57.229 25.678 57.229 57.24 0 28.315-20.282 52.086-48.227 56.523-2.953.469-5.982.707-9.003.707h-179.73c-6.094 0-11.544-3.632-13.886-9.253l-39.832-95.645c-.904-2.167-.676-4.532.628-6.488 1.306-1.959 3.405-3.083 5.76-3.083h149.05c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-149.05c-7.349 0-14.168 3.651-18.242 9.766-2.827 4.242-4.046 9.246-3.585 14.174h-14.723c-4.185 0-8.07 2.08-10.394 5.564-2.324 3.485-2.75 7.874-1.141 11.74l29.809 71.56c1.931 4.693 6.463 7.726 11.546 7.726h24.055l2.272 5.455c4.679 11.229 15.564 18.485 27.732 18.485h67.115c2.868 8.589 4.33 17.631 4.217 26.437-.018 1.374-.068 2.752-.118 4.132-.197 5.434-.4 11.054 1.102 16.902 4.169 16.28 19.189 25.447 31.854 28.597 4.718 1.174 9.674 1.809 15.247 1.942l1.032 8.188c.479 3.792 3.708 6.563 7.432 6.563.313 0 .629-.02.947-.06 4.109-.518 7.021-4.269 6.504-8.378l-10.626-84.323s57.457-.042 58.672-.103l23.167 185.128c1.566 13.038-6.931 24.97-19.764 27.756l-61.608 13.359c-4.602.994-9.329-.127-12.988-3.078-3.656-2.95-5.754-7.335-5.754-12.032v-9.19c0-7.224 5.123-13.579 12.184-15.111l4.642-1.009c13.72-2.966 22.796-15.713 21.106-29.688l-4.62-36.67c-.518-4.109-4.262-7.017-8.379-6.504-4.109.518-7.021 4.269-6.504 8.379l4.616 36.632c.749 6.2-3.287 11.87-9.397 13.191l-4.647 1.01c-13.906 3.018-24 15.538-24 29.769v9.19c0 9.255 4.132 17.896 11.337 23.708 5.485 4.424 12.196 6.761 19.079 6.761 2.162 0 4.341-.23 6.504-.699l29.075-6.305c2.567 22.984 22.108 40.915 45.766 40.915h19.39c21.207 0 38.46-17.257 38.46-38.47v-39.58c0-12.941 10.528-23.47 23.47-23.47h23.53c4.143 0 7.5-3.358 7.5-7.5s-3.359-7.5-7.502-7.5zm-360.427-197.83-27.737-66.59h16.141l27.732 66.59zm169.901 101.857c-3.531-.2-6.724-.658-9.723-1.405-10.639-2.646-18.859-9.618-20.946-17.767-.964-3.75-.808-8.065-.642-12.633.054-1.498.107-2.996.126-4.484.114-8.851-1.097-17.893-3.524-26.627h26.781z" />
                                                </g>
                                            </svg>
                                        </i>
                                    </span>
                                </div>
                            </div>
                            <?php echo render_textarea('new_product_description', 'product_description', $product->description ?? ''); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo render_select('new_branch_id', $branches_list, ['id', 'name'], 'product_branch'); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo render_select('new_category_id', [], ['id', 'name'], 'product_category', '', ['title' => 'first_select_branch']); ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo render_select('new_subcategory_id', [], ['id', 'name'], 'product_subcategory', '', ['title' => 'first_select_category']); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <?php echo render_input('new_price', _l('Price'), $product->price ?? '', 'number'); ?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo render_input('new_quantity_number', 'quantity', $product->quantity_number ?? '', 'number'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="attachment">
                                        <div class="form-group">
                                            <label for="attachment" class="control-label"><small
                                                    class="req text-danger">* </small><?php echo _l('product_image'); ?></label>
                                            <input type="file" extension="png,jpg,jpeg,gif"
                                                filesize="<?php echo file_upload_max_size(); ?>"
                                                class="form-control" name="product" id="product" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("Close");?></button>
                            <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <!-- payment modal -->
            <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="exampleModalLabel" class="modal-title float-left"><?php echo _l('finalize_sale') ?>
                            </h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <?php echo form_open('products/pos/add_sale', ['id'=>'pos-payment-form', 'method'=>'post', 'files'=>true,'class'=>'pos-payment-form' ]); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <h2 id="customerName"><?php echo _l("lead");?>:
                                    <span></span>
                                </h2>
                            </div>
                            <div class="form-group">
                                <p id="sale_notes"><?php echo _l("note");?>:
                                    <span></span>
                                </p>
                            </div>
                            <div class="form-group">
                                <h3 id="ItemsNum2"><span>0</span> <?php echo _l("item(s)");?>
                                </h3>
                            </div>
                            <div class="form-group">
                                <h2 id="TotalModal"><?php echo _l('total')?>
                                    <span></span>
                                </h2>
                            </div>
                            <div class="form-group">
                                <label for="paymentMethod"><?php echo _l("payment_method");?></label>
                                <select class="js-select-options form-control" id="paymentMethod">
                                    <option value="0"><?php echo _l("cash");?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group Paid">
                                <label for="Paid"><?php echo _l("paid");?></label>
                                <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text"
                                    value="0" name="paid" class="form-control" id="paidModalInput"
                                    placeholder="<?php echo _l("paid");?>">
                            </div>
                            <div class="form-group ReturnChange">
                                <h3 id="ReturnChange"><?php echo _l("change");?>
                                    <span>0</span> <?php echo get_option('product_currency')?>
                                </h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l("close");?></button>
                            <button type="button" class="btn btn-primary" id="saleBtn" onclick="posSale()"><?php echo _l("submit");?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <!-- coupon modal -->
            <div id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('coupon_code') ?>
                            </h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="coupon-code" class="form-control"
                                    placeholder="<?php echo _l('coupon_code') ?>...">
                            </div>
                            <button type="button" class="btn btn-primary coupon-check" data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shipping_cost modal -->
            <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('shipping_cost') ?>
                            </h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="shipping_cost" class="form-control numkey" step="any">
                            </div>
                            <button type="button" name="shipping_cost_btn" class="btn btn-primary"
                                data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ticket modal -->
            <div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" id="ticketModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title float-left" id="ticket"><?php echo _l("receipt");?>
                            </h3>
                        </div>
                        <div class="modal-body" id="modal-body">
                            <div id="printSection">
                                <!-- Ticket goes here -->
                                <center>
                                    <h1 style="color:#34495E"><?php echo _l("empty");?>
                                    </h1>
                                </center>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default hiddenpr modal-close"
                                data-dismiss="modal"><?php echo _l("сlose");?></button>
                            <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?php echo _l("print");?></button>
                        </div>
                        <div id="elementH"></div>
                    </div>
                </div>
            </div>
            <!-- livestream_scanner-->
            <div class="modal fade" id="livestream_scanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" id="livestream_scannerModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close mclose" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title"><?php echo _l('barcode_scanner') ?>
                            </h4>
                        </div>
                        <div class="modal-body" style="position: static">
                            <div id="interactive" class="viewport"></div>
                            <div class="error"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mclose" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <!--header navbar-->
                        <header class="header">
                            <nav class="navbar">
                                <div class="navbar-holder d-flex align-items-center justify-content-between">
                                    <a id="btnFullscreen" href="#" class="expand-btn"><i class="fa fa-window-maximize">
                                        </i></a>
                                    <div class="navbar-header">
                                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                            <li class="nav-item">
                                                <a id="btnCalculator" data-toggle="modal"
                                                    data-target="#calculator_modal"><i class="fa fa-calculator"></i>
                                                    <?php echo _l('calculator')?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a id="btnBarcodeReader">
                                                    <i>
                                                        <svg id="Capa_1" enable-background="new 0 0 512 512" height="20"
                                                            style="width: 20px; height: 20px; vertical-align: middle;"
                                                            viewBox="0 0 512 512" width="512"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <g>
                                                                <path
                                                                    d="m196.992 234.287h-179.497c-9.646 0-17.495 7.848-17.495 17.495v119.687c0 9.646 7.849 17.495 17.495 17.495h179.497c9.646 0 17.494-7.848 17.494-17.495v-119.687c0-9.647-7.847-17.495-17.494-17.495zm2.494 137.182c0 1.375-1.119 2.495-2.494 2.495h-179.497c-1.376 0-2.495-1.119-2.495-2.495v-119.687c0-1.375 1.119-2.495 2.495-2.495h179.497c1.375 0 2.494 1.119 2.494 2.495z" />
                                                                <path
                                                                    d="m163.051 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z" />
                                                                <path
                                                                    d="m135.147 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z" />
                                                                <path
                                                                    d="m107.243 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z" />
                                                                <path
                                                                    d="m51.436 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z" />
                                                                <path
                                                                    d="m504.5 349.42h-23.53c-21.212 0-38.47 17.258-38.47 38.47v39.58c0 12.941-10.524 23.47-23.46 23.47h-19.39c-16.474 0-29.987-12.894-30.994-29.119l17.764-3.852c20.438-4.437 33.971-23.44 31.472-44.24l-23.227-185.612c14.005-3.713 26.685-11.597 36.248-22.685 11.289-13.089 17.506-29.828 17.506-47.132 0-39.833-32.402-72.24-72.229-72.24h-43.01c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h43.011c31.557 0 57.229 25.678 57.229 57.24 0 28.315-20.282 52.086-48.227 56.523-2.953.469-5.982.707-9.003.707h-179.73c-6.094 0-11.544-3.632-13.886-9.253l-39.832-95.645c-.904-2.167-.676-4.532.628-6.488 1.306-1.959 3.405-3.083 5.76-3.083h149.05c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-149.05c-7.349 0-14.168 3.651-18.242 9.766-2.827 4.242-4.046 9.246-3.585 14.174h-14.723c-4.185 0-8.07 2.08-10.394 5.564-2.324 3.485-2.75 7.874-1.141 11.74l29.809 71.56c1.931 4.693 6.463 7.726 11.546 7.726h24.055l2.272 5.455c4.679 11.229 15.564 18.485 27.732 18.485h67.115c2.868 8.589 4.33 17.631 4.217 26.437-.018 1.374-.068 2.752-.118 4.132-.197 5.434-.4 11.054 1.102 16.902 4.169 16.28 19.189 25.447 31.854 28.597 4.718 1.174 9.674 1.809 15.247 1.942l1.032 8.188c.479 3.792 3.708 6.563 7.432 6.563.313 0 .629-.02.947-.06 4.109-.518 7.021-4.269 6.504-8.378l-10.626-84.323s57.457-.042 58.672-.103l23.167 185.128c1.566 13.038-6.931 24.97-19.764 27.756l-61.608 13.359c-4.602.994-9.329-.127-12.988-3.078-3.656-2.95-5.754-7.335-5.754-12.032v-9.19c0-7.224 5.123-13.579 12.184-15.111l4.642-1.009c13.72-2.966 22.796-15.713 21.106-29.688l-4.62-36.67c-.518-4.109-4.262-7.017-8.379-6.504-4.109.518-7.021 4.269-6.504 8.379l4.616 36.632c.749 6.2-3.287 11.87-9.397 13.191l-4.647 1.01c-13.906 3.018-24 15.538-24 29.769v9.19c0 9.255 4.132 17.896 11.337 23.708 5.485 4.424 12.196 6.761 19.079 6.761 2.162 0 4.341-.23 6.504-.699l29.075-6.305c2.567 22.984 22.108 40.915 45.766 40.915h19.39c21.207 0 38.46-17.257 38.46-38.47v-39.58c0-12.941 10.528-23.47 23.47-23.47h23.53c4.143 0 7.5-3.358 7.5-7.5s-3.359-7.5-7.502-7.5zm-360.427-197.83-27.737-66.59h16.141l27.732 66.59zm169.901 101.857c-3.531-.2-6.724-.658-9.723-1.405-10.639-2.646-18.859-9.618-20.946-17.767-.964-3.75-.808-8.065-.642-12.633.054-1.498.107-2.996.126-4.484.114-8.851-1.097-17.893-3.524-26.627h26.781z" />
                                                            </g>
                                                        </svg>
                                                    </i>
                                                    <?php echo _l('barcode')?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </header>
                        <div class="row">
<!--                            <div class="col-md-4">-->
<!--                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip"-->
<!--                                    data-title="--><?php //echo _l('branch'); ?><!--"></i>-->
<!--                                --><?php //echo render_select('branch_id', $branches_list, ['id', 'name'], 'branch', !empty(set_value('branch_id')) ? set_value('branch_id') : $product->branch_id ?? ''); ?>
<!--                            </div>-->
                            <div class="col-md-6">
                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip"
                                    data-title="<?php echo _l('first_select_branch'); ?>"></i>
                                <?php echo render_select('category_id', [], ['id', 'name'], 'category', !empty(set_value('category_id')) ? set_value('category_id') : $product->category_id ?? '', ['title' => 'first_select_branch']); ?>
                            </div>
                            <div class="col-md-6">
                                <i class="fa fa-question-circle pull-left" data-toggle="tooltip"
                                    data-title="<?php echo _l('first_select_category'); ?>"></i>
                                <?php echo render_select('subcategory_id', [], ['id', 'name'], 'subcategory', !empty(set_value('subcategory_id')) ? set_value('subcategory_id') : $product->subcategory_id ?? '', ['title' => 'first_select_category']); ?>
                            </div>
                            <div class="col-md-12 mt-1 table-container">
                                <div id="products-list">
                                    <input type="text" class="search form-group" id="productSearchBox"
                                        placeholder="<?php echo _l('search_by') ?>" />

                                    <ul class="list">
                                        <?php for ($i = 0; $i < count($products_list); $i++) { ?>
                                        <li class="product-img sound-btn"
                                            title="<?php echo $products_list[$i]['name']?>"
                                            data-product="<?php echo $products_list[$i]['name'].'***productcode***'. $products_list[$i]['barcode'] ?>">
                                            <img src="<?php echo module_dir_url('products', 'uploads/' . $products_list[$i]['image_url']) ?>"
                                                width="100%">
                                            <p class="productName"><?php echo $products_list[$i]['name']?>
                                            </p>
                                            <span><?php echo $products_list[$i]['price']?></span>
                                            <p class="productBranch" hidden><?php echo $products_list[$i]['branch_id']?>
                                            </p>
                                            <p class="productCategory" hidden><?php echo $products_list[$i]['category_id']?>
                                            </p>
                                            <p class="productSubCategory" hidden><?php echo $products_list[$i]['subcategory_id']?>
                                            </p>
                                            <p class="productCode" hidden><?php echo $products_list[$i]['barcode']?>
                                            </p>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    <ul class="pagination"></ul>
                                </div>
                            </div>

                            <!--                            <div class="col-md-12">-->
                            <!--                                <div id="posWindowButtons">-->
                            <!--                                    <ul class="list">-->
                            <!--                                        <li class="posWindowN0 active-pos-window" onclick="goToPosWindow(this)">1</li>-->
                            <!--                                    </ul>-->
                            <!--                                    <button class="new-pos-window-btn" onclick="addNewPosWindow()">+</button>-->
                            <!--                                    <button class="remove-pos-window-btn" onclick="removePosWindow()">-</button>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('products/pos/calculator_modal'); ?>
<?php init_tail(); ?>
<script
    src="<?php echo module_dir_url('products', 'assets/js/jquery.redirect.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/jqueryPrint.min.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/list.min.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/sweetalert.min.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/keyboard.min.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/keyboard.extension.all.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/barcode/quagga.js')?>">
</script>
<script
    src="<?php echo module_dir_url('products', 'assets/js/pos.js')?>">
</script>

<script>
    var rowindex;
    var productCodesInOrder = [];
    var pList = <?php echo json_encode($products_list) ?> ;
    var filteredProductList = [];
    var branchesList = <?php echo json_encode($branches_list) ?> ;
    var categoriesList = <?php echo json_encode($categories_list) ?> ;
    var subcategoriesList = <?php echo json_encode($subcategories_list) ?> ;
    var keyboard_active = <?php echo json_encode($settings->is_keyboard_active); ?> ;

    var posWindowsData = [];
    var lastPosWindowIndex = 1;
    var activePosWindowIndex = 0;

    if (pList.length) {
        var productsList = new List('products-list', {
            valueNames: ['productName', 'productBranch', 'productCategory', 'productSubCategory',
                'productCode'
            ],
            page: 10,
            pagination: [{
                innerWindow: 3,
                outerWindow: 5,
            }],
        });
        filteredProductList = productsList.items;
    }

    function addNewPosWindow() {
        console.log('preactive: ' + (activePosWindowIndex + 1));
        // get the last window position
        var lastPosWindowPosition = $('#posWindowButtons .list li').last().index();
        if (lastPosWindowPosition == 0) lastPosWindowIndex = 1;

        // remove active status from all buttons
        $('#posWindowButtons .list li').removeClass('active-pos-window');

        // append a new pos window button and set active status
        $('#posWindowButtons .list').append(
            `<li class="posWindowN${lastPosWindowIndex} active-pos-window" onclick="goToPosWindow(this)">${lastPosWindowIndex+1}</li>`
        );

        // save previous active pos window data
        var posData = {
            'lead_id': $('#lead_id').val(),
            'sale_notes': $('textarea[name="notes"]').val(),
        }
        posWindowsData[activePosWindowIndex] = posData;

        // empty inputs for new pos window
        $('#lead_id').val('').selectpicker('refresh');
        $('textarea[name="notes"]').val('');

        // set a new last indicator number and active pos window index
        lastPosWindowIndex++;
        activePosWindowIndex = lastPosWindowPosition + 1;
    }

    function removePosWindow() {
        // get index of active status page
        var position = $('#posWindowButtons .list li').index($('.active-pos-window'));

        // if 1st page don't remove anything
        if (position === 0) return false;

        // else remove current active pos window data
        $('#posWindowButtons .list').find('.active-pos-window').remove();
        if (posWindowsData[position]) {
            posWindowsData.splice(position, 1);
        }

        // reactivate status to the 1st page and set page's data
        var lastPosWindowPosition = $('#posWindowButtons .list li').last().index();
        activePosWindowIndex = lastPosWindowPosition;
        var newActivePosData = posWindowsData[activePosWindowIndex];
        $('#posWindowButtons .list li').last().addClass('active-pos-window');

        // set input values
        $('#lead_id').val(newActivePosData.lead_id).selectpicker('refresh');
        $('textarea[name="notes"]').val(newActivePosData.sale_notes);
    }

    function goToPosWindow(page) {
        // get index of page
        var position = $('#posWindowButtons .list li').index($(page));

        // save previous active pos window data
        var oldPosData = {
            'lead_id': $('#lead_id').val(),
            'sale_notes': $('textarea[name="notes"]').val(),
        }
        posWindowsData[activePosWindowIndex] = oldPosData;

        // set new active pos indicator and data to new active pos
        activePosWindowIndex = position;
        var newPosData = posWindowsData[position];
        $('#lead_id').val(newPosData.lead_id).selectpicker('refresh');
        $('textarea[name="notes"]').val(newPosData.sale_notes);

        // toggle active status
        $('#posWindowButtons .list li').removeClass('active-pos-window');
        $('#posWindowButtons .list li:nth-child(' + (position + 1) + ')').addClass('active-pos-window');
    }

    if (keyboard_active == 1) {
        $("input.numkey:text").keyboard({
            usePreview: false,
            layout: 'custom',
            display: {
                'accept': '&#10004;',
                'cancel': '&#10006;'
            },
            customLayout: {
                'normal': ['1 2 3', '4 5 6', '7 8 9', '0 {dec} {bksp}', '{clear} {cancel} {accept}']
            },
            restrictInput: true, // Prevent keys not in the displayed keyboard from being typed in
            preventPaste: true, // prevent ctrl-v and right click
            autoAccept: true,
            css: {
                // input & preview
                // keyboard container
                container: 'center-block dropdown-menu', // jumbotron
                // default state
                buttonDefault: 'btn btn-default',
                // hovered button
                buttonHover: 'btn-primary',
                // Action keys (e.g. Accept, Cancel, Tab, etc);
                // this replaces "actionClass" option
                buttonAction: 'active'
            },
        });
        $('input[type="text"]').keyboard({
            usePreview: false,
            autoAccept: true,
            autoAcceptOnEsc: true,
            display: {
                'accept': '&#10004; <?php echo _l('accept') ?>',
                'cancel': '&#10006; <?php echo _l('cancel') ?>',
                'bksp': '&#8678; <?php echo _l('delete') ?>'
            },
            customLayout: {
                'normal': ['1 2 3', '4 5 6', '7 8 9', '0 {dec} {bksp}', '{clear} {cancel} {accept}']
            },
            css: {
                // input & preview
                // keyboard container
                container: 'center-block dropdown-menu', // jumbotron
                // default state
                buttonDefault: 'btn btn-default',
                // hovered button
                buttonHover: 'btn-primary',
                // Action keys (e.g. Accept, Cancel, Tab, etc);
                // this replaces "actionClass" option
                buttonAction: 'active',
                // used when disabling the decimal button {dec}
                // when a decimal exists in the input area
                buttonDisabled: 'disabled'
            },
            change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')
            }
        });
        $('input[type="search"]').keyboard({
            usePreview: false,
            autoAccept: true,
            autoAcceptOnEsc: true,
            css: {
                // input & preview
                // keyboard container
                container: 'center-block dropdown-menu', // jumbotron
                // default state
                buttonDefault: 'btn btn-default',
                // hovered button
                buttonHover: 'btn-primary',
                // Action keys (e.g. Accept, Cancel, Tab, etc);
                // this replaces "actionClass" option
                buttonAction: 'active',
                // used when disabling the decimal button {dec}
                // when a decimal exists in the input area
                buttonDisabled: 'disabled'
            },
            change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')
            }
        });
        $('textarea').keyboard({
            usePreview: false,
            autoAccept: true,
            autoAcceptOnEsc: true,
            css: {
                // input & preview
                // keyboard container
                container: 'center-block dropdown-menu', // jumbotron
                // default state
                buttonDefault: 'btn btn-default',
                // hovered button
                buttonHover: 'btn-primary',
                // Action keys (e.g. Accept, Cancel, Tab, etc);
                // this replaces "actionClass" option
                buttonAction: 'active',
                // used when disabling the decimal button {dec}
                // when a decimal exists in the input area
                buttonDisabled: 'disabled'
            },
            change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')
            }
        });

        $('#productSearchBox').keyboard().autocomplete().addAutocomplete({
            // add autocomplete window positioning
            // options here (using position utility)
            position: {
                of: '#productSearchBox',
                my: 'top+18px',
                at: 'center',
                collision: 'flip'
            }
        });
    }

    if (keyboard_active == 1) {
        $('#productSearchBox').bind('keyboardChange', function(e, keyboard, el) {
            var lead_id = $('#lead_id').val();
            temp_data = $('#productSearchBox').val();
            if (!lead_id) {
                $('#productSearchBox').val(temp_data.substring(0, temp_data.length - 1));
                Swal.fire(
                    '<?php echo _l('select_lead'); ?>'
                );
            } else {
                productsList.filter(function(pro) {
                    var ps = false;
                    if (temp_data) {
                        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(temp_data), "i");
                        for (item of filteredProductList) {
                            if (matcher.test(item.values().productName + item.values().productCode)) {
                                if (pro.values().productCode == item.values().productCode) {
                                    ps = true;
                                }
                            }
                        }
                        return ps;
                    }
                    for (item of filteredProductList) {
                        if (pro.values().productCode == item.values().productCode) {
                            ps = true;
                        }
                    }
                    return ps;
                });
            }
        });
    } else {
        $('#productSearchBox').on('input', function() {
            var lead_id = $('#lead_id').val();
            if (!lead_id) {
                $('#productSearchBox').val('');
                Swal.fire(
                    '<?php echo _l('select_lead'); ?>'
                );
            } else {
                temp_data = $('#productSearchBox').val();
                productsList.filter(function(pro) {
                    var ps = false;
                    if (temp_data) {
                        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(temp_data), "i");
                        for (item of filteredProductList) {
                            if (matcher.test(item.values().productName + item.values().productCode)) {
                                if (pro.values().productCode == item.values().productCode) {
                                    ps = true;
                                }
                            }
                        }
                        return ps;
                    }
                    for (item of filteredProductList) {
                        if (pro.values().productCode == item.values().productCode) {
                            ps = true;
                        }
                    }
                    return ps;
                });
            }

        });
    }

    var productSearchBox = $('#productSearchBox');
    productSearchBox.autocomplete({
        source: function(request, response) {
            var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.map(filteredProductList, function(item) {
                if (matcher.test(item.values().productName + item.values().productCode)) {
                    return {
                        label: item.values().productName,
                        value: item.values().productCode
                    }
                }
            }));
        },
        response: function(event, ui) {
            if (ui.content.length == 1) {
                var data = ui.content[0].value;
                $(this).autocomplete("close");
                productSearch(data);
            }
        },
        select: function(event, ui) {
            var data = ui.item.value;
            productSearch(data);
            productSearchBox.val(ui.item.label);
            return false;
        },
    });

    $("#lead_id").change(function() {
        var id = $(this).val();

        if (id) {
            $('#customerName span').text($(this).find("option:selected").text());
        }
    });

    $("#products-table").on('click', '.plus', function() {
        rowindex = $(this).closest('tr').index();
        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
        checkQuantity(String(qty), true);
    });

    $("#products-table").on('click', '.minus', function() {
        rowindex = $(this).closest('tr').index();
        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) - 1;
        if (qty > 0) {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
        } else {
            qty = 1;
        }
        checkQuantity(String(qty), true);
    });

    $("#products-table").on('input', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if ($(this).val() < 1 && $(this).val() != '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
            Swal.fire(
                '<?php echo _l('wrong_quantity'); ?>'
            );
        }
        if ($(this).val() >= 1) {
            checkQuantity($(this).val(), true);
        }
    });

    $("#products-table").on('focusout', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if ($(this).val() < 1 || $(this).val() == '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
        }
        checkQuantity($(this).val(), true);
    });

    $("#products-table").on('focusout', 'input[name="discount"]', function() {
        rowindex = $(this).closest('tr').index();
        if ($(this).val() < 0 || $(this).val() == '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') input[name="discount"]').val(0);
        }
        checkQuantity($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(), true);
    });

    $("#products-table").on('click', '.qty', function() {
        rowindex = $(this).closest('tr').index();
    });

    $(document).on('click', '.sound-btn', function() {
        var audio = $("#scannerBeepSoundClip")[0];
        audio.play();
    });

    $(document).on('click', '.product-img', function() {
        var lead_id = $('#lead_id').val();
        if (!lead_id) {
            Swal.fire(
                '<?php echo _l('select_lead'); ?>'
            );
        } else {
            var data = $(this).data('product');
            data = data.split("***productcode***");
            productSearch(data[1]);
        }
    });

    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        var audio = $("#deleteProductSoundClip")[0];
        audio.play();
        rowindex = $(this).closest('tr').index();
        productCodesInOrder.splice(rowindex, 1);
        $(this).closest("tr").remove();
        calculateTotal();
    });

    $('#category_id').change(function() {
        var id = $(this).val();
        var selector = '';
        if (id) {
            scs = subcategoriesList.filter(c => c.parent_id == id);
            if (scs.length < 1) {
                $('#subcategory_id').selectpicker({
                    title: '<?php echo _l('empty') ?>'
                });
            } else {
                $('#subcategory_id').selectpicker({
                    title: '<?php echo _l('select_subcategory') ?>'
                });
            }
        } else {
            scs = '';
            $('#subcategory_id').selectpicker({
                title: '<?php echo _l('first_select_category') ?>'
            });
        }
        selector += '<option value=""></option>'
        for (let subcategory of scs) {
            selector += '<option value=' + subcategory.id + '>' + subcategory.name + '</option>';
        }
        $('#subcategory_id').html(selector).selectpicker('refresh');

        productsList.filter(function(pro) {
            if (id) {
                return pro.values().productBranch == $('#init_branch_id').val() && pro.values()
                    .productCategory == id;
            }
            return pro.values().productBranch == $('#init_branch_id').val();
        });
        filteredProductList = productsList.matchingItems;

        return false;
    });

    $('#subcategory_id').change(function() {
        var id = $(this).val();
        productsList.filter(function(pro) {
            if (id) {
                return pro.values().productBranch == $('#init_branch_id').val() && pro.values()
                    .productCategory == $('#category_id').val() && pro.values().productSubCategory ==
                    id;
            }
            return pro.values().productBranch == $('#init_branch_id').val() && pro.values()
                .productCategory == $('#category_id').val();
        });
        filteredProductList = productsList.matchingItems;

        return false;
    });

    $('#paymentBtn').click(function() {
        if (rowindex >= 0) {
            $('#add-payment').modal('show');
        } else {
            Swal.fire(
                '<?php echo _l('add_product_to_order') ?>'
            );
        }
    });

    $("#paidModalInput").keyup(function() {
        calculateChange($(this).val());
    });

    $("#paidModalInput").focusout(function() {
        if ($(this).val() == '') {
            $(this).val(0);
        }
        calculateChange($(this).val());
    });

    $('button[name="shipping_cost_btn"]').on("click", function() {
        calculateGrandTotal();
    });

    $('#cancel-btn').click(confirmCancel);

    async function initPOS() {
        const { value: formValues } = await Swal.fire({
            title: '<?php echo _l('enter_branch'); ?>',
            html:`<div class="form-group select-placeholder">
                        <select id="init_branch_id" name="init_branch_id" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                            <option value=""></option>
                            <?php foreach($branches_list as $branch){ ?>
                            <option value="<?php echo $branch['id']; ?>" ><?php echo $branch['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>`,
            focusConfirm: false,
            confirmButtonText: '<?php echo _l('continue') ?>&nbsp;<i class="fa fa-arrow-right"></i>',
            preConfirm: () => {
                if($('#init_branch_id').val() != '') {
                    var id = $('#init_branch_id').val();
                    var name = $('#init_branch_id').find(':selected').text();
                    $('#currentSelectedBranch span').text(name);
                    localStorage.setItem("selectedBranchId", id);
                    localStorage.setItem("selectedBranchName", name);
                    return id;
                }
                return false;
            },
            allowOutsideClick: false,
            didOpen: () => {
                if(localStorage.getItem("selectedBranchId")) {
                    $('#init_branch_id').selectpicker('val', localStorage.getItem("selectedBranchId"));
                }
                $('#init_branch_id').selectpicker('refresh');
            }
        });

        if (formValues) {
            selectBranch(formValues);
        }
    }
    if(localStorage.getItem("selectedBranchId")) {
        selectBranch(localStorage.getItem("selectedBranchId"));
        $('#currentSelectedBranch span').text(localStorage.getItem("selectedBranchName"))
    }else{
        initPOS();
    }

    function selectBranch(formValues) {
        var id = formValues;
        var selector = '';

        if (id) {
            sc = categoriesList.filter(c => c.branchIds.includes(id));
            if (sc.length < 1) {
                $('#category_id').selectpicker({
                    title: '<?php echo _l('empty') ?>'
                });
            } else {
                $('#category_id').selectpicker({
                    title: '<?php echo _l('select_category') ?>'
                });
            }
        } else {
            sc = '';
            $('#category_id').selectpicker({
                title: '<?php echo _l('first_select_branch') ?>'
            });
        }
        selector += '<option value=""></option>'
        for (let category of sc) {
            selector += '<option value=' + category.id + '>' + category.name + '</option>';
        }
        $('#category_id').html(selector).selectpicker('refresh');
        $('#subcategory_id').html('').selectpicker('refresh');

        productsList.filter(function (pro) {
            if (id) {
                return pro.values().productBranch.includes(id);
            }
            return true;
        });
        filteredProductList = productsList.matchingItems;
    }

    function productSearch(productCode) {
        var selectedProduct = pList.filter(p => p.barcode == productCode);
        if (selectedProduct.length > 0) {
            if (productCodesInOrder.includes(productCode)) {
                rowindex = productCodesInOrder.indexOf(productCode);
                var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                checkQuantity(qty, true);
            } else {
                if (selectedProduct[0].quantity_number > 0) {
                    addNewProduct(selectedProduct[0]);
                } else {
                    Swal.fire(
                        '<?php echo _l('low_stock')?>');
                }
            }
        }
    }

    function addNewProduct(data) {
        var newRow = $("<tr>");
        var cols = '';
        cols +=
            '<td class="col-sm-3 product-title"><button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"><strong class="product-name">' +
            data.name + '</strong></button></td>';
        cols +=
            '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="fa fa-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" value="1" step="any" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="fa fa-plus"></span></button></span></div></td>';
        cols += '<td class="col-sm-2 product-price">' + data.price + '</td>';
        cols +=
            '<td class="col-sm-2 discount"><input type="text" name="discount" class="form-control numkey discount-value input-number" value="0" step="any" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required=""></td>'
        cols += '<td class="col-sm-1 sub-total">' + data.price + '</td>';
        cols +=
            '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>';
        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data.id + '"/>';
        cols += '<input type="hidden" class="product-code" name="barcode" value="' + data.barcode + '"/>';
        cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + data.quantity_number + '"/>';
        cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" value="' + data.price + '" />';
        cols += '<input type="hidden" class="total_discount" name="total_discount" />';
        cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';
        newRow.append(cols);
        $("#products-table.order-list tbody").append(newRow);
        rowindex = newRow.index();
        checkQuantity(1, false);
    }

    function checkQuantity(sale_qty, existing_product_in_orders) {
        var row_barcode = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
        var row_sale_unit = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val();
        sale_qty = parseInt(sale_qty)

        if (row_sale_unit < sale_qty) {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(row_sale_unit);
            Swal.fire('<?php echo _l('low_stock')?>');
            return;
        }
        if (existing_product_in_orders) {

        } else {
            productCodesInOrder.push(row_barcode);
        }
        calculateRowProductData(sale_qty);
    }

    function calculateRowProductData(quantity) {
        var row_product_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price')
            .val();
        var row_product_discount = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
            '.discount-value').val();

        var sub_total = (row_product_price * quantity);
        var total_dis = sub_total * (row_product_discount / 100);
        sub_total -= total_dis;
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(
            2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.total_discount').val(total_dis.toFixed(
            2));

        calculateTotal();
    }

    function calculateTotal() {
        //Sum of quantity
        var total_qty = 0;
        $("table.order-list tbody .qty").each(function(index) {
            if ($(this).val() == '') {
                total_qty += 0;
            } else {
                total_qty += parseFloat($(this).val());
            }
        });
        $('input[name="total_qty"]').val(total_qty);

        //Sum of discount
        var total_discount = 0;
        $("table.order-list tbody tr .total_discount").each(function() {
            total_discount += parseFloat($(this).val());
        });

        $('input[name="total_discount"]').val(total_discount.toFixed(2));

        //Sum of subtotal
        var total = 0;
        $(".sub-total").each(function() {
            total += parseFloat($(this).text());
        });
        $('input[name="total_price"]').val(total.toFixed(2));

        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        var item = $('table.order-list tbody tr:last').index();
        var total_qty = parseFloat($('input[name="total_qty"]').val());
        var subtotal = parseFloat($('input[name="total_price"]').val());
        var order_tax =
            '<?php echo get_option("tax_percentage") ?>';
        if (!order_tax)
            order_tax = 0;
        var order_discount = parseFloat($('.total_discount').val());
        if (!order_discount)
            order_discount = 0.00;
        $("#discount").text(order_discount.toFixed(2));

        var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
        if (!shipping_cost)
            shipping_cost = 0.00;

        item = ++item + '(' + total_qty + ')';
        order_tax = subtotal * (order_tax / 100);
        var grand_total = subtotal + shipping_cost + order_tax;
        $('input[name="grand_total"]').val(grand_total.toFixed(2));

        // couponDiscount();
        var coupon_discount = parseFloat($('input[name="coupon_discount"]').val());
        if (!coupon_discount)
            coupon_discount = 0.00;
        grand_total -= coupon_discount;

        $('#item').text(item);
        $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
        $('#sale_notes span').text($('textarea[name="notes"]').val());
        $('#ItemsNum2 span').text(total_qty);
        $('#subtotal').text(subtotal.toFixed(2));
        $('input[name="order_tax"]').val(order_tax.toFixed(2));
        $('#shipping-cost').text(shipping_cost.toFixed(2));
        $('#grand-total').text(grand_total.toFixed(2));
        $('#TotalModal span').text(grand_total.toFixed(2));
        $('#paidModalInput').val(grand_total);
        $('input[name="grand_total"]').val(grand_total.toFixed(2));
    }

    function calculateChange(paid) {
        var change = -(parseFloat($('input[name="grand_total"]').val()) - parseFloat(paid));
        if (change < 0) {
            $('#ReturnChange span').text(change.toFixed(2));
            $('#ReturnChange span').addClass("text-danger");
            $('#ReturnChange span').removeClass("text-info");
            $('#saleBtn').attr('onclick', '');
        } else {
            $('#ReturnChange span').text(change.toFixed(2));
            $('#ReturnChange span').removeClass("text-danger");
            $('#ReturnChange span').addClass("text-info");
            $('#saleBtn').attr('onclick', 'posSale()');
        }
    }

    function posSale() {
        var leadId = $('#lead_id').val();
        var leadName = $('#lead_id').find('option:selected').text();
        var branchId = localStorage.getItem('selectedBranchId');
        var itemsNumber = $('input[name="item"]').val();
        var totalQuantity = $('input[name="total_qty"]').val();
        var totalDiscount = $('.total_discount').val();
        var totalTax = $('input[name="order_tax"]').val();
        var totalPrice = $('input[name="total_price"]').val();
        var returnChange = $('#ReturnChange span').text();
        var grandTotal = $('input[name="grand_total"]').val();
        var orderTaxRate =
            '<?php echo get_option("tax_percentage") ?>';
        var shippingCost = $('input[name="shipping_cost"]').val();
        var shippingDriverId = '';
        var paymentMethod = $('#paymentMethod').val();
        var paidAmount = $('#paidModalInput').val();
        var saleNotes = $('textarea[name="notes"]').val();
        var productIds = [];
        var productNames = [];
        var productQuantities = [];
        var productDiscounts = [];
        var productTotalPrices = [];
        $('table.order-list tbody tr').each(function() {
            productIds.push($(this).find('.product-id').val());
            productNames.push($(this).find('.product-name').text());
            productQuantities.push($(this).find('.qty').val());
            productDiscounts.push($(this).find('.total_discount').val());
            productTotalPrices.push($(this).find('.subtotal-value').val());
        });

        $.ajax({
            url: $("#pos-payment-form").attr('action'),
            type: "POST",
            data: {
                lead_id: leadId,
                lead_name: leadName,
                branch_id: branchId,
                items: itemsNumber,
                total_quantity: totalQuantity,
                total_discount: totalDiscount,
                total_tax: totalTax,
                total_price: totalPrice,
                return_change: returnChange,
                grand_total: grandTotal,
                order_tax_rate: orderTaxRate,
                shipping_cost: shippingCost,
                shipping_driver_id: shippingDriverId,
                payment_method: paymentMethod,
                paid_amount: paidAmount,
                sale_notes: saleNotes,
                product_ids: productIds,
                product_names: productNames,
                product_quantities: productQuantities,
                product_discounts: productDiscounts,
                product_total_prices: productTotalPrices
            },
            success: function(data) {
                $('#printSection').html(data);
                $('#add-payment').modal('hide');
                $('#ticket').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire('Error!');
            }
        });
    }

    function confirmCancel() {
        var audio = $("#deleteProductSoundClip")[0];
        audio.play();
        Swal.fire({
            title: '<?php echo _l('are_you_sure') ?>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?php echo _l('yes') ?>',
            cancelButtonText: '<?php echo _l('cancel') ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                cancel($('table.order-list tbody tr:last').index());
            }
        });
        return false;
    }

    function cancel(rownumber) {
        while (rownumber >= 0) {
            $('table.order-list tbody tr:last').remove();
            rownumber--;
        }
        $('input[name="shipping_cost"]').val('');
        $('input[name="order_discount"]').val('');
        calculateTotal();
    }

    // ------------------------------------------------------- //
    // barcode scanner
    // ------------------------------------------------------ //
    //
    function order_by_occurence(arr) {
        var counts = {};
        arr.forEach(function(value) {
            if (!counts[value]) {
                counts[value] = 0;
            }
            counts[value]++;
        });
        return Object.keys(counts).sort(function(curKey, nextKey) {
            return counts[nextKey] - counts[curKey];
        });
    }

    function barcodeScan() {
        var Quagga = window.Quagga;
        var App = {
            _scanner: null,
            init: function() {
                this.attachListeners();
            },
            activateScanner: function(addingNew) {
                var last_results = [];
                var scanner = this.configureScanner('#interactive'),
                    onDetected = function (result) {
                        if (result.codeResult.code) {
                            var last_code = result.codeResult.code;
                            last_results.push(last_code);
                            if (last_results.length === 20) {
                                accurateCode = order_by_occurence(last_results)[0];
                                last_results = [];
                                var audio = $("#scannerBeepSoundClip")[0];
                                audio.play();
                                if (addingNew) {
                                    $('#new_product_code').val(accurateCode);
                                } else {
                                    $('#productSearchBox').val(accurateCode);
                                    productSearch(accurateCode);
                                    productsList.filter(function(pro) {
                                        return pro.values().productCode.includes(accurateCode);
                                    });
                                }
                                stop();
                            }
                        }
                    }.bind(this),
                    stop = function() {
                        scanner.stop();  // should also clear all event-listeners?
                        scanner.removeEventListener('detected', onDetected);
                        this.hideOverlay();
                        this.attachListeners();
                    }.bind(this);

                this.showOverlay(stop);
                scanner.addEventListener('detected', onDetected).start().then(function (success){
                    console.log("success");
                }, function (err){
                    if(err) {
                        $('#livestream_scanner .modal-body .error').html('<div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i><?php echo _l('NotFoundError') ?></strong>: <?php echo _l('DeviceNotFound') ?></div>');
                    }
                });
            },
            attachListeners: function() {
                var self = this;
                btnBarcodeReader = document.querySelector('#btnBarcodeReader');
                productAddBarcodeBtn = document.querySelector('#productAddBarcodeBtn');


                btnBarcodeReader.addEventListener("click", function onClick(e) {
                    if(!$('#lead_id').val()){
                        $('#productSearchBox').val('');
                        Swal.fire(
                            '<?php echo _l('select_lead'); ?>'
                        );
                        return;
                    }
                    e.preventDefault();
                    btnBarcodeReader.removeEventListener("click", onClick);
                    self.activateScanner();
                });

                productAddBarcodeBtn.addEventListener("click", function onClick(e) {
                    e.preventDefault();
                    productAddBarcodeBtn.removeEventListener("click", onClick);
                    self.activateScanner();
                });

            },
            showOverlay: function(cancelCb) {
                $('#livestream_scanner button.mclose').on('click', function closeClick() {
                    $(this).unbind('click', closeClick);
                    cancelCb();
                });
                $('#livestream_scanner').modal('show');
            },
            hideOverlay: function() {
                $('#livestream_scanner').modal('hide');
            },
            configureScanner: function(selector) {
                if (!this._scanner) {
                    this._scanner = Quagga
                        .decoder(
                            {
                                readers: [
                                    "code_128_reader",
                                    "ean_reader",
                                    "ean_8_reader",
                                    "code_39_reader",
                                    "code_39_vin_reader",
                                    "codabar_reader",
                                    "upc_reader",
                                    "upc_e_reader",
                                    "i2of5_reader",
                                ],
                                multiple: false
                            }
                        )
                        .locator({patchSize: 'medium'})
                        .fromSource({
                            target: selector,
                            constraints: {
                                width: 600,
                                height: 400,
                                facingMode: "environment"
                            }
                        });
                }
                return this._scanner;
            }
        };
        App.init();
    }
    barcodeScan();

    $('#new_branch_id').change(function() {
        var id = $(this).val();
        var selector = '';

        if (id) {
            sc = categoriesList.filter(c => c.branchIds.includes(id));
            if (sc.length < 1) {
                $('#new_category_id').selectpicker({
                    title: '<?php echo _l('empty') ?>'
                });
            } else {
                $('#new_category_id').selectpicker({
                    title: '<?php echo _l('select_category') ?>'
                });
            }
        } else {
            sc = '';
            $('#new_category_id').selectpicker({
                title: '<?php echo _l('first_select_branch') ?>'
            });
        }
        selector += '<option value=""></option>'
        for (let category of sc) {
            selector += '<option value=' + category.id + '>' + category.name + '</option>';
        }
        $('#new_category_id').html(selector).selectpicker('refresh');
        $('#new_subcategory_id').html('').selectpicker('refresh');
    });

    $('#new_category_id').change(function() {
        var id = $(this).val();
        var selector = '';

        if (id) {
            scs = subcategoriesList.filter(c => c.parent_id == id);
            if (scs.length < 1) {
                $('#new_subcategory_id').selectpicker({
                    title: '<?php echo _l('empty') ?>'
                });
            } else {
                $('#new_subcategory_id').selectpicker({
                    title: '<?php echo _l('select_subcategory') ?>'
                });
            }
        } else {
            scs = '';
            $('#new_subcategory_id').selectpicker({
                title: '<?php echo _l('first_select_category') ?>'
            });
        }
        selector += '<option value=""></option>'
        for (let subcategory of scs) {
            selector += '<option value=' + subcategory.id + '>' + subcategory.name + '</option>';
        }
        $('#new_subcategory_id').html(selector).selectpicker('refresh');
    });

    $('input[type="file"]').prop('required', true);
    $(function() {
        appValidateForm($('form'), {
            new_product_name: "required",
            new_product_code: "required",
            new_product_description: "required",
            new_branch_id: "required",
            new_category_id: "required",
            new_price: "required",
            new_quantity_number: "required"
        });
    });
</script>
</body>

</html>