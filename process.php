<?php

add_action('wp_ajax_dcms_ajax_add_file', 'dcms_upload_file');
// add_action('wp_ajax_nopriv_dcms_ajax_add_file', 'dcms_upload_file');

// Process upload file
function dcms_upload_file(){
    $res = [];

    validate_nonce('ajax-nonce-upload');

    if( isset($_FILES['file']) ) {

        global $wp_filesystem;
        WP_Filesystem();

        $name_file = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];

        validate_extension_file($name_file);

        $content_directory = $wp_filesystem->wp_content_dir() . 'uploads/archivos-subidos/';
        $wp_filesystem->mkdir( $content_directory );

        if( move_uploaded_file( $tmp_name, $content_directory . $name_file ) ) {
            $res = [
                'status' => 1,
                'message' => "El archivo se agregó correctamente"
            ];
        }

    } else {
        $res = [
            'status' => 0,
            'message' => "Existe un error en la subida del archivo"
        ];
    }

    echo json_encode($res);
    wp_die();
}


// Nonce validation
function validate_nonce( $nonce_name ){
    if ( ! wp_verify_nonce( $_POST['nonce'], $nonce_name ) ) {
        $res = [
            'status' => 0,
            'message' => '✋ Error nonce validation!!'
        ];
        echo json_encode($res);
        wp_die();
    }
}

function validate_extension_file( $name_file ){

    $path_parts = pathinfo($name_file);
    $ext = $path_parts['extension'];
    $allow_extensions = ['png','jpg','pdf'];

    if ( ! in_array($ext, $allow_extensions) ) {
          $res = [
              'status' => 0,
              'message' => "Extensión de archivo no permitida"
          ];
          echo json_encode($res);
          wp_die();
    }

}
