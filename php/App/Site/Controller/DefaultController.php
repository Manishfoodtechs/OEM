<?php
namespace App\Site\Controller;

use Database\DB;
use Core\XML;

class DefaultController extends AppController {

	public function index() {
		return $this->render('Page/Index');
	}

	public function categories() {
		$data = simplexml_load_file(DIR_APP.'/categories.xml', 'Core\XML');
		return $this->render('Page/Categories', compact('data'));
	}
	
	public function db() {
		$printer = new \Model\Printer();
		return $printer->CompareModelWithDatabase();
	}

}