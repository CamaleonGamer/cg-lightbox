<?php

/**
 * Render form
 * @param array
 */

function render_form_cg($fields)
{

    $output = '<table class="form-table">';

    foreach ($fields as $field) {

        $field['rowclass'] = isset($field['rowclass']) ? $field['rowclass'] : false;

        $field['label'] = isset($field['label']) ? $field['label'] : '';

        if ($field['type'] == "fieldsgroup") {
            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '>';
            $output .= '<th scope="row">' . $field['label'] . '</th>';
            $output .= '<td>';
            foreach ($field['fields'] as $field_) {
                $break = $field_["break"] ? "<br>" : "";
                switch ($field_["type"]) {
                    case 'number':
                        $propertybytype = 'step="1" min="0"';
                        break;

                    case 'checkbox':
                        $propertybytype = $field_['attr'];
                        break;

                    default:
                        $propertybytype = "";
                        break;
                }

                switch ($field_["type"]) {
                    case 'checkbox':
                        $output .= '<input type="hidden" name="' . $field_['name'] . '" value="" />';
                        $output .= $break . '<input name="' . $field_['name'] . '" type="' . $field_['type'] . '" ' . $propertybytype . ' id="' . $field_['name'] . '" value="' . $field_['value'] . '" > ';
                        $output .= '<label for="' . $field_['name'] . '">' . $field_['label'] . '</label> ';
                        break;

                    default:
                        $output .= '<label for="' . $field_['name'] . '">' . $field_['label'] . '</label> ';
                        $output .= $break . '<input name="' . $field_['name'] . '" type="' . $field_['type'] . '" ' . $propertybytype . ' id="' . $field_['name'] . '" value="' . $field_['value'] . '" class="small-text"> ';
                        break;
                }

            }

            $output .= '<p class="description">' . $field['description'] . '</p>';
            $output .= '</td>';
            $output .= '</tr>';
        }

        if ($field['type'] == 'text') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';

            $output .= '<td><input type="text" id="' . $field['name'] . '" name="' . $field['name'] . '" value="' . $field['value'] . '" class="regular-text"/>';

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'number') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';

            $output .= '<td><input type="number" id="' . $field['name'] . '" name="' . $field['name'] . '" value="' . $field['value'] . '" step="1" min="0" class="small-text" />';

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'checkbox') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';

            $output .= '<td><input type="hidden" name="' . $field['name'] . '" value="" /><input type="checkbox" id="' . $field['name'] . '" name="' . $field['name'] . '" value="' . $field['value'] . '" ' . $field['attr'] . ' />';

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'radio') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label for="' . $field['name'] . '">' . $field['label'] . '</label></th><td>';

            foreach ($field["options"] as $option) {
                if ($option["value"] == $field['value']) {
                    $checked = "checked";
                } else {
                    $checked = "";
                }

                $output .= '<input type="radio" id="' . $field['name'] . '" name="' . $field['name'] . '" value="' . $option["value"] . '" ' . $checked . '/>' . $option["label"] . '&nbsp;&nbsp;';
            }

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'checkboxgroup') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label>' . $field['grouplabel'] . '</label></th>';

            $output .= '<td>';

            foreach ($field['groupitem'] as $key => $item) {

                $output .= '<input type="hidden" name="' . $item['name'] . '" value="" /><input type="checkbox" id="' . $item['name'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '" ' . $item['attr'] . ' /> <label for="' . $item['name'] . '">' . $item['label'] . '</label><br />';

            }

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'select') {

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label>' . $field['label'] . '</label></th>';

            $output .= '<td>';

            $output .= '<select name="' . $field['name'] . '">';

            foreach ((array) $field['values'] as $val => $name) {

                $output .= '<option ' . (($val == $field['value']) ? 'selected="selected"' : '') . ' value="' . $val . '">' . $name . '</option>';

            }

            $output .= '</select>';

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

        if ($field['type'] == 'upload') {

            // if ( isset( $_POST['submit'] ) && isset( $_POST['image_attachment_id'] ) ) :
            //     update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
            // endif;

            wp_enqueue_media();

            $output .= '<tr ' . ($field['rowid'] ? 'id="' . $field['rowid'] . '"' : '') . ' ' . ($field['rowclass'] ? 'class="' . $field['rowclass'] . '"' : '') . '><th><label for="' . $field['name'] . '">' . $field['label'] . '</label></th>';

            $output .= '<td><div class="image-preview-wrapper">';

            $output .= '<img id="image-preview" src="' . wp_get_attachment_url($field['value']) . '" height="100" style="max-height: 100px; "></div>';

            $output .= '<input id="upload_image_button" type="button" class="button" value="Seleccionar Imagen" />';

            $output .= '<input type="hidden" name="' . $field['name'] . '" id="image_attachment_id" value="' . $field['value'] . '">';

            $output .= '<p class="description">' . $field['description'] . '</p></td></tr>';

        }

    }

    $output .= '</table>';

    return $output;

}

function option_cg($key = '')
{

    global $settings;

    $option = get_option('cg_lightbox_settings') ? get_option('cg_lightbox_settings') : array();

    $option = array_merge($settings, $option);

    if ($key) {

        $return = $option[$key];

    } else {

        $return = $option;

    }

    return $return;

}

// function allow_uploads()
// {
//     $user_role = 'administrator';
//     $author = get_role($user_role);
//     $author->add_cap('edit_others_pages');
//     $author->add_cap('edit_published_pages');

// }

// add_action('init', 'allow_uploads');

add_action("admin_enqueue_scripts", "enqueue_media_uploader_cg");

function enqueue_media_uploader_cg()
{
    wp_enqueue_media();
}

add_action('admin_footer', 'media_selector_print_scripts_cg');

function media_selector_print_scripts_cg()
{

    ?>
    <script type="text/javascript">

    jQuery(document).ready(function($){
        $('#upload_image_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Selecciona una imagen',
                // mutiple: true if you want to upload multiple files at once
                multiple: false
            }).open()
            .on('select', function(e){
                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get('selection').first();
                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                console.log(uploaded_image);
                var image_url = uploaded_image.toJSON().url;
                var image_id = uploaded_image.toJSON().id;
                // Let's assign the url value to the input field
                // $('#image_url').val(image_url);
                $( '#image-preview' ).attr( 'src', image_url ).css( 'width', 'auto' );
                $( '#image_attachment_id' ).val( image_id );
            });
        });
    });


    </script>
    <?php
}

?>