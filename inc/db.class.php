<?php
#error_reporting(0  & ~E_DEPRECATED);

class DB
{ var $conn;
	function __construct(  )
	{ require( "ini/db.ini.php" );
    $this -> conn  = mysqli_connect( $server, $user, $pass );
  	if( $this->conn ) {	mysqli_select_db( $this -> conn, $dbase  );	}
   	else              { echo( "<b>Verbindung zur IDM-DB konnte nicht hergestellt werden </b>" ); 	}
  }
  
  function getRaumListe()
  { $sql_1 = "SELECT * FROM `raum`";
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $raum[$row['roomID']] = $row; }	}
    return $raum;
  }
  
  function getClusterListe()
  {  $sql_1 = "SELECT * FROM `cluster`";
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $cluster[$row['clusterID']] = $row; }	}
    return $cluster;
  }
  
  function getLaufwegListe()
  {  $sql_1 = "SELECT * FROM `laufweg`";
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $laufweg[$row['laufwegID']] = $row; }	}
    return $laufweg;
  }
  
  function getFluegelListe()
  {  $sql_1 = "SELECT * FROM `fluegel`";
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $fluegel[$row['fluegelID']] = $row; }	}
    return $fluegel;
  }
  
  function getEingangListe()
  {  $sql_1 = "SELECT * FROM `eingang`";
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $eingang[$row['eingangID']] = $row; }	}
    return $eingang;
  }
  
  
  
  
  function getProfessor( $dozabk )
  {  $sql_1 = "SELECT * FROM `dozenten` WHERE  `abk` = \"". trim($dozabk) ."\"";
  
    $result_1 = mysqli_query (  $this->conn, $sql_1  );
  	if ( $result_1 )   	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) ) { $dozent = $row; }	}
    $dozent[ 'abk' ] =	$dozabk;
    return $dozent;
  }
  
  function getKlausurenTable( )
  { $sql_1 = "SET lc_time_names = 'de_DE'";
    $result_1 = mysqli_query (  $this -> conn, $sql_1  );
 
    $sql_2 = "SELECT lv.name ,DATE_FORMAT(vlvz.date, \"%W\") as wt ,   vlvz.date, vlvz.time , vlvz.raum, doz.lastname,  vlvz.sem, vlvz.SG, vlvz.bemerkung,  vlvz.anzstudi1,  vlvz.anzstudi2  FROM `vl_verzeichnis` as vlvz, `lehrveranstaltungen` as lv, `dozenten` as doz WHERE lv.abk = vlvz.LVAabk AND doz.abk = vlvz.dozabk ORDER BY `date`  ASC, `time` ASC, `lastname` ASC;     ";
    $result_2 = mysqli_query (  $this -> conn, $sql_2  );
    
    while ( $row = mysqli_fetch_array( $result_2, MYSQLI_ASSOC ) )
    { $row = $this->getExtendedKlausurenTable( $row );
      $tab[] = $row;
    }
    return   $tab;
  }
  
  function getExtendedKlausurenTable($row)
  { if ($row)
    { $row[ 'rInfo' ] = '';
      $row[ 'rI'    ] = '';
        
      $raumliste = explode(',' , $row[ 'raum' ] );

      foreach($raumliste as $raumID)
      { if( $raumID != '' AND $raumID < 2000 )
        { $result2 = $this -> getRauminfoByID( $raumID );
          if ( isset( $result2 ) )
          foreach( $result2 as $k => $r )
          { if( $k == 'raum' ) { $row[ 'rI' ] .= $r."/";  }
            $row[ 'rInfo'  ] .= $r.", ";
          }
          $row[ 'rInfo' ]  .= chr(13 ).chr(10 );
        }
      }
      if ( strlen( $row[ 'rI' ] ) > 0 )
      { $row['rI'] = substr($row['rI'], 0, -1);  ## letztes Zeichen wieder entfernen
      }
   }
  return $row;
  }
  
  function getRauminfoByID( $raumID )
  { $rauminfo = null;
    $sql_1 = "SELECT `raum`, `eingang`,`laufweg`,`aufzug`,`personen` FROM `raum` WHERE `ID` =  $raumID";

    $result_1 = mysqli_query (  $this->conn, $sql_1  );
    if ( $result_1 )
    { while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
      { $rauminfo = $row;
      }
    }
    return $rauminfo;
  }

function getStudiengang( $studiengangID )
{ $studiengang = null;
  $sql_1 = "SELECT * FROM `mdl_haw_studiengaenge` WHERE  `ID` =   $studiengangID";
	$result_1 = mysqli_query (  $this->conn, $sql_1  );
	if ( $result_1 )
	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{ $studiengang = $row;
		}
	}
  return $studiengang;
}


function getVeranstaltung( $LVAabk ) // zB Mat1
{ $veranstaltung = null;
  $sql_1    = "SELECT * FROM `lehrveranstaltungen` WHERE `abk`= \"".$LVAabk ."\"";
  
	$result_1 = mysqli_query (  $this->conn, $sql_1  );
	if ( $result_1 )
	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{	$veranstaltung= $row;
		}
	}
  return $veranstaltung;
}

