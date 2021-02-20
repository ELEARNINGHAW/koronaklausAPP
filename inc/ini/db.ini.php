	<?php
	$liveserver = "lernserver.ls.haw-hamburg.de"; # Adresse des Liveservers ohne "www",
	# "www.meine.server.de = meine.server.de"
   
	if ( $_SERVER[ 'SERVER_NAME' ] == $liveserver )
	{   
		# Werte auf Produktivserver einstellen!
		$server = $opts['hn'] = "localhost";
		$user 	= $opts['un'] = "koronaklaus";
		$pass 	= $opts['pw'] = "koronaklaus";
		$dbase 	= $opts['db'] = "koronaklaus";
	}   

	else 
	{
		# Werte auf Entwicklungsserver einstellen!
		$server = $opts['hn'] = "localhost";
		$user 	= $opts['un'] = "koronaklaus";
		$pass 	= $opts['pw'] = "koronaklaus";
		$dbase 	= $opts['db'] = "koronaklaus";
	}
	?>
