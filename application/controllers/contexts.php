<?PHP

class Contexts extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('context_model');	
	}
		
	function toggle() {
		$context = $this->input->post('context');
		
		if ($context)
		{
			$this->context_model->toggle($this->view_data['userid'], $context);
			$this->output->set_output('true');
		}
		else
		{
			$this->output->set_output('false');
		}
	}	
}
