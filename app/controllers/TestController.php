<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class TestController extends CI_Controller{
 function test(){
	 $mail_from = 'dev4iidfc@gmail.com';
                    $to = 'of;sajeeb@gmail.com';
                    #send mail
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtp.googlemail.com',
                        #'smtp_host' => 'tls://smtp.googlemail.com',
                        #'smtp_port' => 25,
                        'smtp_port' => 465,
                        // 'smtp_port' => 587,
                        'smtp_user' => 'dev4iidfc@gmail.com',
                        'smtp_pass' => 'vxtahblzvixlbizd',
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8'
                    );
                    $this->load->library('email', $config);
                    $this->email->initialize($config);
                    $this->email->clear(TRUE);
                    $this->email->set_newline("\r\n");
                    if ($mail_from) {
                        $this->email->from($mail_from, 'HR Software Dev Team');
                    }
                    $this->email->to($to);
                    $this->email->subject("TEST MAIL");
                    $message = "Test";
                    $this->email->message($message);

           
                    if ($this->email->send()) {
                        echo 'success';
                    } else {
                        #$CI->log_me($CI->email->print_debugger());
                        // echo 'Mail not sent!';
                        echo $this->email->print_debugger();
						
                    }
 }
}
