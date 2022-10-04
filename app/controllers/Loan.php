<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Loan extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper('url');
        $this->load->model('Loan_model');
        
    }

    public function index() {       
        
    }
    public function loanType(){        
        if($this->input->post('add_btn')){
            $postData=$this->input->post();
            $userId = $this->session->userdata('user_id');
            $content_id=$postData['content_id'];
            $loanTypeName=$postData['loan_type_name'];
            $check_duplicate=$this->Loan_model->getloanTypeName($loanTypeName);
            
            if($loanTypeName && !$check_duplicate){
                if($content_id){
                $paramsData = array(
                    'loan_type_name' =>  $postData['loan_type_name'],
                    'max_loan_amount' =>  $postData['max_loan_amount'],
                    'interest_percentage' => $postData['interest_percent'],
                    'status' =>  $postData['status'],
                    'description' =>  $postData['description'],
                    'updated_at' => $this->current_time(),
                    'updated_by' => $userId
                );
                $updateCondition=array('id' => $content_id);
                $result = $this->Loan_model->updateLoanType($paramsData,$updateCondition);
                if($result==true)
                {
                    $this->session->set_flashdata('success', "Data Updated."); 
                }else{
                    $this->session->set_flashdata('error', "Data not updated");
                }
            }else{
                $paramsData = array(
                    'loan_type_name' =>  $postData['loan_type_name'],
                    'max_loan_amount' =>  $postData['max_loan_amount'],
                    'interest_percentage' => $postData['interest_percent'],
                    'status' =>  $postData['status'],
                    'description' =>  $postData['description'],
                    'created_at' => $this->current_time(),
                    'created_by' => $userId
                );
                $result = $this->Loan_model->insertLoanType($paramsData);
                if($result==true)
                {
                    $this->session->set_flashdata('success', "Data Inserted."); 
                }else{
                    $this->session->set_flashdata('error', "Data not inserted");
                }
            }
            }else{
                $update_key=$check_duplicate->loan_type_name;
                $paramsData = array(
                    'loan_type_name' =>  $postData['loan_type_name'],
                    'max_loan_amount' =>  $postData['max_loan_amount'],
                    'interest_percentage' => $postData['interest_percent'],
                    'status' =>  $postData['status'],
                    'description' =>  $postData['description'],
                    'updated_at' => $this->current_time(),
                    'updated_by' => $userId
                );
                $updateCondition=array('loan_type_name' => $update_key);
                $result = $this->Loan_model->updateLoanType($paramsData,$updateCondition);
                if($result==true)
                {
                    $this->session->set_flashdata('success', "Data Updated."); 
                }else{
                    $this->session->set_flashdata('error', "Data not updated");
                }
            }
            
             //$data['msg']=$msg; 
             redirect('loan-type');            
        }
        
        if($this->uri->segment(2)){
            
            $edit_id=$this->uri->segment(2);
            $data['id']=$edit_id;
            $data['toedit_records']=$this->Loan_model->getLoanTypeById($edit_id);
            
        }        
        $data['loan_types'] = $this->Loan_model->getAllLoanType();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->noCache();
        $this->load->view('loan/loan_type/loan_type',$data);
    }
    public function activeInactiveLoanType(){
       
            $edit_id=$this->uri->segment(2);
            $val=$this->uri->segment(3);
            if($val=='active'){
                $updateData=array(
                    'status' => 1,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $userId
                );                
            }else if($val=='inactive'){
                $updateData=array(
                    'status' => 0,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $userId
                );                
            }
            $updateCondition=array('id' => $edit_id);
            $result = $this->Loan_model->updateLoanType($updateData,$updateCondition);
            if($result==true)
            {
                $this->session->set_flashdata('msg_success', "Data Updated."); 
            }else{
                $this->session->set_flashdata('msg_error', "Data not updated");
            }
            redirect('loan-type');
        
    }
    public function deleteLoanType(){
        if ($this->uri->segment(3)) {
            $id = ($this->uri->segment(3));
            $res=$this->Loan_model->deleteById($id,'tbl_loan_type');
            if($res==true)
            {
                $this->session->set_flashdata('msg_success', "Data has been deleted."); 
            }else{
                $this->session->set_flashdata('msg_error', "Data not deleted");
            }                       
            redirect('loan-type');
             //redirect($final_controller_url);
        }
    }
    public function giveLoan(){ 
        $rst = null;
        if($this->input->post('add_btn')){
            $postData=$this->input->post();

            $empInfo = explode("|", $postData['emp_name']); 
            $contentId = $empInfo[0]; 
            $empId = $empInfo[1]; 
            $empCompanyId = $empInfo[2]; 
            $empDivisionId = $empInfo[3]; 
            $repaymentType = $postData['repayment'];
            
            $installmentNumber = $postData['installment'];
            $amount = $postData['amount'];
            $interestPercentage=$postData['interest'];            
            $penaltyPercentage=$postData['penalty'];
            
            $pricipalInstallmentAmount=$amount/$installmentNumber;
            if($penaltyPercentage>0){
                $penaltyAmount = ($amount*$penaltyPercentage)/100;
                $penaltyInstallmentAmount=$penaltyAmount/$installmentNumber;
            }else{
                $penaltyAmount=0;
                $penaltyInstallmentAmount=0;
            }
            if($interestPercentage>0){
                $interestAmount = ($amount*$interestPercentage)/100;
                $interestInstallmentAmount=$interestAmount/$installmentNumber; 
            }else{
                $interestAmount=0;
                $interestInstallmentAmount=0;               
                
            }
            $installmentAmount=$pricipalInstallmentAmount+$interestInstallmentAmount;
            $totalPayment=$amount + $interestAmount;
            
            
            $repayFromSalary=$postData['repay_from_salary'];
            if($repayFromSalary !=''){
                $repayFromSalary=1;
            }else{
                $repayFromSalary=0;
            }
            
            // Loan insert
            $paramsData = array(
                'account_id' =>  $postData['account_id'],
                'year' =>  $postData['year'],
                'loan_type_id' => $postData['loan_type'],
                'given_method' =>  $postData['loan_method'],
                'trans_date' =>  date('Y-m-d',strtotime($postData['trans_date'])),
                'given_by' =>  $this->session->userdata('user_id'),
                'amount' =>  $postData['amount'],
                'installment' =>  $postData['installment'],
                'interest' =>  $postData['interest'],
                'penalty' =>  $postData['penalty'],
                'total_payment' => $totalPayment,
                'installment_amount' =>  $installmentAmount,
                'content_id' =>  $contentId,
                'emp_id' =>  $empId,
                'company_id' =>  $empCompanyId,
                'division_id' =>  $empDivisionId,
                'balance' =>  $totalPayment,
                'repayment_type' =>  $postData['repayment'],
                'disbursement-date' =>  date('Y-m-d',strtotime($postData['disbursement_date'])),
                'repayment_from' => $repayFromSalary,
                'created_at' => $this->current_time(),
                'created_by' => $this->session->userdata('user_id')
            );
            
            $loanId = $this->Loan_model->insertLoanAdvance($paramsData);
            
            
            
            // Loan Disribution ---------------------
            
            $date = strtotime($postData['disbursement_date']);
            
            for($i=0;$i<$installmentNumber;$i++){
                if($repaymentType=='daily_repayment'){
                    $orderdate = explode('-', $postData['disbursement_date']);                    
                    $day   = $orderdate[0]+$i;
                    $month = $orderdate[1];                    
                    $year  = $orderdate[2];
                    if($day<10){
                        $disbursement_date=$year.'-'.$month.'-0'.$day;
                    }else{
                        $disbursement_date=$year.'-'.$month.'-'.$day;
                    }
                    
                }else if($repaymentType=='weekly_repayment'){
                    
                    $disbursement_date=$postData['disbursement_date'];
                   
                    if($i>0){
                        $date = strtotime("+7 day", $date);
                        $disbursement_date=date('d-m-Y', $date);
                    }
                    
                    
                }else if($repaymentType=='monthly_repayment'){
                    $orderdate = explode('-', $postData['disbursement_date']);                    
                    $day   = $orderdate[0];
                    $month = $orderdate[1]+$i;                    
                    $year  = $orderdate[2];
                    if($month<10){                                               
                        $disbursement_date=$year.'-0'.$month.'-'.$day;
                    }else{
                         if($month>60){
                            $year  = $orderdate[2]+5; 
                            $month = $month-60;
                        }else if($month>48){
                            $year  = $orderdate[2]+4;
                            $month = $month-48;
                        }else if($month>36){
                            $year  = $orderdate[2]+3;
                            $month = $month-36;
                        }else if($month>24){
                            $year  = $orderdate[2]+2;
                            $month = $month-24;
                        }else if($month>12){
                            $year  = $orderdate[2]+1;
                            $month = $month-12;
                        }                        
                       $disbursement_date=$year.'-'.$month.'-'.$day;
                        
                        
                    }                 
                    
                }else if($repaymentType=='yearly_repayment'){
                    $orderdate = explode('-', $postData['disbursement_date']);                    
                    $day   = $orderdate[0];
                    $month = $orderdate[1];                    
                    $year  = $orderdate[2]+$i;
                    if($month<10){
                        $disbursement_date=$day.'-'.$month.'-'.$year."<br/>";
                    }else{
                        $disbursement_date=$day.'-'.$month.'-'.$year."<br/>";
                    }                 
                    
                } 
                
                if($i>0){
                    $currBalance= $currBalance-($pricipalInstallmentAmount+$interestInstallmentAmount);                    
                }else{
                  $currBalance=$totalPayment-($pricipalInstallmentAmount+$interestInstallmentAmount);
                  
                }
                $disbursementData=array(
                    'loan_id' => $loanId,
                    'payment_date' => date('Y-m-d',strtotime($disbursement_date)),
                    'principal_amount' => $pricipalInstallmentAmount,
                    'interest_amount' => $interestInstallmentAmount,
                    'penalty_amount' => $penaltyInstallmentAmount,
                    'total_payment' => $pricipalInstallmentAmount+$interestInstallmentAmount,
                    'balance' => $currBalance,
                    'repayment_from' => $repayFromSalary,
                    'created_at' => $this->current_time(),
                    'created_by' => $this->session->userdata('user_id')                    
                );
                //print_r($disbursementData);
                $this->Loan_model->insertLoanAdvanceDisbursement($disbursementData);
            }
           
            if($loanId==true)
            {
                
                $transactionData = array(
                        'TransDate' =>  date('Y-m-d',strtotime($postData['trans_date'])),
                        'AccountID' => $postData['account_id'],
                        'TTypeID' => 2,
                        'CategoryID' => 9, // Loan given
                        'Amount' => $amount,
                        'Dr' => $amount,                    
                        'Ref' => $loanId,                    
                        'CreatedAt' => $this->current_time(),
                        'CreatedBy' => $this->session->userdata('user_id')  
                    );
                    $this->Loan_model->insertPaymentTransData($transactionData);
                    // $this->Loan_model->updateAccountBalance($postData['account_id'],$amount);
                $insertData=$this->Loan_model->getLoanDisbursementData($loanId);
             
                $this->session->set_flashdata('success', "Data Inserted."); 
                
                $this->session->set_flashdata('data', $insertData); 
                
            }else{
                $this->session->set_flashdata('error', "Data not inserted");
            }
            redirect('give-loan',$rst);  
        }
      
        //$data['accounts']=$this->loanModel->getActiveAccount();
        $data['loan_types']=$this->Loan_model->getActiveLoanType();
        $userId=  $this->session->userdata('user_id');
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        $userAccountGroupId=  $this->session->userdata('user_permitted_account_group');
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        if($userId==1){
            //$data['accounts']=$this->Loan_model->getAccounts();
            $data['employees']=$this->Loan_model->getAllEmployee();
        }else{
             $this->load->model('Payroll_model');
             //$data['accounts']= $this->Payroll_model->getAccountsByAcountGroupId($userAccountGroupId);
             if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
               
        $this->load->view('loan/give_loan',$data);
    }
    
   
    public function check_exists() {
        $id = $this->input->post('id', true);
        $value = $this->input->post('check_val', true);
        $result = $this->Loan_model->checkExist($value);
        if ($result) {
            //echo "'" . $name . "'" . ' <font color=red >Already exist!</font>';
            echo "Already exist!";
        } else {
            // echo "'" . $name . "'" . ' <font color=green >Available</font>';
        }
    } 
    public function getInterestByLoanId(){
        $id=$this->input->post('id');
        $result=$this->Loan_model->getInterestByLoanId($id);
        echo $result->interest_percentage;
    }
    
     public function employeeLoanReport(){
        if($this->input->post('add_btn')){
            $postData = $this->input->post();
            $empInfo = explode('-', $postData['emp_name']);
            $content_id=$empInfo[0];
            $data['emp_id']=$empInfo[1];
            $data['emp_name']=$empInfo[2];
            $data['year'] = $postData['year'];
            $year=$postData['year'];            
            $data['loans']=$this->Loan_model->getEmployeeLoanData($content_id,$year); 
            $data['search_record']=true;
        }
        $userId=  $this->session->userdata('user_id');
        $userType = $this->session->userdata('user_type');
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        $userAccountGroupId=  $this->session->userdata('user_permitted_account_group');
        
        if($userId==1 || $userType==9){
            $data['employees']=$this->Loan_model->getAllEmployee();
        }else{             
             if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $this->load->view('loan/report/employee_loan_report',$data);
    }
       
    public function divisionLoanReport(){
        
        if($this->input->post('search_btn')){
            $postData = $this->input->post();
            $accountInfo = explode('|',$postData['account_id']);
            $accountId=$accountInfo[0];
            $accountName=$accountInfo[1];
            $data['account_name']=$accountName;
            $data['year'] = $postData['year'];
            $year=$postData['year'];
            
                $data['loans']=$this->Loan_model->getAccountLoanData($accountId,$year); 
            
           $data['search_record']=true;            
        }
        
        $userId=  $this->session->userdata('user_id');
        $userType = $this->session->userdata('user_type');
        $userAccountGroupId=  $this->session->userdata('user_permitted_account_group');  
        
        if($userId==16 || $userType==9){
            $data['accounts']=$this->Loan_model->getAccounts();
        }else{
            $this->load->model('Payroll_model');
            $data['accounts']= $this->Payroll_model->getAccountsByAcountGroupId($userAccountGroupId);
        }
        
//        print_r($data['accounts']);
//        exit;
        
        $this->load->view('loan/report/division_loan_report',$data);
    }
    public function loanManage(){
        $searchPage = 'manage_loan';   
        $userId=  $this->session->userdata('user_id');
        if ($this->input->post('search_btn')) {
            $postData = $this->input->post();            
            $companyId=$postData['emp_company'];
            $companyName=$this->taxonomy->getTaxonomyBytid($companyId);
            $data['company_name']=$companyName['name'];
            $data['year'] = $postData['year'];
            $year = $postData['year']; 
            $divisionId = $postData['emp_division'];
            $divisionName=$this->taxonomy->getTaxonomyBytid($divisionId);
            $data['division_name']=$divisionName['name'];
            
            $query = " l.year=$year ";
            if ($companyId == '') {
                $data['company_name'] = 'All';
            } else {
                $query .=" AND sfe.emp_division=$companyId ";
            }
            if ($divisionId == '') {
                $data['division_name'] = 'All';
            } else {
                $query .=" AND sfe.emp_department=$divisionId ";
            }
            // search history section ---------
            $this->search_query_model->deleteQuerybyUserid($userId, $searchPage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            //$searchpage="payslip_confirmation";
            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $userId,
                'table_view' => $data['company_name'],
                'per_page' => $data['division_name'],
                'month' => '',
                'year' => $data['year'],
                'search_page' => $searchPage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);
            $data['search_record'] = true;
        }
        
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        if($userId==1){
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        }else{
            if($userDepartment){
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($userDepartment);
            }else{
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($userDivision);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($userDivision);
        }
        $default_info = $this->search_field_emp_model->getsearchQuery($searchPage);        
        $data['company_name'] = $default_info['table_view'];
        $data['division_name'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $searchQuery = $default_info['search_query'];        
        $data['loans']=$this->Loan_model->getLoans($searchQuery);
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $this->load->view('loan/loan_manage',$data, 'refresh');
    }
    public function deleteLoan(){
        $loanId = $this->uri->segment(2);
        $result = $this->Loan_model->deleteLoanById($loanId);
        if ($result === true) {
            $this->session->set_flashdata('success', "Loan deleted successfully. ");
        } else {
            $this->session->set_flashdata('error', "Loan not deleted!");
        }
        redirect('loan-manage');
    }

    public function getLoanDisbursmentDataByLoanId(){
        $id=$this->input->post('loan_id');
        $sdata['loan_id']=$id;
        $sdata['loanDisbursmentInfo']=$this->Loan_model->getLoanDisbursementData($id);
        $this->load->view("loan/report/disbursement", $sdata);
    }
    
    public function paymentLoan(){
        if($this->input->post('add_btn')){
            $postData=$this->input->post();
            $result=explode('-',$postData['emp_name']);
            $content_id=$result[0];
            
            $paramsData = array(
                'loan_id' => $postData['emp_loan_id'],
                'loan_disbursement_id' => $postData['disbursement_id'],
                // 'account_id' => $postData['account_id'],
                'content_id' => $content_id,
                'posting_date' =>  date('Y-m-d',strtotime($postData['posting_date'])),
                'payment_date_was' => $postData['payment_date'],
                'year' => $postData['year'],
                'payment_method' => $postData['payment_method'],
                'principal_amount' => $postData['principal_amount'],
                'interest_amount' => $postData['interest_amount'],
                'penalty_amount' => $postData['penalty_amount'],
                'total_amount' => $postData['total_installment_amount'],
                'created_at' => $this->current_time(),
                'created_by' => $this->session->userdata('user_id') 
            ); 
            
            
            $loanPaymentId = $this->Loan_model->insertLoanPayment($paramsData);
            if($loanPaymentId==true)
            {
                $transactionData = array(
                        'TransDate' =>  date('Y-m-d',strtotime($postData['posting_date'])),
                        'AccountID' => $postData['account_id'],
                        'TTypeID' => 1,
                        'CategoryID' => 76, // Loan repayment acceptence
                        'Amount' => $postData['total_installment_amount'],
                        'Cr' => $postData['total_installment_amount'],                    
                        'Ref' => $loanPaymentId,                    
                        'CreatedAt' => $this->current_time(),
                        'CreatedBy' => $this->session->userdata('user_id')  
                    );
                $this->Loan_model->insertPaymentTransData($transactionData);
                // $this->Loan_model->updateAccountBalanceCr($postData['account_id'],$postData['total_installment_amount']);
                
                $amount= $postData['principal_amount']+$postData['interest_amount'];
                $this->Loan_model->updateLoanInfo($postData['emp_loan_id'],$amount);
                $this->Loan_model->updateLoanDisbursementInfo($postData['disbursement_id']);
                $this->session->set_flashdata('success', "Data Inserted."); 
            }else{
                $this->session->set_flashdata('error', "Data not inserted");
            }
            redirect('loan-payment');
        }
        $userId=  $this->session->userdata('user_id');
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        $userAccountGroupId=  $this->session->userdata('user_permitted_account_group');
        
        if($userId==1){
            // $data['accounts']=$this->Loan_model->getAccounts();
            $data['employees']=$this->Loan_model->getAllEmployee();
        }else{
             $this->load->model('Payroll_model');
            //  $data['accounts']= $this->Payroll_model->getAccountsByAcountGroupId($userAccountGroupId);
             if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $this->load->view('loan/loan_payment',$data);
    }
    
    public function getDueLoanByEmployeeId(){
        $content_id=$this->input->post('content_id');
        $year=$this->input->post('year');
        $data['loans']=$this->Loan_model->getDueLoanData($content_id,$year);
        $this->load->view('loan/single_due_loan',$data);
        
    }
    public function getDueLoanIdByEmployeeId(){
        
        $content_id=$this->input->post('content_id');
        $year=$this->input->post('year');        
        $data['loans']=$this->Loan_model->getDueLoanIdByEmployeeId($content_id,$year);
        echo json_encode($data['loans']);        
        
    }
    
    public function getLoanDisbursmentPaymentDataByLoanId(){
        $loan_id=$this->input->post('loan_id');
        $data['disbusement']=$this->Loan_model->getLoanDisbursmentPaymentDataByLoanId($loan_id);
        echo json_encode($data['disbusement']); 
    }
    
    public function deleteLoanDisAmount(){
        $delId = $this->input->post('id');
        $disInfo = $this->db->query("SELECT * FROM tbl_loan_disbursement WHERE id=$delId")->row();
        $loanId = $disInfo->loan_id;
        $amount = $disInfo->total_payment;
//        echo $loanId;
        $this->db->query("UPDATE tbl_loan_disbursement SET balance=balance-$amount WHERE loan_id=$loanId");
        $this->db->query("UPDATE tbl_payroll SET loan=loan-$amount,total_deduction=total_deduction-$amount,net_salary=net_salary+$amount WHERE loan_disbursement_id=$delId");
       $updateOk= $this->db->query("UPDATE tbl_loan_advance SET installment=installment-1,amount=amount-$amount,total_payment=total_payment-$amount,balance=balance-$amount WHERE id=$loanId");
       if($updateOk){
            $this->db->where('id', $delId);
            $res = $this->db->delete("tbl_loan_disbursement");
            if ($res) {
                return true;
            }
       }
    }
    
        public function updateLoanPaymentDate(){
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
            $this->db->set($columnName, $newValue);
            $this->db->set('updated_at', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('id', $contentId);
            $result = $this->db->update('tbl_loan_disbursement');
    }
    
    public function updateLoanPaymentAmount(){
        $columnName = $this->input->post('name');
        $newAmount = $this->input->post('value');
        $contentId = $this->input->post('pk');
        $disInfo = $this->db->query("SELECT * FROM tbl_loan_disbursement WHERE id=$contentId")->row();
        $oldAmount = $disInfo->total_payment;
        $loanId = $disInfo->loan_id;
        if($newAmount>$oldAmount){ 
            $addAmt = $newAmount-$oldAmount;
            // update loan_disbursement, principal-amount, total_payment
            $this->db->query("UPDATE tbl_loan_disbursement SET principal_amount=principal_amount+$addAmt,total_payment=total_payment+$addAmt WHERE id=$contentId");
            // update loan_advance table amount,total_payment,balance
            $this->db->query("UPDATE tbl_loan_advance SET amount=amount+$addAmt,total_payment=total_payment+$addAmt,balance=balance+$addAmt WHERE id=$loanId");
            // update tbl_payroll loan,total_deduction,net_salary
            $this->db->query("UPDATE tbl_payroll SET loan=loan+$addAmt,total_deduction=total_deduction+$addAmt,net_salary=net_salary-$addAmt WHERE loan_disbursement_id=$contentId");
        }else if($newAmount<$oldAmount){
            $minusAmt = $oldAmount-$newAmount;
            $this->db->query("UPDATE tbl_loan_disbursement SET principal_amount=principal_amount-$minusAmt,total_payment=total_payment-$minusAmt WHERE id=$contentId");
            $this->db->query("UPDATE tbl_loan_advance SET amount=amount-$minusAmt,total_payment=total_payment-$minusAmt,balance=balance-$minusAmt WHERE id=$loanId");
            $this->db->query("UPDATE tbl_payroll SET loan=loan-$minusAmt,total_deduction=total_deduction-$minusAmt,net_salary=net_salary+$minusAmt WHERE loan_disbursement_id=$contentId");
        }
    }
    public function current_time() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }
    function noCache()
    {
        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
       
         
}

?>
