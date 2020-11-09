<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmall_item_show_history_model extends CB_Model
{
    public $_table = 'cmall_item_show_history';

    public $allow_order_field = [
        'show_dt'
    ];

    /**
     * Cmall_item_show_history_model constructor.
     * @param string $_table
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($limit = '', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
        $select = 'cmall_item_show_history.*, cmall_item.mem_id as item_mem_id, cmall_item.cit_datetime, cmall_item.cit_hit, cmall_item.cit_name, cmall_item.cit_key, cmall_item.cit_file_1, member.mem_nickname, member.mem_firstname, member.mem_lastname';
        $join[] = array('table' => 'cmall_item', 'on' => 'cmall_item_show_history.cit_id = cmall_item.cit_id', 'type' => 'inner');
        $join = [
            [
                'table' => 'cmall_item',
                'on' => 'cmall_item_show_history.cit_id = cmall_item.cit_id',
                'type' => 'inner'
            ],
            [
                'table' => 'member',
                'on' => 'member.mem_id = cmall_item.mem_id',
                'type' => 'left'
            ],
        ];
        return $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop, 'cmall_item.cit_id');
    }
}