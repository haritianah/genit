<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'dompdf\autoload.inc.php';
use Dompdf\Dompdf;

class PPdf extends Dompdf{
    public function __construct()
    {
        parent::__construct();
    }
}