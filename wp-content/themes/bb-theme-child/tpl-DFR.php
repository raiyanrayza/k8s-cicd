<?php
/*
Template Name: Daily Field Report
*/
get_header();
?>

<div class="home_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="dfr__body dfr__body_Paces">
          <h3> <span class="pmpro_checkout-h3-name">Membership Level</span> <span class="pmpro_checkout-h3-msg"><a href="https://aibitz.com/paces/membership-account/membership-levels/">change</a></span></h3>
          <div class="dfr__bodyfields">
            <p> You have selected the <strong>Basic  Membership</strong> membership level. </p>
            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
            <div id="pmpro_level_cost">
              <p>The price for membership is <strong>$10.00</strong> now. </p>
              <p>Membership expires after 1 Month.</p>
            </div>
          </div>
          <div class="dfr__bodyfields">
            <h3> <span class="pmpro_checkout-h3-name">Account Information</span> <span class="pmpro_checkout-h3-msg">Already have an account? <a href="https://aibitz.com/paces/login/?redirect_to=https%3A%2F%2Faibitz.com%2Fpaces%2Fmembership-account%2Fmembership-checkout%2F%3Flevel%3D1">Log in here</a></span> </h3>
            <form action="/action_page.php" class="dfr_form">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="date">Username</label>
                    <input type="text" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="pass">Password</label>
                    <input type="password" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="cfpass">Confirm Password</label>
                    <input type="password" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="email">Email Address</label>
                    <input type="email" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="emailc">Confirm Email Address</label>
                    <input type="email" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="specialist">&nbsp;</label>
                    <span class="gwt-CheckBox">
                    <input value="on" id="avi-no-fuel-stops" tabindex="0" class="avi-fuel-stops-checkbox" type="checkbox">
                    <label for="avi-no-fuel-stops" class="avi-fuel-stops-checkbox-label">I'm, an EP Specialist</label>
                    </span> </div>
                </div>
              </div>
            </form>
          </div>
          <div class="dfr__bodyfields">
            <h3> <span class="pmpro_checkout-h3-name">Payment Information</span> <span class="pmpro_checkout-h3-msg">We Accept Visa, Mastercard, American Express, and Discover</span> </h3>
            <form action="/action_page.php"  class="dfr_form">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label class="control-label" for="date">Card Number</label>
                    <input type="text" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="cfpass">Card Number</label>
                    <input type="password" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label class="control-label" for="email">Card Number</label>
                    <input type="email" class="form-control" id="project" placeholder="Type here">
                  </div>
                </div>
              </div>
              <div class="button_process">
                <input type="submit" id="pmpro_btn-submit" class="paces_checkout" value="Submit and Check Out »">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?php
 get_footer();
?>
