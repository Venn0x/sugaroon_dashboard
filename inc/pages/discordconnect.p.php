<?php

if(Config::isLogged()) Config::gotoPage("dashboard");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me/guilds';
$apiURLBase2 = 'https://discord.com/api/users/@me';



// Start the login process by sending the user to Discord's authorization page
if(get('action') == 'login') {

  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => 'http://localhost/bot_dashboard/discordconnect',
    'response_type' => 'code',
    'scope' => 'identify guilds'
  );

  // Redirect the user to Discord's authorization page
  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => 'http://localhost/bot_dashboard/discordconnect',
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;


  //header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
 $_SESSION['discord_logged_as'] = apiRequest($apiURLBase2);

 $_SESSION['guilds_cache'] = apiRequest($apiURLBase);

 $_SESSION['GLB_GUILDS_CACHE'] = file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=guilds");

 Config::gotoPage("dashboard");



} else {
  header('Location: ?action=login');
}


?>