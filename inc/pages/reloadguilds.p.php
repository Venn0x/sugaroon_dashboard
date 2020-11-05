<?php

if(Config::isLogged()){


	$_SESSION['guilds_cache'] = apiRequest('https://discord.com/api/users/@me/guilds');

	$_SESSION['GLB_GUILDS_CACHE'] = file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=guilds");

	if(isset($_GET['backto'])) header('Location: http://'.$_GET['backto']);

	else Config::gotoPage("");

}

?>