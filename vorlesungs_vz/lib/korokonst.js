
let  statusBox = document.getElementById("statusBox");
let  statusText = document.getElementById("statusText");

$("#bemerkung89").on("change",function() { updateAnote( 89, this.value )   } );


let R = new Array();
R[ "S407"  ] = new Object();
R[ "S407"  ][ 'ID'    ] = "1029"  ;
R[ "S407"  ][ 'name'  ] = "S4.07" ;
R[ "S407"  ][ 'pers'  ] =  21     ;
R[ "S407"  ][ 'state' ] =  0      ;
R[ "S407"  ][ 'jq'    ] =  $( "#S407"   );

R[ "S40506"  ] = new Object();
R[ "S40506"  ][ 'ID'    ] = "1028"   ;
R[ "S40506"  ][ 'name'  ] = "S4.05-06" ;
R[ "S40506"  ][ 'pers'  ] =  19;
R[ "S40506"  ][ 'state' ] =  0         ;
R[ "S40506"  ][ 'jq'    ] =  $( "#S40506" );

R[ "S308"  ] = new Object();
R[ "S308"  ][ 'ID'    ] = "1027"	;
R[ "S308"  ][ 'name'  ] = "S3.08"	;
R[ "S308"  ][ 'pers'  ] =  22  ;
R[ "S308"  ][ 'state' ] =  0    ;
R[ "S308"  ][ 'jq'    ] =  $( "#S308"   )  ;

R[ "S404"  ] = new Object();
R[ "S404"  ][ 'ID'    ] = "1026" ;
R[ "S404"  ][ 'name'  ] = "S4.04";
R[ "S404"  ][ 'pers'  ] =  22 ;
R[ "S404"  ][ 'state' ] =  0    ;
R[ "S404"  ][ 'jq'    ] =  $( "#S404"   )   ;

R[ "N41011"  ] = new Object();
R[ "N41011"  ][ 'ID'    ] = "1025";
R[ "N41011"  ][ 'name'  ] = "N4.10-11";
R[ "N41011"  ][ 'pers'  ] =  21 ;
R[ "N41011"  ][ 'state' ] =  0    ;
R[ "N41011"  ][ 'jq'    ] =  $( "#N41011" )   ;

R[ "N412"  ] = new Object();
R[ "N412"  ][ 'ID'    ] = "1024";
R[ "N412"  ][ 'name'  ] = "N4.12";
R[ "N412"  ][ 'pers'  ] = 17  ;
R[ "N412"  ][ 'state' ] =  0    ;
R[ "N412"  ][ 'jq'    ] =  $( "#N412"   )   ;

R[ "N227"  ] = new Object();
R[ "N227"  ][ 'ID'    ] = "1023"	;
R[ "N227"  ][ 'name'  ] = "N2.27"	;
R[ "N227"  ][ 'pers'  ] =  7  ;
R[ "N227"  ][ 'state' ] =  0    ;
R[ "N227"  ][ 'jq'    ] =  $( "#N227"   )   ;

R[ "N225"  ] = new Object();
R[ "N225"  ][ 'ID'    ] = "1022";
R[ "N225"  ][ 'name'  ] = "N2.25";
R[ "N225"  ][ 'pers'  ] =  9  ;
R[ "N225"  ][ 'state' ] =  0    ;
R[ "N225"  ][ 'jq'    ] =  $( "#N225"   )    ;

R[ "FoyG"  ] = new Object();
R[ "FoyG"  ][ 'ID'    ] = "1021";
R[ "FoyG"  ][ 'name'  ] = "Foyer ges";
R[ "FoyG"  ][ 'pers'  ] =  74 ;
R[ "FoyG"  ][ 'state' ] =  0    ;
R[ "FoyG"  ][ 'jq'    ] =  $( "#FoyG"   )  ;

R[ "S402"  ] = new Object();
R[ "S402"  ][ 'ID'    ] = "1020" ;
R[ "S402"  ][ 'name'  ] = "S4.02";
R[ "S402"  ][ 'pers'  ] =  9   ;
R[ "S402"  ][ 'state' ] =  0    ;
R[ "S402"  ][ 'jq'    ] =  $( "#S402"   )   ;

