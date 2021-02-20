 <?php
 require_once( "../inc/db.class.php" );
 require_once( "../inc/db.IDM.class.php" );
 
 $dbIDM                  = new DBIDM();
 $db                     = new DB( $dbIDM );

 $row = 1;
 if (($handle = fopen("klausurenW2020.csv", "r")) !== FALSE) {
   while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
     $data[] = $db->getProfAbk( $data[1] );
     # print_r($data);
     $vlv[] = $data;
   }
   fclose($handle);
 }

foreach ($vlv as $vl)
{
  print_r($db->setSG2( $vl ));
}

/*
  $id = $_GET['id'];
  $state = $_GET['p'] ;
  
  $db->setWishState( $id, $state );

  if ($state == 1) { $stateN = 'W'; }
  if ($state == 2) { $stateN = 'B'; }
  
  echo  '<a href="#" class="'.$stateN.'" onclick="return false;" id="alink'.$id.'a">'.$stateN.'</a>';
 */
?>
