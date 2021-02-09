<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo htmlspecialchars($title); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <?php echo form_open_multipart($this->uri->uri_string()); ?>
                        <?php echo render_input('product_name', 'product_name', $product->name ?? ''); ?>
                        <div class="form-group" app-field-wrapper="product_code">
                            <label for="product_code" class="control-label"> <small class="req text-danger">* </small><?php echo _l('product_code') ?></label>
                            <div class="relative">
                                <input type="text" id="product_code" name="product_code" class="form-control" value="<?php echo $product->barcode ?? '' ?>">
                                <span id="productAddBarcodeBtn" class="btn btn-info">
                                    <i>
                                        <svg id="Capa_1" stroke="white" stroke-width="10" enable-background="new 0 0 512 512" height="20" style="width: 20px; height: 20px; vertical-align: middle;" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m196.992 234.287h-179.497c-9.646 0-17.495 7.848-17.495 17.495v119.687c0 9.646 7.849 17.495 17.495 17.495h179.497c9.646 0 17.494-7.848 17.494-17.495v-119.687c0-9.647-7.847-17.495-17.494-17.495zm2.494 137.182c0 1.375-1.119 2.495-2.494 2.495h-179.497c-1.376 0-2.495-1.119-2.495-2.495v-119.687c0-1.375 1.119-2.495 2.495-2.495h179.497c1.375 0 2.494 1.119 2.494 2.495z"/><path d="m163.051 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z"/><path d="m135.147 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z"/><path d="m107.243 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.357-7.5-7.5-7.5z"/><path d="m51.436 265.019c-4.143 0-7.5 3.358-7.5 7.5v78.214c0 4.142 3.357 7.5 7.5 7.5s7.5-3.358 7.5-7.5v-78.214c0-4.143-3.358-7.5-7.5-7.5z"/><path d="m504.5 349.42h-23.53c-21.212 0-38.47 17.258-38.47 38.47v39.58c0 12.941-10.524 23.47-23.46 23.47h-19.39c-16.474 0-29.987-12.894-30.994-29.119l17.764-3.852c20.438-4.437 33.971-23.44 31.472-44.24l-23.227-185.612c14.005-3.713 26.685-11.597 36.248-22.685 11.289-13.089 17.506-29.828 17.506-47.132 0-39.833-32.402-72.24-72.229-72.24h-43.01c-4.143 0-7.5 3.358-7.5 7.5s3.357 7.5 7.5 7.5h43.011c31.557 0 57.229 25.678 57.229 57.24 0 28.315-20.282 52.086-48.227 56.523-2.953.469-5.982.707-9.003.707h-179.73c-6.094 0-11.544-3.632-13.886-9.253l-39.832-95.645c-.904-2.167-.676-4.532.628-6.488 1.306-1.959 3.405-3.083 5.76-3.083h149.05c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-149.05c-7.349 0-14.168 3.651-18.242 9.766-2.827 4.242-4.046 9.246-3.585 14.174h-14.723c-4.185 0-8.07 2.08-10.394 5.564-2.324 3.485-2.75 7.874-1.141 11.74l29.809 71.56c1.931 4.693 6.463 7.726 11.546 7.726h24.055l2.272 5.455c4.679 11.229 15.564 18.485 27.732 18.485h67.115c2.868 8.589 4.33 17.631 4.217 26.437-.018 1.374-.068 2.752-.118 4.132-.197 5.434-.4 11.054 1.102 16.902 4.169 16.28 19.189 25.447 31.854 28.597 4.718 1.174 9.674 1.809 15.247 1.942l1.032 8.188c.479 3.792 3.708 6.563 7.432 6.563.313 0 .629-.02.947-.06 4.109-.518 7.021-4.269 6.504-8.378l-10.626-84.323s57.457-.042 58.672-.103l23.167 185.128c1.566 13.038-6.931 24.97-19.764 27.756l-61.608 13.359c-4.602.994-9.329-.127-12.988-3.078-3.656-2.95-5.754-7.335-5.754-12.032v-9.19c0-7.224 5.123-13.579 12.184-15.111l4.642-1.009c13.72-2.966 22.796-15.713 21.106-29.688l-4.62-36.67c-.518-4.109-4.262-7.017-8.379-6.504-4.109.518-7.021 4.269-6.504 8.379l4.616 36.632c.749 6.2-3.287 11.87-9.397 13.191l-4.647 1.01c-13.906 3.018-24 15.538-24 29.769v9.19c0 9.255 4.132 17.896 11.337 23.708 5.485 4.424 12.196 6.761 19.079 6.761 2.162 0 4.341-.23 6.504-.699l29.075-6.305c2.567 22.984 22.108 40.915 45.766 40.915h19.39c21.207 0 38.46-17.257 38.46-38.47v-39.58c0-12.941 10.528-23.47 23.47-23.47h23.53c4.143 0 7.5-3.358 7.5-7.5s-3.359-7.5-7.502-7.5zm-360.427-197.83-27.737-66.59h16.141l27.732 66.59zm169.901 101.857c-3.531-.2-6.724-.658-9.723-1.405-10.639-2.646-18.859-9.618-20.946-17.767-.964-3.75-.808-8.065-.642-12.633.054-1.498.107-2.996.126-4.484.114-8.851-1.097-17.893-3.524-26.627h26.781z"/></g></svg>
                                    </i>
                                </span>
                            </div>
                        </div>
                        <?php echo render_textarea('product_description', 'product_description', $product->description ?? ''); ?>
                        <div class="row">
                            <div class="col-md-4">
                               <?php echo render_select('branch_id', $branches, ['id', 'name'], 'product_branch', !empty(set_value('branch_id')) ? set_value('branch_id') : $product->branch_id ?? ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_select('category_id', '', ['id', 'name'], 'product_category', !empty(set_value('category_id')) ? set_value('category_id') : $product->category_id ?? '', ['title' => 'first_select_branch']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_select('subcategory_id', '', ['id', 'name'], 'product_subcategory', !empty(set_value('subcategory_id')) ? set_value('subcategory_id') : $product->subcategory_id ?? '', ['title' => 'first_select_category']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo render_input('price', _l('Price'), $product->price ?? '', 'number'); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo render_input('quantity_number', 'quantity', $product->quantity_number ?? '', 'number'); ?>
                            </div>
                        </div>
                        <?php
                          $existing_image_class = 'col-md-4';
                          $input_file_class     = 'col-md-8';
                          if (empty($product->image_url)) {
                              $existing_image_class = 'col-md-12';
                              $input_file_class     = 'col-md-12';
                          }
                        ?>
                        <div class="row">
                          <?php if (!empty($product->image_url)) { ?>
                          <div class="<?php echo htmlspecialchars($existing_image_class); ?>">
                              <div class="existing_image">
                                <label class="control-label">Existing Image</label>
                                <img src="<?php echo base_url('modules/'.PRODUCTS_MODULE_NAME.'/uploads/'.$product->image_url); ?>" class="img img-responsive img-thubnail zoom"/>
                              </div>
                          </div>
                          <?php } ?>
                          <div class="<?php echo htmlspecialchars($input_file_class); ?>">
                              <div class="attachment">
                                <div class="form-group">
                                  <label for="attachment" class="control-label"><small class="req text-danger">* </small><?php echo _l('product_image'); ?></label>
                                  <input type="file" extension="png,jpg,jpeg,gif" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="product" id="product" required>
                                </div>
                              </div>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>

                    <!-- livestream_scanner-->
                    <div class="modal fade" id="livestream_scanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document" id="livestream_scannerModal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close mclose" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title"><?php echo _l('barcode_scanner') ?></h4>
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
                    <audio id="scannerBeepSoundClip" preload="auto">
                        <source src="<?php echo module_dir_url(PRODUCTS_MODULE_NAME, 'assets/audio/scanner_beep.mp3')?>"/>
                    </audio>

                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script src="<?php echo module_dir_url('products', 'assets/js/barcode/quagga.js')?>"></script>
<script type="text/javascript">
    var categories = <?php echo json_encode($categories);?>;
    var subcategories = <?php echo json_encode($subcategories);?>;
    var currentBranchId = $('#branch_id').val();
    var currentCatId = '<?php echo $product->category_id ?>';
    var currentSubCatId = '<?php echo $product->subcategory_id ?>';
    var mode = '<?php echo '' . $this->uri->segment(3, 0); ?>';
    (mode == 'add_product') ? $('input[type="file"]').prop('required',true) : $('input[type="file"]').prop('required',false);
    $(function () {
        appValidateForm($('form'), {
            product_name        : "required",
            product_code        : "required",
            product_description : "required",
            branch_id           : "required",
            category_id         : "required",
            price               : "required",
            quantity_number     : "required"
        });
    });

    $('#branch_id').change(function() {
        setCategoryValue($(this).val(), '');
    });

    $('#category_id').change(function() {
        setSubCategoryValue($(this).val(), '');
    });

    function setCategoryValue(id, currentVal) {
        var selector = '';

        if(id) {
            selectedBranchCategories = categories.filter(c => c.branchIds.includes(id));
            if(selectedBranchCategories.length < 1){
                $('#category_id').selectpicker({title: '<?php echo _l('empty') ?>'});
            }else{
                $('#category_id').selectpicker({title: '<?php echo _l('select_category') ?>'});
            }
        } else {
            selectedBranchCategories = '';
            $('#category_id').selectpicker({title: '<?php echo _l('first_select_branch') ?>'});
        }
        selector += '<option value=""></option>'
        for(let category of selectedBranchCategories){
            selector += '<option value='+category.id +'>'+category.name +'</option>';
        }
        $('#category_id').html(selector).selectpicker('refresh');
        $('#subcategory_id').html('').selectpicker('refresh');
        $('#category_id').selectpicker('val', currentVal);
    }
    setCategoryValue(currentBranchId, currentCatId);

    function setSubCategoryValue(id, currentVal) {
        var selector = '';

        if(id) {
            selectedCategorySubs = subcategories.filter(c => c.parent_id == id);
            if(selectedCategorySubs.length < 1){
                $('#subcategory_id').selectpicker({title: '<?php echo _l('empty') ?>'});
            }else{
                $('#subcategory_id').selectpicker({title: '<?php echo _l('select_subcategory') ?>'});
            }
        } else {
            selectedCategorySubs = '';
            $('#subcategory_id').selectpicker({title: '<?php echo _l('first_select_category') ?>'});
        }
        selector += '<option value=""></option>'
        for(let subcategory of selectedCategorySubs){
            selector += '<option value='+subcategory.id +'>'+subcategory.name +'</option>';
        }
        $('#subcategory_id').html(selector).selectpicker('refresh');
        $('#subcategory_id').selectpicker('val', currentVal);
    }
    setSubCategoryValue(currentCatId, currentSubCatId);

    // ------------------------------------------------------- //
    // barcode scanner
    // ------------------------------------------------------ //
    //
    function order_by_occurence(arr) {
        var counts = {};
        arr.forEach(function (value){
            if(!counts[value]) {
                counts[value] = 0;
            }
            counts[value]++;
        });
        return Object.keys(counts).sort(function (curKey, nextKey) {
            return counts[nextKey] - counts[curKey];
        })
    }

    function barcodeScan() {
        var Quagga = window.Quagga;
        var App = {
            _scanner: null,
            init: function() {
                this.attachListeners();
            },
            activateScanner: function() {
                var last_results = [];
                var scanner = this.configureScanner('#interactive'),
                    onDetected = function (result) {
                        var last_code = result.codeResult.code;
                        last_results.push(last_code);
                        if(last_results.length > 20) {
                            accurateCode = order_by_occurence(last_results)[0];
                            last_results = [];
                            var audio = $("#scannerBeepSoundClip")[0];
                            audio.play();
                            document.querySelector('#product_code').value = accurateCode;
                            stop();
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
                var self = this,
                    button = document.querySelector('#productAddBarcodeBtn');

                button.addEventListener("click", function onClick(e) {
                    e.preventDefault();
                    button.removeEventListener("click", onClick);
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

</script>