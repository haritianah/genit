<?php

class show extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_etudiants');
        $this->load->model('model_fiche');
        app::connect(true);
    }

    public function index($niveau='',$decision='')
    {
        $data['title'] ="Résultats ".$niveau;
        if (!empty($niveau)){
            $data['niveau']= $niveau;
            $etudiants = $this->model_etudiants->get_list_etudiant($niveau,'1',false);
            $data['etudiants'] = $etudiants;
            $data['countAdm']= 0;
            $data['countRat']= 0;
            $data['countRef']= 0;
            $data['countExp']= 0;
        }
        if (!empty($decision)){
            $data['des'] = $decision;
            if ($decision == 'EXP'){
                $decision ='AJN';
            }
            $idDes = $this->model_etudiants->get_listEtudiantByDecision($niveau,$decision,$_SESSION['annee_etude']);
            switch ($data['des']){
                case 'ADMIS' : $data['text'] = 'Admis';
                    break;
                case  'ADMAJN' : $data['text'] = 'Admis sous réserve';
                    break;
                case 'AJN' : $data['text'] = 'Redoublants';
                    break;
                case 'EXP' : $data['text'] = 'Non autorisé à se réinscrire à la mention PSI';
                    break;

            }
            $data['idDes']= $idDes;
        }
        $this->template->view('resultat/show',$data);
    }

}