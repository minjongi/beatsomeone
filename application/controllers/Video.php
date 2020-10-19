<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CB_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_board_post_lists';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_board_list');
        $meta_description = $this->cbconfig->item('site_meta_description_board_list');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_board_list');
        $meta_author = $this->cbconfig->item('site_meta_author_board_list');
        $page_name = $this->cbconfig->item('site_page_name_board_list');

        $searchconfig = array(
            '{게시판명}',
        );

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'video',
            'layout_dir' => $this->cbconfig->item('layout_beatsomeone'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_beatsomeone'),
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