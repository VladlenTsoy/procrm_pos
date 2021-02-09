
	 "use strict";

    window.addEventListener('load',function(){
       appValidateForm($('#product-branch-modal'), {
        p_branch_name: 'required',
        p_branch_address: 'required'
    }, manage_product_branch);
       $('#product_branch_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
        $('#product_branch_modal .add-title').removeClass('hide');
        $('#product_branch_modal .edit-title').addClass('hide');
        $('#product_branch_modal input[name="p_branch_id"]').val('');
        $('#product_branch_modal input[name="p_branch_name"]').val('');
        $('#product_branch_modal :input[name="p_branch_address"]').val('');
        if (typeof(group_id) !== 'undefined') {
            $('#product_branch_modal input[name="p_branch_id"]').val(group_id);
            $('#product_branch_modal .add-title').addClass('hide');
            $('#product_branch_modal .edit-title').removeClass('hide');
            $('#product_branch_modal input[name="p_branch_name"]').val($(invoker).parents('tr').find('td').eq(0).text());
            $('#product_branch_modal :input[name="p_branch_address"]').val($(invoker).parents('tr').find('td').eq(1).text());
        }
    });
   });
    function manage_product_branch(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-product-branch')){
                    $('.table-product-branch').DataTable().ajax.reload();
                }
                alert_float('success', response.message);
                $('#product_branch_modal').modal('hide');
            } else {
                alert_float('danger', response.message);
            }
        });
        return false;
    }