R[ "S401"  ] = new Object();
R[ "S401"  ][ 'ID'    ] = "1019";
R[ "S401"  ][ 'name'  ] = "S4.01"	;
R[ "S401"  ][ 'pers'  ] =  21 ;
R[ "S401"  ][ 'state' ] =  0    ;
R[ "S401"  ][ 'jq'    ] =  $( "#S401"   )    ;

R[ "S302"  ] = new Object();
R[ "S302"  ][ 'ID'    ] = "1018"	;
R[ "S302"  ][ 'name'  ] = "S3.02";
R[ "S302"  ][ 'pers'  ] =  9  ;
R[ "S302"  ][ 'state' ] =  0    ;
R[ "S302"  ][ 'jq'    ] =  $( "#S302"   )   ;

R[ "S301"  ] = new Object();
R[ "S301"  ][ 'ID'   ] = "1017"	;
R[ "S301"  ][ 'name' ] = "S3.01"	;
R[ "S301"  ][ 'pers' ] =  21 ;
R[ "S301"  ][ 'jq'   ] =    $( "#S301"   )   ;
R[ "S301"  ][ 'state' ] =  0    ;

R[ "S403"  ] = new Object();
R[ "S403"  ][ 'ID'   ] = "1016";
R[ "S403"  ][ 'name' ] = "S4.03"	;
R[ "S403"  ][ 'pers' ] =  9  ;
R[ "S403"  ][ 'jq'   ] =   $( "#S403"   )   ;
R[ "S403"  ][ 'state' ] =  0    ;

R[ "S303"  ] = new Object();
R[ "S303"  ][ 'ID'   ] = "1015"	;
R[ "S303"  ][ 'name' ] = "S3.03"	;
R[ "S303"  ][ 'pers' ] =  	9  ;
R[ "S303"  ][ 'jq'    ] =  $( "#S303"   )    ;
R[ "S303"  ][ 'state' ] =  0    ;

R[ "109"  ] = new Object();
R[ "109"  ][ 'ID'   ] = "1014";
R[ "109"  ][ 'name' ] = "1.09";
R[ "109"  ][ 'pers' ] =  9 ;
R[ "109"  ][ 'jq'    ] =    $( "#109"    )   ;
R[ "109"  ][ 'state' ] =  0    ;

R[ "108"  ] = new Object();
R[ "108"  ][ 'ID'   ] = "1013";
R[ "108"  ][ 'name' ] = "1.08";
R[ "108"  ][ 'pers' ] =  8 ;
R[ "108"  ][ 'jq'    ] =    $( "#108"    )   ;
R[ "108"  ][ 'state' ] =  0    ;

R[ "107ab"  ] = new Object();
R[ "107ab"  ][ 'ID'   ] = "1012"	;
R[ "107ab"  ][ 'name' ] = "1.07 a-b";
R[ "107ab"  ][ 'pers' ] =  20 ;
R[ "107ab"  ][ 'jq'    ] =     $( "#107ab"  )  ;
R[ "107ab"  ][ 'state' ] =  0    ;

R[ "125"  ] = new Object();
R[ "125"  ][ 'ID'   ] = "1011";
R[ "125"  ][ 'name' ] = "1.25"	;
R[ "125"  ][ 'pers' ] =  4  ;
R[ "125"  ][ 'jq'    ] =  $( "#125"    )    ;
R[ "125"  ][ 'state' ] =  0    ;

R[ "N409"  ] = new Object();
R[ "N409"  ][ 'ID'   ] = "1010";
R[ "N409"  ][ 'name' ] = "N4.09";
R[ "N409"  ][ 'pers' ] =  10 ;
R[ "N409"  ][ 'jq'    ] =  $( "#N409"   )    ;
R[ "N409"  ][ 'state' ] =  0    ;

R[ "FoyO"  ] = new Object();
R[ "FoyO"  ][ 'ID'   ] = "1009";
R[ "FoyO"  ][ 'name' ] = "Foyer Ost";
R[ "FoyO"  ][ 'pers' ] =  28 ;
R[ "FoyO"  ][ 'jq'    ] =   $( "#FoyO"   )   ;
R[ "FoyO"  ][ 'state' ] =  0    ;

