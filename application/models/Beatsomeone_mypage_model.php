<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Beatsomeone Mypage model class *
 *
 * Copyright (c) inpreter
 *
 * @author inpreter (empicy@gmail.com)
 */

class Beatsomeone_mypage_model extends CB_Model
{

	function __construct()
	{
		parent::__construct();
	}


    /**
     * DashBoard : Order Details
     * @param $mem_id 사용자 ID
     * @return mixed
     */
    public function getOrderDetails($mem_id)
    {
        $this->db
            ->select('mem_id, cod_status, count(*) AS cnt')
            ->where('mem_id',$mem_id)
            ->group_by(array('mem_id', 'cod_status'));

        $qry = $this->db->get('cb_cmall_order_detail');

        $result = $qry->result_array();

        return $result;
    }

    /**
     * DashBoard : Product Details
     * @param $mem_id 사용자 ID
     * @return int[]
     */
    public function getProductDetails($mem_id)
    {
        return array(
            'Total' => 12,
            'Selling' => 2,
            'Pending' => 7,
        );
    }

    /**
     * DashBoard : ExpiredSoon
     * @param $mem_id 사용자 ID
     * @return mixed
     */
    public function getExpiredSoon($mem_id)
    {

        $where = array(
            'd.mem_id' => $mem_id,
        );

        $this->db
            ->select('d.mem_id, d.cit_id, i.cit_key, i.cit_name, p.musician, i.cit_file_1 as coverImg, DATE_ADD(NOW(), INTERVAL 4 HOUR) as expireTm')
            ->join('cb_cmall_item as i','i.cit_id = d.cit_id','inner')
            ->join('cb_cmall_item_meta_v as p','p.cit_id = d.cit_id','left')
            ->where($where)
            ->limit(3);

        $qry = $this->db->get('cmall_order_detail as cb_d');

        $result = $qry->result_array();
        return $result;
    }

    /**
     * DashBoard : RecentlyListen
     * @param $mem_id 사용자 ID
     * @return mixed
     */
    public function getRecentlyListen($mem_id)
    {

        $where = array(
            'd.mem_id' => $mem_id,
        );


        $this->db
            ->select('d.mem_id, d.cit_id, i.cit_key, i.cit_name, p.musician, i.cit_file_1 as coverImg, DATE_ADD(NOW(), INTERVAL 4 HOUR) as expireTm')
            ->join('cb_cmall_item as i','i.cit_id = d.cit_id','inner')
            ->join('cb_cmall_item_meta_v as p','p.cit_id = d.cit_id','left')
            ->where($where)
            ->order_by('ish_id','desc')
            ->limit(6);

        $qry = $this->db->get('cmall_item_show_history as cb_d');

        $result = $qry->result_array();
        return $result;
    }

    /**
     * DashBoard : Message
     * @param $mem_id 사용자 ID
     * @return array[]
     */
    public function getMessage($mem_id)
    {
        return array(
            array(
                'mem_id' => 1,
                'mem_name' => 'User 1',
                'mem_photo' => '2020/03/9d8475aaa1fcc0736a927b791bd826e4.png',
                'sendDt' => new DateTime(),
                'status' => 'Unread'
            ),
            array(
                'mem_id' => 1,
                'mem_name' => 'User 1',
                'mem_photo' => '2020/03/9d8475aaa1fcc0736a927b791bd826e4.png',
                'sendDt' => new DateTime(),
                'status' => 'Read'
            ),
            array(
                'mem_id' => 2,
                'mem_name' => 'User 2',
                'mem_photo' => '2020/03/ba3c4af02c9648a053cdc2928115b444.png',
                'sendDt' => new DateTime(),
                'status' => 'Read'
            ),

        );
    }

    /**
     * DashBoard : SupportCase
     * @param $mem_id 사용자 ID
     * @return array[]
     */
    public function getSupportCase($mem_id)
    {

        return array(
            array(
                'sp_id' => 1,
                'title' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'contents' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'regDt' => new DateTime(),
                'status' => 'Open'
            ),
            array(
                'sp_id' => 2,
                'title' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'contents' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'regDt' => new DateTime(),
                'status' => 'Closed'
            ),
            array(
                'sp_id' => 3,
                'title' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'contents' => 'What is the usage range of my bought beatsomeone of this item contains music of tension',
                'regDt' => new DateTime(),
                'status' => 'Closed'
            ),

        );
    }

