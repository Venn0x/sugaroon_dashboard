
<?php 
	
	if(Config::isLogged()) Config::gotoPage("dashboard"); else { ?>


		<br><br><br><br><br>

	<div class="card-body">


		<style type="text/css">
		.tehc {
		  color: #fff;
		  text-align: center;
		  font-family: Lato, sans-serif;
		  font-weight: 100;

		}
		.hover-item {
		  transition: 0.3s;
		}
		.hover-item:hover {
		  transform: translate(0, -10px);
		}
		</style>

		<h1 class="tehc">Login with discord</h1>
				<a href="<?php echo Config::$_PAGE_URL; ?>discordconnect" target="_blank"><center><div class="hover-item"><img src="https://discord.com/assets/f8389ca1a741a115313bede9ac02e2c0.svg" width=150px height="150px"></div></center></a>
	</div>



<?php 
	
	}?>

