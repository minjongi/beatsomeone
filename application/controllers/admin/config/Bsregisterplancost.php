<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * BS Register Plan Cost class
 *
 *
 * @author DevNo3
 */

/**
 * 관리자>환경설정>회원 플랜 정책 controller 입니다.
 */
class Bsregisterplancost extends CB_Controller
{

	/**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
	public $pagedir = 'config/bsregisterplancost';

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array();

	/**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
	protected $modelname = '';

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
		$this->load->library(array('querystring'));
	}

	/**
	 * 관리 페이지
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_config_bsregisterplancost_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->load->model('Beatsomeone_model');

		/**
		 * Validation 라이브러리를 가져옵니다
		 */
		$this->load->library('form_validation');

		/**
		 * 전송된 데이터의 유효성을 체크합니다
		 */
		$config = array(
			array(
				'field' => 'm_monthly',
				'label' => '월금액(원)',
				'rules' => 'trim|required',
			),
            array(
                'field' => 'm_monthly_d',
                'label' => '월금액($)',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'm_yearly',
                'label' => '년금액(원)',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'm_yearly_d',
                'label' => '년금액($)',
                'rules' => 'trim|required',
            ),
		);
		$this->form_validation->set_rules($config);

        $view['view']['data'] = $this->Beatsomeone_model->get_register_plan_cost();
		/**
		 * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
		 * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
		 */
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

            $d = array(
                array(
                    'plan' => $this->input->post('m_plan'),
                    'monthly' => $this->input->post('m_monthly'),
                    'monthly_d' => $this->input->post('m_monthly_d'),
                    'yearly' => $this->input->post('m_yearly'),
                    'monthly_d' => $this->input->post('m_monthly_d'),
                    'yearly_discount_pc' => $this->input->post('m_yearly_discount_pc'),
                    'yearly_discount_amt' => $this->input->post('m_yearly_discount_amt'),
                    'yearly_discount_amt_d' => $this->input->post('m_yearly_discount_amt_d'),
                ),
                array(
                    'plan' => $this->input->post('p_plan'),
                    'monthly' => $this->input->post('p_monthly'),
                    'monthly_d' => $this->input->post('p_monthly_d'),
                    'yearly' => $this->input->post('p_yearly'),
                    'monthly_d' => $this->input->post('p_monthly_d'),
                    'yearly_discount_pc' => $this->input->post('p_yearly_discount_pc'),
                    'yearly_discount_amt' => $this->input->post('p_yearly_discount_amt'),
                    'yearly_discount_amt_d' => $this->input->post('p_yearly_discount_amt_d'),
                ),
            );
            log_message('debug','plan : '.var_export($d,true));

            $result = $this->Beatsomeone_model->merge_register_plan_cost($d);

			if (!$result) {
				$view['view']['alert_message'] = '저장 실패 하였습니다';
			} else {
				$view['view']['alert_message'] = '저장 되었습니다';
			}

		}

		//$view['view']['data'] = $getdata;

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}
}
