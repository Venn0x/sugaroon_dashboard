<?php

define('OAUTH2_CLIENT_ID', '771110685182001202');
define('OAUTH2_CLIENT_SECRET', 'jAfsdfsg54t34wlL3sKNpoq');

if(!defined('wcode.ro'))

	die('Be right back.');

class Config {

	private static $instance;

	private static $_perPage = 18;

	public static $g_con;

	public static $pdo;

	public static $htmlpurifier;

	public static $_url = array();

	public static $_ALLOW_THEME_CHANGE = 0;

	public static $_PAGE_URL = 'http://localhost/bot_dashboard/ ';



	public static $_BOTSERVER_URL = 'http://localhost';

	public static $_BOTSERVER_PORT = 5348;

	public static $_BOTSERVER_TOKEN = 'rB9I0kaM599vstRfwHFoHk7nb0q2UOtqlaCyO7VqqHOt8SV4PPf0m9mdmYDV';


	private function __construct() {

		self::_getUrl();

	}


	public static function init()

	{

		if (is_null(self::$instance))

		{

			self::$instance = new self();

		}

		return self::$instance;

	}
	

	private static function _getUrl() {

		$url = isset($_GET['page']) ? $_GET['page'] : null;

        $url = rtrim($url, '/');

        $url = filter_var($url, FILTER_SANITIZE_URL);

        self::$_url = explode('/', $url);

	}

	

	public static function getContent() {

		require_once 'assets/vendor/library/HTMLPurifier.auto.php';

		include_once 'inc/header.inc.php';

		if(self::$_url[0] === 'signature') { include 'inc/pages/' . self::$_url[0] . '.p.php'; return; }

		if(isset(self::$_url[0]) && !strlen(self::$_url[0]))

			include_once 'inc/pages/index.p.php';

		else if(file_exists('inc/pages/' . self::$_url[0] . '.p.php')) 

			include 'inc/pages/' . self::$_url[0] . '.p.php';

		else

			include_once 'inc/pages/index.p.php'; 

		include_once 'inc/footer.inc.php';

	}

	public static $mysqli;

	

	public static function xss($data)

	{

		// Fix &entity\n;

		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);

		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);

		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);

		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');



		// Remove any attribute starting with "on" or xmlns

		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);



		// Remove javascript: and vbscript: protocols

		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);

		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);

		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);



		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>

		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);

		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);



		// Remove namespaced elements (we do not need them)

		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);



		do

		{

		    // Remove really unwanted tags

		    $old_data = $data;

		    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);

		}

		while ($old_data !== $data);



		// we are done...

		return $data;

	}

	

	public static function clean($text = null) {

		if (strpos($text, 'script') !== false) return '<i><small>Unknown</small></i>';

		if (strpos($text, 'meta') !== false) return '<i><small>Unknown</small></i>';

		if (strpos($text, 'document.location') !== false) return '<i><small>Unknown</small></i>';

		if (strpos($text, 'olteanu') !== false) return '<i><small>Unknown</small></i>';

		strtr ($text, array ('olteanuadv' => '<replacement>'));

		$regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';

		return preg_replace_callback($regex, function ($matches) {

			return '<a target="_blank" href="'.$matches[0].'">'.$matches[0].'</a>';

		}, $text);

	}


	public static function getPage() {

		return isset(self::$_url[2]) ? self::$_url[2] : 1;

	}


	public static function isActive($active) {

		if(is_array($active)) {

			foreach($active as $ac) {

				if($ac === self::$_url[0]) return ' class="active"';

			}

			return;

		} else return self::$_url[0] === $active ? ' class="active"' : false;

	}


	public static function showSN() {

		if(!isset($_SESSION['staticnotif']) || !strlen($_SESSION['staticnotif'])) $last_notif = '';

		else {

			$last_notif = $_SESSION['staticnotif'];

			$_SESSION['staticnotif'] = '';

			unset($_SESSION['staticnotif']);

		}

		return $last_notif;

	}

	public static function createSN($type, $message) {

		$text = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close">

				<span aria-hidden="true">×</span>

			</button><i class="fa fa-info-circle"></i> '.$message.'

		</div>';

		$_SESSION['staticnotif'] = $text;

	}

	public static function csSN($type, $message, $dismiss = true) {

		$text = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close">

				'.($dismiss ? '<span aria-hidden="true">×</span>' : '').'

			</button><i class="fa fa-info-circle"></i> '.$message.'

		</div>';

		return $text;

	}

	

	public static function gotoPage($page,$delay = false,$type = false,$message = false) {

		if(strlen($type) > 2) {

			$text = '<div class="alert alert-'.$type.' alert-dismissible" role="alert">

				<button type="button" class="close" data-dismiss="alert" aria-label="Close">

					<span aria-hidden="true">×</span>

				</button><i class="fa fa-info-circle"></i> '.$message.'

			</div>';

			$_SESSION['staticnotif'] = $text;

		}

		if($delay != false && $delay > 0) {

			echo '<meta http-equiv="refresh" content="' . $delay . ';' . self::$_PAGE_URL . $page  . '">';

			return;

		}

		header('Location: ' . self::$_PAGE_URL . $page);

	}

	

	public static function timeFuture($time_ago)

	{

		// $time_ago = strtotime($time_ago);

		$cur_time   = time();

		$time_elapsed   = $time_ago - $cur_time;

		$days       = round($time_elapsed / 86400 );



		if($days > -1){

			return "in $days days";

		 }else {

			return "$days days ago";

		}

	}

	public static function timeAgo($time_ago, $icon = true)

	{

		$time_ago = strtotime($time_ago);

		$cur_time   = time();

		$time_elapsed   = $cur_time - $time_ago;

		$seconds    = $time_elapsed ;

		$minutes    = round($time_elapsed / 60 );

		$hours      = round($time_elapsed / 3600);

		$days       = round($time_elapsed / 86400 );

		$weeks      = round($time_elapsed / 604800);

		$months     = round($time_elapsed / 2600640 );

		$years      = round($time_elapsed / 31207680 );

		// Seconds

		if($seconds <= 60){

			return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." just now";

		}

		//Minutes

		else if($minutes <=60){

			if($minutes==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." one minute ago";

			}

			else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $minutes minutes ago";

			}

		}

		//Hours

		else if($hours <=24){

			if($hours==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." an hour ago";

			}else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $hours hours ago";

			}

		}

		//Days

		else if($days <= 7){

			if($days==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." yesterday";

			}else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $days days ago";

			}

		}

		//Weeks

		else if($weeks <= 4.3){

			if($weeks==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." a week ago";

			}else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $weeks weeks ago";

			}

		}

		//Months

		else if($months <=12){

			if($months==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." a month ago";

			}else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $months months ago";

			}

		}

		//Years

		else{

			if($years==1){

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." one year ago";

			}else{

				return "".($icon ? "<i class='fa fa-clock-o'></i>" : "")." $years years ago";

			}

		}

	}

	public static function generateRandomString($length = 10) {

		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$charactersLength = strlen($characters);

		$randomString = '';

		for ($i = 0; $i < $length; $i++) {

			$randomString .= $characters[rand(0, $charactersLength - 1)];

		}

		return $randomString;

	}

	public static function isLogged() {

		if(!isset($_SESSION['discord_logged_as'])) return 0;

		else return 1;

	}

	

	

}

?>
