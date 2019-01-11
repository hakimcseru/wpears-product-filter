<?php

function filterby_category(){
	global $wp_query;

	//get product category
	$pcategory = $_POST['pcategory'];

	//custom query with passing product category
	// $wp_query = new WP_Query( array(
	//    'post_type'      => array('product'),
	//    'post_status'    => 'publish',
	//    'posts_per_page' => -1,
	//    'tax_query'      => array( array(
	//         'taxonomy'        => 'product_cat',
	//         'field'           => 'term_id',
	//         'terms'           =>  array($pcategory),
	//         'operator'        => 'IN',
	//     ) )
	// ) );

    
    //multiple query test
    $wp_query = new WP_Query( array(
       'post_type'      => array('product'),
       'post_status'    => 'publish',
       'posts_per_page' => -1,
       'tax_query'      => array( 
            'relation' => 'AND',
            array(
                'taxonomy'        => 'pa_color',
                'field'           => 'slug',
                'terms'           =>  array($prod_c),
            ),array(
                'taxonomy'        => 'product_cat',
                'field'           => 'term_id',
                'terms'           =>  array($categ),
            ), 
        )
    ) );

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

    
	echo json_encode(array( 'rainbow_cat_content' => $_RESPONSE ),JSON_PRETTY_PRINT);
	exit(); 
}

add_action('wp_ajax_filterby_category','filterby_category');
add_action('wp_ajax_nopriv_filterby_category','filterby_category');