R[ "N408"  ] = new Object();
R[ "N408"  ][ 'ID'   ] = "1008";
R[ "N408"  ][ 'name' ] = "N4.08";
R[ "N408"  ][ 'pers' ] =  9 ;
R[ "N408"  ][ 'jq'    ] =   $( "#N408"   )    ;
R[ "N408"  ][ 'state' ] =  0    ;

R[ "N407"  ] = new Object();
R[ "N407"  ][ 'ID'   ] = "1007";
R[ "N407"  ][ 'name' ] = "N4.07";
R[ "N407"  ][ 'pers' ] =  9 ;
R[ "N407"  ][ 'jq'    ] =  $( "#N407"   )    ;
R[ "N407"  ][ 'state' ] =  0    ;

R[ "N517"  ] = new Object();
R[ "N517"  ][ 'ID'   ] = "1006";
R[ "N517"  ][ 'name' ] = "N5.17";
R[ "N517"  ][ 'pers' ] =  22 ;
R[ "N517"  ][ 'jq'    ] =    $( "#N517"   )   ;
R[ "N517"  ][ 'state' ] =  0    ;

R[ "N406"  ] = new Object();
R[ "N406"  ][ 'ID'   ] = "1005";
R[ "N406"  ][ 'name' ] = "N4.06"	;
R[ "N406"  ][ 'pers' ] =  9  ;
R[ "N406"  ][ 'jq'    ] =   $( "#N406"   )   ;
R[ "N406"  ][ 'state' ] =  0    ;

R[ "N310"  ] = new Object();
R[ "N310"  ][ 'ID'   ] = "1004";
R[ "N310"  ][ 'name' ] = "N3.10" ;
R[ "N310"  ][ 'pers' ] =  7 ;
R[ "N310"  ][ 'jq'    ] =    $( "#N310"   )   ;
R[ "N310"  ][ 'state' ] =  0    ;

R[ "N219"  ] = new Object();
R[ "N219"  ][ 'ID'   ] = "1003"	 ;
R[ "N219"  ][ 'name' ] = "N2.19"	;
R[ "N219"  ][ 'pers' ] =  8  ;
R[ "N219"  ][ 'jq'    ] =    $( "#N219"   )   ;
R[ "N219"  ][ 'state' ] =  0    ;

R[ "N218"  ] = new Object();
R[ "N218"  ][ 'ID'   ] = "1002";
R[ "N218"  ][ 'name' ] = "N2.18";
R[ "N218"  ][ 'pers' ] =  8  ;
R[ "N218"  ][ 'jq'    ] =   $( "#N218"   )    ;
R[ "N218"  ][ 'state' ] =  0    ;

R[ "N215"  ] = new Object();
R[ "N215"  ][ 'ID'   ] = "1001";
R[ "N215"  ][ 'name' ] = "N2.15";
R[ "N215"  ][ 'pers' ] =  8  ;
R[ "N215"  ][ 'jq'    ] =      $( "#N215"   )  ;
R[ "N215"  ][ 'state' ] =  0    ;

R[ "FoyW"  ] = new Object();
R[ "FoyW"  ][ 'ID'   ] = "1000"	;
R[ "FoyW"  ][ 'name' ] = "Foyer West";
R[ "FoyW"  ][ 'pers' ] = 45 ;
R[ "FoyW"  ][ 'jq'    ] =    $( "#FoyW"   )    ;
R[ "FoyW"  ][ 'state' ] =  0    ;


let C = new Array();
C[ "C08" ] = new Object();
C[ "C08" ][ 'ID' ] =  "2017"    ;
C[ "C08" ][ 'state' ] =  0    ;
C[ "C08" ][ "R"     ] =  new Array(  "S407"                            );
C[ "C08" ][ 'jq'    ] =  $( "#C08"   )  ;

