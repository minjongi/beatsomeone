<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Beatsomeone model class *
 *
 * Copyright (c) inpreter
 *
 * @author inpreter (empicy@gmail.com)
 */

class Beatsomeone_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cmall_item';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cit_id'; // 사용되는 테이블의 프라이머리키

	public $allow_order = array('cit_order asc', 'cit_datetime desc', 'cit_datetime asc', 'cit_hit desc', 'cit_hit asc', 'cit_review_count desc',
		'cit_review_count asc', 'cit_review_average desc', 'cit_review_average asc', 'cit_price desc', 'cit_price asc', 'cit_sell_count desc');

	function __construct()
	{
		parent::__construct();
	}

	// 메인 페이지 리스트
    public function get_main_list($config)
    {
        $bpm = element('bpm', $config);
        $sort = element('sort', $config);
        $voice = element('voice', $config);
        log_message('debug','Genre : ' . element('genre', $config));
        log_message('debug','Bpm : ' . $bpm);
        log_message('debug','Sort : ' . $sort);
        log_message('debug','Voice : ' . $voice);

        $where['cit_status'] = 1;
        if (element('genre', $config) && element('genre', $config) !== 'All Genre') {
            $where['p.genre'] = element('genre', $config);
        }

        if ($bpm) {
            $where['p.bpm <='] = $bpm + 0;
            $where['p.bpm >='] = $bpm - 10;
        }
        if ($voice == 'true') {
            $where['p.voice'] = 1;
        }

        // 만약 정렬 조건이 없거나 [Sort By Staff Picks] 인경우에는 [상품유형] 이 [추천] 인 경우만 검색
        if(!$sort || $sort == 'Sort By Staff Picks') {
            $where['cmall_item.cit_type1'] = 1;
            $this->db->order_by('cde_download', 'desc');
        }
        // 만약 정렬 조건이 [Newest] 인경우에는 최신 등록 상품 조회
        if($sort == 'Newest') {
            $this->db->order_by('cit_datetime', 'desc');
        }
        // 만약 정렬 조건이 [Top Downloads] 인경우에는 다운로드 수 많은 순 조회
        if($sort == 'Top Downloads') {
            $this->db->order_by('cde_download', 'desc');
        }

        $limit = element('limit', $config) ? element('limit', $config) : 4;
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, p.cde_download, ';
        $select .= ' (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish';
        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($limit);


        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;
    }

    // 디테일 페이지
    public function get_detail($config)
    {
        $cit_key = element('cit_key', $config);
        $cit_id = element('cit_id', $config);

        log_message('debug','cit_key : ' . $cit_key);
        log_message('debug','cit_id : ' . $cit_id);

        if($cit_key) {
            $where['cmall_item.cit_key'] = $cit_key;
        }

        if($cit_id) {
            $where['cmall_item.cit_id'] = $cit_id;
        }


        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('(select q.cit_id, count(*) as cnt from cb_cmall_qna AS q group by q.cit_id) AS q','q.cit_id = cmall_item.cit_id','left');
        // 판매갯수
        $this->db->join('(select cit_id, count(*) as cnt from cb_cmall_order_detail as d where cod_status = \'deposit\' group by cit_id) AS t1','t1.cit_id = cmall_item.cit_id','left');
        // 장바구니 갯수
        $this->db->join('(select cit_id, count(*) as cnt from cb_cmall_cart as c group by cit_id) AS t2','t2.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, p.cde_download, ';
        $select .= 'IFNULL(q.cnt,0) AS comment_cnt, ';
        $select .= 'IFNULL(t1.cnt,0) + IFNULL(t2.cnt,0)  AS sell_cnt, ';
        $select .= ' (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish';
        $this->db->select($select);
        $this->db->where($where);

        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;
    }

    public function increase_download_count($p) {
        $cde_id = $p["cde_id"];

        $this->db->where('cde_id',$cde_id);
        $this->db->set('cde_download', 'cde_download+1', FALSE);
        $this->db->update('cmall_item_detail');
    }

    public function get_main_trending_list($config)
    {

        $where['cit_status'] = 1;



        $limit = element('limit', $config) ? element('limit', $config) : 4;

        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = cmall_item.cit_id AND p1.cim_key = "info_content_1"','left');
        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = cmall_item.cit_id AND p2.cim_key = "info_content_2"','left');
        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = cmall_item.cit_id AND p3.cim_key = "info_content_3"','left');
        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND m1.mem_id = "'.$this->member->item('mem_id').'"','left');

        $this->db->select('cmall_item.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price, (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish');
        $this->db->where($where);
        $this->db->limit($limit);
        $this->db->order_by('cit_order', 'asc');
        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;
    }

    public function get_comment_list($config)
    {

        $where['cmall_qna.cit_id'] = element('cit_id', $config);

        $this->db->where($where);
        //$this->db->limit($limit);
        $this->db->order_by('cb_cmall_qna.cqa_id', 'desc');
        $qry = $this->db->get('cmall_qna');
        $result = $qry->result_array();

        return $result;

    }

    // Item 공유 횟수 증가
    public function increase_item_share_count($config)
    {
        return $this->db->where('cit_id', $config['cit_id'])
            ->set('cit_share_count','cit_share_count + 1',false)
            ->update('cmall_item');
    }

    // 연관 추가 등록 : 연관추가할 음원 조회
    public function get_item_list_for_addRelation($p)
    {
        $this->db->where('cb_c.cit_id !=',$p['cit_id']);
        if($p['title']) {
            $this->db->where('cb_c.cit_name like','%'.$p['title'].'%');
        }
        if($p['musician']) {
            $this->db->where('p3.cim_value like','%'.$p['musician'].'%');
        }

        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = c.cit_id AND p1.cim_key = "info_content_1"','left');
        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = c.cit_id AND p2.cim_key = "info_content_2"','left');
        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = c.cit_id AND p3.cim_key = "info_content_3"','left');
        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = c.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = c.cit_id AND w.mem_id = "'.$p['mem_id'].'"','left');

        $this->db->select('cb_c.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price, (case when w.cwi_id is not null then 1 else 0 end) as is_wish');
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        $result = $qry->result_array();

        return $result;
    }

    // Sublist 조회
    public function get_sublist_list($config)
    {
        $limit = element('limit', $config);
        $offset = element('offset', $config);
        $sort = element('sort', $config);
        $search = element('search', $config);
        $genre = element('genre', $config);
        $subgenre = element('subgenre', $config);
        $bpmFr = element('bpmFr', $config);
        $bpmTo = element('bpmTo', $config);
        $moods = element('moods', $config);
        $trackType = element('trackType', $config);

        log_message('debug','$limit : ' . $limit);
        log_message('debug','$offset : ' . $offset);
        log_message('debug','$sort : ' . $sort);
        log_message('debug','$search : ' . $search);
        log_message('debug','$bpmFr : ' . $bpmFr);
        log_message('debug','$bpmTo : ' . $bpmTo);
        log_message('debug','$genre : ' . $genre);
        log_message('debug','$subgenre : ' . $subgenre);
        log_message('debug','$moods : ' . $moods);
        log_message('debug','$trackType : ' . $trackType);


        $where['cit_status'] = 1;
        // search
        if ($search) {
            $this->db->where("(p.hashtag like '%".$search."%' OR cb_cmall_item.cit_name like '%".$search."%' OR p.musician like '%".$search."%')",null,false);
        }
        // Genre
        if ($genre && $genre !== 'All Genre') {
            $this->db->where('p.genre',$genre);
        }

        // SubGenre
        if ($subgenre && $subgenre !== 'All') {
            $this->db->where('p.subgenre',$subgenre);
        }
        // Bpm
        if ($bpmFr) {
            $this->db->where('p.bpm >=',$bpmFr + 0);
        }
        if ($bpmTo) {
            $this->db->where('p.bpm <=',$bpmTo + 0);
        }
        // Moods
        if ($moods && $moods !== 'All') {
            $this->db->where('p.moods',$moods);
        }
        // Track Type
        if ($trackType && $trackType !== 'All types') {
            $this->db->where('p.trackType',$trackType);
        }

        // 만약 정렬 조건이 없거나 [All Select] 인경우에는 조회수 높은 순으로 조회
        if(!$sort || $sort == 'All Select') {
            $this->db->order_by('cmall_item.cit_hit', 'desc');
        }
        // 만약 정렬 조건이 없거나 [Sort By Staff Picks] 인경우에는 [상품유형] 이 [추천] 인 경우만 검색
        if($sort == 'Sort By Staff Picks') {
            $where['cmall_item.cit_type1'] = 1;
            $this->db->order_by('cde_download', 'desc');
        }
        // 만약 정렬 조건이 [Newest] 인경우에는 최신 등록 상품 조회
        if($sort == 'Newest') {
            $this->db->order_by('cit_datetime', 'desc');
        }
        // 만약 정렬 조건이 [Top Downloads] 인경우에는 다운로드 수 많은 순 조회
        if($sort == 'Top Downloads') {
            $this->db->order_by('cde_download', 'desc');
        }

        //$limit = element('limit', $config) ? element('limit', $config) : 4;
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, p.cde_download, ';
        $select .= ' (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish';
        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($limit);
        $this->db->offset($offset);


        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;

    }


    // Sublist Top 5 조회
    public function get_sublist_top5_list($config)
    {
        $sort = element('sort', $config);
        $search = element('search', $config);
        $genre = element('genre', $config);
        $subgenre = element('subgenre', $config);
        $bpmFr = element('bpmFr', $config);
        $bpmTo = element('bpmTo', $config);
        $moods = element('moods', $config);
        $trackType = element('trackType', $config);



        $where['cit_status'] = 1;
        // search
        if ($search) {
            $this->db->where("p.hashtag like '%".$search."%' OR cb_cmall_item.cit_name like '%".$search."%' OR p.musician like '%".$search."%'",null,false);
        }
        // Genre
        if ($genre && $genre !== 'All Genre') {
            $this->db->where('p.genre',$genre);
        }

        // SubGenre
        if ($subgenre && $subgenre !== 'All') {
            $this->db->where('p.subgenre',$subgenre);
        }
        // Bpm
        if ($bpmFr) {
            $this->db->where('p.bpm >=',$bpmFr + 0);
        }
        if ($bpmTo) {
            $this->db->where('p.bpm <=',$bpmTo + 0);
        }

        // 만약 정렬 조건이 없거나 [All Select] 인경우에는 조회수 높은 순으로 조회
        if(!$sort || $sort == 'All Select') {
            $this->db->order_by('cmall_item.cit_hit', 'desc');
        }
        // 만약 정렬 조건이 없거나 [Sort By Staff Picks] 인경우에는 [상품유형] 이 [추천] 인 경우만 검색
        if($sort == 'Sort By Staff Picks') {
            $where['cmall_item.cit_type1'] = 1;
            $this->db->order_by('cde_download', 'desc');
        }
        // 만약 정렬 조건이 [Newest] 인경우에는 최신 등록 상품 조회
        if($sort == 'Newest') {
            $this->db->order_by('cit_datetime', 'desc');
        }
        // 만약 정렬 조건이 [Top Downloads] 인경우에는 다운로드 수 많은 순 조회
        if($sort == 'Top Downloads') {
            $this->db->order_by('cde_download', 'desc');
        }

        //$limit = element('limit', $config) ? element('limit', $config) : 4;
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, p.cde_download, ';
        $select .= ' (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish';
        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($config['limit']);


        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;


    }


    // 등록 비용 플랜 조회
    public function get_register_plan_cost()
    {

        $this->db->select('*');
        $qry = $this->db->get('cb_bs_register_plan_cost');

        $result = $qry->result_array();

        return $result;
    }

    // 사용자 음원 목록 조회
    public function get_user_regist_item_list($p)
    {

        $where = array(
            'm.cim_value = ' => $p['mem_id'],
        );
        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = c.cit_id AND p1.cim_key = "info_content_1"','left');
        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = c.cit_id AND p2.cim_key = "info_content_2"','left');
        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = c.cit_id AND p3.cim_key = "info_content_3"','left');
        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = c.cit_id','left');
        $this->db->where($where);
        $this->db->select('cb_c.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price');
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        $result = $qry->result_array();

        return $result;
    }

    // 음원 조회
    public function get_item($p)
    {

        $where = array(
            'cb_c.cit_id = ' => $p['cit_id'],
        );
        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = c.cit_id AND p1.cim_key = "info_content_1"','left');
        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = c.cit_id AND p2.cim_key = "info_content_2"','left');
        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = c.cit_id AND p3.cim_key = "info_content_3"','left');
        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = c.cit_id','left');
        $this->db->where($where);
        $this->db->select('cb_c.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price, m1.cde_originname');
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        $result = $qry->first_row();

        return $result;
    }

    // 음원 기타정보 조회
    public function get_item_infomation($p)
    {

        $where = array(
            'cb_c.cit_id = ' => $p['cit_id'],
        );
        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
        $this->db->join('cb_member as cm','m.cim_value = cm.mem_id','inner');

        $this->db->where($where);
        $this->db->select('cb_c.*, cm.mem_userid, cm.mem_email, cm.mem_username, cm.mem_nickname,cm.mem_photo');
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        $result = $qry->first_row();

        return $result;
    }

    // 연관 음원 조회
    public function get_relation_list($config)
    {
        $limit = element('limit', $config);
        $offset = element('offset', $config);
        $mem_id = element('mem_id', $config);
        $cit_id = element('cit_id', $config);

        log_message('debug','$limit : ' . $limit);
        log_message('debug','$offset : ' . $offset);
        log_message('debug','$cit_id : ' . $cit_id);
        log_message('debug','$mem_id : ' . $mem_id);


        $where['cit_status'] = 1;



        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$mem_id.'"','left');
        $this->db->join('cb_cmall_item_relation as r','cmall_item.cit_id = r.cit_id_r AND r.cit_id = "' . $cit_id.'"','inner');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, p.cde_download, ';
        $select .= ' (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish';
        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($limit);
        $this->db->offset($offset);
        $this->db->order_by('cde_download', 'desc');

        $qry = $this->db->get($this->_table);
        $result = $qry->result_array();

        return $result;

//        $where = array(
////            'cb_c.cit_id = ' => $p['cit_id'],
//        );
//        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
//        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = c.cit_id AND p1.cim_key = "info_content_1"','left');
//        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = c.cit_id AND p2.cim_key = "info_content_2"','left');
//        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = c.cit_id AND p3.cim_key = "info_content_3"','left');
//        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = c.cit_id','left');
//        $this->db->join('cb_cmall_item_relation as r','c.cit_id = r.cit_id_r AND r.cit_id = ' . $p['cit_id'],'inner');
//        $this->db->join('cb_cmall_wishlist as w','w.cit_id = c.cit_id AND w.mem_id = "'.$p['mem_id'].'"','left');
//        $this->db->where($where);
//        $this->db->select('cb_c.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price, m1.cde_originname, (case when w.cwi_id is not null then 1 else 0 end) as is_wish');
//        $this->db->order_by('cit_id', 'desc');
//        $qry = $this->db->get('cmall_item as cb_c');
//
//        $result = $qry->result_array();
//
//        return $result;
    }

    // 사용자 상품 등록
    public function merge_item($p)
    {
        // Begin Transaction
        $this->db->trans_start();

        log_message('debug','MERGE_ITEM PARAMETER : '.print_r($p,true));

        $cit_id = null;

        // 만약 cit_id 존재 시 업데이트
        if($p["cit_id"]) {

            $cit_id = $p["cit_id"];

            // 상품 등록 (cmall_item)
            $data = array(
                "cit_name" => $p["cit_name"],
                "cit_content" => $p["cit_content"],
                "cit_updated_datetime" => cdate('Y-m-d H:i:s'),
            );
            if($p["cit_file_1"]) {
                $data["cit_file_1"] = $p["cit_file_1"];
            }
            $this->db->where('cit_id',$cit_id);
            $this->db->update('cmall_item', $data);



            // 옵션 등록 (cmall_item_detail)
            $data = array(
                "cde_price" => $p["cit_price"],
            );
            if(array_key_exists("cde_file_1",$p)) {
                $data["cde_filename"] = $p["cde_file_1"]["cde_filename"];
                $data["cde_originname"] = $p["cde_file_1"]["cde_originname"];
                $data["cde_filesize"] = $p["cde_file_1"]["cde_filesize"];
                $data["cde_type"] = $p["cde_file_1"]["cde_type"];
            }
            $this->db->where('cit_id',$cit_id);
            $this->db->update('cmall_item_detail', $data);

            // 메타 등록 (cmall_item_meta)

            $meta = array(
                'info_content_1' => $p['genre'],
                'info_content_2' => $p['bpm'],
                'info_content_3' => $p['musician'],
            );

            foreach ($meta as $k => $v) {
                $mp = array(
                    'cim_value' => $v,
                );
                $this->db->where('cit_id',$cit_id);
                $this->db->where('cim_key',$k);
                $this->db->update('cmall_item_meta', $mp);
            }

        }
        // 아니면 등록
        else {
            // 상품 등록 (cmall_item)
            $data = array(
                "cit_name" => $p["cit_name"],
                "cit_key" => $p["cit_key"],
                "mem_id" => $p["mem_id"],
                "cit_status" => 1,
                "cit_summary" => "",
                "cit_content" => $p["cit_content"],
                "cit_content_html_type" => 1,
                "cit_datetime" => cdate('Y-m-d H:i:s'),
                "cit_updated_datetime" => cdate('Y-m-d H:i:s'),
            );
            if($p["cit_file_1"]) {
                $data["cit_file_1"] = $p["cit_file_1"];
            }
            $this->db->insert('cmall_item', $data);

            $cit_id = $this->db->insert_id();

            // 옵션 등록 (cmall_item_detail)
            $data = array(
                "cit_id" => $cit_id,
                "mem_id" => $p["mem_id"],
                "cde_title" => '기본',
                "cde_price" => $p["cit_price"],
                "cde_datetime" => cdate('Y-m-d H:i:s'),
                "cde_ip" => $p["ip"],
                "cde_status" => 1,
            );
            if(array_key_exists("cde_file_1",$p)) {
                $data["cde_filename"] = $p["cde_file_1"]["cde_filename"];
                $data["cde_originname"] = $p["cde_file_1"]["cde_originname"];
                $data["cde_filesize"] = $p["cde_file_1"]["cde_filesize"];
                $data["cde_type"] = $p["cde_file_1"]["cde_type"];
            }
            $this->db->insert('cmall_item_detail', $data);

            // 메타 등록 (cmall_item_meta)

            $meta = array(
                'seller_mem_id' => $p['mem_id'],
                'seller_mem_userid' => $p['mem_userid'],
                'ip_address' => $p['ip'],
                'info_content_1' => $p['genre'],
                'info_content_2' => $p['bpm'],
                'info_content_3' => $p['musician'],
            );

            foreach ($meta as $k => $v) {
                $mp = array(
                    "cit_id" => $cit_id,
                    'cim_key' => $k,
                    'cim_value' => $v,
                );
                $this->db->insert('cmall_item_meta', $mp);
            }

        }




        // Commit Transaction
        $this->db->trans_complete();

        return $cit_id;
    }


}
