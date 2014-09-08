<?php
class Task_model extends MY_Model {
	public function __construct() {
		$this->load->database();
	}

	public function collect_task($userId, $task)
	{		
		$data = array(
			'title' => $task,
			'userId' => $userId
		);
		
		$this->db->insert('task', $data);
		$id = $this->db->insert_id();
		
		return $id;
	}
	
	public function count_for_processing($userId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('contextId', NULL);
		$this->db->where('finished', NULL);
		$this->db->from('task');
		return $this->db->count_all_results();
	}
	
	public function get_next_for_processing($userId)
	{
		$this->db->order_by('id', 'desc');
		$this->db->limit(1, 0);
		$this->db->where('userId', $userId);
		$this->db->where('contextId', NULL);		
		$this->db->where('finished', NULL);
		$query = $this->db->get('task');
		
		return $query->row_array();
	}
	
	private function update_task($userId, $taskId, $data)
	{
		$this->db->where('id', $taskId);
		$this->db->where('userId', $userId);
		$this->db->update('task', $data);
	}
	
	public function set_context($userId, $taskId, $contextId) 
	{
		$this->update_task($userId, $taskId, array(
			'contextId' => $contextId
		));		
	}

	public function delete($userId, $taskId)
	{
		$this->db->where('id', $taskId);
		$this->db->where('userId', $userId);
		$this->db->delete('task');		
	}
	
	public function finish($userId, $taskId)
	{
		$this->db->set('finished', 'NOW()', FALSE);
		$this->update_task($userId, $taskId, array());		
	}
	
	public function reprocess($userId, $taskId)
	{
		$this->update_task($userId, $taskId, array('contextId' => NULL));
	}
	
	public function get_list($userId)
	{
		$this->db->join('context', 'context.id = task.contextId');
		$this->db->where('task.finished', NULL);
		$this->db->where('task.userId', $userId);
		$this->db->select('task.*, context.active');
		$this->db->order_by('task.id', 'desc');
		$query = $this->db->get('task');
		
		return $query->result_array();
	}
		
	public function get($userId, $taskId)
	{
		$this->db->where('id', $taskId);
		$this->db->where('userId', $userId);
		$query = $this->db->get('task');
		return $query->row_array();
	}

	public function select($query = FALSE, $exclude = FALSE, $limit = FALSE, $start = FALSE)
	{
		if ($query != FALSE)
		{
			$this->db->like('name', $query, 'after');
		}
		
		if ($exclude != FALSE)
		{
			$this->db->where('id !=', $exclude);
		}		
		
		if ($limit != FALSE)
		{
			$this->db->limit($limit, $start);
		}
		
		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('user');
		return $query->result_array();
	}
	
	public function get_random()
	{
		$this->db->order_by('RAND()');
		$this->db->limit(1, 0);
		$query = $this->db->get('user');
		return $query->row_array();		
	}
	
	public function get_userid($provider, $uid)
	{
		$this->db->select('user_id');
		$query = $this->db->get_where('user_login', array('provider' => $provider, 'uid' => $uid));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		$row = $query->row_array();
		return $row['user_id'];
	}

	public function get_login_user($provider, $uid)
	{
		$this->db->select('user.*');
		$this->db->join('user', 'user.id = user_login.user_id');

		$query = $this->db->get_where('user_login', array('provider' => $provider, 'uid' => $uid));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		return $query->row_array();
	}

	public function update_user($provider, $uid, $name, $email, $image)
	{		
		$data = array(
			'name' => $name,
			'email' => $email,
			'image' => $image
		);
		
		$id = $this->get_userid($provider, $uid);
		
		if ($id !== FALSE)
		{
			$this->db->where(array('id' => $id));
			$this->db->update('user', $data);
		}
		
		return $id;
	}
		
	public function get_user($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		
		return $query->row_array();
	}
	
	public function update_profile($id, $name, $bio)
	{
		$data = array(
			'name' => $name,
			'bio' => $bio
		);
		
		$this->db->where('id', $id);
		$this->db->update('user', $data);
	}
}
