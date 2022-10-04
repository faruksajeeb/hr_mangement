<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_model extends CI_Model {

	public function albumUpload($album_data) {

		$this -> db -> insert('album', $album_data);

		return $this -> db -> insert_id();

	}

	public function galleryUpload($gallery_data) {

		$this -> db -> insert('gallery', $gallery_data);

	}
	
	public function getAlbumall($title){
		
		return $this->db->like('title',$title)->get('album')->result_array();
	}
	
	public function countTable($table){
	
	return $this->db->count_all($table);
}

	public function getalbum() {

		return $this -> db -> where('is_cover', 1) -> get('album') -> result_array();

	}

	public function getAllmember() {

		return $this -> db -> get('membership') -> result_array();

	}

	public function updatemember($id, $val) {

		$this -> db -> where('id', $id) -> update('membership', $val);
		return true;

	}

	public function getMemberById($id) {

		return $this -> db -> where('id', $id) -> get('membership') -> row_array();

	}
	

	public function saveUser($data) {

		$this -> db -> insert('users', $data);

		return $this -> db -> insert_id();

	}

	public function user_group_assign($group_data) {

		$this -> db -> insert('users_groups', $group_data);

	}

	public function get_all() {

		return $this -> db -> get('users') -> result_array();
	}

	public function get_groups() {

		return $this -> db -> get('groups') -> result_array();

	}

	public function get_user($id) {

		return $this -> db -> where('id', $id) -> get('users') -> row_array();

	}

	public function get_user_group($id) {

		return $this -> db -> where('user_id', $id) -> get('users_groups') -> row_array();

	}

	public function update($data, $id) {

		$this -> db -> where('id', $id) -> update('users', $data);

	}

	public function update_group($group_data, $id) {

		$this -> db -> where('user_id', $id) -> update('users_groups', $group_data);
		return true;
	}

	public function update_account($datas, $userId) {

		$this -> db -> where('id', $userId) -> update('users', $datas);
		return true;
	}

	public function getUploadData() {

		return $this -> db -> get('file_data') -> result_array();

	}

	public function getgroupbyid($uid) {

		return $this -> db -> where('user_id', $uid) -> get('users_groups') -> row_array();
	}



	public function savePolicy($data, $table) {

		$this -> db -> insert($table, $data);

		return $this -> db -> insert_id();

	}

	public function get_all_policy_id($id) {

		return $this -> db -> where('ID', $id) -> get('policies') -> row_array();

	}

	public function updatePolicy($data, $id) {

		$this -> db -> where('ID', $id) -> update('policies', $data);
		return true;
	}

	public function delete($id, $field, $table) {

		$this -> db -> where($field, $id) -> delete($table);
		return true;
	}

	public function saveEvent($event) {

		$this -> db -> insert('event', $event);
		return true;
	}

	public function getEvents($id) {

		return $this -> db -> select('e.*, e.id as eid') -> from('event as e') -> get() -> result_array();
	}

	public function getEventByID($id) {

		return $this -> db -> where('id', $id) -> get('event') -> row_array();

	}

	public function updateEvent($id, $event) {

		$this -> db -> where('id', $id) -> update('event', $event);
		return true;
	}

	public function eventSum() {

		return $this -> db -> count_all_results('event');

	}

	public function currenteventSum() {

		return $this -> db -> where('date BETWEEN "' . date('Y-m-01') . '" AND "' . date('Y-m-31') . '"') -> count_all_results('event');

	}
public function get_alldetails_user($id){
	
	
	return $this->db->where('member_id',$id)->get('users')->row_array();
	
	
}

	public function deleteEvent($id) {

		$this -> db -> where('id', $id) -> delete('event');

		$this -> db -> where('event_id', $id) -> delete('member_event');
		return true;
	}

	public function is_going($id, $act) {

		return $this -> db -> where('member_id', $id) -> where('activities', $act) -> count_all_results('member_event');

	}

	public function saveAttendace($data) {

		$this -> db -> insert('member_event', $data);
		return true;
	}
	
	public function checkAttendance($id,$user){
		
		return $this->db->where('event_id',$id)->where('member_id',$user)->get('member_event')->row_array();
		
	}
	
	public function updateAttendance($id,$dataevent){
		
		
		$this->db->where('id',$id)->update('member_event',$dataevent);
		return true;
	}
	
	public function getPicData($id){
		
		return $this->db->where('id',$id)->get('album')->row_array();
		
	}
	
	public function resetPassword($pass,$id){
		
		$this->db->where('email',$id)->update('users',$pass);
		return true;
	}

}
?>