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
        $result_cd  = $_POST["allat_result_cd"];
        $result_msg = $_POST["allat_result_msg"];
        $enc_data   = $_POST["allat_enc_data"];

        if (empty($_POST["allat_enc_data"])) {
            ?>
            <script>
                self.close();
            </script>
            <?php
            exit;
        }

        echo("<script>");
        echo("if(window.opener != undefined) {");
        echo("	opener.result_submit('".$result_cd."','".$result_msg."','".$enc_data."');");
        echo("	window.close();");
        echo("} else {");
        echo("	parent.result_submit('".$result_cd."','".$result_msg."','".$enc_data."');");
        echo("}");
        echo("</script>");
    }
}