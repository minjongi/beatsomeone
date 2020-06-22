<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Allat class
 *
 * Copyright (c)
 *
 * @author
 */
class Allat extends CB_Controller
{
    /**
     * 모델을 로딩합니다
     */
    protected $models = array();

    /**
     * 헬퍼를 로딩합니다
     */
    protected $helpers = array('form', 'array', 'cmall');

    function __construct()
    {
        parent::__construct();

        /**
         * 라이브러리를 로딩합니다
         */
        $this->load->library(array('querystring', 'email'));
    }

    public function proc()
    {
        if (empty($_POST["allat_enc_data"])) {
            ?>
            <script>
                self.close();
            </script>
            <?php
            exit;
        }

        ?>
        <script>
            if(!!opener) {
                opener.result_submit('0000', '', '<?= $_POST["allat_enc_data"] ?>');
                self.close();
            } else {
                parent.result_submit('0000', '', '<?= $_POST["allat_enc_data"] ?>');
            }
        </script>
        <?php
    }
}