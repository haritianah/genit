<?php

/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 30/11/2019
 * Time: 21:18
 */
class etudiant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        app::connect();
        $this->load->model('model_etudiants');
    }

    public function insert()
    {
        $data['title'] = "Insertion d'étudiants";
        $this->template->view('settings/etudiant/insert',$data);
    }

    public function update($idet)
    {
        empty($idet) ? exit() : true;
        $etudiant = $this->model_etudiants->get_info_etudiant($idet);
        $data['title']= "Modifier étudiant";
        $data['etudiant'] = $etudiant;
        $this->template->view('settings/etudiant/update',$data);
    }

    public function query_update()
    {
        $this->db->set('nom',strtoupper($_POST['nom']));
        $this->db->set('prenom',ucfirst($_POST['prenom']));
        $this->db->set('sexe',$_POST['sexe']);
        $this->db->set('naissance',$_POST['date']);
        $this->db->set('lieu',$_POST['lieu']);
        $this->db->set('adresse',$_POST['adresse']);
        $this->db->set('telephone',$_POST['phone']);
        $this->db->set('inscrit',$_POST['inscrit']);
        $this->db->where('id_etudiant',$_POST['id']);
        $this->db->update('etudiant');
        echo "SUCCESS";
        redirect("settings/etudiant/update/{$_POST['id']}");
    }
}