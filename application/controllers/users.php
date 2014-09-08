<?PHP

class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');		
		$this->view_data['nav'] = 'users';
	}

	public function index()
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($this->user_model->get()));					
	}

	public function select($exclude_self = FALSE)
	{
		$query = $this->input->get('q', TRUE);
		$page = $this->input->get('p', TRUE);
		
		if ($exclude_self != FALSE)
		{
			$exclude_self = $this->view_data['userid'];
		}
		$result = $this->user_model->select($query, $exclude_self, 10, ($page - 1) * 10);

		$this->output->set_content_type('application/json')->set_output(json_encode(array('more' => count($result) == 10, 'results' => $result)));
	}

	public function profile($id)
	{
		$this->load->helper('select2');

		$this->view_data['user'] = $this->user_model->get_user($id);
		
		if ($this->view_data['userid'] == $id)
		{
			$this->view_data['submenu'] = array(
				'users/edit_profile' => 'Edit profile'
			);
		}

		$this->show_view('users/profile');
	}
	
	public function edit_profile()
	{
		$this->requires_login();
		
		$this->load->helper('form');
		$this->load->helper('tiny_mce');
		$this->load->helper('select2');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('bio', 'Bio', 'xss_clean|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->view_data['css'] = array('css/select2.css');
	
			$this->view_data['user'] = $this->user_model->get_user($this->view_data['userid']);
			
			$this->show_view('users/edit_profile');	
		}
		else
		{			
			$this->user_model->update_profile($this->view_data['userid'], $this->input->post('name', TRUE), $this->input->post('bio', TRUE));
			redirect('/users/profile/' . $this->view_data['userid']);
		}
	}
}