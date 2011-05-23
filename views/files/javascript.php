$(document).ready(function() {
<?php foreach($action_names as $key => $action_name): ?>
<?php
		if ($action_name == 'index')
		{
			continue; 	// move onto next iteration of the loop
		}
?>
	$("#<?php echo $controller_name."_".$action_name;?>").submit(function() {
		<?php
		$last_field = 0;
		$vars = '';
		$passing_vars = '';
		$error_vars = '';
		for($counter=1; $field_total >= $counter; $counter++) {
			if (set_value("view_field_label$counter") == NULL)
			{
				continue; 	// move onto next iteration of the loop
			}
			$vars .= '
		var '. set_value("view_field_name$counter").' = $("#'. set_value("view_field_name$counter").'").val();';
			if($passing_vars != '') {
				$passing_vars .= ', ';
			}
			$passing_vars .= ''. set_value("view_field_name$counter").' : '. set_value("view_field_name$counter").'';
			$error_vars .= '
			$("#'. set_value("view_field_name$counter").'_error").html(data.'. set_value("view_field_name$counter").');';
		}
		echo $vars;
		?>
		var id_val = '';
<?php if($action_name != 'insert'): ?>
		if( typeof($("#<?php echo $primary_key_field;?>").val()) != 'undefined' ) {
			id_val = '/' + $("#<?php echo $primary_key_field;?>").val();
<?php endif; ?>
			$.post("/<?php echo $controller_name;?>/<?php echo $action_name;?>" + id_val, { <?php echo $passing_vars;?> }, function(data){
				<?php echo $error_vars;?>

			},'json');
<?php if($action_name != 'insert'): ?>
		}
<?php endif; ?>
	});
<?php endforeach;?>
});