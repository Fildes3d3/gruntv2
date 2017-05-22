<?php 
require_once('./wp-load.php');
$image_path = '/wp-content/plugins/rm-video/static/images/';
$coupon_page_image_path = '/wp-content/plugins/rm-video/couponpageimages/';
$hash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : '';
$user_id = base64_decode($hash);
$coupon = isset($_REQUEST['coupon']) ? $_REQUEST['coupon'] : '';
//echo $blogger->b2b_center->showCoupon($hash);
if(!defined('DIR_FS_INC')){
	define('DIR_FS_INC',dirname(__FILE__).'/wp-content/plugins/rm-video/');
}
error_reporting(E_ALL);
//$user = wp_get_current_user();
//require_once(dirname(__FILE__).'/wp-content/plugins/rm-video/lib/wpfw-autoload.class.php');

//WP_RM_Video_WPFW_Autoload::register(dirname(__FILE__).'/wp-content/plugins/rm-video');

//$main = WP_RM_Video_Main::GetInstance();


require_once(DIR_FS_INC.'b2b.center.class.php');
//print_r(wp_get_current_user());

$b2b = new WP_RM_B2B_Center('',$user_id);
if(isset($_POST['search'])){
	$couponlist =$b2b->getSearchCoupons($_POST['searchCriteria'], $_POST['categ']);
}elseif(isset($_GET['char'])){
	$couponlist = $b2b->getCouponsByChar($_GET['char'][0]);
}else{
	$couponlist = $b2b->getCouponsRandom();
}
$categs = $b2b->listCategories();
?><html>
<head>
<style>
	img{border:0px;}
	a{text-decoration:none;}
	div.wrap{
	width:800px;
	}
body{background-color: #99FFFF;
    background-image: url("/wp-content/themes/chrischild/assets/css/images/bg.png");
    background-repeat: repeat-x;
    color: #555555;
}
.mainbg{
	width:	750px;
    margin-top:30px;
    padding-left:12px;
    padding-right:12px; 
    padding-top:15px;
    padding-bottom:20px;
 	background-color:#ffffff;
}
.theader{
	height:30px;
	background-color:#00396c;
	color:#ffffff;
	padding:5px;
}
 .tfooter{
 height:60px;
 background-color:#1b6fba;
 color:#ffffff;
 }
 .tfooter img {margin-left:10px; margin-right:10px;}
 div.inside table{
  color:#707070;
 }
 .mainbg{
 	background-color:#ffffff;
 }
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
.verticalsharebg{
	width:80px;
	height:215px;
	text-align:left;
	padding-left:10px;
	background-image: url("<?php echo $image_path;?>verticalsharebg.jpg");
}
.verticalsharebg span{ top:7px;vertical-align:middle;position:relative;float:right;margin-right:10px;clear:both;}
</style>
<script src="/jquery.min.js" type="text/javascript"></script>
</head>
<body>
	<center>
	
		<div class="mainbg">
  <?php
  $srcpath = '/wp-content/plugins/rm-video/static/images/';
  $location = 'http://'.$_SERVER['SERVER_NAME'] . '/mycoupons.php?hash='.$hash;
	
  
 	
 	
$alfabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	?> 	 

  <div >
   
    <div class="inside">
    	
    	<div class="">
    		<table width="100%">
		   		<tr>
		   			<td align="center" width="40%">
		   				<img src="<?php echo $coupon_page_image_path. $b2b->user_id?>" />
		   			</td>
		   			<td align="left" width="60%">
		   			 	<span class="name"><?php echo $b2b->page->page_name;?></span><br>
						
						<?php echo $b2b->page->company_name;?><br>
						<?php echo $b2b->page->phone;?><br>
						<?php echo $b2b->page->email;?><br>
						License Number: #<?php echo $b2b->page->licence;?><br>
						<br>
						<a href="<?php echo $b2b->page->subscribe_link; ?>" target="_blank"><img src="<?php echo $image_path?>but_subscribebut.jpg" /></a>
		   			</td>
		   		</tr>
	   		</table>
		   	<div class="postboxinternal" style="width:90%">
		   	<form name="fomul" action="" method="POST" >
			   	<table width="100%" >
			   	<tr class="theader">
			   		<td colspan="5"> Coupon Finder </td>
			   	</tr>
			   	<tr>
			   		<td align="center" >
			   	Search Coupon (Title): </td>
			   		<td><input type="text" name="searchCriteria" value="<?php echo @$_REQUEST['searchCriteria']; ?>" />	   	
			   		</td>
			   		<td align="center" >
			   	
			   		Category:
			   		</td>
			   		<td>
			   		<select name="categ" >
			   			<option value="">Select ... </option>
			        <?php foreach($categs as $cat){?>
			          <option  value="<?php echo $cat->cat_id;?>" > <?php echo $cat->name;?> </option>         							
			           						
			        <?php } ?>
			     	</select>
			    
			     	</td>
			     	<td align="center" >
			   	<input type="submit" name="search" value="Search Coupon" />
			   		</td>
			   	</tr>
			   	<tr>
			   		<td colspan="5" align="center">
			   			Search By First Letter:&nbsp;&nbsp;&nbsp;  
			   			<?php
			   			for($i=0;$i<strlen($alfabet);$i++){ 
			   				echo '&nbsp;<a href="'. $location.'&tool=select&char='.$alfabet[$i].'"><b>'.$alfabet[$i].'</b></a>&nbsp;';
			   			} 
			   			?>
			   		</td>
			   	</tr>
			   	</table>
			   	</form>
		   	</div>
	   	
	   	 	<div><img src="<?php echo $image_path;?>b2b_sep3.jpg" /></div>             
           
            <?php foreach($couponlist as $coupon){ ?>
            <center>
             <table  cellpadding="0" cellspacing="0" > 
            <tr style="height:250px;">             
              <td style=""><img src="/coupon.php?hash=<?php echo $coupon->hash; ?>&preview=1" /></td>
             
              <td> 
              		<div class="verticalsharebg" title="<?php echo $coupon->hash; ?>">
	              		<div><a class="getclick" title="pr" href="/coupon-page.php?print&coupon=<?php echo $coupon->hash; ?>" target="_blank"><img src="<?php echo $image_path?>rmcb_print.jpg" /></a>
	              		<span> &nbsp;(<?php echo (int)$coupon->print;?>)</span>
	              		</div>
						<div><a class="getclick" title="dl" href="/coupon.php?download&hash=<?php echo $coupon->hash; ?>"><img src="<?php echo $image_path?>rmcb_dw.jpg" /></a>
						<span> &nbsp;(<?php echo (int)$coupon->download;?>)</span>
						</div>
						<div><a class="getclick" title="mail" href="mailto:?body=Check This Coupon&body=<?php echo urlencode('http://'. $_SERVER['SERVER_NAME'].'/coupon-page.php?coupon='. $coupon->hash );?>&subject=<?php echo $coupon->title;?>"><img src="<?php echo $image_path?>rmcb_email.jpg" /></a>
						<span> &nbsp;(<?php echo (int)$coupon->email;?>)</span>
						</div>
						<div><a class="getclick" title="fb" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode('http://'.$_SERVER['SERVER_NAME'].'/coupon-page.php?coupon='. $coupon->hash )?>" target="_blank"><img src="<?php echo $image_path?>rmcb_fb.jpg" /></a>
						<span> &nbsp;(<?php echo (int)$coupon->facebook;?>)</span>
						</div>
						<div><a class="getclick" title="tw" href="http://twitter.com/home?status=<?php echo urlencode('Check out this coupon <a href="http://'.$_SERVER['SERVER_NAME'].'/coupon.php?download&hash='. $coupon->hash.'" target="_blank">here</a>')?>" target="_blank" ><img src="<?php echo $image_path?>rmcb_tw.jpg" /></a>
						<span> &nbsp;(<?php echo (int)$coupon->twitter;?>)</span>
						</div>
					</div>
				</td>
            </tr>
            
          	</table>
          </center>
            <?php } ?>
           
          </div>
          <br>
          <br>
    </div>
  </div>
</div>
<script type="text/javascript">
<!--
jQuery(document).ready(function(){

	jQuery('.getclick').click(function(){
		_coupon = jQuery(this).parent().attr('title');
		_click = jQuery(this).attr('title');
		
		arguments =  {
				'call'		: 'logb2bclicks',
				'hash': '<?php echo $_REQUEST['hash'];?>',
				'coupon' : _coupon,
				'click' : _click
				
		};
		 $.ajax({
			 type: 'POST',
			 url: '/b2b-tracking.php',
			 data: arguments,
			 success: function(data) {
			    ///alert(data);	//do nothing 
			 },                   
			 dataType: 'html'
		 });
		 return false;
	});
	
});
//-->
</script>





</center>
</body>
</html>