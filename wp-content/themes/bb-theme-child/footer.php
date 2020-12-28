<?php do_action( 'fl_content_close' ); ?>



	</div><!-- .fl-page-content -->

	<?php



	do_action( 'fl_after_content' );



	if ( FLTheme::has_footer() ) :



	?>

	<footer class="fl-page-footer-wrap" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

		<?php



		do_action( 'fl_footer_wrap_open' );

		do_action( 'fl_before_footer_widgets' );



		FLTheme::footer_widgets();



		do_action( 'fl_after_footer_widgets' );

		do_action( 'fl_before_footer' );



		FLTheme::footer();



		do_action( 'fl_after_footer' );

		do_action( 'fl_footer_wrap_close' );



		?>

	</footer>

	<?php endif; ?>

	<?php do_action( 'fl_page_close' ); ?>

</div><!-- .fl-page -->

<?php



wp_footer();



do_action( 'fl_body_close' );



FLTheme::footer_code();



?>
<?php /*?><script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery_min.js"></script><?php */?>
<script>
	setTimeout( function() {
		jQuery(".simplefilter").fadeIn(800);
	}, 700);
	
    jQuery(window).on('load', function() {
        jQuery('.preloader').addClass('preloader-deactivate');
    });
</script>

<script>
jQuery(document).ready(function() {
            jQuery("#btnSubmit").click(function(){

                var cdau =jQuery("#cdau").val();

                console.log(cdau);

                var cname=jQuery("#cname").val();
                var cemail=jQuery("#cemail").val();
                var cphone=jQuery("#cphone").val();

                if (cname !== '' && cemail !== '' && cphone !== '') {


                    var daily_rate = cdau/365;

                    var result = daily_rate/5.5;

                    var system_size =result*1.1;

                    var rounded = Math.round( system_size * 10 ) / 10;


//       var sun = ;

//       var system = ;

                    var system_price=0;

                    var pvm = jQuery("#pvm").val();


                    if(pvm==1){

                        var pvmv = 'QCells-310';

                        system_price = rounded*2.70;
                    }

                    if(pvm==2){

                        var pvmv = 'LG340N1C-A5';

                        system_price = rounded*2.80;

                    }

                    if(pvm==3){

                        var pvmv = 'Panasonic HIT330';


                        system_price = rounded*2.85;

                    }

//alert(pvmv); return false;


                    jQuery("#result").empty();

                    var system_price1 = system_price.toFixed(2);

                    //thousands_separators(system_price1)
                    var system_price3 = decimalmultiply(system_price,1000);

                    var system_price7 = round(system_price3, 2);

                    var system_price4 = thousands_separators(system_price7);

                    var system_size33 =Math.round(system_size);


                    jQuery("#result").append( "<h4>Estimated System Size: <b>"+rounded+" kwDC</b></h4><h4>Estimated System Price: <b>$"+system_price4+".00 </b></h4><p>These estimates are based on averages for Southern California. Final system size and pricing determined via email, telephone, or in-home consolation.</p>");


                    /*
                    <h4 class='discla'><b>Disclaimer</b>:This price estimate does not include city permitting fees.</h4>*/


                    console.log(system_size);
//console.log(quantity_of_modules);
                    console.log(system_price);

//return false;

                    jQuery.ajax({

                        type: "POST",
                        url: "https://www.crownsolarelectric.com/action/",
                        //dataType: 'json',
                        //dataType: 'json',
                        data: {system_price4: system_price4,system_size:rounded,pvmv:pvmv,cemail:cemail,cname:cname,cphone:cphone},
                        success: function(data) {
                            console.log(data);
                            //$('#child_div').empty();
                            //$('#child_div').html(data);

                        }
                    });

                    return false;

                }


//alert("button");
            });
        });


        /*$(document).ready(function () {
               $('#minor_children').click(function (event) {*/

        jQuery(document).ready(function() {
            jQuery("#minor_children").click(function(event){


                if (this.checked) {
                    jQuery('#show_guardian').show("slow");

                }
                else {

                    jQuery('#show_guardian').hide("slow");

                }
            });

        });

        function thousands_separators(num)
        {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        }

        function decimalmultiply(a, b) {
            return parseFloat((a * b).toFixed(12));
        }

        function round(value, precision) {
            var multiplier = Math.pow(10, precision || 0);
            return Math.round(value * multiplier) / multiplier;
        }
		
		
</script>
</body>

</html>

