<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Allat class
 *
 * Copyright (c)
 *
 * @author
 */
class Payco extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Cmall_order');

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');

    private $payInfo = [];

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'email'));
        $this->init();
    }

    public function init()
    {
        //----------------------------------------------------------------------------------------------------------------------
        // 캐릭터셋 지정
        //-----------------------------------------------------------------------------------------------------------------------
        // header("charset=utf8");

        //-----------------------------------------------------------------------------------------------------------------------
        //
        // 환경변수 선언
        //
        //------------------------------------------------------------------------------------------------------------------------
        // 가맹점 코드 선언 ( 가맹점 수정 부분 )
        //------------------------------------------------------------------------------------------------------------------------

        $this->payInfo['sellerKey'] = "V4MTUT";                                    //(필수) 가맹점 코드 - 파트너센터에서 알려주는 값으로, 초기 연동 시 PAYCO에서 쇼핑몰에 값을 전달한다.
        $this->payInfo['cpId'] = "V4MTUT";                                    //(필수) 상점ID, 30자 이내
        $this->payInfo['productId'] = "V4MTUT_EASYP";                                    //(필수) 상품ID, 50자 이내
        $this->payInfo['deliveryId'] = "DELIVERY_PROD";                                    //(필수) 배송비상품ID, 50자 이내
        $this->payInfo['deliveryReferenceKey'] = "DV0001";                                    //(필수) 가맹점에서 관리하는 배송비상품 연동 키, 100자 이내, 고정

        //-------------------------------------------------------------------------------------------------------------------------
        // 가맹점 API 가 호출 당할 경우 도메인 또는 아이피 셋팅하기 위한 변수 ( 도메인이 있을 경우 도메인을 셋팅하시면 됩니다. )
        // 용도 : serviceUrl 및 returnUrl, nonBankbookDepositInformUrl 용.
        // API 호출시 http:// 부터 경로를 전체적으로 써줘야 HttpRequest 통신시 오류발생 안함.
        //--------------------------------------------------------------------------------------------------------------------------

        //	$AppWebPath = "http://xxx.xxx.xxx.xxx/php/easypay/pay2/";
        $this->payInfo['AppWebPath'] = "https://beatsomeone.com/pg/payco/";
//        $this->payInfo['AppWebPath'] = "https://mvp.beatsomeone.com/pg/payco/";

        //--------------------------------------------------------------------------------------------------------------------------
        // 운영/개발 설정
        // Log 사용 여부 설정
        //---------------------------------------------------------------------------------------------------------------------------
        $this->payInfo['appMode'] = "REAL";        // REAL - 실서버 운영, TEST - 개발(테스트)
        $this->payInfo['LogUse'] = false;            // Log 사용 여부 ( True = 사용, False = 미사용 )

        //---------------------------------------------------------------------------------------------------------------------------
        // API 주소 설정 ( 상단 appMode 에 따라 테스트와 실서버로 분기됩니다. )
        //--------------------------------------------------------------------------------------------------------------------------
        if ($this->payInfo['appMode'] == "TEST") {
            $this->payInfo['URL_reserve'] = "https://alpha-api-bill.payco.com/outseller/order/reserve";
            $this->payInfo['URL_approval'] = "https://alpha-api-bill.payco.com/outseller/payment/approval";
            $this->payInfo['URL_cancel_check'] = "https://alpha-api-bill.payco.com/outseller/order/cancel/checkAvailability";
            $this->payInfo['URL_cancel'] = "https://alpha-api-bill.payco.com/outseller/order/cancel";
            $this->payInfo['URL_upstatus'] = "https://alpha-api-bill.payco.com/outseller/order/updateOrderProductStatus";
            $this->payInfo['URL_cancelMileage'] = "https://alpha-api-bill.payco.com/outseller/order/cancel/partMileage";
            $this->payInfo['URL_checkUsability'] = "https://alpha-api-bill.payco.com/outseller/code/checkUsability";
            $this->payInfo['URL_detailForVerify'] = "https://alpha-api-bill.payco.com/outseller/payment/approval/getDetailForVerify"; // alpha(개발) 결제상세 조회(검증용)API URL
        } else {
            $this->payInfo['URL_reserve'] = "https://api-bill.payco.com/outseller/order/reserve";
            $this->payInfo['URL_approval'] = "https://api-bill.payco.com/outseller/payment/approval";
            $this->payInfo['URL_cancel_check'] = "https://api-bill.payco.com/outseller/order/cancel/checkAvailability";
            $this->payInfo['URL_cancel'] = "https://api-bill.payco.com/outseller/order/cancel";
            $this->payInfo['URL_upstatus'] = "https://api-bill.payco.com/outseller/order/updateOrderProductStatus";
            $this->payInfo['URL_cancelMileage'] = "https://api-bill.payco.com/outseller/order/cancel/partMileage";
            $this->payInfo['URL_checkUsability'] = "https://api-bill.payco.com/outseller/code/checkUsability";
            $this->payInfo['URL_detailForVerify'] = "https://api-bill.payco.com/outseller/payment/approval/getDetailForVerify";      // (운영)결제상세 조회(검증용)API URL
        }

        //--------------------------------------------------------------------------------------------------------------------------
        // 로그 파일 선언
        //--------------------------------------------------------------------------------------------------------------------------
        $todate = str_replace("-", "", date("Y-m-d"));
        $Write_LogFile = "log" . DIRECTORY_SEPARATOR . "Payco_Log_" . $todate . "_php.txt";

        //--------------------------------------------------------------------------------------------------------------------------
        // 접속 브라우저 확인
        //--------------------------------------------------------------------------------------------------------------------------
        if (preg_match('/(iPhone|iPod|iPad|Android|Windows CE|BlackBerry|Symbian|Windows Phone|webOS|Opera Mni|Opera Mobi|POLARIS|IEMobile|lgtelecom|nokia|SonyEricsson|LG|SAMSUNG|Samsung)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $this->payInfo['isMobile'] = 0;
            // echo "모바일 웹 브라우저 입니다.";
        } else {
            // echo "웹 브라우저 입니다.";
            $this->payInfo['isMobile'] = 1;
        }
    }

    public function return()
    {
        include("application/libraries/pg/payco/payco_util.php");

        $doApproval = true;																// 기본적으로 주문예약 및 결제인증 받은것으로 설정
        $reserveOrderNo					= $_REQUEST["reserveOrderNo"];					// 주문 예약 번호
        $sellerOrderReferenceKey		= $_REQUEST["sellerOrderReferenceKey"];			// 외부가맹점에서 관리하는 주문연동Key
        $paymentCertifyToken			= $_REQUEST["paymentCertifyToken"];				// 결제인증토큰(결제승인시 필요)
        $totalPaymentAmt				= $_REQUEST["totalPaymentAmt"];					// 총결제금액
        $discountAmt					= $_REQUEST["discountAmt"];						// 쿠폰할인금액(PAYCO포인트 미포함 )
        $totalRemoteAreaDeliveryFeeAmt	= $_REQUEST["totalRemoteAreaDeliveryFeeAmt"];	// 총 도서산간비( 추가배송비 )
        $pointAmt						= $_REQUEST["pointAmt"];						// PAYCO 포인트 사용금액

        $cartNo							= $_REQUEST["cartNo"];							// returnUrlParam 에서 던진 값을 수신( 장바구니 번호 )
        $totalTaxableAmt				= $_REQUEST["tmpTotalTaxableAmt"];				// returnUrlParam 에서 던진 값을 수신( 과세 )
        $totalVatAmt					= $_REQUEST["tmpTotalVatAmt"];					// returnUrlParam 에서 던진 값을 수신( 부과세 )
        $totalTaxfreeAmt 				= $_REQUEST["tmpTotalTaxfreeAmt"];				// returnUrlParam 에서 던진 값을 수신( 면세 )

        $code							= $_REQUEST["code"];							// 결과코드
        $message						= $_REQUEST["message"];							// 결과코드

        $returnResult = [
            'code' => '9999',
            'message' => '오류가 발생하였습니다',
            'data' => ''
        ];
        $ItemTotalOrderAmt = $totalPaymentAmt;

        if ($code == 2222) {
            $returnResult['code'] = $code;
            $returnResult['message'] = '사용자에 의해 결제취소 되었습니다';
        } else if($code == "4005"){
            $returnResult['code'] = $code;
            $returnResult['message'] = '이미 주문 완료되었습니다';
        } else if ($totalPaymentAmt != $ItemTotalOrderAmt) {
            $returnResult['code'] = '9999';
            $returnResult['message'] = '주문금액과 결제금액이 틀립니다';
        } else if ($code == 0) {

            $approvalOrder["sellerKey"]					= $this->payInfo['sellerKey'];					// 가맹점 코드. payco_config.php 에 설정
            $approvalOrder["reserveOrderNo"]			= $reserveOrderNo;				// 예약주문번호.
            $approvalOrder["paymentCertifyToken"]		= $paymentCertifyToken;			// 결제인증토큰.
            $approvalOrder["sellerOrderReferenceKey"]	= $sellerOrderReferenceKey;		// 외부가맹점에서 관리하는 주문연동Key
            $approvalOrder["totalPaymentAmt"]			= $totalPaymentAmt;				// 주문 총 금액.

            // 결제승인 요청( approval )
            $Result = payco_approval($this->payInfo['URL_approval'], stripslashes(json_encode($approvalOrder)) );
            $Read_Data = json_decode( $Result, true );

            $sellerOrderReferenceKey			= $Read_Data["result"]["sellerOrderReferenceKey"];			// 가맹점에서 발급했던 주문 연동 Key
            $reserveOrderNo						= $Read_Data["result"]["reserveOrderNo"];					// PAYCO에서 발급한 주문예약번호
            $orderNo							= $Read_Data["result"]["orderNo"];							// PAYCO에서 발급한 주문번호
            $memberName							= $Read_Data["result"]["memberName"];						// 주문자명
            $totalOrderAmt						= $Read_Data["result"]["totalOrderAmt"];					// 총 주문 금액
            $totalDeliveryFeeAmt				= $Read_Data["result"]["totalDeliveryFeeAmt"];				// 총 배송비 금액
            $totalRemoteAreaDeliveryFeeAmt		= $Read_Data["result"]["totalRemoteAreaDeliveryFeeAmt"];	// 총 추가배송비 금액
            $totalPaymentAmt					= $Read_Data["result"]["totalPaymentAmt"];					// 총 결제 금액
            $sellerOrderProductReferenceKey     = $Read_Data["result"]["orderProducts"][0]["sellerOrderProductReferenceKey"];	// 가맹점에서 관리하는 	주문상품 연동key
            $orderCertifyKey 					= $Read_Data["result"]["orderCertifyKey"];					// 주문인증키

            // 결제상세 조회(검증용)API 호출 - 승인완료 후 DB 저장시 오류 났을 경우, 결제취소시에 사용합니다.
            $detailForVerify = array();
            $detailForVerify["sellerKey"] = $this->payInfo['sellerKey'];                    // 가맹점 코드. payco_config.php 에 설정
            $detailForVerify["reserveOrderNo"] = $reserveOrderNo;                // 예약주문번호.
            $detailForVerify["sellerOrderReferenceKey"] = $sellerOrderReferenceKey;    // 외부가맹점에서 관리하는 주문연동Key

            $detailForVerify_Result = payco_detailForVerify($this->payInfo['URL_detailForVerify'], stripslashes(json_encode($detailForVerify)));        // 배열을 JSON 형식으로 변환 및 백슬래시 제거 후에, 결제 승인 요청함.
            $detailForVerify_Read_Data = json_decode($detailForVerify_Result, true);                            // JSON 형식의 전달받은 값을, 배열로 변환.

            try
            {
                $params['code'] = $Read_Data['code'];
                $params['message'] = $Read_Data['message'];
                $params['order_no'] = $Read_Data["result"]["orderNo"];
                $params['amt'] = $Read_Data["result"]["totalPaymentAmt"];
                $params['complete_ymdt'] = $Read_Data["result"]['paymentCompleteYmdt'];
                $params['order_certify_key'] = $Read_Data["result"]["orderCertifyKey"];
                $params['cor_id'] = $Read_Data["result"]["sellerOrderReferenceKey"];
                $params['raw_data'] = $Result;
                $this->Cmall_order_model->payco_log_insert($params);

                $returnResult['code'] = $Read_Data["code"];
                $returnResult['message'] = ($Read_Data["code"] == '0') ? '주문이 정상적으로 완료되었습니다' : $Read_Data['message'];
                $returnResult['data'] = $Result;
            }
            catch ( Exception $e )
            {
                $cancelOrder = array();
                $cancelOrder["sellerKey"] = $this->payInfo['sellerKey'];                            // 가맹점 코드. payco_config.php 에 설정
                $cancelOrder["sellerOrderReferenceKey"] = $detailForVerify_Read_Data["result"]["sellerOrderReferenceKey"];                // 취소주문연동키. ( 파라메터로 넘겨 받은 값 )
                $cancelOrder["orderCertifyKey"] = $detailForVerify_Read_Data["result"]["orderCertifyKey"];                        // 주문완료통보시 내려받은 인증값
                $cancelOrder["cancelTotalAmt"] = $detailForVerify_Read_Data["result"]["totalPaymentAmt"];                        // PAYCO 주문서의 총 금액을 입력합니다. (전체취소, 부분취소 전부다)

                $cancel_Result = payco_cancel($this->payInfo['URL_cancel'], stripslashes(json_encode($cancelOrder)));
                $returnResult['code'] = '9999';
                $returnResult['message'] = 'DB 저장오류 발생하여 결제취소 되었습니다';
                //exit(json_encode($returnResult));
            }
        } else {
            $returnResult['code'] = $code;
            $returnResult['message'] = '결제가 승인되지 않았습니다';
        }

        $this->load->view('pg/payco/return', $returnResult);
    }

    public function popup()
    {
        $this->load->view('pg/payco/payco_popup');
    }

    public function reserve()
    {
        //-----------------------------------------------------------------------------
        // PAYCO 주문 예약 페이지 샘플  ( PHP EASYPAY / PAY2 )
        // payco_reserve.php
        // 2016-08-26	PAYCO기술지원 <dl_payco_ts@nhnent.com>
        //-----------------------------------------------------------------------------
        header('Content-Type: text/html; charset=utf-8');
        include("application/libraries/pg/payco/payco_util.php");

        //-----------------------------------------------------------------------------
        // 이 문서는 json 형태의 데이터를 반환합니다.
        //-----------------------------------------------------------------------------
        // header("Content-Type:application/json");

        //---------------------------------------------------------------------------------
        // 이전 페이지에서 전달받은 고객 주문번호 설정, 장바구니 번호 설정
        //---------------------------------------------------------------------------------
        $customerOrderNumber = $_REQUEST["customerOrderNumber"];
        $cartNo              = $_REQUEST["cartNo"];

        //-----------------------------------------------------------------------------
        // (로그) 호출 시점과 호출값을 파일에 기록합니다.
        //-----------------------------------------------------------------------------
//        Write_Log("payco_reserve.php is Called - customerOrderNumber : $customerOrderNumber , cartNo : $cartNo");


        //---------------------------------------------------------------------------------
        // 상품정보 변수 선언 및 초기화
        //---------------------------------------------------------------------------------
//        Global $cpId, $productId;

        //---------------------------------------------------------------------------------
        // 변수 초기화
        //---------------------------------------------------------------------------------
        $TotalProductPaymentAmt = 0	;		//주문 상품이 여러개일 경우 상품들의 총 금액을 저장할 변수
        $OrderNumber			= 0;		//주문 상품이 여러개일 경우 순번을 매길 변수

        //---------------------------------------------------------------------------------
        // 구매 상품을 변수에 셋팅 ( JSON 문자열을 생성 )
        //---------------------------------------------------------------------------------
        $ProductRows = array();				// (필수) 주문서에 담길 상품 목록 생성

        $tmpTotalTaxfreeAmt = 0;			// 면세상품합
        $tmpTotalTaxableAmt = 0;			// 과세상품합
        $tmpTotalVatAmt		= 0;			// 부가세합

        //---------------------------------------------------------------------------------
        // 상품정보 값 입력
        //---------------------------------------------------------------------------------
        $OrderNumber					= $OrderNumber + 1;									// 상품에 순번을 정하기 위해 값을 증가합니다.

        $orderQuantity					= $_REQUEST["orderQuantity"];												// (필수) 주문수량 (1로 세팅)
        $productUnitPrice				= $_REQUEST["productUnitPrice"];											// (필수) 상품 단가      ( 테스트용으로써 100,000원으로 설정. )
        $productUnitPaymentPrice		= $_REQUEST["productUnitPaymentPrice"];										// (필수) 상품 결제 단가 ( 테스트용으로써 100,000원으로 설정. 배송비 설정시 상품가격에 포함시킴 ex)2,500 )

        //상품단가(productAmt)는 원 상품단가이고 상품결제단가(productPaymentAmt)는 상품단가에서 할인등을 받은 금액입니다. 실제 결제에는 상품결제단가가 사용됩니다.
        $productAmt						= $productUnitPrice * $orderQuantity;				// (필수) 상품 결제금액(상품단가 * 수량)
        $productPaymentAmt				= $productUnitPaymentPrice * $orderQuantity;		// (필수) 상품 결제금액(상품결제단가 * 수량)
        $TotalProductPaymentAmt			= $TotalProductPaymentAmt + $productPaymentAmt;		// 주문정보를 구성하기 위한 상품들 누적 결제 금액(상품 결제 금액)

        $iOption						= "";							    		  		// 옵션 ( 최대 100 자리 )
        $sortOrdering					= $OrderNumber;										// (필수) 상품노출순서, 10자 이내
        $productName					= $_REQUEST["productName"];     					// (필수) 상품명, 4000자 이내
        $orderConfirmUrl				= "";												// 주문완료 후 주문상품을 확인할 수 있는 url, 4000자 이내
        $orderConfirmMobileUrl			= "";												// 주문완료 후 주문상품을 확인할 수 있는 모바일 url, 1000자 이내
        $productImageUrl				= "";												// 이미지URL (배송비 상품이 아닌 경우는 필수), 4000자 이내, productImageUrl에 적힌 이미지를 썸네일해서 PAYCO 주문창에 보여줍니다.
        $sellerOrderProductReferenceKey = $_REQUEST["sellerOrderProductReferenceKey"];		// 외부가맹점에서 관리하는 주문상품 연동 키(sellerOrderProductReferenceKey)는 주문 별로 고유한 key이어야 한다.
        $taxationType					= "TAXATION";										// 과세타입 : DUTYFREE :면세, COMBINE : 결합상품, TAXATION : 과세
        //$taxationType					= "DUTYFREE";


        //---------------------------------------------------------------------------------------------------------------------------------
        // 주문서에 담길 부가 정보를 JSON 으로 작성 (필요시 사용)
        // payExpiryYmdt			: 해당 주문예약건 만료 처리 일시
        // virtualAccountExpiryYmd  : 가상계좌만료일시
        //
        // cancelMobileUrl			: 모바일 결제페이지에서 취소 버튼 클릭시 이동할 URL (결제창 이전 URL 등). 미입력시 메인 URL로 이동
        /// 모바일 결제페이지에서 취소 버튼 클릭시 이동할 URL (결제창 이전 URL 등)
        /// 1순위 : 주문예약 > extraData > cancelMobileUrl 값이 있을시 => cancelMobileUrl 이동
        /// 2순위 : 주문예약시 전달받은 returnUrl 이동 + 실패코드(오류코드:2222)
        /// 3순위 : 가맹점 URL로 이동(가맹점등록시 받은 사이트URL)
        /// 4순위 : 이전 페이지로 이동 => history.Back();
        //
        // viewOptions			    : 화면UI옵션(showMobileTopGnbYn : 모바일 상단 GNB 노출여부 , iframeYn : Iframe 호출현재 iframeYN의 용도는 없으며, 차후 iframe 이슈 대응을 위한 필드로 iframe 사용인 경우는 Y로사용 )
        //---------------------------------------------------------------------------------------------------------------------------------

        //$payExpiryYmdt			             	= "20171231180000";	             // 미적용시, 자동으로 만료시간 지정됨.
        //$virtualAccountExpiryYmd					= "20171231180000";

        //$appUrl = "payco://";														 // IOS 인앱 결제시 ISP 모바일 등의 앱에서 결제를 처리한 뒤 복귀할 앱 URL
        // 앱을 호출하는 url , Safari 에서 호출 테스트  예) payco://

        //$cancelMobileUrl 							= $AppWebPath."index.php";       //모바일 PAYCO 결제창 [취소] 버튼 선택

        $viewOptionsArry 							= array();
        //$viewOptionsArry["showMobileTopGnbYn"]		= "Y";
        $viewOptionsArry["iframeYn"]				= "N";
        //$viewOptions = json_encode($viewOptionsArry);                             // 배열 형태를 JSON 으로 Encode 금지. 주문예약 요청 JSON 형식에 맞지않는 역슬래시가 자동 추가됨.

        $extraDataArray								= array();
        //$extraDataArray["payExpiryYmdt"] 			    = $payExpiryYmdt;
        //$extraDataArray["virtualAccountExpiryYmd"] 	= $virtualAccountExpiryYmd;

        //$extraDataArray["appUrl"] 					= $appUrl;
        //$extraDataArray["cancelMobileUrl"] 			= $cancelMobileUrl;

        $extraDataArray["viewOptions"] 				= $viewOptionsArry;

        $extraData = addslashes(json_encode($extraDataArray));

        //Write_Log("payco_reserve.php is Called >>>> extraData : $extraData");


        //-----------------------------------------------------------------------------------------------------------------------------------------------------------
        // $tmpTotalTaxfreeAmt(면세상품 총액) / $tmpTotalTaxableAmt(과세상품 총액) / $tmpTotalVatAmt(부가세 총액) -> 일부 필요한 가맹점을위한 예제임 (필요시 사용)
        //------------------------------------------------------------------------------------------------------------------------------------------------------------

        // 과세상품일 경우
        if( $taxationType == "TAXATION") {
            $tmpTotalTaxableAmt = round($TotalProductPaymentAmt/1.1);
            $tmpTotalVatAmt		= $TotalProductPaymentAmt - $tmpTotalTaxableAmt;

            // 면세상품일 경우
        } else if( $taxationType == "DUTYFREE"){
            $tmpTotalTaxfreeAmt = $TotalProductPaymentAmt;  // 총 결제 할 금액 적용

            // 복합상품일 경우(
        } else if( $taxationType == "COMBINE") {
            $tmpTotalTaxfreeAmt = 0;
            $tmpTotalTaxableAmt = 93182;
            $tmpTotalVatAmt	   = 9318;
        }

        //---------------------------------------------------------------------------------
        // 상품값으로 읽은 변수들로 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------
        try {
            $ProductsList = array();
            $ProductsList["cpId"]					= $this->payInfo['cpId'];
            $ProductsList["productId"]				= $this->payInfo['productId'];
            $ProductsList["productAmt"]				= $productAmt;
            $ProductsList["productPaymentAmt"]		= $productPaymentAmt;
            $ProductsList["orderQuantity"]			= $orderQuantity;
            $ProductsList["option"]					= urlencode($iOption);
            $ProductsList["sortOrdering"]			= $sortOrdering;
            $ProductsList["productName"]			= urlencode($productName);

            if ( $orderConfirmUrl					!= "") {		$ProductsList["orderConfirmUrl"]				= $orderConfirmUrl; 				};
            if ( $orderConfirmMobileUrl				!= "") {		$ProductsList["orderConfirmMobileUrl"]			= $orderConfirmMobileUrl;			};
            if ( $productImageUrl					!= "") {		$ProductsList["productImageUrl"]				= $productImageUrl;					};
            if ( $sellerOrderProductReferenceKey	!= "") {		$ProductsList["sellerOrderProductReferenceKey"] = $sellerOrderProductReferenceKey;	};
            array_push($ProductRows, $ProductsList);

        } catch ( Exception $e ) {
            $Error_Return = array();
            $Error_Return["result"]		= "DB_RECORDSET_ERROR";
            $Error_Return["message"]	= $e->getMassage();
            $Error_Return["code"]		= $e->getLine();
            return json_encode($Error_Return);
        }

        //---------------------------------------------------------------------------------
        // 주문정보 변수 선언
        //---------------------------------------------------------------------------------
//        Global $sellerKey,$AppWebPath;


        //---------------------------------------------------------------------------------
        // 주문정보 값 입력 ( 가맹점 수정 가능 부분 )
        //---------------------------------------------------------------------------------
        $sellerOrderReferenceKey		= $customerOrderNumber;														// (필수) 외부가맹점의 주문번호
        $sellerOrderReferenceKeyType	= "UNIQUE_KEY";																//  외부가맹점의 주문번호 타입 UNIQUE_KEY 유니크 키 - 기본값, DUPLICATE_KEY 중복 가능한 키( 외부가맹점의 주문번호가 중복 가능한 경우 사용)

        //$sellerOptions = "{\\\"clientIp\\\":\\\"210.206.104.164\\\",\\\"memberId\\\":\\\"userid\\\"}"; // 게임결제용_판매자부가정보

        $iCurrency						= "KRW";																	// 통화(default=KRW)

        //$totalOrderAmt				= $TotalProductPaymentAmt;													// (필수) 총 주문금액.
        $totalPaymentAmt				= $TotalProductPaymentAmt;													// (필수) 총 결재 할 금액.

        $orderTitle						= $productName;										// 주문 타이틀

        $returnUrl						= $this->payInfo['AppWebPath'].'return';											// 주문완료 후 Redirect 되는 Url
        //---------------------------------------------------------------------------------------------------------------------------------
        //$returnUrlParam 담길 값를 JSON 으로 작성 (필요시 사용)
        //---------------------------------------------------------------------------------------------------------------------------------
        $returnUrlParamArray = array();
        $returnUrlParamArray["cartNo"] = $cartNo;                      // 장바구니 번호

        // 면세상품일 경우
        if( $taxationType == "DUTYFREE"){
            $returnUrlParamArray["tmpTotalTaxfreeAmt"] = $tmpTotalTaxfreeAmt;      // 면세금액 ( 총 결제 할 금액 적용 )

            // 과세상품일 경우
        } elseif( $taxationType == "TAXATION") {
            $returnUrlParamArray["tmpTotalTaxableAmt"] = $tmpTotalTaxableAmt;      // 과세금액
            $returnUrlParamArray["tmpTotalVatAmt"]     = $tmpTotalVatAmt;          // 부과세금액

            // 복합상품일 경우
        }else{
            $returnUrlParamArray["tmpTotalTaxfreeAmt"] = 0;
            $returnUrlParamArray["tmpTotalTaxableAmt"] = $tmpTotalTaxableAmt;      // 과세금액
            $returnUrlParamArray["tmpTotalVatAmt"]     = $tmpTotalVatAmt;          // 부과세금액
        }

        $returnUrlParamArrayJSON = addslashes(json_encode($returnUrlParamArray));   // {\"cartNo\":\"CartNo_12345\"}

        //주문완료 시 PAYCO에서 가맹점의 Service API 호출할때 같이 전달할 파라미터(payco_reserve.php 에서 payco_return.php 로 전달할 값을 JSON 형태의 문자열로 전달)
        $returnUrlParam                = $returnUrlParamArrayJSON;
        //Write_Log("payco_reserve.php is Called - returnUrlParam : $returnUrlParam");

        $nonBankbookDepositInformUrl	= $this->payInfo['AppWebPath'].'bankbook.php';								    //무통장입금완료통보 URL
        $orderMethod					= "EASYPAY";																// (필수) 주문유형(=결재유형) - 체크아웃형 : CHECKOUT - 간편결제형+가맹점 id 로그인 : EASYPAY_F , 간편결제형+가맹점 id 비로그인(PAYCO 회원구매) : EASYPAY
        $orderChannel					= $_REQUEST["orderChannel"] ?? "PC";								        // 주문채널 ( default : PC / MOBILE )
        $inAppYn						= "N";																		// 인앱결제 여부( Y/N ) ( default = N )
        $individualCustomNoInputYn		= "N"	;																	// 개인통관고유번호 입력 여부 ( Y/N ) ( default = N )
        $orderSheetUiType				= "GRAY";																	// 주문서 UI 타입 선택 ( 선택 가능값 : RED / GRAY )
        $payMode						= "PAY2";																	// 결제모드 ( PAY1 - 결제인증, 승인통합 / PAY2 - 결제인증, 승인분리 )

        //-----------------------------------------------------------------------------------------------------------------------------------------------------------
        // $tmpTotalTaxfreeAmt(면세상품 총액) / $tmpTotalTaxableAmt(과세상품 총액) / $tmpTotalVatAmt(부가세 총액) -> 일부 필요한 가맹점을위한 예제임 (필요시 사용)
        //------------------------------------------------------------------------------------------------------------------------------------------------------------

        $totalTaxfreeAmt				= $tmpTotalTaxfreeAmt;														// 면세금액(면세상품의 공급가액 합)
        $totalTaxableAmt				= $tmpTotalTaxableAmt;														// 과세금액(과세상품의 공급가액 합)
        $totalVatAmt					= $tmpTotalVatAmt;															// 부가세(과세상품의 부가세 합)



        //---------------------------------------------------------------------------------
        // 설정한 주문정보들을 Json String 을 작성합니다.
        //---------------------------------------------------------------------------------

        $json = array();
        try {
            $strJson = array();
            $strJson["sellerKey"]					= $this->payInfo['sellerKey'];
            $strJson["sellerOrderReferenceKey"]		= $sellerOrderReferenceKey;
            $strJson["sellerOrderReferenceKeyType"] = $sellerOrderReferenceKeyType;

            // $strJson["sellerOptions"] = $sellerOptions; // 게임결제용_판매자부가정보

            $strJson["totalPaymentAmt"]			= $totalPaymentAmt;
            $strJson["orderTitle"]				= urlencode($orderTitle);
            $strJson["orderMethod"]				= $orderMethod;
            if ( $iCurrency						!= "") {		$strJson["currency"]					= $iCurrency;					};
            if ( $returnUrl						!= "") {		$strJson["returnUrl"]					= $returnUrl;					};
            if ( $returnUrlParam				!= "") {		$strJson["returnUrlParam"]				= $returnUrlParam;				};
            if ( $nonBankbookDepositInformUrl	!= "") {		$strJson["nonBankbookDepositInformUrl"] = $nonBankbookDepositInformUrl;	};
            if ( $orderChannel					!= "") {		$strJson["orderChannel"]				= $orderChannel;				};
            if ( $inAppYn						!= "") {		$strJson["inAppYn"]						= $inAppYn;						};
            if ( $individualCustomNoInputYn		!= "") {		$strJson["individualCustomNoInputYn"]	= $individualCustomNoInputYn;	};
            if ( $orderSheetUiType				!= "") {		$strJson["orderSheetUiType"]			= $orderSheetUiType;			};
            if ( $payMode						!= "") {		$strJson["payMode"] = $payMode;											};

            //-----------------------------------------------------------------------------------------------------------------------------------------------------------
            // $tmpTotalTaxfreeAmt(면세상품 총액) / $tmpTotalTaxableAmt(과세상품 총액) / $tmpTotalVatAmt(부가세 총액) -> 일부 필요한 가맹점을위한 예제임 (필요시 사용)
            //------------------------------------------------------------------------------------------------------------------------------------------------------------
            $strJson["totalTaxfreeAmt"]			= $totalTaxfreeAmt;
            $strJson["totalTaxableAmt"]			= $totalTaxableAmt;
            $strJson["totalVatAmt"]				= $totalVatAmt;

            $strJson["extraData"]				= $extraData;
            $strJson["orderProducts"]			= $ProductRows;

            $res =  payco_reserve($this->payInfo['URL_reserve'], urldecode(stripslashes(json_encode($strJson))));  //주문예약 API 호출 함수
            echo $res;
        } catch ( Exception $e ) {
            $Error_Return				= array();
            $Error_Return["result"]		= "RESERVE_ERROR";
            $Error_Return["message"]	= $e->getMassage();
            $Error_Return["code"]		= $e->getCode();
//            Write_Log("payco_reserve.php Logical Error : Code - ".$e->getCode().", Description - ".$e->getMessage());
            return json_encode($Error_Return);
        }
    }
}