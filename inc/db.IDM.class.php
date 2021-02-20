<?php
class DBIDM
{

var $conn;
 
function __construct()
{
    require("ini/db.IDM.ini.php");
	$this->conn  = mysqli_connect( $server, $user, $pass );
	 
	if( $this->conn )
	{   
		if (!mysqli_select_db(  $this->conn, $dbase )            ) 		echo "<br>ERROR: DB Select<br>";
        if (!mysqli_query($this->conn ,  "set names 'utf8'"    ) ) 		echo "<br>ERROR: DB UTF8<br>";
	}
	else
	{
																		die("<b>ERROR:  IDM-DB no connection </b>");
	}
}

function getIDMuser($value, $select = "A")
{   if          ( $select == "M" ) $selector = "matrikelnr";
	else if  	( $select == "A" ) $selector = "akennung";
	
	$IDMuser ="";

	$sql_1 = "SELECT * FROM `mdl_haw_idm` WHERE `$selector` = '$value'";
	
 # die($sql_1);
  
	$result_1	= mysqli_query( $this->conn, $sql_1  );
 
	if ( $result_1 )
	{	 
		while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{	
			$IDMuser = $row;
		}
	}
   	return $IDMuser;
}

function existMatNr( $akennung )
{
	$exist = false; 

	$sql_1 = "SELECT `akennung` FROM `mdl_haw_idm` WHERE `akennung` = \"$akennung\"";
	
	$result_1	= mysqli_query( $this->conn, $sql_1  );
	if ( $result_1 )
	{	
		while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{	
			if ( $akennung == $row['akennung'] )
				$exist = true;

		}
	}
  	return $exist;
}

function setIDMuser( $IDMuser )
{
# die('SU');
#die($this->existMatNr( $IDMuser['akennung']) );
  $tmp =  '';
	if ($this->existMatNr( $IDMuser['akennung'] ))
	{ 
    if ( isset ( $IDMuser[ 'vorname'    ] )) { $tmp .=  '`vorname`		  = \'' .$IDMuser[ 'vorname'    ]. '\','; }
		if ( isset ( $IDMuser[ 'nachname'   ] )) { $tmp .=  '`nachname`	    = \'' .$IDMuser[ 'nachname'   ]. '\','; }
		if ( isset ( $IDMuser[ 'studiengang'] )) { $tmp .=  '`studiengang`	= \'' .$IDMuser[ 'studiengang']. '\','; }
		if ( isset ( $IDMuser[ 'semester'   ] )) { $tmp .=  '`semester` 	  = \'' .$IDMuser[ 'semester'   ]. '\','; }
		if ( isset ( $IDMuser[ 'department' ] )) { $tmp .=  '`department`	  = \'' .$IDMuser[ 'department' ]. '\','; }
		if ( isset ( $IDMuser[ 'mail'       ] )) { $tmp .=  '`mail` 		    = \'' .$IDMuser[ 'mail'       ]. '\','; }
		if ( isset ( $IDMuser[ 'matrikelnr' ] )) { $tmp .=  '`matrikelnr` 	= \'' .$IDMuser[ 'matrikelnr' ]. '\' '; }
 
   $sql_1 = "UPDATE `mdl_haw_idm` SET ".$tmp." WHERE `akennung`	= '".$IDMuser['akennung'] ."'";
	}
	else
	{
		$sql_1	=
			"INSERT INTO `mdl_haw_idm` (
			`akennung`, 
			`matrikelnr`, 
			`vorname`, 
			`nachname`, 
			`studiengang`, 
			`department`,
			`semester`, 
			`mail` ) 	
			
			VALUES ( 
			\"".$IDMuser['akennung']."\",
			\"".$IDMuser['matrikelnr']."\",
			\"".$IDMuser['vorname']."\", 
			\"".$IDMuser['nachname']."\", 
			\"".$IDMuser['studiengang']."\", 
			\"".$IDMuser['studiengang']."\", 
			\"".$IDMuser['semester']."\" , 
			\"".$IDMuser['mail']."\" )";
	} 

	$result_1	= mysqli_query( $this->conn, $sql_1  );
}

function setDB( $param, $IDMuser )
{
  $sql_1 = "";
	if($param['column'] == "studiengangID")
	{   
		$sql_1 = "UPDATE `mdl_haw_idm` SET `studiengang` = '".$param['value']."' WHERE `akennung` ='".$IDMuser['akennung'] ."' ";
    $result_1	= mysqli_query( $this->conn, $sql_1  );
	 
	}
	else if($param['column'] == "semester")
	{
		$sql_1 = "UPDATE `mdl_haw_idm` SET `semester` = '".$param['value']."' WHERE `akennung` ='".$IDMuser['akennung'] ."' ";
    $result_1	= mysqli_query( $this->conn, $sql_1  );
    
	}

}

function deb($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}

}

?>
