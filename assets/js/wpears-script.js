(function($){

	//Ajax Sorting
	$('#wpears-sorting-product ul li a').on('click', function(e) {
		e.preventDefault();

		$('#wpears-sorting-product ul li a').not(this).parent().removeClass('check_select');	
		//add loader html
		// $("#main .products").html(`
		// 	<div id="rainbow_product_loader">
		// 		<div id="rainbow_pd_load_img"></div>
		// 	<div>`
		// );

		// $('#rainbow_product_loader').show();
		// var sortValue = $(this).data('value');
		// var sortValue = $(this).data('filterby');
		//get newest products by ajax
		// var pSortingInfo = {
		// 	action: 'filterby_sorting',
		// 	psorting: sortValue,	                    
		// };

		// $.post(ajax_url, pSortingInfo, function(msg) {
		// 	$("#rainbow_product_loader").fadeOut(500);
		// 	$("#main").html(msg.rainbow_sorting_content.products);
		// 	console.log('success');
		// },'json');
	});


	//Ajax attribute filter
	$('[data-WpearsTerm="term"]').on('click',function(e){
		e.preventDefault();
		var productTerm = $(this).text().toLowerCase();


		
		//set product term and ajax method
		// var pinfo = {
		// 			action: 'filterby_term',
  //                   pterm: productTerm,	                    
  //               };

		// $.post(ajax_url, pinfo, function(msg) {
		// 	$("#main").html(msg.rainbow_aj_content.products);
		// },'json');

	});


	// check and update url
	function updateUrl(filter_key,filter_value) {
 		
		var winLocation = window.location.href;
		url = winLocation;
		console.log(url);
		var url_params = {}, hash;
		var hashes = url.slice(url.indexOf('?') + 1).split('&');
		
		console.log(hashes);
		console.log("gaa");


		for (var i = 0; i < hashes.length; i++) {
		        hash = hashes[i].split('=');
		        url_params[hash[0]] = hash[1];
		    }

		var new_location = '';
		var has_before 	 =  false;

		if(hashes.length)
		{
		
		var coun=1;
		$.each(url_params, function(key, value) {
		   console.log('object key is: ' + key + ' & object value is: ' + value );
		   
		   if( key  != 'http://localhost/wootest/shop/') {

			   if (key in url_params) {
			   		
			   		if( key == 'undefined'  ) {
				   		//history.pushState({}, '', winLocation);
				   		console.log("negative");

				   	}else{
				   		console.log("updated page url: " + url);

				   		if( value != 'undefined') {
				   			console.log(value);
				   			var slicedUrl = url.slice(url.indexOf('?') + 1);

				   			if(key==filter_key)
				   			{
				   				value=value+','+filter_value;
				   				has_before=true;
				   			}

				   			if(coun >1)
				   				new_location +='&'+ key + '=' + value;

						   			else new_location += key + '=' + value;
						   
						   coun++;
						   		//new_location = url.new_location;
						   	console.log("current page: " + url);
						   	console.log(url);
						   	console.log(slicedUrl);
						   	console.log(new_location);
					   		console.log("location updated");
				   			//history.pushState({}, '', new_location);
				   		}else{
				   			console.log(value);
				   			console.log('error');
				   		}	
				   		
				   	}
			    }else {
			   		//history.pushState({}, '', '?' + filter_key + '='+ filter_value);
			    }
			}else {
				console.log('main url asce!');
			}
		});
	}else {
		}
		if(new_location)
		{
 			if(has_before) {
				history.pushState({}, '', '?' +new_location);
			}else {
				history.pushState({}, '', '?' + filter_key + '='+ filter_value+'&'+new_location);
			}
		}else  {
			history.pushState({}, '', '?' + filter_key + '='+ filter_value);
		}

	}

	//on click filter checkbox show/hide
	$('.wpears-widget ul li a').on('click', function(e) {
		e.preventDefault();
		$(this).parent('.wpears-widget ul li').toggleClass('check_select');

		var filter_by = $(this).data('filterby');

		if( filter_by == "category" ) {
			var data_key = 'product-category';
			var data_val = $(this).data('value');
			updateUrl(data_key,data_val);
		}else if( filter_by == "term" ) {
			var data_key = 'product-term';
			var data_val = $(this).data('value');
				data_val = data_val.toLowerCase();
			updateUrl(data_key,data_val);
		}else if( filter_by == "sorting" ) {
			var data_key = 'orderby';
			var data_val = $(this).data('value');
				data_val = data_val.toLowerCase();
			updateUrl(data_key,data_val);
		}else {
			console.log('no filter yet!');
		}

		//display product loader
		$("#main .products").html(`
			<div id="rainbow_product_loader">
				<div id="rainbow_pd_load_img"></div>
			<div>`
		);

		$('#rainbow_product_loader').show();
		
		var product_wrap = ".wpears_product_wrapper";
		console.log(product_wrap.length);
		$.get(window.location.href, function(data) {
			var $data = jQuery(data),
				shop_loop = $data.find(product_wrap);
			var hasProductWrapper = shop_loop.length;
			var product_wrapper = shop_loop.html();
			
			if(hasProductWrapper == '0') {
				$('#rainbow_product_loader').hide();
				$(product_wrap).html('<h1 style="color:red">No Product Found!</h1>');
			}
			$(product_wrap).html(product_wrapper);
			
		});
	});

	/* Ajax Price Filter */ 

	//Price Range Slider JS
	var slider = document.getElementById('slider');

	noUiSlider.create(slider, {
	    start: [20, 80],
	    connect: true,
	    tooltips: true,
	    range: {
	        'min': 0,
	        'max': 100
	    }
	});

	//Get input value of minimum range
	var minRange = document.getElementById('minSlideValue');
	var maxRange = document.getElementById('maxSlideValue');

	//update set value of minimum range
	slider.noUiSlider.on('update', function (values, handle) {
	    if (handle === 0) {
	        minRange.value = values[handle];
	    }
	    if (handle === 1) {
	        maxRange.value = values[handle];
	    }
	});

	//after change value of minimum range
	slider.noUiSlider.on('change',function(){
		//display product loader
		$("#main .products").html(`
			<div id="rainbow_product_loader">
				<div id="rainbow_pd_load_img"></div>
			<div>`
		);

		$('#rainbow_product_loader').show();
		var minValue = Math.floor( $("#minSlideValue").val() );
		var maxValue = Math.floor( $("#maxSlideValue").val() );
		//alert("Minimum value is " + minValue + " & Maximum Value is " + maxValue);

		//set product price and ajax method
		var pinfo = {
					action: 'filterby_price',
                    pPrice: {
                    	minPrice: minValue,
                    	maxPrice: maxValue
                    }	                    
                };
        //Data Pass on Ajax Price Filter
		$.post(ajax_url, pinfo, function(msg) {
			$('#rainbow_product_loader').hide();
			$("#main").html(msg.rainbow_price_content.products);
		},'json');
	});

})(jQuery)