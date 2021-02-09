<?php

function handle_product_upload($product_id)
{
    $CI = &get_instance();
    if (isset($_FILES['product']['name']) && '' != $_FILES['product']['name']) {
        $path = get_upload_path_by_type('products');
        $tmpFilePath = $_FILES['product']['tmp_name'];
        if (!empty($tmpFilePath) && '' != $tmpFilePath) {
            $path_parts = pathinfo($_FILES['product']['name']);
            $extension  = $path_parts['extension'];
            $extension  = strtolower($extension);
            $filename    = 'product_'.$product_id.'.'.$extension;
            $newFilePath = $path.$filename;
            _maybe_create_upload_path($path);
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI->products_model->edit_product(['image_url'=>$filename], $product_id);
                return true;
            }
        }
    }

    return false;
}

function handle_product_delete_file($id, $deleting)
{
    $CI = &get_instance();
    $product = $CI->products_model->get_by_id_product($id);
    $path = get_upload_path_by_type('products');
    if(pathinfo($_FILES['product']['name'])['filename']) {
        if (file_exists($path . $product->image_url)) {
            unlink($path . $product->image_url);
            return true;
        }else{
            return false;
        }
    }else{
        if($deleting) {
            if (file_exists($path . $product->image_url)) {
                unlink($path . $product->image_url);
                return true;
            }else{
                return false;
            }
        }
        return true;
    }
}

function toPlainArray($arr)
{
    $output = "['";
    foreach ($arr as $val) {
        $output .= $val."', '";
    }
    $plain_array = substr($output, 0, -3).']';

    return $plain_array;
}
