<?php
class Context_model extends MY_Model {
	public function __construct() {
		$this->load->database();
	}

	public function get_list($userId)
	{		
		$this->db->where('userId', $userId);
		$query = $this->db->get('context');
		return $query->result_array();
	}
	
	public function get_tasked($userId)
	{
		$this->db->join('context', 'context.id = task.contextId');
		$this->db->where('task.finished', NULL);
		$this->db->where('task.userId', $userId);
		$this->db->select('context.*');
		$this->db->distinct();
		$this->db->order_by('context.name');
		$query = $this->db->get('task');
		
		return $query->result_array();		
	}
	
	public function toggle($userId, $contextId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('id', $contextId);
		$this->db->set('active', 'not active', FALSE);
		$this->db->update('context');
	}
	
	public function create($userId, $name)
	{
		$data = array(
			'name' => $name,
			'userId' => $userId
		);
		
		$this->db->insert('context', $data);
		$id = $this->db->insert_id();
		
		return $id;		
	}
}