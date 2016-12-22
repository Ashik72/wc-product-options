<?php  

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

/**
* WP List Table child 
*/
class Embroidery_List extends WP_List_Table
{
	
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Embroidery', 'wc-product-options' ), //singular name of the listed records
			'plural'   => __( 'Embroideries', 'wc-product-options' ), //plural name of the listed records
			'ajax'     => false //should this table support ajax?

		] );

	}

	public function no_items() {
		
		return 'No items found.';
	}

	public function the_embroidery_data() {

		global $wpdb;

		$order_column = (!empty($_GET['orderby']) ? $_GET['orderby'] : 'date');
		$order_asc_desc = (!empty($_GET['order']) ? $_GET['order'] : 'ASC');

		$sql_emb = "SELECT * FROM `".$wpdb->prefix."embroidery_pricing` ORDER BY ".$order_column." ".$order_asc_desc."";

		$get_embroidery_options = $wpdb->get_results($sql_emb, ARRAY_A);


		return $get_embroidery_options;

	}


	public function get_columns(){
	  $columns = array(
  	    'cb'        => '<input type="checkbox" />',
	    'name' => 'Title',
	    'size'    => 'Details',
	    'date'      => 'Date'
	  );
	  return $columns;
	}

	function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="name[]" value="%s" />', $item['id']
        );    
    }

	function get_bulk_actions() {
	  $actions = array(
	    'delete'    => 'Delete'
	  );
	  return $actions;
	}


	function prepare_items() {
	  $columns = $this->get_columns();
	  $hidden = array();
	  $sortable = $this->get_sortable_columns();
	  $this->_column_headers = array($columns, $hidden, $sortable);


	  $this->items = $this->the_embroidery_data();
	}

	function get_sortable_columns() {
	  $sortable_columns = array(
	    'name'  => array('name',false),
	    'size' => array('size',false),
	    'date'   => array('date',false)
	  );
	  return $sortable_columns;
	}

	function column_default( $item, $column_name ) {
	  switch( $column_name ) { 
	    case 'name':
	    case 'size':
   	      return $item[ $column_name ];
	    case 'edit_delete':
   	      return $item[ 'date' ];
	    default:
	      return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  }
	}


	function column_date ($item) {

		return $item['date'];
	}
	
	function column_name($item) {

	$nonce_edit = wp_create_nonce( 'embroidery-single-edit_'.$item['id'] );
	$nonce_delete = wp_create_nonce( 'embroidery-single-delete_'.$item['id'] );


	  $actions = array(
	            'edit'      => sprintf('<a href="?page=%s&action=%s&name=%s&wpnonce=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id'], $nonce_edit),
	            'delete'    => sprintf('<a href="?page=%s&action=%s&name=%s&wpnonce=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id'], $nonce_delete),
	        );

	  return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );
	}




}


?>