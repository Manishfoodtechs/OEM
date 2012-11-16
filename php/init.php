<?php
// OEM - a PHP framework for web applications
// by Michał Tatarynowicz (pies@sputnik.pl)
// Hereby released into the public domain.

define('DEBUG', true);

require_once dirname(__FILE__).'/Libs/Core/Framework.php';

class Site extends \Core\Framework {

	const DateFormat      = 'd.m.Y';
	const DateTimeFormat  = 'd.m.Y H:i';

    static $SwitchDomain = array(
		'example.com' => 'www.example.com',
		'www.admin.example.com' => 'admin.example.com',
	);

    static $ResolveApp = array(
		'www.example.com'   => 'Site',
		'admin.example.com' => 'Admin',
	);

    static $DefaultApp = 'Site';
	
	public static $locale = 'pl_PL.UTF8';
	public static $encoding = 'UTF-8';
	
	public static function Date($utime=false) {
		return date(Site::DateFormat, $utime);
	}

	public static function DateTime($utime=false) {
		return date(Site::DateTimeFormat, $utime);
	}

	public static function SendEmail($to_name, $to_email, $subject, $message) {
		$site = config()->site;
		$from = config()->email;
		$html = render('Email/Layout', compact('subject','message'));
		
		if (IS_LIVE) {
			$mailer = new \Core\Email($site->name, $site->email);
			return $mailer->send($to_name, $to_email, $subject, $html);
		}
		else {
			debug("\nFrom {$site->name} <{$site->email}>\nTo: {$to_name} <{$to_email}>\nSubject: {$subject}\n\n{$html}\n");
			return true;
		}
	}

	/**
	 * @return \Core\XMLConfig
	 */
	public static function Users() {
		return static::LoadConfigFile('users');
	}

}

\Site::Init(dirname(__FILE__));
