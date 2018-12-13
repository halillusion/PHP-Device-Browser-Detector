<?php

function device_detector($ua=NULL)
{

	// Based on Jay's PHP Class on https://stackoverflow.com/a/28585591/9397800

	$ua = $ua==NULL ? $_SERVER['HTTP_USER_AGENT'] : $ua;
	$browser = 'UNDETECTED';
	$version = '@';
	$platform = 'UNDETECTED';
	$os_platform = 'UNDETECTED';
	$b_icon = 'mdi mdi-close-circle';
	$p_icon = 'mdi mdi-close-circle';

	$browser_list = array (
		'Trident\/7.0' => array('Internet Explorer 11','mdi mdi-internet-explorer'),
		'MSIE' => array('Internet Explorer','mdi mdi-internet-explorer'),
		'Edge' => array('Microsoft Edge','mdi mdi-edge'),
		'Internet Explorer' => array('Internet Explorer','mdi mdi-internet-explorer'),
		'Beamrise' => array('Beamrise','mdi mdi-earth'),
		'Opera' => array('Opera','mdi mdi-opera'),
		'OPR' => array('Opera','mdi mdi-opera'),
		'Vivaldi' => array('Vivaldi','mdi mdi-earth'),
		'Shiira' => array('Shiira','mdi mdi-earth'),
		'Chimera' => array('Chimera','mdi mdi-earth'),
		'Phoenix' => array('Phoenix','mdi mdi-earth'),
		'Firebird' => array('Firebird','mdi mdi-earth'),
		'Camino' => array('Camino','mdi mdi-earth'),
		'Netscape' => array('Netscape','mdi mdi-earth'),
		'OmniWeb' => array('OmniWeb','mdi mdi-earth'),
		'Konqueror' => array('Konqueror','mdi mdi-earth'),
		'icab' => array('iCab','mdi mdi-earth'),
		'Lynx' => array('Lynx','mdi mdi-earth'),
		'Links' => array('Links','mdi mdi-earth'),
		'hotjava' => array('HotJava','mdi mdi-earth'),
		'amaya' => array('Amaya','mdi mdi-earth'),
		'IBrowse' => array('IBrowse','mdi mdi-earth'),
		'iTunes' => array('iTunes','mdi mdi-earth'),
		'Silk' => array('Silk','mdi mdi-earth'),
		'Dillo' => array('Dillo','mdi mdi-earth'),
		'Maxthon' => array('Maxthon','mdi mdi-earth'),
		'Arora' => array('Arora','mdi mdi-earth'),
		'Galeon' => array('Galeon','mdi mdi-earth'),
		'Iceape' => array('Iceape','mdi mdi-earth'),
		'Iceweasel' => array('Iceweasel','mdi mdi-earth'),
		'Midori' => array('Midori','mdi mdi-earth'),
		'QupZilla' => array('QupZilla','mdi mdi-earth'),
		'Namoroka' => array('Namoroka','mdi mdi-earth'),
		'NetSurf' => array('NetSurf','mdi mdi-earth'),
		'BOLT' => array('BOLT','mdi mdi-earth'),
		'EudoraWeb' => array('EudoraWeb','mdi mdi-earth'),
		'shadowfox' => array('ShadowFox','mdi mdi-earth'),
		'Swiftfox' => array('Swiftfox','mdi mdi-earth'),
		'Uzbl' => array('Uzbl','mdi mdi-earth'),
		'UCBrowser' => array('UCBrowser','mdi mdi-earth'),
		'Kindle' => array('Kindle','mdi mdi-earth'),
		'wOSBrowser' => array('wOSBrowser','mdi mdi-earth'),
		'Epiphany' => array('Epiphany','mdi mdi-earth'),
		'SeaMonkey' => array('SeaMonkey','mdi mdi-earth'),
		'Avant Browser' => array('Avant Browser','mdi mdi-earth'),
		'Chrome' => array('Google Chrome','mdi mdi-google-chrome'),
		'Safari' => array('Safari','mdi mdi-apple-safari'),
		'Firefox' => array('Firefox','mdi mdi-firefox'),
		'Mozilla' => array('Mozilla','mdi mdi-firefox')
	);

	$platform_list = array(
		'windows' => array('Windows','mdi mdi-windows'),
		'iPad' => array('iPad','mdi mdi-apple'),
		'iPod' => array('iPod','mdi mdi-apple'),
		'iPhone' => array('iPhone','mdi mdi-apple'),
		'mac' => array('Apple MacOS','mdi mdi-apple'),
		'android' => array('Android','mdi mdi-linux'),
		'linux' => array('Linux','mdi mdi-linux'),
		'Nokia' => array('Nokia','mdi mdi-microsoft'),
		'BlackBerry' => array('BlackBerry','mdi mdi-blackberry'),
		'FreeBSD' => array('FreeBSD','mdi mdi-freebsd'),
		'OpenBSD' => array('OpenBSD','mdi mdi-linux'),
		'NetBSD' => array('NetBSD','mdi mdi-linux'),
		'UNIX' => array('UNIX','mdi mdi-mouse'),
		'DragonFly' => array('DragonFlyBSD','mdi mdi-linux'),
		'OpenSolaris' => array('OpenSolaris','mdi mdi-linux'),
		'SunOS' => array('SunOS','mdi mdi-linux'),
		'OS\/2' => array('OS/2','mdi mdi-mouse'),
		'BeOS' => array('BeOS','mdi mdi-mouse'),
		'win' => array('Windows','mdi mdi-windows'),
		'Dillo' => array('Linux','mdi mdi-linux'),
		'PalmOS' => array('PalmOS','mdi mdi-mouse'),
		'RebelMouse' => array('RebelMouse','mdi mdi-mouse')
	);

	foreach($browser_list as $pattern => $name) {
		if( preg_match("/".$pattern."/i",$ua, $match)) {
			$b_icon = $name[1];
			$browser = $name[0];
			$known = array('Version', $pattern, 'other');
			$pattern_version = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern_version, $ua, $matches)) {
			}
			$i = count($matches['browser']);
			if ($i != 1) {
				if (strripos($ua,"Version") < strripos($ua,$pattern)){
					@$version = $matches['version'][0];
				}
				else {
					@$version = $matches['version'][1];
				}
			}
			else {
				$version = $matches['version'][0];
			}
			break;
		}
	}

	foreach($platform_list as $key => $platform) {
		if (stripos($ua, $key) !== false) {
			$p_icon = $platform[1];
			$platform = $platform[0];
			break;
		} 
	}

	$os_array = array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	);

	foreach ($os_array as $regex => $value)
	{
		if (preg_match($regex, $ua))
		{
			$os_platform = $value;
		}
	}

	return array(
		'user_agent'=> $ua,			// User Agent
		'browser'	=> $browser,	// Browser Name
		'version'	=> $version,	// Version
		'platform'	=> $platform,	// Platform
		'os'		=> $os_platform,// Platform Detail
		'b_icon'	=> $b_icon,		// Browser Icon(icon class name like from Material Design Icon)
		'p_icon'	=> $p_icon		// Platform Icon(icon class name like from Material Design Icon)
	);
}