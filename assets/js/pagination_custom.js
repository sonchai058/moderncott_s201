var show_per_page 	= 9;
var step_value 		= 10;
var number_of_items = 0;
var number_of_pages = 0;
var wrap_content 	= null;

var tab_menu 		= ['everything', 'recommend', 'popular', 'bestseller'];

var navigation_html = '';





function render_pagination() {
	if (number_of_pages > 1) {
		$('#current_page').val(0);
		$('#show_per_page').val(show_per_page);

		navigation_html  = '<li><a class="first_link" href="javascript:first();"><i class="fa fa-step-backward"></i></a></li>';
		navigation_html += '<li><a class="stepBackward_link" href="javascript:step_backward();"><i class="fa fa-angle-double-left"></i></a></li>';
		navigation_html += '<li><a class="previous_link" href="javascript:previous();"><i class="fa fa-angle-left"></i></a></li>';
		var current_link = 0;
		while (number_of_pages > current_link) {
			navigation_html += '<li><a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a></li>';
			current_link += 1;
		}
		navigation_html += '<li><a class="next_link" href="javascript:next();"><i class="fa fa-angle-right"></i></a></li>';
		navigation_html += '<li><a class="stepForward_link" href="javascript:step_forward();"><i class="fa fa-angle-double-right"></i></a></li>';
		navigation_html += '<li><a class="last_link" href="javascript:last();"><i class="fa fa-step-forward"></i></a></li>';

		$('.pagination ul').html(navigation_html);
		$('.pagination ul li:first').addClass('disabled');
		$('.pagination ul li:nth-child(2)').addClass('disabled');
		$('.pagination ul li:nth-child(3)').addClass('disabled');
		$('.pagination ul li:nth-child(4)').addClass('active');
		if ($('.pagination ul li').length <= 7) {
			$('.pagination ul li:nth-child(5)').addClass('disabled');
			$('.pagination ul li:nth-child(6)').addClass('disabled');
			$('.pagination ul li:last').addClass('disabled');
		}
	}
	else
		$('.pagination ul').html('');
}

function first() {
	if ($(".first_link").closest("li").prop("class") != "disabled")
		go_to_page(0);
}

function step_backward() {
	new_page = parseInt($('#current_page').val()) - step_value;
	if (new_page >= 0)
		go_to_page(new_page);
	else if (new_page < 0) {
		if ($(".stepBackward_link").closest("li").prop("class") != "disabled")
			go_to_page(0);
	}
}

function previous() {
	new_page = parseInt($('#current_page').val()) - 1;
	if (new_page >= 0)
		go_to_page(new_page);
}

function go_to_page(page_num) {
	if ($('.pagination ul li:nth-child(' + (page_num + 4) + ')').prop('class') != 'active') {
		var show_per_page = parseInt($('#show_per_page').val());
		start_from = page_num * show_per_page;
		end_on = start_from + show_per_page;
		$('#' + wrap_content).children().css('display', 'none').slice(start_from, end_on).fadeIn("fast").css('display', 'inline-block');
		$('.pagination ul li').removeClass('active');
		$('.pagination ul li:nth-child(' + (page_num + 4) + ')').addClass('active');
		if (page_num <= 0) {
			$('.pagination ul li:first').addClass('disabled');
			$('.pagination ul li:nth-child(2)').addClass('disabled');
			$('.pagination ul li:nth-child(3)').addClass('disabled');
		}
		else if (page_num >= 0) {
			$('.pagination ul li:first').removeClass('disabled');
			$('.pagination ul li:nth-child(2)').removeClass('disabled');
			$('.pagination ul li:nth-child(3)').removeClass('disabled');
		}
		if ((page_num + 1) >= number_of_pages) {
			$('.pagination ul li:nth-child(' + (number_of_pages + 4) + ')').addClass('disabled');
			$('.pagination ul li:nth-child(' + (number_of_pages + 5) + ')').addClass('disabled');
			$('.pagination ul li:last').addClass('disabled');
		}
		else if ((page_num + 1) <= number_of_pages) {
			$('.pagination ul li:nth-child(' + (number_of_pages + 4) + ')').removeClass('disabled');
			$('.pagination ul li:nth-child(' + (number_of_pages + 5) + ')').removeClass('disabled');
			$('.pagination ul li:last').removeClass('disabled');
		}
		$('#current_page').val(page_num);
		// $("html, body").animate({ 
		// 	scrollTop: $("html, body").offset().top 
		// }, 0);
		$('html, body').animate({
    		scrollTop: $(".wrap_content").offset().top
		}, 1000);
	}
}

function next() {
	new_page = parseInt($('#current_page').val()) + 1;
	if (new_page < number_of_pages)
		go_to_page(new_page);
}

function step_forward() {
	new_page = parseInt($('#current_page').val()) + step_value;
	if (new_page < number_of_pages)
		go_to_page(new_page);
	else if (new_page >= number_of_pages) {
		if ($(".stepForward_link").closest("li").prop("class") != "disabled")
			go_to_page(number_of_pages - 1);
	}
}

function last() {
	if ($(".last_link").closest("li").prop("class") != "disabled")
		go_to_page(number_of_pages - 1);
}





