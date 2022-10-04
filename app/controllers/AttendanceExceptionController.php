<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AttendanceExceptionController extends CI_Controller
{

    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->library('encrypt'); //load this library. 
        // ini_set('max_execution_time', 30000);
    }

    #Employee Section
    function create()
    {
        $contentId = $this->session->userdata('content_id');
        if (!$contentId) {
            $this->session->set_flashdata('errors', "Something went wrong!");
        } else {
            $data = array();
            $postData = $this->input->post();
            if ($postData) {
                $this->form_validation->set_rules('attendance_date', 'Attendance Date', 'required');
                $this->form_validation->set_rules('exception_type', 'Exception Type', 'required');
                $this->form_validation->set_rules('reason', 'Reason', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->session->set_flashdata('errors', validation_errors());
                } else {

                    $attendanceDate = date('Y-m-d', strtotime($postData['attendance_date']));
                    $editId = $this->input->post('edit_attendance_exception_id');
                    if (!$editId) {
                        #check duplicate
                        $checkExist = $this->db->query("SELECT * FROM attendance_exceptions WHERE content_id=$contentId AND attendance_date='$attendanceDate' ")->row();
                        if ($checkExist) {
                            $this->session->set_flashdata('errors', "Your exception record already exist!");
                        } else {
                            #INSERT
                            $formData = array(
                                'content_id' => $contentId,
                                'attendance_date' => $attendanceDate,
                                'exception_type' => $postData['exception_type'],
                                'reason' => $postData['reason'],
                                'created_at' => $this->currentDateTime(),
                                'created_by' => $this->session->userdata('content_id')
                            );
                            $this->db->insert("attendance_exceptions", $formData);
                            $this->session->set_flashdata('success', "Attendance exception inserted successfully!");
                        }
                    } else {
                        #check duplicate
                        $checkExist = $this->db->query("SELECT * FROM attendance_exceptions WHERE content_id=$contentId AND attendance_date='$attendanceDate' AND id !=$editId ")->row();
                        if ($checkExist) {
                            $this->session->set_flashdata('errors', " Exception record already exist!");
                        } else {
                            #UPDATE
                            $formData = array(
                                'content_id' => $contentId,
                                'attendance_date' => $attendanceDate,
                                'exception_type' => $postData['exception_type'],
                                'reason' => $postData['reason'],
                                'updated_at' => $this->currentDateTime(),
                                'updated_by' => $this->session->userdata('content_id')
                            );
                            $this->db->where('id', $editId);
                            $this->db->update("attendance_exceptions", $formData);
                            $this->session->set_flashdata('success', "Attendance exception updated successfully!");
                            redirect('my-attendance-exceptions');
                        }
                    }
                }
            }
        }
        $this->load->view('attendance_exception/create_attendance_exception', $data);
    }
    function myException()
    {
        $data = array();
        $action = $this->uri->segment(2);
        $encrptId = $this->uri->segment(3);
        $decrptId = base64_decode(urldecode($encrptId));
        if ($action && $decrptId) {
            switch ($action) {
                case 'edit':
                    $edit_info = $this->db->query("SELECT * FROM attendance_exceptions WHERE id=$decrptId AND status=0")->row();
                    if ($edit_info) {
                        $data['edit_info'] = $edit_info;
                        $this->load->view('attendance_exception/create_attendance_exception', $data);
                        return false;
                    } else {
                        $this->session->set_flashdata('errors', "Something went wrong!");
                    }

                    break;
                case 'delete':
                    $this->db->query("DELETE FROM attendance_exceptions WHERE id=$decrptId AND status=0");
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('success', "Record deleted successfully!");
                    } else {
                        $this->session->set_flashdata('errors', "Something went wrong!");
                    }

                    break;
                default:
                    $this->session->set_flashdata('errors', "Something went wrong!");
            }
            redirect('my-attendance-exceptions');
        }
        $this->encrypt->decode(); //Decrypts an encoded string. 
        $contentId = $this->session->userdata('content_id');
        $data['attendance_exceptions'] = $this->db->query("SELECT * FROM attendance_exceptions WHERE content_id=$contentId ")->result();
        $this->load->view('attendance_exception/my_attendance_exception', $data);
    }

    #HR/Admin Section

    function attendanceExceptions()
    {
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->db->select('exception.*,emp.emp_id,emp.emp_name,division.name as emp_division')
        ->from('attendance_exceptions exception')
        ->join('search_field_emp as emp','emp.content_id=exception.content_id','LEFT')
        ->join('taxonomy as division','division.id=emp.emp_division','LEFT');

        $this->db->order_by('exception.id','DESC');
        if($this->input->post()){
            $status = $this->input->post('search_status');
            $content_id = $this->input->post('content_id');
            if($status!=null){
                $this->db->where('exception.status',$status);
            }
            if($content_id!=null){
                $this->db->where('exception.content_id',$content_id);
            }
        }else{
            $this->db->limit(100);
        }        
        
        $query = $this->db->get();
        $data['attendance_exceptions'] = $query->result();
        $this->load->view('attendance_exception/attendance_exceptions', $data); 

    }

    public function updateStatus()
    {
        $userEmployeeId = $this->session->userdata('employee_id');
        $empInfo = $this->db->query("SELECT id FROM employee_id WHERE emp_id='$userEmployeeId' ")->row();
        $empContentId = $empInfo->id;
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
        $this->db->set($columnName, $newValue);
        $this->db->set('updated_at', getCurrentDateTime());
        $this->db->set('updated_by', $empContentId);
        $this->db->where('id', $contentId);
        $result = $this->db->update('attendance_exceptions');
    }

    function approved()
    {
    }
    function declined()
    {
        // add decline reason
    }
    function currentDateTime()
    {
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        return date("Y-m-d H:i:s", $servertime);
    }
}
