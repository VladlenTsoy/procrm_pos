<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div id="pos_page" class="content">
        <div class="row">
            <!-- Orders list -->
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <audio id="productSelectSoundClip" preload="auto">
                            <source src="<?php echo module_dir_url(PRODUCTS_MODULE_NAME, 'assets/audio/beep-timber.mp3') ?>"/>
                        </audio>
                        <audio id="deleteProductSoundClip" preload="auto">
                            <source src="<?php echo module_dir_url(PRODUCTS_MODULE_NAME, 'assets/audio/beep-07.mp3')?>"/>
                        </audio>
                        <div class="card">
                            <div class="card-body" style="padding-bottom: 0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo render_select('lead_id', $leads, ['id', 'name'], '', !empty(set_value('id')) ? set_value('id') : '', ['title'=> _l('select_lead'), 'class'=>'pos-selectpicker']); ?>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" onclick="init_lead(); " class="btn pos-transparent-btn" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-user-plus"></i><?php echo _l('new_lead'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn" data-toggle="modal" data-target="#notes-modal"><i class="fa fa-pencil"></i><?php echo _l('note'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn" data-toggle="modal" data-target="#addShipping"><i class="fa fa-truck"></i><?php echo _l('shipping'); ?></button>
                                                <button type="button" class="btn pos-transparent-btn" data-toggle="modal" data-target="#addNewProductModal"><i class="fa fa-plus"></i><?php echo _l('item'); ?></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="table-responsive transaction-list">
                                                <table id="products-table" class="table order-list table-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th class="col-sm-3"><?php echo _l('product')?></th>
                                                            <th class="col-sm-3"><?php echo _l('quantity')?></th>
                                                            <th class="col-sm-2"><?php echo _l('price')?></th>
                                                            <th class="col-sm-2"><?php echo _l('discount')?>%</th>
                                                            <th class="col-sm-1"><?php echo _l('total')?></th>
                                                            <th class="col-sm-1"><?php echo _l('action')?></th>
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
                                        <div class="col-12 totals" style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
                                            <div class="row" style="border-bottom: 1px solid #f5f5f5">
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('items')?> </span><span id="item">0</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('total')?> </span><span id="subtotal">0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('discount')?> </span><span id="discount">0.00</span>
                                                </div>
                                            </div>
                                            <div class="row" style="border-bottom: 1px solid #f5f5f5">
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('coupon')?> <button type="button" class="btn btn-link" data-toggle="modal" data-target="#coupon-modal"><i class="fa fa-pencil"></i></button></span><span id="coupon-text">0.00</span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="totals-title"><?php echo _l('shipping')?> <button type="button" class="btn btn-link" data-toggle="modal" data-target="#shipping-cost-modal"><i class="fa fa-pencil"></i></button></span><span id="shipping-cost">0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-amount">
                                <h2><?php echo _l('grand_total') ?>: <span id="grand-total">0.00</span></h2>
                            </div>
                            <div class="additional-options">
                              <div class="row">
                                  <div class="column-5 col-md-6">
                                      <button style="background: #0984e3" type="button" class="btn btn-custom payment-btn" id="paymentBtn"><i class="fa fa-credit-card"></i> <?php echo _l('pay') ?></button>
                                  </div>
                                  <div class="column-5 col-md-6">
                                      <button style="background-color: #d63031;" type="button" class="btn btn-custom" id="cancel-btn"><i class="fa fa-close"></i> <?php echo _l('cancel') ?></button>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- notes modal -->
            <div id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('note') ?></h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea type="text" name="notes" class="form-control" rows="10" maxlength="200"></textarea>
                            </div>
                            <button type="button" name="notes_btn" class="btn btn-primary" data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- add new product modal -->
            <div id="addNewProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('new_product') ?></h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <?php echo form_open_multipart('products/pos/add_product'); ?>
                            <div class="modal-body">
                                <?php echo render_input('product_name', 'product_name'); ?>
                                <?php echo render_input('product_code', 'product_code'); ?>
                                <?php echo render_textarea('product_description', 'product_description'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo render_select('product_category_id', $products_categories_list, ['p_category_id', 'p_category_name'], 'products_categories', !empty(set_value('product_category_id')) ? set_value('product_category_id') : $product->product_category_id ?? ''); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo render_input('price', _l('Price'),'', 'number'); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo render_input('quantity_number', 'quantity', '', 'number'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="attachment">
                                            <div class="form-group">
                                                <label for="attachment" class="control-label"><small class="req text-danger">* </small><?php echo _l('product_image'); ?></label>
                                                <input type="file" extension="png,jpg,jpeg,gif" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="product" id="product" required>
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
            <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="exampleModalLabel" class="modal-title float-left"><?php echo _l('finalize_sale') ?></h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <?php echo form_open('products/pos/add_sale', ['id'=>'pos-payment-form', 'method'=>'post', 'files'=>true,'class'=>'pos-payment-form' ] ); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <h2 id="customerName"><?php echo _l("lead");?>: <span></span> </h2>
                            </div>
                            <div class="form-group">
                                <p id="sale_notes"><?php echo _l("note");?>: <span></span></p>
                            </div>
                            <div class="form-group">
                                <h3 id="ItemsNum2"><span>0</span> <?php echo _l("item(s)");?></h3>
                            </div>
                            <div class="form-group">
                                <h2 id="TotalModal"><?php echo _l('total')?> <span></span></h2>
                            </div>
                            <div class="form-group">
                                <label for="paymentMethod"><?php echo _l("payment_method");?></label>
                                <select class="js-select-options form-control" id="paymentMethod">
                                    <option value="0"><?php echo _l("cash");?></option>
                                </select>
                            </div>
                            <div class="form-group Paid">
                                <label for="Paid"><?php echo _l("paid");?></label>
                                <input onkeypress="return event.charCode >= 48 && event.charCode <= 57" type="text" value="0" name="paid" class="form-control"  id="paidModalInput" placeholder="<?php echo _l("paid");?>">
                            </div>
                            <div class="form-group ReturnChange">
                                <h3 id="ReturnChange"><?php echo _l("change");?> <span>0</span> <?php echo get_option('product_currency')?></h3>
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
            <div id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('coupon_code') ?></h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="coupon-code" class="form-control" placeholder="<?php echo _l('coupon_code') ?>...">
                            </div>
                            <button type="button" class="btn btn-primary coupon-check" data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shipping_cost modal -->
            <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title float-left"><?php echo _l('shipping_cost') ?></h3>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="shipping_cost" class="form-control numkey" step="any">
                            </div>
                            <button type="button" name="shipping_cost_btn" class="btn btn-primary" data-dismiss="modal"><?php echo _l('submit') ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ticket modal -->
            <div class="modal fade" id="ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" id="ticketModal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title float-left" id="ticket"><?php echo _l("receipt");?></h3>
                        </div>
                        <div class="modal-body" id="modal-body">
                            <div id="printSection">
                                <!-- Ticket goes here -->
                                <center><h1 style="color:#34495E"><?php echo _l("empty");?></h1></center>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default hiddenpr modal-close" data-dismiss="modal"><?php echo _l("сlose");?></button>
                            <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()"><?php echo _l("print");?></button>
                        </div>
                        <div id="elementH"></div>
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
                                    <a id="btnFullscreen" href="#" class="expand-btn"><i class="fa fa-window-maximize"> </i></a>
                                    <div class="navbar-header">
                                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                                            <li class="nav-item">
                                                <a id="btnCalculator" data-toggle="modal" data-target="#calculator_modal"><i class="fa fa-calculator"></i> <?php echo _l('calculator')?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </header>
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo render_select('p_branch_id', $products_branches_list, ['p_branch_id', 'p_branch_name'], '', !empty(set_value('p_branch_id')) ? set_value('p_branch_id') : '', ['title'=> _l('all_branches'), 'class'=>'pos-selectpicker']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_select('p_category_id', $products_categories_list, ['p_category_id', 'p_category_name'], '', !empty(set_value('p_category_id')) ? set_value('p_category_id') : '', ['title'=>_l('all_categories'), 'class'=>'pos-selectpicker']); ?>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-block btn-danger btn-filter" id="featured-filter"><?php echo _l('Featured') ?></button>
                            </div>
                            <div class="col-md-12 mt-1 table-container">
                                <div id="products-list">
                                    <input type="text" class="search form-group" id="productSearchBox" placeholder="<?php echo _l('search_by') ?>"/>

                                    <ul class="list">
                                        <?php for($i = 0; $i < count($products_list); $i++) { ?>
                                            <li class="product-img sound-btn" title="<?php echo $products_list[$i]['product_name']?>" data-product="<?php echo $products_list[$i]['product_name'].'-'. $products_list[$i]['product_code'] ?>">
                                                <img src="<?php echo module_dir_url('products', 'uploads/' . $products_list[$i]['product_image']) ?>" width="100%">
                                                <p class="productName"><?php echo $products_list[$i]['product_name']?></p>
                                                <span><?php echo $products_list[$i]['price']?></span>
                                                <p class="productCategory" hidden><?php echo $products_list[$i]['product_category_id']?></p>
                                            </li>
                                        <?php }?>
                                    </ul>
                                    <ul class="pagination"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('products/calculator_modal'); ?>
<?php init_tail(); ?>
<script src="<?php echo module_dir_url('products', 'assets/js/jquery.redirect.js')?>"></script>
<script src="<?php echo module_dir_url('products', 'assets/js/jqueryPrint.min.js')?>"></script>
<script src="<?php echo module_dir_url('products', 'assets/js/keyboard.min.js')?>"></script>
<script src="<?php echo module_dir_url('products', 'assets/js/keyboard.extension.all.js')?>"></script>
<script>
    var rowindex;
    var productCodesInOrder = [];
    var pList = <?php echo json_encode($products_list) ?>;
    var pCategoriesList = <?php echo json_encode($products_categories_list) ?>;
    var selectedBranchCategories = [];
    var keyboard_active = <?php echo get_option('keyboard_active') ?>;
    if(pList.length) {
        var productsList = new List('products-list', {
            valueNames: ['productName', 'productCategory'],
            page: 10,
            pagination: [{
                innerWindow: 3,
                outerWindow: 5,
            }],
        });
    }

    if(keyboard_active == 1) {
        $("input.numkey:text").keyboard({
            usePreview: false,
            layout: 'custom',
            display: {
                'accept'  : '&#10004;',
                'cancel'  : '&#10006;'
            },
            customLayout : {
                'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']
            },
            restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
            preventPaste : true,  // prevent ctrl-v and right click
            autoAccept : true,
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
                'accept'  : '&#10004; <?php echo _l('accept') ?>',
                'cancel'  : '&#10006; <?php echo _l('cancel') ?>',
                'bksp': '&#8678; <?php echo _l('delete') ?>'
            },
            customLayout : {
                'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']
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

    if(keyboard_active==1){
        $('#productSearchBox').bind('keyboardChange', function (e, keyboard, el) {
            var lead_id = $('#lead_id').val();
            temp_data = $('#productSearchBox').val();
            if(!lead_id){
                $('#productSearchBox').val(temp_data.substring(0, temp_data.length - 1));
                Swal.fire('<?php echo _l('select_lead'); ?>');
            }else{

                productsList.filter(function(pro) {
                    if(temp_data) {
                        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(temp_data), "i");
                        var productsArray = $.grep(pList, function(item) {
                            return matcher.test(item.product_name);
                        });
                        for(let product of productsArray){
                            if (pro.values().productName == product.product_name) {
                                return true;
                            }
                        }
                    } else {
                        for(let product of productsList){
                            if (pro.values().productCategory == product.p_category_id) {
                                return true;
                            }
                        }
                    }
                });
                console.log(productsList);
            }
        });
    }
    else{
        $('#productSearchBox').on('input', function(){
            var lead_id = $('#lead_id').val();
            temp_data = $('#productSearchBox').val();
            if(!lead_id){
                $('#productSearchBox').val(temp_data.substring(0, temp_data.length - 1));
                Swal.fire('<?php echo _l('select_lead'); ?>');
            }

        });
    }
    var productSearchBox = $('#productSearchBox');

    productSearchBox.autocomplete({
        source: function(request, response) {
            var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(pList, function(item) {
                return matcher.test(item.product_name);
            }));
        },
        response: function(event, ui) {
            if (ui.content.length == 1) {
                var data = ui.content[0].product_code;
                $(this).autocomplete( "close" );
                productSearch(data);
            };
        },
        select: function(event, ui) {
            var data = ui.item.product_code;
            productSearch(data);
        },
    });
    $("#lead_id").change(function(){
        var id = $(this).val();
        if(id) {
            $('#customerName span').text($(this).find("option:selected" ).text());
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
        if($(this).val() < 1 && $(this).val() != '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
            Swal.fire('<?php echo _l('wrong_quantity'); ?>');
        }
        if($(this).val() >= 1) {
            checkQuantity($(this).val(), true);
        }
    });

    $("#products-table").on('focusout', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if($(this).val() < 1 || $(this).val() == '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
        }
        checkQuantity($(this).val(), true);
    });

    $("#products-table").on('focusout', 'input[name="discount"]', function() {
        rowindex = $(this).closest('tr').index();
        if($(this).val() < 0 || $(this).val() == '') {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') input[name="discount"]').val(0);
        }
        checkQuantity($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(), true);
    });

    $("#products-table").on('click', '.qty', function() {
        rowindex = $(this).closest('tr').index();
    });

    $(document).on('click', '.sound-btn', function() {
        var audio = $("#productSelectSoundClip")[0];
        audio.play();
    });

    $(document).on('click', '.product-img', function() {
        var lead_id = $('#lead_id').val();
        if(!lead_id) {
            Swal.fire('<?php echo _l('select_lead'); ?>');
        }else{
            var data = $(this).data('product');
            data = data.split("-");
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

    $('#p_branch_id').change(function(){
        var id = $(this).val();
        var selector = '';

        if(id) {
            selectedBranchCategories = pCategoriesList.filter(pc => pc.product_branch_id == id);
        } else {
            selectedBranchCategories = pCategoriesList;
        }
        selector += '<option value=""></option>'
        for(let category of selectedBranchCategories){
            selector += '<option value='+category.p_category_id +'>'+category.p_category_name +'</option>';
        }
        $('#p_category_id').html(selector).selectpicker('refresh');

        productsList.filter(function(pro) {
            for(let category of selectedBranchCategories){
                if (pro.values().productCategory == category.p_category_id) {
                    return true;
                }
            }
        });
        return false;
    });

    $('#p_category_id').change(function(){
        var id = $(this).val();

        productsList.filter(function(pro) {
            if(id) {
                return pro.values().productCategory == id;
            } else {
                for(let category of selectedBranchCategories){
                    if (pro.values().productCategory == category.p_category_id) {
                        return true;
                    }
                }
            }
        });

        return false;
    });

    $('#paymentBtn').click(function (){
        if(rowindex >= 0) {
            $('#add-payment').modal('show');
        }else {
            Swal.fire('<?php echo _l('add_product_to_order') ?>');
        }
    });

    $("#paidModalInput").keyup(function() {
        calculateChange($(this).val());
    });

    $("#paidModalInput").focusout(function() {
        if($(this).val() == '') {
            $(this).val(0);
        }
        calculateChange($(this).val());
    });

    $('button[name="shipping_cost_btn"]').on("click", function() {
        calculateGrandTotal();
    });

    $('#cancel-btn').click(confirmCancel);

    function productSearch(productCode) {
        var selectedProduct = pList.filter(p => p.product_code == productCode);
        if(selectedProduct.length > 0) {
            if(productCodesInOrder.includes(productCode)) {
                rowindex = productCodesInOrder.indexOf(productCode);
                var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                checkQuantity(qty, true);
            } else {
                if(selectedProduct[0].quantity_number > 0) {
                    addNewProduct(selectedProduct[0]);
                }else {
                    Swal.fire('<?php echo _l('low_stock')?>');
                }
            }
        }
    }

    function addNewProduct(data){
        var newRow = $("<tr>");
        var cols = '';
        cols += '<td class="col-sm-3 product-title"><button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"><strong class="product-name">' + data.product_name + '</strong></button></td>';
        cols += '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="fa fa-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" value="1" step="any" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="fa fa-plus"></span></button></span></div></td>';
        cols += '<td class="col-sm-2 product-price">' + data.price + '</td>';
        cols += '<td class="col-sm-2 discount"><input type="text" name="discount" class="form-control numkey discount-value input-number" value="0" step="any" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required=""></td>'
        cols += '<td class="col-sm-1 sub-total">' + data.price + '</td>';
        cols += '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="fa fa-times"></i></button></td>';
        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data.id + '"/>';
        cols += '<input type="hidden" class="product-code" name="product_code" value="' + data.product_code + '"/>';
        cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + data.quantity_number + '"/>';
        cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" value="'+ data.price +'" />';
        cols += '<input type="hidden" class="total_discount" name="total_discount" />';
        cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';
        newRow.append(cols);
        $("#products-table.order-list tbody").append(newRow);
        rowindex = newRow.index();
        checkQuantity(1, false);
    }

    function checkQuantity(sale_qty, existing_product_in_orders) {
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
        var row_sale_unit = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val();
        sale_qty = parseInt(sale_qty)

        if(row_sale_unit < sale_qty) {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(row_sale_unit);
            Swal.fire('<?php echo _l('low_stock')?>');
            return;
        }
        if(existing_product_in_orders) {

        } else {
            productCodesInOrder.push(row_product_code);
        }
        calculateRowProductData(sale_qty);
    }

    function calculateRowProductData(quantity) {
        var row_product_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val();
        var row_product_discount = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val();

        var sub_total = (row_product_price * quantity);
        var total_dis = sub_total * (row_product_discount/100);
        sub_total-=total_dis;
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.total_discount').val(total_dis.toFixed(2));

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
        var order_tax = '<?php echo get_option("tax_percentage") ?>';
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
        if(change < 0){
            $('#ReturnChange span').text(change.toFixed(2));
            $('#ReturnChange span').addClass( "text-danger" );
            $('#ReturnChange span').removeClass( "text-info" );
            $('#saleBtn').attr('onclick', '');
        }else{
            $('#ReturnChange span').text(change.toFixed(2));
            $('#ReturnChange span').removeClass( "text-danger" );
            $('#ReturnChange span').addClass( "text-info" );
            $('#saleBtn').attr('onclick', 'posSale()');
        }
    }

    function posSale() {
        var leadId = $('#lead_id').val();
        var leadName = $('#lead_id').find('option:selected').text();
        var itemsNumber = $('input[name="item"]').val();
        var totalQuantity = $('input[name="total_qty"]').val();
        var totalDiscount = $('.total_discount').val();
        var totalTax = $('input[name="order_tax"]').val();
        var totalPrice = $('input[name="total_price"]').val();
        var returnChange = $('#ReturnChange span').text();
        var grandTotal = $('input[name="grand_total"]').val();
        var orderTaxRate = '<?php echo get_option("tax_percentage") ?>';
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
        $('table.order-list tbody tr').each(function (){
            productIds.push($(this).find('.product-id').val());
            productNames.push($(this).find('.product-name').text());
            productQuantities.push($(this).find('.qty').val());
            productDiscounts.push($(this).find('.total_discount').val());
            productTotalPrices.push($(this).find('.subtotal-value').val());
        });


        $.ajax({
            url : $("#pos-payment-form").attr('action'),
            type: "POST",
            data: {
                lead_id: leadId,
                lead_name: leadName,
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
            success: function(data)
            {
                $('#printSection').html(data);
                $('#add-payment').modal('hide');
                $('#ticket').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
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
        while(rownumber >= 0) {
            $('table.order-list tbody tr:last').remove();
            rownumber--;
        }
        $('input[name="shipping_cost"]').val('');
        $('input[name="order_discount"]').val('');
        calculateTotal();
    }

    $('input[type="file"]').prop('required',true);
    $(function () {
        appValidateForm($('form'), {
            product_name        : "required",
            product_code        : "required",
            product_description : "required",
            product_category_id : "required",
            price               : "required",
            quantity_number     : "required"
        });
    });
</script>
<script src="<?php echo module_dir_url('products', 'assets/js/products.js')?>"></script>
</body>
</html>