C[ "C07" ] = new Object();
C[ "C07" ][ 'ID' ] = "2016"    ;
C[ "C07" ][ 'state' ] =  0    ;
C[ "C07" ][ "R"     ] =  new Array(  "S40506"                         );
C[ "C07" ][ 'jq'    ] =  $( "#C07"   )  ;

C[ "C06" ] = new Object();
C[ "C06" ][ 'ID' ] =  "2015"    ;
C[ "C06" ][ 'state' ] =  0    ;
C[ "C06" ][ "R"     ] =  new Array(  "S308"                           );
C[ "C06" ][ 'jq'    ] =  $( "#C06"   )  ;

C[ "C05" ] = new Object();
C[ "C05" ][ 'ID' ] =  "2014"    ;
C[ "C05" ][ 'state' ] =  0    ;
C[ "C05" ][ "R"     ] =  new Array(  "S404"                           );
C[ "C05" ][ 'jq'    ] =  $( "#C05"   )  ;

C[ "C12" ] = new Object();
C[ "C12" ][ 'ID' ] =  "2013"    ;
C[ "C12" ][ 'state' ] =  0    ;
C[ "C12" ][ "R"     ] =  new Array(  "N41011"  , "N412"               );
C[ "C12" ][ 'jq'    ] =  $( "#C12"   )  ;

C[ "C18" ] = new Object();
C[ "C18" ][ 'ID' ] =  "2012"    ;
C[ "C18" ][ 'state' ] =  0    ;
C[ "C18" ][ "R"     ] =  new Array(  "N227"  , "N225"                 );
C[ "C18" ][ 'jq'    ] =  $( "#C18"   )  ;

C[ "C16" ] = new Object();
C[ "C16" ][ 'ID' ] = "2011"    ;
C[ "C16" ][ 'state' ] =  0    ;
C[ "C16" ][ "R"     ] =  new Array( "FoyG"                             );
C[ "C16" ][ 'jq'    ] =  $( "#C16"   )  ;

C[ "C02" ] = new Object();
C[ "C02" ][ 'ID' ] =  "2010"    ;
C[ "C02" ][ 'state' ] =  0    ;
C[ "C02" ][ "R"     ] =  new Array( "S402"   ,  "S401"                );
C[ "C02" ][ 'jq'    ] =  $( "#C02"   )  ;

C[ "C01" ] = new Object();
C[ "C01" ][ 'ID' ] =  "2009"    ;
C[ "C01" ][ 'state' ] =  0    ;
C[ "C01" ][ "R"     ] =  new Array(  "S302"  ,  "S301"                );
C[ "C01" ][ 'jq'    ] =  $( "#C01"   )  ;

C[ "C04" ] = new Object();
C[ "C04" ][ 'ID' ] =  "2008"    ;
C[ "C04" ][ 'state' ] =  0    ;
C[ "C04" ][ "R"     ] =  new Array(  "S403"  ,  "S303"                );
C[ "C04" ][ 'jq'    ] =  $( "#C04"   )  ;

C[ "C03" ] = new Object();
C[ "C03" ][ 'ID' ] = "2007"    ;
C[ "C03" ][ 'state' ] =  0    ;
C[ "C03" ][ "R"     ] =  new Array( "109" , "108" , "107ab"           );
C[ "C03" ][ 'jq'    ] =  $( "#C03"   )  ;

C[ "C13" ] = new Object();
C[ "C13" ][ 'ID' ] =  "2006"    ;
C[ "C13" ][ 'state' ] =  0    ;
C[ "C13" ][ "R"     ] =  new Array( "125"                             );
C[ "C13" ][ 'jq'    ] =  $( "#C13"   )  ;

C[ "C11" ] = new Object();
C[ "C11" ][ 'ID' ] =  "2005"    ;
C[ "C11" ][ 'state' ] =  0;
C[ "C11" ][ "R"     ] =  new Array( "N409"                            );
C[ "C11" ][ 'jq'    ] =  $( "#C11"   )  ;

C[ "C14" ] = new Object();
C[ "C14" ][ 'ID' ] =  "2004"    ;
C[ "C14" ][ 'state' ] =  0    ;
C[ "C14" ][ "R"     ] =  new Array( "FoyO"                            );
C[ "C14" ][ 'jq'    ] =  $( "#C14"   )  ;

