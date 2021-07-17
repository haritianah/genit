<?php
/**
 *
 */
class model_note extends CI_Model
{
    public $nombre =0;
    /**
     * @param $id
     * @param string $idmat
     * @return array
     */
    public function get_note($id, $idmat ='',$annee='')
    {
        $this->db->where("id_etudiant",$id);
        if (!empty($idmat)){
            $this->db->where('id_matiere',$idmat);
        }
        if (!empty($annee)) {
            $this->db->where('annee_etude',$annee);
        }
      $query=  $this->db->get('notes');
        return $query->result();
    }

    /**
     * @param $code
     * @return array
     */
    public function get_noteByCode($code)
    {
        $this->db->where('code_note',$code);
        $query = $this->db->get('notes');
        return $query->row();
    }
	public function get_noteParam($param, $result=true,$join=false)
	{
		if ($join===true){
			$this->db->join('etudiant','etudiant.id_etudiant=notes.id_etudiant');
			$this->db->join('matiere','matiere.id_matiere=notes.id_matiere');
			$this->db->select('notes.*,nom,prenom,matiere.*');
		}
		$query = $this->db->get_where('notes',$param);
		return $result==true ? $query->result() : $query;
	}
    private function q_update($code,$note)
    {
        if ($note >=0 && $note<=20){
            $this->db->set('notes',$note);
            $this->db->set('noteO',$note);
            $this->db->set('lastup',"NOW()",FALSE);
            $this->db->where('code_note',$code);
            $this->db->update('notes');
        }
    }

    private function q_delib($code,$note)
    {
        if ($note>=0 && $note<=20){
            $this->db->set('notes',$note);
            $this->db->set('lastup','NOW()',false);
            $this->db->where('code_note',$code);
            $this->db->update('notes');
        }

    }

