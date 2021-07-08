<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Mypage class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 마이페이지와 관련된 controller 입니다.
 */
class Mypage extends CB_Controller
{

    /**
     * 모델을 로딩합니다
     */
    protected $models = array();

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('pagination', 'querystring'));

    }


    /**
     * 마이페이지입니다
     */
    public function index($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_index';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);


        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        $view['view']['member_group_name'] = '';
        $member_group = $this->member->group();
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                if ($view['view']['member_group_name']) {
                    $view['view']['member_group_name'] .= ', ';
                }
                $view['view']['member_group_name'] .= element('mgr_title', $item);
            }
        }

        // 사용자 정보 추가
        $userinfo = $this->Member_model->get_by_memid($mem_id);
        $userinfo = array(
            'mem_id' => $userinfo['mem_id'],
            'mem_userid' => $userinfo['mem_userid'],
            'mem_username' => $userinfo['mem_username'],
            'mem_address1' => $userinfo['mem_address1'],
            'mem_email' => $userinfo['mem_email'],
            'mem_firstname' => $userinfo['mem_firstname'],
            'mem_lastname' => $userinfo['mem_lastname'],
            'mem_type' => $userinfo['mem_type'],
            'mem_profile_content' => $userinfo['mem_profile_content'],
            'mem_usertype' => $userinfo['mem_usertype'],
            'mem_nickname' => $userinfo['mem_nickname'],
            'mem_photo' => $userinfo['mem_photo'],
            'mem_is_admin' => $userinfo['mem_is_admin'],
        );
        $member_group = $this->member->group();
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                $userinfo['mem_group'] = $item;
            }
        }
        $view['view']['userinfo'] = $userinfo;