    /**
     * DashBoard : Settlement Overview
     * @param $mem_id 사용자 ID
     * @return int[]
     */
    public function getSettlementOverview($mem_id)
    {

        return array(
            'EstimatedSales' => 123456, // EstimatedSales
            'EstimatedSales_C' => 40093, // EstimatedSales 증감분
            'EstimatedSettlement' => 93409, // EstimatedSettlement
            'EstimatedSettlement_C' => -10093, // EstimatedSettlement 증감분
            'LastMonthSettlement' => 80039, // LastMonthSettlement
            'LastMonthSettlement_C' => 63093, // LastMonthSettlement 증감분
        );
    }

    /**
     * DashBoard : Chart
     * 중간에 빠지는 날도 채워 널어야 차트가 빠지지 않고 그려짐
     * @param $mem_id 사용자 ID
     * @return array[]
     */
    public function getChart($mem_id)
    {

        return array(
            // 이번달 정보
            array(
                'category' => 'Estimated settlement',
                'data' => array(
                    '2020-04-29'=>82100,
                    '2020-04-30'=>73200,
                    '2020-05-01'=>79330,
                    '2020-05-02'=>72330,
                    '2020-05-03'=>92332,
                    '2020-05-04'=>80030,
                    '2020-05-05'=>90030,
                    '2020-05-06'=>120030,
                    '2020-05-07'=>100030,
                    '2020-05-08'=>113030,

                ),
            ),
            // 다음달 정보
            array(
                'category' => 'Last Month settlement',
                'data' => array(
                    '2020-04-29'=>52100,
                    '2020-04-30'=>73200,
                    '2020-05-01'=>59330,
                    '2020-05-02'=>31000,
                    '2020-05-03'=>92332,
                    '2020-05-04'=>120030,
                    '2020-05-05'=>40030,
                    '2020-05-06'=>20030,
                    '2020-05-07'=>10030,
                    '2020-05-08'=>6030,
                    '2020-05-09'=>30030,
                ),
            ),

        );
    }

    /**
     * Manage Infomation : 사용자 이름 변경 중복 체크
     * @param $mem_id 사용자 ID
     * @param $mem_username 변경할 사용자 이름
     * @return bool[]
     */
    public function checkDuplicateMemUsername($mem_id, $mem_username)
    {
        $where = array(
            'm.mem_id !=' => $mem_id,
            'm.mem_username' => $mem_username
        );

        $this->db
            ->select('mem_id')
            ->where($where);

        $qry = $this->db->get('cb_member as m');

        return array( 'result' => $qry->num_rows() > 0);
    }

    /**
     * Manage Infomation : 사용자 이름 변경 처리
     * @param $mem_id 사용자 ID
     * @param $mem_username 변경할 사용자 이름
     * @return array
     */
    public function updateMemUsername($mem_id, $mem_username)
    {
        $where = array(
            'mem_id' => $mem_id,
        );

        $r = $this->db
            ->where($where)
            ->set('mem_username', $mem_username)
            ->update('cb_member');


        return array( 'result' => $r);
    }

    /**
     * Manage Infomation : 이메일 변경 중복 확인
     * @param $mem_id 사용자 ID
     * @param $mem_email 변경할 이메일
     * @return bool[]
     */
    public function checkDuplicateEmail($mem_id, $mem_email)
    {
        $where = array(
            'm.mem_id !=' => $mem_id,
            'm.mem_email' => $mem_email
        );

        $this->db
            ->select('mem_id')
            ->where($where);

        $qry = $this->db->get('cb_member as m');

        return array( 'result' => $qry->num_rows() > 0);
    }

    /**
     * Manage Infomation : 이메일 변경 처리
     * @param $mem_id 사용자 ID
     * @param $mem_email 변경 이메일
     * @return array
     */
    public function updateEmail($mem_id, $mem_email)
    {
        $where = array(
            'mem_id' => $mem_id,
        );

        $r = $this->db
            ->where($where)
            ->set('mem_email', $mem_email)
            ->update('cb_member');


        return array( 'result' => $r);
    }

    /**
     * Manage Infomation : 사용자 정보 업데이트
     * @param $mem_id 사용자 ID
     * @param $param 변경 사용자 정보
     * @return array
     */
    public function updateUserInfo($mem_id, $param)
    {
        $where = array(
            'mem_id' => $mem_id,
        );

        $r = $this->db
            ->where($where)
            ->set($param)
            ->update('cb_member');


        return array( 'result' => $r);
    }

    /**
     * Manage Infomation : 패스워드 변경 처리
     * @param $mem_id 사용자 ID
     * @param $param 변경 패스워드 정보
     * @return array
     */
    public function updateUserPassword($mem_id, $param)
    {
        $where = array(
            'mem_id' => $mem_id,
        );

        $r = $this->db
            ->where($where)
            ->set($param)
            ->update('cb_member');


        return array( 'result' => $r);
    }

}
