<?php
// Phase 0 Belegverfahren hat noch nicht begonnen
// Phase 1 Belegverfahren läuft für alle
// Phase 2 Belegverfahren läuft nur noch für für 1.Sem (>1. Sem können Eintragungen nicht mehr ändern)
// Phase 3 Belegverfahren geschlossen, nur noch für Nachzügler
// Phase 4 Keine weiteren Buchungen möglich, unbest. Buchungen werden nicht angezeigt.

session_start();
#error_reporting(2);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


require_once("../inc/belegliste.class.php");
require_once("../inc/db.class.php");
require_once("../inc/db.IDM.class.php");

$param;   
$IDMuser;  
$studiengaenge;  
$vl_verzeichnis; 
$belegliste; 
$contentA; 

$DEBUG  = false;

$db     = new DB();                                                                                 if ($DEBUG) { echo "<br>#### W ####"; }
$dbIDM  = new DBIDM();                                                                              if ($DEBUG) { echo "<br>POST"; deb( $_POST     ); }
$bl     = new Belegliste( $db, $dbIDM );                                                            if ($DEBUG) { echo "<br>GET" ; deb( $_GET      ); }
                                                                                                    if ($DEBUG) { echo "<br>SESS"; deb( $_SESSION  ); }
$phasewechsel = $db->getPhasen();

$phase = $_SESSION[ "phase" ] = 0; 


if ( isset( $_GET[ 'sv'   ] ) ) 
{ 
  $_SESSION['intern'] = 'true';
}

if ( isset($_SESSION['intern']) AND  $_SESSION['intern'] != 'true'  )                                                              // -- Beschränkung nur bei Studiansicht
{ 
  if ( time() > $phasewechsel[1] )  {  $phase = $_SESSION[ "phase" ] = 1; }   
  if ( time() > $phasewechsel[2] )  {  $phase = $_SESSION[ "phase" ] = 2; }   
  if ( time() > $phasewechsel[3] )  {  $phase = $_SESSION[ "phase" ] = 3; }                         if ($DEBUG) { echo "<br>Intern"; deb( $_SESSION  ); }
  if ( time() > $phasewechsel[4] )  {  $phase = $_SESSION[ "phase" ] = 4; }                         if ($DEBUG) { echo "<br>Intern"; deb( $_SESSION  ); }
}
else                                                                                                // -- Keine Beschränkung bei Koordinatorenansicht 
{                                                                                                   if ($DEBUG) { echo "<br>aus EMIL"; deb( $_SESSION  ); }
  $phase =   $_SESSION[ "phase" ] = 1;                                                             
}

#$phase = $_SESSION[ "phase" ] = 4; 

$IDMuser[ 'mail'        ] = "";
$IDMuser[ 'vorname'     ] = "";
$IDMuser[ 'nachname'    ] = "";
$IDMuser[ 'akennung'    ] = "";
$IDMuser[ 'matrikelnr'  ] = "";
$IDMuser[ 'studiengang' ] = "";  
$IDMuser[ 'stg'         ] = "";
$IDMuser[ 'department'  ] = "";  
$IDMuser[ 'semester'    ] = "";

/*-------------------------------------------------------------------------------------------------------------------------------------------*/
if($_POST)                                                                                          /* Änderungen des Nutzers werden registriert */
{
  $param[ 'action'   ] = $_POST[ 'a'        ];                                                      if ($DEBUG)  echo 'Änderungen des Nutzers werden registriert';
  $param[ 'column'   ] = $_POST[ 'col'      ]; 
  $param[ 'value'    ] = $_POST[ 'val'      ];
  $param[ 'ID'       ] = $_POST[ 'id'       ];
  $param[ 'checksum' ] = $_POST[ 'checksum' ];   
  $param[ 'phase'    ] = $phase;   
}
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/*-------------------------------------------------------------------------------------------------------------------------------------------*/
if( $_SESSION['GET'] )                                                                                         /*  Initiale Parameterübergabe über  Moodle */
{        
  if ( isset( $_SESSION['GET'][ 'm'   ] )) { $IDMuser[ 'mail'        ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'm'  ] ) ); } else { echo "<br>ERROR: no 'mail'       "; }  if ($DEBUG) { echo "<br>INIT<br>"; };
  if ( isset( $_SESSION['GET'][ 'fn'  ] )) { $IDMuser[ 'vorname'     ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'fn' ] ) ); } else { echo "<br>ERROR: no 'vorname'    "; }
  if ( isset( $_SESSION['GET'][ 'ln'  ] )) { $IDMuser[ 'nachname'    ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'ln' ] ) ); } else { echo "<br>ERROR: no 'nachname'   "; }
  if ( isset( $_SESSION['GET'][ 'u'   ] )) { $IDMuser[ 'akennung'    ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'u'  ] ) ); } else { echo "<br>ERROR: no 'akennung'   "; }
  if ( isset( $_SESSION['GET'][ 'id'  ] )) { $IDMuser[ 'matrikelnr'  ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'id' ] ) ); } else { echo "<br>ERROR: no 'matrikelnr' "; }
  if ( isset( $_SESSION['GET'][ 'sg'  ] )) { $IDMuser[ 'studiengang' ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'sg' ] ) ); } else { echo "<br>ERROR: no 'studiengang'"; }
  if ( isset( $_SESSION['GET'][ 'dp'  ] )) { $IDMuser[ 'department'  ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'dp' ] ) ); } else { echo "<br>ERROR: no 'department' "; }
  if ( isset( $_SESSION['GET'][ 'se'  ] )) { $IDMuser[ 'semester'    ] =  rawurldecode( base64_decode( $_SESSION['GET'][ 'se' ] ) ); } else { echo "<br>ERROR: no 'semester'   "; }
  #deb($IDMuser,1);
  $dbIDM->setIDMuser( $IDMuser );                                                                   if ($DEBUG) echo"<br>neuer Eintrag<br>"; 
  $IDMuser[ 'stg' ] =  $db->transSG( $IDMuser[ 'studiengang' ] );                                     // Gruppiert ähnliche Studiengänge (zu BT, VT, HC...) 
  $_SESSION[ 'IDMuser'    ] =  $IDMuser;                                                            if ($DEBUG){echo"<br>IDMU SESS<br>";  deb( $_SESSION[ 'IDMuser'  ]);}
}

