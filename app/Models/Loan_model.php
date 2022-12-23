<?php

class Loan_model extends CI_Model {

    public function getAllLoanType() {
        $result = $this->db->query("SELECT * FROM tbl_loan_type WHERE deletion_status=0")->result_array();
        return $result;
    }

    function getLoanTypeById($id) {
        $query = $this->db->get_where('tbl_loan_type', array('id' => $id));
        return $query->row_array();
    }

    public function checkExist($value) {
        $this->db->select('loan_type_name')->from('tbl_loan_type');
        $this->db->WHERE('loan_type_name', $value);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function insertLoanType($paramsData) {
        return $this->db->insert("tbl_loan_type", $paramsData);
    }

    public function updateLoanType($data = array(), $where = array()) {
        $this->db->where($where);
        $this->db->update('tbl_loan_type', $data);
        return true;
    }

    function deleteById($id, $table) {
        $this->db->where('id', $id);
        $res = $this->db->delete($table);
        if ($res) {
            return true;
        }
    }

    public function getloanTypeName($value) {
        if ($value) {
            $this->db->select('loan_type_name')->from('tbl_loan_type');
            $this->db->WHERE('loan_type_name', $value);
            $query = $this->db->get();
            $data = $query->row();
            return $data;
        }
    }

    public function getActiveEmployee() {
        return $this->db->query("SELECT content_id,emp_id,emp_name FROM search_field_emp WHERE type_of_employee NOT IN(153,473) ORDER BY emp_name")->result_array();
    }

    public function getAllEmployee() {
        return $this->db->query("SELECT content_id,emp_id,emp_name FROM search_field_emp ORDER BY emp_name")->result_array();
    }

    public function getActiveLoanType() {
        return $this->db->query('SELECT * FROM tbl_loan_type WHERE status=1')->result_array();
    }

    public function getInterestByLoanId($id) {
        $this->db->select('interest_percentage')->from('tbl_loan_type');
        $this->db->WHERE('id', $id);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function getEmpContentId($emp_id) {
        return $this->db->query("SELECT id FROM employee_id WHERE emp_id=$emp_id")->row();
    }

    public function insertLoanAdvance($paramsData) {
        $this->db->insert("tbl_loan_advance", $paramsData);
        $loanId = $this->db->insert_id();
        return $loanId;
    }

    public function insertLoanAdvanceDisbursement($disbursementData) {
        $this->db->insert("tbl_loan_disbursement", $disbursementData);
        return true;
    }

    public function getLoanDisbursementData($id) {
        return $this->db->query("SELECT * FROM tbl_loan_disbursement WHERE loan_id=$id")->result();
    }

    public function getEmployeeLoanData($content_id, $year) {
        return $this->db->query("SELECT l.*,ac.AccountName,lt.loan_type_name FROM tbl_loan_advance as l LEFT JOIN tbl_loan_type as lt ON lt.id=l.loan_type_id LEFT JOIN tbl_accounts AS ac ON ac.ID=l.account_id WHERE l.content_id=$content_id AND l.year=$year")->result();
    }

    public function getAccountLoanData($accountId, $year) {
        if ($accountId == '') {
            return $this->db->query("SELECT l.*,lt.loan_type_name,sfe.emp_name FROM tbl_loan_advance as l "
                            . "LEFT JOIN tbl_loan_type as lt ON lt.id=l.loan_type_id "
                            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=l.content_id "
                            . "WHERE l.year=$year ORDER BY l.id")->result();
        } else {
            return $this->db->query("SELECT l.*,lt.loan_type_name,sfe.emp_name FROM tbl_loan_advance as l "
                            . "LEFT JOIN tbl_loan_type as lt ON lt.id=l.loan_type_id "
                            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=l.content_id "
                            . "WHERE l.account_id=$accountId AND l.year=$year ORDER BY l.id")->result();
        }
    }

    public function getDepatmentLoanData($divisionId, $departmentId, $year) {
        return $this->db->query("SELECT l.*,lt.loan_type_name,sfe.emp_name FROM tbl_loan_advance as l "
                        . "LEFT JOIN tbl_loan_type as lt ON lt.id=l.loan_type_id "
                        . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=l.content_id "
                        . "WHERE sfe.emp_division=$divisionId AND sfe.emp_department=$departmentId AND l.year=$year ORDER BY l.id")->result();
    }

    public function getLoans($searchQuery) {
        if ($searchQuery) {
            $this->db->select('l.*,lt.loan_type_name,sfe.emp_name');
            $this->db->from('tbl_loan_advance AS l');
            $this->db->join('tbl_loan_type AS lt', 'lt.id = l.loan_type_id', 'LEFT');
            $this->db->join('search_field_emp AS sfe', 'sfe.content_id = l.content_id', 'LEFT');
            $this->db->where($searchQuery, NULL, FALSE);
            $this->db->order_by('l.id', 'ASC');
            $query = $this->db->get();
            if (count($query) > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }
    public function deleteLoanById($id){
        $loanStatusPaid = $this->db->query("SELECT id FROM tbl_loan_disbursement WHERE loan_id=$id AND status=1 LIMIT 1")->row();
        if(!$loanStatusPaid){
            $loanDisResult = $this->db->query("SELECT id,status FROM tbl_loan_disbursement WHERE loan_id=$id")->result();
            foreach($loanDisResult AS $singDisRes){
               $loanDisburseId = $singDisRes->id;
               $payrollResult = $this->db->query("SELECT * FROM tbl_payroll WHERE loan_disbursement_id=$loanDisburseId AND total_paid=0")->row();
               if($payrollResult){
                    $loanAmount = $payrollResult->loan;
                    $this->db->query("UPDATE tbl_payroll SET total_deduction=total_deduction-$loanAmount,net_salary=net_salary+$loanAmount,loan=0,loan_disbursement_id=NULL WHERE id=$payrollResult->id");
               }
            }
            $query="DELETE FROM tbl_loan_advance WHERE id=$id ";
            $this->db->query($query);

            $query2="DELETE FROM tbl_loan_disbursement WHERE loan_id=$id ";
            $this->db->query($query2);
            return true;
        }else{
             return false;
        }      
        
    }
    public function getDueLoanData($content_id, $year) {
        return $this->db->query("SELECT l.*,lt.loan_type_name FROM tbl_loan_advance as l LEFT JOIN tbl_loan_type as lt ON lt.id=l.loan_type_id WHERE l.content_id=$content_id AND l.year=$year AND l.balance!=0.00")->result();
    }

    public function getDueLoanIdByEmployeeId($content_id, $year) {
        return $this->db->query("SELECT id FROM tbl_loan_advance WHERE content_id=$content_id AND year=$year AND repayment_from =0 AND balance > '0.00'")->result();
    }

    public function getLoanDisbursmentPaymentDataByLoanId($loan_id) {
        return $this->db->query("SELECT * FROM tbl_loan_disbursement WHERE loan_id=$loan_id AND status=0 ORDER BY id LIMIT 1")->row();
    }

    public function insertLoanPayment($paramsData) {
        $this->db->insert("tbl_loan_repayment", $paramsData);
        $loanPaymentId = $this->db->insert_id();
        return $loanPaymentId;
    }

    public function updateLoanInfo($loanId, $amount) {
        $query = "UPDATE tbl_loan_advance SET paid_installment=paid_installment+1,balance=balance-$amount WHERE id=$loanId ";
        $this->db->query($query);
        return true;
    }

    public function updateLoanDisbursementInfo($id) {
        $query = "UPDATE tbl_loan_disbursement SET status=1 WHERE id=$id ";
        $this->db->query($query);
        return true;
    }

    public function getAccounts() {
        return $this->db->query("SELECT * FROM tbl_accounts WHERE Status=1 ORDER BY SerialOrder")->result();
    }

    public function updateAccountBalance($accountId, $amount) {
        $query = "UPDATE tbl_accounts SET Balance=Balance-$amount WHERE ID=$accountId ";
        $this->db->query($query);
        return true;
    }

    public function updateAccountBalanceCr($accountId, $amount) {
        $query = "UPDATE tbl_accounts SET Balance=Balance+$amount WHERE ID=$accountId ";
        $this->db->query($query);
        return true;
    }

    public function insertPaymentTransData($paramsData) {
        return $this->db->insert("tbl_transactions", $paramsData);
    }
    
    public function uodateLoanInfo($loanId,$amount){      
     
    }

}

?>