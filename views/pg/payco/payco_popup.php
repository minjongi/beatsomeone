<?php
	//-----------------------------------------------------------------------------
	// PAYCO 팝업차단 페이지 샘플 ( PHP EASYPAY / PAY1 )
	// payco_popup.php
	// 2016-08-30	PAYCO기술지원 <dl_payco_ts@nhnent.com>
	//-----------------------------------------------------------------------------
	include("application/libraries/pg/payco/payco_config.php");

	//-----------------------------------------------------------------------------
	// 테스트용 고객 주문 번호 받아와서 생성
	// 테스트 할때 마다 Refresh(F5)를 해서 고객 주문 번호가 바뀌어야 정상적인 테스트를 하실 수 있습니다.
	//-----------------------------------------------------------------------------
	
	$customerOrderNumber = $_REQUEST["customerOrderNumber"]; // 가맹점 고객 주문번호
	$cartNo 			 = $_REQUEST["cartNo"]; 			 // 장바구니 번호	
	
	//-----------------------------------------------------------------------------
	// (로그) 호출값을 파일에 기록합니다.
	//-----------------------------------------------------------------------------	
	
	Write_Log("payco_popup.php is Called - customerOrderNumber : $customerOrderNumber , cartNo : $cartNo");	

?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">

<meta name="keyword" content="컨텐츠">

<title>PAYCO 팝업차단 페이지 샘플(PHP EasyPay PAY1)</title>

<link href="css/common.css" rel="stylesheet" type="text/css">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<!--
<script src="/share/js/requirejs/require.js"></script>
<script src="/share/js/requirejs/require.config.js"></script>
-->
<script type="text/javascript" src="https://static-bill.nhnent.com/payco/checkout/js/payco.js" charset="UTF-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">

function callPaycoUrl(){

	
	var customerOrderNumber = "<?=$customerOrderNumber?>";            // ( 결제완료 후 에도 주문예약번호 자동생성 가능하도록 임시 추가 ) 가맹점 고객 주문번호 입력

	//var Params = "customerOrderNumber=<?=$customerOrderNumber?>";	// 가맹점 고객 주문번호 입력
	
	var cartNo = "<?=$cartNo?>";                         // 장바구니 번호
		
	
    // localhost 로 테스트 시 크로스 도메인 문제로 발생하는 오류 
    $.support.cors = true;

	/* + "&" + $('order_product_delivery_info').serialize() ); */
	$.ajax({
		type: "POST",
		url: "<?=$AppWebPath?>reserve",

		//data: Params,		// JSON 으로 보낼때는 JSON.stringify(customerOrderNumber)
		data:{"customerOrderNumber":customerOrderNumber, "cartNo":cartNo},
		
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		dataType:"json",
		success:function(data){
			if(data.code == '0') {
				
				//console.log(data.result.reserveOrderNo);	// 주석 해제시, 일부 웹브라우저 에서 PAYCO 결제창이 뜨지 않습니다.	
						
				location.href = data.result.orderSheetUrl;		
				//document.location.href = order_Url;
											
			} else {				
				alert("code:"+data.code+"\n"+"message:"+data.message);				
			}
		},
        error: function(request,status,error) {
            //에러코드
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			return false;
        }
	});
}

</script>
</head>
<body onLoad="callPaycoUrl()"></body>
</html>