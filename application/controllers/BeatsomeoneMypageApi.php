<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Beatsomeone Mypage API class
 *
 * Copyright (c) Inpreter
 * Cmall 기반 음원거래 사이트 MYPAGE API
 *
 * @author Inpreter (empicy@gmail.com)
 */

/**
 * Beatsomeone Mypage API
 */
class BeatsomeoneMypageApi extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'accesslevel', 'cmalllib'));

	}

    /**
     * 사용자 정보 조회
     */
    public function getUserInfo()
    {
        $mem_id = $this->member->item('mem_id');
        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Member_model');


        $result = $this->Member_model->get_by_memid($mem_id);

        $result = array(
            'mem_id' => $result['mem_id'],
            'mem_userid' => $result['mem_userid'],
            'mem_username' => $result['mem_username'],
            'mem_address1' => $result['mem_address1'],
            'mem_email' => $result['mem_email'],
            'mem_firstname' => $result['mem_firstname'],
            'mem_lastname' => $result['mem_lastname'],
            'mem_type' => $result['mem_type'],
            'mem_profile_content' => $result['mem_profile_content'],
            'mem_usertype' => $result['mem_usertype'],
            'mem_nickname' => $result['mem_nickname'],
            'mem_photo' => $result['mem_photo'],
        );

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 대시보드 정보 조회
     */
    public function getDashboardInfo()
    {
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');
        $this->load->model('Member_model');

        $userinfo = $this->Member_model->get_by_memid($mem_id);
        $userinfo = array(
            'mem_id' => $userinfo['mem_id'],
            'mem_username' => $userinfo['mem_username'],
            'mem_address1' => $userinfo['mem_address1'],
            'mem_email' => $userinfo['mem_email'],
            'mem_firstname' => $userinfo['mem_firstname'],
            'mem_lastname' => $userinfo['mem_lastname'],
            'mem_type' => $userinfo['mem_type'],
            'mem_profile_content' => $userinfo['mem_profile_content'],
            'mem_usertype' => $userinfo['mem_usertype'],
            'mem_nickname' => $userinfo['mem_nickname'],
            'mem_photo' => $userinfo['mem_photo'],
        );

        $result = array(
            'UserInfo' => $userinfo,
            'OrderDetails' => $this->Beatsomeone_mypage_model->getOrderDetails($mem_id),
            'ProductDetails' => $this->Beatsomeone_mypage_model->getProductDetails($mem_id),
            'ExpiredSoon' => $this->Beatsomeone_mypage_model->getExpiredSoon($mem_id),
            'RecentlyListen' => $this->Beatsomeone_mypage_model->getRecentlyListen($mem_id),
            'Message' => $this->Beatsomeone_mypage_model->getMessage($mem_id),
            'SupportCase' => $this->Beatsomeone_mypage_model->getSupportCase($mem_id),
            'SettlementOverview' => $this->Beatsomeone_mypage_model->getSettlementOverview($mem_id),
            'Chart' => $this->Beatsomeone_mypage_model->getChart($mem_id),
        );

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    /**
     * 개인정보 변경 : 사용자이름 중복 확인
     */
    public function checkDuplicateMemUsername()
    {
        $mem_username = $this->input->post('mem_username');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');

        $result = $this->Beatsomeone_mypage_model->checkDuplicateMemUsername($mem_id,$mem_username);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경 : 사용자이름 변경
     */
    public function updateMemUsername()
    {
        $mem_username = $this->input->post('mem_username');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');

        $result = $this->Beatsomeone_mypage_model->updateMemUsername($mem_id,$mem_username);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경 : 이메일 중복 확인
     */
    public function checkDuplicateEmail()
    {
        $mem_email = $this->input->post('mem_email');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');

        $result = $this->Beatsomeone_mypage_model->checkDuplicateEmail($mem_id,$mem_email);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    /**
     * 개인정보 변경 : 이메일 변경
     */
    public function updateEmail()
    {
        $mem_email = $this->input->post('mem_email');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');

        $result = $this->Beatsomeone_mypage_model->updateEmail($mem_id,$mem_email);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경
     */
    public function updateUserInfo()
    {
        $mem_id = $this->member->item('mem_id');
        $param = array(
            'mem_type' => $this->input->post('mem_type'),
            'mem_firstname' => $this->input->post('mem_firstname'),
            'mem_lastname' => $this->input->post('mem_lastname'),
            'mem_address1' => $this->input->post('mem_address1'),
            'mem_profile_content' => $this->input->post('mem_profile_content'),
        );

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');

        $result = $this->Beatsomeone_mypage_model->updateUserInfo($mem_id,$param);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경 : 패스워드 변경 : 패스워드 확인
     */
    public function checkCompareUserPassword()
    {
        $pwdOriginal = $this->input->post('pwdOriginal');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        if ( ! function_exists('password_hash')) {
            $this->load->helper('password');
        }

        $this->load->model('Member_model');
        $user = $this->Member_model->get_by_memid($mem_id);

        $result = null;

        if(!password_verify($pwdOriginal, element('mem_password', $user))) {
            $result = array(
                'result' => false,
            );
        } else {
            $result = array(
                'result' => true,
            );
        }

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경 : 패스워드 변경 : 패스워드 업데이트
     */
    public function updateUserPassword()
    {
        $pwdOriginal = $this->input->post('pwdOriginal');
        $pwdChange = $this->input->post('pwdChange');
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        if ( ! function_exists('password_hash')) {
            $this->load->helper('password');
        }

        $this->load->model('Member_model');
        $user = $this->Member_model->get_by_memid($mem_id);

        $result = null;

        if(!password_verify($pwdOriginal, element('mem_password', $user))) {
            $result = array(
                'result' => false,
            );
        } else {
            $this->load->model('Beatsomeone_mypage_model');

            $param = array(
                'mem_password' => password_hash($pwdChange, PASSWORD_BCRYPT),
            );

            $this->Beatsomeone_mypage_model->updateUserPassword($mem_id,$param);

            $result = array(
                'result' => true,
            );
        }

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     * 개인정보 변경 : 소셜 링크 정보
     */
    public function getSocialLinkInfo()
    {
        $mem_id = $this->member->item('mem_id');

        // 비로그인 사용자 거부
        if(!$mem_id) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_mypage_model');
        $result = $this->Beatsomeone_mypage_model->getSocialLink($mem_id);

        $result = array(
            'facebook' => array_search('facebook', array_column($result, 'soc_type')) > -1  ? $result[array_search('facebook', array_column($result, 'soc_type'))]['update_dt'] : null,
            'twitter' => array_search('twitter', array_column($result, 'soc_type')) > -1 ? $result[array_search('twitter', array_column($result, 'soc_type'))]['update_dt'] : null,
            'google' => array_search('google', array_column($result, 'soc_type')) > -1 ? $result[array_search('google', array_column($result, 'soc_type'))]['update_dt'] : null,
            'naver' => array_search('naver', array_column($result, 'soc_type')) > -1 ? $result[array_search('naver', array_column($result, 'soc_type'))]['update_dt'] : null,
            'kakao' => array_search('kakao', array_column($result, 'soc_type')) > -1 ? $result[array_search('kakao', array_column($result, 'soc_type'))]['update_dt'] : null,
        );

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    public function get_favorites_list()
    {
        required_user_login();

        $view = array();
        $view['view'] = array();

        $this->load->model(array('Cmall_wishlist_model'));

        $findex = $this->Cmall_wishlist_model->primary_key;
        $forder = 'desc';
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;
        $offset = $this->input->post('offset');
        $where = [
            'cmall_wishlist.mem_id' => $this->member->item('mem_id'),
            'cit_status' => 1
        ];
        $result = $this->Cmall_wishlist_model->get_list($limit, $offset, $where, '', $findex, $forder);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result['list']));
    }

    public function store_inquiry()
    {
        required_user_login();

        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $mem_id = $this->member->item('mem_id');


        $this->load->model('Post_model');
        $this->load->model('Board_model');
        $support_board = $this->Board_model->get_one('', '', [
            'brd_key' => 'support'
        ]);

        $data = [
            'brd_id' => $support_board['brd_id'],
            'post_title' => $title,
            'post_content' => $description,
            'mem_id' => $mem_id,
            'post_userid' => $this->member->item('mem_userid'),
            'post_username' => $this->member->item('mem_username'),
            'post_nickname' => $this->member->item('mem_nickname'),
            'post_ip' => $this->input->ip_address(),
            'post_datetime' => cdate('Y-m-d H:i:s'),
            'post_updated_datetime' => cdate('Y-m-d H:i:s'),
            'post_device' => ($this->cbconfig->get_device_type() === 'mobile') ? 'mobile' : 'desktop',
        ];
        $this->Post_model->insert($data);


        $result = [
            'message' => 'Success',
        ];
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function get_inquiry_list() {
        required_user_login();

        $mem_id = (int) $this->member->item('mem_id');

        $this->load->model('Post_model');
        $this->load->model('Board_model');
        $support_board = $this->Board_model->get_one('', '', [
            'brd_key' => 'support'
        ]);

        $result = $this->Post_model->get_post_list('', '', [
            'brd_id' => $support_board['brd_id'],
            'post.mem_id' => $mem_id
        ]);
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function updateAvatar() {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_membermodify_modify';
        $this->load->event($eventname);

        required_user_login();

        $this->load->library('upload');
        $uploadconfig = array();
        $result = false;
        if (isset($_FILES) && isset($_FILES['mem_photo']) && isset($_FILES['mem_photo']['name']) && $_FILES['mem_photo']['name']) {
            $upload_path = config_item('uploads_dir') . '/member_photo/';
            if (is_dir($upload_path) === false) {
                mkdir($upload_path, 0707);
                $file = $upload_path . 'index.php';
                $f = @fopen($file, 'w');
                @fwrite($f, '');
                @fclose($f);
                @chmod($file, 0644);
            }
            $upload_path .= cdate('Y') . '/';
            if (is_dir($upload_path) === false) {
                mkdir($upload_path, 0707);
                $file = $upload_path . 'index.php';
                $f = @fopen($file, 'w');
                @fwrite($f, '');
                @fclose($f);
                @chmod($file, 0644);
            }
            $upload_path .= cdate('m') . '/';
            if (is_dir($upload_path) === false) {
                mkdir($upload_path, 0707);
                $file = $upload_path . 'index.php';
                $f = @fopen($file, 'w');
                @fwrite($f, '');
                @fclose($f);
                @chmod($file, 0644);
            }

            $uploadconfig['upload_path'] = $upload_path;
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['max_size'] = '2000';
            $uploadconfig['max_width'] = '1000';
            $uploadconfig['max_height'] = '1000';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);
            $updatedata = array();
            $updatephoto = null;
            if ($this->upload->do_upload('mem_photo')) {
                $img = $this->upload->data();
                $updatephoto = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
            } else {
                $file_error = $this->upload->display_errors();
            }
            if ($updatephoto) {
                $updatedata['mem_photo'] = base_url(). config_item('uploads_dir') . '/member_photo/' . $updatephoto;
            }
            $getdata = $this->member;
            if (element('mem_photo', $getdata) && $updatephoto) {
                // 기존 파일 삭제
                @unlink(config_item('uploads_dir') . '/member_photo/' . element('mem_photo', $getdata));
            }
            $this->load->model('Member_model');
            $mem_id = (int) $this->member->item('mem_id');
            $result = $this->Member_model->update($mem_id, $updatedata);
        }

        $this->output->set_content_type('text/json');
        if ($result) {
            $result = [
                'avatar' => $updatedata['mem_photo']
            ];
            $this->output->set_output(json_encode($result));
        } else {
            $this->output->set_status_header(400);
        }
    }
}