<?php
/*
Plugin Name: CG Lightbox
Plugin URI: http://www.camaleon-gamer.com/plugins/cg-lightbox
Description: Muestra una ventana emergente (lightbox) con un video de youtube, vimeo, etc., un embet, imagen, o enlace url.
Version: 1.0
Author: Camaleon Gamer
Author URI: http://www.camaleon-gamer.com
License: GPL2
*/

/*  Copyright 2017 Camaleon Gamer  (email : gutyzarate@camaleon-gamer.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


$settings = array(
    'active' => true,
    'width' => 854,
    'height' => 480,
    'autoplay' => false,
    'url' => "https://www.youtube.com/embed/RF0HhrwIwp0",
    'scriptloadin'  => Array('is_single','is_page','is_home','is_archive', 'is_category'),
    'timeout' => 5,
    'tipo' => "url",
    'proportion' => true
);

require_once 'functions.php';

function cg_lightbox_menu() {
    add_options_page( 'CG Lightbox', 'CG Lightbox', 'manage_options', 'cg-lightbox', 'cg_lightbox_opciones' );
}

function cg_lightbox_opciones() {
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <form method="post" action="options.php" id="cg_lightbox_settings">

        <?php
            // wp_nonce_field('update-options'); 
            settings_fields('cg-lightbox');
            do_settings_sections( 'cg-lightbox' );
        ?>
        
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="card">
            <p></p>
            <?php
                // var_dump(get_option('cg_lightbox_settings'));
                /*-----  GET POST IN ARRAY -----*/
                $option_posts = array();
                $option_posts_obj = get_posts();
                $options_posts[''] = 'Selecciona la publicación destino';
                foreach ($option_posts_obj as $post) {
                    $options_posts[$post->ID] = $post->post_title;
                }
                /*----- END GET POST IN ARRAY -----*/

                $fields = Array(
                    Array(
                        'name'          => 'cg_lightbox_settings[active]',
                        'label'         => __('Activar Lightbox','cg-lightbox'),
                        'type'          => 'checkbox',
                        'description'   => __('Habilita la función del lightbox','cg-lightbox'),
                        'value'         => 1,
                        'attr'          => option('active') ? 'checked="checked"' : ''
                    ),

                    Array(
                        'name'          => 'cg_lightbox_settings[timeout]',
                        'label'         => __('Tiempo de espera (segundos)','cg-lightbox'),
                        'type'          => 'number',
                        'description'   => __('Tiempo de espera en segundos para que se muestre el lightbox','cg-lightbox'),
                        'value'         => option('timeout'),
                    ),

                    Array(
                        'label'         => __('Tamaño de lightbox (px)','cg-lightbox'),
                        'type'          => 'fieldsgroup',
                        'description'   => __('Medidas en pixeles del lightbox','cg-lightbox'),
                        'fields'        => array(
                                                array(
                                                    'name'  => 'cg_lightbox_settings[width]',
                                                    'label' => __('Ancho','cg-lightbox'),
                                                    'type'  => 'number',
                                                    'value' => option('width'),
                                                    'break' => false
                                                ),
                                                array(
                                                    'name'  => 'cg_lightbox_settings[height]',
                                                    'label' => __('Alto','cg-lightbox'),
                                                    'type'  => 'number',
                                                    'value' => option('height'),
                                                    'break' => false
                                                ),
                                                array(
                                                    'name'  => 'cg_lightbox_settings[proportion]',
                                                    'label' => __('Mantener proporción','cg-lightbox'),
                                                    'type'  => 'checkbox',
                                                    'value' => 1,
                                                    'attr'  => option('proportion') ? 'checked="checked"' : '',
                                                    'break' => true
                                                ),
                                        )
                    ),

                    Array(
                        'name'          => 'cg_lightbox_settings[tipo]',
                        'label'         => __('Tipo','cg-lightbox'),
                        'type'          => 'radio',
                        'description'   => __('Selecciona el tipo de embed','cg-lightbox'),
                        'options'       => array(
                                                array(
                                                    "value" => "url",
                                                    "label" => "Web"
                                                ),
                                                array(
                                                    "value" => "img",
                                                    "label" => "Imagen"
                                                ),
                                                array(
                                                    "value" => "blog",
                                                    "label" => "Blog"
                                                ),
                                                array(
                                                    "value" => "video",
                                                    "label" => "Video"
                                                ),
                                            ),
                        'value'         => option('tipo')
                    ),
                    Array(
                        'name'          => 'cg_lightbox_settings[autoplay]',
                        'rowid'         => 'cg_lightbox_video',
                        'label'         => __('Autoplay','cg-lightbox'),
                        'type'          => 'checkbox',
                        'description'   => __('Habilita la reproducción automática si es un video','cg-lightbox'),
                        'value'         => 1,
                        'attr'          => option('autoplay') ? 'checked="checked"' : ''
                    ),
                    Array(
                        'name'          => 'cg_lightbox_settings[url]',
                        'rowid'         => 'cg_lightbox_url',
                        'label'         => __('Enlace','cg-lightbox'),
                        'type'          => 'text',
                        'description'   => __('Enlace a insertar en lightbox','cg-lightbox'),
                        'value'         => option('url')
                    ),
                    Array(  
                        'name'          => 'cg_lightbox_settings[post]',
                        'rowid'         => 'cg_lightbox_post',
                        'label'         => __('Artículo','cg-lightbox'),
                        'type'          => 'select',
                        'value'         => option('post'),
                        'values'        => $options_posts,
                        'description'   => __('Selecciona el artículo','cg-lightbox')

                    ),
                    Array(
                        'name'          => 'cg_lightbox_settings[upload_image]',
                        'rowid'         => 'cg_lightbox_img',
                        'label'         => __('Imagen','cg-lightbox'),
                        'type'          => 'upload',
                        'description'   => __('Selecciona la imagen que aparecera en el lightbox','cg-lightbox'),
                        'value'         => option('upload_image')
                    ),
                    Array(
                        'type'          => 'checkboxgroup',
                        'grouplabel'    => __('Habilitar plugins en','cg-lightbox'),
                        'description'   => __('Donde se cargarán los archivos javascript y estilos css','cg-lightbox'),
                        'groupitem'     => Array(
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Single','cg-lightbox'),
                                                    'value' => 'is_single',
                                                    'attr'  => in_array('is_single',option('scriptloadin')) ? 'checked="checked"' : ''
                                                ),
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Page','cg-lightbox'),
                                                    'value' => 'is_page',
                                                    'attr'  => in_array('is_page',option('scriptloadin')) ? 'checked="checked"' : ''
                                                ),
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Front page','cg-lightbox'),
                                                    'value' => 'is_home',
                                                    'attr'  => in_array('is_home',option('scriptloadin')) ? 'checked="checked"' : ''
                                                ),
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Archive page','cg-lightbox'),
                                                    'value' => 'is_archive',
                                                    'attr'  => in_array('is_archive',option('scriptloadin')) ? 'checked="checked"' : ''
                                                ),
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Search page','cg-lightbox'),
                                                    'value' => 'is_search',
                                                    'attr'  => in_array('is_search',option('scriptloadin')) ? 'checked="checked"' : ''
                                                ),
                                                Array(
                                                    'name'  => 'cg_lightbox_settings[scriptloadin][]',
                                                    'label' => __('Category page','cg-lightbox'),
                                                    'value' => 'is_category',
                                                    'attr'  => in_array('is_category',option('scriptloadin')) ? 'checked="checked"' : ''
                                                )
                                            )

                    )
                );

            echo render_form($fields);

            ?>

            <?php

            submit_button('Guardar');

            ?>

            </form>
        </div>
    </div>
    <?php
}



