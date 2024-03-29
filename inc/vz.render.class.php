<?php
class Render
{
  var $WT = array('0'=>'Montag', '1'=>'Dienstag', '2'=>'Mittwoch', '3'=>'Donnerstag', '4'=>'Freitag', '5'=>'Samstag', '6'=>'Sonntag', '7'=>'NN' );
  var $CO = array('0' => '#F08080', '1' => '#fffede', '2' => '#adab61', '8' => '#F08080', '9' => '#E9967A', '10' => '#FA8072', '11' => '#FFA07A', '12' => '#884588', '13' => '#FFA500', '14' => '#FFD700', '15' => '#B8860B', '16' => '#DAA520', '17' => '#EEE8AA', '18' => '#BDB76B', '19' => '#F0E68C', '20' => '#808000', '21' => '#FFFF00' );
  
  function renderKlausurListe( $vorlesungsliste , $I , $changeable = false )
  {
    $tab   = null;
    $tabX  = null;
    $tabXX = null;
    $tmp1  = $tmp2 =  $tmpA = '';
    $ro    = '';
    $i     = 0;
    
    $phase = $_SESSION[ 'phase' ];
    
    $headline = " Klausurenübersicht";
   
    if ( $_SESSION[ 'user' ][ 'ro' ] <= 2 ) { $ed = 'readonly' ; $role = 'user' ;  $bo = ' bw '; }
    else                                    { $ed = ''         ; $role = 'staff';  $bo = ''    ; }

    if ( $_SESSION[ 'phase' ] == 1) { $c7active = ' cA '; } else {  $c7active = '';  }
    if ( $_SESSION[ 'phase' ] == 2) { $c8active = ' cA '; } else {  $c8active = '';  }
  
    if ( $_SESSION[ 'phase' ] == 2 AND $role == 'user'  )   { $ro = 'disabled '; }
    else                                                    { $ro = '';          }
    
    if( $ed == '' ) $headline .= "<a style=' float:right; width: 18px; display: inline; background-color: #FAFAFA' target=\"help_win\" class=\"modalLink\" href=\"#helpit\" rel=\"modal:open\"  title=\"Weitere Informationen über Koronaklaus\" ><img src=\"../vorlesungs_vz/img/help.svg\"   width=\"18\"  height=\"18\" style= \"padding-right: 2px; margin:0px; margin-bottom:-2px;\"  /></a>";
   
    $tab .= "<h2 style='position:relative; top: 0px;'>".$headline."</h2>";
    $tab .= "\n\r<form  method='post'  name='beleglisteGesamt' action='".$_SERVER['PHP_SELF']."' >";
    $tab .= "<table  class=\"belegTabelle\">\r\n";
    $tab .= "<thead><tr> ";
    if( $changeable             ) { $tab .= "<th class=\"c0 header\">ID           </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c1 header\">Dozierende   </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c2 header\">LVA          </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c3 header\">Sem          </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c4 header\">SG           </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c5 header\">Datum        </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c6 header\">Zeit         </th>\r\n ";}
    #if( ( $role=='staff' ) OR ( $role=='user' AND $phase == 1 ) )
    { $tab .= "<th class=\"c7 " .$c7active." header\">Anz. Studi<br>(1. grob)    </th>\r\n ";}
    if( ( $role=='staff' ) OR ( $role=='user' AND $phase == 2 ) ) { $tab .= "<th class=\"c8 " .$c8active." header\">Anz. Studi<br>(2. fein)  </th>\r\n ";}
    if( $changeable             ) { $tab .= "<th class=\"c9 header\">Bemerkung    </th>\r\n ";}
    if(   $role=='staff'        ) { $tab .= "<th class=\"c10\"><a title='Neuer Klausrendatensatz hinzufügen' style='background-color: #0F0F0F' href=\"".$_SERVER['PHP_SELF']."?action=addone&go=1\" ><img  id=\"addone\" src=\"../vorlesungs_vz/img/p.gif\"></a></th>\r\n ";}
    else                          { $tab .= "<th class=\"c10\"></th>\r\n "; }
    $tab .= "</tr></thead> \r\n \r\n";
    
    if($vorlesungsliste)
    { $tab .= "<tbody>\r\n";
      
      foreach($vorlesungsliste as $vll )
      { $tabX= $this -> formatDozLVA( $vll );
        $tabXX[]                = $tabX;
        unset($tabX);
      }
      
      if($tabXX)
      { $i = 0;
        foreach( $tabXX as $tabX )
        { $i++;
          $tab .= "<tr class='t1'   id=\"row_"  .$tabX[ 'ID' ]. "\">";
          $tab .= "<td class='c0 center'>" .$tabX[ 'ID' ]. "</td>\r\n";
          $tab .= "<td class='c1' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'dozname'                          ] . "</span><input  $ed  class=\"dozname " . $bo . "\" id=\"dozname"  .$tabX[ 'ID' ]. "\"   type=\"text\"   value=\"" .$tabX[ 'dozname'   ]  . "\" list=\"doznames\"                                                                    ></div></td>\r\n";
          $tab .= "<td class='c2' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'LVA'                              ] . "</span><input  $ed  class=\"LVA "     . $bo . "\" id=\"LVA"      .$tabX[ 'ID' ]. "\"   type=\"text\"   value=\"" .$tabX[ 'LVA'       ]  . "\" list=\"LVA\"                                                                         /></div></td>\r\n";
          $tab .= "<td class='c3' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'sem'                              ] . "</span><input  $ed  class=\"sem "     . $bo . "\" id=\"sem"      .$tabX[ 'ID' ]. "\"   type=\"number\" value=\"" .$tabX[ 'sem'       ]  . "\" min=\"0\"  max=\"20\" maxlength=\"2\" required size=\"10\"                           /></div></td>\r\n";
          $tab .= "<td class='c4' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'SG'                               ] . "</span><input  $ed  class=\"SG "      . $bo . "\" id=\"SG"       .$tabX[ 'ID' ]. "\"   type=\"text\"   value=\"" .$tabX[ 'SG'        ]  . "\" list=\"SG\"            maxlength=\"5\"  required size=\"1\" pattern=\"[A-Z]{1,1}\"   /></div></td>\r\n";
          $tab .= "<td class='c5' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'date'                             ] . "</span><input  $ed  class=\"date "    . $bo . "\" id=\"date"     .$tabX[ 'ID' ]. "\"   type=\"date\"   value=\"" .$tabX[ 'date'      ]  . "\" /></div></td>\r\n";
          $tab .= "<td class='c6' ><div class=\"ui-widget\"><span class='hidden'>" .$tabX[ 'time'                             ] . "</span><input  $ed  class=\"time "    . $bo . "\" id=\"time"     .$tabX[ 'ID' ]. "\"   type=\"time\"   value=\"" .$tabX[ 'time'      ]  . "\"  step=\"1800\"  min=\"6:00\" max=\"0:00\"                                            /></div></td>\r\n";

        #if(    ( $role=='staff' ) OR ( $role=='user' AND $phase == 1 ) )
        { $tab .= "<td class='c7  " .$c7active." ' ><div class=\"ui-widget\"><span class='hidden'>" . $tabX[ 'anzStudis' ][ '1' ] . "</span><input    class=\"aSt2\"    " .$ro. "  id=\"anzStdIn" .$tabX[ 'ID' ] . "_1\" type=\"number\" value=\"". $tabX[ 'anzStudis' ][ '1' ] . "\"  min=\"0\" max=\"200\"                                                         /></div></td>\r\n"; }
       
        if(    ( $role=='staff' ) OR ( $role=='user' AND $phase == 2 ) )
        { $tab .= "<td class='c8 " .$c8active." ' ><div class=\"ui-widget\"><span class='hidden'>"  . $tabX[ 'anzStudis' ][ '2' ] . "</span><input       class=\"aSt2\"                      id=\"anzStdIn" . $tabX[ 'ID' ] . "_2\" type=\"number\" value=\"" . $tabX[ 'anzStudis' ][ '2' ] . "\"  min=\"0\" max=\"200\"                                                /></div></td>\r\n"; }
          $tab .= "<td class='c9' ><div class=\"ui-widget\"><span class='hidden'>" . $tabX['anote']                               . "</span><textarea    wrap=\"hard\"  class=\"anote ta3 ". $bo ."\"  id=\"anote"    . $tabX[ 'ID' ] . "\"   name=\"anote" . $tabX['ID'] . "\"  rows=\"" . (floor(strlen($tabX['anote']) / 60)) . "\" cols=\"15\"  wrap=\"on\" style='height:55px; width:100%; ' >" . $tabX['anote'] . "</textarea></div></td>\r\n";
       
        if(     $role=='staff' )
        { $tab .= "<td class='c10' > <div class=\"ui-widget\"><img  class=\"center\" title='Diesen Klausrendatensatz löschen'   id=\"kill_"    . $tabX[ 'ID' ] . "\"   src='../vorlesungs_vz/img/m.png'></div></td>\r\n"; }
       
        else
        { $tab .= "<td class='c10' > <div class=\"ui-widget\"></div></td>\r\n";}
        
          $tab .= "</tr>\r\n";

          $tmpA .=  '$("#dozname'  .$tabX[ "ID" ].'"  ).on("change",function() { $("#dozname'  .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changedozn&id='   .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#LVA'      .$tabX[ "ID" ].'"  ).on("change",function() { $("#LVA'      .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changeLVA&id='    .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#SG'       .$tabX[ "ID" ].'"  ).on("change",function() { $("#SG'       .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changeSG&id='     .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#sem'      .$tabX[ "ID" ].'"  ).on("change",function() { $("#sem'      .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changeSem&id='    .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#date'     .$tabX[ "ID" ].'"  ).on("change",function() { $("#date'     .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changedate&id='   .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#time'     .$tabX[ "ID" ].'"  ).on("change",function() { $("#time'     .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changetime&id='   .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";

        if(     ( $role=='staff' ) OR ( $role=='user' AND $phase == 1 ) )
        { $tmpA .= '$("#anzStdIn' . $tabX["ID"] . '_1").on("change",function() { $("#anzStdIn' . $tabX["ID"] . '_1" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post", url: "ajax.php?action=changeSAnz1&id=' . $tabX["ID"] . '&val="  + this.value } ); } );' . "\r\n"; }

        if(     ( $role=='staff' ) OR ( $role=='user' AND $phase == 2 ) )
        { $tmpA .= '$("#anzStdIn'  .$tabX[ "ID" ].'_2").on("change",function() { $("#anzStdIn' .$tabX[ "ID" ].'_2" ).css("background-color", "#c2ffc2"); $.ajax({ type: "POST", url: "ajax.php?action=changeSAnz2&id='  .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n"; }
          $tmpA .=  '$("#anote'    .$tabX[ "ID" ].'"  ).on("change",function() { $("#anote'    .$tabX[ "ID" ].  '" ).css("background-color", "#c2ffc2"); $.ajax({ type: "post",   data: { val : this.value },  url: "ajax.php?action=changeanote&id='   .$tabX[ "ID" ].'&val="  + this.value } ); } );'."\r\n";
          $tmpA .=  '$("#kill_'    .$tabX[ "ID" ].'"  ).on("click" ,function() { $.ajax({ type: "post", url: "ajax.php?action=deleterow&id='    .$tabX[ "ID" ].'&val="  + 0 } ); $( "#row_'.$tabX[ "ID" ].'" ).hide();} );'."\r\n";
        }
      }
      $tab .= "</tbody>\r\n";
    }
    
    $tab .="</table>\r\n";
    $tab .="</form>\r\n";
    
    $tmp2 .= '<script type="text/javascript">//<![CDATA['."\r\n" . $tmpA . "\r\n".'//]]></script>';
    $tmp2 .= '<script type="text/javascript"> $(document).ready(function(){'."\r\n" .$tmp1.= "\r\n".'});</script>';
    
    $datalist_doz = '<datalist id="doznames">'."\r\n";
    foreach ( $I['alldozenten'] as $doz )
    { if ( $doz[ 'firstname' ] != '' ) $firstname = ", ".  $doz[ 'firstname' ];
      else                             $firstname = '';
      $datalist_doz  .=  '<option value="' .  $doz[ 'lastname' ].  $firstname   .  ' / ' . $doz[ 'abk' ].'">'."\r\n" ;
    }
    $datalist_doz .= '</datalist>'."\r\n";
    
    $datalist_LVA = '<datalist id="LVA">'."\r\n";
    foreach ( $I['allLVA'] as $LVA )
    { $datalist_LVA  .=  '<option value="' .  $LVA[ 'name' ]. ' / ' . $LVA[ 'abk' ].'">'."\r\n" ;
    }
    $datalist_LVA .= '</datalist>'."\r\n";
    
    $datalist_SG = '<datalist id="SG">'."\r\n";
    foreach ( $I['allSG'] as $SG )
    { if ($SG[ 'abk2' ] != '')
      $datalist_SG  .=  '<option value="' .  $SG[ 'abk2' ].  '">'."\r\n" ;
    }
    $datalist_SG .= '</datalist>'."\r\n";
    
    $tab .= $tmp2;
    
    $tab .= $datalist_doz;
    $tab .= $datalist_LVA;
    $tab .= $datalist_SG;
    return $tab;
    #  return '<div style="display:inline-block; float:left; overflow: auto; height: 100%;   ">'.$tab.'</div>';
  }
  

  function renderExtKlausurListe( $vorlesungsliste , $I, $db, $changeable = false )
  { $i = 0;
    $tab   = null;
    $tabX  = null;
    $tabXX = null;
    
    $r = $_SESSION[ 'liste' ]['raum'];
      
    foreach ($_SESSION[ 'liste' ]['raum'] as $raum )  { $rx[ $raum['shortname'] ]  =   $raum['roomID'];  }
  
    $slotlist = "var SLO = new Object();";
    
    $JSisObserver   = "; let options = {  root: document.getElementById('viewport2'),     rootMargin: '0px',  threshold: 0 }; ";
    
    $JSb2   = "";
    
    $KL     = "; let KL = [";
    $KLI    = "; let KLI = [";
    $ajax1  = '';
    
    if ( $_SESSION['user']['ro'] <= 2 ) { $ed = 'readonly' ; } else { $ed ='';}
    
    $i = 0;
    
    $JQBut = '';
    
    foreach ($db -> getTimeslots() as $id => $val)    ## ALLE bisher als "OK"/"Nicht OK" geklickten Timeslots
    { $xTS[$id] = $val ;
    }
    
    if( $vorlesungsliste )
    { ### Datenstruktur für Timeslots erstellen
      foreach( $vorlesungsliste as $datum => $listOfKL)
      { $SLkIDList = '';
        foreach ( $listOfKL as $slot => $vor )
        { $SLdate  =  $datum. '--' . $slot;
          $SLtxt   = "SL".$SLdate;
          $SLID    = str_replace( '-','',$SLtxt);
          $SLOKID  = "TSisOK". $SLID ;
          
          $SLkIDList = '';
          foreach ($vor as $v)
          { $SLkIDList .=  $v['ID'].",";
          }
          $SLkIDList = substr($SLkIDList, 0, -1); // letztes Komma wieder entfernen  ;
          
          $SLO[$SLID][ 'SLID'       ] = $SLID;
          $SLO[$SLID][ 'SLName'     ] = $SLdate;
          $SLO[$SLID][ 'SLTxt'      ] = $SLtxt ;
          $SLO[$SLID][ 'SLokID'     ] = $SLOKID;
          $SLO[$SLID][ 'SLkIDlist'  ] = $SLkIDList;
          #### ----------------------------------------------
          
          if  ( isset( $xTS[ $SLID ] ) AND  $xTS[ $SLID] == 1 ) {$state = 1;}
          else                     {$state = 0;}
          
          $slotlist .= "
  SLO[ \"".$SLID."\" ] = {
  ID: \"".$SLID."\",
  date: \"".$SLdate."\",
  state: $state,
  KL:  [".$SLkIDList."]
  }";
          
          $tmpV = $vor;
          $WT = $this->WT[array_pop($tmpV)['WD']];
          $i++;
          
          $JSb2 .= "$( \"#". $SLOKID  ."\" ).click(function() { setIsOkButton( '". $SLID  ."' ) ;  saveIsOk( '". $SLID  ."' );  });"."\r\n";
          ##########################
          $tabH  = "<div   id=\"".$SLID."\" class='slot'><div class='headline widget'>
                    <input class=\"LVA\"  id=\"".$SLOKID."\"        style='width:175px; height: 40px;'  type=\"button\" value=\"\"    />\r\n";
          $tabH .= "<input class=\"LVA\"  id=\"button".$SLOKID."\"  style='width:250px; height: 40px;'  type=\"button\" value=\"" . $WT . " " . $SLdate . "\"     onclick=\"setCurSlot( '".$SLID."' ); \"  /> </div>\r\n";
          
          $tabH .= "<table  class=\"belegTabelle\" style=\"width: 100%\">\r\n";
          $tabH .= "<tr class=\"t1\">";
          if ($changeable) { $tabH .= "<td  class=\"b1_0  header\">Zeit                                   </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_1  header\">Lehrveranstaltung / Dozierende / SemSG </td>\r\n "; }
          #if ($changeable) { $tabH .= "<td  class=\"b1_2  header\">Studis Anz                             </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_3  header\">Bemerkung                              </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_4  header\">                                       </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_5  header\">Raum                                   </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_6  header\">IST                                    </td>\r\n "; }
          if ($changeable) { $tabH .= "<td  class=\"b1_7  header\">SOLL                                   </td>\r\n "; }
          $tabH .= "</tr>\r\n \r\n";
          $tab .= $tabH;
          
          foreach ( $vor as $kl )
          { if ( $kl[ 'WD'   ] == null ) { $t[ $kl[ 'ID' ]][ 'WD'   ] = 7;     }  # uninitialisierte Wochentag wird auf 7 gesetzt
            if ( $kl[ 'date' ] == null ) { $t[ $kl[ 'ID' ]][ 'date' ] = 0;     }  # uninitialisierte Wochentag wird auf 7 gesetzt
  
            $kl[ 'dozname' ]  = $I[ 'alldozenten' ][ trim($kl[ 'dozabk' ]) ] [ 'lastname' ];
            $kl[ 'LVA'     ]  = $I[ 'allLVA' ][ trim($kl[ 'LVAabk' ]) ] [ 'name' ];
            
            $KL .= "\"".$kl[ 'ID'   ]."\",";
            
            $bg1 = "style='background-color: " .$this -> CO[ $slot ]."'";
            $i++;
            $tab .= "<tr id=\"row_" .$kl[ 'ID'   ]."\">\r\n";
            $tab .= "<td class = 'b1_0'  $bg1><div class=\"ui-widget\"><input $ed class=\"LVA\" id=\"time" .$kl[ 'ID' ]. "\" type=\"text\"   value=\"" .$kl[ 'time'    ] . "\"  step=\"1800\"  min=\"6:00\" max=\"0:00\"     /></div></td>\r\n";
            $tab .= "<td class = 'b1_1' >     <div class=\"ui-widget\"                               ><input  $ed  class=\"LVA\"  id=\"LVA"            .$kl[ 'dozname' ] . " / "      .$kl[ 'ID' ]. "\"   type=\"text\"   value=\"ID:".$kl[ 'ID' ]." /  "  .$kl[ 'dozname'   ] . " / " .$kl[ 'LVA'        ] .  " / " .$kl[ 'semSG'  ] . "\"  list=\"LVA\"                                                                         /></div></td>\r\n";
            #$tab .= "<td class = 'b1_2' >     <div class=\"ui-widget\"                               ><input       class=\"LVB\"  id=\"anzstudi"       .$kl[ 'ID' ]. "_1\" type=\"text\" value=\"" .$kl[ 'anzstudi1'  ] . " / " .$kl[ 'anzstudi2'  ] .  "\"  min=\"0\" max=\"200\"                                                               /></div></td>\r\n";
            $tab .= "<td class = 'b1_3' >     <div class=\"ui-widget\"                               ><textarea    class=\"LVA ta2\"  id=\"bemerkung"  .$kl[ 'ID' ]. "\"   name=\"bemerkung"         .$kl[ 'ID'         ] . "\" wrap=\"on\"   rows=\"3\"   cols=\"15\"  >" .$kl[ 'bemerkung'      ] . "</textarea></div></td>\r\n";
            $tab .= "<td class = 'b1_4' >     <div class=\"ui-widget\" style='display: none;'        ><textarea    class=\"LVA ta1\"  id=\"KL"         .$kl[ 'ID' ]. "\"   name=\"KL".$kl[ 'ID' ]."\"  rows=\"3\" cols=\"6\"  wrap=\"on\" >" .$kl[ 'raum'  ] . "</textarea></div></td>\r\n";
            $tab .= "<td class = 'b1_5' >     <div class=\"ui-widget\"                               ><textarea    class=\"LVA ta2\"  id=\"sav"        .$kl[ 'ID' ]. "\"   name=\"sav".$kl[ 'ID' ]."\"  rows=\"3\" cols=\"6\"  wrap=\"on\" >" .$kl[ 'save'  ] . "</textarea></div></td>\r\n";
            $tab .= "<td class = 'b1_6' >     <div class=\"ui-widget\"                               ><input       class=\"LVB\"  id=\"SX"             .$kl[ 'ID' ]. "\"   type=\"text\" value=\"" .$kl[ 'studr'  ] . "\"  min=\"0\" max=\"200\"                                                               /></div></td>\r\n";
            $tab .= "<td class = 'b1_7'  id=\"b" .$kl[ 'ID' ]. "\"   ><div class=\"ui-widget\"       ><input       class=\"LVB\"  id=\"button"         .$kl[ 'ID' ]. "\"   style='width:100%; height: 60px;'    type=\"button\" value=\"" .$kl[ 'anzstudi1'  ] . "/" .$kl[ 'anzstudi2'  ] .  "\"     onclick=\"setCurKL( ".$kl[ 'ID' ].", '".$SLID."' ); \"  /></div></td>\r\n";
            $tab .= "</tr>\r\n";
            
            $ajax1 .= '$("#bemerkung' .$kl[ "ID" ].'" ).on("change",function() { $("#bemerkung' .$kl[ "ID" ].'" ).toggle( "fade" ); $("#bemerkung' .$kl[ "ID" ].'" ).toggle( "fade" ); $.ajax({ type: "post", data: { val : this.value }, url: "ajax.php?action=changeanote&id=' .$kl[ 'ID' ]. '&val=" + this.value } ); } );'."\r\n";
          }
          $tab .="</table></div>\r\n";
        }
      }
    }
    
    $ajax1 .=  '$("#TSisOK'   . $SLID. '" ).on("click",function() {  $("#TSisOK' .$SLID. '" ).toggle( "fade" );  $("#TSisOK' .$SLID.  '" ).toggle( "fade" );  $.ajax({ type: "post",   data: { val : this.value },  url: "ajax.php?action=changeanote&id='   .$SLID.'&val="  + this.value } ); } );'."\r\n";
    
    $tab .="</form>\r\n";
   
    $tab .= "
<div style=\"position:fixed ; top:0px; right:5px;\">
<table width=\"295\" cellpadding=\"2\" cellspacing=\"0\" class=\"roompicker\">
  <tr>
    <td class='pickTD'> EI </td>
    <td class='pickTD'> Raum </td>
    <td class='pickTD'> Pers </td>
    <td class='pickTD'> CL </td>
    <td class='pickTD'> LW </td>
    <td class='pickTD'> FL </td>
    <td class='pickTD'> EI </td>
  </tr>
  <tr><!-- 1029 = S407 -->
    <td class='pickTD' rowspan=\"13\"> UL </td>
    <td class='pickTD'> ". $r[ $rx['S407']]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['S407'] ]['shortname'] ."\"  >". $r[ $rx['S407'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"C08\"> ". $r[ $rx['S407'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"grun1\" rowspan=\"5\"> " . ( $r[ $rx['S407'] ]['maxpers'] + $r[ $rx['S40506']]['maxpers'] + $r[ $rx['S308']]['maxpers'] + $r[ $rx['S209']]['maxpers'] + $r[ $rx['S230']]['maxpers'] ). "</td>
    <td class='pickTD' id=\"ULS\"   rowspan=\"6\"> " . ( $r[ $rx['S407'] ]['maxpers'] + $r[ $rx['S40506']]['maxpers'] + $r[ $rx['S308']]['maxpers'] + $r[ $rx['S209']]['maxpers'] + $r[ $rx['S230']]['maxpers'] +  $r[ $rx['S404']]['maxpers'] ). "  </td>
    <td class='pickTD' id=\"UL\"    rowspan=\"13\">" . ( $r[ $rx['N41011']]['maxpers'] + $r[ $rx['N412']]['maxpers'] + $r[ $rx['N224']]['maxpers'] + $r[ $rx['N230']]['maxpers'] + $r[ $rx['N205']]['maxpers'] + $r[ $rx['043']]['maxpers'] + $r[ $rx['FoyG']]['maxpers'] + $r[ $rx['S407'] ]['maxpers'] + $r[ $rx['S40506']]['maxpers'] + $r[ $rx['S308']]['maxpers'] + $r[ $rx['S209']]['maxpers'] + $r[ $rx['S230']]['maxpers'] +  $r[ $rx['S404']]['maxpers'] )."</td>
  </tr>
  
  <tr><!-- 1028 = S40506 -->
    <td class='pickTD'> ". $r[ $rx['S40506']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S40506']]['shortname'] ."\"  >". $r[ $rx['S40506']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C07\" > ". $r[ $rx['S40506']]['maxpers'] ." </td>
  </tr>
  
  <tr> <!-- 1027 = S308 -->
    <td class='pickTD'> ". $r[ $rx['S308']]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['S308']]['shortname'] ."\"  >". $r[ $rx['S308']]['maxpers'] ." </td>
    <td class='pickTD' id=\"C06\"> ". $r[ $rx['S308']]['maxpers'] ." </td>
  </tr>
  
   <tr><!-- 1035 = S2.09 -->
    <td class='pickTD'> ". $r[ $rx['S209']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S209']]['shortname'] ."\"  >". $r[ $rx['S209']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C21\" > ". $r[ $rx['S209']]['maxpers'] ." </td>
  </tr>

  <tr> <!-- 1036 = S230 -->
    <td class='pickTD'> ". $r[ $rx['S230']]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['S230']]['shortname'] ."\"  >". $r[ $rx['S230']]['maxpers'] ." </td>
    <td class='pickTD' id=\"C20\"> ". $r[ $rx['S230']]['maxpers'] ." </td>
  </tr>

   <tr><!-- 1026 = S4.04 -->
    <td class='pickTD'> ". $r[ $rx['S404']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S404']]['shortname'] ."\"  >". $r[ $rx['S404']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C05\" > ". $r[ $rx['S404']]['maxpers'] ." </td>
    <td class='pickTD' id=\"lila\"   > ". $r[ $rx['S404']]['maxpers'] ." </td>
  </tr>
 
   <tr><!-- 1025 = N4.10-11 -->
   <td class='pickTD'> ". $r[ $rx['N41011']]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N41011']]['shortname'] ."\"> ". $r[ $rx['N41011']]['maxpers'] ." </td>
    <td class='pickTD' id=\"C12\"      rowspan=\"2\"> " . ( $r[ $rx['N41011']]['maxpers'] + $r[ $rx['N412']]['maxpers'] ) . "  </td>
    <td class='pickTD' id=\"rot1\"     rowspan=\"5\"> " . ( $r[ $rx['N41011']]['maxpers'] + $r[ $rx['N412']]['maxpers'] + $r[ $rx['N224']]['maxpers'] + $r[ $rx['N230']]['maxpers'] + $r[ $rx['N205']]['maxpers'] ). " </td>
    <td class='pickTD' id=\"ULN\"      rowspan=\"7\"> " . ( $r[ $rx['N41011']]['maxpers'] + $r[ $rx['N412']]['maxpers'] + $r[ $rx['N224']]['maxpers'] + $r[ $rx['N230']]['maxpers'] + $r[ $rx['N205']]['maxpers'] + $r[ $rx['043']]['maxpers'] + $r[ $rx['FoyG']]['maxpers'] ). " </td>
  </tr>
 
  <tr> <!-- 1024 = N4.12 -->
    <td class='pickTD'> ". $r[ $rx['N412']]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['N412']]['shortname'] ."\"  >". $r[ $rx['N412']]['maxpers'] ." </td>
  </tr>

  <tr><!-- 1034 = N224 -->
    <td class='pickTD bg1'> ". $r[ $rx['N224']]['name'] ." </td>
    <td class='pickTD grey0' id=\"". $r[ $rx['N224']]['shortname'] ."\"  >". $r[ $rx['N224']]['maxpers'] ." </td>
    <td class='pickTD grey0' id=\"C22\" > ". $r[ $rx['N224']]['maxpers'] ." </td>
  </tr>


  <tr> <!-- 1036 = S230 -->
    <td class='pickTD bg1'> ". $r[ $rx['N230']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['N230']]['shortname'] ."\"  >". $r[ $rx['N230']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C23\"> ". $r[ $rx['N230']]['maxpers'] ." </td>
  </tr>


 <tr><!-- 1032 = N205 -->
    <td class='pickTD bg1'> ". $r[ $rx['N205']]['name'] ." </td>
    <td class='pickTD grey0' id=\"". $r[ $rx['N205']]['shortname'] ."\"  >". $r[ $rx['N205']]['maxpers'] ." </td>
    <td class='pickTD grey0' id=\"C24\" > ". $r[ $rx['N205']]['maxpers'] ." </td>
 </tr>
 
 
  <tr> <!-- 1030 =  0.43 -->
    <td class='pickTD bg1'> ". $r[ $rx['043']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['043']]['shortname'] ."\"  >". $r[ $rx['043']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C25\"> ". $r[ $rx['043']]['maxpers'] ." </td>
    <td class='pickTD' id=\"ohne\" > ". $r[ $rx['043']]['maxpers'] ."  </td>
  </tr>
 

  <tr><!-- 1021 = Foyer ges -->
    <td class='pickTD'> ". $r[ $rx['FoyG']]['name'] ." </td>
    <td class='pickTD grey0' id=\"". $r[ $rx['FoyG']]['shortname'] ."\"  >". $r[ $rx['FoyG']]['maxpers'] ." </td>
    <td class='pickTD grey0' id=\"C16\" > ". $r[ $rx['FoyG']]['maxpers'] ." </td>
    <td class='pickTD' id=\"blau\"    > ". $r[ $rx['FoyG']]['maxpers'] ." </td>
  </tr>

  <tr>
    <td class='pickTD' rowspan=\"13\"> HO </td>
    <td class='pickTD'>  ". $r[ $rx['S402'] ]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S402'] ]['shortname'] ."\" >". $r[ $rx['S402'] ]['maxpers'] ."</td>
    <td class='pickTD grey1' id=\"C02\"  rowspan=\"2\"> ". ( $r[ $rx['S402'] ]['maxpers'] +  $r[ $rx['S401'] ]['maxpers'])." </td>
    <td class='pickTD' id=\"grun2\"  rowspan=\"4\">  ". ( $r[ $rx['S402'] ]['maxpers'] +  $r[ $rx['S401'] ]['maxpers'] +  $r[ $rx['S302'] ]['maxpers'] +  $r[ $rx['S301'] ]['maxpers'] )." </td>
    <td class='pickTD' id=\"HOS\"    rowspan=\"9\">  ". ( $r[ $rx['S402'] ]['maxpers'] +  $r[ $rx['S401'] ]['maxpers'] +  $r[ $rx['S302'] ]['maxpers'] +  $r[ $rx['S301'] ]['maxpers'] + $r[ $rx['S403'] ]['maxpers'] + $r[ $rx['S303'] ]['maxpers'] + $r[ $rx['109'] ]['maxpers'] + $r[ $rx['108'] ]['maxpers'] + $r[ $rx['107ab'] ]['maxpers'])."</td>
    <td class='pickTD' id=\"HO\"     rowspan=\"13\"> ". ( $r[ $rx['S402'] ]['maxpers'] +  $r[ $rx['S401'] ]['maxpers'] +  $r[ $rx['S302'] ]['maxpers'] +  $r[ $rx['S301'] ]['maxpers'] + $r[ $rx['S403'] ]['maxpers'] + $r[ $rx['S303'] ]['maxpers'] + $r[ $rx['109'] ]['maxpers'] + $r[ $rx['108'] ]['maxpers'] + $r[ $rx['107ab'] ]['maxpers'] + $r[ $rx['125'] ]['maxpers'] + $r[ $rx['N409'] ]['maxpers'] + $r[ $rx['FoyO'] ]['maxpers'] + $r[ $rx['045'] ]['maxpers'] ) ."</td>
  </tr>
  <tr>
    <td class='pickTD'>  ". $r[ $rx['S401'] ]['name'] ."</td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S401'] ]['shortname'] ."\" >". $r[ $rx['S401'] ]['maxpers'] ."</td>
  </tr>

  <tr>
    <td class='pickTD'>   ". $r[ $rx['S302'] ]['name'] ."</td>
    <td class='pickTD grey1' id=\"". $r[ $rx['S302'] ]['shortname'] ."\" >". $r[ $rx['S302'] ]['maxpers'] ."</td>
    <td class='pickTD' id=\"C01\"   rowspan=\"2\"> ". ( $r[ $rx['S302'] ]['maxpers'] +  $r[ $rx['S301'] ]['maxpers'])." </td>
  </tr>

  <tr>
  <td class='pickTD'>   ". $r[ $rx['S301'] ]['name'] ."</td>
  <td class='pickTD' id=\"". $r[ $rx['S301'] ]['shortname'] ."\" >". $r[ $rx['S301'] ]['maxpers'] ."</td>
  </tr>

  <tr>
   <td class='pickTD'>   ". $r[ $rx['S403'] ]['name'] ."</td>
   <td class='pickTD grey1' id=\"". $r[ $rx['S403'] ]['shortname'] ."\" >". $r[ $rx['S403'] ]['maxpers'] ."</td>
   <td class='pickTD grey1' id=\"C04\" rowspan=\"2\"> ". ( $r[ $rx['S403'] ]['maxpers'] + $r[ $rx['S303'] ]['maxpers'])." </td>
   <td class='pickTD' id=\"orange\"  rowspan=\"5\"> ". ( $r[ $rx['S403'] ]['maxpers'] + $r[ $rx['S303'] ]['maxpers'] + $r[ $rx['109'] ]['maxpers'] + $r[ $rx['108'] ]['maxpers'] + $r[ $rx['107ab'] ]['maxpers'])."  </td>
  </tr>


  <tr>
  <td class='pickTD'>     ". $r[ $rx['S303'] ]['name'] ."</td>
  <td class='pickTD grey1' id=\"". $r[ $rx['S303'] ]['shortname'] ."\" >". $r[ $rx['S303'] ]['maxpers'] ."</td>
  </tr>

  <tr>
    <td class='pickTD'>   ". $r[ $rx['109'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['109'] ]['shortname'] ."\" >". $r[ $rx['109'] ]['maxpers'] ."</td>
    <td class='pickTD' id=\"C03\"   rowspan=\"3\"> ". ( $r[ $rx['109'] ]['maxpers'] +  $r[ $rx['108'] ]['maxpers'] +  $r[ $rx['107ab'] ]['maxpers'])." </td>
  </tr>

  <tr>
    <td class='pickTD'>     ". $r[ $rx['108'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['108'] ]['shortname'] ."\" >". $r[ $rx['108'] ]['maxpers'] ."</td>
  </tr>
  <tr>
    <td class='pickTD'>     ". $r[ $rx['107ab'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['107ab'] ]['shortname'] ."\" >". $r[ $rx['107ab'] ]['maxpers'] ."</td>
  </tr>
  <tr>
    <td class='pickTD bg3' >". $r[ $rx['125'] ]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['125'] ]['shortname'] ."\" > ". $r[ $rx['125'] ]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C13\" > ". $r[ $rx['125'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"rot2\"      > ". $r[ $rx['125'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"HON\" rowspan=\"4\"> ". ( $r[ $rx['125'] ]['maxpers'] +  $r[ $rx['N409'] ]['maxpers'] +  $r[ $rx['FoyO'] ]['maxpers']+  $r[ $rx['045'] ]['maxpers'])." </td>
  </tr>
  <tr>
    <td class='pickTD' >". $r[ $rx['N409'] ]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['N409'] ]['shortname'] ."\" > ". $r[ $rx['N409'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"C11\" > ". $r[ $rx['N409'] ]['maxpers'] ." </td>
    <td class='pickTD' id=\"schwarz\" rowspan=\"3\"> ". ( $r[ $rx['N409'] ]['maxpers'] +  $r[ $rx['FoyO'] ]['maxpers'] +  $r[ $rx['045'] ]['maxpers'] )." </td>
  </tr>
  <tr>
  <td class='pickTD'>     ". $r[ $rx['FoyO'] ]['name'] ."</td>
  <td class='pickTD grey1' id=\"". $r[ $rx['FoyO'] ]['shortname'] ."\" >". $r[ $rx['FoyO'] ]['maxpers'] ."</td>
  <td class='pickTD grey1'  id=\"C14\">". $r[ $rx['FoyO'] ]['maxpers'] ."</td>
  </tr>
  
   <tr>
  <td class='pickTD'>     ". $r[ $rx['045'] ]['name'] ."</td>
  <td class='pickTD grey1' id=\"". $r[ $rx['045'] ]['shortname'] ."\" >". $r[ $rx['045'] ]['maxpers'] ."</td>
  <td class='pickTD grey1'  id=\"C19\">". $r[ $rx['045'] ]['maxpers'] ."</td>
  </tr>

 
  <tr>
    <td class='pickTD' rowspan=\"9\"> HW </td>
    <td class='pickTD'>  ". $r[ $rx['N408'] ]['name'] ." </td>
    <td class='pickTD' id=\"". $r[ $rx['N408'] ]['shortname'] ."\" >". $r[ $rx['N408'] ]['maxpers'] ."</td>
    <td class='pickTD' id=\"C10\"  rowspan=\"2\"> ". ( $r[ $rx['N408'] ]['maxpers'] + $r[ $rx['N407'] ]['maxpers'] )." </td>
    <td class='pickTD' id=\"gelb\" rowspan=\"2\"> ". ( $r[ $rx['N408'] ]['maxpers'] + $r[ $rx['N407'] ]['maxpers'] )." </td>
    <td class='pickTD' id=\"HWN\"  rowspan=\"9\"> ". ( $r[ $rx['N408'] ]['maxpers'] + $r[ $rx['N407'] ]['maxpers'] +  $r[ $rx['N517'] ]['maxpers'] +  $r[ $rx['N406'] ]['maxpers'] + $r[ $rx['N310'] ]['maxpers'] + $r[ $rx['N219'] ]['maxpers'] + $r[ $rx['N218'] ]['maxpers'] + $r[ $rx['N215'] ]['maxpers'] + $r[ $rx['FoyW'] ]['maxpers'])."</td>
    <td class='pickTD' id=\"HW\"   rowspan=\"9\"> ". ( $r[ $rx['N408'] ]['maxpers'] + $r[ $rx['N407'] ]['maxpers'] +  $r[ $rx['N517'] ]['maxpers'] +  $r[ $rx['N406'] ]['maxpers'] + $r[ $rx['N310'] ]['maxpers'] + $r[ $rx['N219'] ]['maxpers'] + $r[ $rx['N218'] ]['maxpers'] + $r[ $rx['N215'] ]['maxpers'] + $r[ $rx['FoyW'] ]['maxpers']) ."</tr>
  <tr>
    <td class='pickTD'>     ". $r[ $rx['N407'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N407'] ]['shortname'] ."\" >". $r[ $rx['N407'] ]['maxpers'] ."</td>
  </tr>
  
  <tr>
   <td class='pickTD'>   ". $r[ $rx['N517'] ]['name'] ."</td>
   <td class='pickTD grey1' id=\"". $r[ $rx['N517'] ]['shortname'] ."\" >". $r[ $rx['N517'] ]['maxpers'] ."</td>
   <td class='pickTD grey1' id=\"C09\" rowspan=\"2\"> ". ( $r[ $rx['N517'] ]['maxpers'] + $r[ $rx['N406'] ]['maxpers'])." </td>
   <td class='pickTD' id=\"pink\"  rowspan=\"6\"> ". ( $r[ $rx['N517'] ]['maxpers'] + $r[ $rx['N406'] ]['maxpers'] + $r[ $rx['N310'] ]['maxpers'] + $r[ $rx['N219'] ]['maxpers'] + $r[ $rx['N218'] ]['maxpers']+ $r[ $rx['N215'] ]['maxpers'])."  </td>
  </tr>
  <tr>
    <td class='pickTD'>     ". $r[ $rx['N406'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N406'] ]['shortname'] ."\" >". $r[ $rx['N406'] ]['maxpers'] ."</td>
  </tr>
  <tr>
   
   <td class='pickTD bg3'>   ". $r[ $rx['N310'] ]['name'] ."</td>
   <td class='pickTD' id=\"". $r[ $rx['N310'] ]['shortname'] ."\" >". $r[ $rx['N310'] ]['maxpers'] ."</td>
   <td class='pickTD' id=\"C17\" rowspan=\"4\"> ". ( $r[ $rx['N310'] ]['maxpers'] + $r[ $rx['N219'] ]['maxpers'] + $r[ $rx['N218'] ]['maxpers'] + $r[ $rx['N215'] ]['maxpers'])." </td>
   
  </tr>
  <tr>
    <td class='pickTD bg3'>     ". $r[ $rx['N219'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N219'] ]['shortname'] ."\" >". $r[ $rx['N219'] ]['maxpers'] ."</td>
  </tr>
  <tr>
    <td class='pickTD bg3'>     ". $r[ $rx['N218'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N218'] ]['shortname'] ."\" >". $r[ $rx['N218'] ]['maxpers'] ."</td>
  </tr>
  <tr>
    <td class='pickTD bg3'>     ". $r[ $rx['N215'] ]['name'] ."</td>
    <td class='pickTD' id=\"". $r[ $rx['N215'] ]['shortname'] ."\" >". $r[ $rx['N215'] ]['maxpers'] ."</td>
  </tr>
  <tr>
    <td class='pickTD bg1'> ". $r[ $rx['FoyW']]['name'] ." </td>
    <td class='pickTD grey1' id=\"". $r[ $rx['FoyW']]['shortname'] ."\"  >". $r[ $rx['FoyW']]['maxpers'] ." </td>
    <td class='pickTD grey1' id=\"C15\"> ". $r[ $rx['FoyW']]['maxpers'] ." </td>
    <td class='pickTD' id=\"grau\" > ". $r[ $rx['FoyW']]['maxpers'] ."  </td>
    
  </tr>
</table>
</div>
";

    /**



$tab .= "
<div style=\"position:fixed ; top:0px; right:5px;\">
<table width=\"295\" cellpadding=\"2\" cellspacing=\"0\" class=\"roompicker\">
<tr>
<td class='pickTD'> EI </td>
<td class='pickTD'> Raum </td>
<td class='pickTD'> Pers </td>
<td class='pickTD'> CL </td>
<td class='pickTD'> LW </td>
<td class='pickTD'> FL </td>
<td class='pickTD'> EI </td>
</tr>
<tr>
<td class='pickTD' rowspan=\"13\"> UL </td>
<td class='pickTD'> S4.07 </td>
<td class='pickTD' id=\"S407\"  > 100 </td>
<td class='pickTD' id=\"C08\"> 100 </td>
<td class='pickTD' id=\"grun1\" rowspan=\"5\"> 454 </td>
<td class='pickTD' id=\"ULS\" rowspan=\"6\"> 558  </td>
<td class='pickTD' id=\"UL\"  rowspan=\"13\"> 1347 </td>
</tr>
<tr>
<td class='pickTD' height=\"20\"> S4.05-06 </td>
<td class='pickTD grey1' id=\"S40506\"> 100 </td>
<td class='pickTD grey1' id=\"C07\" > 100 </td>
</tr>
<tr>
<td class='pickTD'> S3.08 </td>
<td class='pickTD' id=\"S308\"  > 100 </td>
<td class='pickTD' id=\"C06\"> 100 </td>
</tr>
<tr>
<td class='pickTD'> S2.09 </td>
<td class='pickTD' id=\"S209\"  > 54 </td>
<td class='pickTD' id=\"C21\"> 54 </td>
</tr>
<tr>
<td class='pickTD'> S2.30 </td>
<td class='pickTD' id=\"S230\"> 100 </td>
<td class='pickTD' id=\"C20\"> 100 </td>
</tr>
<tr>
<td class='pickTD' height=\"25\"> S4.04 </td>
<td class='pickTD grey1' id=\"S404\" > 104 </td>
<td class='pickTD grey1' id=\"C05\"  > 104 </td>
<td class='pickTD' id=\"lila\"   > 104 </td>
</tr>
<tr>
<td class='pickTD'> N4.10-11 </td>
<td class='pickTD' id=\"N41011\"> 100 </td>
<td class='pickTD' id=\"C12\"      rowspan=\"2\"> 200 </td>
<td class='pickTD' id=\"rot1\"     rowspan=\"5\"> 454</td>
<td class='pickTD' id=\"ULN\"       rowspan=\"7\"> 789</td>
</tr>

<tr>
<td class='pickTD'> N4.12 </td>
<td class='pickTD' id=\"N412\"  > 100 </td>
</tr>
<!--
<tr>
<td class='pickTD' class='bg3'>(L) N2.27 </td>
<td class='pickTD' id=\"N227\"   class=\"grey1\"> 7 </td>
<td class='pickTD' id=\"C18\" class=\"grey1\" rowspan=\"2\"> 16 </td>
</tr>

<tr>
<td class='pickTD' class='bg3'>(L) N2.25 </td>
<td class='pickTD' id=\"N225\"   class=\"grey1\"> 9 </td>
</tr>
-->
<tr>
<td class='pickTD' class='bg1'>N2.24</td>
<td class='pickTD grey0' id=\"N224\"> 142 </td>
<td class='pickTD grey0' id=\"C22\"> 142 </td>
</tr>

<tr>
<td class='pickTD' class='bg1'>N2.30 </td>
<td class='pickTD grey1' id=\"N230\"> 56 </td>
<td class='pickTD grey1' id=\"C23\" > 56 </td>
</tr>

<tr>
<td class='pickTD' class='bg1'>N2.05 </td>
<td class='pickTD grey0' id=\"N205\"> 56 </td>
<td class='pickTD grey0' id=\"C24\" > 56 </td>
</tr>

<tr>
<td class='pickTD'> 0.43 </td>
<td class='pickTD grey1' id=\"043\" > 261 </td>
<td class='pickTD grey1' id=\"C25\" > 261  </td>
<td class='pickTD' id=\"ohne\" > 261 </td>
</tr>


<tr>
<td class='pickTD'> Foyer ges.</td>
<td class='pickTD' id=\"FoyG\"  > 74 </td>
<td class='pickTD' id=\"C16\"> 74 </td>
<td class='pickTD' id=\"blau\"    > 74 </td>
</tr>

<tr>
<td class='pickTD' rowspan=\"13\"> HO </td>
<td class='pickTD'> S4.02 </td>
<td class='pickTD grey1' id=\"S402\" >50 </td>
<td class='pickTD grey1' id=\"C02\"  rowspan=\"2\"> 150 </td>
<td class='pickTD' id=\"grun2\"  rowspan=\"4\"> 300 </td>
<td class='pickTD' id=\"HOS\"    rowspan=\"9\"> 600 </td>
<td class='pickTD' id=\"HO\"     rowspan=\"13\"> 1027</td>
</tr>
<tr>
<td class='pickTD'> S4.01 </td>
<td class='pickTD grey1' id=\"S401\"> 100 </td>
</tr>

<tr>
<td class='pickTD'> S3.02 </td>
<td class='pickTD' id=\"S302\"  > 50 </td>
<td class='pickTD' id=\"C01\"   rowspan=\"2\"> 150 </td>
</tr>

<tr>
<td class='pickTD'> S3.01 </td>
<td class='pickTD' id=\"S301\"  > 100 </td>
</tr>

<tr>
<td class='pickTD'> S4.03 </td>
<td class='pickTD grey1' id=\"S403\" > 50 </td>
<td class='pickTD grey1' id=\"C04\"  rowspan=\"2\"> 100 </td>
<td class='pickTD' id=\"orange\"  rowspan=\"5\"> 300 </td>
</tr>

<tr>
<td class='pickTD'> S3.03 </td>
<td class='pickTD grey1' id=\"S303\" > 50 </td>
</tr>

<tr>
<td class='pickTD'> 1.09 </td>
<td class='pickTD' id=\"109\"   > 50 </td>
<td class='pickTD' id=\"C03\"               rowspan=\"3\"> 200 </td>
</tr>

<tr>
<td class='pickTD'> 1.08 </td>
<td class='pickTD' id=\"108\"   > 50 </td>
</tr>
<tr>
<td class='pickTD'> 1.07 a-b </td>
<td class='pickTD' id=\"107ab\" > 100 </td>
</tr>
<tr>
<td class='pickTD bg3' >(MP) 1.25 </td>
<td class='pickTD grey1' id=\"125\" > 50 </td>
<td class='pickTD grey1' id=\"C13\" > 50 </td>
<td class='pickTD' id=\"rot2\"      > 50 </td>
<td class='pickTD' id=\"HON\" rowspan=\"4\"> 427 </td>
</tr>
<tr>
<td class='pickTD'> N4.09 </td>
<td class='pickTD' id=\"N409\" > 50 </td>
<td class='pickTD' id=\"C11\"> 50 </td>
<td class='pickTD' id=\"schwarz\" rowspan=\"3\"> 377 </td>
</tr>
<tr>
<td class='pickTD'> Foyer Ost </td>
<td class='pickTD grey1' id=\"FoyO\"  > 28 </td>
<td class='pickTD grey1' id=\"C14\"  > 28 </td>
</tr>

<tr>
<td class='pickTD'> 0.45 </td>
<td class='pickTD grey1' id=\"045\" > 299 </td>
<td class='pickTD grey1' id=\"C19\" > 299 </td>
</tr>

<tr>
<td class='pickTD' rowspan=\"9\"> HW </td>
<td class='pickTD'> N4.08 </td>
<td class='pickTD' id=\"N408\"  > 50 </td>
<td class='pickTD' id=\"C10\"               rowspan=\"2\"> 100 </td>
<td class='pickTD' id=\"gelb\"    rowspan=\"2\"> 100 </td>
<td class='pickTD' id=\"HWN\" rowspan=\"9\"> 314 </td>
<td class='pickTD' id=\"HW\" rowspan=\"9\"> 314 </td>
</tr>
<tr>
<td class='pickTD'> N4.07 </td>
<td class='pickTD' id=\"N407\"  > 50 </td>
</tr>
<tr>
<td class='pickTD'> N5.17 </td>
<td class='pickTD grey1' id=\"N517\" > 100 </td>
<td class='pickTD grey1' id=\"C09\"  rowspan=\"2\"> 150 </td>
<td class='pickTD' id=\"pink\"       rowspan=\"6\"> 214 </td>
</tr>
<tr>
<td class='pickTD'> N4.06 </td>
<td class='pickTD grey1' id=\"N406\"   > 50 </td>
</tr>
<tr>
<td class='pickTD bg3' >(RZ) N3.10 </td>
<td class='pickTD' id=\"N310\"  > 16 </td>
<td class='pickTD' id=\"C17\"               rowspan=\"4\"> 64 </td>
</tr>
<tr>
<td class='pickTD bg3' >(RZ) N2.19 </td>
<td class='pickTD' id=\"N219\"  > 16 </td>
</tr>
<tr>
<td class='pickTD bg3'  >(RZ) N2.18 </td>
<td class='pickTD' id=\"N218\"  > 16 </td>
</tr>
<tr>
<td class='pickTD bg3'  >(RZ) N2.15 </td>
<td class='pickTD' id=\"N215\"  > 16 </td>
</tr>
<tr>
<td class='pickTD' >Foyer W</td>
<td class='pickTD grey1' id=\"FoyW\" > 73 </td>
<td class='pickTD grey1' id=\"C15\" > 73 </td>
<td class='pickTD' id=\"grau\"    > 73</td>
</tr>
</table>
</div>
";


**/



$js = 'let  statusBox  = document.getElementById("statusBox" );
let  statusText = document.getElementById("statusText");
$("#bemerkung89").on("change",function() { updateAnote( 89, this.value )   } );'. "\r\n";


$REH = '';
$raum ="let R = new Array();\r\n";
foreach( $_SESSION[ 'liste' ][ 'raum' ] as $r)
{ $raum .=
  "R[ \"" .$r[ 'shortname' ]. "\"  ] = new Object();\r\n".
  "R[ \"" .$r[ 'shortname' ] ."\"  ][ 'ID'    ] = \""     .$r[ 'roomID'   ]. "\";\r\n"   .
  "R[ \"" .$r[ 'shortname' ] ."\"  ][ 'name'  ] = \""     .$r[ 'name'     ]. "\";\r\n"   .
  "R[ \"" .$r[ 'shortname' ] ."\"  ][ 'pers'  ] = "       .$r[ 'maxpers'  ]. ";\r\n"     .
  "R[ \"" .$r[ 'shortname' ] ."\"  ][ 'jq'    ] = $( \"#" .$r[ 'shortname']. "\" );\r\n" .
  "R[ \"" .$r[ 'shortname' ] ."\"  ][ 'state' ] = 0;\r\n\r\n";
  $REH .= "$( \"#". $r['shortname'] . "\" ).on( \"click\", function( event ) { this.blur();  updIt0(\"".$r['shortname']."\"  ,null, true, 1); });\r\n";
}

$CEH = '';
$cluster = "let C = new Array();\r\n";
foreach( $_SESSION[ 'liste' ][ 'cluster' ] as $c)
{ $c[ 'r' ] = str_replace( ',', '","', $c[ 'raum' ] );
  $cluster .=
  "C[ \"" .$c[ 'name' ]. "\"  ] = new Object();\r\n".
  "C[ \"" .$c[ 'name' ] ."\"  ][ 'ID'    ] = \""            .$c[ 'clusterID' ]. "\";\r\n"   .
  "C[ \"" .$c[ 'name' ] ."\"  ][ 'name'  ] = \""            .$c[ 'name'      ]. "\";\r\n"   .
  "C[ \"" .$c[ 'name' ] ."\"  ][ 'R'     ] = new Array( \"" .$c[ 'r'         ]. "\" );\r\n" .
  "C[ \"" .$c[ 'name' ] ."\"  ][ 'jq'    ] = $( \"#"        .$c[ 'name'      ]. "\" );\r\n" .
  "C[ \"" .$c[ 'name' ] ."\"  ][ 'state' ] = 0;\r\n\r\n";
  $CEH .= "$( \"#". $c['name'] . "\" ).on( \"click\", function( event ) {  updIt1(\"".$c['name']."\"  ,null, true, 1,1); });\r\n";
}

$LEH  = '';
$laufweg = "let L = new Array();\r\n";
foreach( $_SESSION[ 'liste' ][ 'laufweg' ] as $l )
{ $l[ 'c' ] = str_replace( ',', '","', $l[ 'cluster' ] );
  $laufweg .=
    "L[ \"" .$l['name']. "\"  ] = new Object();\r\n".
    "L[ \"" .$l['name'] ."\"  ][ 'ID'    ] = \""            .$l[ 'laufwegID' ]. "\";\r\n"   .
    "L[ \"" .$l['name'] ."\"  ][ 'name'  ] = \""            .$l[ 'name'      ]. "\";\r\n"   .
    "L[ \"" .$l['name'] ."\"  ][ 'C'     ] = new Array( \"" .$l[ 'c'         ]."\" ) ;\r\n"     .
    "L[ \"" .$l['name'] ."\"  ][ 'jq'    ] = $( \"#"        .$l[ 'name'      ]. "\" );\r\n" .
    "L[ \"" .$l['name'] ."\"  ][ 'state' ] = 0;\r\n\r\n";
    $LEH .= "$( \"#". $l['name'] . "\" ).on( \"click\", function( event ) {  updIt2(\"".$l['name']."\"  ,null, true, 1,1); });\r\n";
}
$FEH = '';
$fluegel = "let F = new Array();\r\n";
foreach( $_SESSION[ 'liste' ][ 'fluegel' ] as $f )
{ $f[ 'l' ] = str_replace( ',', '","', $f[ 'laufweg' ] );
  $fluegel .=
    "F[ \"" .$f['name']. "\"  ] = new Object();\r\n".
    "F[ \"" .$f['name'] ."\"  ][ 'ID'    ] = \""            .$f[ 'fluegelID'  ]. "\";\r\n"    .
    "F[ \"" .$f['name'] ."\"  ][ 'name'  ] = \""            .$f[ 'name'       ]. "\";\r\n"    .
    "F[ \"" .$f['name'] ."\"  ][ 'L'     ] = new Array( \"" .$f[ 'l'          ]. "\" );\r\n"  .
    "F[ \"" .$f['name'] ."\"  ][ 'jq'    ] = $( \"#"        .$f[ 'name'       ]. "\" );\r\n"  .
    "F[ \"" .$f['name'] ."\"  ][ 'state' ] = 0;\r\n\r\n";
    $FEH .= "$( \"#". $f['name'] . "\" ).on( \"click\", function( event ) {  updIt3(\"".$f['name']."\"  ,null, true, 1,1); });\r\n";
}

$EEH = '';
$eingang = "let E = new Array();\r\n";
foreach( $_SESSION[ 'liste' ][ 'eingang' ] as $e )
{ $e[ 'f' ] = str_replace( ',', '","', $e[ 'fluegel' ] );
  $eingang .=
    "E[ \"" .$e['name']. "\"  ] = new Object();\r\n".
    "E[ \"" .$e['name'] ."\"  ][ 'ID'    ] = \""            .$e[ 'eingangID'  ]. "\";\r\n"    .
    "E[ \"" .$e['name'] ."\"  ][ 'name'  ] = \""            .$e[ 'name'       ]. "\";\r\n"    .
    "E[ \"" .$e['name'] ."\"  ][ 'F'     ] = new Array( \"" .$e[ 'f'          ]. "\" );\r\n"  .
    "E[ \"" .$e['name'] ."\"  ][ 'jq'    ] = $( \"#"        .$e[ 'name'       ]. "\" );\r\n"  .
    "E[ \"" .$e['name'] ."\"  ][ 'state' ] = 0;\r\n\r\n";
    $EEH .= "$( \"#". $e['name'] . "\" ).on( \"click\", function( event ) {  updIt4(\"".$e['name']."\"  ,null, true, 1,1); });\r\n";
}


# $tab = "<script>" .$JSTS.     "];</script>".$tab;
# $tab = "<script>" .$KL.       "];</script>".$tab;
$tab = "<script>" .$slotlist. "; </script>".$tab;
$tab .= "<script>" .$js .$raum . $cluster . $laufweg . $fluegel . $eingang. "</script>";
$tab .= "<script>" .$REH . $CEH . $LEH . $FEH . $EEH. "</script>";
#$tab .= '<script	src="lib/korokonst.js" type="text/javascript"></script>';
$tab .= '<script	src="lib/koroklaus.js" type="text/javascript"></script>';
$tab .="<script>" .$JSisObserver. ";</script>";
$tab .="<script>
 
 // - Raum ID wird zu Raumnamen ----------
 

for ( const [ key, value ] of Object.entries( SLO ) )  { value.KL.forEach( ID2name ) ; }


// - Raum ID wird zu Raumnamen ----------
</script>";
    
$tab .= "<script>".$JSb2."; </script>\r\n";

# $tab .= "<script>
    /*
    for (const [key, value] of Object.entries(SLO))
    {   //console.log(key );
        //console.log( value);
        console.log( value.ID);
        console.log( value.date);
        console.log( value.state);
        console.log( value.KL);
    }
    */
#</script>\r\n";   ##  OK Button werden (beim Aufruf der Seite) initialisiert
    
    $tab .= "<script> for (const [key, value] of Object.entries(SLO))  {   setIsOkButton( value.ID );  }  </script>\r\n";   ##  OK Button werden (beim Aufruf der Seite) initialisiert
    $tab .= "<script>".$ajax1."; </script>\r\n";
    return $tab;
  }
  
  function formatDozLVA($vll)
  {
    if (isset ($vll[ 'doz' ][ 'abk' ])  AND $vll[ 'doz' ][ 'abk' ] != '' )
    { $dozname =  $vll[ 'doz' ][ 'abk' ] ;
    }
    if (isset ($vll[ 'doz' ][ 'lastname' ])  AND $vll[ 'doz' ][ 'lastname' ] != '' AND   (isset ($vll[ 'doz' ][ 'abk' ])  AND $vll[ 'doz' ][ 'abk' ] != '' ) )
    { $dozname = $vll[ 'doz' ][ 'lastname'  ] .' / ' .$vll[ 'doz' ][ 'abk' ] ;
    }
    elseif (isset ($vll[ 'doz' ][ 'lastname' ])  AND $vll[ 'doz' ][ 'lastname' ]  )
    { $dozname = $vll[ 'doz' ][ 'lastname'  ] ;
    }
    else
    { $dozname = '';
    }
    
    if (isset ($vll[ 'LVA' ][ 'abk' ])  AND $vll[ 'LVA' ][ 'abk' ] != '' )
    { $LVA = $vll[ 'LVA' ][ 'abk'  ] ;
    }
    if (isset ($vll[ 'LVA' ][ 'abk' ])  AND $vll[ 'LVA' ][ 'abk' ] != '' )
    { $LVA = $vll[ 'LVA' ][ 'name' ]. ' / ' .$vll[ 'LVA' ][ 'abk' ] ;
    }
    else
    { $LVA =  '';
    }
    
    $vll[ 'LVA'     ] =  $LVA ;
    $vll[ 'dozname' ] =  $dozname ;
    return $vll;
  }
}


if (!function_exists ( 'deb' ) )
{
  function deb($var)
  {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }
}
