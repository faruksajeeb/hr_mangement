<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payrollModel
 *
 * @author Md. Omar Faruk
 */
class Payroll_model extends CI_Model
{
    //put your code here
    public function getAllEmployee()
    {
        return $this->db->query("SELECT content_id,emp_id,emp_name FROM search_field_emp ORDER BY emp_name")->result_array();
    }
    public function getEmpListByDivision($division)
    {
        $query = $this->db->select('DISTINCT(ejh.content_id),ejh.division_tid,ejh.department_tid,sfe.emp_id,sfe.emp_name')
            ->from('emp_job_history ejh')
            ->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT')
            ->where("ejh.division_tid", $division)
            //->order_by("sfe.emp_id + 0", "ASC")
            ->order_by("sfe.emp_id", "ASC")
            ->get();
        return $query->result_array();
    }
    public function getEmpListByDepartment($division, $department)
    {
        $query = $this->db->select('DISTINCT(ejh.content_id),ejh.division_tid,ejh.department_tid,sfe.emp_id,sfe.emp_name')
            ->from('emp_job_history ejh')
            ->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT')
            ->where("ejh.division_tid", $division)
            ->where("ejh.department_tid", $department)
            //->order_by("sfe.emp_id + 0", "ASC")
            ->order_by("sfe.emp_id", "ASC")
            ->get();
        return $query->result_array();
    }
    public function getEmployeeByJobHostory()
    {
        return $this->db->query("SELECT content_id,emp_id,emp_name FROM search_field_emp ORDER BY emp_name")->result_array();
    }
    public function getActiveEmployee()
    {
        return $this->db->query("SELECT content_id,emp_id,emp_name FROM search_field_emp WHERE type_of_employee NOT IN(153,473) ORDER BY emp_name")->result_array();
    }
    public function getEmpInfoByContentId($content_id)
    {
        //return $this->db->query("SELECT * FROM search_field_emp WHERE content_id=$content_id AND type_of_employee NOT IN(153,473)")->row();
        return $this->db->query("SELECT * FROM search_field_emp WHERE content_id=$content_id")->row();
    }

