<?php 

// require __DIR__ . '/vendor/autoload.php';

// use Automattic\WooCommerce\Client;

function main_page(){
?>
	<div class="wrap wpsp-dashboard-body">
		<div class="wpsp-header">
			<h1>Wpears Product Filter Options</h1>
		</div>
	</div>
<?php
	

	 $args = array(
                'post_type'        => 'product',
                'numberposts'      => -1,
                'post_status'      => 'publish',
                'fields'           => 'ids',
                'tax_query'      => array( array(
                        'taxonomy'        => 'pa_color',
                        'field'           => 'slug',
                        'terms'           =>  array('blue'),
                        'operator'        => 'IN',
                    ) )
            );

            $filtered_posts = get_posts( $args );


            /* Curl Practise Code */
            //$cInit = curl_init();

            // Setup headers - I used the same headers from Firefox version 2.0.0.6 
            // below was split up because php.net said the line was too long. :/ 
            //$header[] = "Accept: application/json";
            //$header[] = "Content-Type: application/json"; 


            // set URL and other appropriate options
            //curl_setopt($cInit, CURLOPT_URL, "https://jsonplaceholder.typicode.com/photos");
            //curl_setopt($cInit, CURLOPT_URL, "https://unsplash.com/search/photos/nature");

            //curl_setopt($cInit, CURLOPT_RETURNTRANSFER,true);
            // set header options
            //curl_setopt($cInit, CURLOPT_HTTPHEADER, $header);

            // grab URL and pass it to the browser
            //$result = curl_exec($cInit); 

            //https://images.unsplash.com/photo-1540202403-b7abd6747a18

            //match all resources image
            //preg_match_all("!https://images.unsplash.com/[^\s]*!", $result, $matches);

            //$image = array_value( array_unique( $matches[0] ) );

            // echo "<pre>";
            // print_r( $matches );
            // echo "</pre>";
            
            // for( $i=0;$i<sizeof($matches);$i++ ) {
            //     //echo '<img style="width:30%;float:left" src="'.$image[$i].'">';
            //     echo "hello";
            //     echo "<br>";
            // } 

            // close cURL resource, and free up system resources
            //curl_close($cInit);

            //$results = json_decode($result);



            // $woocommerce = new Client(
            //     'http://localhost/wootest/',
            //     'ck_aac396f1bfd045bd2bc76865cde9af0143083500',
            //     'cs_96fb46746712af3fe98c2ecdaed2f04a61c8374c',
            //     [
            //         'wp_api' => true,
            //         'version' => 'wc/v3'
            //     ]
            // );

            //global $woocommerce;
            // $apiResult = $woocommerce->get('http://localhost/wootest/wp-json/wc/v3/products?attribute=pa_color&attribute_term=17?consumer_key=ck_aac396f1bfd045bd2bc76865cde9af0143083500&consumer_secret=cs_96fb46746712af3fe98c2ecdaed2f04a61c8374c');

            // echo "<pre>";
            // print_r( $apiResult );
            // echo "</pre>";
            

            /* Curl Practise Code End */

           $wp_query = new WP_Query( $args );

           if( class_exists('WC_Query') &&  method_exists('WC_Query', 'product_query') ) {

           	echo $result = wc()->query->product_query($wp_query);
            // echo "<pre>";
            // print_r( $result );
            // echo "</pre>";
            
        	}

        	//add_filter( 'loop_shop_post_in', array( __CLASS__, 'price_filter' ) );
        	// global $wpdb, $wp_query;
        	// $result =  $wpdb->get_results( $wpdb->prepare("
         //        SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
         //        INNER JOIN $wpdb->postmeta ON ID = post_id
         //        WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish'
         //    " ) );
         //    echo "hh";
        	// echo "<pre>";
        	// print_r( $result );
        	// echo "</pre>";
        	
	
}


