jQuery(document).ready(function($) {


function adjust_tab_height() {


	$(".ProductFrontend #content").height($(".ProductFrontend #content-1").height()+50);

	$(document).on('click', ".ProductFrontend label", function(evt) {

		var tabSelector = ".ProductFrontend #"+$(this).data('class');

		$(".ProductFrontend #content").height($(tabSelector).height()+50);

		$('.tab-de-general').addClass('activatedClass');

		$(tabSelector).removeClass('activatedClass');

	})

	$('.tab-de-general').each(function(index, el) {

		if (index !== 0)
			$(this).addClass('activatedClass');
		
	});
}

function adjust_tab_height_sub() {


	$(".ProductFrontendSubTab #content").height($(".ProductFrontendSubTab #content-1").height()+50);

	$(document).on('click', ".ProductFrontendSubTab label", function(evt) {

		var tabSelector = ".ProductFrontendSubTab #"+$(this).data('class');

		$(".ProductFrontendSubTab #content").height($(tabSelector).height()+50);

		$('.tab-de-general_sub').addClass('activatedClass');

		$(tabSelector).removeClass('activatedClass');

	})
}

adjust_tab_height();
adjust_tab_height_sub();

})
