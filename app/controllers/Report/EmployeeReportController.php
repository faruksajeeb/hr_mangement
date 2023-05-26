<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class EmployeeReportController extends CI_Controller
{
    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    public function yearlyEmployeeCount()
    {
        
        if ($this->input->get()) {           
            
                $company_info = explode('|', $this->input->get('company_id'));
                $company_id = $company_info[0];
                $company_name = $company_info[1];
                $division_info = explode('|', $this->input->get('division_id'));
                $division_id = $division_info[0];
                $branch_name = $division_info[1];
                $date_from = date('d-m-Y', strtotime($this->input->get('date_from')));
                $date_to = date('d-m-Y', strtotime($this->input->get('date_to')));
               
                if ($company_id && $division_id && $date_from && $date_to) {
                    $divisionCondition = '';
                    if ($division_id != 'all') {
                        $divisionCondition = "AND EJH.department_tid='$division_id'";
                    }
                  
                    $records = $this->db->query("SELECT 
                    EJH.*,SFE.emp_name,SFE.emp_id,
                    company.name as company_name,
                    branch.name as branch_name,
                    department.name as department_name,
                    designation.name as designation_name
                    FROM emp_job_history as EJH
                    LEFT JOIN search_field_emp as SFE ON SFE.content_id=EJH.content_id 
                    LEFT JOIN taxonomy as company ON company.id=EJH.division_tid 
                    LEFT JOIN taxonomy as branch ON branch.id=EJH.department_tid 
                    LEFT JOIN taxonomy as department ON department.id=EJH.department_id 
                    LEFT JOIN taxonomy as designation ON designation.id=EJH.post_tid 
                    WHERE EJH.division_tid='$company_id'
                    AND STR_TO_DATE(EJH.start_date,'%d-%m-%Y') >= STR_TO_DATE('$date_from','%d-%m-%Y') 
                    AND (STR_TO_DATE(EJH.end_date,'%d-%m-%Y') <= STR_TO_DATE('$date_to','%d-%m-%Y') OR EJH.end_date IS NULL)
                    $divisionCondition  
                GROUP BY EJH.content_id 
                ORDER BY EJH.grade_tid");
//  dd($records);
                    if ($records->num_rows() > 0) {
                        $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                        $html .= '<tr>
                        <th colspan="7" style="text-align:center;font-size:20px;background-color:#CCC">Yearly Leave Count</th>
                    </tr>';
                        $html .= '<tr>
                    <th>Company :</th>
                    <th >' . $company_name . '</th>
                    <th style="text-align:right">Branch/ Division : </th>
                    <th >' . $branch_name . '</th>
                    <th style="text-align:right">Date Range: </th>
                    <th colspan="2">' . $date_from." to ".$date_to . '</th>
                    
                </tr>';
                        $html .= '<tr>
                    <th>SL NO</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Company Name</th>
                    <th>Branch Name</th>
                    <th>Department Name</th>
                    <th>Designation Name</th>
                </tr>';
                        $html .= '</thead>
                    <tbody>';
                        $totalEmp = 0;
                        foreach ($records->result() as $key => $val) :
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->emp_name .
                                '</td><td>' . $val->emp_id .
                                '</td><td>' . $val->company_name .
                                '</td><td>' . $val->branch_name .
                                '</td><td>' . $val->department_name .
                                '</td><td>' . $val->designation_name .
                                '</td></tr>';
                                $totalEmp++;
                        endforeach;
                        $html .= '</tbody>';
                        $html .= '<tfoot>';
                        $html .= '<tr><td colspan="7" style="text-align:center">Total Employee: '.$totalEmp.'</td></tr>';
                        $html .= '</tfoot>';
                        
                        $html .= '</table>';
                        echo $html;
                    } else {
                        echo "No data found.";
                    }
                } else {
                    echo "Something went wrong!";
                }
            return FALSE;
        }

        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 and status=1")->result();
        $this->load->view('reports/employee/yearly_emloyee_count', $data);
    }
}
