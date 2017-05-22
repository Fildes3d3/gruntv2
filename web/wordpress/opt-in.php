<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');

require_once('./wp-load.php');
//ini_set('display_errors','On');


set_error_handler('rem_error_handler');
$image_path = '/wp-content/plugins/rm-video/static/images/';
if(!defined('DIR_FS_INC')){
	define('DIR_FS_INC',dirname(__FILE__).'/wp-content/plugins/rm-video/');
}
if(!function_exists('deg')){
	function deg($ob){
		echo "<pre>";
		echo print_r($ob,true);
		echo "</pre>";
		
	}
}
//if(!function_exists('recaptcha_get_html')){
//	//require_once('recaptchalib.php');
//}
function get_valid_email( $email ) {
	$regex = '/^([*+!.&#$¦\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
	return preg_match($regex, trim($email), $matches);
}

function rem_error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
	switch($errno){
		case E_ERROR:
			$errstr = 'E_ERROR';
			break;
		case E_NOTICE:
			$errstr = 'E_NOTICE';
			break;
		case E_WARNING:
			$errstr = 'E_WARNING';
			break;
		case E_PARSE:
			$errstr = 'E_PARSE';
			break;
		case E_NOTICE:
			$errstr = 'E_NOTICE';
			break;
		case E_CORE_ERROR:
			$errstr = 'E_CORE_ERROR';
			break;
		case E_CORE_WARNING:
			$errstr = 'E_CORE_WARNING';
			break;
		case E_COMPILE_ERROR:
			$errstr = 'E_COMPILE_ERROR';
			break;
		case E_COMPILE_WARNING:
			$errstr = 'E_COMPILE_WARNING';
			break;
		case E_USER_ERROR:
			$errstr = 'E_USER_ERROR';
			break;
		case E_USER_WARNING:
			$errstr = 'E_USER_WARNING';
			break;
		case E_USER_NOTICE:
			$errstr = 'E_USER_NOTICE';
			break;
		case E_ALL:
			$errstr = 'E_ALL';
			break;
	}
	if($errno!= E_NOTICE ){
		
		$error_str	= $errfile . ':' . $errline . ' (' . $errno . '): ' . $errstr . "\n";
		$error_str 	.= "TRACE BEGIN:\n" . print_r(debug_backtrace(), true) . "\nEND";

		//deg($error_str);
		
	}
}

//deg($_POST);

//echo 1;
require_once(DIR_FS_INC.'email.center.class.php');

