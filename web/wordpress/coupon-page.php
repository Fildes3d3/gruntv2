<?php

error_reporting(E_ALL);
if($_SERVER['SERVER_NAME']=='50.57.37.33' || $_SERVER['SERVER_NAME']=='groupfive.ro' ){
	require_once('./wp-load.php');
}else{
	//ob_start();
	//echo '1';
	require_once('./wp-config.php');
	define( 'WPINC', 'wp-includes' );
	//echo '1';
	// Include files required for initialization.
	require( ABSPATH . WPINC . '/load.php' );
	require_wp_db();
	//ob_end_clean();
	global $wpdb;
}

$image_path = '/wp-content/plugins/rm-video/static/images/';
$coupon_page_image_path = '/wp-content/plugins/rm-video/couponpageimages/';
$hash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : '';
$couponhash = isset($_REQUEST['coupon']) ? $_REQUEST['coupon'] : '';
//echo $blogger->b2b_center->showCoupon($hash);
if(!defined('DIR_FS_INC')){
	define('DIR_FS_INC',dirname(__FILE__).'/wp-content/plugins/rm-video/');
}

//$user = wp_get_current_user();
//require_once(dirname(__FILE__).'/wp-content/plugins/rm-video/lib/wpfw-autoload.class.php');

//WP_RM_Video_WPFW_Autoload::register(dirname(__FILE__).'/wp-content/plugins/rm-video');

//$main = WP_RM_Video_Main::GetInstance();
//echo '1';

require_once(DIR_FS_INC.'b2b.center.class.php');
//print_r(wp_get_current_user());
//echo '1';
$b2b = new WP_RM_B2B_Center();
//echo $b2b->user_id;
$coupon = $b2b->loadCoupon($couponhash);
//echo "<pre>".print_r($coupon,true)."</pre>".$b2b->user_id;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $coupon->title;?></title>
<meta name="description" content="<?php echo $coupon->description;?>" >
<style>
img{border:0px;}
body{background-color: #99FFFF;
    background-image: url("/wp-content/themes/chrischild/assets/css/images/bg.png");
    background-repeat: repeat-x;
    color: #555555;
}
.mainbg{
	width:	660px;
    margin-top:30px;
    padding-left:12px;
    padding-right:12px; 
    padding-top:15px;
    padding-bottom:20px;
 	background-color:#ffffff;
}
.headerimg{text-align:left;}
div.postboxinternal{
 	background-color:#ffffff;
    border-color: #b4b3b3;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0px 0px 5px #b4b3b3;
    line-height: 1;
    margin-top: 7px;
    padding: 3px;
}
span.name{
 	font-size:24px;
 	color:#00396c;
}

</style>
</head>
<body>
	<center>
		
		<div class="mainbg">
			<div class="headerimg"><img src="<?php echo $image_path;?>featured_coupon.jpg" /></div>
			<div><img src="<?php echo $image_path;?>b2b_sep1.jpg" /></div>
			<div>
				<center>
					<img src="/coupon.php?hash=<?php echo $_GET['coupon']; ?>" />
					<br><?php if(!isset($_REQUEST['print'])){?>
					<div class="b2b_cp_shareimgs">
						<a href="#" onClick="javascript:window.print();"><img src="<?php echo $image_path?>rmcb_print.jpg" /></a>
						<a href="/coupon.php?download&hash=<?php echo $_GET['coupon']; ?>"><img src="<?php echo $image_path?>rmcb_dw.jpg" /></a>
						<a href="mailto:?body=Check This Coupon&body=<?php echo urlencode('http://'. $_SERVER['SERVER_NAME'].'/coupon-page.php?coupon='. $coupon->hash );?>&subject=<?php echo $coupon->title;?>"><img src="<?php echo $image_path?>rmcb_email.jpg" /></a>
						<a href="http://twitter.com/home?status=<?php echo urlencode('Check out this coupon <a href="http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI'] .'" >here</a>')?>" target="_blank" ><img src="<?php echo $image_path?>rmcb_tw.jpg" /></a>
						<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://'.$_SERVER['SERVER_NAME'].'/coupon-page.php?coupon='. $coupon->hash );?>" target="_blank"><img src="<?php echo $image_path?>rmcb_fb.jpg" /></a>
						<!-- <a href="http://www.facebook.com/share.php?p[summary]=<?php echo urlencode('Featured Coupon');?>&p[images][0]=<?php echo urlencode( 'http://'.$_SERVER['SERVER_NAME'].'/coupon.php?hash='. $_GET['coupon'] );?>&p[title]=<?php echo urlencode('Check this coupon');?>&p[url]=<?php echo urlencode('http://'.$_SERVER['SERVER_ADDR'].''.$_SERVER['REQUEST_URI'])?>" target="_blank"><img src="<?php echo $image_path?>rmcb_fb.jpg" /></a> -->
					</div>
					<?php } ?>
				</center>
			</div>
			<div><img src="<?php echo $image_path;?>b2b_sep2.jpg" /></div>
			<div></div>
			<table >
			<tr>
				<td colspan="3" align="center">
					
					<img src="<?php echo $image_path;?>b2b_complimentsof.jpg" />
				</td>
			</tr>
			
			<tr>
				<td align="center"> 
					<div style="width:175px;height:176px;"><img src="<?php echo $coupon_page_image_path. $b2b->user_id;?>" /></div><br>
					
				</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td align="left"> 
					<span class="name"><?php echo $b2b->page->display_name;?></span><br>
					<?php echo $b2b->page->company_name;?><br>
					<?php echo $b2b->page->phone;?><br>
					<?php echo $b2b->page->email;?><br>
					License Number: #<?php echo $b2b->page->licence;?><br>
					<br>
					<a href="/mycoupons.php?hash=<?php echo base64_encode($b2b->user_id).'&coupon='.$_GET['coupon']; ?>" ><img src="<?php echo $image_path?>rm_seeallmycoupons.jpg" /></a>
					<br>
					<a href="<?php echo $b2b->page->subscribe_link; ?>" target="_blank"><img src="<?php echo $image_path?>but_subscribebut.jpg" /></a>
				</td>
			</tr>
			</table>
		</div>
	</center>
</body>
</html>
<?php if(isset($_REQUEST['print'])){?>
<script>
function sleep(milliseconds) {
    var now = new Date();
    var exitTime = now.getTime() + milliseconds;
    while (true) {
        now = new Date();
        if (now.getTime() > exitTime)
        return;
    }
}

sleep(2000);
window.print();
var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
if(!is_chrome){
	window.close();
}
</script>
<?php }?>