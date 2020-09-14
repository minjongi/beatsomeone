<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Board_info extends CB_Controller
{
    protected $helpers = array('form', 'array', 'number');

    /**
     * Board_info constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library(array('accesslevel'));
    }

    public function index($brd_key = '')
    {
        $this->output->set_content_type('text/json');
        if (empty($brd_key)) {
            $this->output->set_status_header('404');
        }

        $board_id = $this->board->item_key('brd_id', $brd_key);
        if (empty($board_id)) {
            $this->output->set_status_header('404');
        }

        $board = $this->board->item_all($board_id);

        $board['is_use_captcha'] = false;

        if( check_use_captcha($this->member, $board) ){
            $board['is_use_captcha'] = true;
        }

        $alertmessage = $this->member->is_member()
            ? '회원님은 글을 작성할 수 있는 권한이 없습니다'
            : '비회원은 글을 작성할 수 있는 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오';

        $check = array(
            'group_id' => element('bgr_id', $board),
            'board_id' => element('brd_id', $board),
        );
        $this->accesslevel->check(
            element('access_write', $board),
            element('access_write_level', $board),
            element('access_write_group', $board),
            $alertmessage,
            $check
        );

        // 본인인증 사용하는 경우 - 시작
        if (element('access_write_selfcert', $board)) {
            $this->load->library(array('selfcertlib'));
            $this->selfcertlib->selfcertcheck('write', element('access_write_selfcert', $board));
        }
        $keys = ['link_num', 'use_upload_file', 'upload_file_num', 'upload_file_max_size', 'upload_file_extension'];
        $board = array_filter($board, function ($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);

        $this->output->set_output(json_encode($board));
    }
}