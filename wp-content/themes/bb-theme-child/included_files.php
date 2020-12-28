<?php

// Search EP Sepcialist functions
require_once 'app/ep-specialist/search-specialist.php';

// include file to add EP Specialist in CPT when user registred via join.
require_once 'app/ep-specialist/add_specialist_on_registration.php';

// include file to add extra features in Paid Membership Pro plugin.
require_once 'app/paid-member/add-column.php';

// include file to add Update and add Card to user.
require_once 'app/paid-member/pmpro-card_update.php';

// include file to send mail to pmpro users.
require_once 'app/paid-member/pmpro_mail.php';

// this file to add and update cusotm data in pmpro plugin's default edit profile (your-profile) page.
require_once 'app/paid-member/edit-profile-custom.php';

// include file to update custom form data for pmpro edit profile page custom form
require_once 'app/paid-member/update-profile-custom.php';

// this file have action filter to update membership levels for approval process
require_once 'app/paid-member/update_level_after_checkout.php';

// include file to add common function like text change add class etc.
require_once 'app/common/common-functions.php';

// include file for custom signup registration form and approve functionality for members
require_once 'app/signup/signup.php';

// include file to send email when user get approved by admin
require_once 'app/signup/approve_mail.php';

// include file to add edit extra profile fields in admin's user section + add new admin user menu page
require_once 'app/admin/edit-profile-extra.php';

// include file to Save extra fields of user's profile.
require_once 'app/admin/save-profile-extra.php';

// include file to add users in Mail Poet List
require_once 'app/mailPoet/list-function.php';

// include file to Integrate contact form 7 with mail poet. Add user in mailPoet newsletters subscribers list on form submit
require_once 'app/mailPoet/wpcf7_integration.php';


// include file to create order and assign membership on user imports. also have other functions.
require_once 'app/paid-member/pmpro_custom_functions.php';

// include file to Import users form csv.
require_once 'app/admin/upload-users-functions.php';

// include file to add common function to apply custom mail templates.
require_once 'app/common/default-email-filters.php';