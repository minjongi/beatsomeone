<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_log_model extends CB_Model
{
    public $_table = 'cb_cron_log';

    function __construct()
    {
        parent::__construct();
    }

    public function cron_log()
    {
        $data = [
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->_table, $data);
    }
}
?>