<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Register class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 회원 가입과 관련된 controller 입니다.
 */
class Register extends CB_Controller
{

    /**
     * 모델을 로딩합니다
     */
    protected $models = array('Member_meta', 'Member_auth_email', 'Promo', 'Member', 'Member_group_member');

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'string');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'form_validation', 'phpmailer_lib', 'email', 'notelib', 'point'));

        if (!function_exists('password_hash')) {
            $this->load->helper('password');
        }

    }


    /**
     * 사용자 유형 선택
     */
    public function index()
    {
        $check_login = $this->member->is_member();
        if ($check_login) {
            $t = $this->input->get('t');
            if ($t == 'pr') {
                $member_group = $this->Member_group_member_model->get_with_group($this->member->item('mem_id'))[0];
                if ($member_group['mgr_id'] == 4) {
                    alert(lang('lang143'), '/');
                } else {
                    redirect('/mypage/upgrade');
                }
            }
            redirect('/');
        }

        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_index';
        $this->load->event($eventname);

        $view['getData']['billTerm'] = $this->input->get('billTerm');
        $view['getData']['plan'] = $this->input->get('plan');
        $view['getData']['planName'] = $this->input->get('planName');
        if (empty($view['getData']['billTerm']) || empty($view['getData']['plan']) || empty($view['getData']['planName'])) {
            $view['getData'] = [];
        }

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_register');
        $meta_description = $this->cbconfig->item('site_meta_description_register');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
        $meta_author = $this->cbconfig->item('site_meta_author_register');
        $page_name = $this->cbconfig->item('site_page_name_register');

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'register',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

    public function terms()
    {
        $eventname = 'event_register_terms';
        $this->load->event($eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_default');
        $meta_description = $this->cbconfig->item('site_meta_description_default');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_default');
        $meta_author = $this->cbconfig->item('site_meta_author_default');
        $page_name = '이용약관';

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'terms',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

    public function policy()
    {
        $eventname = 'event_register_policy';
        $this->load->event($eventname);

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_default');
        $meta_description = $this->cbconfig->item('site_meta_description_default');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_default');
        $meta_author = $this->cbconfig->item('site_meta_author_default');
        $page_name = '이용약관';

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'policy',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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
     * 회원 약관 동의시 작동하는 함수입니다
     */
    public function register_user()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        if ($this->member->is_member()
            && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            redirect();
        }

        if ($this->cbconfig->item('use_register_block')) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_block_layout'] = Events::trigger('before_block_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register');
            $meta_description = $this->cbconfig->item('site_meta_description_register');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
            $meta_author = $this->cbconfig->item('site_meta_author_register');
            $page_name = $this->cbconfig->item('site_page_name_register');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_block_user',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

            return false;
        }

        /**
         * 전송된 데이터의 유효성을 체크합니다
         */
        $config = array(
            array(
                'field' => 'agree',
                'label' => '회원가입약관',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'agree2',
                'label' => '개인정보취급방침',
                'rules' => 'trim|required',
            ),
        );
        $this->form_validation->set_rules($config);

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

            $this->session->set_userdata('registeragree', '');
            $this->session->set_userdata('selfcertinfo', '');

            $view['view']['member_register_policy1'] = $this->cbconfig->item('member_register_policy1');
            $view['view']['member_register_policy2'] = $this->cbconfig->item('member_register_policy2');
            $view['view']['canonical'] = site_url('register_user');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register');
            $meta_description = $this->cbconfig->item('site_meta_description_register');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
            $meta_author = $this->cbconfig->item('site_meta_author_register');
            $page_name = $this->cbconfig->item('site_page_name_register');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_user',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $this->session->set_userdata('registeragree', '1');
            redirect('register/form_user');
        }
    }

    /**
     * 회원가입 폼 페이지입니다
     */
    public function form()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_form';
        $this->load->event($eventname);

        $form_data = $this->input->post();


        if ($this->member->is_member() && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            redirect();
        }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        if ($this->cbconfig->item('use_register_block')) {
            $result = [
                'message' => 'Blocked sign up',
            ];
            $this->output->set_status_header('403');
            $this->output->set_content_type('text/json');
            $this->output->set_output(json_encode($result));
            return false;
        }


        if ($this->cbconfig->item('use_selfcert') && $this->cbconfig->item('use_selfcert_required') && !$this->session->userdata('selfcertinfo')) {
            if (!$this->session->userdata('selfcertinfo')) {
                $this->session->set_flashdata(
                    'message',
                    '본인 확인 후에 회원가입이 가능합니다.'
                );
                redirect('register');
            }
        }

        $selfcert_phone = $selfcert_username = $selfcert_birthday = $selfcert_sex = '';
        $selfcert_meta = '';

        if ($this->cbconfig->item('use_selfcert') && $this->session->userdata('selfcertinfo')) {
            $selfcertinfo = $this->session->userdata('selfcertinfo');
            if (element('selfcert_type', $selfcertinfo) == 'phone') {
                if ($this->cbconfig->item('use_selfcert_phone') == 'kcb' or $this->cbconfig->item('use_selfcert_phone') == 'kcp') {
                    $selfcert_phone = element('selfcert_phone', $selfcertinfo);
                    $selfcert_username = element('selfcert_username', $selfcertinfo);
                    $selfcert_birthday = element('selfcert_birthday', $selfcertinfo);
                    $selfcert_sex = element('selfcert_sex', $selfcertinfo);
                    $selfcert_key = element('selfcert_key', $selfcertinfo);
                    $selfcert_local_code = element('selfcert_local_code', $selfcertinfo);
                    $selfcert_meta = array(
                        'selfcert_type' => element('selfcert_type', $selfcertinfo),
                        'selfcert_company' => $this->cbconfig->item('use_selfcert_phone'),
                        'selfcert_comm_id' => element('selfcert_comm_id', $selfcertinfo),
                        'selfcert_phone' => $selfcert_phone,
                        'selfcert_username' => $selfcert_username,
                        'selfcert_birthday' => $selfcert_birthday,
                        'selfcert_sex' => $selfcert_sex,
                        'selfcert_key' => $selfcert_key,
                        'selfcert_local_code' => $selfcert_local_code,
                    );
                }
            }
        }

        $password_length = $this->cbconfig->item('password_length');
        $email_description = '';
        if ($this->cbconfig->item('use_register_email_auth')) {
            $email_description = '회원가입 후 인증메일이 발송됩니다. 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
        }

        $configbasic = array();

        $nickname_description = '';
        if ($this->cbconfig->item('change_nickname_date')) {
            $nickname_description = '<br />닉네임을 입력하시면 앞으로 '
                . $this->cbconfig->item('change_nickname_date') . '일 이내에는 변경할 수 없습니다';
        }

        $configbasic['mem_userid'] = array(
            'field' => 'mem_userid',
            'label' => '아이디',
            'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]|callback__mem_userid_check',
            'description' => '영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요',
        );

        $password_description = '비밀번호는 ' . $password_length . '자리 이상이어야 ';
        if ($this->cbconfig->item('password_uppercase_length')
            or $this->cbconfig->item('password_numbers_length')
            or $this->cbconfig->item('password_specialchars_length')) {

            $password_description .= '하며 ';
            if ($this->cbconfig->item('password_uppercase_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_uppercase_length') . '개의 대문자';
            }
            if ($this->cbconfig->item('password_numbers_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_numbers_length') . '개의 숫자';
            }
            if ($this->cbconfig->item('password_specialchars_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_specialchars_length') . '개의 특수문자';
            }
            $password_description .= '를 포함해야 ';
        }
        $password_description .= '합니다';

        $configbasic['mem_password'] = array(
            'field' => 'mem_password',
            'label' => '패스워드',
            'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
            'description' => $password_description,
        );
        if (!$selfcert_username) {
            $configbasic['mem_username'] = array(
                'field' => 'mem_username',
                'label' => '이름',
                'rules' => 'trim|min_length[2]|max_length[20]',
            );
        }
        $configbasic['mem_nickname'] = array(
            'field' => 'mem_nickname',
            'label' => '닉네임',
            'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]|callback__mem_nickname_check',
            'description' => '공백없이 한글, 영문, 숫자만 입력 가능 2글자 이상' . $nickname_description,
        );
        $configbasic['mem_email'] = array(
            'field' => 'mem_email',
            'label' => '이메일',
            'rules' => 'trim|required|valid_email|max_length[50]|is_unique[member.mem_email]|callback__mem_email_check',
            'description' => $email_description,
        );
        $configbasic['mem_homepage'] = array(
            'field' => 'mem_homepage',
            'label' => '홈페이지',
            'rules' => 'prep_url|valid_url',
        );
        if (!$selfcert_phone) {
            $configbasic['mem_phone'] = array(
                'field' => 'mem_phone',
                'label' => '전화번호',
                'rules' => 'trim|valid_phone',
            );
        }
        if (!$selfcert_birthday) {
            $configbasic['mem_birthday'] = array(
                'field' => 'mem_birthday',
                'label' => '생년월일',
                'rules' => 'trim|exact_length[10]',
            );
        }
        if (!$selfcert_sex) {
            $configbasic['mem_sex'] = array(
                'field' => 'mem_sex',
                'label' => '성별',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_zipcode'] = array(
            'field' => 'mem_zipcode',
            'label' => '우편번호',
            'rules' => 'trim|min_length[5]|max_length[7]',
        );
        $configbasic['mem_address1'] = array(
            'field' => 'mem_address1',
            'label' => '기본주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address2'] = array(
            'field' => 'mem_address2',
            'label' => '상세주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address3'] = array(
            'field' => 'mem_address3',
            'label' => '참고항목',
            'rules' => 'trim',
        );
        $configbasic['mem_address4'] = array(
            'field' => 'mem_address4',
            'label' => '지번',
            'rules' => 'trim',
        );
        $configbasic['mem_profile_content'] = array(
            'field' => 'mem_profile_content',
            'label' => '자기소개',
            'rules' => 'trim',
        );
        $configbasic['mem_open_profile'] = array(
            'field' => 'mem_open_profile',
            'label' => '정보공개',
            'rules' => 'trim|exact_length[1]',
        );
        if ($this->cbconfig->item('use_note')) {
            $configbasic['mem_use_note'] = array(
                'field' => 'mem_use_note',
                'label' => '쪽지사용',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_receive_email'] = array(
            'field' => 'mem_receive_email',
            'label' => '이메일수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_receive_sms'] = array(
            'field' => 'mem_receive_sms',
            'label' => 'SMS 문자수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_recommend'] = array(
            'field' => 'mem_recommend',
            'label' => '추천인아이디',
            'rules' => 'trim|alphanumunder|min_length[3]|max_length[20]|callback__mem_recommend_check',
        );

//        if ($this->member->is_admin() === false && ! $this->session->userdata('registeragree')) {
//            $this->session->set_flashdata(
//                'message',
//                '회원가입약관동의와 개인정보취급방침동의후 회원가입이 가능합니다'
//            );
//            redirect('register');
//        }

        $registerform = $this->cbconfig->item('registerform');
        $form = json_decode($registerform, true);

        $config = array();
        if ($form && is_array($form)) {
            foreach ($form as $key => $value) {
                if (!element('use', $value)) {
                    continue;
                }
                if (element('func', $value) === 'basic') {
                    if ($key == 'mem_username' && $selfcert_username) {
                        continue;
                    }
                    if ($key == 'mem_phone' && $selfcert_phone) {
                        continue;
                    }
                    if ($key == 'mem_birthday' && $selfcert_birthday) {
                        continue;
                    }
                    if ($key == 'mem_sex' && $selfcert_sex) {
                        continue;
                    }

                    if ($key === 'mem_address') {
                        if (element('required', $value) === '1') {
                            $configbasic['mem_zipcode']['rules'] = $configbasic['mem_zipcode']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_zipcode'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address1']['rules'] = $configbasic['mem_address1']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address1'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address2']['rules'] = $configbasic['mem_address2']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address2'];
                    } else {
                        if (element('required', $value) === '1') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|required';
                        }
                        if (element('field_type', $value) === 'phone') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|valid_phone';
                        }
                        $config[] = $configbasic[$value['field_name']];
                        if ($key === 'mem_password') {
                            $config[] = $configbasic['mem_password_re'];
                        }
                    }
                } else {
                    $required = element('required', $value) ? '|required' : '';
                    if (element('field_type', $value) === 'checkbox') {
                        $config[] = array(
                            'field' => element('field_name', $value) . '[]',
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    } else {
                        $config[] = array(
                            'field' => element('field_name', $value),
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    }
                }
            }
        }


        $this->form_validation->set_rules($config);

        $form_validation = $this->form_validation->run();
        $file_error = '';
        $updatephoto = '';
        $file_error2 = '';
        $updateicon = '';

        if ($form_validation) {
            $this->load->library('upload');
            if ($this->cbconfig->item('use_member_photo') && $this->cbconfig->item('member_photo_width') > 0 && $this->cbconfig->item('member_photo_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_photo']) && isset($_FILES['mem_photo']['name']) && $_FILES['mem_photo']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_photo/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_photo')) {
                        $img = $this->upload->data();
                        $updatephoto = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error = $this->upload->display_errors();

                    }
                }
            }

            if ($this->cbconfig->item('use_member_icon') && $this->cbconfig->item('member_icon_width') > 0 && $this->cbconfig->item('member_icon_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_icon']) && isset($_FILES['mem_icon']['name']) && $_FILES['mem_icon']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_icon/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_icon')) {
                        $img = $this->upload->data();
                        $updateicon = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error2 = $this->upload->display_errors();
                    }
                }
            }
        }

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($form_validation === false or $file_error !== '' or $file_error2 !== '') {
            $this->output->set_content_type('text/json');
            $this->output->set_status_header('400');
            $result = [
                'message' => 'Bad Request',
            ];
            $this->output->set_output(json_encode($result));
            return false;
        } else {

            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */
            $this->load->model('Beatsomeone_model');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $mem_level = (int)$this->cbconfig->item('register_level');
            $insertdata = array();
            $metadata = array();
            // $this->Member_model->delete_where(array('mem_userid' => $this->input->post('mem_userid')));

            $insertdata['mem_userid'] = $this->input->post('mem_userid');
            $insertdata['mem_email'] = $this->input->post('mem_email');
            $insertdata['mem_password'] = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);
            $insertdata['mem_nickname'] = $this->input->post('mem_nickname');
            $metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_level'] = $mem_level;
            $insertdata['mem_firstname'] = $this->input->post('mem_firstname');
            $insertdata['mem_lastname'] = $this->input->post('mem_lastname');
            $insertdata['mem_type'] = $this->input->post('mem_type');


            if ($selfcert_username) {
                $insertdata['mem_username'] = $selfcert_username;
            } else if (isset($form['mem_username']['use']) && $form['mem_username']['use']) {
                $insertdata['mem_username'] = $this->input->post('mem_username', null, '');
            }
            if (isset($form['mem_homepage']['use']) && $form['mem_homepage']['use']) {
                $insertdata['mem_homepage'] = $this->input->post('mem_homepage', null, '');
            }
            if ($selfcert_phone) {
                $insertdata['mem_phone'] = $selfcert_phone;
            } else if (isset($form['mem_phone']['use']) && $form['mem_phone']['use']) {
                $insertdata['mem_phone'] = $this->input->post('mem_phone', null, '');
            }
            if ($selfcert_birthday) {
                $insertdata['mem_birthday'] = $selfcert_birthday;
            } else if (isset($form['mem_birthday']['use']) && $form['mem_birthday']['use']) {
                $insertdata['mem_birthday'] = $this->input->post('mem_birthday', null, '');
            }
            if ($selfcert_sex) {
                $insertdata['mem_sex'] = $selfcert_sex;
            } else if (isset($form['mem_sex']['use']) && $form['mem_sex']['use']) {
                $insertdata['mem_sex'] = $this->input->post('mem_sex', null, '');
            }

            $insertdata['mem_address1'] = $this->input->post('mem_address1');
            $insertdata['mem_receive_email'] = $this->input->post('mem_receive_email') ? 1 : 0;
            if ($this->cbconfig->item('use_note')) {
                $insertdata['mem_use_note'] = $this->input->post('mem_use_note') ? 1 : 0;
                $metadata['meta_use_note_datetime'] = cdate('Y-m-d H:i:s');
            }
            $insertdata['mem_receive_sms'] = $this->input->post('mem_receive_sms') ? 1 : 0;
            $insertdata['mem_open_profile'] = $this->input->post('mem_open_profile') ? 1 : 0;
            $metadata['meta_open_profile_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_ip'] = $this->input->ip_address();
            $metadata['meta_change_pw_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');

            if ($this->cbconfig->item('use_register_email_auth')) {
                $insertdata['mem_email_cert'] = 0;
                $metadata['meta_email_cert_datetime'] = '';
            } else {
                $insertdata['mem_email_cert'] = 1;
                $metadata['meta_email_cert_datetime'] = cdate('Y-m-d H:i:s');
            }

            if ($updatephoto) {
                $insertdata['mem_photo'] = $updatephoto;
            }
            if ($updateicon) {
                $insertdata['mem_icon'] = $updateicon;
            }

            $mem_id = $this->Member_model->insert($insertdata);

            if ($mem_id == 0) {
                $this->output->set_content_type('text/json');
                $this->output->set_status_header('400');
                $result = [
                    'message' => 'Not Registered',
                ];
                $this->output->set_output(json_encode($result));
                return false;
            }
            if (strpos($this->input->post('social_id'), 'social') !== false ) {
                $this->load->model('Social_meta_model');
                $social_id = explode('_', $this->input->post('social_id'));
                $social_type = $this->input->post('mem_social_type');
                $this->Social_meta_model->delete_where(array('smt_value' => $social_id));
                // $data111 = array(
                //     $social_type . '_id' => $social_id[1],
                // );
                $this->Social_meta_model
                    ->add_meta($mem_id, $social_type . '_id', $social_id[1]);
            }
            if ($selfcert_meta) {
                foreach ($selfcert_meta as $certkey => $certvalue) {
                    $metadata[$certkey] = $certvalue;
                }

                $selfcertupdatedata = array(
                    'mem_id' => $mem_id
                );
                $selfcertwhere = array(
                    'msh_cert_key' => $selfcert_key,
                );

                $this->load->model('Member_selfcert_history_model');
                $this->Member_selfcert_history_model->update('', $selfcertupdatedata, $selfcertwhere);
            }

            $this->Member_meta_model->save($mem_id, $metadata);

            $extradata = array();
            if ($form && is_array($form)) {
                $this->load->model('Member_extra_vars_model');
                foreach ($form as $key => $value) {
                    if (!element('use', $value)) {
                        continue;
                    }
                    if (element('func', $value) === 'basic') {
                        continue;
                    }
                    $extradata[element('field_name', $value)] = $this->input->post(element('field_name', $value), null, '');
                }
                $this->Member_extra_vars_model->save($mem_id, $extradata);
            }

            $levelhistoryinsert = array(
                'mem_id' => $mem_id,
                'mlh_from' => 0,
                'mlh_to' => $mem_level,
                'mlh_datetime' => cdate('Y-m-d H:i:s'),
                'mlh_reason' => '회원가입',
                'mlh_ip' => $this->input->ip_address(),
            );
            $this->load->model('Member_level_history_model');
            $this->Member_level_history_model->insert($levelhistoryinsert);

            $this->load->model('Member_group_model');
            $allgroup = $this->Member_group_model->get_all_group();
            $mgr_id = $this->input->post('mgr_id');
            if ($allgroup && is_array($allgroup)) {
                $this->load->model('Member_group_member_model');
                $member_group = $this->db->query("SELECT * FROM cb_member_group WHERE mgr_id=?", [$mgr_id])->row_array();
                if ($member_group['mgr_title'] == 'buyer' || $member_group['mgr_title'] == 'seller_free') {
                    $gminsert = array(
                        'mgr_id' => $mgr_id,
                        'mem_id' => $mem_id,
                        'mgm_datetime' => cdate('Y-m-d H:i:s'),
                    );
                    $this->Member_group_member_model->insert($gminsert);
                } else {
                    foreach ($allgroup as $gkey => $gval) {
                        if (element('mgr_is_default', $gval)) {
                            $gminsert = array(
                                'mgr_id' => element('mgr_id', $gval),
                                'mem_id' => $mem_id,
                                'mgm_datetime' => cdate('Y-m-d H:i:s'),
                            );
                            $this->Member_group_member_model->insert($gminsert);
                        }
                    }
                }
            }

            $this->point->insert_point(
                $mem_id,
                $this->cbconfig->item('point_register'),
                '회원가입을 축하합니다',
                'member',
                $mem_id,
                '회원가입'
            );

            $searchconfig = array(
                '{홈페이지명}',
                '{회사명}',
                '{홈페이지주소}',
                '{회원아이디}',
                '{회원닉네임}',
                '{회원실명}',
                '{회원이메일}',
                '{메일수신여부}',
                '{쪽지수신여부}',
                '{문자수신여부}',
                '{회원아이피}',
            );
            $mem_userid = $this->input->post('mem_userid', null, '');
            $mem_nickname = $this->input->post('mem_nickname', null, '');
            $mem_username = $selfcert_username ? $selfcert_username : $this->input->post('mem_username', null, '');
            $mem_email = $this->input->post('mem_email', null, '');
            $receive_email = $this->input->post('mem_receive_email') ? '동의' : '거부';
            $receive_note = $this->input->post('mem_use_note') ? '동의' : '거부';
            $receive_sms = $this->input->post('mem_receive_sms') ? '동의' : '거부';
            $replaceconfig = array(
                $this->cbconfig->item('site_title'),
                $this->cbconfig->item('company_name'),
                site_url(),
                $mem_userid,
                $mem_nickname,
                $mem_username,
                $mem_email,
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );
            $replaceconfig_escape = array(
                html_escape($this->cbconfig->item('site_title')),
                html_escape($this->cbconfig->item('company_name')),
                site_url(),
                html_escape($mem_userid),
                html_escape($mem_nickname),
                html_escape($mem_username),
                html_escape($mem_email),
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );

            $result = array();

            if (!$this->cbconfig->item('use_register_email_auth')) {
                if (($this->cbconfig->item('send_email_register_user') && $this->input->post('mem_receive_email'))
                    or $this->cbconfig->item('send_email_register_alluser')) {
                    $title = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_email_register_user_title')
                    );
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig_escape,
                        $this->cbconfig->item('send_email_register_user_content')
                    );
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to($this->input->post('mem_email'));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                }
            } else {
                $vericode = array('$', '/', '.');
                $verificationcode = str_replace(
                    $vericode,
                    '',
                    password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
                );

                $beforeauthdata = array(
                    'mem_id' => $mem_id,
                    'mae_type' => 1,
                );
                $this->Member_auth_email_model->delete_where($beforeauthdata);
                $authdata = array(
                    'mem_id' => $mem_id,
                    'mae_key' => $verificationcode,
                    'mae_type' => 1,
                    'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_auth_email_model->insert($authdata);

                $verify_url = site_url('verify/confirmemail?user=' . $this->input->post('mem_userid') . '&code=' . $verificationcode);

                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_user_verifytitle')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_user_verifycontent')
                );

                $title = str_replace('{메일인증주소}', $verify_url, $title);
                $content = str_replace('{메일인증주소}', $verify_url, $content);