function getVorlesungsVerzeichnis()
{ $id = 0;
	$sql_1 = "SELECT  * FROM `klausuren` ORDER BY `dozabk`";
	$result_1 = mysqli_query (  $this->conn, $sql_1  );
	if ( $result_1 )
	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{	$tmp[ 'ID' ] 				      	= "";
	 		$tmp[ 'professor' ] 	  		= "";
			$tmp[ 'studiengang' ] 			= "";
			$tmp[ 'veranstaltung' ] 		= "";
			$tmp[ 'semester' ] 		     	= "";
			$tmp[ 'anzStudenten' ]			= "";
 
			$tmp[ 'ID' ] 					      = $row[ 'ID' ];
			$tmp[ 'professor' ] 			  = $this->getProfessor( $row[ 'professorID' ] );
 			$tmp[ 'studiengang' ] 			= $this->getStudiengang( $row[ 'studiengangID' ] );
 			$tmp[ 'veranstaltung' ] 		= $this->getVeranstaltung( $row[ 'veranstaltungID' ] );
 			$tmp[ 'semester' ] 			    = $row[ 'semester' ];
			$tmp[ 'anzStudenten' ]			= $this->getAnzStudisInVeranstaltung( $row[ 'ID' ] );

			$vl_verzeichnis[ $row['ID'] ] 	= $tmp;
 
			unset( $tmp );
		}
	}
  	return $vl_verzeichnis;
}

function getAllDozent()
{	$sql_1 = "SELECT * FROM `dozenten` ";
	$result_1 = mysqli_query (  $this -> conn, $sql_1  );
  $dozent = null;
 
  if ( $result_1 )
	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{  $dozent[ $row[ 'abk' ] ] = $row;	}
	}
  return $dozent;
}
  
function getDozentByUserID( $userID )
{ $ret = null;
  $sql_1    = "SELECT * FROM `dozenten` WHERE `userID` = '" . $userID ."'";
  $result_1 = mysqli_query (  $this -> conn, $sql_1  );
  if ( $result_1 )  { $ret = mysqli_fetch_array( $result_1, MYSQLI_ASSOC );  }
  return $ret;
}

function getDozentByKurzel( $abk )
{ $sql_1 = "SELECT * FROM `dozenten` WHERE `abk` = '" . $abk ."'";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );

  if ( $result_1 )  { $ret = mysqli_fetch_array( $result_1, MYSQLI_ASSOC );  }
 
  return $ret;
}

function getDozentByKennung( $kennung )
{ $sql_1 = "SELECT * FROM `dozenten` WHERE `userID` = '" . $kennung ."'";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );

  if ( $result_1 )  {  $ret = mysqli_fetch_array( $result_1, MYSQLI_ASSOC );   }
  return $ret;
}

function setPhase($phase)
{ $sql_1 =  "UPDATE `phasen` SET `phase` = " . $phase ." WHERE `phasen` . `ID` = 0";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );
}


function getPhase()
{ $sql_1 =  "SELECT phase FROM `phasen`";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );
  
  if ( $result_1 )  {  $ret = mysqli_fetch_array( $result_1, MYSQLI_ASSOC );   }
  return $ret['phase'];
}

function setKoordinator(  $name )
{ $name[ 'lastname'  ] = trim ( $name[ 'lastname'  ] ); # lastname
  $name[ 'firstname' ] = trim ( $name[ 'firstname' ] ); # firstname
  $name[ 'abk'       ] = trim ( $name[ 'abk'       ] ); # abk

  #if ( $name[ 'abk' ] != '' AND   $name[ 'lastname' ] != '' )
  {
    $sql_1 = "INSERT INTO `dozenten` (`ID`, `userID`, `abk`, `lastname`, `firstname`, `email`) VALUES ( NULL , '". $name[ 'userID' ] . "' , '". $name[ 'abk' ] . "' , '". $name[ 'lastname' ] . "' , '". $name[ 'firstname' ] . "' , '". $name[ 'email' ] ."')";
    $result_1 = mysqli_query($this->conn, $sql_1);
  }
}

  
function updateDozent($user)
{ if( ( isset($_SESSION[ 'user' ][ 'email'   ]) AND $_SESSION[ 'user' ][ 'email'  ]) != '' )
  { $sql_1 = "UPDATE `dozenten`
           SET `dozenten` .`email` = '". $user['email'] ."'
         WHERE `dozenten` . `abk`   = '". $user['abk']  ."'";
     $result_1 = mysqli_query(  $this->conn, $sql_1  );
  }
 
  if( ( isset($_SESSION[ 'user' ][ 'userID'  ]) AND $_SESSION[ 'user' ][ 'userID' ]) != '' )
  { $sql_2 = "UPDATE `dozenten`
         SET `dozenten` .`userID` = '". $user['userID'] ."'
         WHERE `dozenten` . `abk`   = '". $user['abk']  ."'";
    $result_2 = mysqli_query(  $this->conn, $sql_2  );
  }
}

function updateDozent_abk($user)
{ $sql_1 = "UPDATE `dozenten`
           SET `dozenten` .  `abk`   = '". $user[ 'abk'   ] ."'
         WHERE `dozenten` .  `email` = '". $user[ 'email' ] ."'";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}

function update2Dozent($user, $usr)
{ $sql_1 = "UPDATE `dozenten` SET `userID` = '". $usr['uusername'] ."', `email` = '". $usr['uemail'] ."' WHERE `dozenten` . `abk` = '". $user['abk']  ."'";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
  return ($usr['uusername'] );
}
  
function getLehrveranstaltung()
{ $sql_1 = "SELECT * FROM `lehrveranstaltungen` ";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );
  $LVA = null;
  
  if ( $result_1 )
  { while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    { $LVA[ $row[ 'abk' ] ] = $row;
    }
  }
  return $LVA;
}

function getStudiengaenge()
{ $sql_1 = "SELECT * FROM `studiengaenge` ";
  $result_1 = mysqli_query (  $this->conn, $sql_1  );
  $SG = null;
  if ( $result_1 )
  { while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    { $SG[ $row[ 'abk' ] ] = $row;
    }
  }
  return $SG;
}
  
