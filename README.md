Credins Bank Payment Module for osCommerce 2.3

============================================================

</strong>General Notes</strong>

Credins Bank Payment Module is developed by Endri Prifti.<br />
This document with instructions is written by Endri Prifti.<br />
Contact: endri@msn.com

============================================================

<strong>Disclaimer of Warranty</strong>

THERE IS NO WARRANTY FOR THIS SOURCE CODE, MODULE, OR ADD-ON, TO THE EXTENT PERMITTED BY
APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT
HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY
OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,
THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM
IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
ALL NECESSARY SERVICING, REPAIR OR CORRECTION.

============================================================

<strong>Limitation of Liability</strong>

IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS
THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY
GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE
USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF
DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD
PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),
EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF
SUCH DAMAGES.

============================================================

First, make sure:<br>
• Install a CLEAN copy of osCommerce 2.x, (Version 2.3 recommended)<br>
• Delete other currencies.<br>
• You should use only one currency: Albanian Lek.<br>
Create, if it isn't, the Albanian currency, ALL (Lek), and delete all other currencies.<br>
Currently Credins Bank accepts only Visa Cards attached to accounts in Albanian Lek.<br>
• Update the links on FirstData ECOMM panel.<br>
For returnOkUrl use, for example: http://localhost:9999/catalog/ext/modules/payment/credinz/credinz_callback.php<br>
For returnFailUrl use, for example: http://localhost:9999/catalog/ext/modules/payment/credinz/credinz_callback_fail.php<br>
• Copy the certificate file to <installation_folder>\ext\modules\payment\credinz\<certificate_name>.pem

============================================================

Notes:<br>
• Every end of day (at 23:59, but not necessary), the operator (administrator) of osCommerce 2.x should perform the Bussiness Day Closing in order to receive the money in his account at Credins Bank.

============================================================

Copy the content of the "Credinz" folder to "catalog" folder of osCommerce installation.

============================================================

Modify the following files:
<br>
1. ..\catalog\admin\orders.php<br>
around line 70<br>
find <pre>"case 'deleteconfirm':"</pre><br>
substitute all the case with this:<br>
<pre>
      case 'deleteconfirm':
    	require_once(DIR_FS_CATALOG . 'ext/modules/payment/credinz/Merchant.php');

        $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

		$result = tep_db_query("SELECT trans_id, amount FROM credinz_transaction WHERE credinz_order_id=" . $oID . " AND result='OK'");

		if(tep_db_num_rows($result) >= 1) {
			$result		= tep_db_fetch_array($result);

			$trans_id	= urlencode($result['trans_id']);
			$amount		= $result['amount'] * 100;

			$merchant	= new Merchant(	MODULE_PAYMENT_CREDINZ_URL_SERVER_HANDLER, 
										MODULE_PAYMENT_CREDINZ_KEYSTORE,
										MODULE_PAYMENT_CREDINZ_PASSPHRASE,
										1);
			$resp		= $merchant->reverse($trans_id, $amount);

			if(substr($resp,8,2) == "OK" OR substr($resp,8,8) == "REVERSED") {
				tep_remove_order($oID, $HTTP_POST_VARS['restock']);

				$result_token = explode(' ', $resp);

				tep_db_query("UPDATE credinz_transaction SET reversal_amount='" . ($amount/100) . "', response='" . addslashes($resp) . "', result_code='" . $result_token[2] . "', result='REVERSED' WHERE trans_id='" . urldecode($trans_id) . "'");
				
				$messageStack->add_session(SUCCESS_ORDER_DELETED_AMOUNT_REVERSED, 'success');
			}
			else $messageStack->add_session(ERROR_ORDER_CANT_BE_DELETED_AMOUNT_CANT_BE_REVERSED, 'error');
		}
		else tep_remove_order($oID, $HTTP_POST_VARS['restock']);

		tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action'))));
        break;
</pre>
-----------------------------------------------------------

2. ..\catalog\admin\includes\languages\english.php<br>
	around line 85, add: <pre>define('BOX_CUSTOMERS_BUSINESS_DAY_CLOSING', 'Business Day Closing');</pre><br>
	around line 197, add: <pre>define('IMAGE_CLOSE_DAY', 'Close Day');</pre>

-----------------------------------------------------------

3. ..\catalog\admin\includes\filenames.php
	around line 19, add: define('FILENAME_BUSINESS_DAY_CLOSING', 'business_day_closing.php');

-----------------------------------------------------------

4. ..\catalog\admin\includes\languages\english\orders.php
around line 80, add:
	define('ERROR_ORDER_CANT_BE_DELETED_AMOUNT_CANT_BE_REVERSED', 'Error: Can NOT delete order because payment can NOT be reverted.');
	define('SUCCESS_ORDER_DELETED_AMOUNT_REVERSED', 'Success: Order has been successfully deleted and payment reverted.');

-----------------------------------------------------------

5. ..\catalog\admin\includes\boxes\customers.php
around line 25, add:
      ,array(
        'code' => FILENAME_BUSINESS_DAY_CLOSING,
        'title' => BOX_CUSTOMERS_BUSINESS_DAY_CLOSING,
        'link' => tep_href_link(FILENAME_BUSINESS_DAY_CLOSING)
      )


============================================================


Enter osCommerce Administrator's Panel, go to Modules > Payment.
Install, if it isn't already installed.
Enable Credins Bank Payment Module, if it isn't already.
Edit Credins Bank Payment Module, and put the required information.

Put the path where Keystore is located, (just use single slashes, as in the example)
e.g.: C:/xampp/htdocs/eshop/ext/modules/payment/credinz/keystore.pem

Put the keystore Passphrase.

For the test environment:
Put on Handler Server URL: https://secureshop-test.firstdata.lv:8443/ecomm/MerchantHandler
Put on Handler Client URL: https://secureshop-test.firstdata.lv/ecomm/ClientHandler

For the production environment:
Put on Handler Server URL: https://secureshop.firstdata.lv:8443/ecomm/MerchantHandler
Put on Handler Client URL: https://secureshop.firstdata.lv/ecomm/ClientHandler

For the other fields, don't change anything.
