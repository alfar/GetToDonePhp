<?PHP

class Projects extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_model');	
	}
	
	function index() {
		$this->view_data['projects'] = $this->project_model->get_active($this->view_data['userid']);
		
		$this->show_view('projects/index');		
	}
	
	function view($id) {
		$this->view_data['project'] = $this->project_model->get($this->view_data['userid'], $id);
		
		$this->view_data['submenu'] = array(
			'projects/edit/' . $id => 'Edit',
		);
		$this->load->spark('markdown/1.2.0');
		$this->show_view('projects/view');			
	}
	
	function edit($id) {
		$this->view_data['project'] = $this->project_model->get($this->view_data['userid'], $id);
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		$this->form_validation->set_rules('description', 'Description', 'xss_clean|required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->show_view('projects/edit');						
		}
		else
		{			
			$this->project_model->update_project($this->view_data['userid'], $id, array('title' => $this->input->post('title', TRUE), 'description' => $this->input->post('description', TRUE)));
			redirect('/projects/view/' . $id);
		}
	}
	
	function toggle_inprogress() {
		$projectId = $this->input->post('project');
		$index = $this->input->post('index');

		$project = $this->project_model->get($this->view_data['userid'], $projectId);
		
		$toggler = new TodoToggler($index, '!', '~');
		$description = $toggler->parse($project['description']);
				
		$this->project_model->update_description($this->view_data['userid'], $projectId, $description);
	}
	
	function toggle_done() {
		$projectId = $this->input->post('project');
		$index = $this->input->post('index');

		$project = $this->project_model->get($this->view_data['userid'], $projectId);
		
		$toggler = new TodoToggler($index, '~', '#');
		$description = $toggler->parse($project['description']);
				
		$this->project_model->update_description($this->view_data['userid'], $projectId, $description);
	}
	
	function toggle_waiting() {
		$projectId = $this->input->post('project');
		$index = $this->input->post('index');

		$project = $this->project_model->get($this->view_data['userid'], $projectId);
		
		$toggler = new TodoToggler($index, '#', '!');
		$description = $toggler->parse($project['description']);
				
		$this->project_model->update_description($this->view_data['userid'], $projectId, $description);
	}
}

	class TodoToggler
	{
		public function __construct($index, $fromstate, $tostate)
		{
			$this->index = $index;
			$this->fromstate = $fromstate;
			$this->tostate = $tostate;
		}
		
		public function parse($source)
		{
			$this->i = -1;
			return preg_replace_callback('/((?:[*+-]|\d+[.])[ ]+)' . $this->fromstate . '/', array($this, 'on_match'), $source);
		}
		
		public function on_match($m)
		{
			$this->i++;
			
			if ($this->i == $this->index)
			{
				return $m[1] . $this->tostate;
			}
			
			return $m[0];
		}
	}