C[ "C10" ] = new Object();
C[ "C10" ][ 'ID' ] =  "2003"    ;
C[ "C10" ][ 'state' ] =  0    ;
C[ "C10" ][ "R"     ] =  new Array(  "N408" , "N407"                  );
C[ "C10" ][ 'jq'    ] =  $( "#C10"   )  ;

C[ "C09" ] = new Object();
C[ "C09" ][ 'ID' ] = "2002"    ;
C[ "C09" ][ 'state' ] =  0    ;
C[ "C09" ][ "R"     ] =  new Array( "N517", "N406"                    );
C[ "C09" ][ 'jq'    ] =  $( "#C09"   )  ;

C[ "C17" ] = new Object();
C[ "C17" ][ 'ID' ] = "2001"    ;
C[ "C17" ][ 'state' ] =  0    ;
C[ "C17" ][ "R"     ] =  new Array( "N310" , "N219" , "N218" , "N215" );
C[ "C17" ][ 'jq'    ] =  $( "#C17"   )  ;

C[ "C15" ] = new Object();
C[ "C15" ][ 'ID' ] =  "2000"    ;
C[ "C15" ][ 'state' ] =  0    ;
C[ "C15" ][ "R"     ] =  new Array(  "FoyW"                               );
C[ "C15" ][ 'jq'    ] =  $( "#C15"   )  ;


let L = new Array();
L[ "grun1"  ] = new Object();
L[ "grun1"  ] [ 'C'    ] =  new Array( "C08" , "C07" , "C06" );
L[ "grun1"  ][ 'ID'    ] = "3011" ;
L[ "grun1"  ][ 'name'  ] = "grun1" ;
L[ "grun1"  ][ 'state' ] =  0 ;
L[ "grun1"  ][ 'jq'    ] =  $( "#grun1"   );

L[ "lila"   ] = new Object();
L[ "lila"   ][ 'C'     ] =  new Array(  "C05"               );
L[ "lila"   ][ 'ID'    ] = "3010"  ;
L[ "lila"   ][ 'name'  ] = "lila" ;
L[ "lila"   ][ 'state' ] =  0      ;
L[ "lila"   ][ 'jq'    ] =  $( "#lila"   );

L[ "rot1"  ] = new Object();
L[ "rot1"  ][ 'ID'    ] = "3009"  ;
L[ "rot1"  ][ 'name'  ] = "rot1"  ;
L[ "rot1"  ][ 'state' ] =  0       ;
L[ "rot1"  ][ 'C'     ] =  new Array(  "C12"  , "C18"       );
L[ "rot1"  ][ 'jq'    ] =  $( "#rot1"   );

L[ "blau"  ] = new Object();
L[ "blau"  ][ 'ID'    ] = "3008"  ;
L[ "blau"  ][ 'name'  ] = "blau" ;
L[ "blau"  ][ 'state' ] =  0      ;
L[ "blau"  ][ 'C'     ] =   new Array(  "C16"               );
L[ "blau"  ][ 'jq'    ] =  $( "#blau"   );

L[ "grun2"  ] = new Object();
L[ "grun2"  ][ 'ID'    ] = "3007"  ;
L[ "grun2"  ][ 'name'  ] = "grun2" ;
L[ "grun2"  ][ 'state' ] =  0      ;
L[ "grun2"  ][ 'C'     ] =  new Array(  "C02"  , "C01"       );
L[ "grun2"  ][ 'jq'    ] =  $( "#grun2"   );

L[ "orange"  ] = new Object();
L[ "orange"  ][ 'ID'    ] = "3006"  ;
L[ "orange"  ][ 'name'  ] = "orange" ;
L[ "orange"  ][ 'state' ] =  0      ;
L[ "orange"  ][ 'C'     ] =  new Array(  "C04"  , "C03"       );
L[ "orange"  ][ 'jq'    ] =  $( "#orange"   );