//                $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
//                $this->email->to($this->input->post('mem_email'));
//                $this->email->subject($title);
//                $this->email->message($content);
//                $this->email->send();

                $email_auth_message = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
//                $result['email_auth_message'] = $email_auth_message;

                // Load PHPMailer library
                $this->load->library('phpmailer_lib');

                // PHPMailer object
                $mail = $this->phpmailer_lib->load();


                $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                $mail->addReplyTo($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));

                // Add a recipient
                $mail->addAddress($this->input->post('mem_email'));

                // Email subject
                $mail->Subject = $title;

                // Set email format to HTML
                $mail->isHTML(true);

                // Email body content
                $mailContent = $content;
                $mail->Body = $mailContent;

                // Send email
                if (!$mail->send()) {
                    $result['email_auth_message'] = '이메일을 발송하지 못하였습니다. 메일 설정을 확인하여주세요';
                } else {
                    $result['email_auth_message'] = $email_auth_message;
                }
            }

            $emailsendlistadmin = array();
            $notesendlistadmin = array();
            $smssendlistadmin = array();
            $notesendlistuser = array();
            $smssendlistuser = array();

            $superadminlist = '';
            if ($this->cbconfig->item('send_email_register_admin')
                or $this->cbconfig->item('send_note_register_admin')
                or $this->cbconfig->item('send_sms_register_admin')) {
                $mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
                $superadminlist = $this->Member_model->get_superadmin_list($mselect);
            }

            if ($this->cbconfig->item('send_email_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $emailsendlistadmin[$value['mem_id']] = $value;
                }
            }
            if ($this->cbconfig->item('send_note_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $notesendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_note_register_user') && $this->input->post('mem_use_note'))) {
                $notesendlistuser['mem_id'] = $mem_id;
            }
            if ($this->cbconfig->item('send_sms_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $smssendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_sms_register_user') && $this->input->post('mem_receive_sms'))
                or $this->cbconfig->item('send_sms_register_alluser')) {
                if ($selfcert_phone or $this->input->post('mem_phone')) {
                    $smssendlistuser['mem_id'] = $mem_id;
                    $smssendlistuser['mem_nickname'] = $this->input->post('mem_nickname');
                    $smssendlistuser['mem_phone'] = $selfcert_phone ? $selfcert_phone : $this->input->post('mem_phone');
                }
            }

            if ($emailsendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_admin_content')
                );
                foreach ($emailsendlistadmin as $akey => $aval) {
                    $this->email->clear(true);
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to(element('mem_email', $aval));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                }
            }
            if ($notesendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_admin_content')
                );
                foreach ($notesendlistadmin as $akey => $aval) {
                    $note_result = $this->notelib->send_note(
                        $sender = 0,
                        $receiver = element('mem_id', $aval),
                        $title,
                        $content,
                        1
                    );
                }
            }
            if ($notesendlistuser && element('mem_id', $notesendlistuser)) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_user_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_user_content')
                );
                $note_result = $this->notelib->send_note(
                    $sender = 0,
                    $receiver = element('mem_id', $notesendlistuser),
                    $title,
                    $content,
                    1
                );
            }
            if ($smssendlistadmin) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_admin_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    foreach ($smssendlistadmin as $akey => $aval) {
                        $receiver[] = array(
                            'mem_id' => element('mem_id', $aval),
                            'name' => element('mem_nickname', $aval),
                            'phone' => element('mem_phone', $aval),
                        );
                    }
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }
            if ($smssendlistuser) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_user_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    $receiver[] = $smssendlistuser;
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }

            $member_register_data = array(
                'mem_id' => $mem_id,
                'mrg_ip' => $this->input->ip_address(),
                'mrg_datetime' => cdate('Y-m-d H:i:s'),
                'mrg_useragent' => $this->agent->agent_string(),
                'mrg_referer' => $this->session->userdata('site_referer'),
            );
            $recommended = '';
            if ($this->input->post('mem_recommend')) {
                $recommended = $this->Member_model->get_by_userid($this->input->post('mem_recommend'), 'mem_id');
                if (element('mem_id', $recommended)) {
                    $member_register_data['mrg_recommend_mem_id'] = element('mem_id', $recommended);
                } else {
                    $recommended['mem_id'] = 0;
                }
            }
            $this->load->model('Member_register_model');
            $this->Member_register_model->insert($member_register_data);

            if ($this->input->post('mem_recommend')) {
                if ($this->cbconfig->item('point_recommended')) {
                    // 추천인이 존재할 경우 추천된 사람
                    $this->point->insert_point(
                        element('mem_id', $recommended),
                        $this->cbconfig->item('point_recommended'),
                        $this->input->post('mem_nickname') . ' 님이 회원가입시 추천함',
                        'member_recommended',
                        $mem_id,
                        '회원가입추천'
                    );
                }
                if ($this->cbconfig->item('point_recommender')) {
                    // 추천인이 존재할 경우 가입자에게
                    $this->point->insert_point(
                        $mem_id,
                        $this->cbconfig->item('point_recommender'),
                        '회원가입 추천인존재',
                        'member_recommender',
                        $mem_id,
                        '회원가입추천인존재'
                    );
                }
            }

            $this->session->set_flashdata(
                'nickname',
                $this->input->post('mem_nickname')
            );

//            if (!$this->cbconfig->item('use_register_email_auth')) {
                $this->session->set_userdata(
                    'mem_id',
                    $mem_id
                );
//            }
            $this->session->unset_userdata('selfcertinfo');

            $this->output->set_content_type('text/json');
            $result['message'] = 'Registered';
            $this->output->set_output(json_encode($result, JSON_UNESCAPED_UNICODE));
            return true;
        }
    }


    /**
     * 회원가입 폼 페이지입니다
     */
    public function snsform()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_form';
        $this->load->event($eventname);

        $form_data = $this->input->post();
        // var_dump($form_data); exit();
        // if ($this->member->is_member() && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
        //     redirect();
        // }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);


        $selfcert_phone = $selfcert_username = $selfcert_birthday = $selfcert_sex = '';
        $selfcert_meta = '';


            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */
            $this->load->model('Beatsomeone_model');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $mem_level = (int)$this->cbconfig->item('register_level');
            $updatedata = array();
            $metadata = array();

            $updatedata['mem_username'] = $this->input->post('mem_username');
            $updatedata['mem_nickname'] = $this->input->post('mem_nickname');
            // $updatedata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
            $updatedata['mem_level'] = $mem_level;
            $updatedata['mem_firstname'] = $this->input->post('mem_firstname');
            $updatedata['mem_lastname'] = $this->input->post('mem_lastname');
            $updatedata['mem_type'] = $this->input->post('mem_type');

            $updatedata['mem_address1'] = $this->input->post('mem_address1');
            // $updatedata['mem_register_datetime'] = cdate('Y-m-d H:i:s');
            // $updatedata['mem_register_ip'] = $this->input->ip_address();
            $updatedata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');

            $mem_id = $this->member->item('mem_id');
            // $mem_id = $this->Member_model->insert($insertdata);
            $this->Member_model->update($mem_id, $updatedata);

            if ($mem_id == 0) {
                $this->output->set_content_type('text/json');
                $this->output->set_status_header('400');
                $result = [
                    'message' => 'Not Registered',
                ];
                $this->output->set_output(json_encode($result));
                return false;
            }

            $levelhistoryinsert = array(
                'mem_id' => $mem_id,
                'mlh_from' => 0,
                'mlh_to' => $mem_level,
                'mlh_datetime' => cdate('Y-m-d H:i:s'),
                'mlh_reason' => '회원가입',
                'mlh_ip' => $this->input->ip_address(),
            );
            $this->load->model('Member_level_history_model');
            $this->Member_level_history_model->insert($levelhistoryinsert);

            $this->load->model('Member_group_model');
            $allgroup = $this->Member_group_model->get_all_group();
            $mgr_id = $this->input->post('mgr_id');
            if ($allgroup && is_array($allgroup)) {
                $this->load->model('Member_group_member_model');
                $member_group = $this->db->query("SELECT * FROM cb_member_group WHERE mgr_id=?", [$mgr_id])->row_array();
                if ($member_group['mgr_title'] == 'buyer' || $member_group['mgr_title'] == 'seller_free') {
                    $gminsert = array(
                        'mgr_id' => $mgr_id,
                        'mem_id' => $mem_id,
                        'mgm_datetime' => cdate('Y-m-d H:i:s'),
                    );
                    $this->Member_group_member_model->insert($gminsert);
                } else {
                    foreach ($allgroup as $gkey => $gval) {
                        if (element('mgr_is_default', $gval)) {
                            $gminsert = array(
                                'mgr_id' => element('mgr_id', $gval),
                                'mem_id' => $mem_id,
                                'mgm_datetime' => cdate('Y-m-d H:i:s'),
                            );
                            $this->Member_group_member_model->insert($gminsert);
                        }
                    }
                }
            }

            $this->point->insert_point(
                $mem_id,
                $this->cbconfig->item('point_register'),
                '회원가입을 축하합니다',
                'member',
                $mem_id,
                '회원가입'
            );

            // $searchconfig = array(
            //     '{홈페이지명}',
            //     '{회사명}',
            //     '{홈페이지주소}',
            //     '{회원아이디}',
            //     '{회원닉네임}',
            //     '{회원실명}',
            //     '{회원이메일}',
            //     '{메일수신여부}',
            //     '{쪽지수신여부}',
            //     '{문자수신여부}',
            //     '{회원아이피}',
            // );
            // $mem_userid = $this->input->post('mem_userid', null, '');
            // $mem_nickname = $this->input->post('mem_nickname', null, '');
            // $mem_username = $selfcert_username ? $selfcert_username : $this->input->post('mem_username', null, '');
            // $mem_email = $this->input->post('mem_email', null, '');
            // $receive_email = $this->input->post('mem_receive_email') ? '동의' : '거부';
            // $receive_note = $this->input->post('mem_use_note') ? '동의' : '거부';
            // $receive_sms = $this->input->post('mem_receive_sms') ? '동의' : '거부';
            // $replaceconfig = array(
            //     $this->cbconfig->item('site_title'),
            //     $this->cbconfig->item('company_name'),
            //     site_url(),
            //     $mem_userid,
            //     $mem_nickname,
            //     $mem_username,
            //     $mem_email,
            //     $receive_email,
            //     $receive_note,
            //     $receive_sms,
            //     $this->input->ip_address(),
            // );
            // $replaceconfig_escape = array(
            //     html_escape($this->cbconfig->item('site_title')),
            //     html_escape($this->cbconfig->item('company_name')),
            //     site_url(),
            //     html_escape($mem_userid),
            //     html_escape($mem_nickname),
            //     html_escape($mem_username),
            //     html_escape($mem_email),
            //     $receive_email,
            //     $receive_note,
            //     $receive_sms,
            //     $this->input->ip_address(),
            // );

            $result = array();

            if (!$this->cbconfig->item('use_register_email_auth')) {
                if (($this->cbconfig->item('send_email_register_user') && $this->input->post('mem_receive_email'))
                    or $this->cbconfig->item('send_email_register_alluser')) {
                    $title = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_email_register_user_title')
                    );
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig_escape,
                        $this->cbconfig->item('send_email_register_user_content')
                    );
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to($this->input->post('mem_email'));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                }
            } else {
                $vericode = array('$', '/', '.');
                $verificationcode = str_replace(
                    $vericode,
                    '',
                    password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
                );

                $beforeauthdata = array(
                    'mem_id' => $mem_id,
                    'mae_type' => 1,
                );
                $this->Member_auth_email_model->delete_where($beforeauthdata);
                $authdata = array(
                    'mem_id' => $mem_id,
                    'mae_key' => $verificationcode,
                    'mae_type' => 1,
                    'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_auth_email_model->insert($authdata);

                $verify_url = site_url('verify/confirmemail?user=' . $this->input->post('mem_userid') . '&code=' . $verificationcode);

                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_user_verifytitle')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_user_verifycontent')
                );

                $title = str_replace('{메일인증주소}', $verify_url, $title);
                $content = str_replace('{메일인증주소}', $verify_url, $content);

                $email_auth_message = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
