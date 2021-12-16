<?php
class operation extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_fiche');
        $this->load->model('model_etudiants');
        $this->load->model('model_note');
        app::connect(true);
    }
    public function index($niv=""){
        $data['title']="Génération des résultats";
        if ($niv!=""){
            $data['niveau']=$niv;
            $semestre = $this->model_fiche->get_semestre($niv);
            $data['semestres']= $semestre;
        }
        $this->template->view("resultat/operation",$data);
    }
    public function calc($semestre)
    {
        $data['title']="Génération des résultats";
        $data['semestre']= $semestre;
        $niveau = $this->app->getNivBySemestre($semestre)->niveau_unite;
        $data['niveau']= $niveau;
        $etudiants = $this->model_etudiants->get_list_by_niv($niveau);
        $this->db->query("CALL calcEc(?,?)",array($niveau,$_SESSION['annee_etude']));
        //
        $data['etudiants']= $etudiants;
        //VAR
        $data["sumCredtNiv"] = $this->model_fiche->get_sumCredtByNiv($niveau);
        $data["limitNiv"] = limit($data['sumCredtNiv']);
        $this->template->view('resultat/operation',$data);

    }
}