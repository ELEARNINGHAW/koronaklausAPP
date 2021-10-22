 <?php
    require_once( "../inc/db.class.php" );
# require_once( "../inc/db.IDM.class.php" );
# $dbIDM                  = new DBIDM();
$db                     = new DB();

 $action = $_GET['action'];
#
 if ($action == 'addone')
 {
   $db->addBlankRow();
 }

 if ($action == 'deleterow')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->deleteRow($id, $val);
  }

 if ($action == 'changeAnzStudi1')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setAnzStudi1( $id, $val );
 }
 else if ($action == 'changeAnzStudi2')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setAnzStudi2( $id, $val );
 }

 else if ($action == 'changeSG')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setSG( $id, $val );
 }

 else if ($action == 'changesem')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setsem( $id, $val );
 }

 else if ($action == 'changedozn')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setdozent( $id, $val );
 }

 
 else if ($action == 'changeanote')
 {
   $id = $_GET['id'];
   $val = $_POST['val'] ;
   $db->setanote( $id, $val );
 }

 
 else if ($action == 'changeLVA')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setLVA( $id, $val );
 }

 
 else if ($action == 'changeSem')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setsem( $id, $val );
 }
 
 
 else if ($action == 'changedate')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setdate( $id, $val );
 }

 else if ($action == 'changetime')
 {
   $id = $_GET['id'];
   $val = $_GET['val'];
   $db->settime($id, $val);
 }
 
 else if ($action == 'changeSAnz1')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setAnzStudi1( $id, $val );
 }

 else if ($action == 'changeSAnz2')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setAnzStudi2( $id, $val );
 }

 else if ($action == 'changeRaum')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setRaum( $id, $val );
 }


 else if ($action == 'changeChecked')
 {
   $id = $_GET['id'];
   $val = $_GET['val'] ;
   $db->setChecked( $id, $val );
   
 }


 ?>
