<?php

use Ifsnop\Mysqldump\Mysqldump;

/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 14/07/2021
 */
class maj extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        app::connect();
        $this->load->model('model_etudiants');
        $this->load->model('model_decision');
    }
    public function index()
    {
       $data['title'] = "Passage A.U";

       $this->template->view('settings/maj/index', $data);
    }

    public function action()
    {
        $oetudiant = $this->model_etudiants->get_all();
		$this->db->query("CALL backup_etdiant_maj()");
		$dumpSettings = array('routines' => true);
        $dumper= new Mysqldump('mysql:host='.$this->db->hostname.';dbname='.$this->db->database, $this->db->username, $this->db->password, $dumpSettings);
        $odate = new DateTime();
        if(isset($_POST['currentAnnee'])){
            $currentAnnee = $_POST['currentAnnee'];
            $nextAnnee = $currentAnnee + 1;
        }
        $dumper->start('assets/backups/BackupBeforeMaj '.$odate->format('d-m-y His').'.sql');
        foreach ($oetudiant as $etudiant) {
            $this->db->reset_query();
            $odecision =$this->model_decision->get_decison_by_etudiant($etudiant->id_etudiant, $etudiant->niveau);
            if ($etudiant->niveau != "M2"){
                $niveau = $etudiant->niveau;
                $inextNumber = $niveau[1] +1;
                $nextNiveau = $niveau[0].$inextNumber;
                if($nextNiveau == "L4"){
                    $nextNiveau = "M1";
                }

                if ($odecision->decision == "ADMIS") {
                    $this->db->set('niveau', $nextNiveau);
                    $this->db->set('annee_etude', $nextAnnee);
                    $this->db->set('etat', 'P');
                    $this->db->set('inscrit', 0);
                    $this->db->where('id_etudiant', $etudiant->id_etudiant);
                }elseif($odecision->decision == "ADMAJN"){
                    $this->db->set('niveau', $nextNiveau);
                    $this->db->set('annee_etude', $nextAnnee);
                    $this->db->set('etat', 'Rat');
                    $this->db->set('inscrit', 0);
                    $this->db->where('id_etudiant', $etudiant->id_etudiant);
                }elseif($odecision->decision == "AJN"){
                    $this->db->set('annee_etude', $nextAnnee);
                    $this->db->set('etat', 'Red');
                    $this->db->set('inscrit', 0);
                    $this->db->where('id_etudiant', $etudiant->id_etudiant);
                }
                $this->db->update('etudiant');
            }else{
                if($odecision->decision == "ADMIS"){
                    $this->db->set('old', 't');
                    $this->db->set('inscrit', 0);
                    $this->db->where('id_etudiant', $etudiant->id_etudiant);
                }elseif($odecision->decision == "AJN"){
                    $this->db->set('annee_etude', $nextAnnee);
                    $this->db->set('etat', 'Red');
                    $this->db->set('inscrit', 0);
                    $this->db->where('id_etudiant', $etudiant->id_etudiant);
                }
                $this->db->update('etudiant');
            }
        }
        $this->db->set('annee_etude', $nextAnnee);
        $this->db->update('maj');

        redirect('home');
    }

    
}