//        /**
//         * 페이지네이션을 생성합니다
//         */
//        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
//        $config['total_rows'] = $result['total_rows'];
//        $config['per_page'] = $per_page;
//        $this->pagination->initialize($config);
//        $view['view']['paging'] = $this->pagination->create_links();
//        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage');
        $page_name = $this->cbconfig->item('site_page_name_mypage');

        /*
        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'main',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );
        */

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
//            'skin' => 'mypage/dashboard',
            'skin' => 'mypage/mypage',
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
//        // ----- New ------- //
//        // 이벤트 라이브러리를 로딩합니다
//        $eventname = 'event_mypage_index';
//        $this->load->event($eventname);
//
//        /**
//         * 로그인이 필요한 페이지입니다
//         */
//        required_user_login();
//
//        $view = array();
//        $view['view'] = array();
//
//        // 이벤트가 존재하면 실행합니다
//        $view['view']['event']['before'] = Events::trigger('before', $eventname);
//
//        $registerform = $this->cbconfig->item('registerform');
//        $view['view']['memberform'] = json_decode($registerform, true);
//
//        $view['view']['member_group_name'] = '';
//        $member_group = $this->member->group();
//        if ($member_group && is_array($member_group)) {
//
//            $this->load->model('Member_group_model');
//
//            foreach ($member_group as $gkey => $gval) {
//                $item = $this->Member_group_model->item(element('mgr_id', $gval));
//                if ($view['view']['member_group_name']) {
//                    $view['view']['member_group_name'] .= ', ';
//                }
//                $view['view']['member_group_name'] .= element('mgr_title', $item);
//            }
//        }
//
//        // 이벤트가 존재하면 실행합니다
//        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);
//        $mem_userid = $this->member->item('mem_userid');
//
//
//        /**
//         * 레이아웃을 정의합니다
//         */
//        $page_title = $this->cbconfig->item('site_meta_title_mypage');
//        $meta_description = $this->cbconfig->item('site_meta_description_mypage');
//        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
//        $meta_author = $this->cbconfig->item('site_meta_author_mypage');
//        $page_name = $this->cbconfig->item('site_page_name_mypage');
//
//        $layoutconfig = array(
//            'path' => 'mypage',
//            'layout' => 'layout_new',
//            'skin' => 'main',
//            'layout_dir' => $this->cbconfig->item('layout_mypage'),
//            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
//            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
//            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
//            'skin_dir' => $this->cbconfig->item('skin_mypage'),
//            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
//            'page_title' => $page_title,
//            'meta_description' => $meta_description,
//            'meta_keywords' => $meta_keywords,
//            'meta_author' => $meta_author,
//            'page_name' => $page_name,
//        );
//        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
//        $this->data = $view;
//        $this->layout = element('layout_skin_file', element('layout', $view));
//        $this->view = element('view_skin_file', element('layout', $view));
    }


    /**
     * 마이페이지>나의작성글 입니다
     */
    public function post()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_post';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model(array('Post_model', 'Post_file_model'));

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Post_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? $this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'post.mem_id' => $mem_id,
            'post_del' => 0,
        );
        $result = $this->Post_model
            ->get_post_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
                $result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
                $result['list'][$key]['num'] = $list_num--;
                if (element('post_image', $val)) {
                    $filewhere = array(
                        'post_id' => element('post_id', $val),
                        'pfi_is_image' => 1,
                    );
                    $file = $this->Post_file_model
                        ->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
                    $result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 50, 40);
                } else {
                    $result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 50, 40);
                }
            }
        }

        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/post') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_post');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_post');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_post');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_post');
        $page_name = $this->cbconfig->item('site_page_name_mypage_post');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'post',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>나의작성글(댓글) 입니다
     */
    public function comment()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_comment';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $this->load->model(array('Post_model', 'Comment_model'));

        $findex = $this->Comment_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'comment.mem_id' => $mem_id,
        );
        $result = $this->Comment_model
            ->get_comment_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $post = $this->Post_model
                    ->get_one(element('post_id', $val), 'brd_id');
                $brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
                $result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/comment') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_comment');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_comment');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_comment');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_comment');
        $page_name = $this->cbconfig->item('site_page_name_mypage_comment');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'comment',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>포인트 입니다
     */
    public function point()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_point';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        if (!$this->cbconfig->item('use_point')) {
            alert('이 웹사이트는 포인트 기능을 제공하지 않습니다');
        }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model('Point_model');
        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Point_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'point.mem_id' => $mem_id,
        );
        $result = $this->Point_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        $result['plus'] = 0;
        $result['minus'] = 0;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['num'] = $list_num--;
                if (element('poi_point', $val) > 0) {
                    $result['plus'] += element('poi_point', $val);
                } else {
                    $result['minus'] += element('poi_point', $val);
                }
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/point') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_point');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_point');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_point');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_point');
        $page_name = $this->cbconfig->item('site_page_name_mypage_point');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'point',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>팔로우 입니다
     */
    public function followinglist()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_followinglist';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model('Follow_model');

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Follow_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'follow.mem_id' => $mem_id,
        );
        $result = $this->Follow_model
            ->get_following_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['display_name'] = display_username(
                    element('mem_userid', $val),
                    element('mem_nickname', $val),
                    element('mem_icon', $val)
                );
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        $view['view']['following_total_rows'] = $result['total_rows'];
        $countwhere = array(
            'target_mem_id' => $mem_id,
        );
        $view['view']['followed_total_rows'] = $this->Follow_model->count_by($countwhere);

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/followinglist') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_followinglist');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_followinglist');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followinglist');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_followinglist');
        $page_name = $this->cbconfig->item('site_page_name_mypage_followinglist');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'followinglist',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>팔로우(Followed) 입니다
     */
    public function followedlist()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_followedlist';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model('Follow_model');
        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Follow_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'follow.target_mem_id' => $mem_id,
        );
        $result = $this->Follow_model
            ->get_followed_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['display_name'] = display_username(
                    element('mem_userid', $val),
                    element('mem_nickname', $val),
                    element('mem_icon', $val)
                );
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        $view['view']['followed_total_rows'] = $result['total_rows'];
        $countwhere = array(
            'mem_id' => $mem_id,
        );
        $view['view']['following_total_rows'] = $this->Follow_model->count_by($countwhere);

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/followedlist') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_followedlist');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_followedlist');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_followedlist');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_followedlist');
        $page_name = $this->cbconfig->item('site_page_name_mypage_followedlist');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'followedlist',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>추천 입니다
     */
    public function like_post()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_like_post';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model(array('Like_model', 'Post_file_model'));
        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Like_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'like.mem_id' => $mem_id,
            'lik_type' => 1,
            'target_type' => 1,
            'post.post_del' => 0,
        );
        $result = $this->Like_model
            ->get_post_like_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $brd_key = $this->board->item_id('brd_key', element('brd_id', $val));
                $result['list'][$key]['post_url'] = post_url($brd_key, element('post_id', $val));
                $result['list'][$key]['num'] = $list_num--;
                $images = '';
                if (element('post_image', $val)) {
                    $filewhere = array(
                        'post_id' => element('post_id', $val),
                        'pfi_is_image' => 1,
                    );
                    $images = $this->Post_file_model
                        ->get_one('', '', $filewhere, '', '', 'pfi_id', 'ASC');
                }
                $result['list'][$key]['images'] = $images;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/like_post') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_like_post');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_like_post');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_post');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_like_post');
        $page_name = $this->cbconfig->item('site_page_name_mypage_like_post');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'like_post',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>추천(댓글) 입니다
     */
    public function like_comment()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_like_comment';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model(array('Like_model', 'Post_model'));
        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Like_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'like.mem_id' => $mem_id,
            'lik_type' => 1,
            'target_type' => 2,
        );
        $result = $this->Like_model
            ->get_comment_like_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $post = $this->Post_model->get_one(element('post_id', $val), 'brd_id');
                $brd_key = $this->board->item_id('brd_key', element('brd_id', $post));
                $result['list'][$key]['comment_url'] = post_url($brd_key, element('post_id', $val)) . '#comment_' . element('cmt_id', $val);
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/like_comment') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_like_comment');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_like_comment');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_like_comment');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_like_comment');
        $page_name = $this->cbconfig->item('site_page_name_mypage_like_comment');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'like_comment',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>스크랩 입니다
     */
    public function scrap()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_scrap';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model('Scrap_model');
        /**
         * Validation 라이브러리를 가져옵니다
         */
        $this->load->library('form_validation');
        /**
         * 전송된 데이터의 유효성을 체크합니다
         */
        $config = array(
            array(
                'field' => 'scr_id',
                'label' => 'SCRAP ID',
                'rules' => 'trim|required|numeric',
            ),
            array(
                'field' => 'scr_title',
                'label' => '제목',
                'rules' => 'trim',
            ),
        );
        $this->form_validation->set_rules($config);


        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        $alert_message = '';
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $scr_title = $this->input->post('scr_title', null, '');
            $updatedata = array(
                'scr_title' => $scr_title,
            );
            $this->Scrap_model->update($this->input->post('scr_id'), $updatedata);
            $alert_message = '제목이 저장되었습니다';
        }

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;
        $findex = $this->Scrap_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'scrap.mem_id' => $mem_id,
            'post.post_del' => 0,
        );
        $result = $this->Scrap_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;

        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                $result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));

                $result['list'][$key]['post_url'] = post_url(element('brd_key', $board), element('post_id', $val));
                $result['list'][$key]['board_url'] = board_url(element('brd_key', $board));
                $result['list'][$key]['delete_url'] = site_url('mypage/scrap_delete/' . element('scr_id', $val) . '?' . $param->output());
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;
        $view['view']['alert_message'] = $alert_message;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/scrap') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_scrap');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_scrap');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_scrap');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_scrap');
        $page_name = $this->cbconfig->item('site_page_name_mypage_scrap');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'scrap',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>스크랩삭제 입니다
     */
    public function scrap_delete($scr_id = 0)
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_scrap_delete';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $scr_id = (int)$scr_id;
        if (empty($scr_id) or $scr_id < 1) {
            show_404();
        }

        $this->load->model('Scrap_model');
        $scrap = $this->Scrap_model->get_one($scr_id);

        if (!element('scr_id', $scrap)) {
            show_404();
        }
        if ((int)element('mem_id', $scrap) !== $mem_id) {
            show_404();
        }

        $this->Scrap_model->delete($scr_id);

        // 이벤트가 존재하면 실행합니다
        Events::trigger('after', $eventname);

        /**
         * 삭제가 끝난 후 목록페이지로 이동합니다
         */
        $this->session->set_flashdata(
            'message',
            '정상적으로 삭제되었습니다'
        );
        $param =& $this->querystring;

        redirect('mypage/scrap?' . $param->output());
    }


    /**
     * 마이페이지>로그인기록 입니다
     */
    public function loginlog()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage_loginlog');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'loginlog',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>음원등록 입니다
     */
    public function regist_item($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 사용자 정보 추가
        $userinfo = $this->Member_model->get_by_memid($mem_id);
        $userinfo = array(
            'mem_id' => $userinfo['mem_id'],
            'mem_userid' => $userinfo['mem_userid'],
            'mem_username' => $userinfo['mem_username'],
            'mem_address1' => $userinfo['mem_address1'],
            'mem_email' => $userinfo['mem_email'],
            'mem_firstname' => $userinfo['mem_firstname'],
            'mem_lastname' => $userinfo['mem_lastname'],
            'mem_type' => $userinfo['mem_type'],
            'mem_profile_content' => $userinfo['mem_profile_content'],
            'mem_usertype' => $userinfo['mem_usertype'],
            'mem_nickname' => $userinfo['mem_nickname'],
            'mem_photo' => $userinfo['mem_photo'],
            'mem_is_admin' => $userinfo['mem_is_admin'],
        );
        $member_group = $this->member->group();
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                $userinfo['mem_group'] = $item;
            }
        }
        $view['view']['userinfo'] = $userinfo;

        if (strpos($userinfo['mem_group']['mgr_title'], 'buyer') !== false) {
            redirect("/");
        }

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/regist_item',
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