L[ "rot2"  ] = new Object();
L[ "rot2"  ][ 'ID'    ] = "3005"  ;
L[ "rot2"  ][ 'name'  ] = "rot2" ;
L[ "rot2"  ][ 'state' ] =  0      ;
L[ "rot2"  ][ 'C'     ] =  new Array(  "C13"                  );
L[ "rot2"  ][ 'jq'    ] =  $( "#rot2"   );

L[ "schwarz"  ] = new Object();
L[ "schwarz"  ][ 'ID'    ] = "3004"  ;
L[ "schwarz"  ][ 'name'  ] = "schwarz" ;
L[ "schwarz"  ][ 'state' ] =  0      ;
L[ "schwarz"  ][ 'C'     ] = new Array(  "C11"  , "C14"       );
L[ "schwarz"  ][ 'jq'    ] =  $( "#schwarz"   );

L[ "gelb"  ] = new Object();
L[ "gelb"  ][ 'ID'    ] = "3003" ;
L[ "gelb"  ][ 'name'  ] = "gelb" ;
L[ "gelb"  ][ 'state' ] =  0 ;
L[ "gelb"  ][ 'C'     ] =   new Array(  "C10"               );
L[ "gelb"  ][ 'jq'    ] =  $( "#gelb"   );

L[ "pink"  ] = new Object();
L[ "pink"  ][ 'ID'    ] = "3002"  ;
L[ "pink"  ][ 'name'  ] = "pink" ;
L[ "pink"  ][ 'state' ] =  0      ;
L[ "pink"  ][ 'C'     ] = new Array(  "C09"  , "C17"       );
L[ "pink"  ][ 'jq'    ] = $( "#pink"   );

L[ "grau"  ] = new Object();
L[ "grau"  ][ 'ID'    ] = "3001"  ;
L[ "grau"  ][ 'name'  ] = "grau" ;
L[ "grau"  ][ 'state' ] =  0      ;
L[ "grau"  ][ 'C'     ] =  new Array(  "C15"               );
L[ "grau"  ][ 'jq'    ] =  $( "#grau"   );



let F = new Array();
F[ "ULS"  ] = new Object();
F[ "ULS"  ][ 'ID'    ] = "4004"  ;
F[ "ULS"  ][ 'name'  ] = "ULS" ;
F[ "ULS"  ][ 'state' ] =  0      ;
F[ "ULS"  ][ 'jq'    ] =  $( "#ULS"   );
F[ "ULS"  ][ "L" ]	=  new Array( "grun1" ,  "lila"              );

F[ "ULN"  ] = new Object();
F[ "ULN"  ][ 'ID'    ] = "4003"  ;
F[ "ULN"  ][ 'name'  ] = "ULN" ;
F[ "ULN"  ][ 'state' ] =  0      ;
F[ "ULN"  ][ 'jq'    ] =  $( "#ULN"   );
F[ "ULN" ][ "L" ]	=  new Array( "rot1"  ,  "blau"              );

F[ "HOS"  ] = new Object();
F[ "HOS"  ][ 'ID'    ] = "4002"  ;
F[ "HOS"  ][ 'name'  ] = "HOS" ;
F[ "HOS"  ][ 'state' ] =  0      ;
F[ "HOS"  ][ 'jq'    ] =  $( "#HOS"   );
F[ "HOS" ][ "L" ]	=  new Array( "grun2" ,  "orange"            );

F[ "HON"  ] = new Object();
F[ "HON"  ][ 'ID'    ] = "4001"  ;
F[ "HON"  ][ 'name'  ] = "HON" ;
F[ "HON"  ][ 'state' ] =  0      ;
F[ "HON"  ][ 'jq'    ] =  $( "#HON"   );
F[ "HON" ][ "L" ]	=  new Array( "rot2"  ,  "schwarz"           );

F[ "HWN"  ] = new Object();
F[ "HWN"  ][ 'ID'    ] = "4000"  ;
F[ "HWN"  ][ 'name'  ] = "HWN" ;
F[ "HWN"  ][ 'state' ] =  0      ;
F[ "HWN"  ][ 'jq'    ] =  $( "#HWN"   );
F[ "HWN" ][ "L" ]	=  new Array( "gelb"  ,  "pink"   ,  "grau"  );


