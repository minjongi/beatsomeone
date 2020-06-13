<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Beatsomeone API class
 *
 * Copyright (c) Inpreter
 * Cmall 기반 음원거래 사이트 API
 *
 * @author Inpreter (empicy@gmail.com)
 */

/**
 * Beatsomeone API
 */
class BeatsomeoneApi extends CB_Controller
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

	// 메인페이지 목록 조회
    public function main_list($genre = '')
    {

        $this->load->model('Beatsomeone_model');

        // DB Querying (장르별 Top 5)
        $config = array(
            'cit_type1' => '1',
            'limit' => '4',
            'genre' => urldecode($genre),
            'bpm' => $this->input->get('bpm'),
            'sort' => $this->input->get('sort'),
            'voice' => $this->input->get('voice'),

        );
        $result = $this->Beatsomeone_model->get_main_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // Detail 조회
    public function detail_item()
    {

        $this->load->model('Beatsomeone_model');

        // DB Querying (장르별 Top 5)
        $config = array(
            'cit_id' => $this->input->get('cit_id'),

        );
        $result = $this->Beatsomeone_model->get_detail($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 음악 다운로드 수 증가
    public function increase_music_count()
    {

        $this->load->model('Beatsomeone_model');

        $config = array(
            'cde_id' => $this->input->post('cde_id') ,
        );
        $result = $this->Beatsomeone_model->increase_download_count($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 메인페이지 Trending 목록 조회
    public function main_trending_list()
    {

        $this->load->model('Beatsomeone_model');

        // DB Querying (Trending)
        $config = array(
            'limit' => '10',
        );
        $result = $this->Beatsomeone_model->get_main_trending_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 메인페이지 TESTIMONIALS 목록 조회
    public function main_testimonials_list()
    {

        $this->load->model('Beatsomeone_model');

        // DB Querying (Trending)
        $config = array(
            'limit' => '3',
        );
        $result = $this->Beatsomeone_model->get_main_trending_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // sublist 목록 조회
    public function sublist_list()
    {

        $this->load->model('Beatsomeone_model');


        $config = array(
            'limit' =>  $this->input->post('limit') ,
            'offset' =>  $this->input->post('offset') ,
            'sort' =>  $this->input->post('sort') ,
            'search' =>  $this->input->post('search') ,
            'genre' =>  $this->input->post('genre') ,
            'subgenre' =>  $this->input->post('subgenre') ,
            'bpmFr' =>  $this->input->post('bpmFr') ,
            'bpmTo' =>  $this->input->post('bpmTo') ,
            'moods' =>  $this->input->post('moods') ,
            'trackType' =>  $this->input->post('trackType') ,
            'mem_id' => $this->member->item('mem_id'),
        );

        $result = $this->Beatsomeone_model->get_sublist_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // sublist Top 5 조회
    public function sublist_top_list($genre = '')
    {

        $this->load->model('Beatsomeone_model');


        $config = array(
            'sort' =>  $this->input->post('sort') ,
            'search' =>  $this->input->post('search') ,
            'genre' =>  $this->input->post('genre') ,
            'subgenre' =>  $this->input->post('subgenre') ,
            'bpmFr' =>  $this->input->post('bpmFr') ,
            'bpmTo' =>  $this->input->post('bpmTo') ,
            'moods' =>  $this->input->post('moods') ,
            'trackType' =>  $this->input->post('trackType') ,
            'limit' => $this->input->post('limit') ,
        );
        $result = $this->Beatsomeone_model->get_sublist_top5_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 회원별 음원 등록수 조회
    public function item_reg_count()
    {
        $this->load->model('Beatsomeone_model');
        $totalCount = $this->Beatsomeone_model->get_item_reg_count_by_mem_id($this->member->item('mem_id'));
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode(['count' => intval($totalCount)]));
    }

    // 연관음반 추가 대상 조회
    public function search_item_list_for_addRelation()
    {

        $this->load->model('Beatsomeone_model');


        $config = array(
            'cit_id' =>  $this->input->post('cit_id') ,
            'title' =>  $this->input->post('title') ,
            'musician' =>  $this->input->post('musician') ,
            'mem_id' => $this->member->item('mem_id'),
        );

        $result = $this->Beatsomeone_model->get_item_list_for_addRelation($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }







    // detail similar tracks 조회
    public function detail_similartracks_list($cit_id = '')
    {
        $this->load->model('Beatsomeone_model');


        $config = array(
            'limit' =>  $this->input->post('limit') ,
            'offset' =>  $this->input->post('offset') ,
            'cit_id' => $cit_id,
            'mem_id' => $this->member->item('mem_id'),
        );
        log_message('debug','$cit_id : ' . $cit_id);
        log_message('debug','$CONFIG : ' . print_r($config,true));
        $result = $this->Beatsomeone_model->get_relation_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 음반 기타정보 조회
    public function get_item_infomation($cit_id = '')
    {
        $this->load->model('Beatsomeone_model');


        $config = array(
            'cit_id' => $cit_id,
        );
        $result = $this->Beatsomeone_model->get_item_infomation($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // mypage 내음원 목록 조회
    public function get_user_regist_item_list()
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }


        $this->load->model('Beatsomeone_model');

        $config = array(
            'mem_id' => $this->member->item('mem_id'),
        );
        $result = $this->Beatsomeone_model->get_user_regist_item_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // mypage 음원 조회
    public function get_item($cit_id = '')
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_model');

        $config = array(
            'cit_id' => $cit_id,
        );
        $result = $this->Beatsomeone_model->get_item($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // mypage 판매내역 조회
    public function get_status_item_list()
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_model');

        $config = array(
            'mem_id' => $this->member->item('mem_id'),
        );
        $result = $this->Beatsomeone_model->get_user_regist_item_list($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }



    // Comment 추가
    public function add_comment()
    {
        $this->load->model('Cmall_qna_model');

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $content_type = $this->cbconfig->item('use_cmall_product_qna_dhtml') ? 1 : 0;
        $cqa_secret = $this->input->post('cqa_secret') ? 1 : 0;
        $cqa_receive_email = $this->input->post('cqa_receive_email') ? 1 : 0;
        $cqa_receive_sms = $this->input->post('cqa_receive_sms') ? 1 : 0;

        $updatedata = array(
            'cit_id' => $this->input->post('cit_id', null, ''),
            'cqa_title' => $this->input->post('cqa_title', null, ''),
            'cqa_content' => $this->input->post('cqa_content', null, ''),
            'cqa_content_html_type' => $content_type,
            'cqa_secret' => $cqa_secret,
            'cqa_receive_email' => $cqa_receive_email,
            'cqa_receive_sms' => $cqa_receive_sms,
            'cqa_datetime' => cdate('Y-m-d H:i:s'),
            'mem_id' => $this->member->item('mem_id'),
            'cqa_ip' => $this->input->ip_address(),

        );


        $_cqa_id = $this->Cmall_qna_model->insert($updatedata);


        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($_cqa_id));
    }

    // Item Share Count 증가
    public function increase_item_share_count()
    {
        $this->load->model('Beatsomeone_model');

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }


        $updatedata = array(
            'cit_id' => $this->input->post('cit_id', null, ''),
        );

        $result = $this->Beatsomeone_model->increase_item_share_count($updatedata);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 등록 비용 플랜 조회
    public function get_register_plan_cost()
    {
        $this->load->model('Beatsomeone_model');

        $result = $this->Beatsomeone_model
            ->get_register_plan_cost();

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    // Comment 조회
    public function list_comment($cit_id = '')
    {
        $this->load->model('Beatsomeone_model');

        $config['cit_id'] = $cit_id;

        $result = $this->Beatsomeone_model
            ->get_comment_list($config);


        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 연관 음원 조회
    public function list_relation()
    {
        $this->load->model('Cmall_item_relation_model');

        $config = array();
        $config['cit_id'] = $this->input->post('cit_id', null, '');

        $result = $this->Cmall_item_relation_model
            ->get_relation_list($config);


        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    /**
     *  연관음원 추가
     */
    public function add_relation() {

        $this->load->model('Cmall_item_relation_model');

        $config = array(
            'cit_id' => $this->input->post('cit_id') ,
            'cit_id_r' => $this->input->post('cit_id_r') ,
        );
        $result = $this->Cmall_item_relation_model->add_relation($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    /**
     *  연관음원 삭제
     */
    public function remove_relation() {

        $this->load->model('Cmall_item_relation_model');

        $config = array(
            'cir_id' => $this->input->post('cir_id')
        );
        $result = $this->Cmall_item_relation_model->remove_relation($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }



    // GUID 생성
    private function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = ''
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }
    }



    // 사용자 상품 등록
    public function merge_item()
    {
        // Check Login
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        // Load Module
        $this->load->model('Beatsomeone_model','Beatsomeone_model');
        $this->load->model('Member_model','Member_model');

        // 파일 UPLOAD
        $this->load->library('upload');

        // Form Parse
        $form = array(
            'cit_id' => $this->input->post('cit_id'),
            'cit_key' => $this->input->post('cit_key'),
            'cit_name' => $this->input->post('cit_name'),
            'hashTag' => $this->input->post('hashTag'),
            'trackType' => $this->input->post('trackType'),
            'cit_start_datetime' => $this->input->post('cit_start_datetime'),
            'linkUrl' => $this->input->post('linkUrl'),
            'licenseLeaseUseYn' => $this->input->post('licenseLeaseUseYn') === 'true' ? 1 : 0,
            'licenseLeasePriceKRW' => $this->input->post('licenseLeasePriceKRW'),
            'licenseLeasePriceUSD' => $this->input->post('licenseLeasePriceUSD'),
            'licenseLeaseQuantity' => $this->input->post('licenseLeaseQuantity'),
            'licenseStemUseYn' => $this->input->post('licenseStemUseYn') === 'true' ? 1 : 0,
            'licenseStemPriceKRW' => $this->input->post('licenseStemPriceKRW'),
            'licenseStemPriceUSD' => $this->input->post('licenseStemPriceUSD'),
            'licenseStemQuantity' => $this->input->post('licenseStemQuantity'),
            'genre' => $this->input->post('genre'),
            'subgenre' => $this->input->post('subgenre'),
            'moods' => $this->input->post('moods'),
            'bpm' => $this->input->post('bpm'),
            'cit_content' => $this->input->post('cit_content'),
            'unTaggedFile' => $this->input->post('unTaggedFile'),
            'stemFile' => $this->input->post('stemFile'),
            'streamingFile' => $this->input->post('streamingFile'),
            'artwork' => $this->input->post('artwork'),
            'cde_id' => $this->input->post('cde_id'),
            'cde_id_2' => $this->input->post('cde_id_2'),
            'cde_id_3' => $this->input->post('cde_id_3'),
            "mem_id" => $this->member->item('mem_id'),
            "mem_userid" => element('mem_userid',$this->Member_model->get_by_memid($this->member->item('mem_id'), 'mem_userid')),
            "ip" => $this->input->ip_address()
        );

        $jsonDataList = ['unTaggedFile', 'stemFile', 'streamingFile', 'artwork'];
        foreach ($jsonDataList as $key) {
            $form[$key] = empty($form[$key]) ? [] : json_decode($form[$key], true);
        }

        if (!empty($form['hashTag'])) {
            $tmpHashTag = [];
            $hashTag = explode(',', $form['hashTag']);
            foreach ($hashTag as $val) {
                $tmpHashTag[] = trim($val);
            }
            $form['hashTag'] = array_unique($tmpHashTag);
        }

        log_message('debug',print_r($form,true));

        $result = $this->Beatsomeone_model->merge_item($form);

        // Reponse
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    // 상품 파일 업로드 (음원)
    public function upload_item_file()
    {
        // Check Login
        if (!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $result = $this->upload_file('cmallitemdetail', 'wav|mp3|zip|rar');

        // Reponse
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 표지 파일 업로드 (artwork)
    public function upload_artwork_file()
    {
        // Check Login
        if (!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $result = $this->upload_file('cmallitem', 'gif|jpg|png');

        // Reponse
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 파일 업로드
    private function upload_file($baseDir, $allowedTypes)
    {
        // 파일 UPLOAD
        $this->load->library('upload');

        // 음원 파일 업로드
        $filename = 'file';
        $upload_path = config_item('uploads_dir') . '/' . $baseDir . '/';
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

        $uploadconfig = array();
        $uploadconfig['upload_path'] = $upload_path;
        $uploadconfig['allowed_types'] = $allowedTypes;
        $uploadconfig['encrypt_name'] = true;

        $this->upload->initialize($uploadconfig);

        if ($this->upload->do_upload($filename)) {
            $filedata = $this->upload->data();

            // 상세 정보 저장
            $result['filename'] = str_replace(config_item('uploads_dir') . '/' . $baseDir . '/', '', $upload_path) . '/' . element('file_name', $filedata);
            $result['originname'] = element('orig_name', $filedata);
            $result['filesize'] = intval(element('file_size', $filedata) * 1024);
            $result['type'] = str_replace('.', '', element('file_ext', $filedata));
            $result['is_image'] = element('is_image', $filedata) ? element('is_image', $filedata) : 0;
        } else {
            $result['code'] = 'error';
            $result['msg'] = 'ERROR FROM UPLOAD';
        }

        return $result;
    }

    // 관심 항목 추가
    public function toggle_wish_item($cit_id = '')
    {
        /**
         * Data Querying
         */
        $this->load->model('Cmall_item_model');

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $config = array(
            'cit_id' => $cit_id,
        );

        $result = $this->Cmall_item_model->toggle_wish_item($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    // 카트 금액 합산 얻기
    public function getCartSum() {

        $this->load->model('Cmall_cart_model');

        $param =& $this->querystring;
        $findex = 'cmall_item.cit_id';
        $forder = 'desc';

        $mem_id = (int) $this->member->item('mem_id');

        $where = array();
        $where['cmall_cart.mem_id'] = $mem_id;
        $result = $this->Cmall_cart_model->get_cart_list($where, $findex, $forder);
        if ($result) {
            foreach ($result as $key => $val) {
                $result[$key]['detail'] = $this->Cmall_cart_model
                    ->get_cart_detail($mem_id, element('cit_id', $val));
            }
        }

//        log_message('debug','$result : '. print_r($result,true));
//
//        $vs = $this->cmalllib->get_my_cart(1000);
        $s = 0;
        foreach($result as $v) {
//            log_message('debug','ITEM : '. print_r($v,true));
            $s += element('cit_price', $v);

            foreach (element('detail', $v) as $d) {
                $s += element('cde_price', $d);
//                log_message('debug','DETAIL : '. print_r($d,true));
            }
        }
        echo json_encode($s);
        return false;
    }
    
    // 음원 관련 액션
    public function itemAction() {

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $mem_id = (int) $this->member->item('mem_id');

        //$param =  json_encode($this->input->get_post(null));
        //log_message('debug','############################ : ' . print_r($this->input->post('detail_qty'),true));

        // 구매 혹은 장바구니 담기
        // stype : order / cart
        if ($this->input->post('stype')) {
            // 로그인 여부 확인
            if ( ! $mem_id) {
                $this->session->set_flashdata(
                    'message',
                    '로그인 후 이용이 가능합니다'
                );
                return false;
            }

            // 주문 상품 번호 확인
            $cit_id = (int) $this->input->post('cit_id');
            if (empty($cit_id) OR $cit_id < 1) {
                echo json_encode(false);
                return false;
            }

            // 위시 리스트 담기
            if ($this->input->post('stype') === 'wish') {
                $return = $this->cmalllib->addwish($mem_id, $cit_id);
                echo json_encode($return);
            }
            // 장바구니 담기
            elseif ($this->input->post('stype') === 'cart'
                && $this->input->post('chk_detail')
                && is_array($this->input->post('chk_detail'))
                && $this->input->post('detail_qty')) {

                log_message('debug','CART IN START!!!' );

                $return = $this->cmalllib->addcart(
                    $mem_id,
                    $cit_id,
                    $this->input->post('chk_detail'),
                    $this->input->post('detail_qty')
                );
                echo json_encode($return);

            }
            // 바로구매
            elseif ($this->input->post('stype') === 'order'
                && $this->input->post('chk_detail')
                && is_array($this->input->post('chk_detail'))
                && $this->input->post('detail_qty')) {
                $return = $this->cmalllib->addorder(
                    $mem_id,
                    $cit_id,
                    $this->input->post('chk_detail'),
                    $this->input->post('detail_qty')
                );
                return $return;
            }
            //  장바구니 금액 합산
            elseif ($this->input->post('stype') === 'get_cart_sum') {
                $vs = $this->cmalllib->get_my_cart(1000);
                $s = 0;
                foreach($vs as $v) {
                    $s += element('cit_price', $v);
                }
                echo json_encode($s);
                return ;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }



    // mypage 멤버 정보 조회
    public function get_user_info()
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model('Beatsomeone_model');

        $config = array(
            'mem_id' => $this->member->item('mem_id'),
        );
        $result = $this->Beatsomeone_model->get_user_info($config);

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function get_user_cart_list()
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model(array('Cmall_cart_model', 'Beatsomeone_model'));
        $mem_id = (int) $this->member->item('mem_id');

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */

        $param =& $this->querystring;
        $findex = 'cmall_item.cit_id';
        $forder = 'desc';
        $where = array();
        $where['cmall_cart.mem_id'] = $mem_id;
        $result = $this->Cmall_cart_model->get_cart_list($where, $findex, $forder);
        if ($result) {
            foreach ($result as $key => $val) {
                $result[$key]['item_url'] = cmall_item_url(element('cit_key', $val));
                //$result[$key]['detail'] = $this->Cmall_cart_model->get_cart_detail($mem_id, element('cit_id', $val));
                $result[$key]['detail'] = $this->Beatsomeone_model->get_product_info(element('cit_id', $val));
                //log_message('error', print_r($result[$key]['detail'],true) );
            }
        }
        //log_message('error', var_dump($result));
        //$result['list_delete_url'] = site_url('cmallact/cart_delete/?' . $param->output());

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }

    public function delete_user_cart()
    {
        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model(array('Cmall_cart_model'));
        $chk = json_decode($this->input->post('chk'));

        /**
         * 체크한 게시물의 삭제를 실행합니다
         */
        if ($chk && is_array($chk)) {
            foreach ($chk as $val) {
                if ($val) {
                    $where = array(
                        'mem_id' => $this->member->item('mem_id'),
                        'cit_id' => $val,
                        'cct_cart' => 1,
                    );
                    $this->Cmall_cart_model->delete_where($where);
                }
            }
        }
        $this->session->set_flashdata(
            'message',
            '정상적으로 삭제되었습니다'
        );
        $result = array();
        $result['message'] = '정상적으로 삭제되었습니다';
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }


    public function user_cart_to_order(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model(array('Cmall_cart_model'));

        $mem_id = (int) $this->member->item('mem_id');
        $chk = json_decode($this->input->post('chk'));

        $rst = array();

        if ($chk) {
            $cit_id = $chk;
            $return = $this->cmalllib->cart_to_order(
                $mem_id,
                $cit_id
            );
            $rst['result'] = $return;
        }

        $rst['message'] = 'ok';
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }

    public function user_order_list(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }

        $this->load->model(array('Cmall_cart_model'));
        $mem_id = (int) $this->member->item('mem_id');

        $this->load->model('Beatsomeone_model');
        $config = array(
            'mem_id' => $mem_id,
        );
        $mem_result = $this->Beatsomeone_model->get_user_info($config);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $findex = 'cmall_item.cit_id';
        $forder = 'desc';

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array();
        $where['cmall_cart.mem_id'] = $mem_id;
        $result = $this->Cmall_cart_model->get_order_list($where, $findex, $forder);
        $good_name = '';
        $good_count = -1;
        $session_cct_id = array();
        if ($result) {
            foreach ($result as $key => $val) {
                $result[$key]['item_url'] = cmall_item_url(element('cit_key', $val));
                //$result[$key]['detail'] = $this->Cmall_cart_model->get_order_detail($mem_id, element('cit_id', $val));
                $result[$key]['detail'] = $this->Beatsomeone_model->get_product_info(element('cit_id', $val));
                if (empty($good_name)) {
                    $good_name = element('cit_name', $val);
                }
                $good_count ++;
                $session_cct_id[] = element('cct_id', $val);
            }
        }

        $this->load->model('Unique_id_model');
        $unique_id = $this->Unique_id_model->get_id($this->input->ip_address());
        if ($good_count > 0) {
            $good_count .= ' 외 ' . $good_count . '건';
        }
        $this->session->set_userdata(
            'unique_id',
            $unique_id
        );
        $this->session->set_userdata(
            'order_cct_id',
            implode('-', $session_cct_id)
        );
        
        $rst = array();
        $rst['message'] = 'ok';
        $rst['result'] = $result;
        $rst['mem_result'] = $mem_result;
        $rst['good_count'] = $good_count;
        $rst['good_name'] = $good_name;
        $rst['unique_id'] = $unique_id;
        
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }

    public function user_order_update(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }
        $mem_id = (int) $this->member->item('mem_id');

        log_message('error', 'post : ' . print_r($this->input->post(), true));
        log_message('error', 'mem_id : ' .$mem_id );
        log_message('error', 'unique_id : ' .$this->session->userdata('unique_id') );
        log_message('error', 'order_cct_id : ' .$this->session->userdata('order_cct_id') );
        

        /*
        $bigInt = gmp_init($this->input->post('unique_id'));
        $unique_id = gmp_intval($bigInt);
        log_message('error', 'unique_id : ' .$unique_id );
        if ( ! $this->session->userdata('unique_id') 
                OR ! $this->input->post('unique_id') 
                OR $this->session->userdata('unique_id') !== $this->input->post('unique_id')) {
            alert('잘못된 접근입니다 111');
        }*/

        if ( ! $this->session->userdata('unique_id')) {
            alert('잘못된 접근입니다');
        }

        if ( ! $this->session->userdata('order_cct_id')) {
            alert('잘못된 접근입니다');
        }

        $this->load->model('Cmall_cart_model');
        $where = array();
        $where['cmall_cart.mem_id'] = $mem_id;
        $findex = 'cmall_item.cit_id';
        $forder = 'desc';
        $session_cct_id = array();

        $good_mny = $this->input->post('good_mny', null, 0);    //request 값으로 받은 값
        $item_cct_price = 0;        //주문한 상품의 총 금액의 초기화


        $orderlist = $this->Cmall_cart_model->get_order_list($where, $findex, $forder);
        if ($orderlist) {
            foreach ($orderlist as $key => $val) {
                $details = $this->Cmall_cart_model->get_order_detail($mem_id, element('cit_id', $val));

                if( !empty($details) ){
                    foreach((array) $details as $detail ){
                        if( empty($detail) ) continue;

                        $item_cct_price += ((int) element('cit_price', $val) + (int) element('cde_price', $detail)) * element('cct_count', $detail);
                    }
                }

                $session_cct_id[] = element('cct_id', $val);
            }
        }

        if ( $item_cct_price != $good_mny ){
        }


        if ( ! is_numeric($this->input->post('total_price_sum'))) {
            alert('총 결제금액의 값은 숫자만 와야 합니다');
        }
        $total_price_sum = (int) $this->input->post('total_price_sum');
        $usePoint = (int) $this->input->post('usePoint');
        log_message('error', 'total_price_sum : ' .$total_price_sum );
        log_message('error', 'usePoint : ' .$usePoint );


        $this->load->library('paymentlib');

        $insertdata = array();
        $result = '';
        $od_status = 'order'; //주문상태

        $order_deposit = 0;
        $cor_cash = 0;

        //무통장입금
        $insertdata['cor_datetime'] = date('Y-m-d H:i:s');
        $insertdata['mem_realname'] = $this->input->post('mem_realname', null, '');
        $insertdata['cor_total_money'] = $total_price_sum;
        $insertdata['cor_cash_request'] = $this->input->post('good_mny', null, 0);
        $insertdata['cor_deposit'] = $order_deposit;
        $insertdata['cor_cash'] = 0;
        if ( ((int) $item_cct_price - (int) $order_deposit ) != 0 ) {
            $insertdata['cor_status'] = 0;
            $insertdata['cor_approve_datetime'] = null;
        } else {
            $insertdata['cor_status'] = 1;
            $insertdata['cor_approve_datetime'] = date('Y-m-d H:i:s');
            $od_status = 'deposit'; //주문상태
        }

        if ( ((int) $item_cct_price - (int) $order_deposit - $cor_cash) == 0 ) {
            $od_status = 'deposit'; //주문상태
        }


        // 정보 입력
        $cor_id = $this->session->userdata('unique_id');
        $insertdata['cor_id'] = $cor_id;
        $insertdata['mem_id'] = $mem_id;
        $insertdata['mem_nickname'] = $this->member->item('mem_nickname');
        $insertdata['mem_email'] = $this->input->post('mem_email', null, '');
        $insertdata['mem_phone'] = $this->input->post('mem_phone', null, '');
        $insertdata['cor_pay_type'] = $this->input->post('pay_type', null, '');
        $insertdata['cor_content'] = $this->input->post('cor_content', null, '');
        $insertdata['cor_ip'] = $this->input->ip_address();
        $insertdata['cor_useragent'] = $this->agent->agent_string();
        $insertdata['is_test'] = $this->cbconfig->item('use_pg_test');
        $insertdata['status'] = $od_status;

        $this->load->model(array('Cmall_item_model', 'Cmall_order_model', 'Cmall_order_detail_model'));
        $res = $this->Cmall_order_model->insert($insertdata);
        if ($res) {
            $cwhere = array(
                'mem_id' => $mem_id,
                'cct_order' => 1,
            );
            $cartorder = $this->Cmall_cart_model->get('', '', $cwhere);
            if ($cartorder) {
                foreach ($cartorder as $key => $val) {
                    $item = $this->Cmall_item_model
                        ->get_one(element('cit_id', $val), 'cit_download_days');
                    $insertdetail = array(
                        'cor_id' => $cor_id,
                        'mem_id' => $mem_id,
                        'cit_id' => element('cit_id', $val),
                        'cde_id' => element('cde_id', $val),
                        'cod_download_days' => element('cit_download_days', $item),
                        'cod_count' => element('cct_count', $val),
                        'cod_status' => $od_status,
                    );
                    log_message('error', print_r($insertdetail, true) );
                    $this->Cmall_order_detail_model->insert($insertdetail);
                    $deletewhere = array(
                        'mem_id' => $mem_id,
                        'cit_id' => element('cit_id', $val),
                        'cde_id' => element('cde_id', $val),
                    );
                    $this->Cmall_cart_model->delete_where($deletewhere);
                }
            }
        }

        /*
        if ($this->input->post('pay_type') === 'bank') {
            $this->cmalllib->orderalarm('bank_to_contents', $cor_id);
        } else {
            $this->cmalllib->orderalarm('cash_to_contents', $cor_id);
        }
        */

        $this->session->set_userdata('unique_id', '');
        $this->session->set_userdata('order_cct_id', '');

        $rst = array();
        $rst['message'] = 'ok';
        $rst['cor_id'] = $cor_id;
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }


    public function user_order_result(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }
        $mem_id = (int) $this->member->item('mem_id');
        //log_message('error', var_dump($this->input->post(), true) );
        $cor_id = $this->input->post("cor_id");

        $this->load->model(array('Cmall_item_model', 'Cmall_order_model', 'Cmall_order_detail_model'));

        $order = $this->Cmall_order_model->get_one($cor_id);
        $orderdetail = $this->Cmall_order_detail_model->get_by_item($cor_id);
        if ($orderdetail) {
            foreach ($orderdetail as $key => $value) {
                $orderdetail[$key]['item'] = $item
                    = $this->Cmall_item_model->get_one(element('cit_id', $value));
                $orderdetail[$key]['itemdetail'] = $itemdetail
                    = $this->Cmall_order_detail_model
                    ->get_detail_by_item($cor_id, element('cit_id', $value));

                $orderdetail[$key]['item']['possible_download'] = 1;
                if (element('cod_download_days', element(0, $itemdetail)) && element('cor_approve_datetime', $order)) {
                    $endtimestamp = strtotime(element('cor_approve_datetime', $order))
                        + 86400 * element('cod_download_days', element(0, $itemdetail));
                    $orderdetail[$key]['item']['download_end_date'] = $enddate
                        = cdate('Y-m-d', $endtimestamp);

                    $orderdetail[$key]['item']['possible_download'] = ($enddate >= date('Y-m-d')) ? 1 : 0;
                }
            }
        }
        if (element('cor_status', $order) === '1') {
            $this->session->set_userdata(
                'cmall_item_download_' . element('cor_id', $order),
                '1'
            );
        }


        $rst = array();
        $rst['message'] = 'ok';
        $rst['cor_id'] = $cor_id;
        $rst['order'] = $order;
        $rst['orderdetail'] = $orderdetail;
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }


    public function musician_sales_history(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }
        $mem_id = (int) $this->member->item('mem_id');

        $this->load->model('Beatsomeone_model');

        $config = array(
            'mem_id' => $this->member->item('mem_id'),
        );
        $cor_id_list = $this->Beatsomeone_model->get_sales_history($config);
        log_message('error', print_r($cor_id_list, true) );

        $sp_list = array();
        foreach( $cor_id_list as $cor_id ){
            $sp_pr_info = $this->Beatsomeone_model->get_sales_price_info($cor_id);
            $sp_info = $this->Beatsomeone_model->get_sales_product_info($cor_id);
            foreach ( $sp_info as $sp ){
                foreach ( $sp_pr_info as $sp_pr ){
                    $sp['cor_memo'] = $sp_pr['cor_memo'];
                    $sp['cor_total_money'] = $sp_pr['cor_total_money'];
                }
                array_push($sp_list, $sp);
            }
        }
        log_message('error', print_r($sp_list, true) );

        $rst = array();
        $rst['message'] = 'ok';
        $rst['sp_list'] = $sp_list;
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }


    public function user_order_history(){

        // 비로그인 사용자 거부
        if(!$this->member->item('mem_id')) {
            $this->output->set_status_header('412');
            return;
        }
        $mem_id = (int) $this->member->item('mem_id');

        $this->load->model('Beatsomeone_model');

        $config = array(
            'mem_id' => $this->member->item('mem_id'),
        );
        $cor_id_list = $this->Beatsomeone_model->get_order_history($config);
        log_message('error', print_r($cor_id_list, true) );

        $sp_list = array();
        foreach( $cor_id_list as $val ){
            $sp_info = $this->Beatsomeone_model->get_sales_product_info($val);
            $temp = new stdClass();
            $temp->id = $val['cor_id'];
            $temp->size = count($sp_info);
            $temp->items = $sp_info;
            array_push($sp_list, $temp);
        }
        log_message('error', print_r($sp_list, true) );

        $rst = array();
        $rst['message'] = 'ok';
        $rst['sp_list'] = $sp_list;
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($rst));
    }


}