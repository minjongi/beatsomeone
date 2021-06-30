<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Paypal class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Payletter extends CI_Controller
{

	private $CI;

	function __construct()
	{
		$this->CI = & get_instance();
	}

	public function procComplete()
	{
        ini_set('display_errors', '0');
        $this->CI->load->model('Cmall_order_model');

        $paypalData = $_POST["paypal_data"];

        if (empty($paypalData)) {
            return 0;
        }

        $params['raw_data'] = $paypalData;
        $paypalData = json_decode($paypalData, true);
        $params['id'] = $paypalData['id'];
        $params['create_time'] = $paypalData['create_time'];
        $params['update_time'] = $paypalData['update_time'];
        $params['state'] = $paypalData['state'];
        $params['intent'] = $paypalData['intent'];
        $params['payment_method'] = $paypalData['payer']['payment_method'];
        $params['email'] = $paypalData['payer']['payer_info']['email'];
        $params['first_name'] = $paypalData['payer']['payer_info']['first_name'];
        $params['last_name'] = $paypalData['payer']['payer_info']['last_name'];
        $params['payer_id'] = $paypalData['payer']['payer_info']['payer_id'];
        $params['invoice_number'] = $paypalData['transactions'][0]['invoice_number'];
        $params['amount'] = $paypalData['transactions'][0]['amount']['total'];
        $params['currency'] = $paypalData['transactions'][0]['amount']['total'];
        $params['links'] = $paypalData['links']['href'];

        $this->CI->Cmall_order_model->paypal_log_insert($params);

        return $params['amount'];
    }
}
