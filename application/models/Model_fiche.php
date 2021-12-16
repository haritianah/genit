<?php
/**
*
*/
class model_fiche extends CI_Model
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('model_note');
    }
    /**
     * @param $niveau
     * @return array semestre
     */
    public function get_semestre($niveau)
    {
        $this->db->select('semestre');
        $this->db->distinct();
        $this->db->where('niveau_unite',$niveau);
        $query= $this->db->get('unites');

        return $query->result();
    }

    /**
     * @return int
     */
    public function get_sumCredt($niv){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->where('niveau_unite<=',$niv);
        $query=$this->db->get();

        return $query->row()->total;
    }

    /**
     * @param $niveau
     * @return int
     */
    public function get_sumCredtByNiv($niveau){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->where('niveau_unite',$niveau);
        $query=$this->db->get();

        return $query->row()->total;
    }

    /**
     * @param $semestre
     * @return int
     */
    public function get_sumCredtBySemestre($semestre){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->where('semestre',$semestre);
        $query=$this->db->get();

        return $query->row()->total;
    }
    public function get_sumCredtEtudByNiv($idet,$niv){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->join('resultat_matiere','resultat_matiere.id_matiere=matiere.id_matiere');
        $this->db->where('niveau_unite',$niv);
        $this->db->where('id_etudiant',$idet);
        $this->db->where('resultat','ACQ');
        $query=$this->db->get();

        return $query->row()->total;
    }
    public function get_sumCredtEtudBySemestre($idet,$semestre){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->join('resultat_matiere','resultat_matiere.id_matiere=matiere.id_matiere');
        $this->db->where('semestre',$semestre);
        $this->db->where('id_etudiant',$idet);
        $this->db->where('resultat','ACQ');
        $query=$this->db->get();

        return $query->row()->total;
    }
    public function get_sumCredtEtud($idet){
        $this->db->select('SUM(credit) as total');
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite=unites.id_unite');
        $this->db->join('resultat_matiere','resultat_matiere.id_matiere=matiere.id_matiere');
        $this->db->where('id_etudiant',$idet);
        $this->db->where('resultat','ACQ');
        $query=$this->db->get();

        return $query->row()->total;
    }
    public function get_resultAnteAjn($idet,$semestre){
        $semestre = substr($semestre,1);
        $semestre = "S". ($semestre-2);
        $query= $this->model_note->get_resmat(array('id_etudiant'=>$idet,'semestre'=>$semestre,'resultat'=>'AJN'),false);

        return $query->num_rows();
    }
    public function get_sessionExpire($obj_etudiant){
        $sql = "SELECT n1.* from notes n1 join unites u on u.id_unite = n1.id_unite where exists(select * from notes n2 where n1.id_etudiant=n2.id_etudiant
and n1.id_matiere=n2.id_matiere and n2.annee_etude< n1.annee_etude) and (niveau_unite=? OR niveau_unite!=?) and not exists (select * from notes n3 where n1.id_etudiant =n3.id_etudiant and
n1.id_matiere = n3.id_matiere and n1.annee_etude = n3.annee_etude and n1.code_note < n3.code_note) and n1.notes<10 and n1.id_etudiant=?";
        $query = $this->db->query($sql,array($obj_etudiant->niveau,$obj_etudiant->niveau,$obj_etudiant->id_etudiant));

        return $query->num_rows();
    }
    public function get_textDecision($decision,$niv){
        $text = 'REFUSE(E)';
        switch ($decision){
            case 'ADMIS':
                if ($niv=='M2'){
                    $text = 'MASTER ACQUIS';
                }elseif ($niv == 'L3'){
                    $text = 'LICENCE ACQUISE';
                }else{
                    $text = 'ADMIS(E)';
                }
            break;
            case 'ADMAJN':
                $text = 'ADMIS(E) SOUS RESERVE';
            break;
            case 'AJN':
                if ($niv=='M2'){
                    $text = 'MASTER REFUSE';
                }elseif ($niv == 'L3'){
                    $text = 'LICENCE REFUSEE';
                }else{
                    $text = 'REFUSE(E)';
                }
            break;
            default :
                if ($niv=='M2'){
                    $text = 'MASTER REFUSE';
                }elseif ($niv == 'L3'){
                    $text = 'LICENCE REFUSEE';
                }else{
                    $text = 'REFUSE(E)';
                }
            break;
        }

        return $text;
    }
    /**
     * @param $sumCrdtUnite total credit de l'unité
     * @param $credN credit de l'etudiant
     * @param $moyenne moyenne de l'unite de l'etd
     * @return string
     */
    private function get_metion($sumCrdtUnite, $credN, $moyenne){
        if($credN != $sumCrdtUnite){
            $mention='NV';
        }else{
            switch ($moyenne){
                case $moyenne>=10 &&$moyenne <12:
                    $mention="VP";
                    break;
                case $moyenne>=12 &&$moyenne <14:
                    $mention="VAB";
                    break;
                case $moyenne>=14 &&$moyenne <16:
                    $mention="VB";
                    break;
                case $moyenne>=16:
                    $mention="VTB";
                    break;
                default:
                    $mention="NV";
                    break;
            }
        }
        return $mention;
    }
    /**
     * @param $niveau
     * @param string $semestre
     * @return liste unites
     */
    public function get_unite($niveau,$semestre="",$result=true)
    {
        $query = $semestre != "" ? $this->db->get_where('unites', array('niveau_unite' => $niveau, 'semestre' => $semestre))
                                 : $this->db->get_where('unites', array('niveau_unite' => $niveau));
        return $result == true ? $query->result() : $query;

    }
    /**
     * @param $unite
     * @return array
     */
    public function get_matiere($unite,$result=true)
    {
        $query= $this->db->get_where('matiere',array('id_unite' => $unite));
       return $result== true ? $query->result() : $query;
    }

    /**
     * @param $obj_etudiant
     * @param $niv
     * @return array
     */


    public function get_array($obj_etudiant, $niv, $recherche =false)
    {
      $arrnote =array();
        $unit= $this->get_unite($niv);
        foreach ($unit as $unite) {
            /*Get eliminantion*/
            $nbElimNorm = $this->model_note->get_elim($obj_etudiant,$unite->id_unite,"normale");
            $nbElimRatr = $this->model_note->get_elim($obj_etudiant,$unite->id_unite,"rattrapage");
            /*Get nombre defaillant*/
            $nbDefNorm = $this->model_note->get_defail($obj_etudiant,$unite->id_unite,"normale");
            $nbDefRatr = $this->model_note->get_defail($obj_etudiant,$unite->id_unite,"rattrapage");
            /*Counteur de notes pour moyenne*/
            $counterNoteNorm=0;
            $counterNoteNormOri=0;
            $counterNoteRatr=0;
            $counterNoteRatrOri=0;
            /*Counteur credit */
            $counterCredNorm=0;
            $counterCredNormOri=0;
            $counterCredRatr=0;
            $counterCredRatrOri=0;
            //
            $sumCredtUnit= $this->model_note->get_credt_unite($unite->id_unite);
            $mat = $this->get_matiere($unite->id_unite,false);
            $nbMat = $mat->num_rows();
            foreach ($mat->result() as $matiere){
                //Declare var
                $codeN=0;
                $noteN='';
                $colorN='';
                $anneN=0;

                $codeR=0;
                $noteR='';
                $noteRO='';
                $colorR='';
                $anneR=0;

                $resmat = $this->model_note->get_resmat(array('id_etudiant'=>$obj_etudiant->id_etudiant,'id_matiere'=>$matiere->id_matiere),false)->row();
                //
                $obj_noteNorm= $this->model_note->get_lastnote($obj_etudiant->id_etudiant,"normale",$matiere->id_matiere,$obj_etudiant->annee_etude);
                $obj_noteRatr= $this->model_note->get_lastnote($obj_etudiant->id_etudiant,"rattrapage",$matiere->id_matiere,$obj_etudiant->annee_etude);

                if (!empty($obj_noteNorm->notes)){
                    $noteN= $obj_noteNorm->notes==='0.00'? 'ABS' :$obj_noteNorm->notes;
                    $noteNO= $obj_noteNorm->notes==='0.00'? 'ABS' :$obj_noteNorm->noteO;
                    $codeN= $obj_noteNorm->code_note;
                    $colorN= $obj_noteNorm->annee_etude == $obj_etudiant->annee_etude ? 'black' : 'green';
                    $colorN= ($obj_noteNorm->annee_etude == $obj_etudiant->annee_etude && $obj_noteNorm->notes>0 && $obj_noteNorm->notes<=4)? 'red' : $colorN;
                    $anneN= $obj_noteNorm->annee_etude;
                }
                if (!empty($obj_noteRatr->notes)){
                    $noteR=$obj_noteRatr->notes ==='0.00'? 'ABS' :$obj_noteRatr->notes;
                    $noteRO=$obj_noteRatr->noteO ==='0.00'? 'ABS' :$obj_noteRatr->noteO;
                    $codeR=$obj_noteRatr->code_note;
                    $colorR = $obj_noteRatr->annee_etude == $obj_etudiant->annee_etude ? 'blue' : 'green';
                    $colorR= ($obj_noteRatr->annee_etude == $obj_etudiant->annee_etude && $obj_noteRatr->notes>0 && $obj_noteRatr->notes<=4)? 'red' : $colorR;
                    $anneR=$obj_noteRatr->annee_etude;
                }
                if (!empty($obj_noteNorm->notes) && !empty($resmat->resultat) && $resmat->resultat=='AJN' && $resmat->annee_etude != $obj_etudiant->annee_etude){
                    $codeN=0;
                    $noteN='';
                    $colorN='';
                    $anneN=0;
                }
                if (!empty($obj_noteRatr->notes) && !empty($resmat->resultat) && $resmat->resultat=='AJN' && $resmat->annee_etude != $obj_etudiant->annee_etude){
                    $codeR=0;
                    $noteR='';
                    $noteRO='';
                    $colorR='';
                    $anneR=0;
                }
                if ((empty($obj_noteRatr->notes) && $noteN>4) || $noteN >= 10){
                    $noteR=$noteN;
                    $noteRO=$noteNO;
                    $codeR= $codeN;
                    $colorR=  $colorN;
                    $anneR= $anneN;
                }
                if($anneN>$anneR && $codeR!= 0){
                    $noteR=$noteN;
                    $noteRO=$noteNO;
                    $codeR= $codeN;
                    $colorR=  $colorN;
                    $anneR= $anneN;
                }
                if ($noteR > $noteN && $colorR== 'green' && $noteR >= 10 && $recherche == true){
                    $codeN=$codeR;
                    $noteN=$noteR;
                    $colorN=$colorN;
                    $anneN=$anneR;
                }
                $counterNoteNorm+= is_numeric($noteN) ? $noteN : 0;
                $counterNoteRatr+=is_numeric($noteR) ? $noteR : 0;
                $counterNoteRatrOri+=is_numeric($noteRO) ? $noteRO : 0;

                if ($noteN>=10){
                    $counterCredNorm+= $matiere->credit;
                }
                if ($noteR>=10){
                    $counterCredRatr+= $matiere->credit;
                }
                if ($noteRO>=10){
                    $counterCredRatrOri+= $matiere->credit;
                }

                $arrnote[$unite->id_unite][$matiere->id_matiere]["N"]= $noteN;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["codeN"]= $codeN;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["colorN"]= $colorN;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["anneeN"]= $anneN;

                $arrnote[$unite->id_unite][$matiere->id_matiere]["R"]= $noteR;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["RO"]= $noteRO;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["codeR"]= $codeR;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["colorR"]= $colorR;
                $arrnote[$unite->id_unite][$matiere->id_matiere]["anneeR"]= $anneR;
            }
            $moyenneN= round($counterNoteNorm/$nbMat,2);
            $moyenneN= $nbDefNorm!=0 ? 'Déf' : $moyenneN;
            $moyenneN= $nbElimNorm!=0 ? '-' : $moyenneN;
            $moyenneR= round($counterNoteRatr/$nbMat,2);
            $moyenneR= $nbDefRatr!=0 ? 'Déf' : $moyenneR;
            $moyenneR= ($nbElimRatr!=0 || $nbElimNorm!=0) ? '-' : $moyenneR;
            $moyenneRO= round($counterNoteRatrOri/$nbMat,2);
            $moyenneRO= $nbDefRatr!=0 ? 'Déf' : $moyenneRO;
            $moyenneRO= $nbElimRatr!=0 ? '-' : $moyenneRO;

            $mentionN =$this->get_metion($sumCredtUnit, $counterCredNorm, $moyenneN);
            $mentionR =$this->get_metion($sumCredtUnit, $counterCredRatr, $moyenneR);
            $mentionRO =$this->get_metion($sumCredtUnit, $counterCredRatrOri, $moyenneRO);

            if ($moyenneRO != $moyenneR && $counterCredRatrOri != $counterCredRatr){
                $mentionR.= '/D';
            }elseif ($moyenneRO == $moyenneR && $counterCredRatrOri != $counterCredRatr){
                $mentionR.= '/C';
            }

                $arrnote[$unite->id_unite]['elimN']= $nbElimNorm;
                $arrnote[$unite->id_unite]['defN']= $nbDefNorm;
                $arrnote[$unite->id_unite]['moyenneN']= $moyenneN;
                $arrnote[$unite->id_unite]['mentionN']= $mentionN;
                $arrnote[$unite->id_unite]['moyenneR']= $moyenneR;
                $arrnote[$unite->id_unite]['moyenneRO']= $moyenneRO;
                $arrnote[$unite->id_unite]['mentionR']= $mentionR;
                $arrnote[$unite->id_unite]['mentionRO']= $mentionRO;
                $arrnote[$unite->id_unite]['credtN']= $counterCredNorm;
                $arrnote[$unite->id_unite]['credtR']= $counterCredRatr;
                $arrnote[$unite->id_unite]['credtRO']= $counterCredRatrOri;
                $arrnote[$unite->id_unite]['ff']= $counterNoteRatr;
        }

        return $arrnote;
    }
    public function get_noteR ($colorR,$noteR,$noteRO){
        echo $noteR;
        if($noteR!= $noteRO): ?>
            <br><strike><span style="color: <?= $colorR ?> !important"><?= $noteRO ?></span></strike>
        <?php endif;
    }

    /**
     * @param $idetudiant
     */
    public function resetSessExpire($idetudiant){
        $this->db->query("UPDATE etudiant SET old=? WHERE id_etudiant=?",array('f',$idetudiant));
    }

    /**
     * @param $obj_etudiant
     * @param $niveau
     * @param $decision
     */
    public function insertDecision($obj_etudiant, $niveau, $decision){
        $this->db->query('INSERT INTO decision SET id_etudiant=?, decision=?, niveau_des=?, annee_etude=? 
            ON DUPLICATE KEY UPDATE decision =?, annee_etude=?', array($obj_etudiant->id_etudiant, $decision, $niveau,
            $obj_etudiant->annee_etude,$decision,$obj_etudiant->annee_etude));
    }
    public function get_nextHref($idArray, $idetudiant)
    {
        $keys =array_keys($idArray);
        $indexAct= array_search($idetudiant, $keys);
        $lastKey= count($keys)-1;
        if($indexAct<$lastKey){
            $nexthref = $idArray[$keys[$indexAct+1]]['href'];
        }else{
            $nexthref = $idArray[$keys[$indexAct]]['href'];
        }
        return $nexthref;
    }
    public function get_prevHref($idArray,$idetudiant)
    {
        $keys =array_keys($idArray);
        $indexAct= array_search($idetudiant, $keys);
        $lastKey= count($keys)-1;
        if ($indexAct>0) {
            $prevhref = $idArray[$keys[$indexAct-1]]['href'];
        }else{
            $prevhref = $idArray[$keys[$indexAct]]['href'];
        }
        return $prevhref;
    }
}

?>
