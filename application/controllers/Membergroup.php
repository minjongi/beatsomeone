<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membergroup extends CB_Controller
{
    /**
     * 이 컨트롤러의 메인 모델 이름입니다
     */
    protected $modelname = 'Member_group_model';

    /**
     * Membergroup constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 회원 그룹 목록을 가져오는 메소드입니다
     */
    public function index()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_admin_member_membergroup_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        /**
         * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
         */
        $param =& $this->querystring;
        $findex = 'mgr_order';
        $forder = 'asc';

        /**
         * 게시판 목록에 필요한 정보를 가져옵니다.
         */
        $this->load->model($this->modelname);
        $list = $this->{$this->modelname}->get_all_group();

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode($list));
    }
}