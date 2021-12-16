<?php
/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 27/11/2019
 * Time: 17:40
 */

class update extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        app::connect(true);
    }

    public function index()
    {
        $data['title'] = 'Modifier résultat';

        $this->template->view('resultat/update',$data);
    }
}