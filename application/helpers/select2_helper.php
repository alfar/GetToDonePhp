<?PHP
function register_select2()
{
	static $registered = FALSE;
	
	if ( ! $registered )
	{
		$registered = TRUE;
		return '<script type="text/javascript" src="' . base_url() . '/javascript/select2.min.js"></script>';		
	}
	
	return '';
}

function language_select2($id, $value, $class = 'input-block-level', $allow_create = TRUE, $settings = NULL)
{
	if ($settings === NULL)
	{
		$settings = array();
	}
	$settings['ajax'] = array('url' => site_url('languages/flexbox'));
		
	$result = register_select2() . '<input type="hidden" name="' . $id . '" id="' . $id . '" class="' . $class . '" value="' . $value . '" /><script type="text/javascript">$(function() { var cfg = ' . json_encode($settings) . '; cfg.ajax.data = function(term, page) { return { "q": term, "p": page }; }; cfg.ajax.results = function(data, page) { return {"more" : data.more, "results" : $.map(data.results, function(itm) { return {"id": itm.name, "text" : itm.name}; }) };}; cfg.formatResult = function(object, container, query) { return (object["new"] !== undefined ? "<small class=\"muted\">New language: </small>" : "") + object.text; }; ' . ($allow_create ? 'cfg.createSearchChoice = function(term) { return {\'id\': term, \'new\': true, \'text\': term }; }; ' : '') . 'cfg.placeholder = \'Pick a language\'; cfg.initSelection = function(element, callback) {callback({\'id\' : element.val(), \'text\' : element.val()})}; $(\'#' . $id . '\').select2(cfg); });</script>';
	return $result;
}

function language_id_select2($id, $value, $class = 'input-block-level', $allow_create = TRUE, $settings = NULL)
{
	if ($settings === NULL)
	{
		$settings = array();
	}
	$settings['ajax'] = array('url' => site_url('languages/flexbox'));
		
	$result = register_select2() . '<input type="hidden" name="' . $id . '" id="' . $id . '" class="' . $class . '" value="' . $value . '" /><script type="text/javascript">$(function() { var cfg = ' . json_encode($settings) . '; cfg.ajax.data = function(term, page) { return { "q": term, "p": page }; }; cfg.ajax.results = function(data, page) { return {"more" : data.more, "results" : $.map(data.results, function(itm) { return {"id": itm.id, "text" : itm.name}; }) };}; cfg.formatResult = function(object, container, query) { return (object["new"] !== undefined ? "<small class=\"muted\">New language: </small>" : "") + object.text; }; ' . ($allow_create ? 'cfg.createSearchChoice = function(term) { return {\'id\': 0, \'new\': true, \'text\': term }; }; ' : '') . 'cfg.placeholder = \'Pick a language\'; cfg.initSelection = function(element, callback) {callback({\'id\' : -1, \'text\' : element.val()})}; $(\'#' . $id . '\').select2(cfg); });</script>';
	return $result;
}

function user_select2($id, $value, $class = 'input-block-level', $exclude_self = FALSE, $settings = NULL)
{
	if ($settings === NULL)
	{
		$settings = array();
	}
	$settings['ajax'] = array('url' => site_url('users/select' . ($exclude_self != FALSE ? '/1' : '')));
		
	$result = register_select2() . '<input type="hidden" name="' . $id . '" id="' . $id . '" class="' . $class . '" value="' . $value . '" /><script type="text/javascript">$(function() { var cfg = ' . json_encode($settings) . '; cfg.ajax.data = function(term, page) { return { "q": term, "p": page }; }; cfg.ajax.results = function(data, page) { return {"more" : data.more, "results" : $.map(data.results, function(itm) { return {"id": itm.id, "text" : itm.name}; }) };}; cfg.placeholder = \'Pick a user\'; $(\'#' . $id . '\').select2(cfg); });</script>';
	return $result;
}

function language_levels()
{
	static $data = array(
		'1' => 'Tarzan at a party',
		'2' => 'Getting to the party',
		'3' => 'What happened at the party?',
		'4' => 'What if parties were illegal?'
	);
	
	return $data;
}

function language_level_name($level)
{
	$data = language_levels();
	return $data[$level];
}

function language_level_link($id, $level)
{
	$data = language_levels();
	return language_level_link_handler() . '<a href="#" id="' . $id . '" data-value="' . $level . '" class="language_level_link">' . $data[$level] . '</a>';
}

function language_level_picker($id, $class, $level)
{
	$data = language_levels();
	return register_select2() . form_dropdown($id, $data, $level, 'id="' . $id . '" class="' . $class . '"');
}

function language_level_link_handler()
{
	static $registered = FALSE;
	
	if ($registered == FALSE)
	{
		$registered = TRUE;
		
		return register_select2() . '<script type="text/javascript" src="' . base_url() . 'javascript/language_level_link.js"></script>';
	}
	
	return '';
}

function kaizen_states()
{
	static $data = array(
		'0' => 'New',
		'1' => 'Under evaluation',
		'2' => 'Accepted',
		'3' => 'Rejected'
	);
	
	return $data;
}

function kaizen_state_name($state)
{
	$data = kaizen_states();
	return $data[$state];
}

function kaizen_state_link($id, $state)
{
	$data = kaizen_states();
	return kaizen_state_link_handler() . '<a href="#" id="' . $id . '" data-value="' . $state . '" class="kaizen_state_link">' . $data[$state] . '</a>';
}

function kaizen_state_picker($id, $class, $state)
{
	$data = kaizen_states();
	return register_select2() . form_dropdown($id, $data, $state, 'id="' . $id . '" class="' . $class . '"');
}

function kaizen_state_link_handler()
{
	static $registered = FALSE;
	
	if ($registered == FALSE)
	{
		$registered = TRUE;
		
		return register_select2() . '<script type="text/javascript" src="' . base_url() . 'javascript/kaizen_state_link.js"></script>';
	}
	
	return '';
}