$(document).ready(function() {

	$('.wrap_content_tab_menu').each(function(i) {
		$('#' + tab_menu[i]).click(function() {
			setTimeout(function() {
				wrap_content = $('#wrap_content_' + tab_menu[i]).prop('id');

				var tab_index = 0;
				while (tab_index < tab_menu.length) {
					if (tab_index !== i) {
						$('#' + tab_menu[tab_index]).removeClass('active');
						$('#wrap_content_' + tab_menu[tab_index]).css('display', 'none');
					}
					tab_index += 1;
				}

				$('#' + tab_menu[i]).addClass('active');
				$('#wrap_content_' + tab_menu[i]).fadeIn("fast", function() {
					$('#wrap_content_' + tab_menu[i]).css('display', 'inline-block');
				});
				
				number_of_items = $('#wrap_content_' + tab_menu[i]).children().size(); 
				number_of_pages = Math.ceil(number_of_items/show_per_page);

				navigation_html = '';
				render_pagination();

				$('#wrap_content_' + tab_menu[i]).children().css('display', 'none');
				$('#wrap_content_' + tab_menu[i]).children().slice(0, show_per_page).css('display', 'inline-block');
			}, 100);
		});
	});

	$('.wrap_content_tab').find($('#' + tab_menu[0] + ' a')).trigger('click');



	$('.wrap_content_grid').find($('.wrap_content_pagination')).load(function() {
		wrap_content = $('#wrap_content_pagination').prop('id');
		
		number_of_items = $('#wrap_content_pagination').children().size(); 
		number_of_pages = Math.ceil(number_of_items/show_per_page);

		navigation_html = '';
		render_pagination();

		$('#wrap_content_pagination').children().css('display', 'none');
		$('#wrap_content_pagination').children().slice(0, show_per_page).css('display', 'inline-block');
	});

	$('.wrap_content_grid').find($('.wrap_content_pagination')).trigger('load');



	$('.wrap_content_gallery').find($('.wrap_content_row')).load(function() {
		show_per_page = 16;
		wrap_content = $('.wrap_content_row').prop('id');
		
		number_of_items = $('.wrap_content_row').children().size(); 
		number_of_pages = Math.ceil(number_of_items/show_per_page);

		navigation_html = '';
		render_pagination();

		$('.wrap_content_row').children().css('display', 'none');
		$('.wrap_content_row').children().slice(0, show_per_page).css('display', 'block');
	});

	$('.wrap_content_gallery').find($('.wrap_content_row')).trigger('load');



	// $('#recommend').click(function() {
	// 	setTimeout(function() {
	// 		wrap_content = $('#wrap_content_recommend').prop('id');

	// 		$('#recommend').addClass('active');
	// 		$('#popular').removeClass('active');
	// 		$('#bestseller').removeClass('active');
	// 		$("#wrap_content_recommend").fadeIn("fast", function() {
	// 			$('#wrap_content_recommend').css('display', 'inline-block');
	// 		});
	// 		$('#wrap_content_popular').css('display', 'none');
	// 		$('#wrap_content_bestseller').css('display', 'none');
			
	// 		number_of_items = $('#wrap_content_recommend').children().size(); 
	// 		number_of_pages = Math.ceil(number_of_items/show_per_page);

	// 		render_pagination();

	// 		$('#wrap_content_recommend').children().css('display', 'none');
	// 		$('#wrap_content_recommend').children().slice(0, show_per_page).css('display', 'inline-block');
	// 	}, 100);
	// });

	// $('#popular').click(function() {
	// 	setTimeout(function() {
	// 		wrap_content = $('#wrap_content_popular').prop('id');

	// 		$('#recommend').removeClass('active');
	// 		$('#popular').addClass('active');
	// 		$('#bestseller').removeClass('active');
	// 		$('#wrap_content_recommend').css('display', 'none');
	// 		$("#wrap_content_popular").fadeIn("fast", function() {
	// 			$('#wrap_content_popular').css('display', 'inline-block');
	// 		});
	// 		$('#wrap_content_bestseller').css('display', 'none');

	// 		number_of_items = $('#wrap_content_popular').children().size(); 
	// 		number_of_pages = Math.ceil(number_of_items/show_per_page);

	// 		render_pagination();

	// 		$('#wrap_content_popular').children().css('display', 'none');
	// 		$('#wrap_content_popular').children().slice(0, show_per_page).css('display', 'inline-block');
	// 	}, 100);
	// });

	// $('#bestseller').click(function() {
	// 	setTimeout(function() {
	// 		wrap_content = $('#wrap_content_bestseller').prop('id');

	// 		$('#recommend').removeClass('active');
	// 		$('#popular').removeClass('active');
	// 		$('#bestseller').addClass('active');
	// 		$('#wrap_content_recommend').css('display', 'none');
	// 		$('#wrap_content_popular').css('display', 'none');
	// 		$("#wrap_content_bestseller").fadeIn("fast", function() {
	// 			$('#wrap_content_bestseller').css('display', 'inline-block');
	// 		});

	// 		number_of_items = $('#wrap_content_bestseller').children().size(); 
	// 		number_of_pages = Math.ceil(number_of_items/show_per_page);

	// 		render_pagination();

	// 		$('#wrap_content_bestseller').children().css('display', 'none');
	// 		$('#wrap_content_bestseller').children().slice(0, show_per_page).css('display', 'inline-block');
	// 	}, 100);
	// });

	// $('#recommend a').trigger('click');

});