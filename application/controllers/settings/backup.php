<?php


use Ifsnop\Mysqldump\Mysqldump;

class backup extends CI_Controller
{
	public function index()
	{
		$dumpSettings = array('routines' => true);
		$dumper= new Mysqldump('mysql:host='.$this->db->hostname.';dbname='.$this->db->database, $this->db->username, $this->db->password, $dumpSettings);
		$dumper->start('assets/backups/Saugevarde '.date('d m Y').'.sql');
	}
}
