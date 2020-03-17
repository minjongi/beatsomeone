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

        $this->load->model('Cmall_item_model');

        // DB Querying (장르별 Top 5)
        $config = array(
            'cit_type1' => '1',
            'limit' => '4',
            'genre' => urldecode($genre),
        );
        $result = $this->Cmall_item_model->get_main_list($config);

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