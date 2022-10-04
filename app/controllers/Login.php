<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('image_lib');
        
    }

    public function index() {

        $ua = $_SERVER["HTTP_USER_AGENT"];      // Get user-agent of browser
        if (strpos($ua, 'Firefox')) {

            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            // $this->load->view('admin-login', $isUserLoggedIn);
            $this->load->view('login', $isUserLoggedIn);

            // }else{
            //    echo "Only allowed in Chrome browser till Eid Holiday. Your browser does not support ";
            // }
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
            //  redirect('http://www.muslah.com/me');
            echo 'Only allowed in Mozilla Firefox browser. Your browser is Internet explorer';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo 'Only allowed in Mozilla Firefox browser. Your browser is Internet explorer';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {

            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            //$this->load->view('admin-login', $isUserLoggedIn);
            $this->load->view('login', $isUserLoggedIn);

            //  echo 'Only allowed in Mozilla Firefox browser. Your browser is Google Chrome';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo "Only allowed in Mozilla Firefox browser. Your browser is Opera Mini";
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo "Only allowed in Mozilla Firefox browser. Your browser is Opera";
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            //echo "Only allowed in Mozilla Firefox browser. Your browser is Safari";
            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            //$this->load->view('admin-login', $isUserLoggedIn);
            $this->load->view('login', $isUserLoggedIn);
        } else {
            echo "Only allowed in Mozilla Firefox browser. Your browser is " . $ua;
        }
    }

    public function adminLogin() {
		

        $ua = $_SERVER["HTTP_USER_AGENT"];      // Get user-agent of browser
        if (strpos($ua, 'Firefox')) {

            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            $this->load->view('admin-login', $isUserLoggedIn);

            // }else{
            //    echo "Only allowed in Chrome browser till Eid Holiday. Your browser does not support ";
            // }
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
            //  redirect('http://www.muslah.com/me');
            echo 'Only allowed in Mozilla Firefox browser. Your browser is Internet explorer';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo 'Only allowed in Mozilla Firefox browser. Your browser is Internet explorer';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {

            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            $this->load->view('admin-login', $isUserLoggedIn);

            //  echo 'Only allowed in Mozilla Firefox browser. Your browser is Google Chrome';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo "Only allowed in Mozilla Firefox browser. Your browser is Opera Mini";
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            echo "Only allowed in Mozilla Firefox browser. Your browser is Opera";
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
            //redirect('http://www.muslah.com/me');
            //echo "Only allowed in Mozilla Firefox browser. Your browser is Safari";
            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            }
            $isUserLoggedIn['msg'] = "";
            $this->load->view('admin-login', $isUserLoggedIn);
        } else {
            //redirect('http://www.muslah.com/me');
            echo "Only allowed in Mozilla Firefox browser. Your browser is " . $ua;
        }
    }

    public function employeeLogin() {
        $this->load->view('employee-login');
    }

    public function loginget() {
        $this->form_validation->set_rules('txtusername', 'Username', 'required');
        $this->form_validation->set_rules('txtpassword', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $isUserLoggedIn['msg'] = "";
            $this->load->view('admin-login', $isUserLoggedIn);
        } else {
            $username = $this->input->post('txtusername');
            $password = $this->input->post('txtpassword');

            $isUserLoggedIn = $this->users_model->signIn($username, $password);
            if ($this->session->userdata('user_type')) {
                redirect('dashboard');
            } else {
                $this->load->view('admin-login', $isUserLoggedIn);
            }
        }
    }

    public function employeeLoginGet() {
        $this->form_validation->set_rules('employeeID', 'Employee ID', 'required');
        //$this->form_validation->set_rules('userPassword', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $isUserLoggedIn['msg'] = "Please Enter Correct Employee ID and Password";
            $this->load->view('employee-login', $isUserLoggedIn);
        } else {
           
            $username = $this->input->post('employeeID');
            $password = $this->input->post('userPassword');
            $isUserLoggedIn = $this->users_model->employeeSignIn($username, $password);
            if ($this->session->userdata('user_type')) {
                redirect('employee-dashboard');
            } else {
                $this->load->view('employee-login', $isUserLoggedIn);
            }
        }
    }

    // end of login action
    public function getLogout() {
        $user_id = $this->session->userdata('user_id');
        $this->db->set("user_logged_status", 0)->set('user_last_accessed', 'NOW()', FALSE)->where("id", $user_id)->update('users');
        session_destroy();
        $this->session->sess_destroy();
        //  $this->output->clear_all_cache(); // Clears all cache from the cache directory
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        //redirect('login');
        redirect('admin-login');
    }
    public function employeeLogout() {
        $user_id = $this->session->userdata('user_id');
        $this->db->set("logged_status", 0)->set('last_accessed', 'NOW()', FALSE)->where("id", $user_id)->update('employee_id');
        session_destroy();
        $this->session->sess_destroy();
        //  $this->output->clear_all_cache(); // Clears all cache from the cache directory
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // redirect('login', 'refresh');
        redirect('employee-login', 'refresh');
    }

    public function forgotpassword() {
        $this->form_validation->set_rules('forgotemail', 'E-mail', 'required');
        if ($this->form_validation->run() == FALSE) {
            $isUserLoggedIn['msg'] = "";
        } else {
            $useremail = $this->input->post('forgotemail');
            $isUserLoggedIn['msg'] = "";
            $userinfo = $this->users_model->singleuserbyemail($useremail);
            if ($userinfo) {
                $user_pass = $userinfo['password'];
                $user_mail = $userinfo['email'];
                $username = $userinfo['username'];
                $this->mailtouser($user_mail, $user_pass, $username);
                $isUserLoggedIn['msg'] = "<b style='background:pink'>Your Password hes sent to your email. <a href='" . base_url() . "'>Back to Login</a></b>";
            } else {
                $isUserLoggedIn['msg'] = "<b style='background:pink'>Your are not registered</b>";
            }
        }
        $this->load->view('settings/forgotpassword', $isUserLoggedIn);
    }
    
    public function employeePasswordChange(){
        $this->load->view('settings/change-employee-password');
    }
    public function updateEmployeePassword(){
        //$this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
        } else {
            $contentID = $this->session->userdata('content_id');
            $empPassword = $this->input->post('old_password');
            if(empty($empPassword)){
                $empPassword=NULL;
            }
            $newPassword = $this->input->post('new_password');
            $confirmPassword = $this->input->post('confirm_password');
            $isEmpOk = $this->db->get_where('employee_id', array('id' => $contentID, 'password' => $empPassword))->row();
            //$isEmpOk = $this->db->query("SELECT * FROM employee_id WHERE id=$contentID AND password=$empPassword LIMIT 1")->row();
            if($isEmpOk){
                if($newPassword!=$confirmPassword){
                    $this->session->set_flashdata('errors', "SORRY! New password and Confirm password mismatch.");
                }else{
                     if($newPassword==$empPassword){
                            $this->session->set_flashdata('errors', "SORRY! New password and Old password are same. Please change it.");
                        }else{
                            $updateOk = $this->db->query("UPDATE employee_id SET password=$newPassword WHERE  id=$contentID/* AND password=$empPassword */");
                            if($updateOk){
                                $this->session->set_flashdata('success', "Password has been changed successfully!");
                                redirect('employee-dashboard');  
                            }else{
                                $this->session->set_flashdata('errors', "SORRY! Password not change.");
                            }
                        }
                }
               
            }else{
                $this->session->set_flashdata('errors', "SORRY! Old password mismatch!!");
            }
        }
        redirect('change-employee-password');  
    }
    public function mailtouser($user_mail, $user_pass, $username) {
        $to = $user_mail;
        $subject = "Forgot login password at HRM Software";

        $message = "
        <html>
        <head>
        <title>Forgot login password at HRM Software</title>
        </head>
        <body>
        <p>Congratulation! Your password is $user_pass and user name is $username. Please change your password after login.
        If you have any queries please feel free to contact us at support@HRMSoftware.com</p>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <support@HRMSoftware.com>' . "\r\n";

        mail($to, $subject, $message, $headers);
    }

}

?>