<?PHP
function tiny_editor($name, $value = '') 
{
	if ( ! is_array($name) ) 
	{
		$name = array('name' => $name, 'class' => 'tiny');
	}
	
	if ( ! isset($name['class']) )
	{
		$name['class'] = 'tiny';
	}
	
	$editor = '<textarea';
	
	foreach ($name as $k=>$v)
	{
		$editor .= " $k=\"$v\"";		
	}

	$editor .= '>' . $value . '</textarea>';	
	
	return $editor;
}

function tiny_mce() 
{
	$result = '<script type="text/javascript" src="' . base_url() . '/javascript/tiny_mce/jquery.tinymce.js"></script>' .
						'<script type="text/javascript">' .
						'$(function() {$(\'textarea.tiny\').tinymce({script_url : \'' . base_url() . '/javascript/tiny_mce/tiny_mce.js\'});	});' .
						'</script>';
	return $result;
}
