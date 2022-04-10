<?php

add_action('wp_enqueue_scripts', 'dcms_register_scripts');

function dcms_register_scripts(){
    wp_register_script('dcms-upload-script',
                        plugin_dir_url( __FILE__ ).'assets/script.js',
                        ['jquery'],
                        '1.0',
                        true);

    wp_register_style('dcms-upload-style',
                        plugin_dir_url( __FILE__ ).'assets/style.css',
                        [],
                        '1.0');
}

function dcms_enqueue_scripts(){
    wp_enqueue_script('dcms-upload-script');
    wp_enqueue_style('dcms-upload-style');

    wp_localize_script('dcms-upload-script',
                        'dcmsUpload',
                        [ 'ajaxurl'=>admin_url('admin-ajax.php'),
                          'nonce' => wp_create_nonce('ajax-nonce-upload')]);
}