<?php
/**
 * Plugin Name: Linker
 * Plugin URI: https://www.wordpress.org/phillipsalazar
 * Description: Add important links to the admin page!
 * Version: 1.0
 * Author: Phillip Salazar
 * Author URI: https://www.phillipsalazar.com
 */

// globals for the plugin
global $linker_db_version;
$linker_db_version = '1.0';
//global $wpdb;
// linker obj
class Linker
{
  // xss defense
  public function stringSafe($data)
  {
      $string = htmlspecialchars($data);
      return $string;
  }

  // add item to database
  public  function add_Item($name, $url)
  {

        global $wpdb;
	      $this->table_name = $wpdb->prefix . 'Linker_links';

    	  $wpdb->insert(
    		$this->table_name,
    		array(
    			   'name' => $name,
    			   'url' => $url,
    		    ) );
  }

  // read from db reverse
  public function read_DB()
  {
      global $wpdb;

  	   $table_name = $wpdb->prefix . 'Linker_links';
       $result = $wpdb->get_results('SELECT * FROM ' . $table_name . " ORDER BY id DESC");
       return $result;
  }

  // delete item
  public function delete_Item($id)
  {
      global $wpdb;
      $table_name = $wpdb->prefix . 'Linker_links';
      $wpdb->delete( $table_name, array( 'id' => $id ) );
  }
  // update item
  public function update_Item($id, $name, $url)
  {
      global $wpdb;

      $table_name = $wpdb->prefix . 'Linker_links';
  	  $wpdb->update($table_name, ['name' => $name, 'url' => $url], ['id' => $id] );

  }

}

// adds the table
function linker_install()
{

      global $wpdb;
      global $linker_db_version;

      $table_name = $wpdb->prefix . 'Linker_links';
      $charset_collate = $wpdb->get_charset_collate();

       $sql = "CREATE TABLE $table_name (
             id mediumint(9) NOT NULL AUTO_INCREMENT,
             name TINYTEXT NOT NULL,
             url  TEXT NOT NULL,
             PRIMARY KEY  (id)
             ) $charset_collate;";

       require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
       dbDelta( $sql );

       add_option( 'linker_db_version', $linker_db_version );
}

function addingAction()
{

      add_menu_page( 'Linker', 'Linker', 'manage_options', 'test-plugin', 'start_init' );
      add_action('admin_init', 'custom_setting');

}

function linker_style()
{
      wp_register_style('linker_style', plugins_url('/assets/style.css',__FILE__ ));
      wp_enqueue_style('linker_style');
}

function start_init()
{
      $links = new Linker();
      include 'panel.php';

}

register_activation_hook( __FILE__, 'linker_install' );

add_action('admin_menu', 'addingAction');
add_action('admin_init', 'linker_style');
