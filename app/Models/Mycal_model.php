<?php

/**
 * 
 */
class Mycal_model extends CI_Model
{
  var $conf;
  function __construct()
  {
    // Call the Model constructor
    parent::__construct();
    $this->conf = array(
      'start_day' => 'monday',
      'show_next_prev' => true,
      'next_prev_url' => base_url() . 'leavemaster/single_leave'
    );
    $this->conf['template'] = '
    {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar" width="100%">{/table_open}

    {heading_row_start}<tr>{/heading_row_start}

    {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
    {heading_title_cell}<th colspan="{colspan}" style="text-align: center;">{heading}</th>{/heading_title_cell}
    {heading_next_cell}<th style="text-align: right;"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

    {heading_row_end}</tr>{/heading_row_end}

    {week_row_start}<tr class="days_headng">{/week_row_start}
    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
    {week_row_end}</tr>{/week_row_end}

    {cal_row_start}<tr class="days">{/cal_row_start}
    {cal_cell_start}<td class="day">{/cal_cell_start}

    {cal_cell_content}
    <div class="day_num">{day}</div>
    <div class="content">{content}</div>
    {/cal_cell_content}
    {cal_cell_content_today}
    <div class="day_num highlight">{day}</div>
    <div class="content">{content}</div>
    {/cal_cell_content_today}

    {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
    {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}

    {cal_cell_blank}&nbsp;{/cal_cell_blank}

    {cal_cell_end}</td>{/cal_cell_end}
    {cal_row_end}</tr>{/cal_row_end}

    {table_close}</table>{/table_close}
    ';
  }

  function get_calendar_data($year, $month)
  {
    $searchpage = "single_leave";
    $user_id = $this->session->userdata('user_id');
    $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
    $emp_id_query = $this->db->query($search_query)->row_array();
    $content_id = $emp_id_query['search_query'];
    $yearly_holiday = $this->db->query("select * from emp_yearlyholiday WHERE holiday_for_division='all' and holiday_start_date LIKE '%$month-$year' order by id DESC")->result_array();
    if (!$yearly_holiday) {
      $emp_info = $this->db->query("select * from search_field_emp WHERE content_id ='$content_id'")->row_array();
      $division_tid = $emp_info['emp_division'];
      $yearly_holiday = $this->db->query("select * from emp_yearlyholiday WHERE holiday_for_division='$division_tid' and holiday_start_date LIKE '%$month-$year' order by id DESC")->result_array();
    }
    $data_query = "SELECT * FROM emp_leave WHERE content_id='$content_id' AND leave_start_date LIKE '%$month-$year' order by id DESC";
    $emp_data = $this->db->query($data_query)->result_array();
	
    $cal_data = array();
    if ($yearly_holiday) {
      $combined_array = array_merge($yearly_holiday, $emp_data);
    } else {
      $combined_array = $emp_data;
    }
	
    foreach ($combined_array as $single_data) {
      $tid = $single_data['leave_type'];
      if (!$tid) {
        $tid = $single_data['holiday_type'];
      }
      $vocabulary = "SELECT * FROM taxonomy WHERE id='$tid' order by id DESC limit 1";
      $leave_query = $this->db->query($vocabulary)->row_array();
	 
      $format_date = substr($single_data['leave_start_date'], 0, 2);
      if (!$single_data['leave_start_date']) {
        $format_date = substr($single_data['holiday_start_date'], 0, 2);
      }
      $num_padded = sprintf("%d", $format_date);
	   
      $cal_data[$num_padded] = $leave_query['name'];
    }
	
    return $cal_data;
  }

  function generate($year, $month)
  {
    $this->load->library('calendar', $this->conf);
    $cal_data = $this->get_calendar_data($year, $month);
	
    return  $this->calendar->generate($year, $month, $cal_data);
  }
}