$email_center = new WP_RM_Email_Center();
$email_center->getSubscriptionInfo(htmlentities($_REQUEST['hash']));
if($_SERVER['SERVER_NAME']=='50.57.37.33'){
	$publickey = '6LeVWtYSAAAAAHu1oZPH-Aj_H8ctvqhsPQJEijDZ';
	$privatekey = "6LeVWtYSAAAAAP9rxm5qu6H7aAI9RvpgJpaJrc4p";
}else{
	$publickey = '6LeVR9cSAAAAAF4Xyq7O3DR9Ys-FR6jLOzbH81rn';
	$privatekey = "6LeVR9cSAAAAAKns5oOjbp3IfjHQLusWUto_Us5N";
}
//var_dump($email_center->validForm());
$error = false;
?>
<html>
	<head>
		<link rel="stylesheet" href="/opt-in.css" type="text/css" media="screen"/>
	</head>	
	<body><center>
		<div class="mainbg">
			<div class="inside">
				<div class="postboxinternal" style="width:100%;padding-left:20px;padding-right:20px;">
			<?php 
			//try{
			//echo var_dump(isset($_REQUEST['activate']));
			//var_dump($email_center->validForm());
				if(isset($_REQUEST['activate'])){
					if($email_center->activateSubscription(htmlentities($_REQUEST['activate']))){
						?>
						<center>
							<h1> Subscription Activated </h1>
							<h3>You have subscribed to <?php echo $email_center->blog_info->meta_value;?></h3>
						</center>
						<?php
					}else{
						?>
						<center><h1> Error </h1>
						<h3>Invalid request. code: 10001</h3></center>
						<?php
					}
				}elseif($email_center->validForm()){
					//echo 'sssss';
					if(isset($_POST['submit'])){
						
						
						/*$resp = recaptcha_check_answer ($privatekey,
								$_SERVER["REMOTE_ADDR"],
								$_POST["recaptcha_challenge_field"],
								$_POST["recaptcha_response_field"]);

						if (!$resp->is_valid) {
							// What happens when the CAPTCHA was entered incorrectly
							$error = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . 	"(reCAPTCHA said: " . $resp->error . ")";
						} else {
							// Your code here to handle a successful verification
						}*/
						if(!get_valid_email($_REQUEST['email'])) {
							$error = 'Invalid Email';
						}
						//echo $error;
						if(!$error){
							//echo ' no errors ';
							$activationkey = $email_center->addNewSubscriptionFunjustion();
							//echo '<br> $activationkey '. var_dump($activationkey);
							if($activationkey!=''){
								$link = '/opt-in.php?activate='.$activationkey;
								$subject = "Confirm your subscription";
								$headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
								$headers.= 'From: Chasing Excellence Blog <info@chasingexcellenceblog.com>' . "\r\n";
							 	$html = "
								<html>
									<head>
										<style>
											span.red{}
											span.bold{font-weight:bold;}
										</style>
									</head>
									<body>
										Please confirm your subscription to <span class='red'>the</span> <span class='bold'>".$email_center->blog_info->meta_value."</span> blog by clicking on the link below<br><br>
										<a href='http://".$_SERVER['SERVER_NAME'].$link."'>Confirm subscription</a> <br><br>
										<span class='red'>Or copy</span> and paste this link in a new browser window/tab: <br><br>
										http://".$_SERVER['SERVER_NAME'].$link."<br><br>
										<span class='red'>Thank You!</span><br><br>
										 The Chasing Excellence Blo<br>
									</body>
								</html>
		";
								wp_mail($_REQUEST['email'],$subject,$html,$headers);
							//deg($email_center);
							//if(isset($email_center->user_info)){
								$subject = "New subscription on " . $email_center->blog_info->meta_value . ' blog';
								$email = @$_REQUEST['email'];
								$first_name = @$_REQUEST['first_name'];
								$last_name = @$_REQUEST['last_name'];
								$phone = @$_REQUEST['phone'];
								$html = "
								<html>
								<head></head>
								<body>
								User " . $first_name . " ". $last_name ." - $email - $phone <br>
								has just subscribed to your blog <br><br><hr>
								The National Real Estate Post
								</body>
								</html
								";
								wp_mail($email_center->user_info->user_email,$subject,$html,$headers);
							//}
								?>
								<center>
								<h1> Thank you for your subscription </h1>
								<h4>You will receive an email from  Chasing Excellence to confirm your subscription to thie blog. <br>If you don't see it, please check your spam filter.
								</h4>
								</center>
								<?php
								die;
							}else{
								 $error = $email_center->error;
								//if(strpos($error,'Duplicate entry') === 0) {
								//	$error = 'User already subscribed';
								//}
							}
						
							
						}
					}
?>
					<h2 style="text-align:center;">You are subscribing to:  <b><?php echo $email_center->blog_info->meta_value;?></b> </h2>
	
				   	<form name="fomul" action="" method="POST" >
				   		<input type="hidden" name="hash" value="<?php echo htmlentities($_REQUEST['hash']); ?>" />
					   	<table width="100%" >
					   	
					   	<?php if($error){?>
					   	<tr>
					   		<td colspan="3" align="center" style="color:red;"> <?php echo $error;?></td>
					   	</tr>
					   	<?php }else{ ?>
					   	
					   	<?php } ?>
					   	<tr>
					   		<td width="40%" align="right">First Name</td>
					   		<td width="5%"> &nbsp; </td>
					   		<td width="55%"><input type="text" name="first_name" value="" /></td>
					   	</tr>
					   	<tr>
					   		<td align="right">Last Name</td>
					   		<td>  </td>
					   		<td><input type="text" name="last_name" value="" /></td>
					   	</tr>
					   	<tr>
					   		<td align="right">Email </td>
					   		<td>  </td>
					   		<td><input type="text" name="email" value="" /><span class="required"><small>(required)</small></span></td>
					   	</tr>
					   	<tr>
					   		<td align="right">Phone</td>
					   		<td>  </td>
					   		<td><input type="text" name="phone" value="" /></td>
					   	</tr>
					   	<tr>
					   		<td></td>
					   		<td>  </td>
					   		<td><small> <br></small><input type="submit" name="submit" value="Opt-In" /><br><small><br></small></td>
					   	</tr>
					   	<tr>
					   		<td colspan="3"><small> After submitting your subscription request you will receive an email confirmation link.  If you don't see this email please check your junk or spam folders and mark it as a valid email to insure you receive future updates from <?php echo $email_center->blog_info->meta_value;?>.  Thank You!</small></td>
					   	</tr>
					   	</table>
					</form>
			<?php }else{
			?>
				<center><h1> Error </h1>
				<h3>Invalid form request</h3></center>
			<?php }
			
?>
				</div>
			</div>				
		</div>
		</center>	
	</body>	
</html>

