jQuery(document).ready(function($) {


var create_order = {

	start_page_1: function() {

		$(document).on("click", ".btn_cr_order", function(evt) {

			evt.preventDefault();

			var product_id = ((plugin_frontend.product_id.length > 0) ? parseInt(plugin_frontend.product_id) : "");


			var data = {
				'action': 'add_product_for_processing',
				'product_id': product_id      // We pass php values differently!
			};

			jQuery.post(plugin_frontend.ajax_url, data, function(response) {

				if (response == "false") {
					location.reload();
					return;
				}

				$('#containerProductTab').html(response);

			});

			$(this).bind('click', false);
			$(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");
		})
	},

	customizer_1: function() {

		$(document).on('click', '.testDiv', function(event) {
			event.preventDefault();
			console.log("adff");
		});
	},

	increment_decrement: function() {

		$('input[name="product_sizes_single_input[]"]').val(0);
		$('input[name="product_sizes_single_input[]"]').removeAttr('disabled');

		$(document).on('click', '.product_decrement', function(event) {


			var parent_el = $(this).parent().parent();

			var child_el = parent_el.find('.input_no > input');

			var is_disabled = child_el.attr('disabled');



			var prev_val = child_el.val();

			prev_val = parseInt(prev_val);

			prev_val = Math.abs(prev_val);

			if (prev_val <= 0)
				return;

			var new_val = prev_val - 1;

			if (!(is_disabled == "disabled"))
				child_el.val(new_val);

			update_amount($(this));

			//$('input[name="product_sizes_single_input[]"]').removeAttr('disabled');


		});


		$(document).on('click', '.product_increment', function(event) {

			var parent_el = $(this).parent().parent();

			var child_el = parent_el.find('.input_no > input');

			var is_disabled = child_el.attr('disabled');

			var prev_val = child_el.val();

			prev_val = parseInt(prev_val);

			prev_val = Math.abs(prev_val);

			var new_val = prev_val + 1;

			if (!(is_disabled == "disabled"))
				child_el.val(new_val);


			update_amount($(this));

		});


		function update_amount(this_var) {

			console.log(this_var);

			var prev_html = this_var.html();

			this_var.html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");

			$('input[name="product_sizes_single_input[]"]').attr('disabled', 'disabled');

			var total = 0;

			$('input[name="product_sizes_single_input[]"]').each(function() {

				total += parseInt($(this).val());

			});


			if (total <= 0)
				return;

			var product_id = ((plugin_frontend.product_id.length > 0) ? parseInt(plugin_frontend.product_id) : "");


			var data = {
				'action': 'add_calculate_total_update',
				'total': total,      // We pass php values differently!
				'product_id' : product_id
			};

			jQuery.post(plugin_frontend.ajax_url, data, function(response) {


				//$('#containerProductTab').html(response);


				response = jQuery.parseJSON( response )

				//console.log(typeof response);

				//console.log( response);

				$(".add_calculate_total_price span").html(Math.round(response.total_price_after_discount * 100) / 100);
				$(".add_calculate_single_price span").html(Math.round(response.single_price_after_discount * 100) / 100);

				$('input[name="product_sizes_single_input[]"]').removeAttr('disabled');

				//$('input[name="product_sizes_single_input[]"]').attr('disabled', 'disabled');
				this_var.html(prev_html);

			});


		}


	},

	logo_select : function() {

		$(document).on("click", ".btn_add_calculate_total", function(evt) {

			evt.preventDefault();

			var product_id = ((plugin_frontend.product_id.length > 0) ? parseInt(plugin_frontend.product_id) : "");

			var sizeData = new Map();

			sizeData.set("test" , 5);

			$("input[name='product_sizes_single_input[]']").each(function(k, v) {
					// console.log($(this).val());
					// console.log($(this).data('size'));
					//sizeData.$(this).data('size') = $(this).val();
					sizeData.set($(this).data('size') , $(this).val());

			});

			console.log(sizeData.keys());
			console.log(sizeData.values());
			console.log(sizeData.size);

			console.log( $("input[name='single_color_choice_input[]']:checked").val() );
///
var myMap = new Map();

var keyString = "a string",
    keyObj = {},
    keyFunc = function () {};

// setting the values
myMap.set(keyString, "value associated with 'a string'");
myMap.set(keyObj, "value associated with keyObj");
myMap.set(keyFunc, "value associated with keyFunc");
console.log(myMap.size);
console.log(myMap.entries());
console.log(myMap.get(keyString));

///


			var data = {
				'action': 'add_product_for_processing',
				'product_id': product_id      // We pass php values differently!
			};

			// jQuery.post(plugin_frontend.ajax_url, data, function(response) {
			//
			// 	if (response == "false") {
			// 		location.reload();
			// 		return;
			// 	}
			//
			// 	$('#containerProductTab').html(response);
			//
			// });
			//
			// $(this).bind('click', false);
			// $(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");
		})


	}

}

	create_order.start_page_1();
	create_order.customizer_1();
	create_order.increment_decrement();
	create_order.logo_select();


})