function getNumberOfStudisInVeranst($veranstID)
{ $sql    = "SELECT COUNT(*) as anzStudis FROM mdl_haw_wunschbelegliste WHERE `veranstaltungID` =".$veranstID;
  $result = mysqli_query( $this->conn, $sql );
  if ( $result )
	$row = mysqli_fetch_array( $result, MYSQLI_ASSOC ); 

  return $row['anzStudis'];
}

function getAnzStudisInVeranstaltung( $veranstaltungID )
{ $tmp[] = "";
	$ret = 0;
	$sql_1 = "SELECT `veranstaltungID` FROM `mdl_haw_wunschbelegliste` WHERE `veranstaltungID` = ". $veranstaltungID;
	$result_1 = mysqli_query (  $this->conn, $sql_1  );

	if ( $result_1 )
	{ while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{ $ret++;
      $tmp[] = "";
		}
	}
	return $ret;	
}
  
function getExtKlausurplan( $ID )
{
  $extKlausurplan = null;

  if ( $ID != 0 )  { $whereclausel = 'AND `ID` = $ID';   }
  else             { $whereclausel = ' 1 = 1 ';          }
  
  #$LVAListe[]['']
  $sql_1 = "SELECT *, WEEKDAY(`date`) as WD, DAYOFYEAR(`date`) as DOY, DAYNAME(`date`) as DN, HOUR(`time`) as H FROM `vl_verzeichnis`  WHERE ". $whereclausel ." ORDER BY date ASC, H ASC, dozabk DESC ";
 
  /*
  $sql_1 = "SELECT `vl_verzeichnis`.ID as ID,
       `lehrveranstaltungen`.`name` as LVA,
       dozabk,
       `dozenten`.`lastname` as dozname,
       LVAabk,
       semSG,
       date ,
       time,
       WEEKDAY(`date`) as WD,
       DAYOFYEAR(`date`) as DOY,
       DAYNAME(`date`) as DN,
       HOUR(`time`) as H,
       anzstudi1 ,
       anzstudi2,
       bemerkung,
       raum,
       save,
       studr,
       checked
    FROM `vl_verzeichnis`,`dozenten`,  `lehrveranstaltungen` WHERE `lehrveranstaltungen`.`abk` = `vl_verzeichnis`.`LVAabk` AND `dozenten`.`abk` =  `vl_verzeichnis`.`dozabk` " . $whereclausel ." ORDER BY date ASC, H ASC, dozname DESC ";
 
  */
  # deb($sql_1,1);
  
  $result_1 =  mysqli_query (  $this -> conn, $sql_1  );
  
  if ( $result_1 )
  {
    while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    {
      if ($row[ 'DOY' ] == '' ) { $row[ 'DOY' ] = '0' ;}
      if ($row[ 'H'   ] == '' ) { $row[ 'H'   ] = '0' ;}
      if ($row[ 'H'   ] <= 12 ) { $row[ 'H'   ] = '1' ;}
      else                      { $row[ 'H'   ] = '2' ;}
      
      $extKlausurplan[ $row[ 'date' ] ][ $row[ 'H' ] ][ $row[ 'ID' ] ] = $row;
    }
  } #deb($extKlausurplan,1);
  
  /*
  $sql_1 = "SELECT `vl_verzeichnis`.ID as ID, `lehrveranstaltungen`.`name` as LVA, dozabk,`dozenten`.`lastname` as dozname, LVAabk, semSG, date , time, WEEKDAY(`date`) as WD, DAYOFYEAR(`date`) as DOY, DAYNAME(`date`) as DN, HOUR(`time`) as H, anzstudi1 , anzstudi2, bemerkung, raum,  save, studr, checked   FROM `vl_verzeichnis`,`dozenten`,  `lehrveranstaltungen` WHERE `lehrveranstaltungen`.`abk` = `vl_verzeichnis`.`LVAabk` AND `dozenten`.`abk` =  `vl_verzeichnis`.`dozabk` " . $whereclausel ." ORDER BY date ASC, H ASC, dozname DESC ";
  
  deb($sql_1,1);
  
  $result_1 =  mysqli_query (  $this -> conn, $sql_1  );
  
  if ( $result_1 )
  {
    while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    {
      if ($row[ 'DOY' ] == '' ) { $row[ 'DOY' ] = '0' ;}
      if ($row[ 'H'   ] == '' ) { $row[ 'H'   ] = '0' ;}
      if ($row[ 'H'   ] <= 12 ) { $row[ 'H'   ] = '1' ;}
      else                      { $row[ 'H'   ] = '2' ;}
      
      $extKlausurplan[ $row[ 'date' ] ][ $row[ 'H' ] ][ $row[ 'ID' ] ] = $row;
    }
  }#deb($extKlausurplan,1);
  
*/
return $extKlausurplan;
}

