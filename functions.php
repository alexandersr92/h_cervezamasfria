<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// functions.php is empty so you can easily track what code is needed in order to Vite + Tailwind JIT run well


// Main switch to get frontend assets from a Vite dev server OR from production built folder
// it is recommended to move it into wp-config.php
define('IS_VITE_DEVELOPMENT', false);


include "inc/inc.vite.php";
include_once('inc/acf_blocks.php');
include_once('inc/cpt.php');
include_once('inc/acf.php');


register_nav_menus(
    array(
        'primary-menu' => __('Primary Menu'),

    )
);


function add_additional_class_on_li($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');
add_theme_support('post-thumbnails');


//create custom table at install theme
add_action("after_switch_theme", "create_custom_table");


function create_custom_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'super_express_participantes';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name text NOT NULL,
        email text,
        phone text NOT NULL,
        cedula text NOT NULL,
        factura text NOT NULL,
        factura_imagen text NOT NULL,
        status text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
//create another custom table at install theme

add_action("after_switch_theme", "create_custom_table2");


function create_custom_table2()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'super_express_ganadores';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        id_participante integer NOT NULL,
        id_premio integer NOT NULL,
        id_sorteo integer NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

add_action("after_switch_theme", "create_premios_table");


function create_premios_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'super_express_premios';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        image text NOT NULL,
        quantity integer NOT NULL,
        orderP integer NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action("after_switch_theme", "create_premios_sorteos");

function create_premios_sorteos()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'super_express_sorteos';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        date date DEFAULT '0000-00-00' NOT NULL,
        winners text NOT NULL,
        status text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

//create menu item in admin panel
add_action('admin_menu', 'super_express_menu');

function super_express_menu()
{
    add_menu_page(
        'Super Express',
        'Super Express',
        'manage_options',
        'super_express',
        'super_express_options',
        'dashicons-superhero-alt'

    );
    add_submenu_page(
        'super_express',
        'Ganadores',
        'Ganadores',
        'manage_options',
        'super_express_ganadores',
        'super_express_ganadores'
    );
    add_submenu_page(
        'super_express',
        'Premios',
        'Premios',
        'manage_options',
        'super_express_premios',
        'super_express_premios'
    );
    add_submenu_page(
        'super_express',
        'Sorteos',
        'Sorteos',
        'manage_options',
        'super_express_sorteos',
        'super_express_sorteos'
    );
}

function super_express_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include_once(get_template_directory() . '/admin/participantes.php');
}

function super_express_ganadores()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include_once(get_template_directory() . '/admin/ganadores.php');
}

function super_express_premios()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include_once(get_template_directory() . '/admin/premios.php');
}

function super_express_sorteos()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include_once(get_template_directory() . '/admin/sorteos.php');
}