//                $result['email_auth_message'] = $email_auth_message;

                // Load PHPMailer library
                $this->load->library('phpmailer_lib');

                // PHPMailer object
                $mail = $this->phpmailer_lib->load();


                $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                $mail->addReplyTo($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));

                // Add a recipient
                $mail->addAddress($this->input->post('mem_email'));

                // Email subject
                $mail->Subject = $title;

                // Set email format to HTML
                $mail->isHTML(true);

                // Email body content
                $mailContent = $content;
                $mail->Body = $mailContent;

                // Send email
                if (!$mail->send()) {
                    $result['email_auth_message'] = '이메일을 발송하지 못하였습니다. 메일 설정을 확인하여주세요';
                } else {
                    $result['email_auth_message'] = $email_auth_message;
                }
            }

            $emailsendlistadmin = array();
            $notesendlistadmin = array();
            $smssendlistadmin = array();
            $notesendlistuser = array();
            $smssendlistuser = array();

            $superadminlist = '';
            if ($this->cbconfig->item('send_email_register_admin')
                or $this->cbconfig->item('send_note_register_admin')
                or $this->cbconfig->item('send_sms_register_admin')) {
                $mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
                $superadminlist = $this->Member_model->get_superadmin_list($mselect);
            }

            if ($this->cbconfig->item('send_email_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $emailsendlistadmin[$value['mem_id']] = $value;
                }
            }
            if ($this->cbconfig->item('send_note_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $notesendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_note_register_user') && $this->input->post('mem_use_note'))) {
                $notesendlistuser['mem_id'] = $mem_id;
            }
            if ($this->cbconfig->item('send_sms_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $smssendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_sms_register_user') && $this->input->post('mem_receive_sms'))
                or $this->cbconfig->item('send_sms_register_alluser')) {
                if ($selfcert_phone or $this->input->post('mem_phone')) {
                    $smssendlistuser['mem_id'] = $mem_id;
                    $smssendlistuser['mem_nickname'] = $this->input->post('mem_nickname');
                    $smssendlistuser['mem_phone'] = $selfcert_phone ? $selfcert_phone : $this->input->post('mem_phone');
                }
            }

            if ($emailsendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_admin_content')
                );
                foreach ($emailsendlistadmin as $akey => $aval) {
                    $this->email->clear(true);
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to(element('mem_email', $aval));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                }
            }
            if ($notesendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_admin_content')
                );
                foreach ($notesendlistadmin as $akey => $aval) {
                    $note_result = $this->notelib->send_note(
                        $sender = 0,
                        $receiver = element('mem_id', $aval),
                        $title,
                        $content,
                        1
                    );
                }
            }
            if ($notesendlistuser && element('mem_id', $notesendlistuser)) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_user_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_user_content')
                );
                $note_result = $this->notelib->send_note(
                    $sender = 0,
                    $receiver = element('mem_id', $notesendlistuser),
                    $title,
                    $content,
                    1
                );
            }
            if ($smssendlistadmin) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_admin_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    foreach ($smssendlistadmin as $akey => $aval) {
                        $receiver[] = array(
                            'mem_id' => element('mem_id', $aval),
                            'name' => element('mem_nickname', $aval),
                            'phone' => element('mem_phone', $aval),
                        );
                    }
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }
            if ($smssendlistuser) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_user_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    $receiver[] = $smssendlistuser;
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }

            $member_register_data = array(
                'mem_id' => $mem_id,
                'mrg_ip' => $this->input->ip_address(),
                'mrg_datetime' => cdate('Y-m-d H:i:s'),
                'mrg_useragent' => $this->agent->agent_string(),
                'mrg_referer' => $this->session->userdata('site_referer'),
            );
            $recommended = '';
            if ($this->input->post('mem_recommend')) {
                $recommended = $this->Member_model->get_by_userid($this->input->post('mem_recommend'), 'mem_id');
                if (element('mem_id', $recommended)) {
                    $member_register_data['mrg_recommend_mem_id'] = element('mem_id', $recommended);
                } else {
                    $recommended['mem_id'] = 0;
                }
            }
            $this->load->model('Member_register_model');
            $this->Member_register_model->insert($member_register_data);

            $this->session->set_flashdata(
                'nickname',
                $this->input->post('mem_nickname')
            );

//            if (!$this->cbconfig->item('use_register_email_auth')) {
                $this->session->set_userdata(
                    'mem_id',
                    $mem_id
                );
