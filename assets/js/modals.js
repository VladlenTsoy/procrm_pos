
	 "use strict";



     window.addEventListener('load',function(){
        appValidateForm($('#branch-modal-form'), {
         branch_name: 'required',
         branch_address: 'required'
     }, manage_product_branch);
        $('#branch_modal').on('show.bs.modal', function(e) {
         var invoker = $(e.relatedTarget);
         var group_id = $(invoker).data('id');
         $('#branch_modal .add-title').removeClass('hide');
         $('#branch_modal .edit-title').addClass('hide');
         $('#branch_modal input[name="branch_id"]').val('');
         $('#branch_modal input[name="branch_name"]').val('');
         $('#branch_modal :input[name="branch_address"]').val('');
         if (typeof(group_id) !== 'undefined') {
             $('#branch_modal input[name="branch_id"]').val(group_id);
             $('#branch_modal .add-title').addClass('hide');
             $('#branch_modal .edit-title').removeClass('hide');
             $('#branch_modal input[name="branch_name"]').val($(invoker).parents('tr').find('td').eq(0).text());
             $('#branch_modal :input[name="branch_address"]').val($(invoker).parents('tr').find('td').eq(1).text());
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
                 $('#branch_modal').modal('hide');
             } else {
                 alert_float('danger', response.message);
             }
         });
         return false;
     }

     window.addEventListener('load',function(){
         appValidateForm($('#category-modal-form'), {
             branch_ids: 'required',
             category_name: 'required',
             category_description: 'required'
         }, manage_product_category);
         $('#category_modal').on('show.bs.modal', function(e) {
             var invoker = $(e.relatedTarget);
             var group_id = $(invoker).data('id');
             $('#category_modal .add-title').removeClass('hide');
             $('#category_modal .edit-title').addClass('hide');
             $('#category_modal select#branch_ids').val(0).change();
             $('#category_modal input[name="category_id"]').val('');
             $('#category_modal input[name="category_name"]').val('');
             $('#category_modal :input[name="category_description"]').val('');
             if (typeof(group_id) !== 'undefined') {
                 var branch_ids = ($(invoker).data('branch').toString()).includes(',') ? $(invoker).data('branch').split(',') : $(invoker).data('branch');
                 $('#category_modal input[name="category_id"]').val(group_id);
                 $('#category_modal .add-title').addClass('hide');
                 $('#category_modal .edit-title').removeClass('hide');
                 $('#category_modal input[name="category_name"]').val($(invoker).parents('tr').find('td').eq(0).text());
                 $('#category_modal :input[name="category_description"]').val($(invoker).parents('tr').find('td').eq(1).text());
                 $('#category_modal select#branch_ids').selectpicker('val', branch_ids);
             }
         });
     });
     function manage_product_category(form) {
         var data = $(form).serialize();
         var url = form.action;
         $.post(url, data).done(function(response) {
             response = JSON.parse(response);
             if (response.success == true) {
                 if($.fn.DataTable.isDataTable('.table-product-category')){
                     $('.table-product-category').DataTable().ajax.reload();
                 }
                 alert_float('success', response.message);
                 $('#category_modal').modal('hide');
             } else {
                 alert_float('danger', response.message);
             }
         });
         return false;
     }

     window.addEventListener('load',function(){
         appValidateForm($('#subcategory-modal-form'), {
             category_id: 'required',
             subcategory_name: 'required',
             subcategory_description: 'required'
         }, manage_product_subcategory);
         $('#subcategory_modal').on('show.bs.modal', function(e) {
             var invoker = $(e.relatedTarget);
             var group_id = $(invoker).data('id');
             $('#subcategory_modal .add-title').removeClass('hide');
             $('#subcategory_modal .edit-title').addClass('hide');
             $('#subcategory_modal select#category_id').val(0).change();
             $('#subcategory_modal input[name="subcategory_id"]').val('');
             $('#subcategory_modal input[name="subcategory_name"]').val('');
             $('#subcategory_modal :input[name="subcategory_description"]').val('');
             if (typeof(group_id) !== 'undefined') {
                 $('#subcategory_modal input[name="subcategory_id"]').val(group_id);
                 $('#subcategory_modal .add-title').addClass('hide');
                 $('#subcategory_modal .edit-title').removeClass('hide');
                 $('#subcategory_modal input[name="subcategory_name"]').val($(invoker).parents('tr').find('td').eq(0).text());
                 $('#subcategory_modal :input[name="subcategory_description"]').val($(invoker).parents('tr').find('td').eq(1).text());
                 $('#subcategory_modal select#category_id').selectpicker('val', $(invoker).data('category'));
             }
         });
     });
     function manage_product_subcategory(form) {
         var data = $(form).serialize();
         var url = form.action;
         $.post(url, data).done(function(response) {
             response = JSON.parse(response);
             if (response.success == true) {
                 if($.fn.DataTable.isDataTable('.table-product-subcategory')){
                     $('.table-product-subcategory').DataTable().ajax.reload();
                 }
                 alert_float('success', response.message);
                 $('#subcategory_modal').modal('hide');
             } else {
                 alert_float('danger', response.message);
             }
         });
         return false;
     }