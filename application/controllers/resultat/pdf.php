<?php


class pdf extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_etudiants');
        $this->load->model('model_fiche');
        $this->load->library('PPdf');
        app::connect(true);

    }

    public function index($niveau='',$decision='')
    {
        $des = $decision;
        if ($decision == 'EXP'){
            $decision ='AJN';
        }
        $idDes = $this->model_etudiants->get_listEtudiantByDecision($niveau,$decision,$_SESSION['annee_etude']);
        switch ($des){
            case 'ADMIS' : $data['text'] = 'Admis';
                break;
            case  'ADMAJN' : $data['text'] = 'Admis sous réserve';
                break;
            case 'AJN' : $data['text'] = 'Redoublants';
                break;
            case 'EXP' : $data['text'] = 'Non autorisé à se réinscrire à la mention PSI';
                break;

        }
        ob_start();
        $count=0;
        ?>
        <p>UNIVERSITE D'ANTANANARIVO</p>
        <p>DOMAINE ARTS, LETTRES ET SCIENCES HUMAINES</p>
        <br><br>
        <P align="center">MENTION PSYCHOLOGIE SOCIALE ET INTERCULTURELLE</P>
        <P align="center">ANNEE UNIVERSITAIRE <?= $_SESSION['annee_etude']-1 ?> - <?= $_SESSION['annee_etude'] ?></P>
        <br><br>
        <h3>Liste des étudiants <?= $niveau ?> <?= $data['text'] ?></h3>
    <ol>
        <?php foreach ($idDes as $etudiant): ?>
        <?php
        $countSessionExpire = $this->model_fiche->get_sessionExpire($etudiant);
        if ($des == 'EXP' && $countSessionExpire!=0){
            echo "<li> $etudiant->nom $etudiant->prenom </li>";
            $count++;
        }elseif ($des!= 'EXP' && $countSessionExpire==0){
            echo "<li> $etudiant->nom $etudiant->prenom </li>";
            $count++;
        }
        ?>
        <?php endforeach; ?>
    </ol>

        <p>Arrêté la présente liste à <?= $count ?> (<?= trim(convertir($count)) ?>) étudiants</p>
    <?php
        $html = ob_get_clean();
        $pdfGen = new PPdf();
        $pdfGen->loadHtml($html);
        $pdfGen->render();
        $pdfGen->stream("Liste $niveau {$data['text']} .pdf",array('Attachment'=> 0));
    }
}