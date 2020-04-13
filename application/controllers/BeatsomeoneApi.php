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
            'cit_id' => $cit_id,
            'mem_id' => $this->member->item('mem_id'),
        );
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

        // 커버 파일 UPLOAD
        $this->load->library('upload');

        log_message('debug','$_FILES : ' . print_r(json_encode($_FILES),true));
        $cit_file = null;
        if (isset($_FILES) && isset($_FILES['cover_image']) && isset($_FILES['cover_image']['name']) && $_FILES['cover_image']['name']) {
            $upload_path = config_item('uploads_dir') . '/cmallitem/';
            log_message('debug','$upload_path : ' . $upload_path);
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
            $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
            $uploadconfig['max_size'] = '5000';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);

            if ($this->upload->do_upload('cover_image')) {
                $img = $this->upload->data();
                $cit_file = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
                log_message('debug','UPLOAD SUCCESS : '.$cit_file);
            } else {
                $result = 'IMAGE UPLOAD ERROR';
            }
        }

        // 음원 파일 업로드
        $uploadfiledata = array();

        if (isset($_FILES) && isset($_FILES['music_file_1']) && isset($_FILES['music_file_1']['name']) && $_FILES['music_file_1']['name']) {

            $upload_path = config_item('uploads_dir') . '/cmallitemdetail/';
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
            $uploadconfig['allowed_types'] = '*';
            $uploadconfig['encrypt_name'] = true;

            $this->upload->initialize($uploadconfig);

            if ($this->upload->do_upload('music_file_1')) {
                $filedata = $this->upload->data();

                $uploadfiledata['cde_filename'] = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $filedata);
                $uploadfiledata['cde_originname'] = element('orig_name', $filedata);
                $uploadfiledata['cde_filesize'] = intval(element('file_size', $filedata) * 1024);
                $uploadfiledata['cde_type'] = str_replace('.', '', element('file_ext', $filedata));
                $uploadfiledata['is_image'] = element('is_image', $filedata) ? element('is_image', $filedata) : 0;

            } else {
                log_message('debug','MUSIC FILE UPLOAD FAIL');

                $result = 'ERROR FROM UPLOAD MP3';
            }
        }

        // Form Parse
        $form = array(
            "cit_id" => $this->input->post('cit_id'),
            "cit_name" => $this->input->post('cit_name'),
            "cit_key" => $this->getGUID(),
            "musician" => $this->input->post('musician'),
            "cit_content" => $this->input->post('cit_content'),
            "cit_price" => $this->input->post('cit_price'),
            "genre" => $this->input->post('genre'),
            "bpm" => $this->input->post('bpm'),
            "mem_id" => $this->member->item('mem_id'),
            "mem_userid" => element('mem_userid',$this->Member_model->get_by_memid($this->member->item('mem_id'), 'mem_userid')),
            "ip" => $this->input->ip_address(),
        );

        if($cit_file) {
            $form["cit_file_1"] = $cit_file;
        } else {
            $form["cit_file_1"] = null;
        }
        log_message('debug','$uploadfiledata : '. print_r($uploadfiledata,true));
        if($uploadfiledata) {
            $form["cde_file_1"] = $uploadfiledata;
        }


        log_message('debug',print_r($form,true));

        $result = $this->Beatsomeone_model->merge_item($form);

        log_message('debug','$result');
        log_message('debug',print_r($result,true));

//        if($result) {
//            log_message('debug','UPLOAD START');
//            $this->load->library('upload');
//            $k = 1;
//            log_message('debug','$_FILES : ' . print_r(json_encode($_FILES),true));
//
//            if (isset($_FILES) && isset($_FILES['cit_file_' . $k]) && isset($_FILES['cit_file_' . $k]['name']) && $_FILES['cit_file_' . $k]['name']) {
//                $upload_path = config_item('uploads_dir') . '/cmallitem/';
//                log_message('debug','$upload_path : ' . $upload_path);
//                if (is_dir($upload_path) === false) {
//                    mkdir($upload_path, 0707);
//                    $file = $upload_path . 'index.php';
//                    $f = @fopen($file, 'w');
//                    @fwrite($f, '');
//                    @fclose($f);
//                    @chmod($file, 0644);
//                }
//                $upload_path .= cdate('Y') . '/';
//                if (is_dir($upload_path) === false) {
//                    mkdir($upload_path, 0707);
//                    $file = $upload_path . 'index.php';
//                    $f = @fopen($file, 'w');
//                    @fwrite($f, '');
//                    @fclose($f);
//                    @chmod($file, 0644);
//                }
//                $upload_path .= cdate('m') . '/';
//                if (is_dir($upload_path) === false) {
//                    mkdir($upload_path, 0707);
//                    $file = $upload_path . 'index.php';
//                    $f = @fopen($file, 'w');
//                    @fwrite($f, '');
//                    @fclose($f);
//                    @chmod($file, 0644);
//                }
//
//                $uploadconfig = array();
//                $uploadconfig['upload_path'] = $upload_path;
//                $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
//                $uploadconfig['max_size'] = '5000';
//                $uploadconfig['encrypt_name'] = true;
//
//                $this->upload->initialize($uploadconfig);
//
//                if ($this->upload->do_upload('cit_file_' . $k)) {
//                    $img = $this->upload->data();
//                    $cit_file[$k] = cdate('Y') . '/' . cdate('m') . '/' . element('file_name', $img);
//                } else {
//                    $result = 'IMAGE UPLOAD ERROR';
//                }
//            }
//        }

        // Reponse
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
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

}