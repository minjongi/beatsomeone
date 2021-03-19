<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Login class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 로그인 페이지와 관련된 controller 입니다.
 */
class Login extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'string');

	function __construct()
	{
		parent::__construct();

	}


	/**
	 * 로그인 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_login_index';
		$this->load->event($eventname);

		if ($this->member->is_member() !== false && ! ($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
			redirect();
		}

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$this->load->library(array('form_validation'));

		 if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		if ($use_login_account === 'both') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디 또는 이메일',
				'rules' => 'trim|required',
			);
			$view['view']['userid_label_text'] = '아이디 또는 이메일';
		} elseif ($use_login_account === 'email') {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '이메일',
				'rules' => 'trim|required|valid_email',
			);
			$view['view']['userid_label_text'] = '이메일';
		} else {
			$config[] = array(
				'field' => 'mem_userid',
				'label' => '아이디',
				'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]',
			);
			$view['view']['userid_label_text'] = '아이디';
		}
		$config[] = array(
			'field' => 'mem_password',
			'label' => '패스워드',
			'rules' => 'trim|required|min_length[4]|callback__check_id_pw[' . $this->input->post('mem_userid') . ']',
		);

		$this->form_validation->set_rules($config);
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

			if ($this->input->post('returnurl')) {
				if (validation_errors('<div class="alert alert-warning" role="alert">', '</div>')) {
					$this->session->set_flashdata(
						'loginvalidationmessage',
						validation_errors('<div class="alert alert-warning" role="alert">', '</div>')
					);
				}
				$this->session->set_flashdata(
					'loginuserid',
					$this->input->post('mem_userid')
				);
				redirect(urldecode($this->input->post('returnurl')));
			}

			$view['view']['canonical'] = site_url('login');

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

			/**
			 * 레이아웃을 정의합니다
			 */
			$page_title = $this->cbconfig->item('site_meta_title_login');
			$meta_description = $this->cbconfig->item('site_meta_description_login');
			$meta_keywords = $this->cbconfig->item('site_meta_keywords_login');
			$meta_author = $this->cbconfig->item('site_meta_author_login');
			$page_name = $this->cbconfig->item('site_page_name_login');

			$layoutconfig = array(
				'path' => 'login',
				'layout' => 'layout',
				'skin' => 'login',
				'layout_dir' => $this->cbconfig->item('layout_login'),
				'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_login'),
				'use_sidebar' => $this->cbconfig->item('sidebar_login'),
				'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_login'),
				'skin_dir' => $this->cbconfig->item('skin_login'),
				'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_login'),
				'page_title' => $page_title,
				'meta_description' => $meta_description,
				'meta_keywords' => $meta_keywords,
				'meta_author' => $meta_author,
				'page_name' => $page_name,
			);
			$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
			$this->data = $view;
			$this->layout = element('layout_skin_file', element('layout', $view));
			$this->view = element('view_skin_file', element('layout', $view));
		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			if ($use_login_account === 'both') {
				$userinfo = $this->Member_model->get_by_both($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} elseif ($use_login_account === 'email') {
				$userinfo = $this->Member_model->get_by_email($this->input->post('mem_userid'), 'mem_id, mem_userid');
			} else {
				$userinfo = $this->Member_model->get_by_userid($this->input->post('mem_userid'), 'mem_id, mem_userid');
			}
			$this->member->update_login_log(element('mem_id', $userinfo), $this->input->post('mem_userid'), 1, '로그인 성공');
			$this->session->set_userdata(
				'mem_id',
				element('mem_id', $userinfo)
			);

			if ($this->input->post('autologin')) {
				$vericode = array('$', '/', '.');
				$hash = str_replace(
					$vericode,
					'',
					password_hash(random_string('alnum', 10) . element('mem_id', $userinfo) . ctimestamp() . element('mem_userid', $userinfo), PASSWORD_BCRYPT)
				);
				$insertautologin = array(
					'mem_id' => element('mem_id', $userinfo),
					'aul_key' => $hash,
					'aul_ip' => $this->input->ip_address(),
					'aul_datetime' => cdate('Y-m-d H:i:s'),
				);
				$this->load->model(array('Autologin_model'));
				$this->Autologin_model->insert($insertautologin);

				$cookie_name = 'autologin';
				$cookie_value = $hash;
				$cookie_expire = 2592000; // 30일간 저장
				set_cookie($cookie_name, $cookie_value, $cookie_expire);
			}

			$change_password_date = $this->cbconfig->item('change_password_date');
			$site_title = $this->cbconfig->item('site_title');
			if ($change_password_date) {

				$meta_change_pw_datetime = $this->member->item('meta_change_pw_datetime');
				if ( ctimestamp() - strtotime($meta_change_pw_datetime) > $change_password_date * 86400) {
					$this->session->set_userdata(
						'membermodify',
						'1'
					);
					$this->session->set_flashdata(
						'message',
						html_escape($site_title) . ' 은(는) 회원님의 비밀번호를 주기적으로 변경하도록 권장합니다.
						<br /> 오래된 비밀번호를 사용중인 회원님께서는 안전한 서비스 이용을 위해 비밀번호 변경을 권장합니다'
					);
					redirect('membermodify/password_modify');
				}
			}
			$this->load->model(array('Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model'));
			$member_group = $this->Member_group_member_model->get_with_group(element('mem_id', $userinfo));
			for ($i = 0; $i < count($member_group); $i++) {
				if ($member_group[$i]['mgr_id'] > 4) {
					$res_membership_purchase_log = $this->Beatsomeone_model->get_membership_purchase_log(array(
						'mem_id' => element('mem_id', $userinfo),
						'mgr_title' => $member_group[$i]['mgr_title'],
					));
					if (isset($res_membership_purchase_log) && isset($res_membership_purchase_log[0])) {
						$end_date = $res_membership_purchase_log[0]['end_date'];
						if (strtotime($end_date) < time()) {
							// 구독사용이 만료되였습니다.
							if ($res_membership_purchase_log[0]['pay_method'] == "allat") {



								include(FCPATH . 'plugin/pg/allat/subscribe/allatutil.php');

								$at_enc       = "";
								$at_data      = "";
								$at_txt       = "";
							
								echo time();
								// 필수 항목
								$at_cross_key = "11e9e1458ad968ccbc4db73c16c1341f";     //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/helpinfo/hi_install_guide.jsp#shop]
								$at_shop_id   = "dumdumfix";        //설정필요
						
								$at_fix_key        = $res_membership_purchase_log[0]['card_key'];   //카드키(최대 24자)
								$at_sell_mm        = "00";   //할부개월값(최대  2자)
								$at_amt            = $member_group[$i]['mgr_monthly_cost_w'];   //금액(최대 10자)

								$at_shop_member_id = element('mem_id', $userinfo);   //회원ID(최대 20자)               : 쇼핑몰회원ID
								$at_order_no       = time();   //주문번호(최대 80자)             : 쇼핑몰 고유 주문번호
								$at_product_cd     = $member_group[$i]['mgr_title'];   //상품코드(최대 1000자)           : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
								$at_product_nm     = $member_group[$i]['mgr_title'];   //상품명(최대 1000자)             : 여러 상품의 경우 구분자 이용, 구분자('||':파이프 2개)
								$at_cardcert_yn    = "N";   //카드인증여부(최대 1자)          : 인증(Y),인증사용않음(N),인증만사용(X)
								$at_zerofee_yn     = "N";   //일반/무이자 할부 사용 여부(최대 1자) : 일반(N), 무이자 할부(Y)
								$at_buyer_nm       = element('mem_userid', $userinfo);   //결제자성명(최대 20자)
								$at_recp_nm        = element('mem_userid', $userinfo);   //수취인성명(최대 20자)
								$at_recp_addr      = element('mem_userid', $userinfo);   //수취인주소(최대 120자)
								$at_buyer_ip       = "Unknown";   //결제자 IP(최대15자) - BuyerIp를 넣을수 없다면 "Unknown"으로 세팅
								$at_email_addr     = element('mem_email', $userinfo);   //결제자 이메일 주소(50자)
								$at_bonus_yn       = "N";   //보너스포인트 사용여부(최대1자)  : 사용(Y), 사용않음(N)
							
								$at_enc = setValue($at_enc,"allat_card_key"         ,   $at_fix_key        );
								$at_enc = setValue($at_enc,"allat_sell_mm"          ,   $at_sell_mm        );
								$at_enc = setValue($at_enc,"allat_amt"              ,   $at_amt            );
								$at_enc = setValue($at_enc,"allat_shop_id"          ,   $at_shop_id        );
								$at_enc = setValue($at_enc,"allat_shop_member_id"   ,   $at_shop_member_id );
								$at_enc = setValue($at_enc,"allat_order_no"         ,   $at_order_no       );
								$at_enc = setValue($at_enc,"allat_product_cd"       ,   $at_product_cd     );
								$at_enc = setValue($at_enc,"allat_product_nm"       ,   $at_product_nm     );
								$at_enc = setValue($at_enc,"allat_cardcert_yn"      ,   $at_cardcert_yn    );
								$at_enc = setValue($at_enc,"allat_zerofee_yn"       ,   $at_zerofee_yn     );
								$at_enc = setValue($at_enc,"allat_buyer_nm"         ,   $at_buyer_nm       );
								$at_enc = setValue($at_enc,"allat_recp_name"        ,   $at_recp_nm        );
								$at_enc = setValue($at_enc,"allat_recp_addr"        ,   $at_recp_addr      );
								$at_enc = setValue($at_enc,"allat_user_ip"          ,   $at_buyer_ip       );
								$at_enc = setValue($at_enc,"allat_email_addr"       ,   $at_email_addr     );
								$at_enc = setValue($at_enc,"allat_bonus_yn"         ,   $at_bonus_yn       );
								$at_enc = setValue($at_enc,"allat_pay_type"         ,   "FIX"              );  //수정금지(결제방식 정의)
								$at_enc = setValue($at_enc,"allat_test_yn"          ,   "N"                );  //테스트 :Y, 서비스 :N
								$at_enc = setValue($at_enc,"allat_opt_pin"          ,   "NOUSE"            );  //수정금지(올앳 참조 필드)
								$at_enc = setValue($at_enc,"allat_opt_mod"          ,   "APP"              );  //수정금지(올앳 참조 필드)
							
								$at_data = "allat_shop_id=".$at_shop_id.
										   "&allat_amt=".$at_amt.
										   "&allat_enc_data=".$at_enc.
										   "&allat_cross_key=".$at_cross_key;
							
								// 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
								//----------------------------------------------------------------
								$at_txt = ApprovalReq($at_data,"SSL");
							
								// 결제 결과 값 확인
								//------------------
								$REPLYCD   =getValue("reply_cd",$at_txt);        //결과코드
								$REPLYMSG  =getValue("reply_msg",$at_txt);       //결과 메세지
							
								if( !strcmp($REPLYCD,"0000") ){
									// reply_cd "0000" 일때만 성공
									$ORDER_NO         =getValue("order_no",$at_txt);
									$AMT              =getValue("amt",$at_txt);
									$PAY_TYPE         =getValue("pay_type",$at_txt);
									$APPROVAL_YMDHMS  =getValue("approval_ymdhms",$at_txt);
									$SEQ_NO           =getValue("seq_no",$at_txt);
									$APPROVAL_NO      =getValue("approval_no",$at_txt);
									$CARD_ID          =getValue("card_id",$at_txt);
									$CARD_NM          =getValue("card_nm",$at_txt);
									$SELL_MM          =getValue("sell_mm",$at_txt);
									$ZEROFEE_YN       =getValue("zerofee_yn",$at_txt);
									$CERT_YN          =getValue("cert_yn",$at_txt);
									$CONTRACT_YN      =getValue("contract_yn",$at_txt);

									$startDate = date('Y-m-d');
									$endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));
									$params = [
										'mem_id' => element('mem_id', $userinfo),
										'bill_term' => 'monthly',
										'plan' => $member_group[$i]['mgr_description'],
										'plan_name' => $member_group[$i]['mgr_title'],
										'start_date' => $startDate,
										'end_date' => $endDate,
										'pay_method' => 'allat',
										'amount' => intval($member_group[$i]["mgr_monthly_cost_w"]),
										'card_key' => $res_membership_purchase_log[0]['card_key']
									];
									$this->Beatsomeone_model->insert_membership_purchase_log($params);
									$downloaddata = array();
									$downloaddata['mem_remain_downloads'] = $member_group[$i]['mgr_monthly_download_limit'];
									$this->Member_model->update(element('mem_id', $userinfo), $downloaddata);
													
									// echo "결과코드              : ".$REPLYCD."<br>";
									// echo "결과메세지            : ".$REPLYMSG."<br>";
									// echo "주문번호              : ".$ORDER_NO."<br>";
									// echo "승인금액              : ".$AMT."<br>";
									// echo "지불수단              : ".$PAY_TYPE."<br>";
									// echo "승인일시              : ".$APPROVAL_YMDHMS."<br>";
									// echo "거래일련번호          : ".$SEQ_NO."<br>";
									// echo "승인번호              : ".$APPROVAL_NO."<br>";
									// echo "카드ID                : ".$CARD_ID."<br>";
									// echo "카드명                : ".$CARD_NM."<br>";
									// echo "할부개월              : ".$SELL_MM."<br>";
									// echo "무이자여부            : ".$ZEROFEE_YN."<br>";   //무이자(Y),일시불(N)
									// echo "인증여부              : ".$CERT_YN."<br>";      //인증(Y),미인증(N)
									// echo "직가맹여부            : ".$CONTRACT_YN."<br>";  //3자가맹점(Y),대표가맹점(N)
								}else{
									// reply_cd 가 "0000" 아닐때는 에러 (자세한 내용은 매뉴얼참조)
									// reply_msg 는 실패에 대한 메세지
									echo "결과코드  : ".$REPLYCD."<br>";
									echo "결과메세지: ".$REPLYMSG."<br>";
									var_dump($at_txt);
								}





							} else {
								redirect("/register/purchase?mgr_id=".$member_group[$i]['mgr_id']."&billTerm=monthly&repurchase=1");
								return;
							}
						}
					}
				}
			}
			$url_after_login = $this->cbconfig->item('url_after_login');
			if ($url_after_login) {
				$url_after_login = site_url($url_after_login);
			}
			if (empty($url_after_login)) {
				$url_after_login = $this->input->get_post('url') ? urldecode($this->input->get_post('url')) : site_url();
			}

			// 이벤트가 존재하면 실행합니다
			Events::trigger('after', $eventname);

			redirect($url_after_login);
		}
	}


	/**
	 * 로그인시 아이디와 패스워드가 일치하는지 체크합니다
	 */
	public function _check_id_pw($password, $userid)
	{
		 if ( ! function_exists('password_hash')) {
			$this->load->helper('password');
		}

		$max_login_try_count = (int) $this->cbconfig->item('max_login_try_count');
		$max_login_try_limit_second = (int) $this->cbconfig->item('max_login_try_limit_second');

		$loginfailnum = 0;
		$loginfailmessage = '';
		if ($max_login_try_count && $max_login_try_limit_second) {
			$select = 'mll_id, mll_success, mem_id, mll_ip, mll_datetime';
			$where = array(
				'mll_ip' => $this->input->ip_address(),
				'mll_datetime > ' => strtotime(ctimestamp() - 86400 * 30),
			);
			$this->load->model('Member_login_log_model');
			$logindata = $this->Member_login_log_model
				->get('', $select, $where, '', '', 'mll_id', 'DESC');

			if ($logindata && is_array($logindata)) {
				foreach ($logindata as $key => $val) {
					if ((int) $val['mll_success'] === 0) {
						$loginfailnum++;
					} elseif ((int) $val['mll_success'] === 1) {
						break;
					}
				}
			}
			if ($loginfailnum > 0 && $loginfailnum % $max_login_try_count === 0) {
				$lastlogintrydatetime = $logindata[0]['mll_datetime'];
				$next_login = strtotime($lastlogintrydatetime)
					+ $max_login_try_limit_second
					- ctimestamp();
				if ($next_login > 0) {
					$this->form_validation->set_message(
						'_check_id_pw',
						'회원님은 패스워드를 연속으로 ' . $loginfailnum . '회 잘못 입력하셨기 때문에 '
						. $next_login . '초 후에 다시 로그인 시도가 가능합니다'
					);
					return false;
				}
			}
			$loginfailmessage = '<br />회원님은 ' . ($loginfailnum + 1)
				. '회 연속으로 패스워드를 잘못입력하셨습니다. ';
		}

		$use_login_account = $this->cbconfig->item('use_login_account');

		$this->load->model(array('Member_dormant_model'));

		$userselect = 'mem_id, mem_password, mem_denied, mem_email_cert, mem_is_admin';
		$is_dormant_member = false;
		if ($use_login_account === 'both') {
			$userinfo = $this->Member_model->get_by_both($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_both($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} elseif ($use_login_account === 'email') {
			$userinfo = $this->Member_model->get_by_email($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_email($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		} else {
			$userinfo = $this->Member_model->get_by_userid($userid, $userselect);
			if ( ! $userinfo) {
				$userinfo = $this->Member_dormant_model->get_by_userid($userid, $userselect);
				if ($userinfo) {
					$is_dormant_member = true;
				}
			}
		}
		$hash = password_hash($password, PASSWORD_BCRYPT);

		if ( ! element('mem_id', $userinfo) OR ! element('mem_password', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(0, $userid, 0, '회원 아이디가 존재하지 않습니다');
			return false;
		} elseif ( ! password_verify($password, element('mem_password', $userinfo))) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원 아이디와 패스워드가 서로 맞지 않습니다' . $loginfailmessage
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '패스워드가 올바르지 않습니다');
			return false;
		} elseif (element('mem_denied', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님의 아이디는 접근이 금지된 아이디입니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '접근이 금지된 아이디입니다');
			return false;
		} elseif ($this->cbconfig->item('use_register_email_auth') && ! element('mem_email_cert', $userinfo)) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'회원님은 아직 이메일 인증을 받지 않으셨습니다'
			);
			$this->member->update_login_log(element('mem_id', $userinfo), $userid, 0, '이메일 인증을 받지 않은 회원아이디입니다');
			return false;
		} elseif (element('mem_is_admin', $userinfo) && $this->input->post('autologin')) {
			$this->form_validation->set_message(
				'_check_id_pw',
				'최고관리자는 자동로그인 기능을 사용할 수 없습니다'
			);
			return false;
		}

		if ($is_dormant_member === true) {
			$this->member->recover_from_dormant(element('mem_id', $userinfo));
		}

		return true;
	}


	/**
	 * 로그아웃합니다
	 */
	public function logout()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_logout_index';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);

		if ($this->member->is_member() === false) {
			redirect();
		}

		$where = array(
			'mem_id' => $this->member->item('mem_id'),
		);
		$this->load->model(array('Autologin_model'));
		$this->Autologin_model->delete_where($where);

		delete_cookie('autologin');

		$this->session->sess_destroy();
		$url_after_logout = $this->cbconfig->item('url_after_logout');
		if ($url_after_logout) {
			$url_after_logout = site_url($url_after_logout);
		}
		if (empty($url_after_logout)) {
			$url_after_logout = $this->input->get_post('url') ? $this->input->get_post('url') : '/';
		}

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		redirect($url_after_logout, 'refresh');
	}
}
