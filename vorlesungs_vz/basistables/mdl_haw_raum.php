<?php

// Tables for this example.php see file: 'test.sql'
 $err_level = error_reporting(0);
session_start();
require_once("mte/mte.php");
$tabledit = new MySQLtabledit();

		#####################
		# required settings #
		#####################

# database settings:
$tabledit->database = 'koronaklaus';
$tabledit->host = 'localhost';
$tabledit->user = 'koronaklaus';
$tabledit->pass = 'koronaklaus';

# table of the database you want to edit:
$tabledit->table = 'raum';

# the primary key of the table (must be AUTO_INCREMENT):
$tabledit->primary_key = 'ID';

# the fields you want to see in "list view"
# Always add the primary key (`employeeNumber)`: 
#$tabledit->fields_in_list_view = array( 'ID','userID','firstname', 'lastname', 'abk', 'email' );
$tabledit->fields_in_list_view = array('ID', 'shortname', 'roomID', 'name',  'maxpers' );


# 'ID', 'shortname', 'roomID', 'name',  'maxpers'

# ## -- -- ID userID abk lastname firstname email

		#####################
		# optional settings #
		#####################

# Head of the page (<h1>head_1<h1>):
$tabledit->head_1 = "Raum";

# language ('en' for English, 'nl' for Dutch):
$tabledit->language = 'en';

# numbers of rows/records in "list view": 
$tabledit->num_rows_list_view = 100;

# required fields in edit or add record: 
$tabledit->fields_required = array(  'shortname', 'roomID', 'name',  'maxpers' );

# Fields you want to edit (remove this to edit all the fields).
#$tabledit->fields_to_edit = array('lastName','email','job');

# help texts: 
$tabledit->help_text = array(
 
 'shortname' => 'interner alphanumerischer Kurzname  ',
 'roomID' => 'fortlaufender Bezeichner im 1000 er Bereich',
 'name' => 'angezeigter Name',
 'maxpers' => 'maximal Anzahl Personen in diesem Raum'
 
);

# visible name of the fields: 
$tabledit->show_text = array(
  'shortname' => 'interner Kurzname',
  'roomID' => 'interner Bezeichner',
  'name' => 'angezeigter Name',
  'maxpers' => 'maximal Anzahl Personen'
);


# visible name of the fields in list view: 
$tabledit->show_text_listview = array(
  'shortname' => 'interner Kurzname',
  'roomID' => 'interner Bezeichner',
  'name' => 'angezeigter Name',
  'maxpers' => 'maximal Anzahl Personen'

);



# Make selectlist on inputfield based on another table
# in this example: `employees`.`job` is based on `jobs`.`jobname`: 
/*
$tabledit->lookup_table = array(
	'job' => array(
		'query' => "SELECT `id`, `jobname` FROM `jobs`;",
		'option_value' => 'id',
		'option_text' => 'jobname'
	)
);
*/

$tabledit->width_editor = '100%';
$tabledit->width_input_fields = '500px';
$tabledit->width_text_fields = '498px';
$tabledit->height_text_fields = '200px';


# warning no .htaccess ('on' or 'off'): 
$tabledit->no_htaccess_warning = 'off';

		####################################
		# connect, show editor, disconnect #
		####################################

$tabledit->database_connect();

echo "<!DOCTYPE html>
<html lang='en'>
<head>

	<meta charset='utf-8'>

	<title>Editor</title>
	</head>
	<body>
";
if ( $_SESSION['user']['ro'] >= 3 )
  $tabledit->do_it();

echo "
	</body>
	</html>"
;

$tabledit->database_disconnect();
?>
