<?php

//echo $_SERVER['SERVER_NAME'];
if($_SERVER['SERVER_NAME']=='rem.mytestproject.com' || $_SERVER['SERVER_NAME']=='groupfive.ro' ){
	require_once('./wp-load.php');
}else{
	ob_start();
	require_once('./wp-config.php');
	define( 'WPINC', 'wp-includes' );
	
	// Include files required for initialization.
	require( ABSPATH . WPINC . '/load.php' );
	require_wp_db();
	ob_end_clean();
	global $wpdb;
}

//echo "ddddd";
error_reporting(0);
//function deg($ob){
//	 echo "<pre>".print_r($ob,true)."</pre>";
//}
//require_once(dirname(__FILE__).'/wp-content/plugins/rm-video/lib/wpfw-autoload.class.php');

//WP_RM_Video_WPFW_Autoload::register(dirname(__FILE__).'/wp-content/plugins/rm-video');

//$main = WP_RM_Video_Main::GetInstance();


//$blogger = WP_RM_Video_Bloger::GetInstance();

$hash = isset($_REQUEST['hash']) ? $_REQUEST['hash'] : '';
//echo $blogger->b2b_center->showCoupon($hash);
if(!defined('DIR_FS_INC')){
	define('DIR_FS_INC',dirname(__FILE__).'/wp-content/plugins/rm-video/');
}
define('DIR_FS_CREATIVES',	DIR_FS_INC . 'creatives/');
define('DIR_FS_CACHE_ROOT',	DIR_FS_INC . 'cache/');
define('MIN_TRANSPARENCY', 	75);
define('V_CACHING',			true);
$_IMAGE_SIZES = array(
		'1'	=>	array('x' => 550, 'y' => 230),
		'2'	=>	array('x' => 800, 'y' => 300),
		'3'	=>	array('x' => 986, 'y' => 150)
);

// for Heatmaps 1
define('HEAT2_PL', 130);
define('HEAT2_PA', 100);
define('HEAT2_SF', 154);
define('HEAT2_SB', 154);
define('HEAT2_VT', 154);

// for Heatmaps 2,3,4
define('HEAT3_PL', 100);
define('HEAT3_PA', 100);
define('HEAT3_SF', 100);
define('HEAT3_SB', 100);
define('HEAT3_VT', 100);

/**
 * Available heatmap types
 */
$_IMAGE_TYPE = array('heat1', 'heat2', 'heat3', 'heat4');


// legend for heatmaps error codes
$_ERROR_LEGEND =array(
		NULL					=>0,
		'Invalid_time' 			=>1,
		'Invalid_image_size' 	=>2,
		'No_data_available' 	=>3,
		'Invalid_event_type'	=>4,
		'Invalid_ClientID'		=>5,
		'Invalid_view_type'		=>6,
		'Invalid_profileID'		=>7,
		'error_authentification'=>8
);

define('HEATMAP_FONT_PATH',		DIR_FS_CREATIVES . "tahoma.ttf");


define('MIN_RELEVANCE','30');



$cache_options = array(
		'cacheDir' 				=> DIR_FS_INC .'couponcachelite/',
		'lifeTime' 				=> 600,
		'memoryCachingLimit'	=> 10000,
		'automaticCleaningFactor'=> 50,
		'hashedDirectoryLevel' 	=> 3
);
/**
 * cache group for heatmaps
 */
define('HEATMAPS_CACHE_GROUP',	'heatmaps');
/**
 * cache group for services
 */
define('SERVICES_CACHE_GROUP',	'services');



require_once(DIR_FS_INC.'CacheLite/Lite.php');
require_once(DIR_FS_INC.'coupons/VVGraphControler.class.php');

$authentification = true;
$auth_error_code = 'Test error';
//echo '-------';die;
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("content-type: image/png");
$MapsControler  = new GraphControler();
$proxy 		    = new HttpProxy();
$proxy->init($MapsControler);
if(isset($_GET['download'])){
	$MapsControler->run($authentification,$auth_error_code,true);
}else{
	$MapsControler->run($authentification,$auth_error_code);
}
?>
