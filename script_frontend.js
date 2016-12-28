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

			//console.log(this_var);

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

			var sizeData = new Object;

			$("input[name='product_sizes_single_input[]']").each(function(k, v) {

					sizeData[$(this).data('size')] = $(this).val();

			});

			var color_val = $("input[name='single_color_choice_input[]']:checked").val();

			var data = {
				'action': 'process_color_amount',
				'product_id': product_id,
				'size_data' : sizeData,
				'color_val' : color_val

			};

			jQuery.post(plugin_frontend.ajax_url, data, function(response) {

				if (response == "false") {
					location.reload();
					return;
				}
				//console.log(response);
				$('#containerProductTab').html(response);

			});
			//
				$(this).bind('click', false);
				$(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");
		})


	},

	after_logo_select : function() {

		$(document).on("click", ".btn_choose_logo_opt", function(evt) {

				evt.preventDefault();
				var logo_src = $("input[name='logo_selection[]']:checked").data('src');
				var logo_title = $("input[name='logo_selection[]']:checked").data('title');
				var transition_uid = $("input[name='logo_selection[]']:checked").data('uid');

				var data = {
					'action': 'process_logo_src_title',
					'logo_src' : logo_src,
					'logo_title' : logo_title,
					'transition_uid' : transition_uid

				};


				jQuery.post(plugin_frontend.ajax_url, data, function(response) {

					if (response == "false") {
						location.reload();
						return;
					}
					//console.log(response);
					$('#containerProductTab').html(response);

				});

							$(this).bind('click', false);
							$(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");



			});
	},

	go_to_final : function() {

		$(document).on("click", ".go_to_final", function(evt) {

			evt.preventDefault();

			var terms_data = $(this).data('terms');
			terms_data = terms_data.split("|");
			terms_data = terms_data.filter(Boolean);

			var embroidery_option = $("input[name='embroidery_logo_size_selection[]']:checked").data('embroidery_logo_size');
			var color_option = $("input[name='embroidery_logo_color_selection[]']:checked").data('embroidery_logo_color');




			console.log(terms_data);
			var logo_positioning_select = new Object();

			$.each(terms_data, function(k, v) {

				var logo_position = $("input[name='logo_position_selection_"+v+"[]']:checked").data('src');

				logo_positioning_select[v] = logo_position;


			});

			logo_positioning_select = JSON.stringify(logo_positioning_select);
			console.log(logo_positioning_select);

			transient_id = $(".transient_id").data('uid');

			var form = $('form')[0]; // You need to use standart javascript object here
			var formData = new FormData(form);
			formData.append('image_logo', $('input[type=file]')[0].files[0]);
			formData.append('action', 'process_final_step');
			formData.append('logo_positioning_select', logo_positioning_select);
			formData.append('transient_id', transient_id);
			formData.append('embroidery_option', embroidery_option);
			formData.append('color_option', color_option);


		$.ajax({
		    url : plugin_frontend.ajax_url,
		    type: "POST",
		    data : formData,
		    processData: false,
		    contentType: false,
		    success:function(response, textStatus, jqXHR){

					if (response == "false") {
						location.reload();
						return;
					}

					window.location.replace(JSON.parse(response));

					console.log(JSON.parse(response));
					//console.log(typeof response);


		    },
		    error: function(jqXHR, textStatus, errorThrown){
		        //if fails
		    }
		});

		$(this).bind('click', false);
		$(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");



		})

	},

	go_to_final_none : function() {

		$(document).on("click", ".go_to_final_none", function(evt) {

			evt.preventDefault();

			var transition_uid = $(this).data('tuid');

			var data = {
				'action': 'process_final_step_none',
				'transition_uid' : transition_uid

			};


			jQuery.post(plugin_frontend.ajax_url, data, function(response) {

				if (response == "false") {
					location.reload();
					return;
				}
				console.log(response);
				window.location.replace(JSON.parse(response));

			});

		$(this).bind('click', false);
		$(this).html("<img alt='loading' width='20' src='"+plugin_frontend.plugins_url+"/img/ajax-loader.gif' />");



		})

	}




}

	create_order.start_page_1();
	create_order.customizer_1();
	create_order.increment_decrement();
	create_order.logo_select();
	create_order.after_logo_select();
	create_order.go_to_final();
	create_order.go_to_final_none();


})
