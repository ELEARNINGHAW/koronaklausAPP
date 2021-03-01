<?php
session_start();
#$_SESSION = null;
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Cache-Control: post-check=0, pre-check=0", false);

#deb($_SESSION);

require_once( "../inc/db.class.php" );
$db                     = new DB();
$_SESSION[ 'type' ]     = 'EMIL';
#include ("checkreferer.php");  ## TODO CHECKER!!



if ( isset( $_GET[ 'un' ] ) )  # Nutzerdaten von moodle übernehmen
{
  $_SESSION[ 'user' ] = decodeUserData( $_GET );
  $u = $db -> getDozentByUserID( $_SESSION[ 'user' ][ 'userID' ] );
  $_SESSION[ 'user' ][ 'abk' ] = $u[ 'abk' ];
  $db -> setKoordinator(  $_SESSION[ 'user' ] );
}



if(  $_SESSION[ 'type' ] == 'EMIL' )
{
  $_SESSION[ 'user' ][ 'showContent' ] = false;
  if ( isset( $_GET [ 'abk' ] ) ) # Aufruf von Kürzel Eingabemaske
  {
    $_SESSION[ 'user' ][ 'abk' ] = $_GET [ 'abk' ];
    $_SESSION[ 'GET'  ] = $_GET;
 
    $db -> updateDozent_abk( $_SESSION[ 'user' ] );

    #$_SESSION[ 'user' ] = $db -> getDozentByKurzel( $_SESSION[ 'GET' ]  [ 'abk' ] );
    unset($_GET [ 'abk' ]);
  }
  checkRequiredValues();
}


if(  $_SESSION[ 'type' ] == 'STALONE' )
{
  $_SESSION[ 'GET' ] = $_GET;
  $_SESSION[ 'user' ][ 'showContent' ] = false;
  
  if ( isset( $_SESSION[ 'GET' ][ 'abk' ] ) ) # Aufruf von Kürzel Eingabemaske
  {
    $_SESSION[ 'user' ] = $db -> getDozentByKurzel( $_SESSION[ 'GET' ] [ 'abk' ] );
    checkRequiredValues();
    unset($_SESSION['GET']['abk']);
  }

  else if (isset($_SESSION['GET']['email']) OR isset($_SESSION['GET']['userID']) ) # Aufruf mit email und/oder userID
  {
    $db -> updateDozent($_SESSION['user']);
    $_SESSION['user']  = $db -> getDozentByKurzel( $_SESSION[ 'user' ] [ 'abk' ] );
    checkRequiredValues();
    unset($_SESSION['GET']['email']);
    unset($_SESSION['GET']['userID']);
  }
  else
  {
    checkRequiredValues();
  }
  unset ($_SESSION['GET']);
}

setTxt(); echo $_SESSION[ 'txt' ][ 'head' ];

if ($_SESSION['user']['showContent'] == true )
{
	$con = '';
	if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="belegliste.php?go=1"                     target="content"  title="Klausurenübersicht" 	>Klausurenübersicht</a>';
  if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="belegliste.php?go=2"                     target="content"  title="Klausuren Sortiert"  >Klausuren Sortiert</a>';
	if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="basistables/mdl_haw_veranstaltungen.php" target="content"  title="Veranstaltungen"	    >DB: Veranstaltungen</a>';
	if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="basistables/mdl_haw_studiengaenge.php"   target="content"  title="Studiengaenge"	      >DB: Studiengänge</a>';
	if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="basistables/mdl_haw_professoren.php"     target="content"  title="Professoren" 		    >DB: Lehrende</a>';
	if ($_SESSION['user']['ro'] >= 3) $con .=  '<a class="reiter2" href="../inc/Excel-to-MySQL/"	                target="content"  title="EXCEL IM/EXPORT"     >EXCEL IM/EXPORT</a>';
  if ($_SESSION['user']['ro'] >= 2) $con .=  '<br><iframe style="position: absolute; top:24px; border: none"  name="content" src="belegliste.php?go=1"></iframe>';
  echo $con;
}

function checkRequiredValues()
{
  $_SESSION['user']['showContent'] = false;
  if ( !isset($_SESSION[ 'user' ][ 'abk' ]) OR ( $_SESSION[ 'user' ][ 'abk' ] == '' ) )  ## User bei KK noch nicht bekannt
  {
    setTxt(); echo $_SESSION[ 'txt' ][ 'infotxt1' ];
  }
  
  else if ( !isset($_SESSION[ 'user' ][ 'email'  ]) OR ( $_SESSION[ 'user' ][ 'email'  ]  == '')
         OR !isset($_SESSION[ 'user' ][ 'userID' ]) OR ( $_SESSION[ 'user' ][ 'userID' ]  == '')
          )  ## User bei KK noch nicht bekannt
  {
    setTxt(); echo $_SESSION[ 'txt' ][ 'infotxt3' ];
  }

  else
  {  /*
    if
    (     $_SESSION[ 'user' ][ 'userID' ]  == 'aaa860'
      OR  $_SESSION[ 'user' ][ 'userID' ]  == 'aas199'
      OR  $_SESSION[ 'user' ][ 'userID' ]  == 'abh419'
    )
    {
      $_SESSION['user']['ro'] = 2;  ## Koordinator, Admin
    }
    else
    {
     #$_SESSION['user']['ro'] = 3;  ## Teilnehmer, Dozierende
    }
  */
    $_SESSION[ 'user' ][ 'showContent' ] = true;
 
    if ( empty( !$_GET ) )
    header("Location:".$_SERVER[ 'SCRIPT_NAME' ]."" );
  }
}