function cg_lightbox_settings_init()
{
    // register a new setting for "reading" page
    register_setting('cg-lightbox', 'cg_lightbox_settings');

}


function cg_lightbox_script() {

    if( is_single() AND in_array('is_single', option('scriptloadin')) OR

        is_page() AND in_array('is_page', option('scriptloadin')) OR 

        is_home() AND in_array('is_home', option('scriptloadin')) OR 

        is_archive() AND in_array('is_archive', option('scriptloadin')) OR 

        is_search() AND in_array('is_search', option('scriptloadin')) OR

        is_category() AND in_array('is_category', option('scriptloadin'))

        )
    {

        wp_enqueue_script('cg_lightbox_script',plugins_url( 'js/lightbox.class.js' , __FILE__ ),array('jquery'));

    }

}

function cg_lightbox_style() {

    if( is_single() AND in_array('is_single', option('scriptloadin')) OR

        is_page() AND in_array('is_page', option('scriptloadin')) OR 

        is_home() AND in_array('is_home', option('scriptloadin')) OR 

        is_archive() AND in_array('is_archive', option('scriptloadin')) OR 

        is_search() AND in_array('is_search', option('scriptloadin')) OR

        is_category() AND in_array('is_category', option('scriptloadin'))

        )
    {

        // wp_enqueue_style('cg_lightbox_style', plugins_url( 'css/lightbox.style.css' , __FILE__ ));
        wp_enqueue_style('cg_lightbox_style', plugins_url( 'css/lightbox.style.css' , __FILE__), false);

    }

}

