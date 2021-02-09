<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="calculator_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="add-title"><?php echo _l('Calculator'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="calculator">
                    <div class="input" id="input"></div>
                    <div class="buttons">
                        <div class="operators">
                            <div>+</div>
                            <div>-</div>
                            <div>&times;</div>
                            <div>&divide;</div>
                        </div>
                        <div class="leftPanel">
                            <div class="numbers">
                                <div>7</div>
                                <div>8</div>
                                <div>9</div>
                            </div>
                            <div class="numbers">
                                <div>4</div>
                                <div>5</div>
                                <div>6</div>
                            </div>
                            <div class="numbers">
                                <div>1</div>
                                <div>2</div>
                                <div>3</div>
                            </div>
                            <div class="numbers">
                                <div>0</div>
                                <div>.</div>
                                <div id="clear">C</div>
                            </div>
                        </div>
                        <div class="equal" id="result">=</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo module_dir_url('products','assets/js/calculator.js') ?>"></script>