//        $layoutconfig = array(
//            'path' => 'mypage',
//            'layout' => 'layout',
//            'skin' => 'regist_item',
//            'layout_dir' => $this->cbconfig->item('layout_mypage'),
//            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
//            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
//            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
//            'skin_dir' => $this->cbconfig->item('skin_mypage'),
//            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
//            'page_title' => $page_title,
//            'meta_description' => $meta_description,
//            'meta_keywords' => $meta_keywords,
//            'meta_author' => $meta_author,
//            'page_name' => $page_name,
//        );
        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }

    /**
     * 마이페이지>음원등록내역 입니다
     */
    public function list_item($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/list_item',
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
        /*
        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'list_item',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
            'page_title' => $page_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
            'meta_author' => $meta_author,
            'page_name' => $page_name,
        );
        */
        $view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
        $this->data = $view;
        $this->layout = element('layout_skin_file', element('layout', $view));
        $this->view = element('view_skin_file', element('layout', $view));
    }


    /**
     * 마이페이지>profilemod 입니다
     */
    public function profilemod($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/profilemod',
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

    /**
     * 마이페이지>inquiry 입니다
     */
    public function inquiry($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/inquiry',
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

    /**
     * 마이페이지>faq 입니다
     */
    public function faq($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/faq',
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


    /**
     * 마이페이지>mybilling 입니다
     */
    public function mybilling($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/mybilling',
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


    /**
     * 마이페이지>mybillingView 입니다
     */
    public function mybillingView($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/mybillingview',
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


    /**
     * 마이페이지>myCancell 입니다
     */
    public function mycancelList($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/mycancellist',
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

    /**
     * 마이페이지>myCancellview 입니다
     */
    public function mycancelView($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/mycancelview',
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

    /**
     * 마이페이지>calchistory 입니다
     */
    public function calchistory($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/calchistory',
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


    /**
     * 마이페이지>message 입니다
     */
    public function message($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/message',
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


    /**
     * 마이페이지>saleshistory 입니다
     */
    public function saleshistory($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/saleshistory',
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


    /**
     * 마이페이지>seller 입니다
     */
    public function seller($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/seller',
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


    /**
     * 마이페이지>video 입니다
     */
    public function video($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/video',
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


    /**
     * 마이페이지>판매내역 입니다
     */
    public function status_item()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $page = (((int)$this->input->get('page')) > 0) ? ((int)$this->input->get('page')) : 1;

        $this->load->model('Member_login_log_model');

        $findex = $this->Member_login_log_model->primary_key;
        $forder = 'desc';

        $per_page = $this->cbconfig->item('list_count') ? (int)$this->cbconfig->item('list_count') : 20;
        $offset = ($page - 1) * $per_page;

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $where = array(
            'mem_id' => $mem_id,
        );
        $result = $this->Member_login_log_model
            ->get_list($per_page, $offset, $where, '', $findex, $forder);
        $list_num = $result['total_rows'] - ($page - 1) * $per_page;
        if (element('list', $result)) {
            foreach (element('list', $result) as $key => $val) {
                if (element('mll_useragent', $val)) {
                    $userAgent = get_useragent_info(element('mll_useragent', $val));
                    $result['list'][$key]['browsername'] = $userAgent['browsername'];
                    $result['list'][$key]['browserversion'] = $userAgent['browserversion'];
                    $result['list'][$key]['os'] = $userAgent['os'];
                    $result['list'][$key]['engine'] = $userAgent['engine'];
                }
                $result['list'][$key]['num'] = $list_num--;
            }
        }
        $view['view']['data'] = $result;

        /**
         * 페이지네이션을 생성합니다
         */
        $config['base_url'] = site_url('mypage/loginlog') . '?' . $param->replace('page');
        $config['total_rows'] = $result['total_rows'];
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $view['view']['paging'] = $this->pagination->create_links();
        $view['view']['page'] = $page;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'mypage',
            'layout' => 'layout',
            'skin' => 'status_item',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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


    /**
     * 마이페이지>sellerreg 입니다
     */
    public function sellerreg($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/sellerreg',
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

    /**
     * 마이페이지>찜하기 입니다
     */
    public function favorites($cit_id = '')
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_loginlog';
        $this->load->event($eventname);
        $this->load->helper(array('cmall'));

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');

        $view = array();
        $view['view'] = array();

        $member = $this->member->get_member();
        $view['view']['member'] = $member;
        $view['view']['member_group_name'] = '';
        if ($member) {
            $member_group = $this->member->group();
            if ($member_group && is_array($member_group)) {

                $this->load->model('Member_group_model');

                foreach ($member_group as $gkey => $gval) {
                    $item = $this->Member_group_model->item(element('mgr_id', $gval));
                    if ($view['view']['member_group_name']) {
                        $view['view']['member_group_name'] .= ', ';
                    }
                    $view['view']['member_group_name'] .= element('mgr_title', $item);
                }
            }
        }

        /*
         * Business
        */
        $view['view']['cit_id'] = $cit_id;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = 'Beat Someone';
        $meta_description = $this->cbconfig->item('site_meta_description_mypage_loginlog');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage_loginlog');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage_loginlog');
        $page_name = $this->cbconfig->item('site_page_name_mypage_loginlog');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/favorites',
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

    public function current_user() {
        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $mem_id = (int)$this->member->item('mem_id');
        $userinfo = $this->Member_model->get_by_memid($mem_id);
        $userinfo = array(
            'mem_id' => $userinfo['mem_id'],
            'mem_userid' => $userinfo['mem_userid'],
            'mem_username' => $userinfo['mem_username'],
            'mem_address1' => $userinfo['mem_address1'],
            'mem_email' => $userinfo['mem_email'],
            'mem_firstname' => $userinfo['mem_firstname'],
            'mem_lastname' => $userinfo['mem_lastname'],
            'mem_type' => $userinfo['mem_type'],
            'mem_profile_content' => $userinfo['mem_profile_content'],
            'mem_usertype' => $userinfo['mem_usertype'],
            'mem_nickname' => $userinfo['mem_nickname'],
            'mem_photo' => $userinfo['mem_photo'],
            'mem_is_admin' => $userinfo['mem_is_admin'],
        );
        $member_group = $this->member->group();
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                $userinfo['mem_group'] = $item;
            }
        }
        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($userinfo));
    }

    public function upgrade()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_mypage_upgrade';
        $this->load->event($eventname);

        /**
         * 로그인이 필요한 페이지입니다
         */
        required_user_login();

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $view['view']['member_group_name'] = '';
        $member_group = $this->member->group();
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                if ($view['view']['member_group_name']) {
                    $view['view']['member_group_name'] .= ', ';
                }
                $view['view']['member_group_name'] .= element('mgr_title', $item);
            }
        }

//        if ($view['view']['member_group_name'] != 'buyer') {
//            redirect("/mypage");
//        }

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);


        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_mypage');
        $meta_description = $this->cbconfig->item('site_meta_description_mypage');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_mypage');
        $meta_author = $this->cbconfig->item('site_meta_author_mypage');
        $page_name = $this->cbconfig->item('site_page_name_mypage');

        $layoutconfig = array(
            'path' => 'beatsomeone',
            'layout' => 'layout',
            'skin' => 'mypage/upgrade',
            'layout_dir' => $this->cbconfig->item('layout_mypage'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_mypage'),
            'use_sidebar' => $this->cbconfig->item('sidebar_mypage'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_mypage'),
            'skin_dir' => $this->cbconfig->item('skin_mypage'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_mypage'),
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

    public function post_upgrade()
    {
        required_user_login();

        $this->output->set_content_type('text/json');

        $mgr_id = $this->input->post('mgr_id');
        $this->load->model(array('Member_group_model', 'Member_group_member_model', 'Beatsomeone_model'));
        $member_group = $this->Member_group_model->item($mgr_id);
        $mem_id = $this->member->item('mem_id');
        if ($member_group['mgr_title'] === 'seller_free') {
            $current_group = $this->Member_group_member_model->get('', '', ['mem_id' => $mem_id]);
            foreach ($current_group as $key => $val) {
                $this->Member_group_member_model->delete($val['mgm_id']);
            }
            $mgm_id = $this->Member_group_member_model->insert([
                'mgr_id' => $mgr_id,
                'mem_id' => $mem_id,
                'mgm_datetime' => cdate('Y-m-d H:i:s'),
            ]);
            if ($mgm_id === 0) {
                $this->output->set_status_header(400);
            }
            $this->output->set_output(json_encode([
                'message' => 'Success',
            ]));
        }
        if ($member_group['mgr_title'] == 'seller_platinum' || $member_group['mgr_title'] == 'seller_master') {
            $pg = $this->input->post('pg');
            $amount = $this->input->post('amount');
            $bill_term = $this->input->post('bill_term');
            if ($pg == 'paypal') {
                if ($bill_term == 'monthly') {
                    if ((float)$amount == (float)element('mgr_monthly_cost_d', $member_group)) {
                        $current_group = $this->Member_group_member_model->get('', '', ['mem_id' => $mem_id]);
                        foreach ($current_group as $key => $val) {
                            $this->Member_group_member_model->delete($val['mgm_id']);
                        }
                        $gminsert = array(
                            'mgr_id' => $this->input->post('mgr_id'),
                            'mem_id' => $mem_id,
                            'mgm_datetime' => cdate('Y-m-d H:i:s'),
                        );
                        $this->Member_group_member_model->insert($gminsert);

                        $termDays = '30';
                        $startDate = date('Y-m-d');
                        $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));

                        $params = [
                            'mem_id' => $mem_id,
                            'bill_term' => $bill_term,
                            'plan_name' => $member_group['mgr_title'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'pay_method' => $pg,
                            'amount' => $amount
                        ];
                        $this->Beatsomeone_model->insert_membership_purchase_log($params);
                    } else {
                        $this->output->set_status_header(400);
                    }
                } else {
                    if ((float)$amount == (float)element('mgr_year_cost_d', $member_group)) {
                        $current_group = $this->Member_group_member_model->get('', '', ['mem_id' => $mem_id]);
                        foreach ($current_group as $key => $val) {
                            $this->Member_group_member_model->delete($val['mgm_id']);
                        }
                        $gminsert = array(
                            'mgr_id' => $this->input->post('mgr_id'),
                            'mem_id' => $mem_id,
                            'mgm_datetime' => cdate('Y-m-d H:i:s'),
                        );
                        $this->Member_group_member_model->insert($gminsert);

                        $termDays = '365';
                        $startDate = date('Y-m-d');
                        $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));

                        $params = [
                            'mem_id' => $mem_id,
                            'bill_term' => $bill_term,
                            'plan_name' => $member_group['mgr_title'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'pay_method' => $pg,
                            'amount' => $amount
                        ];
                        $this->Beatsomeone_model->insert_membership_purchase_log($params);
                    } else {
                        $this->output->set_status_header(400);
                    }
                }
                $this->output->set_output(json_encode([
                    'message' => lang('lang48'),
                ]));
            }
        }
    }

    public function ajax_info()
    {
        required_user_login();

        $mem_id = $this->member->item('mem_id');

        $this->load->model(array('Cmall_order_model', 'Cmall_order_detail_model', 'Note_model', 'Post_model', 'Board_model', 'Cmall_item_show_history_model', 'Cmall_item_model'));

        $order_order_count = $this->Cmall_order_model->count_by([
            'mem_id' => $mem_id,
            'status' => 'order'
        ]);
        $order_cancel_count = $this->Cmall_order_model->count_by([
            'mem_id' => $mem_id,
            'status' => 'cancel'
        ]);
        $order_deposit_count = $this->Cmall_order_model->count_by([
            'mem_id' => $mem_id,
            'status' => 'deposit'
        ]);

        $expired_soon_items = $this->Cmall_order_detail_model->get_expired_items($mem_id);

        $where = [
            'cmall_item_show_history.mem_id' => $mem_id
        ];
        $recently_listen_items = $this->Cmall_item_show_history_model->get_list(12, '', $where, '', 'show_dt', 'desc');

        $where = array(
            'recv_mem_id' => $mem_id,
            'nte_type' => 1,
        );

        $recent_messages = $this->Note_model->get_recv_list(3, '', $where);

        $support_board = $this->Board_model->get_one('', '', "brd_key='support'");
        $where = [
            'post.mem_id' => $mem_id,
            'brd_id' => $support_board['brd_id']
        ];
        $inquiries = $this->Post_model->get_post_list(3, '', $where);
        if (element('list', $inquiries)) {
            foreach (element('list', $inquiries) as $key => $val) {
                $inquiries['list'][$key]['replies'] = $this->Post_model->get_reply_list($val);
            }
        }

        $member_group = $this->member->group();
        $member_group_name = null;
        $mgr_commission = null;
        if ($member_group && is_array($member_group)) {

            $this->load->model('Member_group_model');

            foreach ($member_group as $gkey => $gval) {
                $item = $this->Member_group_model->item(element('mgr_id', $gval));
                if ($member_group_name) {
                    $member_group_name .= ', ';
                    $mgr_commission .= ', ';
                }
                $member_group_name .= element('mgr_title', $item);
                $mgr_commission .= element('mgr_commission', $item);
            }
        }
        $mgr_commission = floatval($mgr_commission);

        $result = [
            'message' => 'Success',
            'order_order_count' => $order_order_count,
            'order_cancel_count' => $order_cancel_count,
            'order_deposit_count' => $order_deposit_count,
            'expired_soon_items' => $expired_soon_items,
            'recently_listen_items' => $recently_listen_items['list'],
            'messages' => $recent_messages['list'],
            'inquiries' => $inquiries['list']
        ];

        if (strpos($member_group_name, 'seller') !== false) {
            $total_sales = $this->Cmall_order_detail_model->totalSaleFundsCurrentMonth($mem_id);
            $sale_funds = $total_sales['total'] ? floatval($total_sales['total']) : 0;
            $sale_funds_d = $total_sales['total_d'] ? floatval($total_sales['total_d']) : 0;

            $result['total_sale_funds'] = $sale_funds;
            $result['total_sale_funds_d'] = $sale_funds_d;

            $result['total_settle_funds'] = $sale_funds * (1 - $mgr_commission / 100);
            $result['total_settle_funds_d'] = $sale_funds_d * (1 - $mgr_commission / 100);

            $total_sales_last = $this->Cmall_order_detail_model->totalSaleFundsLastMonth($mem_id);

            $last_sale_funds = $total_sales_last['total'] ? floatval($total_sales_last['total']) : 0;
            $last_sale_funds_d = $total_sales_last['total_d'] ? floatval($total_sales_last['total_d']) : 0;

            $result['total_last_sale_funds'] = $last_sale_funds;
            $result['total_last_sale_funds_d'] = $last_sale_funds_d;

            $result['total_last_settle_funds'] = $last_sale_funds * (1 - $mgr_commission / 100);
            $result['total_last_settle_funds_d'] = $last_sale_funds * (1 - $mgr_commission / 100);

            $total_sales_lastlast = $this->Cmall_order_detail_model->totalSaleFundsLastLastMonth($mem_id);
            $lastlast_sale_funds = $total_sales_lastlast['total'] ? floatval($total_sales_lastlast['total']) : 0;
            $lastlast_sale_funds_d = $total_sales_lastlast['total_d'] ? floatval($total_sales_lastlast['total_d']) : 0;

            $result['total_lastlast_settle_funds'] = $lastlast_sale_funds * (1 - $mgr_commission / 100);
            $result['total_lastlast_settle_funds_d'] = $lastlast_sale_funds_d * (1 - $mgr_commission / 100);

            $total_product_count = $this->Cmall_item_model->count_total_items($mem_id);
            $selling_product_count = $this->Cmall_item_model->count_selling_items($mem_id);
            $pending_product_count = $this->Cmall_item_model->count_pending_items($mem_id);
            $result['total_product_count'] = $total_product_count;
            $result['selling_product_count'] = $selling_product_count;
            $result['pending_product_count'] = $pending_product_count;

            $saleData = $this->Cmall_order_detail_model->get_sale_data($mem_id);
            $chartData = array();
            for ($i = 0; $i < count($saleData) - 1; $i++) {
                $begin = new DateTime($saleData[$i]['cor_date']);
                $end = new DateTime($saleData[$i + 1]['cor_date']);
                $chartData[$saleData[$i]['cor_date']] = intval($saleData[$i]['total']);
                for ($j = $begin->modify('+1 day'); $j <= $end; $j->modify('+1 day')) {
                    $date = $j->format('Y-m-d');
                    $chartData[$date] = 0;
                }
            }


            $result['saleData'] = array(
                // 이번달 정보
                array(
                    'category' => 'Estimated settlement',
                    'data' => $chartData
                ),
            );
        }

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($result));
    }
}
