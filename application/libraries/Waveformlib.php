<?php

defined('BASEPATH') or exit('No direct script access allowed');

use maximal\audio\Waveform;
use wapmorgan\Mp3Info\Mp3Info;

class Waveformlib
{
    private $CI;
    private $filePath;

    /**
     * This is a static class, do not instantiate it
     *
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * 웨이브폼 생성
     */
    public function setFilePath($cit_id = 0)
    {
        $cit_id = (int)$cit_id;
        if (empty($cit_id)) {
            return $this;
        }

        $this->CI->load->model(array('Cmall_item_detail_model'));
        $file = $this->CI->Cmall_item_detail_model->preview_by_cit_id($cit_id);
        if (empty(element('cde_id', $file))) {
            return $this;
        }

        $filePath = config_item('uploads_dir') . '/cmallitemdetail/' . element('cde_filename', $file);
        if (!file_exists($filePath)) {
            return $this;
        }

        $this->filePath = $filePath;

        return $this;
    }

    /**
     * 웨이브폼 생성
     */
    public function getWaveform($width = 200)
    {
        if (empty($this->filePath)) {
            return null;
        }

        $waveform = new Waveform($this->filePath);
        return $waveform->getWaveformData($width);
    }

    /**
     * 웨이브폼 생성
     */
    public function getAudioInfo()
    {
        if (empty($this->filePath)) {
            return null;
        }

        $audio = null;
        try {
            $audio = new Mp3Info($this->filePath);
        } catch(Exception $e) {
            log_message('error', print_r($e, true));
        }

        return $audio;
    }

    /**
     * 웨이브폼 등록
     * @param int $cit_id
     * @param int $width
     */
    public function setWaveform($cit_id = 0, $width = 200, $duration = 0)
    {
        $this->CI->load->model(array('Cmall_item_model'));

        $this->setFilePath($cit_id);

        $waveform = $this->getWaveform($width);
        $waveformData = empty($waveform['lines1']) ? null : json_encode($waveform['lines1']);

        if (empty($duration)) {
            $audio = $this->getAudioInfo();
            $duration = empty($audio->duration) ? 0 : intval($audio->duration);
        }

        $this->CI->Cmall_item_model->update_preview_info($cit_id, $waveformData, $duration);
    }
}
