( function( $ ) {
    // Expressions indented
 	var renew_btn = $( '.custom-action-btn' );
 	var manual_btn = $( '.manual-action-btn' );
 	var invoice_btn = $( '.invoice-action-btn' );
 	var mail_btn = $( '.mail-action-btn' );

 	renew_btn.on( 'click', function( e ){
 		e.preventDefault();
 		var cr = confirm("You really want to process this payment?");
 		if( !cr ){
 			return false;
 		}
 		var uid = $(this).attr('data-id');
 		var data = {
 			'action' : 'paces_hard_renew',
 			'id' : uid
 		};
 		$( this ).find('span').css( 'display', 'inline-block' );
 		$.post( ajaxurl, data, function( response ){
 			console.log(response);
 			if(response == 'success'){
 				window.location.reload();
 			}else{
 				alert('error while processing');
 			}
 			$( e.target ).find('span').css( 'display', 'none' );
 		} );

 	} );

 	manual_btn.on( 'click', function( e ){
 		e.preventDefault();
 		var cr = confirm("You really want to activate this manually?");
 		if( !cr ){
 			return false;
 		}
 		var uid = $(this).attr('data-id');
 		var data = {
 			'action' : 'paces_manual_renew',
 			'id' : uid
 		};
 		$( this ).find('span').css( 'display', 'inline-block' );
 		$.post( ajaxurl, data, function( response ){
 			console.log(response);
 			if(response == 'success'){
 				window.location.reload();
 			}else{
 				alert('error while processing');
 			}
 			$( e.target ).find('span').css( 'display', 'none' );
 		} );

 	} );
 	invoice_btn.on( 'click', function( e ){
 		e.preventDefault();
 		var cr = confirm("Send invoice to member for payment");
 		if( !cr ){
 			return false;
 		}
 		var uid = $(this).attr('data-id');
 		var data = {
 			'action' : 'paces_send_invoice_renew',
 			'id' : uid
 		};
 		$( this ).find('span').css( 'display', 'inline-block' );
 		$.post( ajaxurl, data, function( response ){
 			console.log(response);
 			if(response == 'success'){
 				alert('Send successfully');
 				// window.location.reload();
 			}else{
 				alert('error while processing');
 			}
 			$( e.target ).find('span').css( 'display', 'none' );
 		} );

 	} );

 	mail_btn.on( 'click', function( e ){
 		e.preventDefault();
 		
 		var uid = $(this).attr('data-id');
 		var data = {
 			'action' : 'paces_send_mail',
 			'id' : uid
 		};
 		$( this ).find('span').css( 'display', 'inline-block' );
 		$.post( ajaxurl, data, function( response ){
 			console.log(response);
 			if(response == 'success'){
 				alert('mail send successfuly');
 			}else{
 				alert('error while processing');
 			}
 			$( e.target ).find('span').css( 'display', 'none' );
 		} );

 	} );

} )( jQuery );