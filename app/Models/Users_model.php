<?php

class Users_model extends CI_Model {

    function signIn($username, $password) {
        $sql = $this->db->get_where('users', array('username' => $username, 'password' => $password, 'user_status' => 1))->row_array();
        if (!isset($sql['id'])) {
            $response['msg'] = 'Username and Password mismatch.';
            $response['rc'] = FALSE;
            return $response;
        } else {
            $sessiondata = array(
                'user_id' => $sql['id'],
                'employee_id' => $sql['employee_id'],
                'user_name' => $sql['username'],
                'user_type' => $sql['user_role'],
                'user_division' => $sql['user_division'],
                'user_department' => $sql['user_department'],
                'user_permitted_account_group' => $sql['user_permitted_account_group'],
                'logged_in' => TRUE
            );

            $this->session->set_userdata($sessiondata);

            $response['msg'] = 'Success';
            $response['rc'] = TRUE;
            $id=$sql['id'];
            $this->db->set("user_logged_status", 1)->set('user_last_accessed', 'NOW()', FALSE)->where("id", $id)->update('users');
            
            return $response;
        }
    }
    function employeeSignIn($username, $password) {
        if(empty($password)){
            $password=NULL;
        }
        $sql = $this->db->get_where('employee_id', array('emp_id' => $username, 'password' => $password, 'status' => 1))->row_array();
       
        if (!isset($sql['id'])) {
            $response['msg'] = 'Username and Password mismatch.';
            $response['rc'] = FALSE;
            return $response;
        } else {
            $contentId = $sql['id'];
            $empInfo = $this->db->query("SELECT emp_name FROM search_field_emp WHERE content_id=$contentId")->row();
            $sessiondata = array(
                'user_id' => $contentId,
                'emp_id' => $sql['emp_id'],
                'emp_name' => $empInfo->emp_name,
                'content_id' => $contentId,
                'logged_in' => TRUE,
                 'user_type' => "employee",
            );

            $this->session->set_userdata($sessiondata);

            $response['msg'] = 'Success';
            $response['rc'] = TRUE;
            $id=$sql['id'];
            $this->db->set("logged_status", 1)->set('last_accessed', 'NOW()', FALSE)->where("id", $id)->update('employee_id');
            
            return $response;
        }
    }
//    function getAllusers() {
//        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->result_array();
//    }
    function getAllUsers(){
        $result=$this->db->query("SELECT u.*,r.user_type as user_role,r.id as role_id,t.name as user_division_name,t2.name as user_department_name "
                . "FROM users as u "
                . "LEFT JOIN role as r ON u.user_role=r.id "
                . "LEFT JOIN taxonomy as t ON u.user_division=t.id "
                . "LEFT JOIN taxonomy as t2 ON u.user_department=t2.tid ORDER BY id DESC")->result_array();
        return $result;
    }
    function getuserbyid($user_id) {
        if($user_id){
            return $this->db->query("select * from users WHERE id=$user_id")->row_array();
        }
    }

    function updateuser($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return true;
    }    

    function userpermission($per_name, $user_type) {
        return $this->db->query("select * from permissions WHERE action ='$per_name' and user_type='$user_type'")->result_array();
    }
    function allpermission() {
        return $this->db->query("select * from permissions")->result_array();
    } 
    function allglobalsettings() {
        return $this->db->query("select * from globalsettings")->result_array();
    }       
    function gettaskwiseglobalsettings($task_type) {
        return $this->db->query("select * from globalsettings WHERE action ='$task_type'")->row_array();
    }      
    function getallrole() {
        return $this->db->query("select * from role ORDER BY id ASC")->result_array();
    }    
    function deleteUserwisePermissionByUserId($user_id) {
        $tables = array('userwiseaccess', 'permitted_emp');
        $this->db->where('user_id', $user_id);
        $this->db->delete($tables);
        return true;
    }
    function deleteglobalsettings() {
        $this->db->empty_table('globalsettings'); 
    }    
    function getuserwisepermission($task_type, $user_id) {
        return $this->db->query("select * from userwiseaccess WHERE action ='$task_type' and user_id='$user_id'")->row_array();
    }  
    function getpermittedemployee($user_id) {
        return $this->db->query("SELECT * FROM permitted_emp WHERE user_id='$user_id'")->row_array();
    }  
    function singleuserbyemail($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row_array();
    }         
    public function updanytbl($data = array(), $where = array(), $tblname) {
        if($data && $where && $tblname){
            $this->db->where($where);
            $this->db->update($tblname, $data);
            return true;
        }
    }   
    function getuserdetails($id) {
        return $this->db->get_where('users', array('id' => $id))->row_array();
    }          
}
?>