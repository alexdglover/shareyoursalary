<?php

$f3=require('lib/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

$f3->config('config.ini');

$f3->set('AUTOLOAD','classes/');

$f3->route('GET /',
	function($f3) {
		$classes=array(
			'Base'=>
				array(
					'hash',
					'json',
					'session'
				),
			'Cache'=>
				array(
					'apc',
					'memcache',
					'wincache',
					'xcache'
				),
			'DB\SQL'=>
				array(
					'pdo',
					'pdo_dblib',
					'pdo_mssql',
					'pdo_mysql',
					'pdo_odbc',
					'pdo_pgsql',
					'pdo_sqlite',
					'pdo_sqlsrv'
				),
			'DB\Jig'=>
				array('json'),
			'DB\Mongo'=>
				array(
					'json',
					'mongo'
				),
			'Auth'=>
				array('ldap','pdo'),
			'Bcrypt'=>
				array(
					'mcrypt',
					'openssl'
				),
			'Image'=>
				array('gd'),
			'Lexicon'=>
				array('iconv'),
			'SMTP'=>
				array('openssl'),
			'Web'=>
				array('curl','openssl','simplexml'),
			'Web\Geo'=>
				array('geoip','json'),
			'Web\OpenID'=>
				array('json','simplexml'),
			'Web\Pingback'=>
				array('dom','xmlrpc')
		);
		$f3->set('classes',$classes);
		$f3->set('content','welcome.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /userref',
	function($f3) {
		$f3->set('content','userref.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /home',
	function($f3) {
                $f3->set('content','home.php');
                echo View::instance()->render('layout.htm');
        }
);

$f3->route('GET /swagger/',
        function($f3) {
    		echo F3::serve('/swagger/dist/index.html');
        }
);


/*$f3->route('GET /survey/@name',
	function($f3) {
                $f3->set('content','survey.htm');
                echo View::instance()->render('layout.htm');
        }
);*/

// Page generator - class of functions for populating pages
$f3->route('GET /thanks/@name','PageGenerator->thanks');
$f3->route('GET /report/@name','PageGenerator->report');
$f3->route('GET /addResponse/@name','PageGenerator->addResponse');

$f3->route('GET /api/v1/survey/getByName/@name','Survey->getByName');

$f3->route('POST /api/v1/survey/addResponse/@name','Survey->addResponse');

$f3->route('POST /api/v1/survey/addSurvey','Survey->addSurvey');

$f3->run();