//            }
            $this->session->unset_userdata('selfcertinfo');

            $this->output->set_content_type('text/json');
            $result['message'] = 'Registered';
            $this->output->set_output(json_encode($result, JSON_UNESCAPED_UNICODE));
            return true;
    }


    /**
     * 회원 약관 동의시 작동하는 함수입니다
     */
    public function register_musician()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        if ($this->member->is_member()
            && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            redirect();
        }

        if ($this->cbconfig->item('use_register_block')) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_block_layout'] = Events::trigger('before_block_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register');
            $meta_description = $this->cbconfig->item('site_meta_description_register');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
            $meta_author = $this->cbconfig->item('site_meta_author_register');
            $page_name = $this->cbconfig->item('site_page_name_register');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_block_musician',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

            return false;
        }

        /**
         * 전송된 데이터의 유효성을 체크합니다
         */
        $config = array(
            array(
                'field' => 'agree',
                'label' => '회원가입약관',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'agree2',
                'label' => '개인정보취급방침',
                'rules' => 'trim|required',
            ),
        );
        $this->form_validation->set_rules($config);

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($this->form_validation->run() === false) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

            $this->session->set_userdata('registeragree', '');
            $this->session->set_userdata('selfcertinfo', '');

            $view['view']['member_register_policy1'] = $this->cbconfig->item('member_register_policy1');
            $view['view']['member_register_policy2'] = $this->cbconfig->item('member_register_policy2');
            $view['view']['canonical'] = site_url('register_musician');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register');
            $meta_description = $this->cbconfig->item('site_meta_description_register');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
            $meta_author = $this->cbconfig->item('site_meta_author_register');
            $page_name = $this->cbconfig->item('site_page_name_register');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_musician',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

        } else {
            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $this->session->set_userdata('registeragree', '1');
            redirect('register/form_musician');
        }
    }

    /**
     * AJAX 회원가입 폼 페이지입니다
     */
    public function ajax_form_user()
    {
        if ($this->member->is_member() && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            return;
        }

        $html_content = array();


        $mem_level = (int)$this->cbconfig->item('register_level');
        $insertdata = array();
        $metadata = array();

        $userType = $this->input->post('user_type');

        $insertdata['mem_userid'] = $this->input->post('mem_userid');
        $insertdata['mem_email'] = $this->input->post('mem_email');
        $insertdata['mem_password'] = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);
        $insertdata['mem_nickname'] = $this->input->post('mem_nickname');
        $insertdata['mem_username'] = $this->input->post('mem_username');
        $insertdata['mem_firstname'] = $this->input->post('mem_firstname');
        $insertdata['mem_lastname'] = $this->input->post('mem_lastname');
        $insertdata['mem_type'] = $this->input->post('mem_type');
        $metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
        $insertdata['mem_level'] = $mem_level;
        $insertdata['mem_address1'] = $this->input->post('mem_address1', null, '');
        $insertdata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');
        $insertdata['mem_usertype'] = $userType == 'user' ? 1 : 2;
        $insertdata['mem_register_datetime'] = cdate('Y-m-d H:i:s');
        $insertdata['mem_register_ip'] = $this->input->ip_address();
        $insertdata['mem_receive_email'] = 1;
        $insertdata['mem_receive_sms'] = 1;
        $insertdata['mem_use_note'] = 1;
        $insertdata['mem_open_profile'] = 1;
        $insertdata['mem_email_cert'] = 1;
        // 일반 유저는 비차단, 뮤지션은 차단 상태로 가입
        //$insertdata['mem_denied'] = $userType == 'user' ? 0 : 1;
        $insertdata['mem_denied'] = 0;

        $mem_id = $this->Member_model->insert($insertdata);

        $this->Member_meta_model->save($mem_id, $metadata);

        if ($this->input->post('mem_musician_bank') != null) {
            $this->load->model('Member_extra_vars_model');
            $extradata = array(
                'mem_musician_bank' => $this->input->post('mem_musician_bank'),
                'mem_musician_account' => $this->input->post('mem_musician_account'),
                'mem_musician_account_nm' => $this->input->post('mem_musician_account_nm'),
            );
            $this->Member_extra_vars_model->save($mem_id, $extradata);
        }

        log_message('debug', 'promo_code=' . $this->input->post('promo_code'));
        $rst = $this->Promo_model->use_code($this->input->post('promo_code'));
        log_message('debug', var_export($rst));
        log_message('debug', print_r($rst, true));


        $levelhistoryinsert = array(
            'mem_id' => $mem_id,
            'mlh_from' => 0,
            'mlh_to' => $mem_level,
            'mlh_datetime' => cdate('Y-m-d H:i:s'),
            'mlh_reason' => '회원가입',
            'mlh_ip' => $this->input->ip_address(),
        );
        $this->load->model('Member_level_history_model');
        $this->Member_level_history_model->insert($levelhistoryinsert);

        $this->load->model('Member_group_model');
        $allgroup = $this->Member_group_model->get_all_group();
        if ($allgroup && is_array($allgroup)) {
            $this->load->model('Member_group_member_model');
            foreach ($allgroup as $gkey => $gval) {
                if (element('mgr_is_default', $gval)) {
                    $gminsert = array(
                        // 뮤지션은 2그룹으로, 일반은 기본 그룹으로
                        'mgr_id' => $userType == 'user' ? element('mgr_id', $gval) : 2,
                        'mem_id' => $mem_id,
                        'mgm_datetime' => cdate('Y-m-d H:i:s'),
                    );
                    $this->Member_group_member_model->insert($gminsert);
                }
            }
        }

        $this->point->insert_point(
            $mem_id,
            $this->cbconfig->item('point_register'),
            '회원가입을 축하합니다',
            'member',
            $mem_id,
            '회원가입'
        );


        $member_register_data = array(
            'mem_id' => $mem_id,
            'mrg_ip' => $this->input->ip_address(),
            'mrg_datetime' => cdate('Y-m-d H:i:s'),
            'mrg_useragent' => $this->agent->agent_string(),
            'mrg_referer' => $this->session->userdata('site_referer'),
        );
        $recommended = '';
        if ($this->input->post('mem_recommend')) {
            $recommended = $this->Member_model->get_by_userid($this->input->post('mem_recommend'), 'mem_id');
            if (element('mem_id', $recommended)) {
                $member_register_data['mrg_recommend_mem_id'] = element('mem_id', $recommended);
            } else {
                $recommended['mem_id'] = 0;
            }
        }
        $this->load->model('Member_register_model');
        $this->Member_register_model->insert($member_register_data);

        $this->session->set_userdata(
            'mem_id',
            $mem_id
        );

        $this->output->set_content_type('text/json');
        $this->output->set_output(json_encode('true'));
    }

    /**
     * 회원가입 폼 페이지입니다
     */
    public function form_user()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_form';
        $this->load->event($eventname);

        if ($this->member->is_member() && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            redirect();
        }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        if ($this->cbconfig->item('use_register_block')) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_block_layout'] = Events::trigger('before_block_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register_form');
            $meta_description = $this->cbconfig->item('site_meta_description_register_form');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_form');
            $meta_author = $this->cbconfig->item('site_meta_author_register_form');
            $page_name = $this->cbconfig->item('site_page_name_register_form');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_block_user',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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
            return false;
        }


        if ($this->cbconfig->item('use_selfcert') && $this->cbconfig->item('use_selfcert_required') && !$this->session->userdata('selfcertinfo')) {
            if (!$this->session->userdata('selfcertinfo')) {
                $this->session->set_flashdata(
                    'message',
                    '본인 확인 후에 회원가입이 가능합니다.'
                );
                redirect('register');
            }
        }

        $selfcert_phone = $selfcert_username = $selfcert_birthday = $selfcert_sex = '';
        $selfcert_meta = '';

        if ($this->cbconfig->item('use_selfcert') && $this->session->userdata('selfcertinfo')) {
            $selfcertinfo = $this->session->userdata('selfcertinfo');
            if (element('selfcert_type', $selfcertinfo) == 'phone') {
                if ($this->cbconfig->item('use_selfcert_phone') == 'kcb' or $this->cbconfig->item('use_selfcert_phone') == 'kcp') {
                    $selfcert_phone = element('selfcert_phone', $selfcertinfo);
                    $selfcert_username = element('selfcert_username', $selfcertinfo);
                    $selfcert_birthday = element('selfcert_birthday', $selfcertinfo);
                    $selfcert_sex = element('selfcert_sex', $selfcertinfo);
                    $selfcert_key = element('selfcert_key', $selfcertinfo);
                    $selfcert_local_code = element('selfcert_local_code', $selfcertinfo);
                    $selfcert_meta = array(
                        'selfcert_type' => element('selfcert_type', $selfcertinfo),
                        'selfcert_company' => $this->cbconfig->item('use_selfcert_phone'),
                        'selfcert_comm_id' => element('selfcert_comm_id', $selfcertinfo),
                        'selfcert_phone' => $selfcert_phone,
                        'selfcert_username' => $selfcert_username,
                        'selfcert_birthday' => $selfcert_birthday,
                        'selfcert_sex' => $selfcert_sex,
                        'selfcert_key' => $selfcert_key,
                        'selfcert_local_code' => $selfcert_local_code,
                    );
                }
            }
        }

        $password_length = $this->cbconfig->item('password_length');
        $email_description = '';
        if ($this->cbconfig->item('use_register_email_auth')) {
            $email_description = '회원가입 후 인증메일이 발송됩니다. 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
        }

        $configbasic = array();

        $nickname_description = '';
        if ($this->cbconfig->item('change_nickname_date')) {
            $nickname_description = '<br />닉네임을 입력하시면 앞으로 '
                . $this->cbconfig->item('change_nickname_date') . '일 이내에는 변경할 수 없습니다';
        }

        $configbasic['mem_userid'] = array(
            'field' => 'mem_userid',
            'label' => '아이디',
            'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]|callback__mem_userid_check',
            'description' => '영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요',
        );

        $password_description = '비밀번호는 ' . $password_length . '자리 이상이어야 ';
        if ($this->cbconfig->item('password_uppercase_length')
            or $this->cbconfig->item('password_numbers_length')
            or $this->cbconfig->item('password_specialchars_length')) {

            $password_description .= '하며 ';
            if ($this->cbconfig->item('password_uppercase_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_uppercase_length') . '개의 대문자';
            }
            if ($this->cbconfig->item('password_numbers_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_numbers_length') . '개의 숫자';
            }
            if ($this->cbconfig->item('password_specialchars_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_specialchars_length') . '개의 특수문자';
            }
            $password_description .= '를 포함해야 ';
        }
        $password_description .= '합니다';

        $configbasic['mem_password'] = array(
            'field' => 'mem_password',
            'label' => '패스워드',
            'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
            'description' => $password_description,
        );
        $configbasic['mem_password_re'] = array(
            'field' => 'mem_password_re',
            'label' => '패스워드 확인',
            'rules' => 'trim|required|min_length[' . $password_length . ']|matches[mem_password]',
        );
        if (!$selfcert_username) {
            $configbasic['mem_username'] = array(
                'field' => 'mem_username',
                'label' => '이름',
                'rules' => 'trim|min_length[2]|max_length[20]',
            );
        }
        $configbasic['mem_nickname'] = array(
            'field' => 'mem_nickname',
            'label' => '닉네임',
            'rules' => 'trim|required|min_length[2]|max_length[20]|callback__mem_nickname_check',
            'description' => '공백없이 한글, 영문, 숫자만 입력 가능 2글자 이상' . $nickname_description,
        );
        $configbasic['mem_email'] = array(
            'field' => 'mem_email',
            'label' => '이메일',
            'rules' => 'trim|required|valid_email|max_length[50]|is_unique[member.mem_email]|callback__mem_email_check',
            'description' => $email_description,
        );
        $configbasic['mem_homepage'] = array(
            'field' => 'mem_homepage',
            'label' => '홈페이지',
            'rules' => 'prep_url|valid_url',
        );
        if (!$selfcert_phone) {
            $configbasic['mem_phone'] = array(
                'field' => 'mem_phone',
                'label' => '전화번호',
                'rules' => 'trim|valid_phone',
            );
        }
        if (!$selfcert_birthday) {
            $configbasic['mem_birthday'] = array(
                'field' => 'mem_birthday',
                'label' => '생년월일',
                'rules' => 'trim|exact_length[10]',
            );
        }
        if (!$selfcert_sex) {
            $configbasic['mem_sex'] = array(
                'field' => 'mem_sex',
                'label' => '성별',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_zipcode'] = array(
            'field' => 'mem_zipcode',
            'label' => '우편번호',
            'rules' => 'trim|min_length[5]|max_length[7]',
        );
        $configbasic['mem_address1'] = array(
            'field' => 'mem_address1',
            'label' => '기본주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address2'] = array(
            'field' => 'mem_address2',
            'label' => '상세주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address3'] = array(
            'field' => 'mem_address3',
            'label' => '참고항목',
            'rules' => 'trim',
        );
        $configbasic['mem_address4'] = array(
            'field' => 'mem_address4',
            'label' => '지번',
            'rules' => 'trim',
        );
        $configbasic['mem_profile_content'] = array(
            'field' => 'mem_profile_content',
            'label' => '자기소개',
            'rules' => 'trim',
        );
        $configbasic['mem_open_profile'] = array(
            'field' => 'mem_open_profile',
            'label' => '정보공개',
            'rules' => 'trim|exact_length[1]',
        );
        if ($this->cbconfig->item('use_note')) {
            $configbasic['mem_use_note'] = array(
                'field' => 'mem_use_note',
                'label' => '쪽지사용',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_receive_email'] = array(
            'field' => 'mem_receive_email',
            'label' => '이메일수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_receive_sms'] = array(
            'field' => 'mem_receive_sms',
            'label' => 'SMS 문자수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_recommend'] = array(
            'field' => 'mem_recommend',
            'label' => '추천인아이디',
            'rules' => 'trim|alphanumunder|min_length[3]|max_length[20]|callback__mem_recommend_check',
        );

        if ($this->member->is_admin() === false && !$this->session->userdata('registeragree')) {
            $this->session->set_flashdata(
                'message',
                '회원가입약관동의와 개인정보취급방침동의후 회원가입이 가능합니다'
            );
            redirect('register');
        }

        $registerform = $this->cbconfig->item('registerform');
        $form = json_decode($registerform, true);

        $config = array();
        if ($form && is_array($form)) {
            foreach ($form as $key => $value) {
                if (!element('use', $value)) {
                    continue;
                }

                // 일반 회원은 계좌 관련 정보를 받지 않는다
                if ($key === 'mem_musician_bank' || $key === 'mem_musician_account' || $key === 'mem_musician_account_nm') {
                    continue;
                }

                if (element('func', $value) === 'basic') {
                    if ($key == 'mem_username' && $selfcert_username) {
                        continue;
                    }
                    if ($key == 'mem_phone' && $selfcert_phone) {
                        continue;
                    }
                    if ($key == 'mem_birthday' && $selfcert_birthday) {
                        continue;
                    }
                    if ($key == 'mem_sex' && $selfcert_sex) {
                        continue;
                    }

                    if ($key === 'mem_address') {
                        if (element('required', $value) === '1') {
                            $configbasic['mem_zipcode']['rules'] = $configbasic['mem_zipcode']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_zipcode'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address1']['rules'] = $configbasic['mem_address1']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address1'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address2']['rules'] = $configbasic['mem_address2']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address2'];
                    } else {
                        if (element('required', $value) === '1') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|required';
                        }
                        if (element('field_type', $value) === 'phone') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|valid_phone';
                        }
                        $config[] = $configbasic[$value['field_name']];
                        if ($key === 'mem_password') {
                            $config[] = $configbasic['mem_password_re'];
                        }
                    }
                } else {
                    $required = element('required', $value) ? '|required' : '';
                    if (element('field_type', $value) === 'checkbox') {
                        $config[] = array(
                            'field' => element('field_name', $value) . '[]',
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    } else {
                        $config[] = array(
                            'field' => element('field_name', $value),
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    }
                }
            }
        }

        if ($this->cbconfig->item('use_recaptcha')) {
            $config[] = array(
                'field' => 'g-recaptcha-response',
                'label' => '자동등록방지문자',
                'rules' => 'trim|required|callback__check_recaptcha',
            );
        } else {
            $config[] = array(
                'field' => 'captcha_key',
                'label' => '자동등록방지문자',
                'rules' => 'trim|required|callback__check_captcha',
            );
        }
        $this->form_validation->set_rules($config);

        $form_validation = $this->form_validation->run();
        $file_error = '';
        $updatephoto = '';
        $file_error2 = '';
        $updateicon = '';

        if ($form_validation) {
            $this->load->library('upload');
            if ($this->cbconfig->item('use_member_photo') && $this->cbconfig->item('member_photo_width') > 0 && $this->cbconfig->item('member_photo_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_photo']) && isset($_FILES['mem_photo']['name']) && $_FILES['mem_photo']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_photo/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_photo')) {
                        $img = $this->upload->data();
                        $updatephoto = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error = $this->upload->display_errors();

                    }
                }
            }

            if ($this->cbconfig->item('use_member_icon') && $this->cbconfig->item('member_icon_width') > 0 && $this->cbconfig->item('member_icon_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_icon']) && isset($_FILES['mem_icon']['name']) && $_FILES['mem_icon']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_icon/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_icon')) {
                        $img = $this->upload->data();
                        $updateicon = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error2 = $this->upload->display_errors();
                    }
                }
            }
        }

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($form_validation === false or $file_error !== '' or $file_error2 !== '') {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

            $html_content = array();

            $k = 0;
            if ($form && is_array($form)) {
                foreach ($form as $key => $value) {

                    if (!element('use', $value)) {
                        continue;
                    }

                    // 일반 회원은 계좌 관련 정보를 받지 않는다
                    if (element('field_name', $value) === 'mem_musician_bank' || element('field_name', $value) === 'mem_musician_account' || element('field_name', $value) === 'mem_musician_account_nm') {
                        continue;
                    }

                    if (element('field_name', $value) === 'mem_username' && $selfcert_username) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_phone' && $selfcert_phone) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_birthday' && $selfcert_birthday) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_sex' && $selfcert_sex) {
                        continue;
                    }

                    $required = element('required', $value) ? 'required' : '';

                    $html_content[$k]['field_name'] = element('field_name', $value);
                    $html_content[$k]['display_name'] = element('display_name', $value);
                    $html_content[$k]['input'] = '';

                    //field_type : text, url, email, phone, textarea, radio, select, checkbox, date
                    if (element('field_type', $value) === 'text'
                        or element('field_type', $value) === 'url'
                        or element('field_type', $value) === 'email'
                        or element('field_type', $value) === 'phone'
                        or element('field_type', $value) === 'date') {
                        if (element('field_type', $value) === 'date') {
                            $html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input datepicker" value="' . set_value(element('field_name', $value)) . '" readonly="readonly" ' . $required . ' />';
                        } elseif (element('field_type', $value) === 'phone') {
                            $html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input validphone" value="' . set_value(element('field_name', $value)) . '" ' . $required . ' />';
                        } else {
                            $html_content[$k]['input'] .= '<input type="' . element('field_type', $value) . '" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" value="' . set_value(element('field_name', $value)) . '" ' . $required . '/>';
                        }
                    } elseif (element('field_type', $value) === 'textarea') {
                        $html_content[$k]['input'] .= '<textarea id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" ' . $required . '>' . set_value(element('field_name', $value)) . '</textarea>';
                    } elseif (element('field_type', $value) === 'radio') {
                        $html_content[$k]['input'] .= '<div class="checkbox">';
                        if (element('field_name', $value) === 'mem_sex') {
                            $options = array(
                                '1' => '남성',
                                '2' => '여성',
                            );
                        } else {
                            $options = explode("\n", element('options', $value));
                        }
                        $i = 1;
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $radiovalue = (element('field_name', $value) === 'mem_sex') ? $okey : $oval;
                                $html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="radio" name="' . element('field_name', $value) . '" id="' . element('field_name', $value) . '_' . $i . '" value="' . $radiovalue . '" ' . set_radio(element('field_name', $value), $radiovalue) . ' /> ' . $oval . ' </label> ';
                                $i++;
                            }
                        }
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_type', $value) === 'checkbox') {
                        $html_content[$k]['input'] .= '<div class="checkbox">';
                        $options = explode("\n", element('options', $value));
                        $i = 1;
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="checkbox" name="' . element('field_name', $value) . '[]" id="' . element('field_name', $value) . '_' . $i . '" value="' . $oval . '" ' . set_checkbox(element('field_name', $value), $oval) . ' /> ' . $oval . ' </label> ';
                                $i++;
                            }
                        }
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_type', $value) === 'select') {
                        $html_content[$k]['input'] .= '<div class="input-group">';
                        $html_content[$k]['input'] .= '<select name="' . element('field_name', $value) . '" class="form-control input" ' . $required . '>';
                        $html_content[$k]['input'] .= '<option value="" >선택하세요</option> ';
                        $options = explode("\n", element('options', $value));
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $html_content[$k]['input'] .= '<option value="' . $oval . '" ' . set_select(element('field_name', $value), $oval) . ' >' . $oval . '</option> ';
                            }
                        }
                        $html_content[$k]['input'] .= '</select>';
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_name', $value) === 'mem_address') {
                        $html_content[$k]['input'] .= '
							<label for="mem_zipcode">우편번호</label>
							<label>
								<input type="text" name="mem_zipcode" value="' . set_value('mem_zipcode') . '" id="mem_zipcode" class="form-control input" size="7" maxlength="7" ' . $required . '/>
							</label>
							<label>
								<button type="button" class="btn btn-black btn-sm" style="margin-top:0px;" onclick="win_zip(\'fregisterform\', \'mem_zipcode\', \'mem_address1\', \'mem_address2\', \'mem_address3\', \'mem_address4\');">주소 검색</button>
							</label>
							<div class="addr-line mt10">
								<label for="mem_address1">기본주소</label>
								<input type="text" name="mem_address1" value="' . set_value('mem_address1') . '" id="mem_address1" class="form-control input" placeholder="기본주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10">
								<label for="mem_address2">상세주소</label>
								<input type="text" name="mem_address2" value="' . set_value('mem_address2') . '" id="mem_address2" class="form-control input" placeholder="상세주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10">
								<label for="mem_address3">참고항목</label>
								<input type="text" name="mem_address3" value="' . set_value('mem_address3') . '" id="mem_address3" class="form-control input" readonly="readonly" placeholder="참고항목" />
							</div>
							<input type="hidden" name="mem_address4" value="' . set_value('mem_address4') . '" />
						';
                    } elseif (element('field_name', $value) === 'mem_password') {
                        $html_content[$k]['input'] .= '<input type="' . element('field_type', $value) . '" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" minlength="' . $password_length . '" />';
                    }

                    $html_content[$k]['description'] = '';
                    if (isset($configbasic[$value['field_name']]['description']) && $configbasic[$value['field_name']]['description']) {
                        $html_content[$k]['description'] = $configbasic[$value['field_name']]['description'];
                    }
                    if (element('field_name', $value) === 'mem_password') {
                        $k++;
                        $html_content[$k]['field_name'] = 'mem_password_re';
                        $html_content[$k]['display_name'] = '비밀번호 확인';
                        $html_content[$k]['input'] = '<input type="password" id="mem_password_re" name="mem_password_re" class="form-control input" minlength="' . $password_length . '" />';
                    }
                    $k++;
                }
            }

            $view['view']['html_content'] = $html_content;
            $view['view']['open_profile_description'] = '';
            if ($this->cbconfig->item('change_open_profile_date')) {
                $view['view']['open_profile_description'] = '정보공개 설정은 ' . $this->cbconfig->item('change_open_profile_date') . '일 이내에는 변경할 수 없습니다';
            }

            $view['view']['use_note_description'] = '';
            if ($this->cbconfig->item('change_use_note_date')) {
                $view['view']['use_note_description'] = '쪽지 기능 사용 설정은 ' . $this->cbconfig->item('change_use_note_date') . '일 이내에는 변경할 수 없습니다';
            }

            $view['view']['canonical'] = site_url('register/form_user');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register_form');
            $meta_description = $this->cbconfig->item('site_meta_description_register_form');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_form');
            $meta_author = $this->cbconfig->item('site_meta_author_register_form');
            $page_name = $this->cbconfig->item('site_page_name_register_form');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_form_user',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

        } else {

            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $mem_level = (int)$this->cbconfig->item('register_level');
            $insertdata = array();
            $metadata = array();

            $insertdata['mem_userid'] = $this->input->post('mem_userid');
            $insertdata['mem_email'] = $this->input->post('mem_email');
            $insertdata['mem_password'] = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);
            $insertdata['mem_nickname'] = $this->input->post('mem_nickname');
            $metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_level'] = $mem_level;

            if ($selfcert_username) {
                $insertdata['mem_username'] = $selfcert_username;
            } else if (isset($form['mem_username']['use']) && $form['mem_username']['use']) {
                $insertdata['mem_username'] = $this->input->post('mem_username', null, '');
            }
            if (isset($form['mem_homepage']['use']) && $form['mem_homepage']['use']) {
                $insertdata['mem_homepage'] = $this->input->post('mem_homepage', null, '');
            }
            if ($selfcert_phone) {
                $insertdata['mem_phone'] = $selfcert_phone;
            } else if (isset($form['mem_phone']['use']) && $form['mem_phone']['use']) {
                $insertdata['mem_phone'] = $this->input->post('mem_phone', null, '');
            }
            if ($selfcert_birthday) {
                $insertdata['mem_birthday'] = $selfcert_birthday;
            } else if (isset($form['mem_birthday']['use']) && $form['mem_birthday']['use']) {
                $insertdata['mem_birthday'] = $this->input->post('mem_birthday', null, '');
            }
            if ($selfcert_sex) {
                $insertdata['mem_sex'] = $selfcert_sex;
            } else if (isset($form['mem_sex']['use']) && $form['mem_sex']['use']) {
                $insertdata['mem_sex'] = $this->input->post('mem_sex', null, '');
            }
            if (isset($form['mem_address']['use']) && $form['mem_address']['use']) {
                $insertdata['mem_zipcode'] = $this->input->post('mem_zipcode', null, '');
                $insertdata['mem_address1'] = $this->input->post('mem_address1', null, '');
                $insertdata['mem_address2'] = $this->input->post('mem_address2', null, '');
                $insertdata['mem_address3'] = $this->input->post('mem_address3', null, '');
                $insertdata['mem_address4'] = $this->input->post('mem_address4', null, '');
            }
            $insertdata['mem_receive_email'] = $this->input->post('mem_receive_email') ? 1 : 0;
            if ($this->cbconfig->item('use_note')) {
                $insertdata['mem_use_note'] = $this->input->post('mem_use_note') ? 1 : 0;
                $metadata['meta_use_note_datetime'] = cdate('Y-m-d H:i:s');
            }
            $insertdata['mem_receive_sms'] = $this->input->post('mem_receive_sms') ? 1 : 0;
            $insertdata['mem_open_profile'] = $this->input->post('mem_open_profile') ? 1 : 0;
            $metadata['meta_open_profile_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_ip'] = $this->input->ip_address();
            $metadata['meta_change_pw_datetime'] = cdate('Y-m-d H:i:s');
            if (isset($form['mem_profile_content']['use']) && $form['mem_profile_content']['use']) {
                $insertdata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');
            }

            if ($this->cbconfig->item('use_register_email_auth')) {
                $insertdata['mem_email_cert'] = 0;
                $metadata['meta_email_cert_datetime'] = '';
            } else {
                $insertdata['mem_email_cert'] = 1;
                $metadata['meta_email_cert_datetime'] = cdate('Y-m-d H:i:s');
            }

            if ($updatephoto) {
                $insertdata['mem_photo'] = $updatephoto;
            }
            if ($updateicon) {
                $insertdata['mem_icon'] = $updateicon;
            }

            $mem_id = $this->Member_model->insert($insertdata);

            if ($selfcert_meta) {
                foreach ($selfcert_meta as $certkey => $certvalue) {
                    $metadata[$certkey] = $certvalue;
                }

                $selfcertupdatedata = array(
                    'mem_id' => $mem_id
                );
                $selfcertwhere = array(
                    'msh_cert_key' => $selfcert_key,
                );

                $this->load->model('Member_selfcert_history_model');
                $this->Member_selfcert_history_model->update('', $selfcertupdatedata, $selfcertwhere);
            }

            $this->Member_meta_model->save($mem_id, $metadata);

            $extradata = array();
            if ($form && is_array($form)) {
                $this->load->model('Member_extra_vars_model');
                foreach ($form as $key => $value) {
                    if (!element('use', $value)) {
                        continue;
                    }
                    if (element('func', $value) === 'basic') {
                        continue;
                    }
                    $extradata[element('field_name', $value)] = $this->input->post(element('field_name', $value), null, '');
                }
                $this->Member_extra_vars_model->save($mem_id, $extradata);
            }

            $levelhistoryinsert = array(
                'mem_id' => $mem_id,
                'mlh_from' => 0,
                'mlh_to' => $mem_level,
                'mlh_datetime' => cdate('Y-m-d H:i:s'),
                'mlh_reason' => '회원가입',
                'mlh_ip' => $this->input->ip_address(),
            );
            $this->load->model('Member_level_history_model');
            $this->Member_level_history_model->insert($levelhistoryinsert);

            $this->load->model('Member_group_model');
            $allgroup = $this->Member_group_model->get_all_group();
            if ($allgroup && is_array($allgroup)) {
                $this->load->model('Member_group_member_model');
                foreach ($allgroup as $gkey => $gval) {
                    if (element('mgr_is_default', $gval)) {
                        $gminsert = array(
                            'mgr_id' => element('mgr_id', $gval),
                            'mem_id' => $mem_id,
                            'mgm_datetime' => cdate('Y-m-d H:i:s'),
                        );
                        $this->Member_group_member_model->insert($gminsert);
                    }
                }
            }

            $this->point->insert_point(
                $mem_id,
                $this->cbconfig->item('point_register'),
                '회원가입을 축하합니다',
                'member',
                $mem_id,
                '회원가입'
            );

            $searchconfig = array(
                '{홈페이지명}',
                '{회사명}',
                '{홈페이지주소}',
                '{회원아이디}',
                '{회원닉네임}',
                '{회원실명}',
                '{회원이메일}',
                '{메일수신여부}',
                '{쪽지수신여부}',
                '{문자수신여부}',
                '{회원아이피}',
            );
            $mem_userid = $this->input->post('mem_userid', null, '');
            $mem_nickname = $this->input->post('mem_nickname', null, '');
            $mem_username = $selfcert_username ? $selfcert_username : $this->input->post('mem_username', null, '');
            $mem_email = $this->input->post('mem_email', null, '');
            $receive_email = $this->input->post('mem_receive_email') ? '동의' : '거부';
            $receive_note = $this->input->post('mem_use_note') ? '동의' : '거부';
            $receive_sms = $this->input->post('mem_receive_sms') ? '동의' : '거부';
            $replaceconfig = array(
                $this->cbconfig->item('site_title'),
                $this->cbconfig->item('company_name'),
                site_url(),
                $mem_userid,
                $mem_nickname,
                $mem_username,
                $mem_email,
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );
            $replaceconfig_escape = array(
                html_escape($this->cbconfig->item('site_title')),
                html_escape($this->cbconfig->item('company_name')),
                site_url(),
                html_escape($mem_userid),
                html_escape($mem_nickname),
                html_escape($mem_username),
                html_escape($mem_email),
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );

            if (!$this->cbconfig->item('use_register_email_auth')) {
                if (($this->cbconfig->item('send_email_register_user') && $this->input->post('mem_receive_email'))
                    or $this->cbconfig->item('send_email_register_alluser')) {
                    $title = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_email_register_user_title')
                    );
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig_escape,
                        $this->cbconfig->item('send_email_register_user_content')
                    );

                    // PHPMailer object
                    $mail = $this->phpmailer_lib->load();
                    $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $mail->addReplyTo();
                    $mail->addAddress($this->input->post('mem_email'));
                    $mail->Subject = $title;
                    $mail->isHTML(true);
                    $mail->Body = $content;
                    $mail->send();

                }
            } else {
                $vericode = array('$', '/', '.');
                $verificationcode = str_replace(
                    $vericode,
                    '',
                    password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
                );

                $beforeauthdata = array(
                    'mem_id' => $mem_id,
                    'mae_type' => 1,
                );
                $this->Member_auth_email_model->delete_where($beforeauthdata);
                $authdata = array(
                    'mem_id' => $mem_id,
                    'mae_key' => $verificationcode,
                    'mae_type' => 1,
                    'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_auth_email_model->insert($authdata);

                $verify_url = site_url('verify/confirmemail?user=' . $this->input->post('mem_userid') . '&code=' . $verificationcode);

                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_user_verifytitle')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_user_verifycontent')
                );

                $title = str_replace('{메일인증주소}', $verify_url, $title);
                $content = str_replace('{메일인증주소}', $verify_url, $content);

                /*
				$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
				$this->email->to($this->input->post('mem_email'));
				$this->email->subject($title);
				$this->email->message($content);
				$this->email->send();
                */

                // PHPMailer object
                $mail = $this->phpmailer_lib->load();
                $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                $mail->addReplyTo();
                $mail->addAddress($this->input->post('mem_email'));
                $mail->Subject = $title;
                $mail->isHTML(true);
                $mail->Body = $content;
                $mail->send();

                $email_auth_message = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
                $this->session->set_flashdata(
                    'email_auth_message',
                    $email_auth_message
                );
            }

            $emailsendlistadmin = array();
            $notesendlistadmin = array();
            $smssendlistadmin = array();
            $notesendlistuser = array();
            $smssendlistuser = array();

            $superadminlist = '';
            if ($this->cbconfig->item('send_email_register_admin')
                or $this->cbconfig->item('send_note_register_admin')
                or $this->cbconfig->item('send_sms_register_admin')) {
                $mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
                $superadminlist = $this->Member_model->get_superadmin_list($mselect);
            }

            if ($this->cbconfig->item('send_email_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $emailsendlistadmin[$value['mem_id']] = $value;
                }
            }
            if ($this->cbconfig->item('send_note_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $notesendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_note_register_user') && $this->input->post('mem_use_note'))) {
                $notesendlistuser['mem_id'] = $mem_id;
            }
            if ($this->cbconfig->item('send_sms_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $smssendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_sms_register_user') && $this->input->post('mem_receive_sms'))
                or $this->cbconfig->item('send_sms_register_alluser')) {
                if ($selfcert_phone or $this->input->post('mem_phone')) {
                    $smssendlistuser['mem_id'] = $mem_id;
                    $smssendlistuser['mem_nickname'] = $this->input->post('mem_nickname');
                    $smssendlistuser['mem_phone'] = $selfcert_phone ? $selfcert_phone : $this->input->post('mem_phone');
                }
            }

            if ($emailsendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_admin_content')
                );
                foreach ($emailsendlistadmin as $akey => $aval) {
                    /*
					$this->email->clear(true);
					$this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
					$this->email->to(element('mem_email', $aval));
					$this->email->subject($title);
					$this->email->message($content);
					$this->email->send();
                    */
                    // PHPMailer object
                    $mail = $this->phpmailer_lib->load();
                    $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $mail->addReplyTo();
                    $mail->addAddress(element('mem_email', $aval));
                    $mail->Subject = $title;
                    $mail->isHTML(true);
                    $mail->Body = $content;
                    $mail->send();
                }
            }
            if ($notesendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_admin_content')
                );
                foreach ($notesendlistadmin as $akey => $aval) {
                    $note_result = $this->notelib->send_note(
                        $sender = 0,
                        $receiver = element('mem_id', $aval),
                        $title,
                        $content,
                        1
                    );
                }
            }
            if ($notesendlistuser && element('mem_id', $notesendlistuser)) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_user_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_user_content')
                );
                $note_result = $this->notelib->send_note(
                    $sender = 0,
                    $receiver = element('mem_id', $notesendlistuser),
                    $title,
                    $content,
                    1
                );
            }
            if ($smssendlistadmin) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_admin_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    foreach ($smssendlistadmin as $akey => $aval) {
                        $receiver[] = array(
                            'mem_id' => element('mem_id', $aval),
                            'name' => element('mem_nickname', $aval),
                            'phone' => element('mem_phone', $aval),
                        );
                    }
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }
            if ($smssendlistuser) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_user_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    $receiver[] = $smssendlistuser;
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }

            $member_register_data = array(
                'mem_id' => $mem_id,
                'mrg_ip' => $this->input->ip_address(),
                'mrg_datetime' => cdate('Y-m-d H:i:s'),
                'mrg_useragent' => $this->agent->agent_string(),
                'mrg_referer' => $this->session->userdata('site_referer'),
            );
            $recommended = '';
            if ($this->input->post('mem_recommend')) {
                $recommended = $this->Member_model->get_by_userid($this->input->post('mem_recommend'), 'mem_id');
                if (element('mem_id', $recommended)) {
                    $member_register_data['mrg_recommend_mem_id'] = element('mem_id', $recommended);
                } else {
                    $recommended['mem_id'] = 0;
                }
            }
            $this->load->model('Member_register_model');
            $this->Member_register_model->insert($member_register_data);

            if ($this->input->post('mem_recommend')) {
                if ($this->cbconfig->item('point_recommended')) {
                    // 추천인이 존재할 경우 추천된 사람
                    $this->point->insert_point(
                        element('mem_id', $recommended),
                        $this->cbconfig->item('point_recommended'),
                        $this->input->post('mem_nickname') . ' 님이 회원가입시 추천함',
                        'member_recommended',
                        $mem_id,
                        '회원가입추천'
                    );
                }
                if ($this->cbconfig->item('point_recommender')) {
                    // 추천인이 존재할 경우 가입자에게
                    $this->point->insert_point(
                        $mem_id,
                        $this->cbconfig->item('point_recommender'),
                        '회원가입 추천인존재',
                        'member_recommender',
                        $mem_id,
                        '회원가입추천인존재'
                    );
                }
            }

            $this->session->set_flashdata(
                'nickname',
                $this->input->post('mem_nickname')
            );

            if (!$this->cbconfig->item('use_register_email_auth')) {
                $this->session->set_userdata(
                    'mem_id',
                    $mem_id
                );
            }
            $this->session->unset_userdata('selfcertinfo');

            redirect('register/result_user');
        }
    }

    /**
     * 회원가입 폼 페이지입니다
     */
    public function form_musician()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_form';
        $this->load->event($eventname);

        if ($this->member->is_member() && !($this->member->is_admin() === 'super' && $this->uri->segment(1) === config_item('uri_segment_admin'))) {
            redirect();
        }

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        if ($this->cbconfig->item('use_register_block')) {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_block_layout'] = Events::trigger('before_block_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register_form');
            $meta_description = $this->cbconfig->item('site_meta_description_register_form');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_form');
            $meta_author = $this->cbconfig->item('site_meta_author_register_form');
            $page_name = $this->cbconfig->item('site_page_name_register_form');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_block_musician',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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
            return false;
        }


        if ($this->cbconfig->item('use_selfcert') && $this->cbconfig->item('use_selfcert_required') && !$this->session->userdata('selfcertinfo')) {
            if (!$this->session->userdata('selfcertinfo')) {
                $this->session->set_flashdata(
                    'message',
                    '본인 확인 후에 회원가입이 가능합니다.'
                );
                redirect('register');
            }
        }

        $selfcert_phone = $selfcert_username = $selfcert_birthday = $selfcert_sex = '';
        $selfcert_meta = '';

        if ($this->cbconfig->item('use_selfcert') && $this->session->userdata('selfcertinfo')) {
            $selfcertinfo = $this->session->userdata('selfcertinfo');
            if (element('selfcert_type', $selfcertinfo) == 'phone') {
                if ($this->cbconfig->item('use_selfcert_phone') == 'kcb' or $this->cbconfig->item('use_selfcert_phone') == 'kcp') {
                    $selfcert_phone = element('selfcert_phone', $selfcertinfo);
                    $selfcert_username = element('selfcert_username', $selfcertinfo);
                    $selfcert_birthday = element('selfcert_birthday', $selfcertinfo);
                    $selfcert_sex = element('selfcert_sex', $selfcertinfo);
                    $selfcert_key = element('selfcert_key', $selfcertinfo);
                    $selfcert_local_code = element('selfcert_local_code', $selfcertinfo);
                    $selfcert_meta = array(
                        'selfcert_type' => element('selfcert_type', $selfcertinfo),
                        'selfcert_company' => $this->cbconfig->item('use_selfcert_phone'),
                        'selfcert_comm_id' => element('selfcert_comm_id', $selfcertinfo),
                        'selfcert_phone' => $selfcert_phone,
                        'selfcert_username' => $selfcert_username,
                        'selfcert_birthday' => $selfcert_birthday,
                        'selfcert_sex' => $selfcert_sex,
                        'selfcert_key' => $selfcert_key,
                        'selfcert_local_code' => $selfcert_local_code,
                    );
                }
            }
        }

        $password_length = $this->cbconfig->item('password_length');
        $email_description = '';
        if ($this->cbconfig->item('use_register_email_auth')) {
            $email_description = '회원가입 후 인증메일이 발송됩니다. 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
        }

        $configbasic = array();

        $nickname_description = '';
        if ($this->cbconfig->item('change_nickname_date')) {
            $nickname_description = '<br />닉네임을 입력하시면 앞으로 '
                . $this->cbconfig->item('change_nickname_date') . '일 이내에는 변경할 수 없습니다';
        }

        $configbasic['mem_userid'] = array(
            'field' => 'mem_userid',
            'label' => '아이디',
            'rules' => 'trim|required|alphanumunder|min_length[3]|max_length[20]|callback__mem_userid_check',
            'description' => '영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요',
        );

        $password_description = '비밀번호는 ' . $password_length . '자리 이상이어야 ';
        if ($this->cbconfig->item('password_uppercase_length')
            or $this->cbconfig->item('password_numbers_length')
            or $this->cbconfig->item('password_specialchars_length')) {

            $password_description .= '하며 ';
            if ($this->cbconfig->item('password_uppercase_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_uppercase_length') . '개의 대문자';
            }
            if ($this->cbconfig->item('password_numbers_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_numbers_length') . '개의 숫자';
            }
            if ($this->cbconfig->item('password_specialchars_length')) {
                $password_description .= ', ' . $this->cbconfig->item('password_specialchars_length') . '개의 특수문자';
            }
            $password_description .= '를 포함해야 ';
        }
        $password_description .= '합니다';

        $configbasic['mem_password'] = array(
            'field' => 'mem_password',
            'label' => '패스워드',
            'rules' => 'trim|required|min_length[' . $password_length . ']|callback__mem_password_check',
            'description' => $password_description,
        );
        $configbasic['mem_password_re'] = array(
            'field' => 'mem_password_re',
            'label' => '패스워드 확인',
            'rules' => 'trim|required|min_length[' . $password_length . ']|matches[mem_password]',
        );
        if (!$selfcert_username) {
            $configbasic['mem_username'] = array(
                'field' => 'mem_username',
                'label' => '이름',
                'rules' => 'trim|min_length[2]|max_length[20]',
            );
        }
        $configbasic['mem_nickname'] = array(
            'field' => 'mem_nickname',
            'label' => '닉네임',
            'rules' => 'trim|required|min_length[2]|max_length[20]|callback__mem_nickname_check',
            'description' => '공백없이 한글, 영문, 숫자만 입력 가능 2글자 이상' . $nickname_description,
        );
        $configbasic['mem_email'] = array(
            'field' => 'mem_email',
            'label' => '이메일',
            'rules' => 'trim|required|valid_email|max_length[50]|is_unique[member.mem_email]|callback__mem_email_check',
            'description' => $email_description,
        );
        $configbasic['mem_homepage'] = array(
            'field' => 'mem_homepage',
            'label' => '홈페이지',
            'rules' => 'prep_url|valid_url',
        );
        if (!$selfcert_phone) {
            $configbasic['mem_phone'] = array(
                'field' => 'mem_phone',
                'label' => '전화번호',
                'rules' => 'trim|valid_phone',
            );
        }
        if (!$selfcert_birthday) {
            $configbasic['mem_birthday'] = array(
                'field' => 'mem_birthday',
                'label' => '생년월일',
                'rules' => 'trim|exact_length[10]',
            );
        }
        if (!$selfcert_sex) {
            $configbasic['mem_sex'] = array(
                'field' => 'mem_sex',
                'label' => '성별',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_zipcode'] = array(
            'field' => 'mem_zipcode',
            'label' => '우편번호',
            'rules' => 'trim|min_length[5]|max_length[7]',
        );
        $configbasic['mem_address1'] = array(
            'field' => 'mem_address1',
            'label' => '기본주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address2'] = array(
            'field' => 'mem_address2',
            'label' => '상세주소',
            'rules' => 'trim',
        );
        $configbasic['mem_address3'] = array(
            'field' => 'mem_address3',
            'label' => '참고항목',
            'rules' => 'trim',
        );
        $configbasic['mem_address4'] = array(
            'field' => 'mem_address4',
            'label' => '지번',
            'rules' => 'trim',
        );
        $configbasic['mem_profile_content'] = array(
            'field' => 'mem_profile_content',
            'label' => '자기소개',
            'rules' => 'trim',
        );
        $configbasic['mem_open_profile'] = array(
            'field' => 'mem_open_profile',
            'label' => '정보공개',
            'rules' => 'trim|exact_length[1]',
        );
        if ($this->cbconfig->item('use_note')) {
            $configbasic['mem_use_note'] = array(
                'field' => 'mem_use_note',
                'label' => '쪽지사용',
                'rules' => 'trim|exact_length[1]',
            );
        }
        $configbasic['mem_receive_email'] = array(
            'field' => 'mem_receive_email',
            'label' => '이메일수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_receive_sms'] = array(
            'field' => 'mem_receive_sms',
            'label' => 'SMS 문자수신여부',
            'rules' => 'trim|exact_length[1]',
        );
        $configbasic['mem_recommend'] = array(
            'field' => 'mem_recommend',
            'label' => '추천인아이디',
            'rules' => 'trim|alphanumunder|min_length[3]|max_length[20]|callback__mem_recommend_check',
        );


        if ($this->member->is_admin() === false && !$this->session->userdata('registeragree')) {
            $this->session->set_flashdata(
                'message',
                '회원가입약관동의와 개인정보취급방침동의후 회원가입이 가능합니다'
            );
            redirect('register_musician');
        }

        $registerform = $this->cbconfig->item('registerform');
        $form = json_decode($registerform, true);

        log_message('debug', print_r($form, true));

        $config = array();
        if ($form && is_array($form)) {
            foreach ($form as $key => $value) {
                if (!element('use', $value)) {
                    continue;
                }
                if (element('func', $value) === 'basic') {
                    if ($key == 'mem_username' && $selfcert_username) {
                        continue;
                    }
                    if ($key == 'mem_phone' && $selfcert_phone) {
                        continue;
                    }
                    if ($key == 'mem_birthday' && $selfcert_birthday) {
                        continue;
                    }
                    if ($key == 'mem_sex' && $selfcert_sex) {
                        continue;
                    }


                    if ($key === 'mem_address') {
                        if (element('required', $value) === '1') {
                            $configbasic['mem_zipcode']['rules'] = $configbasic['mem_zipcode']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_zipcode'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address1']['rules'] = $configbasic['mem_address1']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address1'];
                        if (element('required', $value) === '1') {
                            $configbasic['mem_address2']['rules'] = $configbasic['mem_address2']['rules'] . '|required';
                        }
                        $config[] = $configbasic['mem_address2'];
                    } else {

                        if (element('required', $value) === '1') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|required';
                        }
                        if (element('field_type', $value) === 'phone') {
                            $configbasic[$value['field_name']]['rules'] = $configbasic[$value['field_name']]['rules'] . '|valid_phone';
                        }
                        $config[] = $configbasic[$value['field_name']];
                        if ($key === 'mem_password') {
                            $config[] = $configbasic['mem_password_re'];
                        }
                    }
                } else {

                    // 뮤지션 회원은 계좌 관련 필수 입력 받는다
                    if ($key === 'mem_musician_bank' || $key === 'mem_musician_account' || $key === 'mem_musician_account_nm') {
                        $required = '|required';
                    } else {
                        $required = element('required', $value) ? '|required' : '';
                    }
                    if (element('field_type', $value) === 'checkbox') {
                        $config[] = array(
                            'field' => element('field_name', $value) . '[]',
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    } else {
                        $config[] = array(
                            'field' => element('field_name', $value),
                            'label' => element('display_name', $value),
                            'rules' => 'trim' . $required,
                        );
                    }
                }
            }
        }

        log_message('debug', '===============================');
        log_message('debug', print_r($config, true));

        if ($this->cbconfig->item('use_recaptcha')) {
            $config[] = array(
                'field' => 'g-recaptcha-response',
                'label' => '자동등록방지문자',
                'rules' => 'trim|required|callback__check_recaptcha',
            );
        } else {
            $config[] = array(
                'field' => 'captcha_key',
                'label' => '자동등록방지문자',
                'rules' => 'trim|required|callback__check_captcha',
            );
        }
        $this->form_validation->set_rules($config);

        $form_validation = $this->form_validation->run();
        $file_error = '';
        $updatephoto = '';
        $file_error2 = '';
        $updateicon = '';

        if ($form_validation) {
            $this->load->library('upload');
            if ($this->cbconfig->item('use_member_photo') && $this->cbconfig->item('member_photo_width') > 0 && $this->cbconfig->item('member_photo_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_photo']) && isset($_FILES['mem_photo']['name']) && $_FILES['mem_photo']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_photo/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_photo')) {
                        $img = $this->upload->data();
                        $updatephoto = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error = $this->upload->display_errors();

                    }
                }
            }

            if ($this->cbconfig->item('use_member_icon') && $this->cbconfig->item('member_icon_width') > 0 && $this->cbconfig->item('member_icon_height') > 0) {
                if (isset($_FILES) && isset($_FILES['mem_icon']) && isset($_FILES['mem_icon']['name']) && $_FILES['mem_icon']['name']) {
                    $upload_path = config_item('uploads_dir') . '/member_icon/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('Y') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }
                    $upload_path .= cdate('m') . '/';
                    if (is_dir($upload_path) === false) {
                        mkdir($upload_path, 0707);
                        $file = $upload_path . 'index.php';
                        $f = @fopen($file, 'w');
                        @fwrite($f, '');
                        @fclose($f);
                        @chmod($file, 0644);
                    }

                    $uploadconfig = array();
                    $uploadconfig['upload_path'] = $upload_path;
                    $uploadconfig['allowed_types'] = 'jpg|jpeg|png|gif';
                    $uploadconfig['max_size'] = '2000';
                    $uploadconfig['max_width'] = '1000';
                    $uploadconfig['max_height'] = '1000';
                    $uploadconfig['encrypt_name'] = true;

                    $this->upload->initialize($uploadconfig);

                    if ($this->upload->do_upload('mem_icon')) {
                        $img = $this->upload->data();
                        $updateicon = cdate('Y') . '/' . cdate('m') . '/' . $img['file_name'];
                    } else {
                        $file_error2 = $this->upload->display_errors();
                    }
                }
            }
        }

        /**
         * 유효성 검사를 하지 않는 경우, 또는 유효성 검사에 실패한 경우입니다.
         * 즉 글쓰기나 수정 페이지를 보고 있는 경우입니다
         */
        if ($form_validation === false or $file_error !== '' or $file_error2 !== '') {

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

            $html_content = array();

            $k = 0;
            if ($form && is_array($form)) {
                foreach ($form as $key => $value) {
                    if (!element('use', $value)) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_username' && $selfcert_username) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_phone' && $selfcert_phone) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_birthday' && $selfcert_birthday) {
                        continue;
                    }
                    if (element('field_name', $value) === 'mem_sex' && $selfcert_sex) {
                        continue;
                    }

                    $required = element('required', $value) ? 'required' : '';

                    $html_content[$k]['field_name'] = element('field_name', $value);
                    $html_content[$k]['display_name'] = element('display_name', $value);
                    $html_content[$k]['input'] = '';

                    //field_type : text, url, email, phone, textarea, radio, select, checkbox, date
                    if (element('field_type', $value) === 'text'
                        or element('field_type', $value) === 'url'
                        or element('field_type', $value) === 'email'
                        or element('field_type', $value) === 'phone'
                        or element('field_type', $value) === 'date') {
                        if (element('field_type', $value) === 'date') {
                            $html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input datepicker" value="' . set_value(element('field_name', $value)) . '" readonly="readonly" ' . $required . ' />';
                        } elseif (element('field_type', $value) === 'phone') {
                            $html_content[$k]['input'] .= '<input type="text" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input validphone" value="' . set_value(element('field_name', $value)) . '" ' . $required . ' />';
                        } else {
                            $html_content[$k]['input'] .= '<input type="' . element('field_type', $value) . '" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" value="' . set_value(element('field_name', $value)) . '" ' . $required . '/>';
                        }
                    } elseif (element('field_type', $value) === 'textarea') {
                        $html_content[$k]['input'] .= '<textarea id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" ' . $required . '>' . set_value(element('field_name', $value)) . '</textarea>';
                    } elseif (element('field_type', $value) === 'radio') {
                        $html_content[$k]['input'] .= '<div class="checkbox">';
                        if (element('field_name', $value) === 'mem_sex') {
                            $options = array(
                                '1' => '남성',
                                '2' => '여성',
                            );
                        } else {
                            $options = explode("\n", element('options', $value));
                        }
                        $i = 1;
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $radiovalue = (element('field_name', $value) === 'mem_sex') ? $okey : $oval;
                                $html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="radio" name="' . element('field_name', $value) . '" id="' . element('field_name', $value) . '_' . $i . '" value="' . $radiovalue . '" ' . set_radio(element('field_name', $value), $radiovalue) . ' /> ' . $oval . ' </label> ';
                                $i++;
                            }
                        }
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_type', $value) === 'checkbox') {
                        $html_content[$k]['input'] .= '<div class="checkbox">';
                        $options = explode("\n", element('options', $value));
                        $i = 1;
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $html_content[$k]['input'] .= '<label for="' . element('field_name', $value) . '_' . $i . '"><input type="checkbox" name="' . element('field_name', $value) . '[]" id="' . element('field_name', $value) . '_' . $i . '" value="' . $oval . '" ' . set_checkbox(element('field_name', $value), $oval) . ' /> ' . $oval . ' </label> ';
                                $i++;
                            }
                        }
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_type', $value) === 'select') {
                        $html_content[$k]['input'] .= '<div class="input-group">';
                        $html_content[$k]['input'] .= '<select name="' . element('field_name', $value) . '" class="form-control input" ' . $required . '>';
                        $html_content[$k]['input'] .= '<option value="" >선택하세요</option> ';
                        $options = explode("\n", element('options', $value));
                        if ($options) {
                            foreach ($options as $okey => $oval) {
                                $html_content[$k]['input'] .= '<option value="' . $oval . '" ' . set_select(element('field_name', $value), $oval) . ' >' . $oval . '</option> ';
                            }
                        }
                        $html_content[$k]['input'] .= '</select>';
                        $html_content[$k]['input'] .= '</div>';
                    } elseif (element('field_name', $value) === 'mem_address') {
                        $html_content[$k]['input'] .= '
							<label for="mem_zipcode">우편번호</label>
							<label>
								<input type="text" name="mem_zipcode" value="' . set_value('mem_zipcode') . '" id="mem_zipcode" class="form-control input" size="7" maxlength="7" ' . $required . '/>
							</label>
							<label>
								<button type="button" class="btn btn-black btn-sm" style="margin-top:0px;" onclick="win_zip(\'fregisterform\', \'mem_zipcode\', \'mem_address1\', \'mem_address2\', \'mem_address3\', \'mem_address4\');">주소 검색</button>
							</label>
							<div class="addr-line mt10">
								<label for="mem_address1">기본주소</label>
								<input type="text" name="mem_address1" value="' . set_value('mem_address1') . '" id="mem_address1" class="form-control input" placeholder="기본주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10">
								<label for="mem_address2">상세주소</label>
								<input type="text" name="mem_address2" value="' . set_value('mem_address2') . '" id="mem_address2" class="form-control input" placeholder="상세주소" ' . $required . ' />
							</div>
							<div class="addr-line mt10">
								<label for="mem_address3">참고항목</label>
								<input type="text" name="mem_address3" value="' . set_value('mem_address3') . '" id="mem_address3" class="form-control input" readonly="readonly" placeholder="참고항목" />
							</div>
							<input type="hidden" name="mem_address4" value="' . set_value('mem_address4') . '" />
						';
                    } elseif (element('field_name', $value) === 'mem_password') {
                        $html_content[$k]['input'] .= '<input type="' . element('field_type', $value) . '" id="' . element('field_name', $value) . '" name="' . element('field_name', $value) . '" class="form-control input" minlength="' . $password_length . '" />';
                    }

                    $html_content[$k]['description'] = '';
                    if (isset($configbasic[$value['field_name']]['description']) && $configbasic[$value['field_name']]['description']) {
                        $html_content[$k]['description'] = $configbasic[$value['field_name']]['description'];
                    }
                    if (element('field_name', $value) === 'mem_password') {
                        $k++;
                        $html_content[$k]['field_name'] = 'mem_password_re';
                        $html_content[$k]['display_name'] = '비밀번호 확인';
                        $html_content[$k]['input'] = '<input type="password" id="mem_password_re" name="mem_password_re" class="form-control input" minlength="' . $password_length . '" />';
                    }
                    $k++;
                }
            }

            $view['view']['html_content'] = $html_content;
            $view['view']['open_profile_description'] = '';
            if ($this->cbconfig->item('change_open_profile_date')) {
                $view['view']['open_profile_description'] = '정보공개 설정은 ' . $this->cbconfig->item('change_open_profile_date') . '일 이내에는 변경할 수 없습니다';
            }

            $view['view']['use_note_description'] = '';
            if ($this->cbconfig->item('change_use_note_date')) {
                $view['view']['use_note_description'] = '쪽지 기능 사용 설정은 ' . $this->cbconfig->item('change_use_note_date') . '일 이내에는 변경할 수 없습니다';
            }

            $view['view']['canonical'] = site_url('register/form_user');

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

            /**
             * 레이아웃을 정의합니다
             */
            $page_title = $this->cbconfig->item('site_meta_title_register_form');
            $meta_description = $this->cbconfig->item('site_meta_description_register_form');
            $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_form');
            $meta_author = $this->cbconfig->item('site_meta_author_register_form');
            $page_name = $this->cbconfig->item('site_page_name_register_form');

            $layoutconfig = array(
                'path' => 'register',
                'layout' => 'layout',
                'skin' => 'register_form_musician',
                'layout_dir' => $this->cbconfig->item('layout_register'),
                'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
                'use_sidebar' => $this->cbconfig->item('sidebar_register'),
                'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
                'skin_dir' => $this->cbconfig->item('skin_register'),
                'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

        } else {

            /**
             * 유효성 검사를 통과한 경우입니다.
             * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
             */

            // 이벤트가 존재하면 실행합니다
            $view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

            $mem_level = (int)$this->cbconfig->item('register_level');
            $insertdata = array();
            $metadata = array();

            $insertdata['mem_userid'] = $this->input->post('mem_userid');
            $insertdata['mem_email'] = $this->input->post('mem_email');
            $insertdata['mem_password'] = password_hash($this->input->post('mem_password'), PASSWORD_BCRYPT);
            $insertdata['mem_nickname'] = $this->input->post('mem_nickname');
            $metadata['meta_nickname_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_level'] = $mem_level;
            // 뮤지션 회원은 차단 상태로 가입됨
            $insertdata['mem_denied'] = 1;
            // 뮤지션 회원은 mem_usertype = 2 로 가입
            $insertdata['mem_usertype'] = 2;

            if ($selfcert_username) {
                $insertdata['mem_username'] = $selfcert_username;
            } else if (isset($form['mem_username']['use']) && $form['mem_username']['use']) {
                $insertdata['mem_username'] = $this->input->post('mem_username', null, '');
            }
            if (isset($form['mem_homepage']['use']) && $form['mem_homepage']['use']) {
                $insertdata['mem_homepage'] = $this->input->post('mem_homepage', null, '');
            }
            if ($selfcert_phone) {
                $insertdata['mem_phone'] = $selfcert_phone;
            } else if (isset($form['mem_phone']['use']) && $form['mem_phone']['use']) {
                $insertdata['mem_phone'] = $this->input->post('mem_phone', null, '');
            }
            if ($selfcert_birthday) {
                $insertdata['mem_birthday'] = $selfcert_birthday;
            } else if (isset($form['mem_birthday']['use']) && $form['mem_birthday']['use']) {
                $insertdata['mem_birthday'] = $this->input->post('mem_birthday', null, '');
            }
            if ($selfcert_sex) {
                $insertdata['mem_sex'] = $selfcert_sex;
            } else if (isset($form['mem_sex']['use']) && $form['mem_sex']['use']) {
                $insertdata['mem_sex'] = $this->input->post('mem_sex', null, '');
            }
            if (isset($form['mem_address']['use']) && $form['mem_address']['use']) {
                $insertdata['mem_zipcode'] = $this->input->post('mem_zipcode', null, '');
                $insertdata['mem_address1'] = $this->input->post('mem_address1', null, '');
                $insertdata['mem_address2'] = $this->input->post('mem_address2', null, '');
                $insertdata['mem_address3'] = $this->input->post('mem_address3', null, '');
                $insertdata['mem_address4'] = $this->input->post('mem_address4', null, '');
            }
            $insertdata['mem_receive_email'] = $this->input->post('mem_receive_email') ? 1 : 0;
            if ($this->cbconfig->item('use_note')) {
                $insertdata['mem_use_note'] = $this->input->post('mem_use_note') ? 1 : 0;
                $metadata['meta_use_note_datetime'] = cdate('Y-m-d H:i:s');
            }
            $insertdata['mem_receive_sms'] = $this->input->post('mem_receive_sms') ? 1 : 0;
            $insertdata['mem_open_profile'] = $this->input->post('mem_open_profile') ? 1 : 0;
            $metadata['meta_open_profile_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_datetime'] = cdate('Y-m-d H:i:s');
            $insertdata['mem_register_ip'] = $this->input->ip_address();
            $metadata['meta_change_pw_datetime'] = cdate('Y-m-d H:i:s');
            if (isset($form['mem_profile_content']['use']) && $form['mem_profile_content']['use']) {
                $insertdata['mem_profile_content'] = $this->input->post('mem_profile_content', null, '');
            }

            if ($this->cbconfig->item('use_register_email_auth')) {
                $insertdata['mem_email_cert'] = 0;
                $metadata['meta_email_cert_datetime'] = '';
            } else {
                $insertdata['mem_email_cert'] = 1;
                $metadata['meta_email_cert_datetime'] = cdate('Y-m-d H:i:s');
            }

            if ($updatephoto) {
                $insertdata['mem_photo'] = $updatephoto;
            }
            if ($updateicon) {
                $insertdata['mem_icon'] = $updateicon;
            }

            $mem_id = $this->Member_model->insert($insertdata);

            if ($selfcert_meta) {
                foreach ($selfcert_meta as $certkey => $certvalue) {
                    $metadata[$certkey] = $certvalue;
                }

                $selfcertupdatedata = array(
                    'mem_id' => $mem_id
                );
                $selfcertwhere = array(
                    'msh_cert_key' => $selfcert_key,
                );

                $this->load->model('Member_selfcert_history_model');
                $this->Member_selfcert_history_model->update('', $selfcertupdatedata, $selfcertwhere);
            }

            $this->Member_meta_model->save($mem_id, $metadata);

            $extradata = array();
            if ($form && is_array($form)) {
                $this->load->model('Member_extra_vars_model');
                foreach ($form as $key => $value) {
                    if (!element('use', $value)) {
                        continue;
                    }
                    if (element('func', $value) === 'basic') {
                        continue;
                    }
                    $extradata[element('field_name', $value)] = $this->input->post(element('field_name', $value), null, '');
                }
                $this->Member_extra_vars_model->save($mem_id, $extradata);
            }

            $levelhistoryinsert = array(
                'mem_id' => $mem_id,
                'mlh_from' => 0,
                'mlh_to' => $mem_level,
                'mlh_datetime' => cdate('Y-m-d H:i:s'),
                'mlh_reason' => '회원가입',
                'mlh_ip' => $this->input->ip_address(),
            );
            $this->load->model('Member_level_history_model');
            $this->Member_level_history_model->insert($levelhistoryinsert);

            $this->load->model('Member_group_model');
            $allgroup = $this->Member_group_model->get_all_group();
            if ($allgroup && is_array($allgroup)) {
                $this->load->model('Member_group_member_model');
                foreach ($allgroup as $gkey => $gval) {
                    if (element('mgr_is_default', $gval)) {
                        $gminsert = array(
                            //'mgr_id' => element('mgr_id', $gval),
                            // 뮤지션은 2번 그룹으로 가입됨
                            'mgr_id' => 2,
                            'mem_id' => $mem_id,
                            'mgm_datetime' => cdate('Y-m-d H:i:s'),
                        );
                        $this->Member_group_member_model->insert($gminsert);
                    }
                }
            }

            $this->point->insert_point(
                $mem_id,
                $this->cbconfig->item('point_register'),
                '회원가입을 축하합니다',
                'member',
                $mem_id,
                '회원가입'
            );

            $searchconfig = array(
                '{홈페이지명}',
                '{회사명}',
                '{홈페이지주소}',
                '{회원아이디}',
                '{회원닉네임}',
                '{회원실명}',
                '{회원이메일}',
                '{메일수신여부}',
                '{쪽지수신여부}',
                '{문자수신여부}',
                '{회원아이피}',
            );
            $mem_userid = $this->input->post('mem_userid', null, '');
            $mem_nickname = $this->input->post('mem_nickname', null, '');
            $mem_username = $selfcert_username ? $selfcert_username : $this->input->post('mem_username', null, '');
            $mem_email = $this->input->post('mem_email', null, '');
            $receive_email = $this->input->post('mem_receive_email') ? '동의' : '거부';
            $receive_note = $this->input->post('mem_use_note') ? '동의' : '거부';
            $receive_sms = $this->input->post('mem_receive_sms') ? '동의' : '거부';
            $replaceconfig = array(
                $this->cbconfig->item('site_title'),
                $this->cbconfig->item('company_name'),
                site_url(),
                $mem_userid,
                $mem_nickname,
                $mem_username,
                $mem_email,
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );
            $replaceconfig_escape = array(
                html_escape($this->cbconfig->item('site_title')),
                html_escape($this->cbconfig->item('company_name')),
                site_url(),
                html_escape($mem_userid),
                html_escape($mem_nickname),
                html_escape($mem_username),
                html_escape($mem_email),
                $receive_email,
                $receive_note,
                $receive_sms,
                $this->input->ip_address(),
            );

            if (!$this->cbconfig->item('use_register_email_auth')) {
                if (($this->cbconfig->item('send_email_register_user') && $this->input->post('mem_receive_email'))
                    or $this->cbconfig->item('send_email_register_alluser')) {
                    $title = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_email_register_user_title')
                    );
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig_escape,
                        $this->cbconfig->item('send_email_register_user_content')
                    );
                    /*
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to($this->input->post('mem_email'));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                    */

                    // PHPMailer object
                    $mail = $this->phpmailer_lib->load();
                    $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $mail->addReplyTo();
                    $mail->addAddress($this->input->post('mem_email'));
                    $mail->Subject = $title;
                    $mail->isHTML(true);
                    $mail->Body = $content;
                    $mail->send();
                }
            } else {
                $vericode = array('$', '/', '.');
                $verificationcode = str_replace(
                    $vericode,
                    '',
                    password_hash($mem_id . '-' . $this->input->post('mem_email') . '-' . random_string('alnum', 10), PASSWORD_BCRYPT)
                );

                $beforeauthdata = array(
                    'mem_id' => $mem_id,
                    'mae_type' => 1,
                );
                $this->Member_auth_email_model->delete_where($beforeauthdata);
                $authdata = array(
                    'mem_id' => $mem_id,
                    'mae_key' => $verificationcode,
                    'mae_type' => 1,
                    'mae_generate_datetime' => cdate('Y-m-d H:i:s'),
                );
                $this->Member_auth_email_model->insert($authdata);

                $verify_url = site_url('verify/confirmemail?user=' . $this->input->post('mem_userid') . '&code=' . $verificationcode);

                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_user_verifytitle')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_user_verifycontent')
                );

                $title = str_replace('{메일인증주소}', $verify_url, $title);
                $content = str_replace('{메일인증주소}', $verify_url, $content);
                /*
                $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                $this->email->to($this->input->post('mem_email'));
                $this->email->subject($title);
                $this->email->message($content);
                $this->email->send();
                */

                // PHPMailer object
                $mail = $this->phpmailer_lib->load();
                $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                $mail->addReplyTo();
                $mail->addAddress($this->input->post('mem_email'));
                $mail->Subject = $title;
                $mail->isHTML(true);
                $mail->Body = $content;
                $mail->send();

                $email_auth_message = $this->input->post('mem_email') . '로 인증메일이 발송되었습니다. <br />발송된 인증메일을 확인하신 후에 사이트 이용이 가능합니다';
                $this->session->set_flashdata(
                    'email_auth_message',
                    $email_auth_message
                );
            }

            $emailsendlistadmin = array();
            $notesendlistadmin = array();
            $smssendlistadmin = array();
            $notesendlistuser = array();
            $smssendlistuser = array();

            $superadminlist = '';
            if ($this->cbconfig->item('send_email_register_admin')
                or $this->cbconfig->item('send_note_register_admin')
                or $this->cbconfig->item('send_sms_register_admin')) {
                $mselect = 'mem_id, mem_email, mem_nickname, mem_phone';
                $superadminlist = $this->Member_model->get_superadmin_list($mselect);
            }

            if ($this->cbconfig->item('send_email_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $emailsendlistadmin[$value['mem_id']] = $value;
                }
            }
            if ($this->cbconfig->item('send_note_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $notesendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_note_register_user') && $this->input->post('mem_use_note'))) {
                $notesendlistuser['mem_id'] = $mem_id;
            }
            if ($this->cbconfig->item('send_sms_register_admin') && $superadminlist) {
                foreach ($superadminlist as $key => $value) {
                    $smssendlistadmin[$value['mem_id']] = $value;
                }
            }
            if (($this->cbconfig->item('send_sms_register_user') && $this->input->post('mem_receive_sms'))
                or $this->cbconfig->item('send_sms_register_alluser')) {
                if ($selfcert_phone or $this->input->post('mem_phone')) {
                    $smssendlistuser['mem_id'] = $mem_id;
                    $smssendlistuser['mem_nickname'] = $this->input->post('mem_nickname');
                    $smssendlistuser['mem_phone'] = $selfcert_phone ? $selfcert_phone : $this->input->post('mem_phone');
                }
            }

            if ($emailsendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_email_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_email_register_admin_content')
                );
                foreach ($emailsendlistadmin as $akey => $aval) {
                    /*
                    $this->email->clear(true);
                    $this->email->from($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $this->email->to(element('mem_email', $aval));
                    $this->email->subject($title);
                    $this->email->message($content);
                    $this->email->send();
                    */

                    // PHPMailer object
                    $mail = $this->phpmailer_lib->load();
                    $mail->setFrom($this->cbconfig->item('webmaster_email'), $this->cbconfig->item('webmaster_name'));
                    $mail->addReplyTo();
                    $mail->addAddress(element('mem_email', $aval));
                    $mail->Subject = $title;
                    $mail->isHTML(true);
                    $mail->Body = $content;
                    $mail->send();
                }
            }
            if ($notesendlistadmin) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_admin_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_admin_content')
                );
                foreach ($notesendlistadmin as $akey => $aval) {
                    $note_result = $this->notelib->send_note(
                        $sender = 0,
                        $receiver = element('mem_id', $aval),
                        $title,
                        $content,
                        1
                    );
                }
            }
            if ($notesendlistuser && element('mem_id', $notesendlistuser)) {
                $title = str_replace(
                    $searchconfig,
                    $replaceconfig,
                    $this->cbconfig->item('send_note_register_user_title')
                );
                $content = str_replace(
                    $searchconfig,
                    $replaceconfig_escape,
                    $this->cbconfig->item('send_note_register_user_content')
                );
                $note_result = $this->notelib->send_note(
                    $sender = 0,
                    $receiver = element('mem_id', $notesendlistuser),
                    $title,
                    $content,
                    1
                );
            }
            if ($smssendlistadmin) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_admin_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    foreach ($smssendlistadmin as $akey => $aval) {
                        $receiver[] = array(
                            'mem_id' => element('mem_id', $aval),
                            'name' => element('mem_nickname', $aval),
                            'phone' => element('mem_phone', $aval),
                        );
                    }
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }
            if ($smssendlistuser) {
                if (file_exists(APPPATH . 'libraries/Smslib.php')) {
                    $this->load->library(array('smslib'));
                    $content = str_replace(
                        $searchconfig,
                        $replaceconfig,
                        $this->cbconfig->item('send_sms_register_user_content')
                    );
                    $sender = array(
                        'phone' => $this->cbconfig->item('sms_admin_phone'),
                    );
                    $receiver = array();
                    $receiver[] = $smssendlistuser;
                    $smsresult = $this->smslib->send($receiver, $sender, $content, $date = '', '회원가입알림');
                }
            }

            $member_register_data = array(
                'mem_id' => $mem_id,
                'mrg_ip' => $this->input->ip_address(),
                'mrg_datetime' => cdate('Y-m-d H:i:s'),
                'mrg_useragent' => $this->agent->agent_string(),
                'mrg_referer' => $this->session->userdata('site_referer'),
            );
            $recommended = '';
            if ($this->input->post('mem_recommend')) {
                $recommended = $this->Member_model->get_by_userid($this->input->post('mem_recommend'), 'mem_id');
                if (element('mem_id', $recommended)) {
                    $member_register_data['mrg_recommend_mem_id'] = element('mem_id', $recommended);
                } else {
                    $recommended['mem_id'] = 0;
                }
            }
            $this->load->model('Member_register_model');
            $this->Member_register_model->insert($member_register_data);

            if ($this->input->post('mem_recommend')) {
                if ($this->cbconfig->item('point_recommended')) {
                    // 추천인이 존재할 경우 추천된 사람
                    $this->point->insert_point(
                        element('mem_id', $recommended),
                        $this->cbconfig->item('point_recommended'),
                        $this->input->post('mem_nickname') . ' 님이 회원가입시 추천함',
                        'member_recommended',
                        $mem_id,
                        '회원가입추천'
                    );
                }
                if ($this->cbconfig->item('point_recommender')) {
                    // 추천인이 존재할 경우 가입자에게
                    $this->point->insert_point(
                        $mem_id,
                        $this->cbconfig->item('point_recommender'),
                        '회원가입 추천인존재',
                        'member_recommender',
                        $mem_id,
                        '회원가입추천인존재'
                    );
                }
            }

            $this->session->set_flashdata(
                'nickname',
                $this->input->post('mem_nickname')
            );

