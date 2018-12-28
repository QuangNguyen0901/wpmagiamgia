<?php
if( !class_exists( 'WP_Coupons_Query' ) ){
class WP_Coupons_Query extends WP_Query {
	public $args;
	function __construct( $args = array() ) {

		$args = array_merge( array(
			'post_type' 			=> 'coupon',
			'orderby' 				=> 'expire',
			'order' 				=> 'ASC',
			'type' 					=> '',
			'posts_per_page'		=> couponis_get_option( 'coupons_per_page' )
		), $args);

		$this->args = $args;

		add_filter( 'posts_fields', array( $this, 'posts_fields' ) );
		add_filter( 'posts_join', array( $this, 'posts_join' ) );
		add_filter( 'posts_where', array( $this, 'posts_where' ) );

		if( $args['orderby'] == 'expire' || $args['orderby'] == 'used' ){
			add_filter('posts_orderby', array( $this, 'posts_orderby' ));
		}

		if( !empty( $args['type'] ) ){
			add_filter('posts_where', array( $this, 'filter_post_type' ));
		}

		parent::__construct( $args );

		remove_filter( 'posts_fields', array( $this, 'posts_fields' ) );
		remove_filter( 'posts_join', array( $this, 'posts_join' ) );
		remove_filter( 'posts_where', array( $this, 'posts_where' ) );

		if( $args['orderby'] == 'expire' || $args['orderby'] == 'used' ){
			remove_filter('posts_orderby', array( $this, 'posts_orderby' ));
		}

		if( !empty( $args['type'] ) ){
			remove_filter('posts_where', array( $this, 'filter_post_type' ));
		}		
	}

	function posts_fields( $sql ) {
		return $sql . ", coupons.* ";
	}

	function posts_join( $sql ) {
		global $wpdb;
		return $sql . " INNER JOIN {$wpdb->prefix}couponis_coupon_data AS coupons ON $wpdb->posts.ID = coupons.post_id ";
	}

	function posts_where( $sql ) {
		global $wpdb;
		$sql .= $wpdb->prepare( " AND coupons.expire >= %d ", current_time('timestamp') );
		return $sql;
	}

	function posts_orderby(){
		$orderby_statement = ' coupons.'.$this->args['orderby'].' '.$this->args['order'];
		return $orderby_statement;
	}

	function filter_post_type( $sql ){
		global $wpdb;
		$sql .=  " AND coupons.ctype IN (".esc_sql( $this->args['type'] ).")";
		return $sql;
	}
}
}

if( !function_exists( 'couponis_get_the_expire_time' ) ){
function couponis_get_the_expire_time( $post = 0 ){
	$post = get_post( $post );
	$expire = isset( $post->expire ) ? $post->expire : '';

	return $expire;
}
}

if( !function_exists('couponis_is_expired') ){
function couponis_is_expired( $expire ){
	if( empty( $expire ) ){
		return false;
	}

	if( $expire < current_time( 'timestamp' ) ){
		return true;
	}

	return false;
}
}

if( !function_exists( 'couponis_get_the_coupon_type' ) ){
function couponis_get_the_coupon_type( $post = 0 ){
	$post = get_post( $post );
	$ctype = isset( $post->ctype ) ? $post->ctype : '';

	return $ctype;
}
}

if( !function_exists( 'couponis_is_exclusive' ) ){
function couponis_is_exclusive( $post = 0 ){
	$post = get_post( $post );
	$exclusive = !empty( $post->exclusive ) && $post->exclusive == 1 ? true : false;

	return $exclusive;
}
}

if( !function_exists( 'couponis_get_the_usage' ) ){
function couponis_get_the_usage( $post = 0 ){
	$post = get_post( $post );
	$used = isset( $post->used ) ? $post->used : 0;

	return $used;
}
}

if( !function_exists( 'couponis_get_the_positives' ) ){
function couponis_get_the_positives( $post = 0 ){
	$post = get_post( $post );
	$positive = isset( $post->positive ) ? $post->positive : 0;

	return $positive;
}
}

if( !function_exists( 'couponis_get_the_negatives' ) ){
function couponis_get_the_negatives( $post = 0 ){
	$post = get_post( $post );
	$negative = isset( $post->negative ) ? $post->negative : 0;

	return $negative;
}
}

if( !function_exists( 'couponis_get_the_success' ) ){
function couponis_get_the_success( $post = 0 ){
	$post = get_post( $post );
	$success = isset( $post->success ) ? $post->success : 0;

	return $success;
}
}

if( !function_exists('couponis_posts_join_extend') ){
function couponis_posts_join_extend( $sql, $query ){
	if( $query->is_main_query() ){	
		if( ( $query->is_single() && $query->get('post_type') == 'coupon' ) || ( $query->is_tax( 'coupon-store' ) || $query->is_tax( 'coupon-category' ) ) ){
			global $wpdb;
			$sql .= " INNER JOIN {$wpdb->prefix}couponis_coupon_data AS coupons ON $wpdb->posts.ID = coupons.post_id ";
		}
	}

	return $sql;
}
add_filter( 'posts_join', 'couponis_posts_join_extend', 10, 2 );
}

if( !function_exists('couponis_posts_fields_extend') ){
function couponis_posts_fields_extend( $sql, $query ){
	if( $query->is_main_query() ){
		if( $query->is_single() && $query->get('post_type') == 'coupon' ){
			$sql .= ", coupons.* ";
		}
		else if( $query->is_tax( 'coupon-store' ) || $query->is_tax( 'coupon-category') ){
			global $wpdb;
			$sql .= $wpdb->prepare(", coupons.*, (CASE WHEN expire < %d THEN 1 ELSE 0 END) AS is_expired ", current_time('timestamp'));
		}
	}

	return $sql;
}
add_filter( 'posts_fields', 'couponis_posts_fields_extend', 10, 2 );
}

if( !function_exists('couponis_posts_orderby_extend') ){
function couponis_posts_orderby_extend( $sql, $query ){
	if( $query->is_main_query() ){	
		if( $query->is_tax( 'coupon-store' ) || $query->is_tax( 'coupon-category') ){
			$sql = " is_expired ASC, coupons.expire ASC ";
		}
	}

	return $sql;
}
add_filter( 'posts_orderby', 'couponis_posts_orderby_extend', 10, 2 );
}
?>