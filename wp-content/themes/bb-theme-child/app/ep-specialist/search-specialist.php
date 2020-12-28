<?php
// here

// Register Script
function search_specialist_scripts() {
	wp_enqueue_style( 'jq-data-tables-style', get_stylesheet_directory_uri() . '/css/jquery.dataTables.min.css');
	wp_enqueue_script( 'jq-data-tables', get_stylesheet_directory_uri() . '/js/jquery.dataTables.min.js', array( 'jquery' ), '', false );

	wp_enqueue_script( 'search-ep-specialist', get_stylesheet_directory_uri() . '/js/search-specialist.js', array( 'jquery' ), '', true );
	wp_localize_script( 'search-ep-specialist', 'paces_obj', array('ajaxurl' => admin_url('admin-ajax.php')) );
	
	wp_enqueue_script( 'country-search-specialist', get_stylesheet_directory_uri() . '/js/country-search-specialist.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'search_specialist_scripts' );



// Add Shortcode
function search_specialist_form_shortcode( $atts ) {

	ob_start();
	?>
	<div class="dfr__body ep_search_form_div">
	  <form action="" method="post" name="search_ep_specialist" id="search_ep_specialist" class="dfr_form">
	    <div class="row">
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="member_subclass">Member SubClass:</label>
	          <select class="form-control" name="member_subclass" id="member_subclass">
	          	<option value="">Any</option>
	            <option value="PE_AFF">Affiliate Member</option>
			    <option value="PE_ASSO">Associate Member</option>
			    <option value="PE_COMP">Complimentary Membership</option>
			    <option value="PE_DEC">Deceased Member</option>
			    <option value="PE_EMER">Emeritus</option>
			    <option value="PE_FULL">Full Member</option>
			    <option value="PE_INTL">International</option>
			    <option value="PE_RES">Resigned</option>
			    <option value="PE_FELL">Trainee Fellow Member</option>
	          </select>
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="first_name">First Name:</label>
	          <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="last_name">Last Name:</label>
	          <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Type here">
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="company">Company:</label>
	          <input type="text" class="form-control" id="company" name="company" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="city">City:</label>
	          <input type="text" class="form-control" id="city" name="city" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="state">State/Prov:</label>
	          	<select class="form-control" id="state" name="state">
	          		<option value="">Any</option>
		            <option value="MOR">Morelos</option>
				    <option value="OAX">Oaxaca</option>
				    <option value="GUA">Guanajuato</option>
				    <option value="TAB">Tabasco</option>
				    <option value="AA">Armed Forces Americas</option>
				    <option value="AB">Alberta</option>
				    <option value="ACT">Australian Capital Territory</option>
				    <option value="AE">Armed Forces</option>
				    <option value="AK">Alaska</option>
				    <option value="AL">Alabama</option>
				    <option value="AP">Armed Forces Pacific</option>
				    <option value="AR">Arkansas</option>
				    <option value="AS">American Samoa</option>
				    <option value="AZ">Arizona</option>
				    <option value="BA">Barbados</option>
				    <option value="BAJ">Baja California Providence</option>
				    <option value="BC">British Columbia</option>
				    <option value="CA">California</option>
				    <option value="CHH">Chihuahua</option>
				    <option value="CO">Colorado</option>
				    <option value="COA">Coahuila</option>
				    <option value="CT">Connecticut</option>
				    <option value="DC">District of Columbia</option>
				    <option value="DE">Delaware</option>
				    <option value="FDM">Federal District of Mexico</option>
				    <option value="FL">Florida</option>
				    <option value="FM">Federated States of Micronesia</option>
				    <option value="GA">Georgia</option>
				    <option value="GU">Guam</option>
				    <option value="HI">Hawaii</option>
				    <option value="IA">Iowa</option>
				    <option value="ID">Idaho</option>
				    <option value="IL">Illinois</option>
				    <option value="IN">Indiana</option>
				    <option value="JAL">Jalisco</option>
				    <option value="KA">Karnataka</option>
				    <option value="KS">Kansas</option>
				    <option value="KY">Kentucky</option>
				    <option value="LA">Louisiana</option>
				    <option value="MA">Massachusetts</option>
				    <option value="MB">Manitoba</option>
				    <option value="MD">Maryland</option>
				    <option value="ME">Maine</option>
				    <option value="MEX">Mexico</option>
				    <option value="MH">Marshall Islands</option>
				    <option value="MI">Michigan</option>
				    <option value="MN">Minnesota</option>
				    <option value="MO">Missouri</option>
				    <option value="MS">Mississippi</option>
				    <option value="MT">Montana</option>
				    <option value="NB">New Brunswick</option>
				    <option value="NC">North Carolina</option>
				    <option value="ND">North Dakota</option>
				    <option value="NE">Nebraska</option>
				    <option value="NH">New Hampshire</option>
				    <option value="NJ">New Jersey</option>
				    <option value="NL">Newfoundland and Labrador</option>
				    <option value="NM">New Mexico</option>
				    <option value="NS">Nova Scotia</option>
				    <option value="NSW">New South Wales</option>
				    <option value="NT">Northern Territory</option>
				    <option value="NU">Nunavut</option>
				    <option value="NV">Nevada</option>
				    <option value="NY">New York</option>
				    <option value="OH">Ohio</option>
				    <option value="OK">Oklahoma</option>
				    <option value="ON">Ontario</option>
				    <option value="OR">Oregon</option>
				    <option value="PA">Pennsylvania</option>
				    <option value="PE">Prince Edward Island</option>
				    <option value="PI">Pacific Islands</option>
				    <option value="PR">Puerto Rico</option>
				    <option value="PU">Puebla</option>
				    <option value="PW">Palau</option>
				    <option value="QC">Québec</option>
				    <option value="QLD">Queensland</option>
				    <option value="QR">Quintana Roo</option>
				    <option value="RI">Rhode Island</option>
				    <option value="SA">South Australia</option>
				    <option value="SC">South Carolina</option>
				    <option value="SD">South Dakota</option>
				    <option value="SE">Seoul</option>
				    <option value="SK">Saskatchewan</option>
				    <option value="SL">St Lucia</option>
				    <option value="SN">Sinaloa</option>
				    <option value="SON">Sonora</option>
				    <option value="ST">St Kitts/Nevis</option>
				    <option value="TAS">Tasmania</option>
				    <option value="TN">Tennessee</option>
				    <option value="TR">Trinidad</option>
				    <option value="TX">Texas</option>
				    <option value="UT">Utah</option>
				    <option value="VA">Virginia</option>
				    <option value="VER">Veracruz</option>
				    <option value="VI">Virgin Islands</option>
				    <option value="VIC">Victoria</option>
				    <option value="VT">Vermont</option>
				    <option value="WA">Washington</option>
				    <option value="WAU">Western Australia</option>
				    <option value="WI">Wisconsin</option>
				    <option value="WV">West Virginia</option>
				    <option value="WY">Wyoming</option>
				    <option value="YT">Yukon</option>
				    <option value="YUC">Yucatan</option>
	          	</select>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="postal_code">Postal:</label>
	          <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	        	<label class="control-label" for="country">Country:</label>
	        	<select class="form-control" id="country" name="country">
	        		<option value="">Any</option>
		            <option value="USA">United States of America</option>
				    <option value="CAN">Canada</option>
				    <option value="AFG">Afghanistan</option>
				    <option value="AGO">Angola</option>
				    <option value="AIA">Anguilla</option>
				    <option value="ALB">Albania</option>
				    <option value="AND">Andorra</option>
				    <option value="ARE">United Arab Emirates</option>
				    <option value="ARG">Argentina</option>
				    <option value="ARM">Armenia</option>
				    <option value="ARU">Aruba</option>
				    <option value="ASM">American Samoa</option>
				    <option value="ATA">Antarctica</option>
				    <option value="ATF">French Southern Territories</option>
				    <option value="ATG">Antigua and Barbuda</option>
				    <option value="AUS">Australia</option>
				    <option value="AUT">Austria</option>
				    <option value="AZE">Azerbaijan</option>
				    <option value="BAH">Bahamas</option>
				    <option value="BDI">Burundi</option>
				    <option value="BEL">Belgium</option>
				    <option value="BEN">Benin</option>
				    <option value="BFA">Burkina Faso</option>
				    <option value="BGD">Bangladesh</option>
				    <option value="BGR">Bulgaria</option>
				    <option value="BHR">Bahrain</option>
				    <option value="BIH">Bosnia and Herzegovina</option>
				    <option value="BLR">Belarus</option>
				    <option value="BLZ">Belize</option>
				    <option value="BMU">Bermuda</option>
				    <option value="BOL">Bolivia</option>
				    <option value="BRA">Brazil</option>
				    <option value="BRB">Barbados</option>
				    <option value="BRN">Brunei Darussalam</option>
				    <option value="BTN">Bhutan</option>
				    <option value="BWA">Botswana</option>
				    <option value="BWI">British West Indies</option>
				    <option value="CAF">Central African Republic</option>
				    <option value="CAY">Cayman Islands</option>
				    <option value="CCK">Cocos (Keeling) Islands</option>
				    <option value="CHA">Channel Islands</option>
				    <option value="CHL">Chile</option>
				    <option value="CHN">China</option>
				    <option value="CIV">Cote D'Ivoire</option>
				    <option value="CMR">Cameroon</option>
				    <option value="COD">Democratic Republic of Congo</option>
				    <option value="COG">Congo</option>
				    <option value="COK">Cook Islands</option>
				    <option value="COL">Colombia</option>
				    <option value="COM">Comoros</option>
				    <option value="CPV">Cape Verde</option>
				    <option value="CST">Costa Rica</option>
				    <option value="CUB">Cuba</option>
				    <option value="CUR">Curacao</option>
				    <option value="CXR">Christmas Island</option>
				    <option value="CYP">Cyprus</option>
				    <option value="CZE">Czech Republic</option>
				    <option value="DEN">Denmark</option>
				    <option value="DJI">Djibouti</option>
				    <option value="DNA">Dominica</option>
				    <option value="DOM">Dominican Republic</option>
				    <option value="DZA">Algeria</option>
				    <option value="ECB">Eastern Caribbean</option>
				    <option value="ECU">Ecuador</option>
				    <option value="EGY">Egypt</option>
				    <option value="ENG">England</option>
				    <option value="ERI">Eritrea</option>
				    <option value="ESH">Western Sahara</option>
				    <option value="EST">Estonia</option>
				    <option value="ETH">Ethiopia</option>
				    <option value="FIJ">Fiji</option>
				    <option value="FIN">Finland</option>
				    <option value="FLK">Falkland Islands (Malvinas)</option>
				    <option value="FRA">France</option>
				    <option value="FRO">Faroe Islands</option>
				    <option value="FSM">Micronesia, Federated States</option>
				    <option value="FXX">France, Metropolitan</option>
				    <option value="GAB">Gabon</option>
				    <option value="GBR">United Kingdom</option>
				    <option value="GEO">Georgia</option>
				    <option value="GER">Germany</option>
				    <option value="GHA">Ghana</option>
				    <option value="GIB">Gibraltar</option>
				    <option value="GIN">Guinea</option>
				    <option value="GLP">Guadeloupe</option>
				    <option value="GMB">Gambia</option>
				    <option value="GNB">Guinea-Bissau</option>
				    <option value="GNQ">Equatorial Guinea</option>
				    <option value="GRC">Greece</option>
				    <option value="GRD">Grenada</option>
				    <option value="GRL">Greenland</option>
				    <option value="GTM">Guatemala</option>
				    <option value="GUA">Guam</option>
				    <option value="GUF">French Guiana</option>
				    <option value="GUY">Guyana</option>
				    <option value="HKG">Hong Kong</option>
				    <option value="HMD">Heard and McDonald Islands</option>
				    <option value="HND">Honduras</option>
				    <option value="HRV">Croatia</option>
				    <option value="HTI">Haiti</option>
				    <option value="HUN">Hungary</option>
				    <option value="IDN">Indonesia</option>
				    <option value="IND">India</option>
				    <option value="IOT">British Indian Ocean Territory</option>
				    <option value="IRE">Ireland</option>
				    <option value="IRN">Iran (Islamic Republic of)</option>
				    <option value="IRQ">Iraq</option>
				    <option value="ISL">Iceland</option>
				    <option value="ISR">Israel</option>
				    <option value="ITA">Italy</option>
				    <option value="JAM">Jamaica</option>
				    <option value="JOR">Jordan</option>
				    <option value="JPN">Japan</option>
				    <option value="KAZ">Kazakhstan</option>
				    <option value="KEN">Kenya</option>
				    <option value="KGZ">Kyrgyzstan</option>
				    <option value="KHM">Cambodia</option>
				    <option value="KIR">Kiribati</option>
				    <option value="KNA">Saint Kitts and Nevis</option>
				    <option value="KOR">Republic of Korea</option>
				    <option value="KSV">Kosovo</option>
				    <option value="KWT">Kuwait</option>
				    <option value="LAO">Lao People's Democratic Rep</option>
				    <option value="LBN">Lebanon</option>
				    <option value="LBR">Liberia</option>
				    <option value="LBY">Libya</option>
				    <option value="LCA">Saint Lucia</option>
				    <option value="LIE">Liechtenstein</option>
				    <option value="LKA">Sri Lanka</option>
				    <option value="LSO">Lesotho</option>
				    <option value="LTU">Lithuania</option>
				    <option value="LUX">Luxembourg</option>
				    <option value="LVA">Latvia</option>
				    <option value="LWI">Leeward Islands</option>
				    <option value="MAC">Macau</option>
				    <option value="MAF">Saint Martin</option>
				    <option value="MAL">Malaysia</option>
				    <option value="MAR">Morocco</option>
				    <option value="MDA">Moldova, Republic of</option>
				    <option value="MDV">Maldives</option>
				    <option value="MEX">Mexico</option>
				    <option value="MGD">Madagascar</option>
				    <option value="MHL">Marshall Islands</option>
				    <option value="MKD">Macedonia</option>
				    <option value="MLI">Mali</option>
				    <option value="MLT">Malta</option>
				    <option value="MMR">Burma</option>
				    <option value="MNE">Montenegro</option>
				    <option value="MNG">Mongolia</option>
				    <option value="MNP">Northern Mariana Islands</option>
				    <option value="MON">Monaco</option>
				    <option value="MOZ">Mozambique</option>
				    <option value="MRT">Mauritania</option>
				    <option value="MSR">Montserrat</option>
				    <option value="MTQ">Martinique</option>
				    <option value="MUS">Mauritius</option>
				    <option value="MWI">Malawi</option>
				    <option value="MYT">Mayotte</option>
				    <option value="N/A">Not Available</option>
				    <option value="NAM">Namibia</option>
				    <option value="NCL">New Caledonia</option>
				    <option value="NER">Niger</option>
				    <option value="NFK">Norfolk Island</option>
				    <option value="NGA">Nigeria</option>
				    <option value="NIC">Nicaragua</option>
				    <option value="NIU">Niue</option>
				    <option value="NLD">Netherlands</option>
				    <option value="NOR">Norway</option>
				    <option value="NPL">Nepal</option>
				    <option value="NRU">Nauru</option>
				    <option value="NZL">New Zealand</option>
				    <option value="OMN">Oman</option>
				    <option value="PAK">Pakistan</option>
				    <option value="PAN">Panama</option>
				    <option value="PAR">Paraguay</option>
				    <option value="PCN">Pitcairn Island</option>
				    <option value="PER">Peru</option>
				    <option value="PHI">Philippines</option>
				    <option value="PLW">Palau</option>
				    <option value="PNG">Papua New Guinea</option>
				    <option value="POL">Poland</option>
				    <option value="PRI">Puerto Rico</option>
				    <option value="PRK">People's Dem Rep of Korea</option>
				    <option value="PRT">Portugal</option>
				    <option value="PSE">West Bank and Gaza</option>
				    <option value="PYF">French Polynesia</option>
				    <option value="QAT">Qatar</option>
				    <option value="REU">Reunion</option>
				    <option value="ROM">Romania</option>
				    <option value="RSS">Russia/Saratov</option>
				    <option value="RUS">Russian Federation</option>
				    <option value="RWA">Rwanda</option>
				    <option value="SAB">Saudi Arabia</option>
				    <option value="SCG">Serbia</option>
				    <option value="SCO">Scotland</option>
				    <option value="SDN">Sudan</option>
				    <option value="SEN">Senegal</option>
				    <option value="SGP">Singapore</option>
				    <option value="SGS">South Georgia/Sandwich Islands</option>
				    <option value="SHN">St. Helena</option>
				    <option value="SJM">Svalbard and Jan Mayen Isl.</option>
				    <option value="SLB">Solomon Islands</option>
				    <option value="SLE">Sierra Leone</option>
				    <option value="SLV">El Salvador</option>
				    <option value="SMR">San Marino</option>
				    <option value="SOM">Somalia</option>
				    <option value="SPM">St. Pierre and Miquelon</option>
				    <option value="SPN">Spain</option>
				    <option value="SSD">South Sudan</option>
				    <option value="STP">Sao Tome and Principe</option>
				    <option value="SUR">Suriname</option>
				    <option value="SVK">Slovakia</option>
				    <option value="SVN">Slovenia</option>
				    <option value="SWE">Sweden</option>
				    <option value="SWI">Switzerland</option>
				    <option value="SWZ">Eswatini</option>
				    <option value="SXM">Sint Maarten</option>
				    <option value="SYC">Seychelles</option>
				    <option value="SYR">Syrian Arab Republic</option>
				    <option value="TCA">Turks and Caicos Islands</option>
				    <option value="TCD">Chad</option>
				    <option value="TGO">Togo</option>
				    <option value="THA">Thailand</option>
				    <option value="TJK">Tajikistan</option>
				    <option value="TKL">Tokelau</option>
				    <option value="TKM">Turkmenistan</option>
				    <option value="TLS">Timor-Leste</option>
				    <option value="TON">Tonga</option>
				    <option value="TTO">Trinidad and Tobago</option>
				    <option value="TUG">Yugoslavia</option>
				    <option value="TUN">Tunisia</option>
				    <option value="TUR">Turkey</option>
				    <option value="TUV">Tuvalu</option>
				    <option value="TWN">Taiwan</option>
				    <option value="TZA">United Republic of Tanzania</option>
				    <option value="UGA">Uganda</option>
				    <option value="UKR">Ukraine</option>
				    <option value="UMI">United States Minor Out. Is.</option>
				    <option value="URY">Uruguay</option>
				    <option value="UZB">Uzbekistan</option>
				    <option value="VAT">Holy See (Vatican City)</option>
				    <option value="VCT">St Vincent and The Grenadines</option>
				    <option value="VEN">Venezuela</option>
				    <option value="VGB">British Virgin Islands</option>
				    <option value="VIR">Virgin Islands (U.S.)</option>
				    <option value="VTN">Vietnam</option>
				    <option value="VUT">Vanuatu</option>
				    <option value="WEI">West Indies</option>
				    <option value="WLF">Wallis and Futuna Islands</option>
				    <option value="WSM">Samoa</option>
				    <option value="WWI">Windward Islands</option>
				    <option value="YEM">Yemen</option>
				    <option value="YUG">Serbia</option>
				    <option value="ZAF">South Africa</option>
				    <option value="ZMB">Zambia</option>
				    <option value="ZWE">Zimbabwe</option>
	        	</select>
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="email">Email:</label>
	          <input type="email" class="form-control" id="email" name="email" placeholder="Type here">
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="biography_keyword">Biography Keyword:</label>
	          <input type="text" class="form-control" id="biography_keyword" name="biography_keyword" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="twitter_contact">Twitter Contact:</label>
	          <input type="text" class="form-control" id="twitter_contact" placeholder="Type here">
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="records">Records per pag:</label>
	          <select class="form-control" id="records" name="records">
	            <option value="10">10</option>
	            <option value="20">20</option>
	            <option value="50">50</option>
	          </select>
	        </div>
	      </div>
	    </div>
	    <div class="row">
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="xiography">&nbsp;</label>
	          <span class="gwt-CheckBox">
	          <input value="on" name="partial_search" id="partial_search" tabindex="0" class="avi-fuel-stops-checkbox" type="checkbox">
	          <label for="partial_search" class="avi-fuel-stops-checkbox-label">Find partial matches <a href="#" class="add_tool" title="Automatically adds wildcard to end of search criteria. Mac will, match MacDonald, and MacArthur, but not Schumacher."><i class="fa fa-info-circle"></i></a></label>
	          </span>
	        </div>
	      </div>
	      <div class="col-sm-4">
	        <div class="form-group">
	          <label class="control-label" for="records">Find records that match:</label>
	          <span class="gwt-RadioButton avi-route-type-option">
	          <input name="relation" value="and" id="compare_and" tabindex="0" class="avi-route-type-radio" type="radio" checked="checked">
	          <label for="compare_and" class="avi-route-type-radio-label">All specified fields (AND)</label>
	          </span><span class="gwt-RadioButton avi-route-type-option">
	          <input name="relation" value="or" id="compare_or" tabindex="0" class="avi-route-type-radio" type="radio">
	          <label for="compare_or" class="avi-route-type-radio-label">At least one specified field (OR)</label>
	          </span> </div>
	      </div>
	    </div>
	    <div class="button_process">
	      <button id="search_specialist" type="submit" class="but_theme">Search</button>
	      <button type="reset" class="but_light">Clear Selection</button>
	    </div>
	    
	    <!-- Modal -->
	    <input type="hidden" name="action" value="search_ep_specialist"> 
	  </form>
	</div>
	<div class="dfr__body search_response" style="display: none;">
		<div class="row">
			<div class="col-sm-12">
				<div class="back_nav">
					<a href="javascript:show_ep_spec_form();"><i aria-hidden="true" class="fa fa-angle-left"></i> Back</a>
				</div>

				<!-- <div id="search_results">
				</div> -->
				<div id="result_table">
					<table id="ep-results" class="display" style="width:100%">
				        <thead>
				            <tr>
				                <th>Name</th>				               
				            </tr>
				        </thead>
				        <tbody>
			            </tbody>
			        </table>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();

}
add_shortcode( 'find_specialist_form', 'search_specialist_form_shortcode' );


add_action( 'wp_ajax_search_ep_specialist', 'fn_search_ep_specialist' );
add_action( 'wp_ajax_nopriv_search_ep_specialist', 'fn_search_ep_specialist' );

function fn_search_ep_specialist(){
	
	$member_subclass = $_POST['member_subclass'];
	$first_name = $_POST['first_name'];	
	$last_name = $_POST['last_name'];
	$company = $_POST['company'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$postal_code = $_POST['postal_code'];
	$country = $_POST['country'];
	$email = $_POST['email'];
	$biography_keyword = $_POST['biography_keyword'];
	$records = $_POST['records'];
	$relation = strtoupper( $_POST['relation'] );
	$compare_op = '=';
	$partial_search = $_POST['partial_search'];
	if(!empty($partial_search) && $partial_search == 'on'){
		$compare_op = 'LIKE';
	}

	$meta_query = array();

	if(!empty($member_subclass)){
		array_push($meta_query, array(
			'key'		=> 'member_subclass',
			'value'		=> $member_subclass,
			'compare'	=> '='
		));
	}

	if(!empty($first_name)){
		array_push($meta_query, array(
			'key'		=> 'first_name',
			'value'		=> $first_name,
			'compare'	=> $compare_op
		));
	}
	if(!empty($last_name)){
		array_push($meta_query, array(
			'key'		=> 'last_name',
			'value'		=> $last_name,
			'compare'	=> $compare_op
		));
	}
	if(!empty($company)){
		array_push($meta_query, array(
			'key'		=> 'company',
			'value'		=> $company,
			'compare'	=> $compare_op
		));
	}
	if(!empty($city)){
		array_push($meta_query, array(
			'key'		=> 'city',
			'value'		=> $city,
			'compare'	=> $compare_op
		));
	}
	if(!empty($state)){
		array_push($meta_query, array(
			'key'		=> 'state',
			'value'		=> $state,
			'compare'	=> '='
		));
	}
	
	if(!empty($postal_code)){
		array_push($meta_query, array(
			'key'		=> 'postal_code',
			'value'		=> $postal_code,
			'compare'	=> '='
		));
	}
	if(!empty($country)){
		array_push($meta_query, array(
			'key'		=> 'country',
			'value'		=> $country,
			'compare'	=> '='
		));
	}
	if(!empty($email)){
		array_push($meta_query, array(
			'key'		=> 'email',
			'value'		=> $email,
			'compare'	=> $compare_op
		));
	}
	if(!empty($biography_keyword)){
		array_push($meta_query, array(
			'key'		=> 'biography_keyword',
			'value'		=> $biography_keyword,
			'compare'	=> $compare_op
		));
	}
	$args = array();
	if(!empty($meta_query)){
		$meta_query['relation']	= $relation;

		$args = array(
			'posts_per_page'   => -1,
			'numberposts'	=> -1,
			'post_type'		=> 'ep-specialist',
			'post_status' 	=> 'publish',
			'meta_query'	=> $meta_query
		);
	}else{
		echo json_encode( array('type'=>'blankrequest') ); die;
		$args = array(
			'posts_per_page'   => -1,
			'numberposts'	=> -1,
			'post_type'		=> 'ep-specialist',
			'post_status' 	=> 'publish',
		);
	}
	

	$response = array('type'=>'fail');
	$get_post = new WP_Query( $args );

	if( $get_post->have_posts() ){
		$data = array();
		while ( $get_post->have_posts() ) : $get_post->the_post();
			$arr = array();
			$id = get_the_ID();
			$title = get_the_title();
			$url = get_permalink($id);
			$name = get_field( "display_name", $id );
			if(empty($name)){
				$name = get_field( "first_name", $id );
				$name .= ' '.get_field( "last_name", $id );
			}
			
			$arr['id'] = $id;
			$arr['title'] = $title;
			$arr['name'] = ucwords($name);
			$arr['url'] = $url;
			array_push($data, $arr);
		endwhile;
		$response['type'] = 'success';
		$response['data'] = $data;
		$response['query'] = $get_post->request;
		echo json_encode($response);
	}
	else{
		$response['type'] = 'fail';
		echo json_encode($response);
	}
		
	die;
}

/*
* Ajax to handle search specialist by country 
* search_ep_specialist_by_country
*/

add_action( 'wp_ajax_search_ep_specialist_by_country', 'fn_search_ep_specialist_by_country' );
add_action( 'wp_ajax_nopriv_search_ep_specialist_by_country', 'fn_search_ep_specialist_by_country' );

function fn_search_ep_specialist_by_country(){
	// $state = $_POST['state'];
	$country = $_POST['country'];
	$relation = strtoupper( $_POST['relation'] );
	$compare_op = '=';
	$partial_search = $_POST['partial_search'];
	// $compare_op = 'LIKE';
	
	$meta_query = array();

	
	/*if(!empty($state)){
		array_push($meta_query, array(
			'key'		=> 'state',
			'value'		=> $state,
			'compare'	=> '='
		));
	}*/
	
	if(!empty($country)){
		array_push($meta_query, array(
			'key'		=> 'country',
			'value'		=> $country,
			'compare'	=> '='
		));
	}
	
	$args = array();
	if(!empty($meta_query)){
		$meta_query['relation']	= $relation;

		$args = array(
			'numberposts'	=> -1,
			'post_type'		=> 'ep-specialist',
			'post_status' 	=> 'publish',
			'meta_query'	=> $meta_query
		);
	}else{
		echo json_encode( array('type'=>'blankrequest') ); die;
	}
	

	$response = array('type'=>'fail');
	$get_post = new WP_Query( $args );

	if( $get_post->have_posts() ){
		$data = array();
		while ( $get_post->have_posts() ) : $get_post->the_post();
			$arr = array();
			$id = get_the_ID();
			$title = get_the_title();
			$url = get_permalink($id);
			$name = get_field( "display_name", $id );
			if(empty($name)){
				$name = get_field( "first_name", $id );
				$name .= ' '.get_field( "last_name", $id );
			}
			
			$arr['id'] = $id;
			$arr['title'] = $title;
			$arr['name'] = ucwords($name);
			$arr['url'] = $url;
			array_push($data, $arr);
		endwhile;
		$response['type'] = 'success';
		$response['data'] = $data;
		$response['query'] = $get_post->request;
		echo json_encode($response);
	}
	else{
		$response['type'] = 'fail';
		echo json_encode($response);
	}
		
	die;
}

/*
* Ajax to handle search specialist by country 
* search_ep_specialist_by_country
*/

add_action( 'wp_ajax_search_ep_specialist_by_state', 'fn_search_ep_specialist_by_state' );
add_action( 'wp_ajax_nopriv_search_ep_specialist_by_state', 'fn_search_ep_specialist_by_state' );

function fn_search_ep_specialist_by_state(){
	$state = $_POST['state'];
	$relation = strtoupper( $_POST['relation'] );
	$compare_op = '=';
	$partial_search = $_POST['partial_search'];
	// $compare_op = 'LIKE';
	
	$meta_query = array();
	if(map_state_for_search_map($state)){
		$state = map_state_for_search_map($state);
	}else{
		$state = '';
	}
	
	if(!empty($state)){
		array_push($meta_query, array(
			'key'		=> 'state',
			'value'		=> $state,
			'compare'	=> '='
		));

		array_push($meta_query, array(
			'key'		=> 'country',
			'value'		=> 'US',
			'compare'	=> '='
		));
	}
	
	$args = array();
	if(!empty($meta_query)){
		$meta_query['relation']	= $relation;

		$args = array(
			'numberposts'	=> -1,
			'post_type'		=> 'ep-specialist',
			'post_status' 	=> 'publish',
			'meta_query'	=> $meta_query
		);
	}else{
		echo json_encode( array('type'=>'blankrequest') ); die;
	}
	

	$response = array('type'=>'fail');
	$get_post = new WP_Query( $args );

	if( $get_post->have_posts() ){
		$data = array();
		while ( $get_post->have_posts() ) : $get_post->the_post();
			$arr = array();
			$id = get_the_ID();
			$title = get_the_title();
			$url = get_permalink($id);
			$name = get_field( "display_name", $id );
			if(empty($name)){
				$name = get_field( "first_name", $id );
				$name .= ' '.get_field( "last_name", $id );
			}
			
			$address_1 = '';
			$address_2 = '';
			$phone = '';
			if(get_field('address_line_1')){
				$address_1 = get_field('address_line_1');
			}
			if(get_field('address_line_2')){
				$address_1 .= '<br>'.get_field('address_line_2').'<br>';
			}
			if(get_field('city')){
				$address_2 = get_field('city');
			}
			if(get_field('state')){
				$address_2 .= ', '.get_field('state');
			}
			if(get_field('postal_code')){
				$address_2 .= ', '.get_field('postal_code');
			}
			if(get_field('work_phone')){
				$phone = get_field('work_phone');	
			}

			$arr['id'] = $id;
			$arr['title'] = $title;
			$arr['name'] = ucwords($name);
			$arr['url'] = $url;
			$arr['address_1'] = $address_1;
			$arr['address_2'] = $address_2;
			$arr['phone'] = $phone;
			array_push($data, $arr);
		endwhile;
		$response['type'] = 'success';
		$response['data'] = $data;
		$response['query'] = $get_post->request;
		echo json_encode($response);
	}else{
		$response['type'] = 'fail';
		echo json_encode($response);
	}
		
	die;
}

add_filter( 'body_class', 'custom_body__class' );
function custom_body__class( $classes ) {
	$checkClasses = array('pmpro-body-level-required', 'pmpro-account', 'pmpro-billing', 'pmpro-cancel', 'pmpro-checkout', 'pmpro-invoice', 'pmpro-levels', 'pmpro-member-profile-edit', 'single-event', 'single-location', 'post-type-archive-location', 'post-type-archive-event', 'page-id-1028');

	$result = !empty(array_intersect($checkClasses, $classes));
	if($result){
		$classes[] = 'paces_design_fix';	
	}
    return $classes;
}


// Add Shortcode
add_shortcode( 'international_specialist_form', 'international_search_specialist_form_shortcode' );
function international_search_specialist_form_shortcode( $atts ) {

	ob_start();
	?>
	<div class="dfr__body ep_search_form_div">
		<form action="" method="post" name="search_international_specialist" id="search_international_specialist" class="dfr_form">
			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
						<label class="control-label" for="country">Country:</label>
						<select class="form-control" id="country" name="country">
							<option value="">Any</option>
							<option value="USA">United States of America</option>
				    <option value="CAN">Canada</option>
				    <option value="AFG">Afghanistan</option>
				    <option value="AGO">Angola</option>
				    <option value="AIA">Anguilla</option>
				    <option value="ALB">Albania</option>
				    <option value="AND">Andorra</option>
				    <option value="ARE">United Arab Emirates</option>
				    <option value="ARG">Argentina</option>
				    <option value="ARM">Armenia</option>
				    <option value="ARU">Aruba</option>
				    <option value="ASM">American Samoa</option>
				    <option value="ATA">Antarctica</option>
				    <option value="ATF">French Southern Territories</option>
				    <option value="ATG">Antigua and Barbuda</option>
				    <option value="AUS">Australia</option>
				    <option value="AUT">Austria</option>
				    <option value="AZE">Azerbaijan</option>
				    <option value="BAH">Bahamas</option>
				    <option value="BDI">Burundi</option>
				    <option value="BEL">Belgium</option>
				    <option value="BEN">Benin</option>
				    <option value="BFA">Burkina Faso</option>
				    <option value="BGD">Bangladesh</option>
				    <option value="BGR">Bulgaria</option>
				    <option value="BHR">Bahrain</option>
				    <option value="BIH">Bosnia and Herzegovina</option>
				    <option value="BLR">Belarus</option>
				    <option value="BLZ">Belize</option>
				    <option value="BMU">Bermuda</option>
				    <option value="BOL">Bolivia</option>
				    <option value="BRA">Brazil</option>
				    <option value="BRB">Barbados</option>
				    <option value="BRN">Brunei Darussalam</option>
				    <option value="BTN">Bhutan</option>
				    <option value="BWA">Botswana</option>
				    <option value="BWI">British West Indies</option>
				    <option value="CAF">Central African Republic</option>
				    <option value="CAY">Cayman Islands</option>
				    <option value="CCK">Cocos (Keeling) Islands</option>
				    <option value="CHA">Channel Islands</option>
				    <option value="CHL">Chile</option>
				    <option value="CHN">China</option>
				    <option value="CIV">Cote D'Ivoire</option>
				    <option value="CMR">Cameroon</option>
				    <option value="COD">Democratic Republic of Congo</option>
				    <option value="COG">Congo</option>
				    <option value="COK">Cook Islands</option>
				    <option value="COL">Colombia</option>
				    <option value="COM">Comoros</option>
				    <option value="CPV">Cape Verde</option>
				    <option value="CST">Costa Rica</option>
				    <option value="CUB">Cuba</option>
				    <option value="CUR">Curacao</option>
				    <option value="CXR">Christmas Island</option>
				    <option value="CYP">Cyprus</option>
				    <option value="CZE">Czech Republic</option>
				    <option value="DEN">Denmark</option>
				    <option value="DJI">Djibouti</option>
				    <option value="DNA">Dominica</option>
				    <option value="DOM">Dominican Republic</option>
				    <option value="DZA">Algeria</option>
				    <option value="ECB">Eastern Caribbean</option>
				    <option value="ECU">Ecuador</option>
				    <option value="EGY">Egypt</option>
				    <option value="ENG">England</option>
				    <option value="ERI">Eritrea</option>
				    <option value="ESH">Western Sahara</option>
				    <option value="EST">Estonia</option>
				    <option value="ETH">Ethiopia</option>
				    <option value="FIJ">Fiji</option>
				    <option value="FIN">Finland</option>
				    <option value="FLK">Falkland Islands (Malvinas)</option>
				    <option value="FRA">France</option>
				    <option value="FRO">Faroe Islands</option>
				    <option value="FSM">Micronesia, Federated States</option>
				    <option value="FXX">France, Metropolitan</option>
				    <option value="GAB">Gabon</option>
				    <option value="GBR">United Kingdom</option>
				    <option value="GEO">Georgia</option>
				    <option value="GER">Germany</option>
				    <option value="GHA">Ghana</option>
				    <option value="GIB">Gibraltar</option>
				    <option value="GIN">Guinea</option>
				    <option value="GLP">Guadeloupe</option>
				    <option value="GMB">Gambia</option>
				    <option value="GNB">Guinea-Bissau</option>
				    <option value="GNQ">Equatorial Guinea</option>
				    <option value="GRC">Greece</option>
				    <option value="GRD">Grenada</option>
				    <option value="GRL">Greenland</option>
				    <option value="GTM">Guatemala</option>
				    <option value="GUA">Guam</option>
				    <option value="GUF">French Guiana</option>
				    <option value="GUY">Guyana</option>
				    <option value="HKG">Hong Kong</option>
				    <option value="HMD">Heard and McDonald Islands</option>
				    <option value="HND">Honduras</option>
				    <option value="HRV">Croatia</option>
				    <option value="HTI">Haiti</option>
				    <option value="HUN">Hungary</option>
				    <option value="IDN">Indonesia</option>
				    <option value="IND">India</option>
				    <option value="IOT">British Indian Ocean Territory</option>
				    <option value="IRE">Ireland</option>
				    <option value="IRN">Iran (Islamic Republic of)</option>
				    <option value="IRQ">Iraq</option>
				    <option value="ISL">Iceland</option>
				    <option value="ISR">Israel</option>
				    <option value="ITA">Italy</option>
				    <option value="JAM">Jamaica</option>
				    <option value="JOR">Jordan</option>
				    <option value="JPN">Japan</option>
				    <option value="KAZ">Kazakhstan</option>
				    <option value="KEN">Kenya</option>
				    <option value="KGZ">Kyrgyzstan</option>
				    <option value="KHM">Cambodia</option>
				    <option value="KIR">Kiribati</option>
				    <option value="KNA">Saint Kitts and Nevis</option>
				    <option value="KOR">Republic of Korea</option>
				    <option value="KSV">Kosovo</option>
				    <option value="KWT">Kuwait</option>
				    <option value="LAO">Lao People's Democratic Rep</option>
				    <option value="LBN">Lebanon</option>
				    <option value="LBR">Liberia</option>
				    <option value="LBY">Libya</option>
				    <option value="LCA">Saint Lucia</option>
				    <option value="LIE">Liechtenstein</option>
				    <option value="LKA">Sri Lanka</option>
				    <option value="LSO">Lesotho</option>
				    <option value="LTU">Lithuania</option>
				    <option value="LUX">Luxembourg</option>
				    <option value="LVA">Latvia</option>
				    <option value="LWI">Leeward Islands</option>
				    <option value="MAC">Macau</option>
				    <option value="MAF">Saint Martin</option>
				    <option value="MAL">Malaysia</option>
				    <option value="MAR">Morocco</option>
				    <option value="MDA">Moldova, Republic of</option>
				    <option value="MDV">Maldives</option>
				    <option value="MEX">Mexico</option>
				    <option value="MGD">Madagascar</option>
				    <option value="MHL">Marshall Islands</option>
				    <option value="MKD">Macedonia</option>
				    <option value="MLI">Mali</option>
				    <option value="MLT">Malta</option>
				    <option value="MMR">Burma</option>
				    <option value="MNE">Montenegro</option>
				    <option value="MNG">Mongolia</option>
				    <option value="MNP">Northern Mariana Islands</option>
				    <option value="MON">Monaco</option>
				    <option value="MOZ">Mozambique</option>
				    <option value="MRT">Mauritania</option>
				    <option value="MSR">Montserrat</option>
				    <option value="MTQ">Martinique</option>
				    <option value="MUS">Mauritius</option>
				    <option value="MWI">Malawi</option>
				    <option value="MYT">Mayotte</option>
				    <option value="N/A">Not Available</option>
				    <option value="NAM">Namibia</option>
				    <option value="NCL">New Caledonia</option>
				    <option value="NER">Niger</option>
				    <option value="NFK">Norfolk Island</option>
				    <option value="NGA">Nigeria</option>
				    <option value="NIC">Nicaragua</option>
				    <option value="NIU">Niue</option>
				    <option value="NLD">Netherlands</option>
				    <option value="NOR">Norway</option>
				    <option value="NPL">Nepal</option>
				    <option value="NRU">Nauru</option>
				    <option value="NZL">New Zealand</option>
				    <option value="OMN">Oman</option>
				    <option value="PAK">Pakistan</option>
				    <option value="PAN">Panama</option>
				    <option value="PAR">Paraguay</option>
				    <option value="PCN">Pitcairn Island</option>
				    <option value="PER">Peru</option>
				    <option value="PHI">Philippines</option>
				    <option value="PLW">Palau</option>
				    <option value="PNG">Papua New Guinea</option>
				    <option value="POL">Poland</option>
				    <option value="PRI">Puerto Rico</option>
				    <option value="PRK">People's Dem Rep of Korea</option>
				    <option value="PRT">Portugal</option>
				    <option value="PSE">West Bank and Gaza</option>
				    <option value="PYF">French Polynesia</option>
				    <option value="QAT">Qatar</option>
				    <option value="REU">Reunion</option>
				    <option value="ROM">Romania</option>
				    <option value="RSS">Russia/Saratov</option>
				    <option value="RUS">Russian Federation</option>
				    <option value="RWA">Rwanda</option>
				    <option value="SAB">Saudi Arabia</option>
				    <option value="SCG">Serbia</option>
				    <option value="SCO">Scotland</option>
				    <option value="SDN">Sudan</option>
				    <option value="SEN">Senegal</option>
				    <option value="SGP">Singapore</option>
				    <option value="SGS">South Georgia/Sandwich Islands</option>
				    <option value="SHN">St. Helena</option>
				    <option value="SJM">Svalbard and Jan Mayen Isl.</option>
				    <option value="SLB">Solomon Islands</option>
				    <option value="SLE">Sierra Leone</option>
				    <option value="SLV">El Salvador</option>
				    <option value="SMR">San Marino</option>
				    <option value="SOM">Somalia</option>
				    <option value="SPM">St. Pierre and Miquelon</option>
				    <option value="SPN">Spain</option>
				    <option value="SSD">South Sudan</option>
				    <option value="STP">Sao Tome and Principe</option>
				    <option value="SUR">Suriname</option>
				    <option value="SVK">Slovakia</option>
				    <option value="SVN">Slovenia</option>
				    <option value="SWE">Sweden</option>
				    <option value="SWI">Switzerland</option>
				    <option value="SWZ">Eswatini</option>
				    <option value="SXM">Sint Maarten</option>
				    <option value="SYC">Seychelles</option>
				    <option value="SYR">Syrian Arab Republic</option>
				    <option value="TCA">Turks and Caicos Islands</option>
				    <option value="TCD">Chad</option>
				    <option value="TGO">Togo</option>
				    <option value="THA">Thailand</option>
				    <option value="TJK">Tajikistan</option>
				    <option value="TKL">Tokelau</option>
				    <option value="TKM">Turkmenistan</option>
				    <option value="TLS">Timor-Leste</option>
				    <option value="TON">Tonga</option>
				    <option value="TTO">Trinidad and Tobago</option>
				    <option value="TUG">Yugoslavia</option>
				    <option value="TUN">Tunisia</option>
				    <option value="TUR">Turkey</option>
				    <option value="TUV">Tuvalu</option>
				    <option value="TWN">Taiwan</option>
				    <option value="TZA">United Republic of Tanzania</option>
				    <option value="UGA">Uganda</option>
				    <option value="UKR">Ukraine</option>
				    <option value="UMI">United States Minor Out. Is.</option>
				    <option value="URY">Uruguay</option>
				    <option value="UZB">Uzbekistan</option>
				    <option value="VAT">Holy See (Vatican City)</option>
				    <option value="VCT">St Vincent and The Grenadines</option>
				    <option value="VEN">Venezuela</option>
				    <option value="VGB">British Virgin Islands</option>
				    <option value="VIR">Virgin Islands (U.S.)</option>
				    <option value="VTN">Vietnam</option>
				    <option value="VUT">Vanuatu</option>
				    <option value="WEI">West Indies</option>
				    <option value="WLF">Wallis and Futuna Islands</option>
				    <option value="WSM">Samoa</option>
				    <option value="WWI">Windward Islands</option>
				    <option value="YEM">Yemen</option>
				    <option value="YUG">Serbia</option>
				    <option value="ZAF">South Africa</option>
				    <option value="ZMB">Zambia</option>
				    <option value="ZWE">Zimbabwe</option>
						</select>
					</div>
				</div>
				<div class="button_process-int col-sm-4">
                <label class="control-label" for="country">&nbsp;</label>
			    	<button id="search_specialist_inter" type="submit" class="but_theme">Search International</button>
			    	<input type="hidden" name="action" value="search_ep_specialist_by_country">
			    </div>
			    <div id="search_results" class="col-sm-12"></div>
			</div>
		</form>
	</div>
	<!-- Modal -->
	<div class="modal fade map-country-results" id="search_by_country" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="resultModalLabel">Directory</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<?php 
	return ob_get_clean();
}

function map_state_for_search_map($id){
	$state_list = array('AL'=>"us_1",  
		'AK'=>"us_2",  
		'AZ'=>"us_3",  
		'AR'=>"us_4",  
		'CA'=>"us_5",  
		'CO'=>"us_6",  
		'CT'=>"us_7",  
		'DE'=>"us_8",  
		'FL'=>"us_9",  
		'GA'=>"us_10",  
		'HI'=>"us_11",  
		'ID'=>"us_12",  
		'IL'=>"us_13",  
		'IN'=>"us_14",  
		'IA'=>"us_15",  
		'KS'=>"us_16",  
		'KY'=>"us_17",  
		'LA'=>"us_18",  
		'ME'=>"us_19",  
		'MD'=>"us_20",  
		'MA'=>"us_21",  
		'MI'=>"us_22",  
		'MN'=>"us_23",  
		'MS'=>"us_24",  
		'MO'=>"us_25",  
		'MT'=>"us_26",
		'NE'=>"us_27",
		'NV'=>"us_28",
		'NH'=>"us_29",
		'NJ'=>"us_30",
		'NM'=>"us_31",
		'NY'=>"us_32",
		'NC'=>"us_33",
		'ND'=>"us_34",
		'OH'=>"us_35",  
		'OK'=>"us_36",  
		'OR'=>"us_37",  
		'PA'=>"us_38",  
		'RI'=>"us_39",  
		'SC'=>"us_40",  
		'SD'=>"us_41",
		'TN'=>"us_42",  
		'TX'=>"us_43",  
		'UT'=>"us_44",  
		'VT'=>"us_45",  
		'VA'=>"us_46",  
		'WA'=>"us_47",  
		'WV'=>"us_48",  
		'WI'=>"us_49",  
		'WY'=>"us_50"
	);
	return array_search($id, $state_list);
}
