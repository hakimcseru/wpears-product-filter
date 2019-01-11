<?php
function filterby_price(){
	global $wp_query;

	//get product category
    $pPrice = $_POST['pPrice'];
    $minPrice = $pPrice['minPrice'];
	$maxPrice = $pPrice['maxPrice'];

	//custom query with passing product price range
    $query = array(
        'post_status' => 'publish',
        'post_type' => 'product',
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => '_price',
                'value' => array($minPrice, $maxPrice),
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            )
        )
    );
	$wp_query = new WP_Query( $query );

	// set query in woocommerce
	if( class_exists('WC_Query') &&  method_exists('WC_Query', 'product_query') ) {
        wc()->query->product_query($wp_query);
    }

    // unset arguments
    unset( $args );

	// custom loop with passing product term
    ob_start();

    if ( $wp_query->have_posts() ) {
        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();
        if( ! function_exists('woocommerce_maybe_show_product_subcategories') ) {
            woocommerce_product_subcategories();
        }

        while ( have_posts() ) {
            the_post();
            wc_get_template_part( 'content', 'product' );
        }

        woocommerce_product_loop_end();

        do_action('woocommerce_after_shop_loop');

        wp_reset_postdata();

        $_RESPONSE['products'] = ob_get_contents();
    } else {

        $_RESPONSE['no_products'] = ob_get_contents();
    }
    ob_end_clean();

    
	echo json_encode(array( 'rainbow_price_content' => $_RESPONSE ),JSON_PRETTY_PRINT);
	exit(); 
}

add_action('wp_ajax_filterby_price','filterby_price');
add_action('wp_ajax_nopriv_filterby_price','filterby_price');