function getVorlesung( $ID = 0 )
{ if ( $ID != 0 )  { $whereclausel = 'WHERE `ID` = $ID'; }
  else             {  $whereclausel = '';                }
	
  $sql_1 = "SELECT * FROM `vl_verzeichnis` ". $whereclausel ." ORDER BY `dozabk`";
	$result_1 = mysqli_query (  $this->conn, $sql_1  );

	if ( $result_1 )
	{	while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{ $tmp[ 'ID'             ] = $row[ 'ID'      ];
			$tmp[ 'doz'            ] = $this -> getProfessor(     $row[ 'dozabk' ] );               # $row[ 'dozabk' ];
			$tmp[ 'LVA'            ] = $this -> getVeranstaltung( $row[ 'LVAabk' ] );       # $row[ 'LVAabk' ];                            # $this->getStudiengang( $row[ 'studiengangID' ] );
      $tmp[ 'date'           ] = $row[ 'date'     ] ;
      $tmp[ 'time'           ] = $row[ 'time'     ] ;
      $tmp[ 'SG'             ] = $row[ 'SG'       ];
      $tmp[ 'sem'            ] = $row[ 'sem'      ];
      $tmp[ 'anzStudis'      ][ 1 ] = $row[ 'anzstudi1' ];                    # $this->getStudiengang( $row[ 'studiengangID' ] );
      $tmp[ 'anzStudis'      ][ 2 ] = $row[ 'anzstudi2' ];                    # $this->getStudiengang( $row[ 'studiengangID' ] );
      $tmp[ 'anote'          ] = $row[ 'bemerkung'      ];
      
      $tmpusr = explode(',', $row[ 'dozabk' ] );  foreach ($tmpusr as $tu)   { $tmpu[] = trim($tu); } ;  ## Alle User, besonders Listen von Usern, werden in Array konvertiert
  
      if ( in_array( $_SESSION[ 'user' ][ 'abk' ], $tmpu) OR ( $_SESSION[ 'user' ][ 'ro' ] >= 3 ) )   ## Nur eigene Datensätze werden in die Liste aufgenommen
      { $vorlesungsListe[ $row[ 'ID' ] ]  = $tmp;
      }
			unset( $tmp );
      unset($tmpu);
		}
	}
	
  $_SESSION['vorlesungsliste'] = $vorlesungsListe;
  return $vorlesungsListe;
}

  
function getRaum( $raum  = 0 )
{ $raumliste = null;
  $sql_1     = "SELECT * FROM `raum` ";
  $result_1  = mysqli_query (  $this->conn, $sql_1  );

  if ( $result_1 )
  { while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    { $raumliste[$row[ 'fluegel' ]][$row[ 'raum' ]] = $row;
    }
  }
  return $raumliste;
}

function getBelegliste( $matrikelNr, $vl_verzeichnis )
{  	$belegliste= null;
	  $sql_1 = "SELECT  * FROM `mdl_haw_wunschbelegliste` WHERE `studId` = '$matrikelNr'   ORDER BY `ID` ASC";
	  $result_1 = mysqli_query (  $this->conn, $sql_1  );
    $row[ 'veranstaltung' ] = '';
	if ( $result_1 )
	{ while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{ $row[ 'veranstaltung' ] = $vl_verzeichnis[ $row[ 'veranstaltungID']];
      $belegliste[] = $row;
		}
	}
 	return $belegliste;
}

function getPhasen()
{
  $sql_1 = "SELECT * FROM `mdl_haw_phasen` " ;
 
  $result_1 = mysqli_query (  $this->conn, $sql_1  );
	if ( $result_1 )
	{ while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{ $p = $row['phase'];
			$phasen[ $p ]  = $row['timestamp'];
		}
	}
	return $phasen;
}

/*


function getErstsemestermatnr()
{
	$sql_1 = "SELECT `erstsemestermatnr` FROM `mdl_haw_erstsemestermatnr`";
	$result_1 = mysqli_query(  $this->conn, $sql_1  );
	if ( $result_1 )
	{	
		while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{	
			 $erstsemestermatnr = $row[ 'erstsemestermatnr' ];
		}
	}
  	return $erstsemestermatnr;
}

*/
function setDB( $param, $IDMuser , $belegliste, $vl_verzeichnis )
{	if( $param[ 'column' ] == "delete" )
	{	$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";";
	}	

	else if( $param[ 'column' ] == "neuerBeleglistenEintrag" ) 
	{  $sql_1 = "INSERT INTO `mdl_haw_wunschbelegliste` ( `studID`,  `veranstaltungID`, `timestamp`, `status`, `checksum`) VALUES ( '".$IDMuser[ 'matrikelnr' ]."', '-1', NOW(), '', '".$IDMuser[ 'matrikelnr' ]."')";
  }

	else if( $param[ 'column' ] == "studiengangID" )                                                 	/*Alle Eintr�ge in der Belegliste werden gel�scht wenn das Studiengang ge�ndert wird */
	{ $sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `studID` =".$IDMuser[ 'matrikelnr' ];
  }
	else if( $param[ 'column' ] == "semester" )	                                                      /*Alle Eintr�ge in der Belegliste werden gel�scht wenn das Semester ge�ndert wird */
	{ $sql_0 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `studID` =".$IDMuser[ 'matrikelnr' ];
		mysqli_query (  $this->conn, $sql_0  );
	}
	else if( $param[ 'column' ] == "update2" )                                                        // Update von Checksumme und Veranstaltungs ID
	{ if ( isset( $param[ 'phase' ] ) ) // Argument:Phase nur bei Existenz mit in den SQL Queue
		{  $p = "`phase` =  ".$param[ 'phase' ]. " ,";	}
		else
		{  $p = '';	}
		
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',  $p  `veranstaltungID` = '".$param[ 'value' ]."' WHERE  `ID` = ".$param[ 'ID' ];
	 
		$result_1 = mysqli_query(  $this->conn, $sql_1  );
 
    if(sizeof($belegliste) > 0)
		{ foreach ( $belegliste as $bl )
			{ if( $bl[ 'ID' ] ==   $param[ 'ID' ]  )
				{ $status =  $bl[ 'status' ];
				}
			}
    }
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = '" .$status. "' WHERE  `ID` = " .$param[ 'ID' ];
  
	 	if( $param[ 'value' ] == -1 ) 
		{	$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";";
		}	

		$result_1 = mysqli_query(  $this->conn, $sql_1  );
	}

	else if( $param[ 'column' ] == "update3" )
	{	$sql_1 = "INSERT INTO `mdl_haw_wunschbelegliste` ( `studID`,  `veranstaltungID`, `timestamp`, `status`, `checksum`) VALUES ( '".$IDMuser[ 'matrikelnr' ]."', '-1', NOW(), '', '".$IDMuser[ 'matrikelnr' ]."')";
		$result_1 = mysqli_query(  $this->conn, $sql_1  );
		
		// Update von Checksumme und Veranstaltungs ID
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',   `veranstaltungID` = '".$param[ 'value' ]."' WHERE  `checksum` = ".$param[ 'ID' ];
		$result_1 = mysqli_query(  $this->conn, $sql_1  );

		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = 'M' WHERE  `checksum` = " .$param[ 'ID' ];
		$result_1 = mysqli_query(  $this->conn, $sql_1  );
	}
	
	else
	{	// Update von Checksumme und Veranstaltungs ID
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `checksum` = '".$param[ 'checksum' ]."',  `phase` =  '".$param[ 'phase' ]."' ,  `".$param[ 'column' ]."` = '".$param[ 'value' ]."' WHERE  `ID` = ".$param[ 'ID' ];
		
		$result_1 = mysqli_query(  $this->conn, $sql_1  );
		$belegliste = $this->getBelegliste( $IDMuser[ 'matrikelnr' ], $vl_verzeichnis );	
		$belegliste = $this->isBooked( $IDMuser, $belegliste );
	  
		if( sizeof( $belegliste ) >0 )
		foreach ( $belegliste as $bl )
		{	if( $bl[ 'ID' ] ==   $param[ 'ID' ] )
			{	$status =  $bl[ 'status' ];
			}
		}
		$sql_1 = "UPDATE `mdl_haw_wunschbelegliste` SET `timestamp` = NOW( ) , `status` = '".$status."' WHERE  `ID` = ".$param[ 'ID' ];

		if( $param[ 'value' ] == -1 ) 
		{	$sql_1 = "DELETE FROM `mdl_haw_wunschbelegliste` WHERE `ID` = ". $param[ 'ID' ] .";";
		}	
		
		$result_1 = mysqli_query(  $this->conn, $sql_1  );
	}

	if( ! isset($result_1)  )
	{	$result_1 = mysqli_query(  $this->conn, $sql_1 );
	}
	return $belegliste;
}
/*
function isBooked( $IDMuser, $belegliste )
{  
  if ( sizeof( $belegliste ) > 0 )
   
   for( $i=0; $i< sizeof( $belegliste ); $i++ )  // foreach ($belegliste as $bl)
   {   
		$blStudiengang 		  =  $belegliste[$i][ 'veranstaltung' ][ 'studiengang' ][ 'ID' ];
		$blSemester 	      =  $belegliste[$i][ 'veranstaltung' ][ 'semester' ];
	 
    $userStudiengang 	  =  $IDMuser[ 'studiengang' ];
		$userSemester       =  $IDMuser[ 'semester' ];
	
		if ( $blStudiengang == $userStudiengang && $blSemester == $userSemester   )
		{
			$belegliste[ $i ][ 'status' ] = "B";	
		}
		else
		{
			$belegliste[ $i ][ 'status' ] = "W";		
		}
	}
	return $belegliste;
}
*/

