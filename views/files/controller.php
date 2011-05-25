<?php

$controller = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

class '.ucfirst($controller_name).' extends ';
$controller .= $controller_name == $module_name_lower ? "Front_controller" : "Admin_Controller";
$controller .= ' {
               
	function __construct()
	{
 		parent::__construct();
		$this->load->library(\'form_validation\');
		$this->load->helper(\'form\');
		$this->load->helper(\'url\');';
		if( $db_required ) {
		$controller .= '
		$this->load->model(\''.$module_name_lower.'_model\');';
		}
$controller .= '

		Assets::add_js($this->load->view(\''.$controller_name.'/js\', null, true), \'inline\');
	}
	
	';

	if(in_array('index', $action_names) ) {

$controller .= '
	/** 
	 * function index
	 *
	 * list form data
	 */
	function index()
	{
		Template::set(\'records\', $this->'.$module_name_lower.'_model->find_all());
		if (!Template::get("toolbar_title"))
		{
			Template::set("toolbar_title", "Manage '.$module_name.'");
		}
		Template::render();
	}
	
	';
	}
	
	if(in_array('create', $action_names) ) {
		$controller .= '
	public function create() 
	{
		if ($this->input->post(\'submit\'))
		{
			if ($this->save_'.$module_name_lower.'())
			{
				Template::set_message(\''.$module_name.' successfully created.\', \'success\');
				Template::redirect(\'/admin/'.$controller_name.'/'.$module_name_lower.'\');
			}
			else 
			{
				Template::set_message(\'There was a problem creating the '.$module_name_lower.': \'. $this->'.$module_name_lower.'_model->error, \'error\');
			}
		}
	
		Template::set(\'toolbar_title\', \'Create New '.$module_name.'\');
		Template::set_view(\''.$controller_name.'/create\');
		Template::render();
	}
			';
	}
	
	if( in_array('edit', $action_names) ) {
		$controller .= '
	public function edit() 
	{
		$id = (int)$this->uri->segment(5);
		
		if (empty($id))
		{
			Template::set_message(\'Invalid '.$module_name.' ID.\', \'error\');
			redirect(\'/admin/'.$controller_name.'/'.$module_name_lower.'\');
		}
	
		if ($this->input->post(\'submit\'))
		{
			if ($this->save_'.$module_name_lower.'(\'update\', $id))
			{
				Template::set_message(\''.$module_name.' successfully saved.\', \'success\');
			}
			else 
			{
				Template::set_message(\'There was a problem saving the '.$module_name_lower.': \'. $this->'.$module_name_lower.'_model->error, \'error\');
			}
		}
		
		Template::set(\''.$module_name_lower.'\', $this->'.$module_name_lower.'_model->find($id));
	
		Template::set(\'toolbar_title\', \'Edit '.$module_name.'\');
		Template::set_view(\''.$controller_name.'/edit\');
		Template::render();		
	}
	
			';
	}
	
	if(in_array('delete', $action_names) ) {
		$controller .= '
	public function delete() 
	{	
		$id = $this->uri->segment(5);
	
		if (!empty($id))
		{	
			if ($this->'.$module_name_lower.'_model->delete($id))
			{
				Template::set_message(\'The '.$module_name.' was successfully deleted.\', \'success\');
			} else
			{
				Template::set_message(\'We could not delete the '.$module_name_lower.': \'. $this->'.$module_name_lower.'_model->error, \'error\');
			}
		}
		
		redirect(\'/admin/'.$controller_name.'/'.$module_name_lower.'\');
	}
		';
	}
	
	$controller .= '
	public function save_'.$module_name_lower.'($type=\'insert\', $id=0) 
	{	
';
		$last_field = 0;
		for($counter=1; $field_total >= $counter; $counter++)
		{
			// only build on fields that have data entered. 
	
			//Due to the requiredif rule if the first field is set the the others must be
	
			if (set_value("view_field_label$counter") == NULL)
			{
				continue; 	// move onto next iteration of the loop
			}
			
			// we set this variable as it will be used to place the comma after the last item to build the insert db array
			$last_field = $counter;
			
			$controller .= '			
		$this->form_validation->set_rules(\''.set_value("view_field_name$counter").'\',\''.set_value("view_field_label$counter").'\',\'';
			
			// set a friendly variable name
            $validation_rules = $this->input->post('validation_rules'.$counter);

			// rules have been selected for this fieldset
            $rule_counter = 0;

            if (is_array($validation_rules))
            {       
				// add rules such as trim|required|xss_clean
				foreach($validation_rules as $key => $value)
				{
					if ($rule_counter > 0)
					{
						$controller .= '|';
					}
				
					$controller .= $value;
					$rule_counter++;
				}
            }
			
			if (set_value("db_field_length_value$counter") != NULL)
			{
				if ($rule_counter > 0)
				{
					$controller .= '|';
				}

				$controller .= 'max_length['.set_value("db_field_length_value$counter").']';
			}
			
			$controller .= "');";
		}
$controller .= '
		if ($this->form_validation->run() === false)
		{
			return false;
		}
		
		if ($type == \'insert\')
		{
			$id = $this->'.$module_name_lower.'_model->insert($_POST);
			
			if (is_numeric($id))
			{
				$return = true;
			} else
			{
				$return = false;
			}
		}
		else if ($type == \'update\')
		{
			$return = $this->'.$module_name_lower.'_model->update($id, $_POST);
		}
		
		return $return;
	}

}
';
	
	echo $controller;
?>