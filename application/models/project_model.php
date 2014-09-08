<?php
class Project_model extends MY_Model {
	public function __construct() {
		$this->load->database();
	}

	public function convert_task($userId, $taskId, $active)
	{
		$CI =& get_instance();
		$CI->load->model('task_model');
		$task = $CI->task_model->get($userId, $taskId);
		
		$data = array(
			'title' => $task['title'],
			'userId' => $userId,
			'active' => $active
		);

		$this->db->insert('project', $data);
		$id = $this->db->insert_id();
		
		$CI->task_model->delete($userId, $taskId);
		
		return $id;
	}
	
	public function get($userId, $id) 
	{
		$this->db->where('userId', $userId);
		$this->db->where('id', $id);
		$query = $this->db->get('project');
		return $query->row_array();
	}
	
	public function get_active($userId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('active', 1);
		$query = $this->db->get('project');
		return $query->result_array();		
	}
	
	public function update_project($userId, $projectId, $data)
	{
		$this->db->where('id', $projectId);
		$this->db->where('userId', $userId);
		$this->db->update('project', $data);
	}
	
	public function update_description($userId, $projectId, $description)
	{
		$this->update_project($userId, $projectId, array('description' => $description));
	}
}
