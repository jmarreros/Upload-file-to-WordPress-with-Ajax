<?php

add_action( 'init', 'dcms_form_shortcode' );

function dcms_form_shortcode(){
	add_shortcode('dcms_upload_file', 'dcms_show_upload_file_form');
}

function dcms_show_upload_file_form( $atts , $content ){
    dcms_enqueue_scripts();
    ob_start();
    ?>
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="post" id="form-upload">
            <div>
                <span>Selecciona algún archivo: </span>
                <input type="file" id="file" name="upload-file"/>
            </div>
            <input type="submit" id="submit" value="Enviar archivo" />
        </form>

        <div id="message"></div>
    </section>
    <?php
    $html_code = ob_get_contents();
    ob_end_clean();

    return $html_code;
}
