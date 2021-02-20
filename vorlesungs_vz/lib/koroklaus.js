var curKL   = "";
var curSlot = "";


function updIt0( rID, state = null, save = true , color = 0  )
{ // console.log('rID: ' + rID + ' state: ' + state );
  if (state == null) {   R[rID].state = ++R[rID].state % 2;  }
  else               {   R[rID].state = state;  }

  setIt( R[ rID ], R[ rID ].state, save, color  );
}

function updIt1( cID , state = null, save = true, color = 0, recursiv = true )
{
  //console.log('cID: ' + cID + ' state: ' + state );
  if (state == null) { C[ cID ].state =  ++C[ cID ].state%2; }
  else               { C[ cID ].state =  state; }

  setIt( C[ cID ] ,C[ cID ].state , save, color  );

  if(recursiv)
  {  C[ cID ].R.forEach( function ( rID ) {  updIt0( rID , C[ cID ].state , save , color, recursiv  );  } );
  }
}


function updIt2( lID  , state = null, save = true, color = 0, recursiv = true )
{   //console.log('lID: ' + lID );
    if (state == null)  {  L[ lID ].state =  ++L[ lID ].state%2; }
    else                {  L[ lID ].state =  state; }

    setIt( L[ lID ] ,L[ lID ].state , save , color);

    if(recursiv)
    {
    L[ lID ].C.forEach( function ( cID ) {  updIt1(  cID  , L[ lID ].state , save  , color , recursiv);   } );
    }
}


function updIt3( fID  , state = null, save = true, color = 0, recursiv = true )
{   //console.log('fID: ' + fID );
    if (state == null)  {  F[ fID ].state =  ++F[ fID ].state%2; }
    else                {  F[ fID ].state =  state; }

    setIt( F[ fID ] ,F[ fID ].state , save , color  );
    if(recursiv)
    {
        F[fID].L.forEach(function (lID)
        {
            updIt2(lID, F[fID].state, save, color, recursiv);
        });
    }
}

function updIt4( eID  , state = null, save = true, color = 0, recursiv = true )
{   //console.log('eID: ' + eID );
    if (state == null)  {  E[ eID ].state =  ++E[ eID ].state%2; }
    else                {  E[ eID ].state =  state; }

    setIt( E[ eID ] , E[ eID ].state , save , color  );

    if(recursiv)
    { E[eID].F.forEach(function (fID)
      {
        updIt3(fID, E[eID].state, save, color, recursiv);
      });
    }
}

function iterate(item, index)
{
   // console.log(`${item} has index ${index}`);
}


function getPers(str)
{   var p = 0; for (r in R)  {  if ( str.includes( R[r].ID  )) { p +=  R[r].pers; } } ;
    return( p );
}

function setIt( x, STATE , save = false , color = 0 )
{
    if ( STATE ) { x.jq.addClass( "ram"+color ); }
    else
    {
        x.jq.removeClass( "ram0" );
        x.jq.removeClass( "ram1" );
        x.jq.removeClass( "ram2" );
        x.jq.removeClass( "ram3" );
        x.jq.removeClass( "ram4" );
        x.jq.removeClass( "ram5" );
        x.jq.removeClass( "ram6" );
    }

    rIDList =  $( '#KL'  + curKL ).val( );  // Raumliste =  Text im Feld "Raum" der zur Zeit aktivem Klausur
    rID     =  x.ID + ',' ;

    if ( save )
    { if ( STATE )  // Raum der Liste hinzufügen
      { if ( !rIDList.includes( rID ) )    // Raum steht noch nicht in der Liste
        { $( '#KL' + curKL ).val(function ( i, text2 )  { return text2 +  rID ; } ); // RaumID wird in die Liste eingetragen
        }
      }

      else // Raum von der Liste entfernen
      { $('#KL'  + curKL ).val(function ( i, text )  { return rIDList.replace( rID , '' ); } );
      }

      anz =  $( "#KL" + curKL ).val( );
      for ( j = 0; j < 3; j++ ) { for ( i = 0; i < 1000000; i++ ); };
      $.ajax({  type: "get",  url: "ajax.php?action=changeRaum&id=" + curKL + "&val=" + anz });

      $( "#S" + curKL ).val( getPers( $( "#KL" + curKL ).val( ) ) );
      updateRaumListe();
    }

}

function updateRaumListe()
{
  str2    = '';
  rIDList = $('#KL'  + curKL ).val();
  for( r in R )
  {   if ( rIDList.includes( R[ r ].ID ) && !( str2.includes( R[ r] .name ) ) )
      { str2 +=  R[ r ].name + ", ";
      }
  } ;   //if ( R[r].ID == rl && rl < 2000  )
  $('#sav' + curKL ).val( str2 );
}