else 
{
  //deb($IDMuser);
  #if (isset($_SESSION[ 'IDMuser'  ])) $IDMuser =  $_SESSION[ 'IDMuser'  ];                                                              if ($DEBUG){echo"<br>INTERN IDMU<br>";  deb($IDMuser);}
}


/*-------------------------------------------------------------------------------------------------------------------------------------------*/

$studiengaenge                  = $db->getVLVZStudiengaenge();                                      /* alle Studiengänge des VLVZ */
$vl_verzeichnis                 = $db->getVorlesungsVerzeichnis();                                  /* komplette  VLVZ */
$belegliste                     = $db->getBelegliste( $IDMuser[ 'matrikelnr' ], $vl_verzeichnis );

/*-------------------------------------------------------------------------------------------------------------------------------------------*/

if( isset( $param['action'] ))                                                                              /*  Datenbänke werden aktualisiert */
{  
    $dbIDM->setDB( $param , $IDMuser  );
    $db->setDB( $param , $IDMuser, $belegliste, $vl_verzeichnis );
    $belegliste = $db->getBelegliste( $IDMuser[ 'matrikelnr' ], $vl_verzeichnis );
    $_SESSION[ 'IDMuser'  ] = $IDMuser = $dbIDM->getIDMuser( $IDMuser[ 'akennung' ] );
}
/*-------------------------------------------------------------------------------------------------------------------------------------------*/
$contentA = '';                                                                                                    if ($DEBUG){echo"<br>DB IDMU<br>";   deb($IDMuser);}
$contentA .= $bl->getstudiverwaltunghtmlhead();                                                                            if ($DEBUG){echo"<br>PARAM<br>";     deb($param)  ;} 
$contentA .= $bl->getJavaScript();
$contentA .= "\n\r<form  method='post'  name='belegliste' action='#'>";
$contentA .= "<div class=\"user\">";
$contentA .= $IDMuser[ 'vorname' ].' ' .$IDMuser[ 'nachname' ]. '<br />';
$contentA .= "\n\r<input name='matrikelnr' value=\"".$IDMuser[ 'matrikelnr' ]."\" type='hidden' />";
$contentA .= "\n\r<input name='akennung'   value=\"".$IDMuser[ 'akennung'   ]."\" type='hidden' />";
$contentA .= $IDMuser[ 'matrikelnr'  ]  ." - ".( $db->transSG( $IDMuser[ 'studiengang'  ] ) ) ."" . $IDMuser[ 'semester' ]  ;
$contentA .= " [".$phase."] ";
/*
$contentA .= "<br />Ihr Studiengang";
$contentA .= $tmp = $bl->getStudiengaengeAuswahl( $studiengaenge , $IDMuser['studiengang'] );       if ($DEBUG){echo"<br>SG Auswahl<br>";  deb($tmp)  ;} 
$contentA .= "<br /><br />Ihr Fachsemester";
$contentA .= $tmp = $bl->getFachsemesterAuswahl( $IDMuser );                                        if ($DEBUG){echo"<br>FS Auswahl<br>";  deb($tmp)  ;} 
$contentA .= "</div>";
*/
$contentA .= "<hr />";
$contentA .= $tmp = $bl->getBeleglistenAuswahl($belegliste, $vl_verzeichnis, $IDMuser, $phase );    if ($DEBUG){echo"<br>BL Auswahl<br>";  deb($tmp)  ;} 
$contentA .= "\n\r</form>";
$contentA .= $bl->getAddNewEntryButton( $phase );
$contentA .= $tmp = $bl->getParamForm( $IDMuser );                                                  if ($DEBUG){echo"<br>PARAM Form<br>";  deb($tmp)  ;}   
  
echo $contentA;

function deb($value)
{
  echo "<pre>";
  print_r($value);
  echo "</pre>";
}

?>
</div>
</body>
</html>