    private function q_delete($code,$resmat = false)
    {
        if ($resmat==true){
            $obj_note = $this->get_noteByCode($code);
            //Delete resmat
            $this->db->where('id_etudiant',$obj_note->id_etudiant);
            $this->db->where('id_matiere',$obj_note->id_matiere);
            $this->db->delete('resultat_matiere');
            //Delete note
            $this->db->where('code_note',$code);
            $this->db->delete('notes');
        }else{
            $this->db->where('code_note',$code);
            $this->db->delete('notes');
        }
    }
    public function update_note($code,$note,$json=false)
    {
        $obj_note = $this->get_noteByCode($code);
        $etudiant = $this->model_etudiants->get_info_etudiant($obj_note->id_etudiant);
        ob_start();
        ?>
        <script>
            $('#noteO').val($('#note').val());
        </script>
        <?php
        $script = ob_get_clean();
        if($etudiant->annee_etude == $obj_note->annee_etude){
            //Error Notes Check
            if (!is_numeric($note) || $note > 20 || $note<0){
                if ($json==false){
                    die('ERROR');
                }else{
                    $data['color'] = 'red';
                    echo json_encode($data);
                }
                exit();
            }
            //
            if ($obj_note->session=="normale"){
                //Check Rattrapage
                $param = array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$obj_note->id_matiere,'session'=>'rattrapage',
                    'annee_etude'=>$obj_note->annee_etude);
                $countNoteRattr = $this->get_noteParam($param,false)->num_rows();
                //QUERY
                if ($countNoteRattr==0){
                    $this->q_update($code,$note);
                    if ($json==false){
                        echo $script;
                        die('SUCCESS');
                    }else{
                        $data['color'] = 'green';
                        echo json_encode($data);
                    }
                }
                elseif ($countNoteRattr != 0 && $note<10){
                    $this->q_update($code,$note);
                    if ($json==false){
                        echo $script;
                        die('SUCCESS');
                    }else{
                        $data['color'] = 'green';
                        echo json_encode($data);
                    }
                }else{
                    if ($json==false){
                        die("XXXXXXXXXXXX");
                    }else{
                        $data['color'] = 'red';
                        echo json_encode($data);
                    }

                }
            }elseif ($obj_note->session=='rattrapage'){
                $this->q_update($code,$note);
                if ($json==false){
                    echo $script;
                    die('SUCCESS');
                }else{
                    $data['color'] = 'green';
                    echo json_encode($data);
                }
            }
        }
    }

    public function delib_note($code,$note)
    {
        $obj_note = $this->get_noteByCode($code);
        $etudiant = $this->model_etudiants->get_info_etudiant($obj_note->id_etudiant);
        if($etudiant->annee_etude == $obj_note->annee_etude){
            if ($obj_note->session =='normale'){
                //Check Rattrapage
                $param = array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$obj_note->id_matiere,'session'=>'rattrapage',
                    'annee_etude'=>$obj_note->annee_etude);
                $countNoteRattr = $this->get_noteParam($param,false)->num_rows();
                //QUERY
                if ($countNoteRattr==0){
                    if ($note>=0 && $note <=20){
                        $this->q_delib($code,$note);
                        die('SUCCESS');
                    }
                }else{
                    die("XXXXXXXXXXXX");
                }
            }elseif ($obj_note->session=='rattrapage'){
                if ($note>=0 && $note <=20){
                    $this->q_delib($code,$note);
                    die('SUCCESS');
                }
            }
        }
    }

    public function delete_note($code, $note)
    {
        $obj_note = $this->get_noteByCode($code);
        $etudiant = $this->model_etudiants->get_info_etudiant($obj_note->id_etudiant);
        if($etudiant->annee_etude == $obj_note->annee_etude){
          if ($obj_note->session=='normale'){
              //Check Rattrapage
              $param = array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$obj_note->id_matiere,'session'=>'rattrapage',
                  'annee_etude'=>$obj_note->annee_etude);
              $countNoteRattr = $this->get_noteParam($param,false)->num_rows();
              //QUERY
              if ($countNoteRattr==0){
                  $this->q_delete($code,true);
                  die('Note supprimée');
              }else{
                  die("XXXX--NOTE DE RATTRAPAGE EXISTENTE");
              }
          }elseif ($obj_note->session=='rattrapage'){
              $this->q_delete($code,true);
              die('Note supprimée');
          }
        }
    }


    public function insert_note($param, $update=false){
        if($param['notes'] >=0 && $param['notes']<=20){
            $text_upate = $update==false ? "ON DUPLICATE KEY UPDATE code_note=code_note" : "ON DUPLICATE KEY UPDATE notes=".$param['notes'].",noteO=".$param['noteO'];
            $sql = $this->db->insert_string('notes',$param).$text_upate;
            $this->db->query($sql);
        }

    }
    /**
     * @param int $nombre
     */
    public function get_credt_unite($idunit)
    {
        $this->db->select("SUM(credit) as totCredt");
        $this->db->where('id_unite',$idunit);
        $query = $this->db->get('matiere');
        return $query->row()->totCredt;
    }
    /**
     * @param $obj_etudiant
     * @param $idunit id_unite
     * @param $session
     * @return count Elimination UE
     */
    public function get_elim($obj_etudiant, $idunit, $session)
  {
    $this->db->select("code_note");
    $this->db->where(array('id_etudiant'=>$obj_etudiant->id_etudiant,'id_unite'=>$idunit, "annee_etude"=>$obj_etudiant->annee_etude,
              "session"=>$session, "notes<="=>4, "notes>"=>0));
    $query = $this->db->get("notes");
    return $query->num_rows();
  }

    /**
     * @param $obj_etudiant
     * @param $idunit
     * @param $session
     * @return count Defaillant UE
     */
    public function get_defail($obj_etudiant, $idunit, $session)
    {
        $this->db->select("code_note");
        $this->db->where(array('id_etudiant'=>$obj_etudiant->id_etudiant,'id_unite'=>$idunit, "annee_etude"=>$obj_etudiant->annee_etude,
            "session"=>$session, "notes"=>0));
        $query = $this->db->get("notes");
        return $query->num_rows();
    }

    /**
     * @param $idet
     * @param $idmat
     * @return int
     */
    public function get_limitNote($idet, $idmat){
        $this->db->where('id_etudiant',$idet);
        $this->db->where('id_matiere',$idmat);
        $query = $this->db->get('notes');
        return $query->num_rows();
    }

    /**
     * @param $idet
     * @param $session
     * @param $idmat
     * @param $annee
     * @return mixed
     */
    public function get_lastnote($idet, $session, $idmat, $annee)
    {
       $sql="SELECT * from notes where id_etudiant = ? and session=? and id_matiere=? and annee_etude=? and not exists(select * from notes n2 where notes.id_etudiant
              = n2.id_etudiant and notes.id_matiere = n2.id_matiere and notes.session = n2.session and n2.annee_etude>notes.annee_etude)";
       $tab = array($idet,$session,$idmat,$annee);

       $query= $this->db->query($sql,$tab);
        if($query->num_rows()==0){
            $sql="SELECT * from notes where id_etudiant = ? and session=? and id_matiere=? and not exists(select * from notes n2 where notes.id_etudiant
              = n2.id_etudiant and notes.id_matiere = n2.id_matiere and notes.session = n2.session and n2.annee_etude>notes.annee_etude)";
            $tab = array($idet,$session,$idmat);
            $query = $this->db->query($sql,$tab);
        }
        return $query->row();
    }
    public function get_resmat($param,$result=true)
    {
        $this->db->join('unites','unites.id_unite= resultat_matiere.id_unite');
        $query = $this->db->get_where('resultat_matiere',$param);

        return $result==true ? $query->result() : $query;
    }
    public function get_resmatByMatiere($idetudiant,$idmatiere)
    {
        $this->db->where('id_etudiant',$idetudiant);
        $this->db->where('id_matiere',$idmatiere);
        $query= $this->db->get('resultat_matiere');
        return $query->row();
    }
    public function calc_resmatEtd($obj_etudiant)
    {
        $sql=("INSERT into `resultat_matiere` (id_etudiant, id_matiere, id_unite, resultat, annee_etude)
             select id_etudiant, id_matiere, id_unite,resultat,annee_etude from(select n1.*, case
                when n1.notes>=10 then'ACQ'
                else 'AJN'
                end
                as resultat from notes n1 where n1.id_etudiant =? and not exists (select code_note from notes n2 where n1.id_etudiant=n2.id_etudiant
            and n1.id_matiere= n2.id_matiere and n2.code_note> n1.code_note and n1.annee_etude=n2.annee_etude)
            and n1.annee_etude=? order by n1.id_etudiant ASC, n1.id_matiere ASC)
            tab where annee_etude =? on duplicate key update resultat = tab.resultat, annee_etude= tab.annee_etude ");
        $tab = array($obj_etudiant->id_etudiant,$obj_etudiant->annee_etude,$obj_etudiant->annee_etude);

        return ($this->db->query($sql, $tab));
    }

    /**
     * @param int $nombre
     */
    public function calc_resmatGlobMatiere($idmat,$annee)
    {
        $sql=("INSERT into `resultat_matiere` (id_etudiant, id_matiere, id_unite, resultat, annee_etude)
 select id_etudiant, id_matiere, id_unite,resultat,annee_etude from(select n1.*, case
    when n1.notes>=10 then'ACQ'
    else 'AJN'
    end
    as resultat from notes n1 where n1.id_matiere =? and not exists (select code_note from notes n2 where n1.id_etudiant=n2.id_etudiant
and n1.id_matiere= n2.id_matiere and n2.code_note> n1.code_note and n1.annee_etude=n2.annee_etude)
and n1.annee_etude=? order by n1.id_etudiant ASC, n1.id_matiere ASC)
tab where annee_etude =? on duplicate key update resultat = tab.resultat, annee_etude= tab.annee_etude ");
        $tab=array($idmat,$annee,$annee);

        return ($this->db->query($sql,$tab));
    }

    public function get_listeNoteEtudiant($post)
    {
        $this->db->select("*,notes.annee_etude as annee");
        $this->db->from('etudiant');
        $this->db->join('notes','notes.id_etudiant=etudiant.id_etudiant');
        $this->db->where('id_matiere',$post['matiere']);
        $this->db->where('notes.annee_etude',$post['annee']);
        $this->db->order_by("etudiant.id_etudiant,session","ASC");
        $query = $this->db->get();
        return $query->result();
    }
}


 ?>
