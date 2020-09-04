<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmall_settlement_history_model extends CB_Model
{
    public $_table = 'cmall_settlement_history';

    public $primary_key = 'csh_id';

    function __construct()
    {
        parent::__construct();
    }
}