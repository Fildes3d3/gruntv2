<?php
error_reporting(E_ALL);
require_once('./wp-load.php');

$image_path = '/wp-content/plugins/rm-video/static/images/';
if(!defined('DIR_FS_INC')){
	define('DIR_FS_INC',dirname(__FILE__).'/wp-content/plugins/rm-video/');
}


if(!function_exists('recaptcha_get_html')){
	require_once(DIR_FS_INC .'recaptcha-php/recaptchalib.php');
}
function get_valid_email( $email ) {
	$regex = '/^([*+!.&#$¦\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
	return preg_match($regex, trim($email), $matches);
}

require_once(DIR_FS_INC.'email.center.class.php');

$email_center = new WP_RM_Email_Center();
if($_SERVER['SERVER_NAME']=='50.57.37.33'){
	$publickey = '6LeVWtYSAAAAAHu1oZPH-Aj_H8ctvqhsPQJEijDZ';
	$privatekey = "6LeVWtYSAAAAAP9rxm5qu6H7aAI9RvpgJpaJrc4p";
}else{
	$publickey = '6LeVR9cSAAAAAF4Xyq7O3DR9Ys-FR6jLOzbH81rn';
	$privatekey = "6LeVR9cSAAAAAKns5oOjbp3IfjHQLusWUto_Us5N";
}
?>
<html>
	<head>
		<link rel="stylesheet" href="/opt-in.css" type="text/css" media="screen"/>
	</head>	
	<body>
		<center>
		<div class="mainbg">
			<div class="inside">
				<div class="postboxinternal" style="width:100%">
			<?php 
				$error = '';
				if(isset($_POST['submit'])){ 
					$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
					
					if (!$resp->is_valid) {
						// What happens when the CAPTCHA was entered incorrectly
						$error = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . 	"(reCAPTCHA said: " . $resp->error . ")";
					} else {
						// Your code here to handle a successful verification
					}
					if($error ==''){
						if($email_center->deactivateSubscription(htmlentities($_REQUEST['hash']))){
							?>
							<center>
								<h1> Subscription Dectivated </h1>
							</center>
							<?php
						}else{
							?>
							<center><h1> Error </h1>
							<h3>Invalid request. code: 10001</h3></center>
							<?php
						} 
					}
				}
				if(!isset($_POST['submit']) || $error!=''){
?>
				   	<form name="fomul" action="" method="POST" >
				   		<input type="hidden" name="hash" value="<?php echo htmlentities($_REQUEST['hash']); ?>" />
					   	<table width="100%" >
					   	
					   	<?php if($error){?>
					   	<tr>
					   		<td colspan="3" align="center" style="color:red;"> <?php echo $error;?></td>
					   	</tr>
					   	<?php }else{ ?>
					   	<tr class="theader">
					   		<td colspan="3"> &nbsp;</td>
					   	</tr>
					   	<?php } ?>
					   	
					   	<tr>
					   		<td align="right">Email </td>
					   		<td>  </td>
					   		<td><input type="text" name="email" value="" /><span class="required"><small>(required)</small></span></td>
					   	</tr>
					  
					   	<tr>
					   		<td align="right" valign="top" >Validation</td>
					   		<td>  </td>
					   		<td> <?php  echo recaptcha_get_html($publickey);    ?>					   		
					   		</td>
					   	</tr>
					   	<tr>
					   		<td></td>
					   		<td>  </td>
					   		<td><br><input type="submit" name="submit" value="Opt-Out" /></td>
					   	</tr>
					   	</table>
					</form>
			
			
			<?php }?>
				</div>
			</div>				
		</div>
		</center>	
	</body>	
</html>

