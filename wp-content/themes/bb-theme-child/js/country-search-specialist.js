jQuery(document).ready(function($){
	var form_id = '#search_international_specialist';
	var search_results = '#search_results';
	var result_tbl_body = '#search_by_country .modal-body';

	$(form_id).submit(function(event){
		event.preventDefault();

		var form = $(this)[0];
    	var form_data = new FormData(form);                  
    	// var pageLength = jQuery('#records').val();
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
				// $(".ep_search_form_div").hide();
				$(result_tbl_body).empty();
				$(result_tbl_body).html('');
				/*if ( $.fn.DataTable.isDataTable('#ep-results') ) {
					$('#ep-results').DataTable().destroy();
				}*/
          	},
			success: function (data, status, jqXHR) {
				console.log(data);
				var res =JSON.parse(data);
				if(res.type == 'blankrequest'){
					$(search_results).html('<p>You cannot perform an ungoverned query of all customers. You must enter some criteria to query customers. Please press the BACK button on your browser and try again.</p>');
					invalid_query_msg = 'You cannot perform an ungoverned query of all customers. You must enter some criteria to query customers. Please select any country and try again.';
					$(result_tbl_body).empty();
					$(result_tbl_body).html('');
				}else if(res.type == 'fail'){
					$(search_results).html('<p>No data found.</p>');
					$(result_tbl_body).empty();
					/*$('#ep-results tbody').html('');*/
				}else if(res.type == 'success'){
					console.log(res.data);
					var data = res.data;
					var html_data = '';
					var row_html = '';
					html_data += '<ul class="results-found pagination" id="pagination">';
					$.each(data, function(index, value) {
					    html_data += '<li><a href="'+value.url+'" target="_blank">'+value.name+'</a></li>';
					    row_html += '<tr><td><a href="'+value.url+'">'+value.name+'</a></td></tr>';
					});
					html_data += '</ul>';

					$(result_tbl_body).empty();
					$(result_tbl_body).html(html_data);
					$('#search_by_country').modal('show');
				
				}
			},
			error: function (jqXHR, status, err) {
				console.log(err);
			},
			complete: function (jqXHR, status) {
				$('.preloader').addClass('preloader-deactivate');
			}
		});
	});
});

function search_ep_specialist_by_map(id){
	var $ = jQuery;
	var result_tbl_body = '#search_by_country .modal-body';
	var form_data = new FormData();
	form_data.append('action', 'search_ep_specialist_by_state');
	form_data.append('state', id);                  
	// var pageLength = jQuery('#records').val();
	var invalid_query_msg = 'No matching data available.';
	$.ajax({
		url: paces_obj.ajaxurl,
		type: "POST",
		data: form_data,
		contentType: false,
		processData: false,
		beforeSend: function() {
			$('.preloader').removeClass('preloader-deactivate');
			$(result_tbl_body).html('');
      	},
		success: function (data, status, jqXHR) {
			console.log(data);
			var res =JSON.parse(data);
			if(res.type == 'blankrequest'){
				$(result_tbl_body).html('<p>You cannot perform an ungoverned query of all customers. You must enter some criteria to query customers. Please select any state and try again.</p>');
			}else if(res.type == 'fail'){
				$(result_tbl_body).html('<p>No data found.</p>');
			}else if(res.type == 'success'){
				console.log(res.data);
				var data = res.data;
				var html_data = '';
				var row_html = '';
				html_data += '<ul class="results-found pagination" id="pagination">';
				$.each(data, function(index, value) {
				    html_data += '<li><a href="'+value.url+'" target="_blank">'+value.name+'</a></li>';
				    row_html += '<tr><td><a href="'+value.url+'">'+value.name+'</a></td></tr>';
				});
				html_data += '</ul>';

				$(result_tbl_body).empty();
				$(result_tbl_body).html(html_data);
			}
			$('#search_by_country').modal('show');
		},
		error: function (jqXHR, status, err) {
			console.log(err);
		},
		complete: function (jqXHR, status) {	
			$('.preloader').addClass('preloader-deactivate');
		}
	});
}