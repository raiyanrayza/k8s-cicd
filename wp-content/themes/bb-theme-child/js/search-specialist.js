jQuery(document).ready(function($){
	var form_id = '#search_ep_specialist';
	var search_results = '#search_results';
	var result_tbl_body = '#ep-results tbody';

	$(form_id).submit(function(event){
		event.preventDefault();

		var form = $(this)[0];
    	var form_data = new FormData(form);                  
    	var pageLength = jQuery('#records').val();
		var invalid_query_msg = 'No matching data available.';
		$.ajax({
			url: paces_obj.ajaxurl,
			type: "POST",
			data: form_data,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$(search_results).html('');
				$('.preloader').removeClass('preloader-deactivate');
				// $(".search_response .loading_wrap").show();
				$(".ep_search_form_div").hide();
				$(result_tbl_body).empty();
				$(result_tbl_body).html('');
				if ( $.fn.DataTable.isDataTable('#ep-results') ) {
					$('#ep-results').DataTable().destroy();
				}
          	},
			success: function (data, status, jqXHR) {
				console.log(data);
				var res =JSON.parse(data);
				if(res.type == 'blankrequest'){
					$(search_results).html('<p>You cannot perform an ungoverned query of all customers. You must enter some criteria to query customers. Please press the BACK button on your browser and try again.</p>');
					invalid_query_msg = 'You cannot perform an ungoverned query of all customers. You must enter some criteria to query customers. Please press the BACK button on your browser and try again.';
					$(result_tbl_body).empty();
					$(result_tbl_body).html('');
				}else if(res.type == 'fail'){
					// $(search_results).html('<p>No data found.</p>');
					$(result_tbl_body).empty();
					/*$('#ep-results tbody').html('');*/	
				}else if(res.type == 'success'){
					var data = res.data;
					var html_data = '';
					var row_html = '';
					html_data += '<ul class="results-found pagination" id="pagination">';
					$.each(data, function(index, value) {
					    html_data += '<li><a href="'+value.url+'">'+value.name+'</a></li>';
					    row_html += '<tr><td><a href="'+value.url+'">'+value.name+'</a></td></tr>';
					});
					html_data += '</ul>';

					$(result_tbl_body).empty();
					$(result_tbl_body).html(row_html);	
				
				}
				/*$(".search_response").show();*/
				
			},
			error: function (jqXHR, status, err) {
				console.log(err);
			},
			complete: function (jqXHR, status) {
				// $(".search_response .loading_wrap").hide();
				$(".search_response").show();
				$('html, body').animate({scrollTop: $('.search_response').offset().top -200 }, 'slow');
				console.log(pageLength);
				var tbl = $('#ep-results').DataTable({
					"ordering": false,
					"language": {
				    	"emptyTable": invalid_query_msg
				    },
					"drawCallback": function( settings ) {
					$("#ep-results thead").remove();} 
				});
				tbl.page.len( parseInt(pageLength) ).draw();		
				$('.preloader').addClass('preloader-deactivate');
			}
		});
	});

	var inside_scroll_links = jQuery('.page_inside_scroll li a');

	inside_scroll_links.on('click', function(event){
		event.preventDefault();
		var target = jQuery(this.hash);
		var headerHeight = jQuery(".fl-page-header").height() + 50;

		if (target.length){
			jQuery('html,body').animate({
				scrollTop: target.offset().top - headerHeight
			}, 500);
			return false;
		}
	});

});

function show_ep_spec_form(){
	jQuery(".search_response").hide();
	jQuery(".ep_search_form_div").show();
	jQuery('html, body').animate({scrollTop: jQuery('.ep_search_form_div').offset().top -200 }, 'slow');
}

const phoneInputs = document.querySelectorAll('.phoneInputbit');
const phoneFormat = '({0}{1}{2}) {3}{4}{5}-{6}{7}{8}{9}';
phoneInputs.forEach((phoneInput) => {
    phoneInput.addEventListener('input', (event) => {
        const inputStripped = phoneInput.value.replace(/\D/g, '');
        const inputIsValid = !isNaN(parseInt(event.data));

        if (event.inputType.includes('deleteContent')) {
            /*
             TODO Create input inequality when values are deleted
             that are NOT at the end of the input

             '(012) 34' -> '(012) 3' FINE
             '(012) 34' -> '(01x) 34' INEQUALITY TO FIX
            */
            return;
        }

        /*
          If text was inserted on 'input', and the current length is max (or input
          value was not a number), then remove the last inputted value.
        */
        if (event.inputType == 'insertText' && (inputStripped.length > 10 || !inputIsValid)) {
            phoneInput.value = phoneInput.value.substring(0, phoneInput.value.length - 1);
            return;
        }

        if (inputStripped)
            phoneInput.value = formatPhoneInput(inputStripped);
    });
});

const formatPhoneInput = (inputNumber) => {
    let inputNumArr = inputNumber.split('');
    let formatVar = inputNumArr.length - 1;

    // indexOf() + 3, so we can replace the entire '{x}' variable in phoneFormat
    let replaceIndex = phoneFormat.indexOf(`{${formatVar}}`) + 3;

    // Autocompletion to next input value
    switch (formatVar) {
        case 2:
            replaceIndex += 2;
            break;
        case 5:
            replaceIndex += 1;
            break;
        default:
            break;
    }

    // phoneFormat substring based on the current number length
    let formattedInput = phoneFormat.substring(0, replaceIndex);

    for (let i = 0; i < inputNumArr.length; i++) {
        formattedInput = formattedInput.replace(`{${i}}`, inputNumArr[i]);
    }

    return formattedInput;
}