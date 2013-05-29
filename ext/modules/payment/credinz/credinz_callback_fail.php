<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License


  Credins Bank Payment Module for osCommerce 2.3
  Developed by Endri Prifti, March 2013
*/

  require('Merchant.php');
	chdir('../../../../');
    require('includes/application_top.php');
	include(DIR_WS_LANGUAGES . $language . '/modules/payment/credinz.php');

	$merchant	= new Merchant(	MODULE_PAYMENT_CREDINZ_URL_SERVER_HANDLER,
								MODULE_PAYMENT_CREDINZ_KEYSTORE,
								MODULE_PAYMENT_CREDINZ_PASSPHRASE,
								1);

	$resp		= $merchant -> getTransResult(urlencode($REQUEST['trans_id']), $REQUEST['ip']);

	tep_db_query("INSERT INTO credinz_error VALUES (NULL, now(), 'ReturnFailURL', 'error:" . $REQUEST['error'] . ";response:" . $resp. "')");

	tep_redirect(
				tep_href_link(
								FILENAME_CHECKOUT_PAYMENT, 
								'payment_error=credinz&error=' . urlencode(MODULE_PAYMENT_CREDINZ_ERROR_CALLBACK_FAIL), 
								'SSL'
				)
	);

?>
