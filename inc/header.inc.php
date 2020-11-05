<?php

ob_start();

date_default_timezone_set('Europe/Bucharest');


// error_reporting(0);

if(!file_exists('inc/pages/' . self::$_url[0] . '.p.php') && strlen(self::$_url[0])) Config::gotoPage("");

$_SESSION['render'] = microtime(true);

$themeselected = 3;
/*
if(Config::isLogged()){
	$themeselected = Config::getData("accounts","paneltheme", Config::getUser());
}*/


function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

$apiURLGuilds = 'https://discord.com/api/users/@me/guilds';


?>

<!doctype html>

<html lang="en">

	

	<head>

        <meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    	<title>Sugaroon</title>

        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500is%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="<?php echo Config::$_PAGE_URL ;?>assets/vendor/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">

        <link rel="stylesheet" href="<?php echo Config::$_PAGE_URL ;?>assets/vendor/animate.css/animate.min.css">

        <link rel="stylesheet" href="<?php echo Config::$_PAGE_URL ;?>assets/vendor/jquery.scrollbar/jquery.scrollbar.css">

        <link rel="stylesheet" href="<?php echo Config::$_PAGE_URL ;?>assets/vendor/fullcalendar/dist/fullcalendar.min.css">

        <link href='https://fonts.googleapis.com/css?family=Lato:100italic' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.1.7/css/fork-awesome.min.css" integrity="sha256-gsmEoJAws/Kd3CjuOQzLie5Q3yshhvmo7YNtBG7aaEY=" crossorigin="anonymous">

        <link rel="stylesheet" href="<?php echo Config::$_PAGE_URL ;?>assets/css/app.min.css">
        

    </head>

	

	<body data-sa-theme=<?php echo $themeselected ?>>


		
		
		<?php if(Config::isLogged()){ ?>

		<main class="main">



            <header class="header">

                <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">

                    <i class="zmdi zmdi-menu"></i>

                </div>



                <div class="logo hidden-sm-down">

                    <h1><a href="<?php echo Config::$_PAGE_URL ?>"><img src="<?php echo Config::$_PAGE_URL ?>assets/img/revlogo.png" height="33px" width="127px"></a></h1>

                </div>



                <ul class="top-nav">

				  <li>


						<li class="dropdown">

							<a href="#" data-toggle="dropdown"><b><?php echo $_SESSION['discord_logged_as']->username; ?></b></a>

							<div class="dropdown-menu dropdown-menu-right dropdown-menu--block">

								<a href="<?php echo Config::$_PAGE_URL ?>logout" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>

							  </div>

							</div>

						</li>

				  </li>

                </ul>

            </header> 

		
            <aside class="sidebar">

                <div class="scrollbar-inner">



                    <div class="user">

                        <div class="user__info">

							

								<img class="user__img" src="https://cdn.discordapp.com/avatars/<?php echo $_SESSION['discord_logged_as']->id.'/'.$_SESSION['discord_logged_as']->avatar ?>.png?size=128" alt="">

								<div>

									<div class="user__name"><b><?php echo $_SESSION['discord_logged_as']->username."#".$_SESSION['discord_logged_as']->discriminator; ?></b></div>


								</div>

							

                        </div>

                    </div>



                    <ul class="navigation">

                    	<li><a href="<?php echo Config::$_PAGE_URL."reloadguilds?backto=".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"><font color=lime><i class="fa fa-sync"></i> Refresh servers</font></a></li><br>
                    	

                    	<?php 



						if(session('access_token')) {


								 $glds = $_SESSION['guilds_cache'];
								 if(isset($_SESSION['guilds_cache']->retry_after)) header('Location: '.Config::$_PAGE_URL."reloadguilds?backto=".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
								 
								 else{

								 	

								 	$guilds_w_bot = explode(", ", $_SESSION['GLB_GUILDS_CACHE']);

								 	$available = "";

								 	$canjoin = "";



									for($i = count($glds) - 1; $i >= 0; $i--){

										if(($glds[$i]->permissions & 0x8) == 0x8){

											if(in_array($glds[$i]->id, $guilds_w_bot)){

												$available .= '<li><a href="'. Config::$_PAGE_URL.'manage/'.$glds[$i]->id.'"><i class="fa fa-home"></i> '.$glds[$i]->name.'</a></li>';

											}

											else {

												$canjoin .= '<li><a href="'. Config::$_PAGE_URL.'addto/'.$glds[$i]->id.'"><i class="fa fa-home"></i> '.$glds[$i]->name.'</a></li>';
											}
										}

									}


									echo '<li>Manage servers:</li>';
									echo $available;

									echo '<br><li>Add Sugaroon to:</li>';
									echo $canjoin;


								}

						}
							

						?>

							
						

						
						

                    </ul>

                </div><div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 88px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 86px; top: 0px;"></div></div></div></div>

            </aside>



	<section class="content">
	
	<?php } ?>

	

<?php

if(!Config::isLogged() && Config::$_url[0] != "") Config::gotoPage("");

echo Config::showSN();


?>