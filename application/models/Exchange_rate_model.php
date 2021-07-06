<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class Exchange_rate_model extends CB_Model
{
	/**
	 * 테이블명
	 */
	public $_table = 'exchange_rate';
    /**
     * 사용되는 테이블의 프라이머리키
     */
    public $primary_key = 'er_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}
}
