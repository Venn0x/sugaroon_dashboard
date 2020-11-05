<?php
if(Config::isLogged()){
	$server = Config::$_url[1];

	header("Location: https://discord.com/api/oauth2/authorize?client_id=771110685182001202&permissions=8&redirect_uri=http%3A%2F%2Flocalhost%2Fbot_dashboard%2Freloadguilds%3Fbackto%3Dhttp%3A%2F%2Flocalhost%2Fbot_dashboard%2F&scope=bot&guild_id=".$server);
}
?>