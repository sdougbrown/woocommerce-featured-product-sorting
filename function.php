<?php 
	/** 
	 * add to your theme's functions.php 
	 */
	
	/* change sorting on admin page */
	
	function product_sorting_link( $views ) {
		global $post_type, $wp_query;
		
		 $settings = array(
			'featured_enable' => 'true'
		);
			
		$settings = woo_get_dynamic_values( $settings );
		
		if ( ! current_user_can('edit_others_pages') ) return $views;
		$class = ( isset( $wp_query->query['orderby'] ) && $wp_query->query['orderby'] == 'menu_order title' ) ? 'current' : '';
		$query_string = remove_query_arg(array( 'orderby', 'order' ));
		$query_string = add_query_arg( 'orderby', urlencode('menu_order title'), $query_string );
		$query_string = add_query_arg( 'order', urlencode('ASC'), $query_string );
		$query_string = add_query_arg( 'featured', urlencode('true'), $query_string );
		$views['byorder'] = '<a href="'. $query_string . '" class="' . $class . '">' . __( 'Sort Products', 'woocommerce' ) . '</a>';

		return $views;
	}

	add_filter( 'views_edit-product', 'product_sorting_link' );
	
	function meta_filter_products( $query ) {
		if( !is_admin() )
			return $query;
		if( isset( $_GET['featured'] ) ) {
			if( $_GET['featured'] == 'true' ) {				
				//$query->set( 'meta_key', '_featured' );
				//$query->set( 'meta_value', 'yes' );
				set_query_var( 'meta_query', array( array( 'key' => '_featured', 'value' => 'yes' ) ) );
			}
		}
		return $query;
	}
	add_filter( 'pre_get_posts', 'meta_filter_products' );
?>