/*
function setWishState( $id, $state )
{   
   if ( $state == 1 ) {  $sql_1 = "UPDATE `beleg`.`mdl_haw_wunschbelegliste` SET `status` = 'W' WHERE `mdl_haw_wunschbelegliste`.`ID` = ".$id;  }
   if ( $state == 2 ) {  $sql_1 = "UPDATE `beleg`.`mdl_haw_wunschbelegliste` SET `status` = 'B' WHERE `mdl_haw_wunschbelegliste`.`ID` = ".$id;  }
	$result_1 = mysqli_query(  $this->conn, $sql_1  );
}
*/

 function importRow_vlvz( $val )
{ $SG = null;
  if (strlen($val['semSG']) > 2 )
  { $sem = substr($val['semSG'], 1, 1);
    $SG  = substr($val['semSG'], 2);
  }
  else
  { $sem = substr($val['semSG'], 0, 1);
    $SG  = substr($val['semSG'], 1);
  }
  
  #if (!is_numeric($sem))   {  $sem = null;   $SG = $val['semSG'];   }
    
  if ($sem) { $sql__sem = ", `sem` ";  $VAL_sem  =  ", '".$sem."' " ;  }
  else      { $sql__sem = ""        ;  $VAL_sem  =  "";     }
  if ($SG)  { $sql__SG = ", `SG` "  ;  $VAL_SG   =  ", '".$SG."' ";    }
  else      { $sql__SG = ""         ;  $VAL_SG   =  "";     }
    
  $val[ 'date' ] = " STR_TO_DATE( \"".$val[ 'date' ]."\" , \"%d.%m.%Y\" )";
  
  $sql_1 = "INSERT INTO `vl_verzeichnis`
     ( `kid`, `dozabk`, `LVAabk`, `semSG` " .$sql__sem.$sql__SG." , `date` , `time`, `bemerkung` ,`anzstudi1` )
     VALUES ( '". $val['kid'] . "' , '" . $val['dozabk'] . "' , '" . $val['LVAabk'] . "'  , '" . $val['semSG'] . "'" .$VAL_sem . $VAL_SG ." , " . $val['date'] . " , '" . $val['time'] . "', '" . $val['bemerkung'] . "', '" . $val['anz1'] . "' );";
     $result_1 = mysqli_query($this->conn, $sql_1);
  }
  
function importRow_doz($val)
{ $sql_1 = "INSERT INTO `dozenten` ( `abk`, `lastname` )  VALUES ( '". $val['dozabk'] ."' , '". $val['doz'] ."' );";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );

  {  #$this->update2Dozent($val, $usr);
  }
  ## ---- import userdata ----
}

function importRow_LVA($val)
{ $sql_1 = "INSERT INTO `lehrveranstaltungen` (`abk`, `name`)   VALUES ( '". $val['LVAabk'] ."' , '". $val['LVA'] ."' );";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}

