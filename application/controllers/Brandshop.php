<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Brand class
 *
 * Copyright (c) Inpreter
 * Cmall 기반 음원거래 사이트
 *
 * @author Inpreter (empicy@gmail.com)
 */

/**
 * Brand 페이지에 관한 controller 입니다.
 */
class Brandshop extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'cmall', 'dhtml_editor');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'accesslevel', 'cmalllib'));

		if ( ! $this->cbconfig->item('use_cmall')) {
			alert('이 웹사이트는 ' . html_escape($this->cbconfig->item('cmall_name')) . ' 기능을 사용하지 않습니다');
			return;
		}
	}

    /**
     * @param $user_nickname
     */
    public function shop($user_nickname)
    {
        $userinfo = $this->Member_model->get_by_nickname($user_nickname);
        if (empty($userinfo)) {
            alert('잘못된 접근 입니다', '/');
            return;
        }

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_cmall_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        $view['view']['brand']['mem_id'] = $userinfo['mem_id'];
        $view['view']['brand']['mem_userid'] = $userinfo['mem_userid'];
        $view['view']['brand']['mem_username'] = $userinfo['mem_username'];
        $view['view']['brand']['mem_nickname'] = $userinfo['mem_nickname'];
        $view['view']['canonical'] = site_url('/' . $userinfo['mem_nickname']);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_cmall');
        $meta_description = $this->cbconfig->item('site_meta_description_cmall');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_cmall');
        $meta_author = $this->cbconfig->item('site_meta_author_cmall');
        $page_name = $this->cbconfig->item('site_page_name_cmall');

        $searchconfig = array(
            '{컨텐츠몰명}',
        );
        $replaceconfig = array(
            $this->cbconfig->item('cmall_name'),
        );

        $page_title = str_replace($searchconfig, $replaceconfig, $page_title);
        $meta_description = str_replace($searchconfig, $replaceconfig, $meta_description);
        $meta_keywords = str_replace($searchconfig, $replaceconfig, $meta_keywords);
        $meta_author = str_replace($searchconfig, $replaceconfig, $meta_author);
        $page_name = str_replace($searchconfig, $replaceconfig, $page_name);

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'brand/list',
            'layout_dir' => $this->cbconfig->item('layout_beatsomeone'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_beatsomeone'),
            'use_sidebar' => $this->cbconfig->item('sidebar_cmall'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_cmall'),
            'skin_dir' => $this->cbconfig->item('skin_cmall'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_cmall'),
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );

        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    public function integrate()
    {
        // $userinfo = $this->Member_model->get_by_userid($userid);
        // if (empty($userinfo)) {
        //     alert('잘못된 접근 입니다', '/');
        //     return;
        // }

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_cmall_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        // $view['view']['brand']['mem_id'] = $userinfo['mem_id'];
        // $view['view']['brand']['mem_userid'] = $userinfo['mem_userid'];
        // $view['view']['brand']['mem_username'] = $userinfo['mem_username'];
        // $view['view']['brand']['mem_nickname'] = $userinfo['mem_nickname'];
        // $view['view']['canonical'] = site_url('brand/' . $userid);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_cmall');
        $meta_description = $this->cbconfig->item('site_meta_description_cmall');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_cmall');
        $meta_author = $this->cbconfig->item('site_meta_author_cmall');
        $page_name = $this->cbconfig->item('site_page_name_cmall');

        $searchconfig = array(
            '{컨텐츠몰명}',
        );
        $replaceconfig = array(
            $this->cbconfig->item('cmall_name'),
        );

        $page_title = str_replace($searchconfig, $replaceconfig, $page_title);
        $meta_description = str_replace($searchconfig, $replaceconfig, $meta_description);
        $meta_keywords = str_replace($searchconfig, $replaceconfig, $meta_keywords);
        $meta_author = str_replace($searchconfig, $replaceconfig, $meta_author);
        $page_name = str_replace($searchconfig, $replaceconfig, $page_name);

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'brandshop/list',
            'layout_dir' => $this->cbconfig->item('layout_beatsomeone'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_beatsomeone'),
            'use_sidebar' => $this->cbconfig->item('sidebar_cmall'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_cmall'),
            'skin_dir' => $this->cbconfig->item('skin_cmall'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_cmall'),
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );

        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }
}