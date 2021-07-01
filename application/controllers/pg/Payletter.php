<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Allat class
 *
 * Copyright (c)
 *
 * @author
 */
class Payletter extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Cmall_order');

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'email'));
    }

    public function approval()
    {
        $this->load->model(array('Cmall_order_model'));
        //-----------------------------------------------------------------------------------------------------------------
        // Description    : Get payment results returned by Notify URL
        //                - If the payment is successful, the payment result is returned to the Notify URL.
        //                - It receives the result value through the received Notify URL and performs logic
        //                - such as charging and purchasing suitable for the affiliated store.
        //-----------------------------------------------------------------------------------------------------------------
        if(empty($_POST))
        {
            echo "<RESULT>FAIL</RESULT>";
            return;
        }


        //-----------------------------------------------------------------------------------------------------------------------
        // Description    : Setting payment result information
        //                - The customer can save the following payment information in the DB.
        //                - leave a file log of the following information for debugging.
        //                - To prevent forgery/modification of the parameters passed to Return URL / Notify URL,
        //                - create a SHA256 hash value and then perform comparison verification with the passed hash.
        //                - If successful after processing is completed in the Notify URL, please print <RESULT>OK</RESULT>.
        //-----------------------------------------------------------------------------------------------------------------------
        $strStoreID      = $_POST['storeid'];           //--Store ID
        $strCountryCode  = $_POST['countrycode'];       //--Country Code
        $strCurrency     = $_POST['currency'];          //--Currency Code
        $strStoreOrderNo = $_POST['storeorderno'];      //--Store Order Number
        $strPayAmt       = $_POST['payamt'];            //--Payment request amount

        $strPayerId      = $_POST['payerid'];           //--Payer ID
        $strPayerEmail   = $_POST['payeremail'];        //--Payer E-Mail
        $strServiceName  = $_POST['servicename'];       //--Product Information
        $strCustom       = $_POST['custom'];            //--Additional Information
        $strPayInfo      = $_POST['payinfo'];           //--Payment Information

        $strPgInfo       = $_POST['pginfo'];            //--PG Information paid
        $strTimeStamp    = $_POST['timestamp'];         //--Unix Time Stamp
        $strHash         = $_POST['hash'];              //--SHA256 DATA for comparative verification to prevent parameter forgery/modulation
        $strNotifyType   = $_POST['notifytype'];        //--Notification Type
        $strPayToken     = $_POST['paytoken'];          //--Payletter's unique payment number

        $strTranTime     = $_POST['trantime'];          //--Payment time (yyyy-mm-dd hh:mm:ss)
        $strPOQToken     = $_POST['poqtoken'];          //--Token value used for recurring payment of Payletter
        $strCardKind     = $_POST['cardkind'];          //--Card Kind
        $strCardNo       = $_POST['cardno'];            //--Card no In the case of (pginfo: PLCreditCard), mask processing excluding the last 4 digits of delivery
        $strRetCode      = $_POST['retcode'];           //--Result code (0 = payment success 0 <> payment failure)

        $strRetMsg       = $_POST['retmsg'];            //--Result message

        $params = [
            'storeid' => $strStoreID,
            'countrycode' => $strCountryCode,
            'currency' => $strCurrency,
            'storeorderno' => $strStoreOrderNo,
            'payamt' => $strPayAmt,
            'payerid' => $strPayerId,
            'payeremail' => $strPayerEmail,
            'servicename' => $strServiceName,
            'custom' => $strCustom,
            'payinfo' => $strPayInfo,
            'pginfo' => $strPgInfo,
            'timestamp' => $strTimeStamp,
            'hash' => $strHash,
            'notifytype' => $strNotifyType,
            'paytoken' => $strPayToken,
            'trantime' => $strTranTime,
            'poqtoken' => $strPOQToken,
            'cardkind' => $strCardKind,
            'cardno' => $strCardNo,
            'retcode' => $strRetCode,
            'retmsg' => $strRetMsg,
        ];
        $this->Cmall_order_model->allat_log_insert($params);

        //-----------------------------------------------------------------------------------------------------------------
        //1. Check retcode
        //-----------------------------------------------------------------------------------------------------------------
        if($strRetCode != "0")
        {
            echo "<RESULT>FAIL</RESULT>";
            return;
        }


        //-----------------------------------------------------------------------------------------------------------------
        //2. hash value validation
        //   To prevent forgery/modulation of parameters, create SHA256 hash value and compare and verify the received hash value.
        //   hash = GetSHA256(storeid + currency + storeorderno + payamt + payerid + timestamp + hashkey)
        //-----------------------------------------------------------------------------------------------------------------
        $strVerifyHash = hash("sha256", $strStoreID. $strCurrency. $strStoreOrderNo. $strPayAmt. $strPayerId. $strTimeStamp. "PL_Merchant");

        if($strHash != $strVerifyHash)
        {
            echo "<RESULT>FAIL</RESULT>";
            return;
        }


        //-----------------------------------------------------------------------------------------------------------------
        //3. Logic implementation according to NotifyType
        //-----------------------------------------------------------------------------------------------------------------
        if ($strNotifyType == "1")
        {
            //--Success/Purchasing processing progress
        }
        elseif ($strNotifyType == "2")
        {
            //--Refund/Cancellation processing in progress
        }
        else
        {
            //--Refer to the guide document NotifyType
        }

//        $params = [
//            'storeid' => $strStoreID,
//            'countrycode' => $strCountryCode,
//            'currency' => $strCurrency,
//            'storeorderno' => $strStoreOrderNo,
//            'payamt' => $strPayAmt,
//            'payerid' => $strPayerId,
//            'payeremail' => $strPayerEmail,
//            'servicename' => $strServiceName,
//            'custom' => $strCustom,
//            'payinfo' => $strPayInfo,
//            'pginfo' => $strPgInfo,
//            'timestamp' => $strTimeStamp,
//            'hash' => $strHash,
//            'notifytype' => $strNotifyType,
//            'paytoken' => $strPayToken,
//            'trantime' => $strTranTime,
//            'poqtoken' => $strPOQToken,
//            'cardkind' => $strCardKind,
//            'cardno' => $strCardNo,
//            'retcode' => $strRetCode,
//            'retmsg' => $strRetMsg,
//        ];
//        $this->Cmall_order_model->allat_log_insert($params);

        //--If successful, make sure that html and other code other than <RESULT>OK</RESULT> are not exposed on the page.
        //--If it is not <RESULT>OK</RESULT>, the notification is considered to have failed, and notifications are resent every 5 minutes, up to 10 times.
        echo "<RESULT>OK</RESULT>";
    }

    public function return()
    {
        $this->load->view('pg/payletter/return');
    }

    public function payment()
    {
        header("Content-type: text/html; charset=utf-8");

        //--------------------------------------------------------------------------------------------
        // Description    : Payment Request API URL
        //                - TEST URL : https://dev-api.payletter.com/api/payment/request
        //                - PRODUCTION URL : https://api.payletter.com/api/payment/request
        //--------------------------------------------------------------------------------------------
//        $strReqUrl = 'https://dev-api.payletter.com/api/payment/request'; // TEST
        $strReqUrl = 'https://api.payletter.com/api/payment/request'; // PRODUCTION


        //--------------------------------------------------------------------------------------------
        // 1. Set payment request parameters (key1=value1&key2=value2)
        //    -When the store contract is completed, the store ID and HashKey are issued.
        //    -Integration test is possible with HashKey pre-configured in the test environment before signing up.
        //    -Please refer to the guide document for parameters to be set when requesting payment with a PG other than PLCreditCard.
        //    -StoreID : PL_Merchant
        //    -HashKey : PL_Merchant
        //
        //    ※ Only PLCreditcard (non-authenticated) and PayPalExpressCheckout are accepted for test payment.
        //    - $pginfo : PLCreditCard (비인증 거래 / Amex)
        //                PLCreditCardMpi (인증 거래 / Visa / Master / JCB)
        //                ICBAlipay (알리 페이)
        //                WeChatPayQRCodePayment (위챗 페이)
        //--------------------------------------------------------------------------------------------
        $currency = $_POST["currency"] ?? '';

//        $strStoreID = "PL_Merchant"; // TEST
//        $hashKey = 'PL_Merchant'; // TEST
        if ($currency === 'JPY') {
            $strStoreID = 'beatsomeoneJP'; // PRODUCTION - JPY
            $hashKey = 'beatsomeoneJP_210601'; // PRODUCTION - JPY
        } else {
            $strStoreID = 'beatsomeone'; // PRODUCTION - USD
            $hashKey = 'beatsomeone_210601'; // PRODUCTION - USD
        }

        $storeOrderNo = $_POST["order_no"] ?? '';
        $amount = $_POST["amt"] ?? '';
        $payerid = $_POST["pmember_id"] ?? '';
        $payeremail = $_POST["recp_addr"] ?? '';
        $pginfo = $_POST["pg_info"] ?? '';
        $returnUrl = base_url() . 'pg/payletter/return';
        $notiUrl = base_url() . 'pg/payletter/approval';

        $strRequestContent = "storeid=" . $strStoreID .         //--Store ID
            "&currency=" . $currency .                          //--Currency Code
            "&storeorderno=" . $storeOrderNo .                  //--Store Order Number
            "&amount=" . $amount .                              //--Amount
            "&payerid=" . $payerid .                            //--Payer ID
            "&payeremail=" . $payeremail .                      //--Payer Email
            "&returnurl=" . $returnUrl .                        //--URL to return after payment processing
            "&notiurl=" . $notiUrl .                            //--URL to receive payment success result
            "&pginfo=" . $pginfo;                               //--Payment Request PG Information

        //----------------------------------------------------------------------------------------------------------------------------
        // 2. Nonce value setting
        //----------------------------------------------------------------------------------------------------------------------------
        $strNonce = $this->getGUID();


        //----------------------------------------------------------------------------------------------------------------------------
        // 3. Create TimeStamp for setting hash parameter (based on UTC)
        //----------------------------------------------------------------------------------------------------------------------------
        $strUnixTimeStamp = time();


        //----------------------------------------------------------------------------------------------------------------------------
        // 4. Generate Signature Value
        //   {StoreId}{HashKey}{Method}{URI}{TimeStamp}{Nonce}{Request-Content}
        //----------------------------------------------------------------------------------------------------------------------------
        $strEncodeUrl = strtolower(urlencode($strReqUrl));

        $strRequestString = $strStoreID . $hashKey . "POST" . $strEncodeUrl . $strUnixTimeStamp . $strNonce . $strRequestContent;

        $strSignature = hash("sha256", $strRequestString);


        //----------------------------------------------------------------------------------------------------------------------------
        // 5. Authorization processing
        //    POQAPI {Storeid}:{Signature}:{Nonce}:{TimeStamp}
        //----------------------------------------------------------------------------------------------------------------------------
        $strAuth = "POQAPI " . $strStoreID . ":" . $strSignature . ":" . $strNonce . ":" . $strUnixTimeStamp;


        //----------------------------------------------------------------------------------------------------------------------------
        // 6. Payment Request
        //----------------------------------------------------------------------------------------------------------------------------
        $arrHeaderData = [];
        $arrHeaderData[] = 'Content-Type: application/x-www-form-urlencoded';
        $arrHeaderData[] = "Authorization: " . $strAuth;

        $objCurl = curl_init();
        curl_setopt($objCurl, CURLOPT_URL, $strReqUrl);
        curl_setopt($objCurl, CURLOPT_HTTPHEADER, $arrHeaderData);
        curl_setopt($objCurl, CURLOPT_POST, 1);
        curl_setopt($objCurl, CURLOPT_POSTFIELDS, $strRequestContent);
        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);


        //-----------------------------------------------------------------------------------------
        // 7. Whether the API request was successful/failed (error code)
        //    Request processing succeeds only when HTTP StatusCode 200 OK. If not, refer to the StatusCode below.
        //  - 400 : [997] The request is invalid (Request parameter error)
        //  - 401 : [998] Authentication token is missing or incorrect. (Authentication error)
        //  - 403 : [993] Yon do not have authorization. (Authentication error)
        //  - 404 : [996] Cannot find resource. Please check resource. (The requested resource does not exist)
        //  - 405 : [995] Requested method is not allowed.  (Method error such as POST/GET)
        //  - 500 : [999] Internal server error (System internal error)
        //  - 501 : [994] Related function is not implemented (Occurs when an unimplemented API is called)
        //-----------------------------------------------------------------------------------------
        $strResponse = curl_exec($objCurl);

        $objJsonData = json_decode(urldecode($strResponse));

//        // In case of successful request processing
//        // Response Parameters (In case of successful) : token, online_url, mobile_url
//        if (curl_getinfo($objCurl, CURLINFO_HTTP_CODE) == 200) {
//            echo $objJsonData->token . PHP_EOL;           //--Payment authentication token
//            echo $objJsonData->online_url . PHP_EOL;      //--Payment page call URL (PC environment)
//            echo $objJsonData->mobile_url . PHP_EOL;      //--Payment page call URL (Mobile environment)
//        }
//        // If not success
//        // Response Parameters (In case of failure) : code, message
//        else {
//            echo $strResponse;
//        }

        curl_close($objCurl);

        $this->output->set_content_type('text/json');
        $this->output->set_output($strResponse);
    }

    private function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = chr(123)
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
            return $uuid;
        }
    }
}