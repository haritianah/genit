<?php
/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 07/12/2019
 * Time: 19:37
 */
class matiere extends CI_Controller
{
    public function __construct($niveau='')
    {
        parent::__construct();
        $this->load->model('model_matiere');
    }

    public function index()
    {
        $data['title'] = 'Paramètre matières';

        $this->template->view('settings/matiere/index',$data);
    }

    public function list($niveau='')
    {
        $data['title'] = 'Liste des matières';
        if(!empty($niveau)){
            $data['niveau'] = $niveau ;
            $data ['unites'] = $this->model_matiere->get_unite($niveau);
        }
        $this->template->view('settings/matiere/list',$data);
    }

    public function edit($idmat='')
    {
        empty($idmat) ? exit() :true;
        $matiere = $this->model_matiere->get_infoMatiere($idmat);
        $data['title'] = 'Modifier matière/unité';
        $data['matiere'] = $matiere;
        $data['unite'] = $this->model_matiere->get_infoUnite($matiere->id_unite);

        $this->template->view('settings/matiere/edit',$data);
    }

    public function insert($niveau='')
    {
        $data['title']= 'Insérér une matière';
        $data['niveau'] = $niveau;
        $data['unites'] = $this->model_matiere->get_unite($niveau);
        //third
        $third_css = array('bootstrap-select.min.css');
        $third_js = array('bootstrap-select.min.js');
        $data['third_css'] = $third_css;
        $data['third_js'] = $third_js;
        $this->template->view('settings/matiere/insert',$data);
    }

    public function q_insertMat()
    {
        $unite = $this->model_matiere->check_unitByNum($_POST['num']);
        if (!empty($unite)){
            $data = $_POST;
            $data['idunit'] = $unite->id_unite;
            $data['niveau'] = $unite->niveau_unite;
            //insert matier
            $this->model_matiere->insert_matiere($data);
            //insert resmat
            $etudiantsup = $this->db->get_where('etudiant',array('niveau>'=>$data['niveau']))->result();
            $this->model_matiere->insert_resmatMatiere($etudiantsup);
            $_SESSION['flash']['success'] = 'Matière insérée';
            redirect('settings/matiere');
        }else{
            $_SESSION['flash']['danger'] = 'Cette unité n\'existe pas';
            redirect('settings/matiere');
        }

    }

    public function stat($niveau='')
    {
        $data['title'] = "Statistiques des matières";
        if (!empty($niveau)){
            $data['niveau'] = $niveau;
            $matieres = $this->model_matiere->get_matiereByNiv($niveau);
            $data['matieres'] = $matieres;
        }
        $this->template->view('settings/matiere/stat',$data);
    }
}