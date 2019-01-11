(function($){


	//Ajax Sorting
	$('#rainbow-sorting-product').on('change', function() {	
		//add loader html
		$("#main .products").html(`
			<div id="rainbow_product_loader">
				<div id="rainbow_pd_load_img"></div>
			<div>`
		);

		$('#rainbow_product_loader').show();
		var sortValue = $(this).val();
		//get newest products by ajax
		var pSortingInfo = {
			action: 'filterby_sorting',
			psorting: sortValue,	                    
		};

		$.post(ajax_url, pSortingInfo, function(msg) {
			$("#rainbow_product_loader").fadeOut(500);
			$("#main").html(msg.rainbow_sorting_content.products);
			console.log('success');
		},'json');
	});


	//Ajax attribute filter
	$('[data-rainbowTerm="term"]').on('click',function(e){
		e.preventDefault();
		var productTerm = $(this).text().toLowerCase();
		
		//set product term and ajax method
		var pinfo = {
					action: 'filterby_term',
                    pterm: productTerm,	                    
                };

		$.post(ajax_url, pinfo, function(msg) {
			$("#main").html(msg.rainbow_aj_content.products);
		},'json');

	});

	//on click filter checkbox show/hide
	$('.wpears-widget ul li a').on('click', function(e) {
		e.preventDefault();
		$(this).parent('.wpears-widget ul li').toggleClass('check_select');
	});


	//url parser
	var vars = {}, hash;
	url = 'http://localhost/wootest/shop/?product-cata=26&attra-color=21';
	var hashes = url.slice(url.indexOf('?') + 1).split('&');
	console.log( hashes );
	for (var i = 0; i < hashes.length; i++) {
	        hash = hashes[i].split('=');
	        vars[hash[0]] = hash[1];
	    }
	    console.log(vars);
	

	//Ajax category filter 
	$('[data-rainbow="category"]').on('click',function(e){
		e.preventDefault();
		var productCategory = $(this).attr('data-rainbowcategoryid');
		
		//set product category and ajax method
		var pCategoryInfo = {
					action: 'filterby_category',
                    pcategory: productCategory,	                    
                };

		$.post(ajax_url, pCategoryInfo, function(msg) {
			$("#main").html(msg.rainbow_cat_content.products);
		},'json');

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
		var minValue = Math.floor( $("#minSlideValue").val() );
		var maxValue = Math.floor( $("#maxSlideValue").val() );
		alert("Minimum value is " + minValue + " & Maximum Value is " + maxValue);

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
			$("#main").html(msg.rainbow_price_content.products);
		},'json');
	});
	
	

	

})(jQuery)