function updateDisplay( curKL, color = 0 )
{
    Rlist = $( "#KL" + curKL + "" ).val( );
    for ( e in E)  { if (Rlist.includes( E[e].ID ) ) {  updIt4( e ,1,0, color, false); }  }
    for ( f in F)  { if (Rlist.includes( F[f].ID ) ) {  updIt3( f ,1,0, color, false ); }  }
    for ( l in L)  { if (Rlist.includes( L[l].ID ) ) {  updIt2( l ,1,0, color, false ); }  }
    for ( c in C)  { if (Rlist.includes( C[c].ID ) ) {  updIt1( c ,1,0, color, false); }  }
    for ( r in R)  { if (Rlist.includes( R[r].ID ) ) {  updIt0( r ,1,0, color ); }  }
}


function updateAnote( kID, val )
{
  $("#bemerkung" + kID).toggle("fade");
  $("#bemerkung" + kID).toggle("fade");
  $.ajax({type: "post", data: {val: this.value}, url: "ajax.php?action=changeanote&id=" + kID + "&val=" + val})
}

function ID2name(kID)
{
  $('#S' + kID ).val(getPers($('#KL' + kID ).val()));
  str2    = '';
  rIDList = $( '#KL' + kID ).val();

  for( r in R )
  {  if ( rIDList.includes( R[ r ].ID ) && !( str2.includes( R[ r ] .name ) ) )
     { str2 += R[ r ].name + ', ';
    }
  }
  $('#sav' + kID ).val( str2 );
}

function deactivateKL(klausID)
{
  $('#sav'+ klausID ).removeClass( "grey3" );
  $('#S'  + klausID ).removeClass( "ram1"  );
}

function setCurKL( kl, sl )
{
  curKL = kl; // -- set globale Variable

  for ( const [ key, value ] of Object.entries( SLO ) )  { value.KL.forEach( deactivateKL ) ; }

  $( '#sav' + kl + '' ).addClass( "grey3" )                                             // Aktive Klausurzeile markieren
  $( '#S'   + kl + '' ).addClass( "ram1"  )

  setCurSlot(  sl, kl );

  updateDisplay(kl);
}

function setCurSlot( sl , kl = null)
{
  updIt4( "UL" ,0,0 );                                                   // Menu-Display vollständig zurücksetzten
  updIt4( "HO" ,0,0 );
  updIt4( "HW" ,0,0 );

  SLO[ sl ].KL.forEach( function(kID) {updateDisplay(kID, 0);})                    // alle Räume des aktuellen Timeslots in Display anzeigen

  if ( kl )  { updateDisplay( kl, 1 );  }                                          // Räume der aktuellen Klausur im Display anzeigen

  for (const [key, value] of Object.entries(SLO))
  {
    $('#'+ value.ID +'').removeClass( "grey2" );      // ALLE Timeslots Display vollstängig zurücksetzten
  }

  $('#'+ sl ).addClass( "grey2" )                                           // aktueller Timeslotz aktiv anzeigen
}

function getObjectBykID( kID )
{
  for( r in R )  { if ( R[ r ].ID == kID )  { return R[ r ]; } } ;
}

function saveIsOk(bID)
{ url2 = 'ajax.php?action=changeChecked&id='+bID+'&val=';
  if( SLO[bID].state == 0)
  {
    $.ajax({ type: "post", url: url2+1 } )
    $("#KL"+bID).prop('disabled', true);
    $("#sav"+bID).prop('disabled', true);
  }
  else
  {
    $.ajax({ type: "post", url: url2+0 } )
    $("#KL"+bID).prop('disabled', false);
    $("#sav"+bID).prop('disabled', false);
  }
}

let txtNotOK = 'NICHT GEPRÜFT!';
let txtOK    = 'GEPRÜFT!';
let bgNotOK  = '#d4d6ff';
let bgOK     = '#b5ffd5';



function setIsOkButton(bID)
{ if(SLO[bID].state == 0){ SLO[bID].state = 1;  $("#TSisOK"+bID).val( txtNotOK ).addClass("butOK")  }
  else                   { SLO[bID].state = 0;  $("#TSisOK"+bID).val( txtOK    ).removeClass("butOK")  }
}


function ISOhandler(entries, observer)
{
  for (entry of entries)
  {
    //console.log(entry);
    statusText.textContent = entry.target.id;
	setCurSlot(entry.target.id);
    if (entry.isIntersecting) 
	{ // console.log(entry.target.id);
      statusBox.className = entry.target;
    }
	else
	{
      statusBox.className = "no";
    }
  }
}

/* By default, invokes the handler whenever:
   1. Any part of the target enters the viewport
   2. The last part of the target leaves the viewport */