    public function getEmpSalaryInfoByContentId($content_id, $monthEndDate)
    {
        return $this->db->query("SELECT * FROM emp_salary WHERE content_id=$content_id AND effective_date <= '$monthEndDate' ORDER BY id DESC LIMIT 1")->row();
    }
    function getLeftEmployeeInfo($content_id)
    {
        return $this->db->query("SELECT start_date FROM emp_job_history WHERE content_id=$content_id AND end_date='' ORDER BY id DESC LIMIT 1")->row();
    }
    function getAllEmployeeByDivision($division_tid)
    {
        if ($division_tid == 'all') {
            $query = $this->db->select('sfe.*,texo.name,es.gross_salary')
                ->from('search_field_emp sfe')
                ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')
                ->where("sfe.content_id !='0' ")
                ->where('sfe.publication_status', 1)
                //                    ->limit($limit, $offset)
                //->order_by("sfe.emp_id + 0", "ASC")
                ->order_by("sfe.emp_id", "ASC")
                ->get();
        } else {
            $query = $this->db->select('sfe.*,texo.name,es.gross_salary')
                ->from('search_field_emp sfe')
                ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')
                ->where("sfe.emp_division", $division_tid)
                ->where("sfe.content_id !='0' ")
                ->where('sfe.publication_status', 1)
                //                    ->limit($limit, $offset)
                //->order_by("sfe.emp_id + 0", "ASC")
                ->order_by("sfe.emp_id", "ASC")
                ->get();
        }


        return $query->result_array();
        //$test=$this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) AND emp_division ='$division_tid' order by emp_id")->result_array();
    }
    function getAllEmployeeByDivisionAndDepartment($division_tid, $department_id)
    {


        $query = $this->db->select('sfe.*,texo.name')
            ->from('search_field_emp sfe')
            ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
            ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')
            ->where("sfe.emp_division", $division_tid)
            ->where("sfe.emp_department", $department_id)
            ->where("sfe.content_id !='0' ")
            ->where('sfe.publication_status', 1)
            //                    ->limit($limit, $offset)
            //->order_by("sfe.emp_id + 0", "ASC")
            ->order_by("sfe.emp_id", "ASC")
            ->get();
        //$query = $this->db->select('*')->from('search_field_emp')->get();
        return $query->result_array();
    }
    public function getEmployeeInfoById($content_id, $monthId, $year, $userDivision, $userDepartment)
    {
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
        $startDate = date("Y-m-d", strtotime($monthStartDate));
        $endDate = date("Y-m-d", strtotime($monthEndDate));
        $this->db->select("ejh.content_id,ejh.division_tid,ejh.department_tid,ejh.post_tid,ejh.grade_tid,ejh.emp_type_tid,sfe.joining_date, "
            . "(SELECT start_date FROM emp_job_history z WHERE z.id=MIN(ejh.id)) as start_date,"
            . "(SELECT end_date FROM emp_job_history z WHERE z.id=MAX(ejh.id)) as end_date");
        $this->db->from('emp_job_history AS ejh');
        $this->db->join('taxonomy AS texo', 'ejh.post_tid = texo.tid', 'LEFT');
        $this->db->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT');
        if ($userDivision) {
            $this->db->where("ejh.division_tid", $userDivision);
        }
        if ($userDepartment) {
            $this->db->where("ejh.department_tid", $userDepartment);
        }
        $this->db->where("(STR_TO_DATE(ejh.start_date, '%d-%m-%Y') <='$startDate' OR STR_TO_DATE(ejh.start_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE);
        $this->db->where("(STR_TO_DATE(ejh.end_date, '%d-%m-%Y') >='$endDate' OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y') IS NULL OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y')='' OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE);
        $this->db->where("ejh.content_id =$content_id AND ejh.emp_type_tid !='153' AND ejh.emp_type_tid !='473' ");
        $this->db->group_by("ejh.content_id,ejh.division_tid,ejh.department_tid");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getEmployeeInfoFromJobHostoryById($empContentId, $monthId, $year)
    {
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
        $startDate = date("Y-m-d", strtotime($monthStartDate));
        $endDate = date("Y-m-d", strtotime($monthEndDate));
        $query = $this->db->select("sfe.emp_name,ejh.content_id,ejh.division_tid,ejh.department_tid,ejh.department_id,ejh.post_tid,ejh.grade_tid,ejh.emp_type_tid,sfe.joining_date, "
            . "(SELECT start_date FROM emp_job_history z WHERE z.id=MIN(ejh.id)) as start_date,"
            . "(SELECT end_date FROM emp_job_history z WHERE z.id=MAX(ejh.id)) as end_date")
            ->from('emp_job_history ejh')
            ->join('taxonomy AS texo', 'ejh.post_tid = texo.tid', 'LEFT')
            ->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT')
            ->where("ejh.content_id", $empContentId)
            ->where("(STR_TO_DATE(ejh.start_date, '%d-%m-%Y') <='$startDate' OR STR_TO_DATE(ejh.start_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("(STR_TO_DATE(ejh.end_date, '%d-%m-%Y') >='$endDate' OR ejh.end_date IS NULL OR ejh.end_date='' OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("ejh.content_id !='0' AND ejh.emp_type_tid !='153' AND ejh.emp_type_tid !='473' ")
            ->where("sfe.status", 1) // 0= locked
            ->order_by("ejh.id", "ASC")
            ->group_by("ejh.content_id,ejh.division_tid,ejh.department_tid")
            ->get();
        //       $query = $this->db->select("date")->where("month(STR_TO_DATE(start_date, '%Y-%m-%d'))=4")->from('emp_job_history')->get();
        return $query->row_array();
    }

    public function getEmployeeByCompany($empCompany, $monthId, $year)
    {
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
        $startDate = date("Y-m-d", strtotime($monthStartDate));
        $endDate = date("Y-m-d", strtotime($monthEndDate));
        $query = $this->db->select("sfe.emp_id,sfe.emp_name,ejh.content_id,ejh.division_tid,ejh.department_tid,ejh.department_id,ejh.post_tid,ejh.grade_tid,ejh.emp_type_tid,sfe.joining_date, "
            . "(SELECT start_date FROM emp_job_history z WHERE z.id=MIN(ejh.id)) as start_date,"
            . "(SELECT end_date FROM emp_job_history z WHERE z.id=MAX(ejh.id)) as end_date")
            ->from('emp_job_history ejh')
            ->join('taxonomy AS texo', 'ejh.post_tid = texo.tid', 'LEFT')
            ->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT')
            ->where("ejh.division_tid", $empCompany)
            ->where("(STR_TO_DATE(ejh.start_date, '%d-%m-%Y') <='$startDate' OR STR_TO_DATE(ejh.start_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("(STR_TO_DATE(ejh.end_date, '%d-%m-%Y') >='$endDate' OR ejh.end_date IS NULL OR ejh.end_date='' OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("ejh.content_id !='0' AND ejh.emp_type_tid !='153' AND ejh.emp_type_tid !='473' ")
            ->where("sfe.status", 1) // 0= locked
            ->order_by("ejh.id", "ASC")
            ->group_by("ejh.content_id,ejh.division_tid")
            ->get();
        //       $query = $this->db->select("date")->where("month(STR_TO_DATE(start_date, '%Y-%m-%d'))=4")->from('emp_job_history')->get();
        return $query->result_array();
    }
    public function getEmployeeByCompanyAndDivision($empCompany, $empDivision, $monthId, $year)
    {
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
        $startDate = date("Y-m-d", strtotime($monthStartDate));
        $endDate = date("Y-m-d", strtotime($monthEndDate));
        $query = $this->db->select("sfe.emp_id,sfe.emp_name,ejh.content_id,ejh.division_tid,ejh.department_tid,ejh.department_id,ejh.post_tid,ejh.grade_tid,ejh.emp_type_tid, "
            . "(SELECT start_date FROM emp_job_history z WHERE z.id=MIN(ejh.id)) as start_date,"
            . "(SELECT end_date FROM emp_job_history z WHERE z.id=MAX(ejh.id)) as end_date,"
            . "sfe.emp_name,sfe.emp_name,texo.name,sfe.joining_date")
            ->from('emp_job_history as ejh')
            ->join('taxonomy AS texo', 'ejh.post_tid = texo.tid', 'LEFT')
            ->join('search_field_emp AS sfe', 'sfe.content_id = ejh.content_id', 'LEFT')
            ->where("ejh.division_tid", $empCompany)
            ->where("ejh.department_tid", $empDivision)
            ->where("(STR_TO_DATE(ejh.start_date, '%d-%m-%Y') <='$startDate' OR STR_TO_DATE(ejh.start_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("(STR_TO_DATE(ejh.end_date, '%d-%m-%Y') >='$endDate' OR ejh.end_date IS NULL OR ejh.end_date='' OR STR_TO_DATE(ejh.end_date, '%d-%m-%Y') BETWEEN  '$startDate' AND '$endDate' )", NULL, FALSE)
            ->where("ejh.content_id !='0' AND ejh.emp_type_tid !='153' AND ejh.emp_type_tid !='473' ")
            ->where("sfe.status", 1) // 0= locked
            //            ->where("ejh.content_id",576)
            ->order_by("ejh.id", "ASC")
            ->group_by("ejh.content_id,ejh.division_tid,ejh.department_tid")
            ->get();
        //       $query = $this->db->select("date")->where("month(STR_TO_DATE(start_date, '%Y-%m-%d'))=4")->from('emp_job_history')->get();
        return $query->result_array();
    }
    public function getEmpSalaryDeductInfoById($content_id)
    {
        return $this->db->query("SELECT * FROM emp_salary_deduction WHERE content_id=$content_id ORDER BY id DESC LIMIT 1")->row();
    }
    public function getEmpPaymentMethodInfoById($content_id)
    {
        return $this->db->query("SELECT * FROM emp_payment_method WHERE content_id=$content_id ORDER BY id DESC LIMIT 1")->row();
    }

    public function getLoanInfoByContentId($contentId, $monthId, $year)
    {
        return $this->db->query("SELECT ld.*,l.content_id,l.id as loan_id FROM tbl_loan_disbursement AS ld LEFT JOIN tbl_loan_advance AS l ON ld.loan_id=l.id WHERE"
            . " l.content_id=$contentId AND ld.status=0"
            . " AND ld.repayment_from=1"
            . " AND MONTH(payment_date)=$monthId"
            . " AND YEAR(payment_date)=$year"
            . " ORDER BY ld.id LIMIT 1")->row();
    }
    public function getPaySlipExist($emp_content_id, $empCompanyId, $empDivisionId, $monthId, $year)
    {
        return $this->db->query("SELECT * FROM tbl_payroll "
            . "WHERE content_id=$emp_content_id AND "
            . "company_id=$empCompanyId AND "
            . "division_id=$empDivisionId AND "
            . "month_id=$monthId AND year=$year "
            . "ORDER BY id DESC LIMIT 1")->row();
    }
    public function insertPayslipGeneratorData($paramsData)
    {
        return $this->db->insert("tbl_payroll", $paramsData);
    }
    public function insertPayslipPaymentData($paramsData)
    {
        $this->db->insert("tbl_payroll_payment", $paramsData);
        $paymentId = $this->db->insert_id();
        return $paymentId;
    }
    public function insertPaymentTransData($paramsData)
    {
        return $this->db->insert("tbl_transactions", $paramsData);
    }
    public function insertSalaryIncrementData($paramsData)
    {
        return $this->db->insert("emp_salary", $paramsData);
    }
    public function updatePayslipGeneratorData($data = array(), $where = array())
    {
        $this->db->where($where);
        $this->db->update('tbl_payroll', $data);
        return true;
    }
    public function getMonths()
    {
        return $this->db->query("SELECT * FROM tbl_month")->result();
    }
    public function getBanks($vid)
    {
        return $this->db->query("SELECT * FROM taxonomy WHERE vid='$vid' ORDER BY name ASC")->result();
    }
    public function getAccounts()
    {
        return $this->db->query("SELECT * FROM tbl_accounts WHERE Status=1 ORDER BY SerialOrder")->result();
    }


    public function getPaySlip($searchpage, $search_query)
    {
       
        if ($search_query) {
            $this->db->select('payroll.*,grade.grade_name,sfe.emp_id,sfe.emp_name,sfe.gender,sfe.joining_date,religion.name AS religion_name,company.keywords AS company_name,division.name AS division_name,designation.name AS designation_name,
            bank.name as bank_name,payment_method.branch_name,payment_method.bank_account_no');
            $this->db->from('tbl_payroll as payroll');
            $this->db->join('search_field_emp as sfe', 'sfe.content_id = payroll.content_id', 'left');
            $this->db->join('taxonomy as company', 'company.tid = payroll.company_id', 'left');
            $this->db->join('taxonomy as division', 'division.tid = payroll.division_id', 'left');
            $this->db->join('taxonomy as designation', 'designation.tid = sfe.emp_post_id', 'left');
            $this->db->join('taxonomy as religion', 'religion.tid = sfe.religion', 'left');
            $this->db->join('tbl_salary_grades as grade', 'grade.id = payroll.grade_id', 'left');
            $this->db->join('emp_payment_method as payment_method', 'payment_method.content_id = sfe.content_id', 'left');            
            $this->db->join('taxonomy as bank', 'bank.tid = payment_method.bank_id', 'left');
            $this->db->where($search_query, NULL, FALSE);
            $this->db->order_by('payroll.grade_id', 'ASC');
            $query = $this->db->get();
            if (count($query) > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    public function getSeletedPayslip($paySlips)
    {
        
        if ($paySlips) {
            $this->db->select('payroll.*,sfe.emp_id,sfe.emp_name,sfe.gender,sfe.joining_date,
            religion.name AS religion_name,company.keywords AS company_name,
            division.name AS division_name,designation.name AS designation_name,
            bank.name as bank_name,payment_method.branch_name,payment_method.bank_account_no');
            $this->db->from('tbl_payroll as payroll');
            $this->db->join('search_field_emp as sfe', 'sfe.content_id = payroll.content_id', 'left');
            $this->db->join('taxonomy as company', 'company.tid = payroll.company_id', 'left');
            $this->db->join('taxonomy as division', 'division.tid = payroll.division_id', 'left');
            $this->db->join('taxonomy as designation', 'designation.tid = sfe.emp_post_id', 'left');
            $this->db->join('taxonomy as religion', 'religion.tid = sfe.religion', 'left');
            $this->db->join('emp_payment_method as payment_method', 'payment_method.content_id = sfe.content_id', 'left');            
            $this->db->join('taxonomy as bank', 'bank.tid = payment_method.bank_id', 'left');
            $this->db->where_in('payroll.id', $paySlips);
            $this->db->order_by('sfe.emp_name', 'ASC');
            $query = $this->db->get();
            if (count($query) > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }
    public function getTaxonomyNameByTid($tid)
    {
        $result = $this->db->query("SELECT name FROM taxonomy WHERE tid='$tid' ")->row();
        return $result->name;
    }
    public function getPaySlipInfoById($id)
    {
        return $this->db->query("SELECT * FROM tbl_payroll WHERE id='$id' ")->row();
    }
    public function getPaySlipData($id)
    {
        return $this->db->query("SELECT p.*,sfe.emp_id,sfe.emp_name,sfe.mobile_no,sfe.gender,sfe.joining_date,religion.name as religion,m.month_name,company.name AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name"
            . " FROM tbl_payroll as p"
            . " LEFT JOIN search_field_emp as sfe ON sfe.content_id=p.content_id"
            . " LEFT JOIN tbl_month as m ON m.month_id=p.month_id"
            . " LEFT JOIN taxonomy as company ON company.tid = p.company_id"
            . " LEFT JOIN taxonomy as division ON division.tid = p.division_id"
            . " LEFT JOIN taxonomy as department ON department.tid = p.department_id"
            . " LEFT JOIN taxonomy as designation ON designation.tid = p.emp_post_id"
            . " LEFT JOIN taxonomy as religion ON religion.tid = sfe.religion"
            . " WHERE p.id=$id ")->row();
    }
    function getSalaryCerticatePayslipInfo($content_id, $salaryFromMonthId, $salaryFromYear, $salaryToMonthId, $salaryToYear)
    {
        return $this->db->query("SELECT SUM(basic) as total_basic,SUM(hra) as total_hra,SUM(ma) as total_ma,SUM(ta) as total_ta,SUM(festival_bonus) as total_festival_bonus,SUM(tax) as total_tax,SUM(pfa) AS pf FROM tbl_payroll "
            . "WHERE content_id=$content_id "
            . "AND (year > $salaryFromYear OR (year = $salaryFromYear AND month_id >= $salaryFromMonthId)) "
            . "AND (year < $salaryToYear OR (year = $salaryToYear AND month_id <= $salaryToMonthId)) "
            . "GROUP BY content_id")->row();
        //        return $this->db->query("SELECT basic,hra,ma,ta,bonus,total FROM tbl_payroll "
        //                . "WHERE content_id=$content_id AND "
        //                . "year BETWEEN $salaryFromYear AND $salaryToYear AND month_id BETWEEN $salaryFromMonthId AND $salaryToMonthId")->result();
    }
    public function getPaymentDetailData($id)
    {
        return $this->db->query("SELECT * FROM tbl_payroll_payment WHERE payroll_id=$id ")->result();
    }
    public function getLoanDisbursementInfoById($id)
    {
        return $this->db->query("SELECT * FROM tbl_loan_disbursement WHERE id='$id' ORDER BY id LIMIT 1 ")->row();
    }
    public function updateLoanInfo($loanId, $amount)
    {
        $query = "UPDATE tbl_loan_advance SET paid_installment=paid_installment+1,balance=balance-$amount WHERE id=$loanId ";
        $this->db->query($query);
        return true;
    }
    public function updateAccountBalance($accountId, $amount)
    {
        $query = "UPDATE tbl_accounts SET Balance=Balance-$amount WHERE ID=$accountId ";
        $this->db->query($query);
        return true;
    }
    public function updateLoanDisbursementInfo($id)
    {
        $query = "UPDATE tbl_loan_disbursement SET status=1 WHERE id=$id ";
        $this->db->query($query);
        return true;
    }
    public function deletePayslipById($id)
    {
        $query = "DELETE FROM tbl_payroll WHERE id=$id ";
        $this->db->query($query);
        return true;
    }
    function getAccountsByAcountGroupId($id)
    {
        if ($id) {
            return $this->db->query("select * from tbl_accounts WHERE AccountGroupId='$id' order by ID ASC")->result();
        }
    }
    function getContentId($empId)
    {
        if ($empId) {
            return $this->db->query("SELECT id FROM employee_id WHERE emp_id='$empId' ORDER BY id DESC LIMIT 1")->row();
        }
    }
    function getPresentSalary($id)
    {
        if ($id) {
            return $this->db->query("SELECT gross_salary FROM emp_salary WHERE content_id=$id ORDER BY id DESC LIMIT 1")->row();
        }
    }

    public function updateMultiplePayslip($updateData = array(), $ids)
    {
        $count = 0;
        foreach ($ids as $id) {
            $this->db->where("id", $id);
            $this->db->update('tbl_payroll', $updateData);
            $count = $count + 1;
        }

        echo $count . ' payslips status have been updated successfully!';
        $count = 0;
    }
    public function deleteMultiplePayslip($ids)
    {
        $count = 0;
        foreach ($ids as $id) {
            $this->db->where("id", $id);
            $this->db->delete('tbl_payroll');
            $count = $count + 1;
        }

        echo $count . ' payslips have been deleted successfully.';
        $count = 0;
    }
    function getEmployeeDeductionByDivision($division_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,esd.tax_deduction,esd.provident_fund_deduction,esd.other_deduction,esd.total_deduction')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('emp_salary_deduction AS esd', 'esd.content_id = sfe.content_id', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }
    function getEmployeeDeductionByDivisionAndDepartment($division_tid, $department_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,esd.tax_deduction,esd.provident_fund_deduction,esd.other_deduction,esd.total_deduction')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('emp_salary_deduction AS esd', 'esd.content_id = sfe.content_id', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->where('sfe.emp_department', $department_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }

    function getEmployeeAllowanceByDivision($division_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,es.basic_salary,es.house_rent,es.medical_allow,es.conveyance_allow,es.telephone_allow,es.special_allowa,es.provident_allow,es.transport_allow,es.other_allow,es.performance_bonus,es.festival_bonus')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }
    function getEmployeeAllowanceByDivisionAndDepartment($division_tid, $department_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,es.basic_salary,es.house_rent,es.medical_allow,es.conveyance_allow,es.telephone_allow,es.special_allowa,es.provident_allow,es.transport_allow,es.other_allow,es.performance_bonus,es.festival_bonus')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->where('sfe.emp_department', $department_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }
    function getEmployeePaymentMethodByDivision($division_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,sfe.tin,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,epm.*,tblBank.name AS bankName,tblPaymentMethod.name AS paymentMethod')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->join('taxonomy AS tblBank', 'tblBank.tid = epm.bank_name', 'LEFT')
            ->join('taxonomy AS tblPaymentMethod', 'tblPaymentMethod.tid = epm.emp_pay_type', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }
    function getEmployeePaymentMethodByDivisionAndDepartment($division_tid, $department_tid)
    {
        $query = $this->db->select('sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.type_of_employee,sfe.tin,epm.emp_bank_account,t.keywords AS company,t2.name AS designation,epm.*,tblBank.name AS bankName,tblPaymentMethod.name AS paymentMethod')
            ->from('search_field_emp AS sfe')
            ->join('emp_payment_method AS epm', 'epm.content_id = sfe.content_id', 'LEFT')
            ->join('taxonomy AS t', 't.tid = sfe.emp_division', 'LEFT')
            ->join('taxonomy AS t2', 't2.tid = sfe.emp_post_id', 'LEFT')
            ->join('taxonomy AS tblBank', 'tblBank.tid = epm.bank_name', 'LEFT')
            ->join('taxonomy AS tblPaymentMethod', 'tblPaymentMethod.tid = epm.emp_pay_type', 'LEFT')
            ->where('sfe.emp_division', $division_tid)
            ->where('sfe.emp_department', $department_tid)
            ->order_by("sfe.emp_name", "ASC")
            ->get();
        return $query->result();
    }

    function getActiveBankName()
    {
        $query = $this->db->query('SELECT * FROM taxonomy WHERE vid=10');
        return $query->result();
    }
    function getActivePaymentMethod()
    {
        $query = $this->db->query('SELECT * FROM taxonomy WHERE vid=9');
        return $query->result();
    }
    function getPayslipByEmployeeId($empContentId, $year)
    {
        //         $result = $this->db->query("SELECT * FROM tbl_payroll WHERE content_id=$empContentId AND year=$year ORDER BY month_id ASC")->result();
        if ($empContentId) {
            $this->db->select('payroll.*,sfe.emp_id,sfe.emp_name,sfe.gender,sfe.joining_date,religion.name AS religion_name,company.keywords AS company_name,division.name AS division_name,designation.name AS designation_name,month.month_name');
            $this->db->from('tbl_payroll as payroll');
            $this->db->join('search_field_emp as sfe', 'sfe.content_id = payroll.content_id', 'left');
            $this->db->join('taxonomy as company', 'company.tid = payroll.company_id', 'left');
            $this->db->join('taxonomy as division', 'division.tid = payroll.division_id', 'left');
            $this->db->join('taxonomy as designation', 'designation.tid = sfe.emp_post_id', 'left');
            $this->db->join('taxonomy as religion', 'religion.tid = sfe.religion', 'left');
            $this->db->join('tbl_month as month', 'month.id = payroll.month_id', 'left');
            $this->db->join('emp_payment_method as payment_method', 'payment_method.content_id = sfe.content_id', 'left');
            $this->db->where('payroll.content_id', $empContentId);
            $this->db->where('payroll.year', $year);
            $this->db->order_by('payroll.month_id', 'ASC');
            $query = $this->db->get();
            if (count($query) > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }
}