//            if ( ! $this->cbconfig->item('use_register_email_auth')) {
//                $this->session->set_userdata(
//                    'mem_id',
//                    $mem_id
//                );
//            }
            $this->session->unset_userdata('selfcertinfo');

            redirect('register/result_musician');
        }
    }

    /**
     * 회원가입 결과 페이지입니다
     */
    public function result_user()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_result';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $this->session->keep_flashdata('nickname');
        $this->session->keep_flashdata('email_auth_message');

        if (!$this->session->flashdata('nickname')) {
            redirect();
        }

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_register_result');
        $meta_description = $this->cbconfig->item('site_meta_description_register_result');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_result');
        $meta_author = $this->cbconfig->item('site_meta_author_register_result');
        $page_name = $this->cbconfig->item('site_page_name_register_result');

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'register_result_user',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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
     * 회원가입 결과 페이지입니다
     */
    public function result_musician()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_result';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

//        $this->session->keep_flashdata('nickname');
//        $this->session->keep_flashdata('email_auth_message');

//        if ( ! $this->session->flashdata('nickname')) {
//            redirect();
//        }

        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_register_result');
        $meta_description = $this->cbconfig->item('site_meta_description_register_result');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_register_result');
        $meta_author = $this->cbconfig->item('site_meta_author_register_result');
        $page_name = $this->cbconfig->item('site_page_name_register_result');

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'register_result_musician',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

    public function purchase()
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

        $this->load->model('Member_group_model');

        $item = $this->Member_group_model->item($this->input->get('mgr_id'));
        $view['view']['selectedGroup'] = $item;


        // 이벤트가 존재하면 실행합니다
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);


        /**
         * 레이아웃을 정의합니다
         */
        $page_title = $this->cbconfig->item('site_meta_title_register');
        $meta_description = $this->cbconfig->item('site_meta_description_register');
        $meta_keywords = $this->cbconfig->item('site_meta_keywords_register');
        $meta_author = $this->cbconfig->item('site_meta_author_register');
        $page_name = $this->cbconfig->item('site_page_name_register');

        $layoutconfig = array(
            'path' => 'register',
            'layout' => 'layout',
            'skin' => 'purchase',
            'layout_dir' => $this->cbconfig->item('layout_register'),
            'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_register'),
            'use_sidebar' => $this->cbconfig->item('sidebar_register'),
            'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_register'),
            'skin_dir' => $this->cbconfig->item('skin_register'),
            'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_register'),
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

    public function ajax_purchase()
    {
        $this->output->set_content_type('text/json');

        required_user_login();

        $mem_id = $this->member->item('mem_id');

        $this->load->model(array('Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model'));

        $member_group = $this->Member_group_model->item($this->input->post('mgr_id'));
        if ($member_group['mgr_title'] == 'buyer' || $member_group['mgr_title'] == 'seller_free') {
            $deletewhere = array(
                'mem_id' => $mem_id,
            );
            $this->Member_group_member_model->delete_where($deletewhere);
            $mginsert = array(
                'mgr_id' => $member_group['mgr_id'],
                'mem_id' => $mem_id,
                'mgm_datetime' => cdate('Y-m-d H:i:s'),
            );
            $this->Member_group_member_model->insert($mginsert);
        }  else {
            $billTerm = $this->input->post('bill_term');
            if ($billTerm === 'monthly') {
                $amount = (int)$member_group['mgr_monthly_cost_w'];
                $amount_d = (float)$member_group['mgr_monthly_cost_d'];
                $termDays = '30';
            } else {
                $amount = (int)$member_group['mgr_year_cost_w'];
                $amount_d = (float)$member_group['mgr_year_cost_d'];
                $termDays = '365';
            }

            $pg = $this->input->post('pg');

            if ($this->input->post('pg') === 'allat') {        //올앳
                include(FCPATH . 'plugin/pg/allat/allatutil.php');
                $at_cross_key = $this->cbconfig->item('pg_allat_crosskey');    //설정필요 [사이트 참조 - http://www.allatpay.com/servlet/AllatBiz/support/sp_install_guide_scriptapi.jsp#shop]
                $at_shop_id = $this->cbconfig->item('pg_allat_shop_id');        //설정필요

                // 요청 데이터 설정
                //----------------------
                $at_data = "allat_shop_id=" . $at_shop_id .
                    "&allat_amt=" . $amount .
                    "&allat_enc_data=" . $_POST["allat_enc_data"] .
                    "&allat_cross_key=" . $at_cross_key;
                // 올앳 결제 서버와 통신 : ApprovalReq->통신함수, $at_txt->결과값
                //----------------------------------------------------------------
                // PHP5 이상만 SSL 사용가능
                $at_txt = ApprovalReq($at_data, "SSL");
                // $at_txt = ApprovalReq($at_data, "NOSSL"); // PHP5 이하버전일 경우
                // 이 부분에서 로그를 남기는 것이 좋습니다.
                // (올앳 결제 서버와 통신 후에 로그를 남기면, 통신에러시 빠른 원인파악이 가능합니다.)
                log_message('info', 'Allat: ' . $at_txt);

                // 결제 결과 값 확인
                //------------------
                $REPLYCD = getValue("reply_cd", $at_txt);        //결과코드
                $REPLYMSG = getValue("reply_msg", $at_txt);       //결과 메세지

                // 결과값 처리
                //--------------------------------------------------------------------------
                // 결과 값이 '0000'이면 정상임. 단, allat_test_yn=Y 일경우 '0001'이 정상임.
                // 실제 결제   : allat_test_yn=N 일 경우 reply_cd=0000 이면 정상
                // 테스트 결제 : allat_test_yn=Y 일 경우 reply_cd=0001 이면 정상
                //--------------------------------------------------------------------------
                if (!strcmp($REPLYCD, "0000") || !strcmp($REPLYCD, "0001")) {
                    // reply_cd "0000" 일때만 성공
                    $ORDER_NO = getValue("order_no", $at_txt);
                    $AMT = getValue("amt", $at_txt);
                    $PAY_TYPE = getValue("pay_type", $at_txt);
                    $APPROVAL_YMDHMS = getValue("approval_ymdhms", $at_txt);
                    $SEQ_NO = getValue("seq_no", $at_txt);
                    $APPROVAL_NO = getValue("approval_no", $at_txt);
                    $CARD_ID = getValue("card_id", $at_txt);
                    $CARD_NM = getValue("card_nm", $at_txt);
                    $SELL_MM = getValue("sell_mm", $at_txt);
                    $ZEROFEE_YN = getValue("zerofee_yn", $at_txt);
                    $CERT_YN = getValue("cert_yn", $at_txt);
                    $CONTRACT_YN = getValue("contract_yn", $at_txt);
                    $SAVE_AMT = getValue("save_amt", $at_txt);
                    $CARD_POINTDC_AMT = getValue("card_pointdc_amt", $at_txt);
                    $BANK_ID = getValue("bank_id", $at_txt);
                    $BANK_NM = getValue("bank_nm", $at_txt);
                    $CASH_BILL_NO = getValue("cash_bill_no", $at_txt);
                    $ESCROW_YN = getValue("escrow_yn", $at_txt);
                    $ACCOUNT_NO = getValue("account_no", $at_txt);
                    $ACCOUNT_NM = getValue("account_nm", $at_txt);
                    $INCOME_ACC_NM = getValue("income_account_nm", $at_txt);
                    $INCOME_LIMIT_YMD = getValue("income_limit_ymd", $at_txt);
                    $INCOME_EXPECT_YMD = getValue("income_expect_ymd", $at_txt);
                    $CASH_YN = getValue("cash_yn", $at_txt);
                    $HP_ID = getValue("hp_id", $at_txt);
                    $TICKET_ID = getValue("ticket_id", $at_txt);
                    $TICKET_PAY_TYPE = getValue("ticket_pay_type", $at_txt);
                    $TICKET_NAME = getValue("ticket_nm", $at_txt);
                    $PARTCANCEL_YN = getValue("partcancel_yn", $at_txt);

                    $params = array();
                    $params['REPLYCD'] = $REPLYCD;
                    $params['REPLYMSG'] = $REPLYMSG;
                    $params['ORDER_NO'] = $ORDER_NO;
                    $params['AMT'] = $AMT;
                    $params['PAY_TYPE'] = $PAY_TYPE;
                    $params['APPROVAL_YMDHMS'] = $APPROVAL_YMDHMS;
                    $params['SEQ_NO'] = $SEQ_NO;
                    $params['APPROVAL_NO'] = $APPROVAL_NO;
                    $params['CARD_ID'] = $CARD_ID;
                    $params['CARD_NM'] = $CARD_NM;
                    $params['SELL_MM'] = $SELL_MM;
                    $params['ZEROFEE_YN'] = $ZEROFEE_YN;
                    $params['CERT_YN'] = $CERT_YN;
                    $params['CONTRACT_YN'] = $CONTRACT_YN;
                    $params['SAVE_AMT'] = $SAVE_AMT;
                    $params['CARD_POINTDC_AMT'] = $CARD_POINTDC_AMT;
                    $params['BANK_ID'] = $BANK_ID;
                    $params['BANK_NM'] = $BANK_NM;
                    $params['CASH_BILL_NO'] = $CASH_BILL_NO;
                    $params['ESCROW_YN'] = $ESCROW_YN;
                    $params['ACCOUNT_NO'] = $ACCOUNT_NO;
                    $params['ACCOUNT_NM'] = $ACCOUNT_NM;
                    $params['INCOME_ACC_NM'] = $INCOME_ACC_NM;
                    $params['INCOME_LIMIT_YMD'] = $INCOME_LIMIT_YMD;
                    $params['INCOME_EXPECT_YMD'] = $INCOME_EXPECT_YMD;
                    $params['CASH_YN'] = $CASH_YN;
                    $params['HP_ID'] = $HP_ID;
                    $params['TICKET_ID'] = $TICKET_ID;
                    $params['TICKET_PAY_TYPE'] = $TICKET_PAY_TYPE;
                    $params['TICKET_NAME'] = $TICKET_NAME;
                    $params['PARTCANCEL_YN'] = $PARTCANCEL_YN;
                    $params['RAW_DATA'] = $at_txt;

                    $this->Cmall_order_model->allat_log_insert($params);

                    if ((int)$AMT == $amount) {
                        $deletewhere = array(
                            'mem_id' => $mem_id,
                        );
                        $this->Member_group_member_model->delete_where($deletewhere);
                        $mginsert = array(
                            'mgr_id' => $member_group['mgr_id'],
                            'mem_id' => $mem_id,
                            'mgm_datetime' => cdate('Y-m-d H:i:s'),
                        );
                        $this->Member_group_member_model->insert($mginsert);

                        $startDate = date('Y-m-d');
                        $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));

                        $params = [
                            'mem_id' => $mem_id,
                            'bill_term' => $billTerm,
                            'plan' => $member_group['mgr_description'],
                            'plan_name' => $member_group['mgr_title'],
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'pay_method' => $pg,
                            'amount' => $amount
                        ];
                        $this->Beatsomeone_model->insert_membership_purchase_log($params);

                        $this->session->set_userdata(
                            'mem_id',
                            $mem_id
                        );
                    }

                } else {
                    $this->output->set_status_header('400');
                    $this->output->set_output(json_encode([
                        'reply_cd' => $REPLYCD,
                        'reply_msg' => $REPLYMSG
                    ], JSON_UNESCAPED_UNICODE));
                    return false;
                }

            } elseif ($this->input->post('pg') === 'paypal') {
                $paypalData = $_POST["paypal_data"];

                if (empty($paypalData)) {
                    $this->output->set_status_header('400');
                    return false;
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
                $params['currency'] = $paypalData['transactions'][0]['amount']['currency'];
                $params['links'] = $paypalData['links']['href'];

                $this->Cmall_order_model->paypal_log_insert($params);

                if ((float)$paypalData['transactions'][0]['amount']['total'] == $amount_d) {
                    $deletewhere = array(
                        'mem_id' => $mem_id,
                    );

                    // 현재 이미 있는 그룹을 다지우는데 ....

                    $this->Member_group_member_model->delete_where($deletewhere);
                    $mginsert = array(
                        'mgr_id' => $member_group['mgr_id'],
                        'mem_id' => $mem_id,
                        'mgm_datetime' => cdate('Y-m-d H:i:s'),
                    );
                    $this->Member_group_member_model->insert($mginsert);

                    $startDate = date('Y-m-d');
                    $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));

                    $params = [
                        'mem_id' => $mem_id,
                        'bill_term' => $billTerm,
                        'plan' => $member_group['mgr_description'],
                        'plan_name' => $member_group['mgr_title'],
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'pay_method' => $pg,
                        'amount' => $amount_d
                    ];
                    $this->Beatsomeone_model->insert_membership_purchase_log($params);
                }

            } else {
                $this->output->set_status_header('400');
                $this->output->set_output(json_encode([
                    'message' => '결제 수단이 잘못 입력되었습니다'
                ], JSON_UNESCAPED_UNICODE));
                return false;
            }
        }

        if ($billTerm == 'yearly' && $member_group['mgr_title'] == 'seller_master') {
            $message = lang('lang142');
        } else {
            $message = lang('lang48');
        }

        $this->output->set_output(json_encode([
            'message' => $message,
        ]));
        return true;
    }

    public function ajax_repurchase()
    {
        $this->output->set_content_type('text/json');

        required_user_login();

        $mem_id = $this->member->item('mem_id');

        $this->load->model(array('Member_group_model', 'Cmall_order_model', 'Member_group_member_model', 'Beatsomeone_model'));

        $member_group = $this->Member_group_model->item($this->input->post('mgr_id'));
        $amount = (int)$member_group['mgr_monthly_cost_w'];
        $amount_d = (float)$member_group['mgr_monthly_cost_d'];
        $termDays = '30';

        $paypalData = $_POST["paypal_data"];

        if (empty($paypalData)) {
            $this->output->set_status_header('400');
            return false;
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
        $params['currency'] = $paypalData['transactions'][0]['amount']['currency'];
        $params['links'] = $paypalData['links']['href'];

        $this->Cmall_order_model->paypal_log_insert($params);

        if ((float)$paypalData['transactions'][0]['amount']['total'] == $amount_d) {
            $startDate = date('Y-m-d');
            $endDate = date("Y-m-d", strtotime($startDate . '+ ' . $termDays . ' days'));
            $params = [
                'mem_id' => $mem_id,
                'bill_term' => $billTerm,
                'plan' => $member_group['mgr_description'],
                'plan_name' => $member_group['mgr_title'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'pay_method' => $pg,
                'amount' => $amount_d
            ];
            $this->Beatsomeone_model->insert_membership_purchase_log($params);
        }

        $this->output->set_output(json_encode([
            'message' => lang('lang48'),
        ]));
        return true;
    }

    public function ajax_userid_check()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_ajax_userid_check';
        $this->load->event($eventname);

        $result = array();
        $this->output->set_content_type('application/json');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $userid = trim($this->input->post('userid'));
        if (empty($userid)) {
            $result = array(
                'result' => 'no',
                'reason' => '아이디값이 넘어오지 않았습니다',
            );
            exit(json_encode($result));
        }

        if (!preg_match("/^([a-z0-9_])+$/i", $userid)) {
            $result = array(
                'result' => 'no',
                'reason' => lang('lang103'),
            );
            exit(json_encode($result));
        }

        $where = array(
            'mem_userid' => $userid,
        );
        $count = $this->Member_model->count_by($where);
        if ($count > 0) {
            $result = array(
                'result' => 'no',
                'reason' => lang('usernameAlreadyUse'),
            );
            exit(json_encode($result));
        }

        if ($this->_mem_userid_check($userid) === false) {
            $result = array(
                'result' => 'no',
//				'reason' => $userid . '은(는) 예약어로 사용하실 수 없는 회원아이디입니다',
                'reason' => lang('usernameAlreadyUse'),
            );
            exit(json_encode($result));
        }

        // 이벤트가 존재하면 실행합니다
        Events::trigger('after', $eventname);

        $result = array(
            'result' => 'available',
            'reason' => '사용 가능한 아이디입니다',
        );
        exit(json_encode($result));
    }


    public function ajax_email_check()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_ajax_email_check';
        $this->load->event($eventname);

        $result = array();
        $this->output->set_content_type('application/json');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $email = trim($this->input->post('email'));
        if (empty($email)) {
            $result = array(
                'result' => 'no',
                'reason' => '이메일값이 넘어오지 않았습니다',
            );
            exit(json_encode($result));
        }

        if ($this->member->item('mem_email')
            && $this->member->item('mem_email') === $email) {
            $result = array(
                'result' => 'available',
                'reason' => '사용 가능한 이메일입니다',
            );
            exit(json_encode($result));
        }

        $where = array(
            'mem_email' => $email,
        );
        $count = $this->Member_model->count_by($where);
        if ($count > 0) {
            $result = array(
                'result' => 'no',
                'reason' => lang('lang105'),
            );
            exit(json_encode($result));
        }

        if ($this->_mem_email_check($email) === false) {
            $result = array(
                'result' => 'no',
                'reason' => lang('lang105'),
            );
            exit(json_encode($result));
        }

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $result = array(
            'result' => 'available',
            'reason' => '사용 가능한 이메일입니다',
        );
        exit(json_encode($result));
    }


    public function ajax_password_check()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_ajax_password_check';
        $this->load->event($eventname);

        $result = array();
        $this->output->set_content_type('application/json');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $password = trim($this->input->post('password'));
        if (empty($password)) {
            $result = array(
                'result' => 'no',
                'reason' => '패스워드값이 넘어오지 않았습니다',
            );
            exit(json_encode($result));
        }

        if ($this->_mem_password_check($password) === false) {
            $result = array(
                'result' => 'no',
                'reason' => '패스워드는 최소 1개 이상의 숫자를 포함해야 합니다',
            );
            exit(json_encode($result));
        }

        $result = array(
            'result' => 'available',
            'reason' => '사용 가능한 패스워드입니다',
        );
        exit(json_encode($result));
    }


    public function ajax_nickname_check()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_ajax_nickname_check';
        $this->load->event($eventname);

        $result = array();
        $this->output->set_content_type('application/json');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $nickname = trim($this->input->post('nickname'));
        if (empty($nickname)) {
            $result = array(
                'result' => 'no',
                'reason' => '닉네임값이 넘어오지 않았습니다',
            );
            exit(json_encode($result));
        }

        if ($this->member->item('mem_nickname')
            && $this->member->item('mem_nickname') === $nickname) {
            $result = array(
                'result' => 'available',
                'reason' => '사용 가능한 닉네임입니다',
            );
            exit(json_encode($result));
        }

        $where = array(
            'mem_nickname' => $nickname,
        );
        $count = $this->Member_model->count_by($where);
        if ($count > 0) {
            $result = array(
                'result' => 'no',
                'reason' => '이미 사용중인 닉네임입니다',
            );
            exit(json_encode($result));
        }

        if ($this->_mem_nickname_check($nickname) === false) {
            $result = array(
                'result' => 'no',
                'reason' => '이미 사용중인 닉네임입니다',
            );
            exit(json_encode($result));
        }

        $result = array(
            'result' => 'available',
            'reason' => '사용 가능한 닉네임입니다',
        );
        exit(json_encode($result));
    }


    public function ajax_promocode_check()
    {
        // 이벤트 라이브러리를 로딩합니다
        $eventname = 'event_register_ajax_promocode_check';
        $this->load->event($eventname);

        $result = array();
        $this->output->set_content_type('application/json');

        // 이벤트가 존재하면 실행합니다
        Events::trigger('before', $eventname);

        $code = trim($this->input->post('code'));
        if (empty($code)) {
            $result = array(
                'result' => 'no',
                'reason' => '쿠폰 번호를 입력해주세요',
            );
            exit(json_encode($result));
        }

        $rst = $this->Promo_model->get_code($this->input->post('code'));
        if ($rst && is_array($rst)) {

            if ($rst['useyn'] == 'n') {
                $result = array(
                    'result' => 'available',
                    'reason' => '사용 가능한 쿠폰입니다',
                    'data' => $rst,
                );
                exit(json_encode($result));
            } else {
                $result = array(
                    'result' => 'no',
                    'reason' => '사용이 불가능한 쿠폰입니다',
                );
                exit(json_encode($result));
            }

        } else {
            $result = array(
                'result' => 'no',
                'reason' => '사용 가능한 쿠폰이 아닙니다.',
            );
            exit(json_encode($result));
        }

    }


    /**
     * 회원가입시 회원아이디를 체크하는 함수입니다
     */
    public function _mem_userid_check($str)
    {
        if (preg_match("/[\,]?{$str}/i", $this->cbconfig->item('denied_userid_list'))) {
            $this->form_validation->set_message(
                '_mem_userid_check',
                $str . ' 은(는) 예약어로 사용하실 수 없는 회원아이디입니다'
            );
            return false;
        }

        return true;
    }


    /**
     * 회원가입시 닉네임을 체크하는 함수입니다
     */
    public function _mem_nickname_check($str)
    {
//        $this->load->helper('chkstring');
//        if (chkstring($str, _HANGUL_ + _ALPHABETIC_ + _NUMERIC_) === false) {
//            $this->form_validation->set_message(
//                '_mem_nickname_check',
//                '닉네임은 공백없이 한글, 영문, 숫자만 입력 가능합니다'
//            );
//            return false;
//        }

        if (preg_match("/[\,]?{$str}/i", $this->cbconfig->item('denied_nickname_list'))) {
            $this->form_validation->set_message(
                '_mem_nickname_check',
                $str . ' 은(는) 예약어로 사용하실 수 없는 닉네임입니다'
            );
            return false;
        }
        $countwhere = array(
            'mem_nickname' => $str,
        );
        $row = $this->Member_model->count_by($countwhere);

        if ($row > 0) {
            $this->form_validation->set_message(
                '_mem_nickname_check',
                $str . ' 는 이미 다른 회원이 사용하고 있는 닉네임입니다'
            );
            return false;
        }

        return true;
    }


    /**
     * 회원가입시 이메일을 체크하는 함수입니다
     */
    public function _mem_email_check($str)
    {
        list($emailid, $emaildomain) = explode('@', $str);
        $denied_list = explode(',', $this->cbconfig->item('denied_email_list'));
        $emaildomain = trim($emaildomain);
        $denied_list = array_map('trim', $denied_list);
        if (in_array($emaildomain, $denied_list)) {
            $this->form_validation->set_message(
                '_mem_email_check',
                $emaildomain . ' 은(는) 사용하실 수 없는 이메일입니다'
            );
            return false;
        }

        return true;
    }


    /**
     * 회원가입시 추천인을 체크하는 함수입니다
     */
    public function _mem_recommend_check($str)
    {
        if (!$str) {
            return true;
        }

        $countwhere = array(
            'mem_userid' => $str,
            'mem_denied' => 0,
        );
        $row = $this->Member_model->count_by($countwhere);

        if ($row === 0) {
            $this->form_validation->set_message(
                '_mem_recommend_check',
                $str . ' 는 존재하지 않는 추천인 회원아이디입니다'
            );
            return false;
        }

        return true;
    }


    /**
     * 회원가입시 captcha 체크하는 함수입니다
     */
    public function _check_captcha($str)
    {
        $captcha = $this->session->userdata('captcha');
        if (!is_array($captcha) or !element('word', $captcha) or strtolower(element('word', $captcha)) !== strtolower($str)) {
            $this->session->unset_userdata('captcha');
            $this->form_validation->set_message(
                '_check_captcha',
                '자동등록방지코드가 잘못되었습니다'
            );
            return false;
        }
        return true;
    }


    /**
     * 회원가입시 recaptcha 체크하는 함수입니다
     */
    public function _check_recaptcha($str)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $this->cbconfig->item('recaptcha_secret'),
            'response' => $str,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, sizeof($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);

        if ((string)$obj->success !== '1') {
            $this->form_validation->set_message(
                '_check_recaptcha',
                '자동등록방지코드가 잘못되었습니다'
            );
            return false;
        }

        return true;
    }


    /**
     * 회원가입시 패스워드가 올바른 규약에 의해 입력되었는지를 체크하는 함수입니다
     */
    public function _mem_password_check($str)
    {
        $uppercase = $this->cbconfig->item('password_uppercase_length');
        $number = $this->cbconfig->item('password_numbers_length');
        $specialchar = $this->cbconfig->item('password_specialchars_length');

        $this->load->helper('chkstring');
        $str_uc = count_uppercase($str);
        $str_num = count_numbers($str);
        $str_spc = count_specialchars($str);

        if ($str_uc < $uppercase or $str_num < $number or $str_spc < $specialchar) {

            $description = '비밀번호는 ';
            if ($str_uc < $uppercase) {
                $description .= ' ' . $uppercase . '개 이상의 대문자';
            }
            if ($str_num < $number) {
                $description .= ' ' . $number . '개 이상의 숫자';
            }
            if ($str_spc < $specialchar) {
                $description .= ' ' . $specialchar . '개 이상의 특수문자';
            }
            $description .= '를 포함해야 합니다';

            $this->form_validation->set_message(
                '_mem_password_check',
                $description
            );
            return false;

        }

        return true;
    }
}
