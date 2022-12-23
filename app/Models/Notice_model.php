<?php

class Notice_model extends CI_Model
{

    public function getAllNotice()
    {
        $this->db->select('*')->from('tbl_notice');
        $this->db->where('DeletionStatus', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function insert_notice_info($data)
    {
        $result = $this->db->insert("tbl_notice", $data);
        return $result;
    }
    public function update_status_info($id, $data)
    {
        $this->db->where("NoticeID", $id);
        $this->db->update('tbl_notice', $data);
        return true;
    }
    public function select_notice_detail_by_id($id)
    {
        $this->db->select('*')->from('tbl_notice');
        $this->db->where('NoticeID', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function update_notice_deletion_status_info($id)
    {
        $this->db->set('PublicationStatus', 0);
        $this->db->set('DeletionStatus', 1);
        $this->db->where("NoticeID", $id);
        $this->db->update('tbl_notice');
        return true;
    }
    public function getAllTrashNotice()
    {
        $this->db->select('*')->from('tbl_notice');
        $this->db->where('DeletionStatus = 1');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function restore_notice($id)
    {
        $this->db->set('PublicationStatus', 0);
        $this->db->set('DeletionStatus', 0);
        $this->db->where("NoticeID", $id);
        $this->db->update('tbl_notice');
        return true;
    }
    public function delete_notice($id)
    {
        $this->db->where("NoticeID", $id);
        $this->db->delete('tbl_notice');
        return true;
    }
    public function edit_notice_info($id, $data)
    {
        $this->db->where('NoticeID', $id);
        $this->db->update('tbl_notice', $data);
        return true;
    }
}
