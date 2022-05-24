<?php

class model_formulaire extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_note');
    }
    public function insert_note($objetudiants,$post,$niveau,$niveau2){
        $idunit=$post['unit'];
        $idmat=$post['matiere'];
        $session=$post['session'];
        $anne=$post['annee_etude'];
        $data['session']= $session;

        //SESSION NORMALE
        if ($session=="normale"){
            //DATA
            $data['insert']=1;
            foreach ($objetudiants as $etudiant) {
                $resmat = $this->model_note->get_resmatByMatiere($etudiant->id_etudiant,$idmat);
                $resmat= !empty($resmat) ? $resmat->resultat : NULL;
                $limitnote= $this->model_note->get_limitNote($etudiant->id_etudiant,$idmat);


                if ($limitnote<4 && ($etudiant->niveau == $niveau && ($resmat == NULL || $resmat=="AJN")) || ($etudiant->niveau == $niveau2 && $resmat=="AJN") ){
                    if ($etudiant->annee_etude==$anne){
                        $note = $post["note$etudiant->id_etudiant"];
                        //INSERT ON DUPLICATE
                        $paramInsert = array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$idmat,'id_unite'=>$idunit,
                            'notes'=>$note,'noteO'=>$note,'session'=>$session,'annee_etude'=>$anne);
                        $this->model_note->insert_note($paramInsert);
                        //DATA
                        $data['notes'][$etudiant->id_etudiant] = $note;
                        $data['liste'][] = $etudiant;
                    }
                }
            }
            $this->load->view('ajax/liste_etudiants',$data);
        }

        //SESSION RATTRAPAGE
        if ($session == 'rattrapage'){
            //DATA
            $data['insert']=1;
        foreach ($objetudiants as $etudiant) {
            $resmat = $this->model_note->get_resmatByMatiere($etudiant->id_etudiant,$idmat);
            $resmat= !empty($resmat) ? $resmat->resultat : NULL;
            $limitnote= $this->model_note->get_limitNote($etudiant->id_etudiant,$idmat);
            //Chek isset note normale
            $obj_noteNormale = $this->model_note->get_noteParam(array('id_etudiant'=>$etudiant->id_etudiant,'annee_etude'=>$etudiant->annee_etude,
                'session'=>'normale','id_matiere'=>$idmat), false);
            //COunt note Elim Normale
            $param =array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$idmat,'session'=>"normale",'annee_etude'=>$anne,'notes<='=>4,'notes>'=>0);
            $countElimNormale=$this->model_note->get_noteParam($param, false)->num_rows();
                if ($resmat!= NULL && $resmat=='AJN' && $etudiant->annee_etude== $anne && $limitnote<4 && $countElimNormale==0 && $obj_noteNormale->num_rows()!=0){
                    $note = $post["note$etudiant->id_etudiant"];
                    //INSERT ON DUPLICATE
                    $paramInsert = array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$idmat,'id_unite'=>$idunit,
                                    'notes'=>$note,'noteO'=>$note,'session'=>$session,'annee_etude'=>$anne);
                    $this->model_note->insert_note($paramInsert);
                    //DATA
                    $data['notes'][$etudiant->id_etudiant] = $note;
                    $data['liste'][] = $etudiant;

                }
            }
            $this->load->view('ajax/liste_etudiants',$data);
        }
    }
}