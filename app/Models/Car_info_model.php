<?php

class Car_info_model extends CI_Model {

    public function getallcar(){
 			return $this->db->query("select * from car_info order by id DESC")->result_array();
    }  
    public function getallactivecar(){
            return $this->db->query("select * from car_info WHERE Car_Status='Active' order by id DESC")->result_array();
    }      
    public function getcar_info($id){
        if($id){
 			return $this->db->query("select * from car_info WHERE id='$id' order by id DESC")->row_array();
        
    	}
    }  
    public function getemp_info($id){
        if($id){
            return $this->db->query("select * from car_emp_info WHERE id='$id' order by id DESC")->row_array();
        
        }
    }     
    function getcar_infobycardcode($car_id) {
        if($car_id){
        $query = $this->db->query("SELECT id FROM `car_info` WHERE `Car_Code`='$car_id' ORDER BY `id` DESC LIMIT 1");
        return $car_id = $query->row()->id;
        }
    }     
 
	public function updcar_infotbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('car_info', $data);
			return true;
		}
	}     
   	public function deletesinglebiodocuments($content_id, $repeat_id) {
		if($content_id && $repeat_id){
			$field_name="resources/uploads/cars/documents";
			$this->db->delete('car_documents', array('field_name' => $field_name,'car_id' => $content_id,'field_repeat' => $repeat_id)); 
		}
	}  
    public function deletedriverdocuments($content_id, $repeat_id) {
        if($content_id && $repeat_id){
            $field_name="resources/uploads/cars/drivers/documents";
            $this->db->delete('emp_details', array('field_name' => $field_name,'content_id' => $content_id,'field_repeat' => $repeat_id)); 
        }
    }       
	public function getbiodocumentsrepeatid($content_id) {
			if($content_id){
				return $this->db->query("select field_repeat from car_documents WHERE field_name LIKE '%resources/uploads/cars/documents' and car_id ='$content_id' ORDER BY `field_repeat` DESC")->row_array();
			}
		} 
    public function getdriverdocumentsrepeatid($content_id) {
            if($content_id){
                return $this->db->query("select field_repeat from emp_details WHERE field_name LIKE '%resources/uploads/cars/drivers/documents' and content_id ='$content_id' ORDER BY `field_repeat` DESC")->row_array();
            }
        } 		
	public function updContenttbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('car_documents', $data);
			return true;
		}
	}	
	public function getcontentByidandname($content_id, $field_name) {
		if($content_id && $field_name){
			return $this->db->query("select * from car_documents WHERE car_id ='$content_id' and field_name='$field_name'")->result_array();
		}
	}  	  
    public function getdriverimgByidandname($content_id, $field_name) {
        if($content_id && $field_name){
            return $this->db->query("select * from emp_details WHERE content_id ='$content_id' and field_name='$field_name'")->result_array();
        }
    }
	function getallcontentByid($content_id) {
		if($content_id){
			return $this->db->query("select * from car_documents WHERE car_id ='$content_id'")->result_array();
		}
	}
	public function getsinglebiodocuments($content_id) {
		if($content_id){
			return $this->db->query("select * from car_documents WHERE field_name LIKE '%resources/uploads/cars/documents' and car_id ='$content_id'")->result_array();
		}
	} 
    public function getdriverdocuments($content_id) {
        if($content_id){
            return $this->db->query("select * from emp_details WHERE field_name LIKE '%resources/uploads/cars/drivers/documents' and content_id ='$content_id'")->result_array();
        }
    } 
    public function search_record_count($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
            ->from('car_info')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    }

    public function getsearchQuery($searchpage) {
        if($searchpage){
            $user_id = $this->session->userdata('user_id');
            $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
            return $this->db->query($search_query)->row_array();
        }
    }    

    function get_all_data($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_info')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("id", "DESC") 
                    ->get();
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    function get_all_carlist($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_info')
                    ->where($abb, NULL, FALSE)
                    ->order_by("id", "DESC") 
                    ->get();
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }    
    public function driver_record_count() {
        $abb = " driver_status !='Inactive' ";
        if ($abb) {
            $query = $this->db->select('*')
            ->from('car_emp_info')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    } 
    function get_all_driver_data($limit = NULL, $offset = NULL) {
        $abb = " driver_status !='Inactive' ";
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_emp_info')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("id", "DESC") 
                    ->get();
        }
        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }    
    public function updanytbl($data = array(), $where = array(), $tblname) {
        if($data && $where && $tblname){
            $this->db->where($where);
            $this->db->update($tblname, $data);
            return true;
        }
    }  
    public function getcost_info($id){
        if($id){
            return $this->db->query("select * from car_cost WHERE id='$id' order by id DESC")->row_array();
        
        }
    } 
    function getcarcostbycolumn($column){
        return $this->db->query("select DISTINCT($column) as record from car_cost order by id DESC")->result_array();
    }
    function getalltransportemployee() {
            return $this->db->query("select * from search_field_emp WHERE type_of_employee !='153' AND emp_post_id IN (95, 56, 434, 42, 78) order by grade")->result_array();
    } 
    function getcarinfonotduplicate($column){
        return $this->db->query("select DISTINCT($column) as record from car_info order by id DESC")->result_array();
    }
     public function getrequisition_info($id){
        if($id){
            return $this->db->query("select * from car_requisition WHERE id='$id' order by id DESC")->row_array();
        
        }
    } 

    public function data_count($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
            ->from('car_cost')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    } 
    function get_all_record($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_cost')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("id", "DESC") 
                    ->get();
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }  
    function get_all_carcost($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_cost')
                    ->where($abb, NULL, FALSE)
                    ->order_by("id", "DESC") 
                    ->get();
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }     
    function getcarrequester($column){
        return $this->db->query("select DISTINCT($column) as record from car_requisition order by id DESC")->result_array();
    }
   public function search_requisition_count($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
            ->from('car_requisition')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    } 
   function get_all_requisition_data($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('car_requisition')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("id", "DESC") 
                    ->get();
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }       
}	

?>