function decodeUserData($user_enc)
{
  $user[ 'uid'        ] = b64de( $user_enc [ 'uid' ] );
  $user[ 'userID'     ] = b64de( $user_enc [ 'un'  ] );
  $user[ 'firstname'  ] = b64de( $user_enc [ 'fn'  ] );
  $user[ 'lastname'   ] = b64de( $user_enc [ 'ln'  ] );
  $user[ 'se'         ] = b64de( $user_enc [ 'se'  ] );
  $user[ 'email'      ] = b64de( $user_enc [ 'm'   ] );
  $user[ 'id'         ] = b64de( $user_enc [ 'id'  ] );
  $user[ 'fa'         ] = b64de( $user_enc [ 'fa'  ] );
  $user[ 'dp'         ] = b64de( $user_enc [ 'dp'  ] );
  $user[ 'ro'         ] = b64de( $user_enc [ 'ro'  ] );
  $user[ 'sx'         ] = b64de( $user_enc [ 'sx'  ] );
  $user[ 'an'         ] = b64de( $user_enc [ 'an'  ] );
  $user[ 'ma'         ] = b64de( $user_enc [ 'ma'  ] );
  $user[ 'sn'         ] = b64de( $user_enc [ 'sn'  ] );
  $user[ 'cn'         ] = b64de( $user_enc [ 'cn'  ] );
  $user[ 'cid'        ] = b64de( $user_enc [ 'cid' ] );
  $user[ 'mid'        ] = b64de( $user_enc [ 'mid' ] );
  $_SESSION[ 'user' ] = $user;
  return $user;
}

function b64de($val)
{
  return base64_decode ( rawurldecode( $val ) );
}


  function deb($var)
  {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }


function setTxt()
{
$_SESSION['txt']['infotxt1']
 = '<main><div class="row"><div class="column"><div class="box"><div class="header2">
<h2 style="text-align: center">Hallo  ' . $_SESSION["user"]['firstname'] . '  ' . $_SESSION["user"]['lastname'] . '</h2></div><div style="margin-left:40%;"><p style="margin-left:-10%;">
Bitte geben Sie Ihr Namenskürzel ein:
<form id="abk" action ="' . $_SERVER['PHP_SELF'] . '"><input  id="abk" name="abk" type="text"></form></p></div></div></div></main></div>';
  
$_SESSION['txt']['infotxt2']
 = '<main><div class="row"><div class="column"><div class="box"><div class="header2">
<h2 style="text-align: center">Hallo  ' . $_SESSION["user"]['firstname'] . '  ' . $_SESSION["user"]['lastname'] . '</h2></div><p style="margin-left:20%;">
Ihr eingegebenes Kürzel wird nicht erkannt nicht, bitte geben Sie erneut Ihr Namenskürzel ein:
<div style="margin-left:40%;"><form id="abk" action ="' . $_SERVER['PHP_SELF'] . '"><input  id="abk" name="abk" type="text"></form></p></div></div></div></main></div>';
  
$_SESSION['txt']['infotxt3']
    = '<main><div class="row"><div class="column"><div class="box"><div class="header2">
<h2 style="text-align: center">Hallo  ' . $_SESSION["user"]['firstname'] . '  ' . $_SESSION["user"]['lastname'] . '</h2></div>
<div style="margin-left:20%;">Ihr Nutzerdaten sind noch unvollständig, bitte geben Sie diese ein ein:</div>
<div style="margin-left:20%;"><form id="abk" action ="' . $_SERVER['PHP_SELF'] . '">
<br><label>Ihre HAW-Emailadresse:  </label><input  style="left:400px; width: 500px;" id="email" name="email" type="text" value="' . $_SESSION['user']['email'] . '">
<br><br><label>Ihre HAW-Kennung (aaa123):  </label><input  style="left:400px;" id="userID" name="userID" type="text" value="' . $_SESSION['user']['userID'] . '">
<br><br><input   id="OK" name="OK" type="submit">

</form></p></div></div></div></main></div>';
  
$_SESSION[ 'txt' ][ 'head' ] = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<meta http-equiv=\"cache-control\" content=\"no-cache\">
<meta http-equiv=\"pragma\" content=\"no-cache\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"lib/style.css\" />
<title>Koronaklaus</title>
</head><body>";

}