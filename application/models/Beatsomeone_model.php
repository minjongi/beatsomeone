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

        $where['cit_status'] = 1;
        $this->db->where('cit_start_datetime <= now()');
        $this->db->where('(cit_lease_license_use = 1 or cit_mastering_license_use = 1)');

        $genre = element('genre', $config);
        $genreWhere = [];
        // Genre
        if ($genre === 'BGMSOUND') {
            $where['cmall_item.cit_type5'] = 1;
        } else {
            if ($genre && $genre !== 'All Genre') {
                $genreWhere[] = "p.genre = '" . $genre . "'";
                $genreWhere[] = "p.subgenre = '" . $genre . "'";
            }
            if (!empty($genreWhere)) {
                $this->db->where("(" . implode(' or ', $genreWhere) . ")", null, false);
            }
        }

        if ($bpm) {
            $where['p.bpm <='] = $bpm + 0;
            $where['p.bpm >='] = $bpm - 10;
        }
        if ($voice == 'true') {
            $where['p.voice'] = 1;
        }

        $where['cmall_item.cit_type1'] = 1;

        if($sort == 'Newest') { // 만약 정렬 조건이 [Newest] 인경우에는 최신 등록 상품 조회
            $this->db->order_by('cit_datetime', 'desc');
        } else if($sort == 'Top Downloads') { // 만약 정렬 조건이 [Top Downloads] 인경우에는 다운로드 수 많은 순 조회
            $this->db->order_by('cde_download', 'desc');
        } else { // 만약 정렬 조건이 없거나 [Sort By Staff Picks] 인경우에는 [상품유형] 이 [추천] 인 경우만 검색
            $this->db->order_by('RAND()', 'desc');
        }

        $limit = element('limit', $config) ? element('limit', $config) : 4;
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');
        $this->db->join('cb_member as m','m.mem_id = cmall_item.mem_id','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, m.mem_nickname,';
        $select .= 'p.cde_id, p.cde_price,p.cde_price_d, p.cde_download,';
        $select .= 'p.cde_id_2, p.cde_price_2, p.cde_price_d_2, p.cde_download_2, p.preview_cde_id,';
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

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price, cde_price_d, p.cde_download, p.preview_cde_id,';
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
        return $this->db->update('cmall_item_detail');
    }

    public function get_main_trending_list($config)
    {
        $where['cit_status'] = 1;
        $this->db->where('cit_start_datetime <= now()');
        $this->db->where('(cit_lease_license_use = 1 or cit_mastering_license_use = 1)');

        $limit = element('limit', $config) ? element('limit', $config) : 4;

        $this->db->join('cb_cmall_item_meta as p1','p1.cit_id = cmall_item.cit_id AND p1.cim_key = "info_content_1"','left');
        $this->db->join('cb_cmall_item_meta as p2','p2.cit_id = cmall_item.cit_id AND p2.cim_key = "info_content_2"','left');
        $this->db->join('cb_cmall_item_meta as p3','p3.cit_id = cmall_item.cit_id AND p3.cim_key = "info_content_3"','left');
        $this->db->join('cb_cmall_item_detail as m1','m1.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND m1.mem_id = "'.$this->member->item('mem_id').'"','left');
        $this->db->join('cb_member as m', 'm.mem_id = cmall_item.mem_id', 'left');

        $this->db->select('cmall_item.*, p1.cim_value as genre, p2.cim_value as bpm, p3.cim_value as musician, m1.cde_id, m1.cde_price, (CASE WHEN w.cit_id IS NOT NULL THEN 1 ELSE 0 END) as is_wish, m.mem_nickname');
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

        $this->db->where($where)
            ->join('cb_member as m','m.mem_id = cb_cmall_qna.mem_id','left')
            ->select('cb_cmall_qna.*, m.mem_nickname, m.mem_photo');
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

        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = c.cit_id','left');

        $select = 'c.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice ';
        $select .= ',p.cde_id, p.cde_price,p.cde_price_d, p.cde_download, p.cde_originname, p.cde_quantity ';
        $select .= ',p.cde_id_2, p.cde_price_2,p.cde_price_d_2, p.cde_download_2, p.cde_originname_2, p.cde_quantity_2 ';
        $select .= ',p.cde_id_3, p.cde_price_3,p.cde_price_d_3, p.cde_download_3, p.cde_originname_3, p.cde_quantity_3 ';
        $this->db->select($select);
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        return $qry->result_array();
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
        $brandMemId = element('brand_mem_id', $config);

        $where['cit_status'] = 1;
        $this->db->where('cit_start_datetime <= now()');
        $this->db->where('(cit_lease_license_use = 1 or cit_mastering_license_use = 1)');

        if (!empty($brandMemId)) {
            $where['cb_cmall_item.mem_id'] = $brandMemId;
        }

        // search
        if ($search) {
//            $this->db->where("(p.hashtag like '%".$search."%' OR cb_cmall_item.cit_name like '%".$search."%' OR p.musician like '%".$search."%')",null,false);
            $this->db->where("cb_cmall_item.search_data like '%" . $search . "%'", null, false);
        }

        $genreWhere = [];
        // Genre
        if ($genre === 'BGMSOUND') {
            $where['cmall_item.cit_type5'] = 1;
        } else {
            if ($genre && $genre !== 'All Genre') {
                $genreWhere[] = "p.genre = '" . $genre . "'";
                $genreWhere[] = "p.subgenre = '" . $genre . "'";
            }
        }
        // SubGenre
        if ($subgenre === 'BGMSOUND') {
            $where['cmall_item.cit_type5'] = 1;
        } else {
            if ($subgenre && $subgenre !== 'All') {
                $genreWhere[] = "p.genre = '" . $subgenre . "'";
                $genreWhere[] = "p.subgenre = '" . $subgenre . "'";
            }
        }
        if (!empty($genreWhere)) {
            $this->db->where("(" . implode(' or ', $genreWhere) . ")", null, false);
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
        if(!$sort || $sort == 'All Select' || $sort == 'Sort By') {
            $this->db->order_by('cmall_item.cit_hit', 'desc');
        }
        if($sort == 'random') {
            $this->db->order_by('RAND()', 'desc');
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
        $this->db->join('cb_member as m','m.mem_id = cmall_item.mem_id','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, m.mem_nickname,';
        $select .= 'p.cde_id, p.cde_price,p.cde_price_d, p.cde_download,';
        $select .= 'p.cde_id_2, p.cde_price_2, p.cde_price_d_2, p.cde_download_2, p.preview_cde_id,';
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
        $where['cmall_item.cit_type1'] = 1;
        $this->db->where('cit_start_datetime <= now()');
        $this->db->where('(cit_lease_license_use = 1 or cit_mastering_license_use = 1)');

        // search
        if ($search) {
            $this->db->where("(p.hashtag like '%".$search."%' OR cb_cmall_item.cit_name like '%".$search."%' OR p.musician like '%".$search."%')",null,false);
        }

        $genreWhere = [];
        // Genre
        if ($genre === 'BGMSOUND') {
            $where['cmall_item.cit_type5'] = 1;
        } else {
            if ($genre && $genre !== 'All Genre') {
                $genreWhere[] = "p.genre = '" . $genre . "'";
                $genreWhere[] = "p.subgenre = '" . $genre . "'";
            }
        }
        // SubGenre
        if ($subgenre === 'BGMSOUND') {
            $where['cmall_item.cit_type5'] = 1;
        } else {
            if ($subgenre && $subgenre !== 'All') {
                $genreWhere[] = "p.genre = '" . $subgenre . "'";
                $genreWhere[] = "p.subgenre = '" . $subgenre . "'";
            }
        }
        if (!empty($genreWhere)) {
            $this->db->where("(" . implode(' or ', $genreWhere) . ")", null, false);
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
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','inner');
        $this->db->join('cb_member as m','m.mem_id = cmall_item.mem_id','left');

        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice, p.cde_id, p.cde_price,p.cde_price_d, p.cde_download, m.mem_nickname';

        $this->db->select($select);
        $this->db->where($where);
        $this->db->limit($config['limit']);


        $qry = $this->db->get($this->_table);
        return $qry->result_array();
    }


    // 회원별 음원 등록수 조회
    public function get_item_reg_count_by_mem_id($memId, $usertype=1)
    {
        if ($usertype < 2) {
            return 0;
        }

        $this->db->select('COUNT(*) AS totalCount');
        $this->db->where(['mem_id' => $memId]);

        if ($usertype == 2) {
            $this->db->where('cit_datetime <=', date('Y-m-01'));
        }

        $qry = $this->db->get($this->_table);
        return $qry->row_array()['totalCount'];
    }

    // 등록 비용 플랜 조회
    public function get_register_plan_cost()
    {
        $this->db->select('*');
        $qry = $this->db->get('cb_bs_register_plan_cost');

        $result = $qry->result_array();

        return $result;
    }

    // 등록 비용 플랜 조회
    public function get_register_plan_cost_by_plan($plan)
    {
        $this->db->select('*');
        $this->db->where('plan =', strtoupper($plan));
        $qry = $this->db->get('cb_bs_register_plan_cost');

        $result = $qry->row_array();

        return $result;
    }

    // 등록 비용 플랜 저장
    public function merge_register_plan_cost($p)
    {
        return $this->db->update_batch('cb_bs_register_plan_cost',$p, 'plan');
    }

    // 사용자 음원 목록 조회
    public function get_user_regist_item_list($p)
    {

        $select = 'c.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice ';
        $select .= ',p.cde_id, p.cde_price,p.cde_price_d, p.cde_download, p.cde_originname, p.cde_quantity ';
        $select .= ',p.cde_id_2, p.cde_price_2,p.cde_price_d_2, p.cde_download_2, p.cde_originname_2, p.cde_quantity_2 ';
        $select .= ',p.cde_id_3, p.cde_price_3,p.cde_price_d_3, p.cde_download_3, p.cde_originname_3, p.cde_quantity_3 ';
        $select .= ',p.cde_originname, d.cde_filename, e.mem_nickname';
        $this->db->select($select);
        $where = array(
            'c.mem_id = ' => $p['mem_id'],
        );
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = c.cit_id','left');
        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','inner');
        $this->db->join('cb_cmall_item_detail as d','c.cit_id = d.cit_id AND d.cde_title = "LEASE"','left');
        $this->db->join('cb_member as e','d.mem_id = e.mem_id','left');
        $this->db->where($where);
        $this->db->order_by('cit_id', 'desc');
        $qry = $this->db->get('cmall_item as cb_c');

        return $qry->result_array();

    }

    // 음원 조회
    public function get_item($p)
    {

        $where = array(
            'cmall_item.cit_id = ' => $p['cit_id'],
        );
        $this->db->join('cb_cmall_item_meta_v as p','p.cit_id = cmall_item.cit_id','left');
        $this->db->join('cb_cmall_wishlist as w','w.cit_id = cmall_item.cit_id AND  w.mem_id = "'.$this->member->item('mem_id').'"','left');

        $this->db->where($where);
        $select = 'cmall_item.*, p.genre, p.bpm, p.musician, p.subgenre, p.moods, p.trackType, p.hashTag, p.voice ';
        $select .= ',p.cde_id, p.cde_price,p.cde_price_d, p.cde_download, p.cde_originname, p.cde_quantity ';
        $select .= ',p.cde_id_2, p.cde_price_2,p.cde_price_d_2, p.cde_download_2, p.cde_originname_2, p.cde_quantity_2 ';
        $select .= ',p.cde_id_3, p.cde_price_3,p.cde_price_d_3, p.cde_download_3, p.cde_originname_3, p.cde_quantity_3 ';
        $this->db->select($select);
        $qry = $this->db->get('cmall_item');

        $result = $qry->first_row();

        return $result;
    }

    // 음원 기타정보 조회
    public function get_item_infomation($p)
    {

        $where = array(
            'cb_c.cit_id = ' => $p['cit_id'],
        );
//        $this->db->join('cb_cmall_item_meta as m','c.cit_id = m.cit_id AND m.cim_key = "seller_mem_id"','left');
        $this->db->join('cb_member as cm','cb_c.mem_id = cm.mem_id','inner');

        $this->db->where($where);
        $this->db->select('cb_c.*, cm.mem_userid, cm.mem_email, cm.mem_username, cm.mem_nickname, cm.mem_photo, cm.mem_profile_content');
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

    }

    // 사용자 상품 등록
    public function merge_item($p)
    {
        // Begin Transaction
        $this->db->trans_start();

        $cit_id = null;
        $fileList = ['unTaggedFile' => 'LEASE', 'stemFile' => 'STEM', 'streamingFile' => 'TAGGED'];

        $hashTag = '';
        if (!empty($p['hashTag'])) {
            $hashTag = implode(',', $p['hashTag']);
            foreach ($p['hashTag'] as $tagName) {
                $tmpData = $this->db->query("SELECT cht_id FROM cb_cmall_item_hash_tag WHERE tag_name = ?", $tagName)->row_array();
                if (empty($tmpData['cht_id'])) {
                    $this->db->insert('cmall_item_hash_tag', ['tag_name' => $tagName, 'tagged_count' => 1]);
                    continue;
                }

                $this->db->where('cht_id', $tmpData['cht_id']);
                $this->db->set('tagged_count', 'tagged_count + 1', false);
                $this->db->update('cmall_item_hash_tag');
            }
        }

        $infoContent6 = get_search_track_type($p['trackType']);
        $infoContent1 = get_search_genre($p['genre']);
        $infoContent4 = get_search_genre($p['subgenre']);
        $infoContent5 = get_search_moods($p['moods']);

        $infoContent6 = implode('|', array_unique($infoContent6));
        $infoContent1 = implode('|', array_unique($infoContent1));
        $infoContent4 = implode('|', array_unique($infoContent4));
        $infoContent5 = implode('|', array_unique($infoContent5));

        $searchData = gen_search_data([
            $p['cit_name'],
            $p['mem_nickname'],
            $infoContent1,
            $infoContent4,
            $infoContent5,
            $p['bpm'],
            $infoContent6
        ]);

        $expandSearchData = gen_search_data([
            $infoContent1,
            $infoContent4,
            $infoContent5,
            $hashTag,
        ]);

        // 만약 cit_id 존재 시 업데이트
        if(!empty($p["cit_id"])) {
            $cit_id = $p["cit_id"];
            $itemInfo = $this->get_item($p);

            $expandSearchData = gen_search_data([
                trim($expandSearchData, '|'),
                $itemInfo->similar_song,
                $itemInfo->similar_singer,
                $itemInfo->similar_musicians,
                $itemInfo->other_tags
            ]);

            // 상품 등록 (cmall_item)
            $data = array(
                "cit_name" => $p["cit_name"],
                "cit_content" => $p["cit_content"],
                "cit_updated_datetime" => cdate('Y-m-d H:i:s'),
                'cit_start_datetime' => $p['cit_start_datetime'],
                'cit_lease_license_use' => $p['licenseLeaseUseYn'],
                'cit_mastering_license_use' => $p['licenseStemUseYn'],
                'cit_freebeat' => $p['freebeat'],
                'cit_include_copyright_transfer' => $p['include_copyright_transfer'],
                'cit_officially_registered' => $p['officially_registered'],
                'cit_org_content' => $p['cit_org_content'],
                'cit_type5' => $p['cit_type5'],
                'search_data' => $searchData,
                'expand_search_data' => $expandSearchData
            );
            if (!empty($p["artwork"]['filename'])) {
                $data["cit_file_1"] = $p["artwork"]['filename'];
            }
            $this->db->where('cit_id',$cit_id);
            $this->db->update('cmall_item', $data);

            foreach ($fileList as $fileType => $fileTitle) {
                $uploadFileData['cde_title'] = $fileTitle;
                if ($fileType === 'unTaggedFile') {
                    $cde_id = $p['cde_id'] ?? null;
                    $uploadFileData['cde_price'] = $p['licenseLeasePriceKRW'];
                    $uploadFileData['cde_price_d'] = $p['licenseLeasePriceUSD'];
                    $uploadFileData['cde_quantity'] = $p['licenseLeaseQuantity'];
                } else if ($fileType === 'stemFile') {
                    $cde_id = $p['cde_id_2'] ?? null;
                    $uploadFileData['cde_price'] = $p['licenseStemPriceKRW'];
                    $uploadFileData['cde_price_d'] = $p['licenseStemPriceUSD'];
                    $uploadFileData['cde_quantity'] = $p['licenseStemQuantity'];
                } else if ($fileType === 'streamingFile') {
                    $cde_id = $p['cde_id_3'] ?? null;
                    $uploadFileData['cde_price'] = 0;
                    $uploadFileData['cde_price_d'] = 0;
                    $uploadFileData['cde_quantity'] = 0;
                }

                if (empty($p[$fileType])) {
                    if ($fileType === 'streamingFile') {
                        continue;
                    }
                    $this->db->where('cde_id',$cde_id);
                    $this->db->update('cmall_item_detail', $uploadFileData);
                    continue;
                }

                $uploadFileData['cde_filename'] = $p[$fileType]['filename'];
                $uploadFileData['cde_originname'] = element('originname', $p[$fileType]);
                $uploadFileData['cde_filesize'] = intval(element('filesize', $p[$fileType]) * 1024);
                $uploadFileData['cde_type'] = str_replace('.', '', element('type', $p[$fileType]));
                $uploadFileData['cde_is_image'] = element('is_image', $p[$fileType]) ? element('is_image', $p[$fileType]) : 0;

                if (!empty($cde_id)) {
                    $this->db->where('cde_id',$cde_id);
                    $this->db->update('cmall_item_detail', $uploadFileData);
                    continue;
                }

                $uploadFileData['cit_id'] = $cit_id;
                $uploadFileData['mem_id'] = $p["mem_id"];
                $uploadFileData['cde_datetime'] = cdate('Y-m-d H:i:s');
                $uploadFileData['cde_ip'] = $p["ip"];
                $uploadFileData['cde_status'] = 1;

                $this->db->insert('cmall_item_detail', $uploadFileData);
            }



            // 메타 등록 (cmall_item_meta)
            $meta = array(
                'info_content_1' => $p['genre'] ?? '',
                'info_content_2' => $p['bpm'] ?? '',
                'info_content_3' => $p['musician'] ?? '',
                'info_content_4' => $p['subgenre'] ?? '',
                'info_content_5' => $p['moods'] ?? '',
                'info_content_6' => $p['trackType'] ?? '',
                'info_content_7' => $hashTag ?? '',
                'info_content_8' => $p['voice'] ?? '',
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
            $cit_key = empty($p["cit_key"]) ? uniqid() : $p["cit_key"];
            $data = array(
                "cit_name" => $p["cit_name"],
                "cit_key" => $cit_key,
                "mem_id" => $p["mem_id"],
                "cit_status" => 1,
                "cit_summary" => "",
                "cit_content" => $p["cit_content"],
                "cit_content_html_type" => 1,
                "cit_datetime" => cdate('Y-m-d H:i:s'),
                "cit_updated_datetime" => cdate('Y-m-d H:i:s'),
                'cit_start_datetime' => $p['cit_start_datetime'],
                'cit_lease_license_use' => $p['licenseLeaseUseYn'],
                'cit_mastering_license_use' => $p['licenseStemUseYn'],
                'cit_freebeat' => $p['freebeat'],
                'cit_include_copyright_transfer' => $p['include_copyright_transfer'],
                'cit_officially_registered' => $p['officially_registered'],
                'cit_org_content' => $p['cit_org_content'],
                'cit_type5' => $p['cit_type5'],
                'search_data' => $searchData,
                'expand_search_data' => $expandSearchData
            );
            if (!empty($p["artwork"]['filename'])) {
                $data["cit_file_1"] = $p["artwork"]['filename'];
            }
            $this->db->insert('cmall_item', $data);

            $cit_id = $this->db->insert_id();

            foreach ($fileList as $fileType => $fileTitle) {
                if (empty($p[$fileType])) {
                    continue;
                }
                $uploadFileData['cde_title'] = $fileTitle;

                if ($fileType === 'unTaggedFile') {
                    $uploadFileData['cde_price'] = $p['licenseLeasePriceKRW'];
                    $uploadFileData['cde_price_d'] = $p['licenseLeasePriceUSD'];
                    $uploadFileData['cde_quantity'] = $p['licenseLeaseQuantity'];
                } else if ($fileType === 'stemFile') {
                    $uploadFileData['cde_price'] = $p['licenseStemPriceKRW'];
                    $uploadFileData['cde_price_d'] = $p['licenseStemPriceUSD'];
                    $uploadFileData['cde_quantity'] = $p['licenseStemQuantity'];
                } else if ($fileType === 'streamingFile') {
                    $uploadFileData['cde_price'] = 0;
                    $uploadFileData['cde_price_d'] = 0;
                    $uploadFileData['cde_quantity'] = 0;
                }

                $uploadFileData['cde_filename'] = $p[$fileType]['filename'];
                $uploadFileData['cde_originname'] = element('originname', $p[$fileType]);
                $uploadFileData['cde_filesize'] = intval(element('filesize', $p[$fileType]) * 1024);
                $uploadFileData['cde_type'] = str_replace('.', '', element('type', $p[$fileType]));
                $uploadFileData['cde_is_image'] = element('is_image', $p[$fileType]) ? element('is_image', $p[$fileType]) : 0;

                $uploadFileData['cit_id'] = $cit_id;
                $uploadFileData['mem_id'] = $p["mem_id"];
                $uploadFileData['cde_datetime'] = cdate('Y-m-d H:i:s');
                $uploadFileData['cde_ip'] = $p["ip"];
                $uploadFileData['cde_status'] = 1;

                $this->db->insert('cmall_item_detail', $uploadFileData);
            }

            // 메타 등록 (cmall_item_meta)
            $meta = array(
                'seller_mem_id' => $p['mem_id'] ?? '',
                'seller_mem_userid' => $p['mem_userid'] ?? '',
                'ip_address' => $p['ip'] ?? '',
                'info_content_1' => $p['genre'] ?? '',
                'info_content_2' => $p['bpm'] ?? '',
                'info_content_3' => $p['musician'] ?? '',
                'info_content_4' => $p['subgenre'] ?? '',
                'info_content_5' => $p['moods'] ?? '',
                'info_content_6' => $p['trackType'] ?? '',
                'info_content_7' => $hashTag ?? '',
                'info_content_8' => $p['voice'] ?? '',
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



    // mypage 멤버 정보 조회
    public function get_user_info($p)
    {
        $select = 'mem_id, mem_userid, mem_nickname, mem_email, mem_level, mem_point, mem_icon, mem_photo, mem_usertype, mem_address1, mem_type, mem_firstname, mem_lastname, mem_profile_content';
        $this->db->select($select);

        //$this->db->join('cb_cmall_item_meta_v as p','p.cit_id = c.cit_id','left');

        $where = array(
            'mem_id = ' => $p['mem_id'],
            'mem_denied = ' => 0,
        );
        $this->db->where($where);

        //$this->db->order_by('cit_id', 'desc');

        $qry = $this->db->get('cb_member');

        return $qry->result_array();

    }


    // 멤버 정보 조회
    public function get_userid_info($p)
    {
        $select = 'mem_id, mem_userid, mem_nickname, mem_email, mem_level, mem_point, mem_icon, mem_photo, mem_usertype, mem_address1, mem_type, mem_firstname, mem_lastname';
        $this->db->select($select);

        //$this->db->join('cb_cmall_item_meta_v as p','p.cit_id = c.cit_id','left');

        $where = array(
            'mem_nickname = ' => $p['mem_nickname'],
            'mem_denied = ' => 0,
        );
        $this->db->where($where);

        //$this->db->order_by('cit_id', 'desc');

        $qry = $this->db->get('cb_member');

        return $qry->result_array();

    }



    // 판매자 판매 목록 조회
    public function get_sales_history($p)
    {

        $sql = "select distinct a.cor_id ";
        $sql .= "from cb_cmall_order_detail a ";
        $sql .= "join ( ";
        $sql .= " select x.cit_id ";
        $sql .= " FROM cb_cmall_item x ";
        $sql .= "    join beatsomeone.cb_cmall_item_meta_v y ";
        $sql .= " where x.mem_id = ? ";
        $sql .= " and x.cit_id = y.cit_id ";
        $sql .= "    ) b ";

        $sql .= " where a.cit_id = b.cit_id ";
                
        $rst = $this->db->query($sql, array($p['mem_id']));

        return $rst->result_array();
    }

    //판매 금액정보 조회
    public function get_sales_price_info($p)
    {

        $sql = "select cor_memo, cor_total_money ";
        $sql .= "from cb_cmall_order ";
        $sql .= "where cor_id = ? ";
        
        $rst = $this->db->query($sql, array($p['cor_id']));

        return $rst->result_array();
    }


    // 구매자 구매 목록 조회
    public function get_order_history($p)
    {
        $sql = "SELECT cor_id ";
        $sql .= "FROM cb_cmall_order ";
        $sql .= "where mem_id = ? ";
                
        $rst = $this->db->query($sql, array($p['mem_id']));

        return $rst->result_array();
    }

    // 상품 조회 이력
    public function insert_item_show_history($p)
    {
        $param = array(
            'cit_id' => $p['cit_id'],
            'mem_id' => $p['mem_id'],
            'show_dt' => cdate('Y-m-d H:i:s')
        );

        $this->db->insert('cmall_item_show_history', $param);
    }



    // 판매자 주문 및 상품 정보 조회
    public function get_sales_product_info($cor_id)
    {
        $sql = "select distinct a.cor_id, a.mem_id, a.cit_id, b.*, c.*, d.*, e.*";
        $sql .= "from cb_cmall_order_detail a ";
        $sql .= "    join ( ";
        $sql .= "        select cit_id, cit_key, cit_name, cit_status, cit_file_1, cit_lease_license_use, cit_mastering_license_use ";
        $sql .= "        from cb_cmall_item ";
        $sql .= "    ) b ";
        $sql .= "    on a.cit_id = b.cit_id ";
        $sql .= "    join ( ";
        $sql .= "        select cit_id, genre, bpm, subgenre, moods, trackType, hashTag ";
        $sql .= "            , cde_id, cde_price, cde_price_d, cde_quantity, cde_download, cde_originname ";
        $sql .= "            , cde_id_2, cde_price_2, cde_price_d_2, cde_quantity_2, cde_download_2, cde_originname_2 ";
        $sql .= "        from cb_cmall_item_meta_v ";
        $sql .= "    ) c ";
        $sql .= "    on a.cit_id = c.cit_id ";
        $sql .= "    join ( ";
        $sql .= "        select mem_id, mem_userid ";
        $sql .= "        from cb_member ";
        $sql .= "    ) d ";
        $sql .= "    on a.mem_id = d.mem_id ";
        $sql .= "    join ( ";
        $sql .= "        select cor_id, cor_memo, cor_total_money, cor_datetime, cor_status, status, cor_refund_price ";
        $sql .= "        from cb_cmall_order ";
        $sql .= "    ) e ";
        $sql .= "    on a.cor_id = e.cor_id ";
        $sql .= "where a.cor_id = ? ";

        $rst = $this->db->query($sql, array($cor_id));

        return $rst->result_array();
    }

    public function get_product_info($cit_id){
        $sql = "select distinct a.*, b.*, c.* ";
        $sql .= "from ( ";
        $sql .= "    select cit_id, cit_key, cit_name, cit_status, cit_file_1, cit_lease_license_use, cit_mastering_license_use, mem_id, cit_freebeat  ";
        $sql .= "    from cb_cmall_item ";
        $sql .= "     ) a ";
        $sql .= "    join ( ";
        $sql .= "      select cit_id, genre, bpm, subgenre, moods, trackType, hashTag ";
        $sql .= "      , cde_id, cde_price, cde_price_d, cde_quantity, cde_download, cde_originname, cde_filename ";
        $sql .= "      , cde_id_2, cde_price_2, cde_price_d_2, cde_quantity_2, cde_download_2, cde_originname_2, cde_filename_2 ";
        $sql .= "    from cb_cmall_item_meta_v ";
        $sql .= "     ) b ";
        $sql .= "    on a.cit_id = b.cit_id ";
        $sql .= "    join ( ";
        $sql .= "     select mem_id, mem_userid, mem_nickname ";
        $sql .= "     from cb_member ";
        $sql .= "    ) c ";
        $sql .= "    on a.mem_id = c.mem_id ";
        $sql .= "where a.cit_id = ? ";
        $sql .= " ";

        $rst = $this->db->query($sql, array($cit_id));

        return $rst->result_array();
    }

    public function get_order_info($cor_id){
        $sql = "SELECT distinct a.*, b.cit_id ";
        $sql .= "FROM cb_cmall_order a ";
        $sql .= "    , beatsomeone.cb_cmall_order_detail b ";
        $sql .= "    where a.cor_id = ? ";
        $sql .= "    and a.cor_id = b.cor_id ";
        $sql .= " ";

        $rst = $this->db->query($sql, array($cor_id));

        return $rst->result_array();
    }

    public function get_message_list($mem_id){

        $sql = " SELECT a.nte_id, a.recv_mem_id mem_id, a.related_note_id ";
        $sql .= "   , a.nte_content, a.nte_datetime, a.nte_read_datetime, a.nte_filename ";
        $sql .= "   , b.mem_nickname, b.mem_phone, b.mem_type, b.mem_profile_content ";
        $sql .= "FROM cb_note a, beatsomeone.cb_member b ";
        $sql .= "where a.send_mem_id = ? ";
        $sql .= "and a.nte_type = 1 ";
        $sql .= "and a.recv_mem_id = b.mem_id ";
        $sql .= "union all ";
        $sql .= "SELECT a.nte_id, a.send_mem_id mem_id, a.related_note_id ";
        $sql .= "   , a.nte_content, a.nte_datetime, a.nte_read_datetime, a.nte_filename ";
        $sql .= "   , b.mem_nickname, b.mem_phone, b.mem_type, b.mem_profile_content ";
        $sql .= "FROM cb_note a, beatsomeone.cb_member b ";
        $sql .= "where recv_mem_id = ? ";
        $sql .= "and nte_type = 2 ";
        $sql .= "and a.send_mem_id = b.mem_id ";
        $sql .= "order by nte_id ";
        $sql .= " ";
    

        /*
        $sql = "select a.*, b.nte_content ";
        $sql .= "from ( ";
        $sql .= "   select recv_mem_id, send_mem_id, max(nte_datetime) nte_datetime ";
        $sql .= "   , SUM(CASE WHEN nte_read_datetime IS NULL THEN 1 ELSE 0 END)  unreadcnt";
        $sql .= "   from cb_note";
        $sql .= "   where send_mem_id = ?";
        $sql .= "   and nte_type = 1";
        $sql .= "   group by recv_mem_id, send_mem_id";
        $sql .= "   ) a,";
        $sql .= "   (";
        $sql .= "   select recv_mem_id, nte_datetime, nte_content";
        $sql .= "   from cb_note";
        $sql .= "   where send_mem_id = ?";
        $sql .= "   and nte_type = 1";
        $sql .= "   ) b";
        $sql .= "   where a.recv_mem_id = b.recv_mem_id ";
        $sql .= "   and a.nte_datetime = b.nte_datetime ";
        $sql .= "union ";
        $sql .= "select a.*, b.nte_content ";
        $sql .= "from ( ";
        $sql .= "   select recv_mem_id, send_mem_id, max(nte_datetime) nte_datetime";
        $sql .= "   , SUM(CASE WHEN nte_read_datetime IS NULL THEN 1 ELSE 0 END)  unreadcnt";
        $sql .= "   from cb_note";
        $sql .= " where recv_mem_id = ?";
        $sql .= " and nte_type = 2";
        $sql .= " group by recv_mem_id, send_mem_id";
        $sql .= " ) a,";
        $sql .= " (";
        $sql .= " select recv_mem_id, send_mem_id, nte_datetime, nte_content";
        $sql .= " from cb_note";
        $sql .= " where recv_mem_id = ?";
        $sql .= " and nte_type = 2";
        $sql .= " ) b";
        $sql .= " where a.recv_mem_id = b.recv_mem_id ";
        $sql .= " and a.nte_datetime = b.nte_datetime ";
        $sql .= " ";
        */


        $rst = $this->db->query($sql, array($mem_id, $mem_id));

        return $rst->result_array();
    }

    public function get_message_detail($mem_id, $mid){

        $sql = "select nte_id, send_mem_id, recv_mem_id, nte_type, nte_content, nte_datetime, nte_read_datetime, nte_originname, nte_filename ";
        $sql .= "from cb_note  ";
        $sql .= "where send_mem_id = ? ";
        $sql .= "and recv_mem_id = ?  ";
        $sql .= "and nte_type = 1  ";
        $sql .= "union all  ";
        $sql .= "select nte_id, send_mem_id, recv_mem_id, nte_type, nte_content, nte_datetime, nte_read_datetime, nte_originname, nte_filename  ";
        $sql .= "from cb_note  ";
        $sql .= "where recv_mem_id = ?  ";
        $sql .= "and send_mem_id = ? ";
        $sql .= "and nte_type = 2  ";
        $sql .= "order by nte_id  ";
        $sql .= " ";

        $rst = $this->db->query($sql, array($mem_id, $mid, $mem_id, $mid));

        return $rst->result_array();
    }

    public function get_message_read($mem_id, $mid){

        $sql = "update beatsomeone.cb_note ";
        $sql .= "set nte_read_datetime = now()  ";
        $sql .= "where ( send_mem_id = ? and recv_mem_id = ? ) ";
        $sql .= "   or ( send_mem_id = ? and recv_mem_id = ?) ";
        $sql .= "and nte_read_datetime is null ";
        $sql .= " ";

        $rst = $this->db->query($sql, array($mem_id, $mid, $mid, $mem_id));

        return $rst;
    }
    
    public function insert_send_message($mem_id, $rmid, $message, $filename, $fileurlname){

        $sql = "insert into beatsomeone.cb_note values(0,?,?,1,0,'',?,0,now(),null,?,?) ";
        $rst = $this->db->query($sql, array($mem_id, $rmid, $message, $filename, $fileurlname));
        return $this->db->insert_id();;
    }

    public function insert_recv_message($mem_id, $rmid, $message, $filename, $fileurlname, $nte_id){

        $sql = "insert into beatsomeone.cb_note values(0,?,?,2,?,'',?,0,now(),null,?,?) ";
        $rst = $this->db->query($sql, array($mem_id, $rmid, $nte_id, $message, $filename, $fileurlname));
        return $this->db->insert_id();;
    }

    public function insert_membership_purchase_log($params)
    {
        $data = [
            'mem_id' => $params['mem_id'],
            'bill_term' => $params['bill_term'],
            'plan' => $params['plan'],
            'plan_name' => $params['plan_name'],
            'start_date' => $params['start_date'],
            'end_date' => $params['end_date'],
            'pay_method' => $params['pay_method'],
            'amount' => $params['amount'],
            'card_key' => $params['card_key']
        ];
        $this->db->insert('cb_member_membership_purchase_log', $data);
    }

    public function get_membership_purchase_log($where)
    {
        $sql = "select * ";
        $sql .= "from cb_member_membership_purchase_log  ";
        $sql .= "where mem_id = ".$where['mem_id']." ";
        $sql .= "and plan_name = '".$where['mgr_title']."' ";
        $sql .= "order by mmpl_datetime desc ";
        $sql .= " ";

        $rst = $this->db->query($sql);

        return $rst->result_array();
    }

    public function update_membership_member($memId, $usertype)
    {
        $updateData = [
            'mem_usertype' => $usertype
        ];

        $this->db->where('mem_id', $memId);
        $this->db->update('member', $updateData);
    }

    public function chk_membership_purchase_promotion($memId)
    {
        $this->db->select('COUNT(*) AS totalCount');
        $this->db->where(['mem_id' => $memId, 'pay_method' => 'promotion']);
        $qry = $this->db->get('member_membership_purchase_log');
        return $qry->row_array()['totalCount'];
    }

    public function set_extrincs($citId, $extrincs)
    {
        return $this->db->where('cit_id', $citId)
            ->set('extrincs', $extrincs)
            ->update('cmall_item');
    }

    public function get_mint_target()
    {
        $sql = "SELECT cit_id FROM cb_cmall_item WHERE extrincs = '' OR extrincs IS NULL ORDER BY cit_id ASC ";
        return $this->db->query($sql)->result_array();
    }

    public function get_gen_search_data()
    {
        $sql = "SELECT a.*, b.cit_name, b.similar_song, b.similar_singer, b.similar_musicians, b.other_tags, c.mem_nickname 
                FROM cb_cmall_item_meta_v a
                JOIN cb_cmall_item b ON a.cit_id = b.cit_id
                LEFT JOIN cb_member c ON b.mem_id = c.mem_id";
        return $this->db->query($sql)->result_array();
    }

    public function set_search_data($citId, $searchData, $expandSearchData)
    {
        return $this->db->where('cit_id', $citId)
            ->set('search_data', $searchData)
            ->set('expand_search_data', $expandSearchData)
            ->update('cmall_item');
    }
}
