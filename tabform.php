<?php
include("configuration.php");

$obj = new JConfig();
$host = $obj->host;
$dbUser = $obj->user;
$dbPwd = $obj->password;
$dbName = $obj->db;

$link = mysql_connect($host, $dbUser, $dbPwd);
@mysql_select_db($dbName,$link); 
?>
<script type="text/javascript" src="ckeditor/ckeditor.js">
  
</script>
<script src="validatejs/jquery-1.9.1.min.js">
  
</script><script src="validatejs/jquery.validate.min.js">
  
</script><script>  
     $(function() {  
          $("#myform").validate({  
            rules: {        
              "tabslevel": 
              { 
                required:true   
                             },
                "description":{ 
                    required:true  
                  } 
                   }, 
                   messages:{
                   "tabslevel":"please enter the Tab name", 
                   "description":"please enter the Description", 
                      } 
                     });   
                     });  
       </script> 
                       <style> 
                          .error{ font-weight: normal; color: red; font-size: 12px; }</style>

<style>
.uf_country_form_wrap .form-group { margin-bottom:20px; }
 .uf_country_form_wrap label {font-family: Arial;
    width: auto;
    display: block;
    margin: 10px 0px;
    text-transform: capitalize;
    font-size: 14px;
    font-weight: 500;}
  .uf_country_form_wrap .form-control, .uf_country_form_wrap .form-textarea {    height: 30px;
    padding: 0 10px!important;
    line-height: 30px;
    width: 50%;}  
    .uf_country_form_wrap .form-textarea {height:90px;}
    .btn-success {
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
    background-color: #409740;
    background-image: -moz-linear-gradient(top,#46a546,#378137);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#46a546),to(#378137));
    background-image: -webkit-linear-gradient(top,#46a546,#378137);
    background-image: -o-linear-gradient(top,#46a546,#378137);
    background-image: linear-gradient(to bottom,#46a546,#378137);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff46a546', endColorstr='#ff368136', GradientType=0);
    border-color: #378137 #378137 #204b20;
    filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
    border: none;
    padding: 8px 15px;
    float: right;
    cursor: pointer;
    margin-right: 5px;
}
 .btn-success:hover{ color: #fff; background-color: #378137; }
</style>


<?php 
if(!empty($_REQUEST['comp_id']))
{
 $company_id=$_REQUEST['comp_id']; 
}
else
{
  $company_id="";
}



if(!empty($_REQUEST['list_id']))
{
  //$data=array();
 $list_id=$_REQUEST['list_id']; 
 $rsd=mysql_query("select * from  jos_company_tab where id='$list_id'") ;
 while ($productsDtls = mysql_fetch_array($rsd))
 {  
  $data=$productsDtls;
 }
 
 
}
/*new code for file path */

$companies_id=$_REQUEST['comp_id'];
if($companies_id== "")
{
 $companies_id=$data['comp_id'];
}
$companies_id;

$compdetails=mysql_query("select mt.link_id,mt.link_name,cf.value from jos_mt_links as mt,jos_mt_cfvalues as cf  where mt.link_id=cf.link_id and mt.link_id='$companies_id' and cf.cf_id='30'");
while($compdetail=mysql_fetch_array($compdetails))
{
  $compsdata[]=$compdetail;
}

 $filetype=strtolower($compsdata[0]['value']);
 //$copnamynames=str_replace(' ','_',strtolower($compsdata[0]['link_name']));
 /*new code for fetching dynamic folder name from database */
      $sql="select folder_name from jos_folder where link_id='$companies_id'";
      $folders = mysql_query($sql);
      $folderarray=mysql_fetch_object($folders);
      $copnamynames=$folderarray->folder_name;
 /* code ends here */
 if($filetype =="supplier")
 {
  $filetype="suppliers";
 }
 if($filetype =="member")
 {
  $filetype="members";
 }


 
  $newPath = $filetype."/".$copnamynames;
/* code ends here for file path */

 ?>
<?php if(!empty($data)) { 

  ?>
<form action="#" class="uf_country_form_wrap" id="myform">
  <div class="form-group">
    <label>Tab Label:</label>
    <input type="text" class="form-control" id="tab_level" name="tabslevel" value="<?php echo $data['label'];?>">
  </div>
  <div class="form-group">
    <label>Description:</label>
    <textarea name="description" class="ckeditor"><?php  echo $data['description']; ?></textarea>
  </div>
  <!--<div class="form-group">
    <label>Url:</label>
    <input type="text" class="form-control" id="url" name="url" value="<?php //echo $data['url']; ?>">
  </div>-->
  <input type="hidden" name="tab_id" value="<?php echo $data['id']; ?>">
  <input type="submit" name="upd" class="btn btn-success" value="Update"/>
</form>
<?php }else{ ?>
<form action="#" class="uf_country_form_wrap" id="myform">
  <div class="form-group">
    <label>Tab Label:</label>
    <input type="text" class="form-control" id="tab_level" name="tabslevel">
  </div>
  <div class="form-group">
    <label>Description:</label>
    <textarea name="description" class="ckeditor"></textarea>
  </div>
  <!--<div class="form-group">
    <label>Url:</label>
    <input type="text" class="form-control" id="url" name="url">
  </div>-->
  <input type="hidden" name="company_ids" value="<?php echo $company_id;?>">
  <input type="submit" name="tab" class="btn btn-success" value="Submit"/>
</form>

<?php } ?>






<?php
if(isset($_REQUEST['tab']))
{
   $company_id=$_REQUEST['company_ids'];
   $label=$_REQUEST['tabslevel'];
  $decription=$_REQUEST['description'];
  $url=$_REQUEST['url'];
  

$saved=mysql_query("INSERT INTO jos_company_tab (id, comp_id, label,description,url) VALUES ('', '$company_id', '$label', '$decription', '$url') ") 
    or die(mysql_error()); 
    if($saved)
    {
  {?>
      <script>
      parent.$.fancybox.close();
      
      </script>

    <?php }
    }
    else
    {
      echo "Tab not saved";
    }



}

if(isset($_REQUEST['upd']))
{
  $tab_id=$_REQUEST['tab_id'];
   $label=$_REQUEST['tabslevel'];
  $decription=$_REQUEST['description'];
  $url=$_REQUEST['url'];
  $rec=mysql_query(" UPDATE jos_company_tab set label='$label',description='$decription',url='$url' where id='$tab_id' ") 
    or die(mysql_error());
    if($rec)
    {?>
      <script>
      parent.$.fancybox.close();
      
      </script>

    <?php }
    else
    {
      echo "Tab Not Updated";
    }

}
?>
<script>
CKEDITOR.replace( 'description', {
    //filebrowserBrowseUrl: '/uk_farmers/ckfinder/ckfinder.html',
    filebrowserBrowseUrl: '/ckfinder/ckfinder.html?id=<?php echo $newPath; ?>/',
    filebrowserUploadUrl: '/uploader/upload.php?type=Files&dir=<?php echo $newPath; ?>'
});
</script>
<!--<script>
   CKEDITOR.replace( 'description',
{
  filebrowserBrowseUrl : '/uk_farmers/ckfinder/ckfinder.html?id=testdir',
  filebrowserImageBrowseUrl : '/uk_farmers/ckfinder/ckfinder.html?type=Images',
  filebrowserFlashBrowseUrl : '/uk_farmers/ckfinder/ckfinder.html?type=Flash',
  filebrowserUploadUrl : '/uk_farmers/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
  filebrowserImageUploadUrl : '/uk_farmers/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
  filebrowserFlashUploadUrl : '/uk_farmers/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
  filebrowserWindowWidth : '1000',
  filebrowserWindowHeight : '700'
});
  </script>