function deleteRow( $id, $val )
{ $sql_1 = "DELETE FROM `vl_verzeichnis` WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}

function addBlankRow()
{ $sql_1 = "INSERT INTO `vl_verzeichnis` (`ID`, `dozabk`, `LVAabk`, `date`, `SG`, `sem`, `anzstudi1`, `anzstudi2`) VALUES (NULL, '', '', '0000-00-00', '', '', '0', '0');  ";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}

function changeDozent( $id, $val )
{ $doz = explode( '/', $val);
  $sql_1 = "UPDATE `vl_verzeichnis` SET `dozabk` = '".$doz[1]."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}

function setAnzStudi1( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `anzstudi1` = '".$val."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setAnzStudi2( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `anzstudi2` = '".$val."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setSG2( $vl )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `SG` = '".$vl['3']."',`sem`='".$vl['2']."'    WHERE `LVAabk` = '".$vl['4']."'";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setSG( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `SG` = '".$val."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setsem( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `sem` = '".$val."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setdate( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `date` = '".   $val  ."' WHERE `vl_verzeichnis`.`ID` = ".$id;
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function settime( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `time` = '". $val ."' WHERE `vl_verzeichnis`.`ID` = ".$id;
$result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setanote( $id, $val )
{ $val = $this->conn -> real_escape_string($val);
  $sql_1 = "UPDATE `vl_verzeichnis` SET `bemerkung` = '".$val."' WHERE `vl_verzeichnis`.`ID` = ".$id;
 
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setRaum( $id, $val )
{ $sql_1 = "UPDATE `vl_verzeichnis` SET `raum` = '".$val."' WHERE `vl_verzeichnis`.`ID` = \"".$id."\"";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
}
  
function setChecked( $id, $val )
{ $ret = 0;
  $sql_1 = "SELECT COUNT(*) FROM `timeslots` WHERE `timeslot` = '".$id."'";
  $TSexist = mysqli_fetch_assoc( mysqli_query(  $this -> conn, $sql_1 ) )[ 'COUNT(*)' ];
  
  if( !$TSexist )  ##  Bisher noch kein Eintrag für diesen Timeslot vorhanden. Eintrag wird gemacht.
  { $sql_2 = "INSERT INTO `timeslots` (`ID`, `timeslot`, `checked`) VALUES (NULL, '" .$id. "', '" .$val. "')";
    $result_2 = mysqli_query(  $this->conn, $sql_2  );
  }
    
  else      ## Timeslot bekommt neuen Status für 'Checked'
  { $sql_3 = "UPDATE `timeslots` SET `checked` = '".$val."' WHERE `timeslot`  = \"".$id."\"";
    $result_3 = mysqli_query($this->conn, $sql_3);
  }
}

function getChecked( $id )
{ $sql_1 = "SELECT `checked` FROM `timeslots` WHERE `timeslot` = '". $id."'";
  $result_1 = mysqli_query(  $this->conn, $sql_1  );
  $ret =  mysqli_fetch_row ( $result_1 );
  return $ret[0];
}
  
function getTimeslots()
{ $sql_3 = "SELECT `timeslot`, `checked` FROM `timeslots`";
  $result_3 = mysqli_query( $this->conn, $sql_3);
  
  while ( $row = mysqli_fetch_array( $result_3, MYSQLI_ASSOC ) )
  { $TS[$row['timeslot']] = $row['checked'];
  }
  return $TS;
}

function setdozent( $id, $val )
{ $abk       = '';
  $lastname  = '';
  $firstname = '';
  $new       = '';
 
  $tmp  = explode( ':', $val );

  if (strcmp( trim($tmp[0]), 'NEW')  == 0   )
  { $new  = 'NEW';
    $tmp  = explode( '/', $tmp[ 1 ] );
  }
  else
  { $tmp  = explode( '/', $tmp[ 0 ] );
  }

  $name = explode( ',', $tmp[ 0 ] );
  
  $name[ 'lastname'  ] = trim ( $name[ 0 ] ); # lastname
  $name[ 'firstname' ] = trim ( $name[ 1 ] ); # firstname
  $name[ 'abk'       ] = trim ( $tmp[ 1 ]  ); # abk
  $name[ 'new'       ] = trim ( $new );

  if ( $name[ 'abk' ] != '' AND   $name[ 'lastname' ] != '' )
  { $abk      =  " `dozabk`   = '" . $name[ 'abk'       ]  . "'";
    $lastname =  " `lastname` = '". $name[ 'lastname' ] ."'";
    if ( $name[ 'firstname' ] != '' )
    { $firstname =  ", `firstname` = '". $name[ 'firstname' ] ."'";
    }
 
  	if (strcmp( $name['new'],  'NEW')  == 0   )
    { $sql_2 = "INSERT INTO `dozenten` ( `abk`) VALUES ( '". $name[ 'abk' ] ."')";
      $result_2 = mysqli_query($this->conn, $sql_2);
      $sql_3 = "UPDATE `dozenten` SET " .$lastname. $firstname ."  WHERE `dozenten`.`abk` = '".$name[ 'abk'       ] ."'";
      $result_3 = mysqli_query($this->conn, $sql_3);
    }

    $sql_1    = "UPDATE `vl_verzeichnis` SET " . $abk . "  WHERE `vl_verzeichnis`.`ID` = " . $id;
 
	  $result_1 = mysqli_query( $this -> conn, $sql_1 );
  }
}
 
function setLVA( $id, $val )
{ $abk       = '';
  $LVAname   = '';
  $new       = '';
  
  $tmp  = explode( ':', $val );
  
  if ($tmp[0] == 'NEW')
  { $new       = 'NEW';
    $tmp  = explode( '/', $tmp[ 1 ] );
  }
  else
  { $tmp  = explode( '/', $tmp[ 0 ] );
  }
    
  $name[ 'name'  ] = trim ( $tmp[ 0 ] ); # lastname
  $name[ 'abk'   ] = trim ( $tmp[ 1 ]  ); # abk
  $name[ 'new'   ] = trim ( $new );
 
  if ( $name[ 'abk' ] != '' AND   $name[ 'name' ] != '' )
  { $LVAabk   =  " `LVAabk`   = '" . $name[ 'abk'  ]  . "'";
    if( $name[ 'new' ] == 'NEW')
    {
      $sql_2 = "INSERT INTO `lehrveranstaltungen` (`abk`, `name`) VALUES ( '".$name[ 'abk'  ]."', '".$name[ 'name' ]."');";
      $result_2 = mysqli_query($this->conn, $sql_2);
    }
    
    $sql_1 = "UPDATE `vl_verzeichnis` SET  `LVAabk` = '" . $name[ 'abk'  ] . "'  WHERE `vl_verzeichnis`.`ID` = '" . $id."'";
    $result_1 = mysqli_query( $this -> conn, $sql_1 );
  }
}
  
  function getRooms()
  {
    $_SESSION[ 'liste' ][ 'raum'    ] = $this -> getRaumListe();
    $_SESSION[ 'liste' ][ 'cluster' ] = $this -> getClusterListe();
    $_SESSION[ 'liste' ][ 'laufweg' ] = $this -> getLaufwegListe();
    $_SESSION[ 'liste' ][ 'fluegel' ] = $this -> getFluegelListe();
    $_SESSION[ 'liste' ][ 'eingang' ] = $this -> getEingangListe();
    
    foreach ( $_SESSION[ 'liste' ][ 'eingang' ] as $eingang )
    { $LS[ $eingang[ 'name' ] ] = $eingang;
      foreach ( explode(',', $LS[ $eingang[ 'name' ]][ 'fluegel' ] ) as $fluegelname )
      
      { foreach ( $_SESSION[ 'liste' ][ 'fluegel' ] as $fluegel )
      { if( $fluegel[ 'name' ]  == $fluegelname )
      { $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ] = $fluegel;
        foreach ( explode(',', $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ][ 'laufweg' ] ) as $laufwegname )
        
        { foreach ($_SESSION[ 'liste' ][ 'laufweg' ] as $laufweg)
        { if ( $laufweg['name'] == $laufwegname )
        { $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ]['lw'][$laufwegname] = $laufweg;
          foreach ( explode(',', $laufweg['cluster'] ) as $clustername )
          
          { foreach ($_SESSION[ 'liste' ][ 'cluster' ] as $cluster )
          { if ( $cluster[ 'name' ] == $clustername )
          { $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ][ 'lw' ][ $laufwegname ][ 'cl' ][$clustername] = $cluster;
            foreach ( explode(',', $cluster[ 'raum' ] ) as $raumname )
            
            { foreach ($_SESSION['liste']['raum'] as $raum)
            {
              if ( $raum[ 'shortname' ] == $raumname )
              { $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ][ 'lw' ][ $laufwegname ][ 'cl' ][$clustername]['rn'] [$raumname] = $raum;
              }
            }
            }
            $LS[ $eingang[ 'name' ] ] [ 'fl' ][ $fluegelname ][ 'lw' ][ $laufwegname ][ 'cl' ][$clustername]['raum'] =
              $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ][ 'lw' ][ $laufwegname ][ 'cl' ][$clustername]['rn'] ;
            unset(  $LS[ $eingang[ 'name' ] ][ 'fl' ][ $fluegelname ][ 'lw' ][ $laufwegname ][ 'cl' ][$clustername]['rn']);
          }
          }
          }
          $LS[ $eingang[ 'name' ] ] [ 'fl' ][ $fluegelname ]['lw'][ $laufwegname ]['cluster'] =
            $LS[ $eingang[ 'name' ] ] [ 'fl' ][ $fluegelname ]['lw'][ $laufwegname ]['cl'] ;
          unset($LS[ $eingang[ 'name' ] ] [ 'fl' ][ $fluegelname ]['lw'][ $laufwegname ]['cl']);
        }
        }
        }
        $LS[ $eingang[ 'name' ] ] [ 'fl' ] [ $fluegelname ] [ 'laufweg' ]  =
          $LS[ $eingang[ 'name' ] ] [ 'fl' ] [ $fluegelname ] [ 'lw'      ];
        unset($LS[ $eingang[ 'name' ] ] [ 'fl' ] [ $fluegelname ] [ 'lw'      ]);
      }
      }
      }
      $LS[ $eingang[ 'name' ] ] [ 'fluegel' ] =
        $LS[ $eingang[ 'name' ] ][ 'fl' ];
      unset($LS[ $eingang[ 'name' ] ][ 'fl' ]);
      
    }
    
    $_SESSION[ 'liste' ][ 'alleraume' ] = $LS;
    return $LS;
    
  }
 
 /*
  function getProfAbk( $name )
  {
    $name = explode(',' , $name);
    $name = explode('/' , $name[0]);
    
    $sql_1 = "SELECT * FROM dozenten as doz WHERE BINARY doz.lastname = '".trim($name[0])."'";
    
    $result_1 = mysqli_query(  $this->conn, $sql_1  );
    $abk =  mysqli_fetch_row ( $result_1 );
    
    return $abk[2];
  }
  */
 /*
function setProf( $userData )
{
  if ( ! isset( $userData[ 'ufirstname' ] ) ) { $userData[ 'ufirstname' ] = ''; }
  if ( ! isset( $userData[ 'ulastname'  ] ) ) { $userData[ 'ulastname'  ] = ''; }
  if ( ! isset( $userData[ 'uemail'     ] ) ) { $userData[ 'uemail'     ] = ''; }
  if ( ! isset( $userData[ 'uusername'  ] ) ) { $userData[ 'uusername'  ] = ''; }

  $sql_1 = "INSERT INTO `mdl_haw_professoren` ( `firstname`,  `lastname`,  `email`, `userID`)
  VALUES ( '".$userData['ufirstname'] . "' , '" . $userData['ulastname'] . "' , '" .  $userData['uemail'] . "' , '" . $userData['uusername'] ."' )";
   $result_1 = mysqli_query(  $this->conn, $sql_1  );

}
*/

