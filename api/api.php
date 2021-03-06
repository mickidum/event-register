<?php
  if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
      header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
      die( header( 'location: /error.php' ) );
  }
?>

<?php
//headers
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=export.csv;');
header('Content-Transfer-Encoding: binary'); 

if($_POST) {

$safe_post = array_map('test_input', $_POST);

if ($safe_post['event_date']) {
  $event_date_file_name = $safe_post['event_date'];
  $temp_file_name = fopen('temp_file_name.txt', 'w');
  fwrite($temp_file_name, 'atidim_event_reg_'.$event_date_file_name);
}

$table_content = fopen('table_content.txt', 'w'); 
$file = fopen('html/atidim_event_reg_'.$event_date_file_name.'.html', 'a+'); 
$csv = fopen('csv/atidim_event_reg_'.$event_date_file_name.'.csv', 'a+');

$event_name = $safe_post['event_name'] ? $safe_post['event_name'] : 'no name';

$text_content = "";
$csv_content = "";
$list_content = [];
array_push($list_content, 'Id');

foreach ($safe_post as $key => $value) {
  if ($key !== "event_name" and $key !== "event_date") {
    $text_content .= "<td>{$value}</td>";
    $csv_content .= "{$value},";
    array_push($list_content, $key);
  }
}

array_push($list_content, 'date');

// COMPOSE HTML TABLE
$html_content_header = '';
if (count(file('html/atidim_event_reg_'.$event_date_file_name.'.html')) < 1) {
  $html_content_header = '<thead><tr>';
  foreach ($list_content as $key => $value) {
    $html_content_header .= "<th>".$value."</th>";
  }
  $html_content_header .= "</tr></thead>"."\r\n"."<tbody>"."\r\n";
}


$html_content = "<tr><td>".(count(file('html/atidim_event_reg_'.$event_date_file_name.'.html')) + 1)."</td>".$text_content."<td>".date("d-m-Y H:i:s")."</td></tr>\n";


array_push($list_content, $event_name);

fwrite($table_content, implode(',', $list_content));

extract($safe_post);

if( $name && $email && $phone && strlen($name)>=2 && strlen($phone)>7){

  echo '{"valid": true, "message": "תודה שנרשמת ומקווים שתהנה באירוע"}';

  fwrite($file, $html_content_header.$html_content);

  $outcsv = $csv_content.date("d-m-Y H:i:s")."\r\n";
  //add BOM to fix UTF-8 in Excel
  fwrite($csv, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
     fwrite($csv, $outcsv);
  }

  else{
  echo '{"valid":false, "message":"יש טעויות בטופס"}'; 
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
