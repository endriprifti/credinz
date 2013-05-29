<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License


  Credins Bank Payment Module for osCommerce 2.3
  Developed by Endri Prifti, March 2013
*/

  define('MODULE_PAYMENT_CREDINZ_TEXT_TITLE',  	'Credins Bank eCommerce');
  define('MODULE_PAYMENT_CREDINZ_TEXT_DESCRIPTION',	'<img src="images/icon_popup.gif" border="0"> Visit <a href="http://www.bankacredins.com/"><strong>Credins Bank</strong></a> online<br />Credins Bank Payment Module for osCommerce 2.3.<br />You can sell and purchase in Albanian native currency, the Lek.<br />We accept Visa Cards.');
  define('MODULE_PAYMENT_CREDINZ_TEXT_PUBLIC_HTML',	'<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG8AAAASCAIAAADaGxcoAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6N0MwOUREMEI5RENGMTFFMkJCOUVCOEFFRTQ1OUI5NzkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6N0MwOUREMEM5RENGMTFFMkJCOUVCOEFFRTQ1OUI5NzkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3QzA5REQwOTlEQ0YxMUUyQkI5RUI4QUVFNDU5Qjk3OSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo3QzA5REQwQTlEQ0YxMUUyQkI5RUI4QUVFNDU5Qjk3OSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PnwBHdoAAAnjSURBVHja7JhvTFXn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" border="0"><br /><br /><strong>Credins Bank</strong> You should use a Visa Card in order to make a purchase.');
  define('MODULE_PAYMENT_CREDINZ_SORT_ORDER',					0);
  define('MODULE_PAYMENT_CREDINZ_STATUS',						'True');
  define('MODULE_PAYMENT_CREDINZ_ERROR_HEADING',				'Credins Bank - Error');
  define('MODULE_PAYMENT_CREDINZ_ERROR_MESSAGE',				'There has been an error processing this transaction.<br/>Please check your credit card details!');
  define('MODULE_PAYMENT_CREDINZ_ERROR_CALLBACK_FAIL',			'An error occured by processing the transaction.');
  define('MODULE_PAYMENT_CREDINZ_ERROR_TRANS_NOT_SUCCEEDED',	'The transaction did not succeeded.');
  define('MODULE_PAYMENT_CREDINZ_HACK_ATTEMPTED',				'Hack attempted. Transaction did not succeeded.');
  define('MODULE_PAYMENT_CREDINZ_NO_TRANS_ID',					'No transaction id given.');
  define('MODULE_PAYMENT_CREDINZ_NO_PAYMENT',					'Hack attempted. No payment was made.');
?>
