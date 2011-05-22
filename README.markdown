## ModuleBuilder

Lets you build a full module for the Bonfire (http://cibonfire.com/) app. Controllers, views, models, migrations and javascript files are build very quickly by filling out a single form

- Includes form validation
- Retain POST values on page refresh, form is auto populated with POST
- Show each field error inline.

## Install

- Drop the module into the bonfire/modules folder
- Edit the config file if required

## What now
- Navigate to the /admin/developer/modulebuilder page
- Fill in your fields on the form
- NOTE: "id" fields is added automatically
- Click Build
- You will see the list of generated files
- If generated, rename the Migrations file (adding the correct number) and move it into the db/migrations folder
- You will need to edit the generated code as required

## Configuration modulebuilder/config/modulebuilder.php

	/*
	 * Output path of the modules
	 */
	$config[ 'modulebuilder' ]['output_path'] = APPPATH."../modules/";

    /*
    * array of possible actions in the controller
    */
    $config[ 'modulebuilder' ][ 'form_action_options' ] = 'array('index' => 'List', 
														'insert' => 'Insert', 
														'update' => 'Update', 
														'delete' => 'Delete');
	
    /*
    * html tags used around the form elements
    */
	$config[ 'modulebuilder' ][ 'form_input_delimiters' ] = array('<p>','</p>');

    /*
    * html tags used around the error messages
    */
	$config[ 'modulebuilder' ][ 'form_error_delimiters' ] = array('<span class="error">', '</span>');



- [Log Issues or Suggestions](https://github.com/seandowney/bonfire_modulebuilder/issues)
- [Follow me on Twitter](http://twitter.com/downey_sean)


Acknowledgment: This spark is originally based on Ollie Rattue's http://formigniter.org/ project