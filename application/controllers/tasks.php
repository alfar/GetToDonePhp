<?PHP

class Tasks extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_model');	
	}
		
	function collect() {
		$task = $this->input->post('task');
		
		if ($task)
		{
			$this->task_model->collect_task($this->view_data['userid'], $task);
			$this->output->set_output($this->task_model->count_for_processing($this->view_data['userid']));
		}
		else
		{
			$this->output->set_output(-1);
		}
	}
	
	function process() {
		$this->load->model('context_model');
		$this->view_data['task'] = $this->task_model->get_next_for_processing($this->view_data['userid']);
		$this->view_data['contexts'] = $this->context_model->get_list($this->view_data['userid']);
		$this->show_view('tasks/process');
	}
	
	function process_next() {
		$this->output->set_content_type('application/json')->set_output(json_encode($this->task_model->get_next_for_processing($this->view_data['userid'])));		
	}

	function process_delete() {
		$task = $this->input->post('task');

		$this->task_model->delete($this->view_data['userid'], $task);
		$this->process_next();
	}
	
	function process_finish() {
		$task = $this->input->post('task');

		$this->task_model->finish($this->view_data['userid'], $task);
		$this->process_next();
	}
	
	function process_context() {
		$task = $this->input->post('task');
		$context = $this->input->post('context');

		$this->task_model->set_context($this->view_data['userid'], $task, $context);
		$this->process_next();
	}

	function process_new_context() {
		$task = $this->input->post('task');
		$context = $this->input->post('name');
		
		$this->load->model('context_model');	
		$context = $this->context_model->create($this->view_data['userid'], $context);

		$this->task_model->set_context($this->view_data['userid'], $task, $context);
		$this->process_next();
	}
	
	function process_project() {
		$task = $this->input->post('task');

		$this->load->model('project_model');
		$this->project_model->convert_task($this->view_data['userid'], $task, TRUE);
				
		$this->process_next();
	}
	
	function process_someday() {
		$task = $this->input->post('task');

		$this->load->model('project_model');
		$this->project_model->convert_task($this->view_data['userid'], $task, FALSE);
				
		$this->process_next();		
	}

	function reprocess() {
		$task = $this->input->post('task');

		$this->task_model->reprocess($this->view_data['userid'], $task);
		
		$this->output->set_output('true');
	}
	
	function index() {
		$this->load->model('context_model');
		$this->view_data['contexts'] = $this->context_model->get_tasked($this->view_data['userid']);
		$this->view_data['tasks'] = $this->task_model->get_list($this->view_data['userid']);
		
		$this->show_view('tasks/do');
	}
}