/*
function getVLVZStudiengaenge()  
{   
	$sql_1 = "SELECT DISTINCT `studiengangID` FROM `mdl_haw_vl_verzeichnis`";	
	$result_1 = mysqli_query( $this->conn, $sql_1 );
	if ( $result_1 )
	{
		while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{   
			$sql_2 = "SELECT DISTINCT * FROM `mdl_haw_studiengaenge` WHERE ID = ".$row['studiengangID'];
			$result_2 = mysqli_query( $this->conn, $sql_2 );
			if ( $result_2 )
			{
				while ( $row2 = mysqli_fetch_array( $result_2, MYSQLI_ASSOC ) )
				{
					$studiengaenge[] = $row2;
				}
			}
		}
	}
	return $studiengaenge;	
}
*/
/*
function getVeranstaltungsListe()
{   
	$sql_1 = "SELECT DISTINCT `veranstaltungID` FROM `mdl_haw_vl_verzeichnis`";
	$result_1 = mysqli_query( $this->conn, $sql_1 );
 
	if ( $result_1 )
	{
		while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
		{   
			$sql_2 = "SELECT DISTINCT * FROM `mdl_haw_veranstaltungen` WHERE ID = ".$row['veranstaltungID'];
			$result_2 = mysqli_query( $this->conn, $sql_2 );
			if ( $result_2 )
			{
				while ( $row2 = mysqli_fetch_array( $result_2, MYSQLI_ASSOC ) )
				{
					$veranstaltungen[] = $row2;
				}
			}
		}
	}
	return $veranstaltungen;
}
*/
/*
	function getVorlesungsListe()
	{   
		$sql_3 = "SELECT * FROM `mdl_haw_veranstaltungen";

		$result_3 = mysqli_query( $this->conn, $sql_3);
		
		while ( $row = mysqli_fetch_array( $result_3, MYSQLI_ASSOC ) )
		{
			$vorlesung[] = $row;
		}
		return $vorlesung;
	}

*/

