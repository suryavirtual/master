<?php
include("configuration.php");
$obj = new JConfig();
$host = $obj->host;
$dbUser = $obj->user;
$dbPwd = $obj->password;
$dbName = $obj->db;
$link = mysql_connect($host, $dbUser, $dbPwd);
@mysql_select_db($dbName,$link);
$setCounter = 0;
$setExcelName = "download_Supplier_Member_Permissions";
$setSql = "SELECT ma.id,u.name,mt.link_name as Suppliername,mt1.link_name as Membername,ma.docIds as Permission FROM jos_member_access as ma
left join jos_users as u on(u.id=ma.userId)
inner join jos_mt_links as mt on(mt.link_id=ma.supplierId)
inner join jos_mt_links as mt1 on(mt1.link_id=ma.memberId) ";
$setRec = mysql_query($setSql);
$setCounter = mysql_num_fields($setRec);
for ($i = 0; $i < $setCounter; $i++) {
   $setMainHeader .= mysql_field_name($setRec, $i)."\t";

} 
while($rec = mysql_fetch_row($setRec))  {
  $rowLine = '';
  foreach($rec as $value)       {
   // if((!isset($value) || $value == "") ) {
 if($value =="" ) {
      $value = "\t";
    }   else  {
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '"' . $value . '"' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
}
  $setData = str_replace("\r", "", $setData);
if ($setData == "") {
  $setData = "\nno matching records found\n";
}

$setCounter = mysql_num_fields($setRec);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$setExcelName."_Reoprt.xlsx");
header("Pragma: no-cache");
header("Expires: 0");
echo ucwords($setMainHeader)."\n".$setData."\n"; 
?>