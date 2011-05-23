<?php

$model = '<?php if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

class '.ucfirst($controller_name).'_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------


	/** 
	 * Get a record by id
	 *
	 * @param	integer	$id
	 * @return	mixed
	 */
	function get($id)
	{
		$query = $this->db->get_where("'.$controller_name.'", array("'.$primary_key_field.'" => $id));
			
		return $query->row_array();
	}

	/**
	 * Get all records in the database
	 *
	 * @return 	mixed
	 */
	public function get_all()
	{
		return $this->db->get("'.$controller_name.'")->result_array();
	}';


	foreach($action_names as $key => $action_name) {

		if ($action_name == 'index')
		{
			continue; 	// move onto next iteration of the loop
		}
$model .= '


	/** 
	 * function '.$action_name.'
	 *
	 * '.$action_name.' form data
	 * @param	array	$form_data
	 * @return	boolean	TRUE or FALSE
	 */
	function '.$action_name.'($form_data)
	{
		';
		if( $action_name != 'insert' && $action_name != 'add') {
			if($action_name == 'edit') {
				$action_name = 'update';
			}
			$model .= '
		$this->db->where("'.$primary_key_field.'", $form_data["'.$primary_key_field.'"]);			
		$this->db->'.$action_name.'("'.$controller_name.'", $form_data);';
		}
		else {

			$model .= '
		$this->db->insert("'.$controller_name.'", $form_data);';
		}
		$model .= '
		
		if ($this->db->affected_rows() == \'1\')
		{
			return TRUE;
		}
		
		return FALSE;
	}';
	} // end foreach
	
	$model .= '
}
';
	echo $model;
?>
