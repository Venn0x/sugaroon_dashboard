
<?php

$widgets = array();

$widgets2 = array();


//$_SESSION['guilds_cache'] = apiRequest('https://discord.com/api/users/@me/guilds');

$_SESSION['GLB_GUILDS_CACHE'] = file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=guilds");


$server = Config::$_url[1];

$glds = $_SESSION['guilds_cache'];
$guilds_w_bot = explode(", ", $_SESSION['GLB_GUILDS_CACHE']);

$access = -1;

for($i = 0; $i < count($glds); $i++){

    if($glds[$i]->id == $server){

        if(($glds[$i]->permissions & 0x8) == 0x8){

            if(in_array($glds[$i]->id, $guilds_w_bot)){

                $access = $i;

            }

            else {

                $access = -2;
            }
        }
        else{

            $access = -3;

        }

    }

}

if($access >= 0){
    
    $plgEnabled = explode(",", file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=plugins&server=".$server));

    $plgAll = explode(",", file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=plugins&server=-1"));

    if(!isset(Config::$_url[2])){


        echo '

        <div class="card">
        
            <div class="card-header">

                <h4><i class="fa fa-gear"></i> '.$glds[$access]->name.'</h4>

            </div>

                
            <div class="card-body">

                <h5>You\'re managing <b>'.$glds[$access]->name.'</b>. You can activate and de-activate plugins below. You can manage other settings for some plugins. You cannot modify or toggle the core plugins (not displayed)</h5>
            
            </div>

        </div>';

        for($i = 0; $i < count($plgAll); $i++){

            if(in_array($plgAll[$i], $plgEnabled)) $widgets = addWidget($widgets, ucfirst(str_replace("_", " ", $plgAll[$i])), "<br><a href='".Config::$_PAGE_URL."manage/".$server."/".$plgAll[$i]."/toggle'><button class='buttonfrumos'>Disable</button></a> "." <a href='".Config::$_PAGE_URL."manage/".$server."/".$plgAll[$i]."/options'><button class='buttonfrumos'>Options</button></a>");

            else {
                if(strncmp($plgAll[$i], "core", 4)  !== 0) $widgets2 = addWidget($widgets2, ucfirst(str_replace("_", " ", $plgAll[$i])), "<br><a href='".Config::$_PAGE_URL."manage/".$server."/".$plgAll[$i]."/toggle'><button class='buttonfrumos'>Enable</button></a>");

            }

        }


    }

    else{

        $plugin = Config::$_url[2];

        if(in_array($plugin, $plgAll) && strncmp($plugin, "core", 4) !== 0){

            if(!isset(Config::$_url[3])) header('Location: '.Config::$_PAGE_URL."manage/".$server);

            else{

                $option = Config::$_url[3];;

                if($option == "toggle"){

                    file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=modify&item=toggleplugin&guild=".$server."&plugin=".$plugin);

                    header('Location: '.Config::$_PAGE_URL."manage/".$server);


                }
                else if($option == "options"){



                }
                else{

                    header('Location: '.Config::$_PAGE_URL."manage/".$server);

                }

            }


        }
        else{

            header('Location: '.Config::$_PAGE_URL."manage/".$server);

        }

    }


}
else{
    echo '<div class="card"><div class="card-body"><h3>';
    if($access == -1) echo "ERROR: You're not in that server.";
    if($access == -2) echo "ERROR: That server doesn't have the Sugaroon bot configured. If you have administrator rights of that server, please configure Sugaroon on that server to use it.<br><br><a href='".Config::$_PAGE_URL."addto/".$server."'><button class='buttonfrumos'>Start configuring Sugaroon</button></a>";
    if($access == -3) echo "ERROR: You don't have the permissions to manage that server.";
    echo '</h3></div></div>';
}


//file_get_contents(Config::$_BOTSERVER_URL.":".Config::$_BOTSERVER_PORT."/?token=".Config::$_BOTSERVER_TOKEN."&request=data&item=guilds");













// --- render --- //

function addWidget($widgets, $head, $body){

    array_push($widgets, array('header' => $head, 'body' => $body));

    return $widgets;
}
if(count($widgets) != 0){
    echo '<div class="row quick-stats">';

    for($i = 0; $i < count($widgets); $i++){

        echo '

            <div class="col-sm-6 col-md-3">

                <div class="quick-stats__item">

                    <div class="quick-stats__info">

                        <h2>'.$widgets[$i]['header'].'</h2>

                        '.$widgets[$i]['body'].'

                    </div>

                </div>

            </div>

        ';

        if(($i + 1)%4 == 0 && $i != 0) echo '</div><br><div class="row quick-stats">';

    }
    echo '</div><br><br><br><br>';
}
if(count($widgets2) != 0){
    echo '<div class="row quick-stats">';
    for($i = 0; $i < count($widgets2); $i++){

        echo '

            <div class="col-sm-6 col-md-3">

                <div class="quick-stats__item">

                    <div class="quick-stats__info">

                        <h2><font color="grey">'.$widgets2[$i]['header'].'</font></h2>

                        '.$widgets2[$i]['body'].'

                    </div>

                </div>

            </div>

        ';

        if(($i + 1)%4 == 0 && $i != 0) echo '</div><br><div class="row quick-stats">';

    }
    echo '</div>';
}

?>

