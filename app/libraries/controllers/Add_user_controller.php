<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_user_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
//        $this->load->library('session');
        
    }
    public function adduser_action($post_data=array()) {
        
        $this->CI->load->database();
        $this->CI->load->model('users_model');        
        $user_id         = $post_data['user_id'];
        $employee_id        = $post_data['employee_id'];
        $name               = $post_data['fullname'];
        $user_name          = $post_data['user_name'];
        $email_address      = $post_data['email_address'];
        $password           = $post_data['password'];
        $confirm_password   = $post_data['confirm_password'];
        $phone              = $post_data['phone'];
        $usertype           = $post_data['user_type'];
        $user_division      = $post_data['user_division'];
        $user_department    = $post_data['user_department'];
        $user_status        = $post_data['user_status'];
        $params = array(
            'id'                => '',
            'employee_id'       => $employee_id,
            'name'              => $name,
            'username'          => $user_name,
            'email'             => $email_address,
            'password'          => $password,
            'user_status'       => $user_status,
            'phone'             => $phone,
            'user_role'         => $usertype,
            'user_division'     => $user_division,
            'user_department'   => $user_department,
            'created'           => getCurrentDateTime(),
            );
        if($user_id){
            $params = array_filter($params, 'strlen');
            $res=$this->CI->users_model->updateuser($params, $user_id);
                  if($res){
                $this->CI->session->set_userdata('add_status', 'Data updated successfully!');
            }else{
                $this->CI->session->set_userdata('add_status', 'Something Wrong!');
            }
        }else{
             $res=$this->CI->db->insert("users", $params);
                   if($res){
                $this->CI->session->set_userdata('add_status', 'Data inserted successfully!');
            }else{
                $this->CI->session->set_userdata('add_status', 'Something Wrong!');
            }
            $this->mailtoadmin($email_address, $name, $user_name);
            $this->mailtouser($email_address, $name, $user_name);
        }
        return $res;
        
        
            //echo $this->email->print_debugger();
    }
  public function register_action($post_data=array()) {
        $this->CI->load->database();
        $this->CI->load->model('users_model');        
        $content_id         = $post_data['content_id'];
        $employee_id        = $post_data['employee_id'];
        $name               = $post_data['fullname'];
        $user_name          = $post_data['user_name'];
        $email_address      = $post_data['email_address'];
        $password           = $post_data['password'];
        $confirm_password   = $post_data['confirm_password'];
        $phone              = $post_data['phone'];
        $usertype           = $post_data['user_type'];
        $user_division      = $post_data['user_division'];
        $user_department    = $post_data['user_department'];
        $user_status        = $post_data['user_status'];
        $params = array(
            'id'                => '',
            'employee_id'       => $employee_id,
            'name'              => $name,
            'username'          => $user_name,
            'email'             => $email_address,
            'password'          => $password,
            'user_status'       => '0',
            'phone'             => $phone,
            'user_role'         => "4",
            'user_division'     => $user_division,
            'user_department'   => "",
            'created'           => getCurrentDateTime(),
            );
        if($content_id){
            $params = array_filter($params, 'strlen');
            $this->CI->users_model->updateuser($params, $content_id);
        }else{
             $this->CI->db->insert("users", $params);
            $this->mailtoadmin($email_address, $name, $user_name);
            $this->mailtouser($email_address, $name, $user_name);
        }
        
        
            //echo $this->email->print_debugger();
    }
    public function mailtouser($from, $name, $user_name){
        $to = $from;
        $subject = "Rergistration Result at AAG HRMS";

        $message = "
        <html>
        <head>
            <title>Rergistration Result at AAG HRMS</title>
        </head>
        <body>
            <p>Congratulation! Your registration has been accepted. Please wait until administration approval.
                If you have any enqueries please feel free to E-mail us at programmer@ahmedamin-bd.com.</p>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <programmer@ahmedamin-bd.com>' . "\r\n";

            mail($to,$subject,$message,$headers);

        }
        public function mailtoadmin($from, $name, $user_name){
            $to = "programmer@ahmedamin-bd.com";
            $subject = "New user registration in AAG HRMS";

            $message = '
            <html>
            <head>
                <title>New user registration in AAG HRMS</title>
            </head>
            <body>
                <p>New user has been created. Please active this user. User id is '.$user_name.'</p>
            </body>
            </html>
            ';

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <programmer@ahmedamin-bd.com>' . "\r\n";

            mail($to,$subject,$message,$headers);    
        }


    }

    ?>