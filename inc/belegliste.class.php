<?php
class Belegliste 
{
var $db;
var $dbIDM;

function __construct($db, $dbIDM = null)
{ $this->db   = $db;
  $this->dbIDM = $dbIDM;
}

function b64de($val)
{  return base64_decode ( rawurldecode( $val ) );
}

function getParamForm( $IDMuser )
{ $form  = "";
  $form .=  "<form  method=\"post\"      name=\"param\" action=\"".$_SERVER[ 'PHP_SELF' ]."\" >\n";
  $form .=  "<input name=\"a\"           type=\"hidden\" value=\"update\" />\n";
  $form .=  "<input name=\"col\"         type=\"hidden\" />\n";
  $form .=  "<input name=\"val\"         type=\"hidden\" />\n";
  $form .=  "<input name=\"id\"          type=\"hidden\" />\n";
  $form .=  "<input name=\"checksum\"    type=\"hidden\" />\n";
  $form .=  "<input name=\"semester\"    type=\"hidden\" value=\"".$IDMuser[ 'semester' ]."\"/>\n";
  $form .=  "<input name=\"studiengang\" type=\"hidden\" value=\"".$IDMuser[ 'studiengang' ] ."\"/>\n";
  $form .=  "<input name=\"matrikelnr\"  type=\"hidden\" value=\"".$IDMuser[ 'matrikelnr' ]  ."\"/>\n";
  $form .=  "<input name=\"akennung\"    type=\"hidden\" value=\"".$IDMuser[ 'akennung' ]  ."\"/>\n";
  $form .=  "</form>\n";
  return $form;
}

function getJavaScript()
{
return "<script type=\"text/javascript\">
function update(col  ,value, id)
{   
  checksum    =\"\";
  akennung    = document.param.akennung.value    =  document.belegliste.akennung.value;
  matrikelnr  = document.param.matrikelnr.value  =  document.belegliste.matrikelnr.value;

  if(id)
  {
    veranstaltungID = eval(\"document.belegliste.veranstaltung\"+ id +\".value\");
    checksum = akennung + \";\"+veranstaltungID + \";\"+ matrikelnr;
  }

  document.param.col.value      = col;
  document.param.val.value      = value;
  document.param.id.value       = id;
  document.param.checksum.value = checksum; 
  document.param.submit();
}
</script>
";

}


function getstudiverwaltunghtmlhead()
{
 return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- script src="lib/lib.js" type="text/javascript"></script -->
<link rel="stylesheet" type="text/css" href="lib/style.css" />
<title>Belegliste</title></head>
<body style="margin:0; padding:0;" ><div style="width:220px">';
}


function getAddNewEntryButton( $phase = 1 )
{ if ( $phase >= 1 && $phase <= 3  )
  { return "\n\r<a  href=\"#\" class=\"addItem\" id=\"addItem\"  onclick=\"update('neuerBeleglistenEintrag',false,false); return false;\"  alt=\"ADD\" title=\"ADD\"  type=\"image\">Neuer Eintrag <img  border=\"0\" src=\"pix/p.png\"></a>\n\r";
  }
}

function getFilterID()
{   if    ( isset( $_POST[ 'filterID' ] ) )                    { $veranstaltungsFilterID = $_POST[ 'filterID' ]; }
    elseif( isset( $_GET[ 'F'         ] ) )                    { $veranstaltungsFilterID = $_GET[ 'F' ];         } 
    elseif( isset( $_POST[ 'filterID' ] )  || (isset ( $_POST[ 'F' ]) ) ) {} 
    else { $veranstaltungsFilterID =  -1;                  }
    return $veranstaltungsFilterID ;
}

function getHeliosAuswahl()
{ $filterListe = null;
  
  if ( isset ($_POST[ 'SUB' ] ))                                              /* Ermittelt die angeklickten Felder für den HELIOS Export und erstellt die entsprechende Filterliste */
  {  foreach ( $_POST as $P )
     {  if( $P != "-SELECTED-" )
        { $filterListe[] =  $P ; }
     }
  }
  return $filterListe;
}


function isChangeable()
{ if( $_SESSION['user']["ro"] >= 2 ) { $changeable    = true; }
  else                      { $changeable    = false; }
  return $changeable;
}


function getParams()
{
   $param = '';
   
   if ( isset( $_POST[ 'a'        ] ) ) $param[ 'action'   ] = $_POST[ 'a'        ];
   if ( isset( $_POST[ 'col'      ] ) ) $param[ 'column'   ] = $_POST[ 'col'      ];
   if ( isset( $_POST[ 'val'      ] ) ) $param[ 'value'    ] = $_POST[ 'val'      ];
   if ( isset( $_POST[ 'id'       ] ) ) $param[ 'ID'       ] = $_POST[ 'id'       ];
   if ( isset( $_POST[ 'checksum' ] ) ) $param[ 'checksum' ] = $_POST[ 'checksum' ];
   if ( isset( $_POST[ 'filterID' ] ) ) $param[ 'filterID' ] = $_POST[ 'filterID' ];
   
   if ( isset( $_GET[ 'A'         ] ) ) $param[ 'A' ]        = $_GET[ 'A' ];

   return $param;
}

function getCurrentPhase()
{
### ------------  ERMITTELT DIE AKTUELLE PHASE ------------
$phasewechsel = $this->db->getPhasen();
$phase        = 0; 
$pwERROR      = false;
$pwOld        = 0;

if ( isset($_SESSION[ 'intern' ]) AND $_SESSION[ 'intern' ] != 'true' )                                                              // -- Beschränkung nur bei Studiansicht
{ foreach ( $phasewechsel as $pw  )
  { if ( $pw > $pwOld ) { $pwOld = $pw; } else { $pwERROR = true; echo "ERROR: Phasenwechsel"; }
  }
  
  if ( time() > $phasewechsel[1] )  {  $phase = 1; }   
  if ( time() > $phasewechsel[2] )  {  $phase = 2; }   
  if ( time() > $phasewechsel[3] )  {  $phase = 3; }                         
  if ( time() > $phasewechsel[4] )  {  $phase = 4; }                         
}
else                                                                                                // -- Keine Beschränkung bei Koordinatorenansicht 
{ $phase =  1;
}

return $phase;
}

function deb($var)
{   echo "<pre>";
    print_r($var);
    echo "</pre>";
}

function getInput()
{
$IDMuser[ 'mail'        ] = "";
$IDMuser[ 'vorname'     ] = "";
$IDMuser[ 'nachname'    ] = "";
$IDMuser[ 'akennung'    ] = "";
$IDMuser[ 'matrikelnr'  ] = "";
$IDMuser[ 'studiengang' ] = "";  
$IDMuser[ 'stg'         ] = "";
$IDMuser[ 'department'  ] = "";  
$IDMuser[ 'semester'    ] = "";
/* */

/*-------------------------------------------------------------------------------------------------------------------------------------------*/
if($_POST)                                                                                          /* Änderungen des Nutzers werden registriert */
{
  $param[ 'action'   ] = $_POST[ 'a'        ];                                                     # if ($DEBUG)  echo 'Änderungen des Nutzers werden registriert';
  $param[ 'column'   ] = $_POST[ 'col'      ]; 
  $param[ 'value'    ] = $_POST[ 'val'      ];
  $param[ 'ID'       ] = $_POST[ 'id'       ];
  $param[ 'checksum' ] = $_POST[ 'checksum' ];   
  $param[ 'phase'    ] = $_SESSION[ 'phase' ];   
}
/*-------------------------------------------------------------------------------------------------------------------------------------------*/

/*-------------------------------------------------------------------------------------------------------------------------------------------*/
 
if( $_SESSION['GET'] )                                                                                         /*  Initiale Parameterübergabe über  Moodle */
{
  if ( isset(  $_SESSION['GET'][ 'm'   ] )) { $IDMuser[ 'mail'        ] =  rawurldecode( base64_decode( $_GET[ 'm'  ] ) ); } else { echo "<br>ERROR: no 'mail'       "; }
  if ( isset(  $_SESSION['GET'][ 'fn'  ] )) { $IDMuser[ 'vorname'     ] =  rawurldecode( base64_decode( $_GET[ 'fn' ] ) ); } else { echo "<br>ERROR: no 'vorname'    "; }
  if ( isset(  $_SESSION['GET'][ 'ln'  ] )) { $IDMuser[ 'nachname'    ] =  rawurldecode( base64_decode( $_GET[ 'ln' ] ) ); } else { echo "<br>ERROR: no 'nachname'   "; }
  if ( isset(  $_SESSION['GET'][ 'u'   ] )) { $IDMuser[ 'akennung'    ] =  rawurldecode( base64_decode( $_GET[ 'u'  ] ) ); } else { echo "<br>ERROR: no 'akennung'   "; }
  if ( isset(  $_SESSION['GET'][ 'id'  ] )) { $IDMuser[ 'matrikelnr'  ] =  rawurldecode( base64_decode( $_GET[ 'id' ] ) ); } else { echo "<br>ERROR: no 'matrikelnr' "; }
  if ( isset(  $_SESSION['GET'][ 'sg'  ] )) { $IDMuser[ 'studiengang' ] =  rawurldecode( base64_decode( $_GET[ 'sg' ] ) ); } else { echo "<br>ERROR: no 'studiengang'"; }
  if ( isset(  $_SESSION['GET'][ 'dp'  ] )) { $IDMuser[ 'department'  ] =  rawurldecode( base64_decode( $_GET[ 'dp' ] ) ); } else { echo "<br>ERROR: no 'department' "; }
  if ( isset(  $_SESSION['GET'][ 'se'  ] )) { $IDMuser[ 'semester'    ] =  rawurldecode( base64_decode( $_GET[ 'se' ] ) ); } else { echo "<br>ERROR: no 'semester'   "; }

  $this->dbIDM->setIDMuser( $IDMuser );                                                                 #  if ($DEBUG) echo"<br>neuer Eintrag<br>"; 
 
  $IDMuser[ 'stg' ] =  $this->db->transSG( $IDMuser[ 'studiengang' ] );                                     // Gruppiert ähnliche Studiengänge (zu BT, VT, HC...) 
  
  $_SESSION[ 'IDMuser'    ] =  $IDMuser;                                                           # if ($DEBUG){echo"<br>IDMU SESS<br>";  deb( $_SESSION[ 'IDMuser'  ]);}
}

else 
{ $IDMuser =  $_SESSION[ 'IDMuser'  ];                                                             # if ($DEBUG){echo"<br>INTERN IDMU<br>";  deb($IDMuser);}
}

if ($_GET[ 'sv' ]) 
{  $_SESSION[ 'intern' ]  = rawurldecode( base64_decode( $_GET[ 'sv' ] ) );
   $_SESSION[ 'phase'  ]  = 1;
}
  
return $IDMuser;
}

}
?>