let E = new Array();
E[ "UL" ] = new Object();
E[ "UL" ][ 'ID'    ] = "5002"  ;
E[ "UL" ][ 'name'  ] = "UL" ;
E[ "UL" ][ 'state' ] =  0      ;
E[ "UL" ][ 'jq'    ] =  $( "#UL"   );
E[ "UL" ][ "F" ] = new Array( "ULS" , "ULN" );

E[ "HO" ] = new Object();
E[ "HO" ][ 'ID'    ] = "5001"  ;
E[ "HO" ][ 'name'  ] = "HO" ;
E[ "HO" ][ 'state' ] =  0      ;
E[ "HO" ][ 'jq'    ] =  $( "#HO"   );
E[ "HO" ][ "F" ] = new Array( "HOS" , "HON" );

E[ "HW" ] = new Object();
E[ "HW" ][ 'ID'    ] = "5000"  ;
E[ "HW" ][ 'name'  ] = "HW" ;
E[ "HW" ][ 'state' ] =  0      ;
E[ "HW" ][ 'jq'    ] =  $( "#HW"   );
E[ "HW" ][ "F" ] = new Array( "HWN"         );


$( "#S407"   ).on( "click", function( event ) {  updIt0("S407"  ,null, true, 1); });
$( "#S40506" ).on( "click", function( event ) {  updIt0("S40506",null, true, 1); });
$( "#S308"   ).on( "click", function( event ) {  updIt0("S308"  ,null, true, 1); });
$( "#S404"   ).on( "click", function( event ) {  updIt0("S404"  ,null, true, 1); });
$( "#N41011" ).on( "click", function( event ) {  updIt0("N41011",null, true, 1); });
$( "#N412"   ).on( "click", function( event ) {  updIt0("N412"  ,null, true, 1); });
$( "#N227"   ).on( "click", function( event ) {  updIt0("N227"  ,null, true, 1); });
$( "#N225"   ).on( "click", function( event ) {  updIt0("N225"  ,null, true, 1); });
$( "#FoyG"   ).on( "click", function( event ) {  updIt0("FoyG"  ,null, true, 1); });
$( "#S402"   ).on( "click", function( event ) {  updIt0("S402"  ,null, true, 1); });
$( "#S401"   ).on( "click", function( event ) {  updIt0("S401"  ,null, true, 1); });
$( "#S302"   ).on( "click", function( event ) {  updIt0("S302"  ,null, true, 1); });
$( "#S301"   ).on( "click", function( event ) {  updIt0("S301"  ,null, true, 1); });
$( "#S403"   ).on( "click", function( event ) {  updIt0("S403"  ,null, true, 1); });
$( "#S303"   ).on( "click", function( event ) {  updIt0("S303"  ,null, true, 1); });
$( "#109"    ).on( "click", function( event ) {  updIt0("109"   ,null, true, 1); });
$( "#108"    ).on( "click", function( event ) {  updIt0("108"   ,null, true, 1); });
$( "#107ab"  ).on( "click", function( event ) {  updIt0("107ab" ,null, true, 1); });
$( "#125"    ).on( "click", function( event ) {  updIt0("125"   ,null, true, 1); });
$( "#N409"   ).on( "click", function( event ) {  updIt0("N409"  ,null, true, 1); });
$( "#FoyO"   ).on( "click", function( event ) {  updIt0("FoyO"  ,null, true, 1); });
$( "#N408"   ).on( "click", function( event ) {  updIt0("N408"  ,null, true, 1); });
$( "#N407"   ).on( "click", function( event ) {  updIt0("N407"  ,null, true, 1); });
$( "#N517"   ).on( "click", function( event ) {  updIt0("N517"  ,null, true, 1); });
$( "#N406"   ).on( "click", function( event ) {  updIt0("N406"  ,null, true, 1); });
$( "#N310"   ).on( "click", function( event ) {  updIt0("N310"  ,null, true, 1); });
$( "#N219"   ).on( "click", function( event ) {  updIt0("N219"  ,null, true, 1); });
$( "#N218"   ).on( "click", function( event ) {  updIt0("N218"  ,null, true, 1); });
$( "#N215"   ).on( "click", function( event ) {  updIt0("N215"  ,null, true, 1); });
$( "#FoyW"   ).on( "click", function( event ) {  updIt0("FoyW"  ,null, true, 1); });


