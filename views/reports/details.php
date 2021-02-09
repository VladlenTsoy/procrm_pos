<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body d-flex justify-content-between align-items-center">
                        <h4 class="no-margin width-full">
                            <?php echo htmlspecialchars($title); ?>
                        </h4>
                        <a href="<?php echo admin_url('products/reports') ?>" type="button" class="btn btn-default float-right"><?php echo _l('back'); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l('primary_info'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="col-md-12 gradientPinkHeaderBg">
                            <ul id="salePrimaryInfo" class="details_list">
                                <li>
                                    <span><i class="fa fa-building-o"></i> <?php echo _l("branch") ;?></span>
                                    <span> <?php echo $branch->name ;?></span>
                                </li>
                                <li>
                                    <span><i class="fa fa-list-ol"></i> <?php echo _l("sale_num") ;?></span>
                                    <span><?php echo ' № ' . $pos_sale->id ;?></span>
                                </li>
                                <li>
                                    <span><i class="fa fa-male"></i> <?php echo _l("cashier") ;?></span>
                                    <span><?php echo $biller->firstname ;?></span>
                                </li>
                                <li>
                                    <span><i class="fa fa-user"></i> <?php echo _l("lead");?></span>
                                    <span><?php echo $lead->name ;?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l('products_info'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="col-md-12 gradientPinkHeaderBg">
                            <table id="saleProductsInfo" class="" cellspacing="0" border="0">
                                <thead>
                                <tr>
                                    <th><?php echo _l("product"); ?></th>
                                    <th><?php echo _l("quantity"); ?></th>
                                    <th><?php echo _l("discount"); ?></th>
                                    <th><?php echo _l("price"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($sale_products as $product) { ?>
                                    <tr>
                                        <td><?php echo $product['productName'] ;?></td>
                                        <td><?php echo $product['quantity'] ;?></td>
                                        <td><?php echo $product['discount'] ;?></td>
                                        <td><?php echo number_format((float)($product['total_price']),2, '.', '') . ' ' . $pos_settings->currency; ?></td>
                                    </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo _l('prices_info'); ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        <div class="col-md-12 gradientPinkHeaderBg">
                            <table id="salePricesInfo" cellspacing="0" border="0">
                                <tbody>
                                    <tr>
                                        <td><?php echo _l("total_items") . ' ('. $pos_sale->total_quantity . ')' ;?></td>
                                        <td><?php echo $pos_sale->total_price . ' ' . $pos_settings->currency ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("discount") ;?></td>
                                        <td><?php echo $pos_sale->total_discount  . ' ' . $pos_settings->currency ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("tax"). ' (' . $pos_settings->tax_rate .'%)' ;?></td>
                                        <td><?php echo $pos_sale->total_tax . ' ' . $pos_settings->currency  ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("shipping") ;?></td>
                                        <td><?php echo $pos_sale->shipping_cost . ' ' . $pos_settings->currency  ;?></td>
                                    </tr>
                                    <tr id="grandTotal">
                                        <td><?php echo _l("grand_total") ;?></td>
                                        <td><?php echo $pos_sale->grand_total . ' ' . $pos_settings->currency  ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("paid") ;?></td>
                                        <td><?php echo $pos_sale->paid_amount . ' ' . $pos_settings->currency  ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("change") ;?></td>
                                        <td><?php echo $pos_sale->return_change . ' ' . $pos_settings->currency  ;?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo _l("payment_method") ;?></td>
                                        <td><?php echo _l($pos_sale->payment_method );?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
</body>
</html>
