<?php
/*
* Supported File Formats: .XLS | .XLS | .CSV  (Excel 1997-2007)
*/
error_reporting(E_ALL);
require_once( "../db.class.php" );

require_once( "../db.SQLL.class.php" );

$dbL                    = new SQLL_DB();
$db                     = new DB($dbL);
$output = '';

if(isset($_POST["import"]))
{
  $import_counter = 0;	
  $fn = explode(".", $_FILES["excel"]["name"]);
  $extension = $fn[1]; // For getting Extension of selected file

  $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension

  if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
  {
    $file_tmp_name = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file

  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file_tmp_name); // create object of PHPExcel library by using load() method and in load method define path of selected file

  $output .= "<label class='text-success'>Data Added: </label><br /><table class='table table-bordered'>";
  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
    $highestRow = $worksheet->getHighestRow();
    for($row=1; $row<=$highestRow; $row++)
    {
      $vlvz[ 'kid'       ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 0, $row ) -> getValue( ) );
      $vlvz[ 'LVAabk'    ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 1, $row ) -> getValue( ) );
      $vlvz[ 'LVA'       ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 2, $row ) -> getValue( ) );
      $vlvz[ 'semSG'     ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 3, $row ) -> getValue( ) );
      $vlvz[ 'dozabk'    ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 4, $row ) -> getValue( ) );
      $vlvz[ 'doz'       ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 5, $row ) -> getValue( ) );
      $vlvz[ 'bemerkung' ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 6, $row ) -> getValue( ) );
      $vlvz[ 'date'      ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 7, $row ) -> getValue( ) );
      $vlvz[ 'time'      ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 8, $row ) -> getValue( ) );
      $vlvz[ 'anz1'      ] = mysqli_real_escape_string( $db->conn, $worksheet->getCellByColumnAndRow ( 9, $row ) -> getValue( ) );
  
    if( !empty( is_numeric($vlvz[ 'kid' ]) AND ($vlvz[ 'LVAabk' ] ) || !empty( $vlvz[ 'dozabk' ] ) ) )// if none of the data are empty
    {
      $import_counter++;
      $output .= "<tr>";
      
      $db->importRow_vlvz($vlvz);
	  $db->importRow_doz($vlvz);
      $db->importRow_LVA($vlvz);		
	  
	  $output .= '<td>' .$vlvz[ 'kid'     ] . '</td>';
      $output .= '<td>' .$vlvz[ 'dozabk' ] . '</td>';
      $output .= '<td>' .$vlvz[ 'doz'    ] . '</td>';
      $output .= '<td>' .$vlvz[ 'LVAabk' ] . '</td>';
      $output .= '<td>' .$vlvz[ 'LVA'    ] . '</td>';
      $output .= '<td>' .$vlvz[ 'semSG'  ] . '</td>';
      $output .= '<td>' .$vlvz[ 'date'   ] . ' ' .$vlvz[ 'time'  ] .'</td>';
      $output .= '<td>' .$vlvz[ 'bemerkung' ] . ' ' .$vlvz[ 'bemerkung'  ] .'</td>';

      $output .= '</tr>';
    }
    else
    {
       # deb($vlvz);
    }
   }
  } 
  $output .= '</table>';
  $output .= '<div>'. $import_counter. ' Datensätze importiert</div>';
  
  $target_dir = "/home/koronaklaus/upload"; //file upload folder
  $target_file = $target_dir .time().basename( $_FILES[ "excel" ][ "name" ] ); // target file to be uploaded

  //upload the file
  if (move_uploaded_file($file_tmp_name, $target_file)) {
       $fileUploadMsg= "<label class='text-success'>The file has been uploaded Successfully!</label><br>";
    } else {
       $fileUploadMsg= '<label class="text-danger">Sorry, there was an error uploading your file!</label><br>';
    }

 }
 else
 {
  $output = '<label class="text-danger">Invalid File</label>'; //if non excel file then
 }
}


function deb($var)
{
	echo "<pre>";
	print_r($var);
	echo "</pre>";
}


?>

<html>
 <head>
  <title>PHP Excel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color: #0cb313b3;
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  input[type="file"]{
    border:1px solid gray;
  }

  td {
      width: 100px;
      font-size: 10px;
  }
  </style>
 </head>
 <body>
  <div class="container box">
   <form method="post" enctype="multipart/form-data">
    <div class="container-fluid">
      <h3 align="center" class="text-success" style="font-weight:600;">Excel Importer</h3><br />
      <div class="row" style="margin-bottom:20px">
        <div class="col-md-4 col-xs-4 col-sm-4"></div>  <!-- Blank Div -->
        <div class="col-md-4 ">
          <img src="img/excel.png" height="150px" width="150px">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
          <label>Select Excel File*</label>
        </div>
        <div class="col-xs-6 col-md-5 col-sm-6 col-lg-5">
            <input type="file"  name="excel" style="width:600px" />
        </div>
        <div class="col-xs-7 col-md-7 col-sm-6 col-lg-7">
            <input type="submit" name="import" class="btn btn-info" value="Import" style="margin-left:240px; padding:2px 20px;"/>
        </div>
      </div>
  </div>
   </form>
   <br />
   <br />
   <?php
      echo $output;
      echo @$fileUploadMsg;
      echo "<hr/>
			<p style='float:left'>* Supported Formats: .xls | .xlsx | .csv</p>
			<p style='float:right'><a href='export.php'>Exporter &#8594;</a></p>";
   ?>
  </div>
 </body>
</html>


