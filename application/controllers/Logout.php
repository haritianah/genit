<?php
class logout extends CI_Controller{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        unset($_SESSION['auth']);
        redirect(base_url('login'));
    }
}