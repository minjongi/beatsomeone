<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membergroup_history_model extends CB_Model {

    /**
     * 테이블명
     */
    public $_table = 'member_membership_purchase_log';

    /**
     * 사용되는 테이블의 프라이머리키
     */
    public $primary_key = 'mmpl_id'; // 사용되는 테이블의 프라이머리키

    function __construct()
    {
        parent::__construct();
    }

    public function get_admin_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
        $select = 'member_membership_purchase_log.*, member.mem_id, member.mem_userid, member.mem_nickname, member.mem_is_admin, member.mem_icon';
        $join[] = array('table' => 'member', 'on' => 'member_membership_purchase_log.mem_id = member.mem_id', 'type' => 'left');
        return $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
    }

}