function cg_lightbox_load()
{

    if( is_single() AND in_array('is_single', option('scriptloadin')) OR

        is_page() AND in_array('is_page', option('scriptloadin')) OR 

        is_home() AND in_array('is_home', option('scriptloadin')) OR 

        is_archive() AND in_array('is_archive', option('scriptloadin')) OR 

        is_search() AND in_array('is_search', option('scriptloadin')) OR

        is_category() AND in_array('is_category', option('scriptloadin'))

        )
    {
        switch (option("tipo")) {
            case 'url':
                $enlace = '{url: "'.option("url").'"}';
            break;
            case 'video':
                $enlace = '{url: "'.option("url").'"}';
            break;
            case 'img':
                $enlace = '{img: "'.wp_get_attachment_url(option("upload_image")).'", url: "'.option("url").'"}';
            break;
            case 'blog':
                $post_select = get_post(option("post"));
                $enlace = '{img: "'.wp_get_attachment_url(option("upload_image")).'", url: "'.$post_select->guid.'"}';
            break;
        }

        ?>

        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery("body").prepend('<!--LIGHTBOX--><div class="lightbox"><div class="wrap-lightbox"><div class="content-lightbox"></div><a id="close-lightbox"></a></div></div><!--LIGHTBOX-->');
                var mql = window.matchMedia("screen and (max-device-width: 600px)");
                if(!mql.matches)
                {
                    setTimeout(function(){
                        if(getCookie("view_cg_lightbox") != "true" || getCookie("view_cg_lightbox") == "")
                        {
                            lightboxVideo.open();
                        }
                        
                    }, <?php echo option('timeout'); ?>*1000);

                }
            });
                
            lightboxVideo = new lightbox({
                tipo: "<?php echo option('tipo'); ?>",
                width: <?php echo option('width'); ?>,
                height: <?php echo option('height'); ?>,
                autoplay: <?php echo option('autoplay') ? "true" : "null" ?>,
                url: <?php echo $enlace; ?>
            });

        </script>

        <?php

    }
}


function cg_lightbox_script_admin($hook)
{
    // wp_die($hook);
    if($hook != 'settings_page_cg-lightbox') {
        return;
    }

    wp_enqueue_script('cg_lightbox_script_admin',plugins_url( 'js/cg_lightbox_admin.js' , __FILE__ ), array('jquery'));

}

add_action('admin_menu', 'cg_lightbox_menu');
add_action('admin_init', 'cg_lightbox_settings_init');
add_action('admin_enqueue_scripts', 'cg_lightbox_script_admin');
add_action('wp_enqueue_scripts', 'cg_lightbox_script');
add_action('wp_enqueue_scripts', 'cg_lightbox_style');
if(option("active"))
{
   add_action('wp_footer', 'cg_lightbox_load'); 
}

?>