$( "#C08" ).on( "click", function( event ) { updIt1("C08",null, true, 1,1);  });
$( "#C07" ).on( "click", function( event ) { updIt1("C07",null, true, 1,1);  });
$( "#C06" ).on( "click", function( event ) { updIt1("C06",null, true, 1,1);  });
$( "#C05" ).on( "click", function( event ) { updIt1("C05",null, true, 1,1);  });
$( "#C12" ).on( "click", function( event ) { updIt1("C12",null, true, 1,1);  });
$( "#C18" ).on( "click", function( event ) { updIt1("C18",null, true, 1,1);  });
$( "#C16" ).on( "click", function( event ) { updIt1("C16",null, true, 1,1);  });
$( "#C02" ).on( "click", function( event ) { updIt1("C02",null, true, 1,1);  });
$( "#C01" ).on( "click", function( event ) { updIt1("C01",null, true, 1,1);  });
$( "#C04" ).on( "click", function( event ) { updIt1("C04",null, true, 1,1);  });
$( "#C03" ).on( "click", function( event ) { updIt1("C03",null, true, 1,1);  });
$( "#C13" ).on( "click", function( event ) { updIt1("C13",null, true, 1,1);  });
$( "#C11" ).on( "click", function( event ) { updIt1("C11",null, true, 1,1);  });
$( "#C14" ).on( "click", function( event ) { updIt1("C14",null, true, 1,1);  });
$( "#C10" ).on( "click", function( event ) { updIt1("C10",null, true, 1,1);  });
$( "#C09" ).on( "click", function( event ) { updIt1("C09",null, true, 1,1);  });
$( "#C17" ).on( "click", function( event ) { updIt1("C17",null, true, 1,1);  });
$( "#C15" ).on( "click", function( event ) { updIt1("C15",null, true, 1,1);  });

$( "#grun1"   ).on( "click", function( event ) { updIt2("grun1"  ,null, true, 1,1);  });
$( "#lila"    ).on( "click", function( event ) { updIt2("lila"   ,null, true, 1,1);  });
$( "#blau"    ).on( "click", function( event ) { updIt2("blau"   ,null, true, 1,1);  });
$( "#grun2"   ).on( "click", function( event ) { updIt2("grun2"  ,null, true, 1,1);  });
$( "#orange"  ).on( "click", function( event ) { updIt2("orange" ,null, true, 1,1);  });
$( "#rot1"    ).on( "click", function( event ) { updIt2("rot1"   ,null, true, 1,1);  });
$( "#rot2"    ).on( "click", function( event ) { updIt2("rot2"   ,null, true, 1,1);  });
$( "#schwarz" ).on( "click", function( event ) { updIt2("schwarz",null, true, 1,1);  });
$( "#gelb"    ).on( "click", function( event ) { updIt2("gelb"   ,null, true, 1,1);  });
$( "#pink"    ).on( "click", function( event ) { updIt2("pink"   ,null, true, 1,1);  });
$( "#grau"    ).on( "click", function( event ) { updIt2("grau"   ,null, true, 1,1);  });

$( "#ULS" ).on( "click", function( event ) { updIt3( "ULS" ,null, true, 1,1); });
$( "#ULN" ).on( "click", function( event ) { updIt3( "ULN" ,null, true, 1,1); });
$( "#HOS" ).on( "click", function( event ) { updIt3( "HOS" ,null, true, 1,1); });
$( "#HON" ).on( "click", function( event ) { updIt3( "HON" ,null, true, 1,1); });
$( "#HWN" ).on( "click", function( event ) { updIt3( "HWN" ,null, true, 1,1); });

$( "#UL" ).on( "click", function( event ) { updIt4( "UL",null, true, 1,1); });
$( "#HO" ).on( "click", function( event ) { updIt4( "HO",null, true, 1,1); });
$( "#HW" ).on( "click", function( event ) { updIt4( "HW",null, true, 1,1); });

