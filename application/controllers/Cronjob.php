<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Cronjog class
 * @author redsunset
 */

class cronjob extends CB_Controller
{
    protected $models = array('');
    protected $helpers = array('form', 'array');

    function __contrunct()
    {
        parent::__construct();

        $this->load->library(array('pagination', 'querystring'));
    }
    function cronjob()
    {
        echo "cron job-------------1-----------\n";
        $this->load->model('Cron_log_model');
        $this->Cron_log_model->cron_log();
    }
}
?>