/*
function getGesamtBelegliste( $sort = "veranstaltung" )
{
  $belegliste = array();

  $sql_1 = "SELECT * FROM `mdl_haw_wunschbelegliste` ORDER BY `".$sort."ID`	ASC ";

  $result_1 = mysqli_query(  $this->conn, $sql_1 );

  if ( $result_1 )
  {
    while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
    {
      $tmp[ 'ID' ]               = $row[ 'ID' ];
      $tmp[ 'status' ]           = $row[ 'status' ];
      $tmp[ 'phase' ]            = $row[ 'phase' ];
      $tmp[ 'veranstaltungID' ]  = $row[ 'veranstaltungID' ];

      if( $row[ 'veranstaltungID' ] != '-1'   )
	  {
        $tmp[ 'IDMuser' ] = $this->dbIDM->getIDMuser( $row[ 'studID' ], 'M' ) ;  				                      #$this->deb($tmp[ 'IDMuser' ]);
        $tmp[ 'IDMuser' ][ 'studiengang' ]=    $this->transSG( $tmp[ 'IDMuser' ][ 'studiengang' ] );
        $tmp[ 'vorlesung' ] = $_SESSION[ 'vorlesungsliste' ][ $row[ 'veranstaltungID' ] ];

        $belegliste[] = $tmp;
      }
    }
  }
  return $belegliste;
}
*/
/*
	function getAllLists()
	{   
		$lists = "";

		#$sql_1 = "SELECT * FROM `mdl_haw_professoren`";
		#$sql_2 = "SELECT * FROM `mdl_haw_studiengaenge`";
		#$sql_3 = "SELECT * FROM `mdl_haw_veranstaltungen`";
    
    $sql_1 = "SELECT * FROM `dozenten`";
    $sql_2 = "SELECT * FROM `mdl_haw_studiengaenge`";
    $sql_3 = "SELECT * FROM `lehrveranstaltungen`";
		
		$result_1 = mysqli_query( $this->conn, $sql_1 );
		$result_2 = mysqli_query( $this->conn, $sql_2 );
		$result_3 = mysqli_query( $this->conn, $sql_3 );
 
		if ( $result_1 )
		{
			while ( $row = mysqli_fetch_array( $result_1, MYSQLI_ASSOC ) )
			{   
				$professoren[] = $row;
			}
			$lists[ 'professoren' ] = $professoren;
		}

		if ( $result_2 )
		{
			while ( $row = mysqli_fetch_array( $result_2, MYSQLI_ASSOC ) )
			{
				$studiengaenge[] = $row;
			}
			$lists[ 'studiengaenge' ] = $studiengaenge;
		}

		if ($result_3)
		{
			while ( $row = mysqli_fetch_array( $result_3, MYSQLI_ASSOC ) )
			{
				$veranstaltungen[] = $row;
			}
			$lists[ 'veranstaltungen' ] = $veranstaltungen;
		}
		return $lists;
	}
*/
  
  
function deb($var)
{ echo "<pre>";
  print_r($var);
  echo "</pre>";
}

}

?>