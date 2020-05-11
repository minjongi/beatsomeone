<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib
{

    var $CI;

    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $this->CI =& get_instance();
        $mail = new PHPMailer;

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = $this->CI->config->item('email_smtp_host');
        $mail->SMTPAuth = true;
        $mail->Username = $this->CI->config->item('email_smtp_user');
        $mail->Password = $this->CI->config->item('email_smtp_pass');
        $mail->Port     = $this->CI->config->item('email_smtp_port');
        $mail->SMTPSecure = $this->CI->config->item('email_smtp_crypto');
        $mail->CharSet  = 'utf-8';


        return $mail;
    }
}