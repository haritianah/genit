<?php 
/**
* 
*/
class app extends CI_Model
{
	
	//----
	public static function connect($redirect=false){
			if(isset($_SESSION['auth']) && !empty($_SESSION['auth']->user)){
				return true;
			}else{
			    if ($redirect===true){
			        redirect('login');
                }
				return false;
			}
				
	}
	public static function adminCon($an){
			if(isset($_SESSION['auth']) && $_SESSION['auth']->user=="admin"){
				if($an==9){
					return true;
				}else{
					$req =$GLOBALS['bd']->query('SELECT COUNT(annee_etude) AS counteur, annee_etude FROM etudiant GROUP BY annee_etude ORDER BY counteur DESC
							LIMIT 1;');
					$freq=$req->fetch();
					if ($freq->annee_etude==$an){
						return true;
					}
				}
				
				
			}
	}
	public function niveau($url,$sufix=""){
		if(!empty($sufix)){
			$sufix="/".$sufix;
		}
		
		?>
		<b><P class="nivc">CHOISIR NIVEAU D'ETUDE</P></b>
		<div style="margin-left:100px;">
			<div id="niv">
				<ul>
					<li class="active"><?= anchor($url.$sufix."/L1","L1") ?></li>
					<li><?= anchor($url.$sufix."/L2","L2") ?></li>
					<li><?= anchor($url.$sufix."/L3","L3") ?></li>
					<li><?= anchor($url.$sufix."/M1","M1") ?></li>
					<li><?= anchor($url.$sufix."/M2","M2") ?></li>
				</ul>
			</div>
		</div>

		<?php
	}
    public function semestre($url,$semestres){
       $semestre1 = $semestres[0]->semestre;
       $semestre2 = $semestres[1]->semestre;

        ?>
        <b><P class="nivc">CHOISIR NIVEAU D'ETUDE</P></b>
        <div style="margin-left:100px;">
            <div id="niv">
                <ul>
                    <li class="active"><?= anchor($url."/".$semestre1,$semestre1) ?></li>
                    <li><?= anchor($url."/".$semestre2,$semestre2) ?></li>

                </ul>
            </div>
        </div>

        <?php
    }
    public function getNivBySemestre($semestre){
        $this->db->select('niveau_unite');
        $this->db->where('semestre',$semestre);
        $query = $this->db->get('unites');
        return $query->row();
    }
    public function getNivByUnite($unite){
        $this->db->select('niveau_unite');
        $this->db->where('id_unite',$unite);
        $query = $this->db->get('unites');
        return $query->row();
    }

    public function session_msg()
    {
        if (isset($_SESSION['flash'])){
            $key = key($_SESSION['flash']);
            echo "<div class='alert alert-$key'>";
            foreach ($_SESSION['flash'] as $flash) {
                if (is_array($flash)):
                    foreach ($flash as $flash_s) {
                        echo "<p>$flash_s</p>";
                    }
                else:
                    echo "<p>$flash</p>";
                endif;
            }
            echo '</div>';
            unset($_SESSION['flash']);
        }
    }

}

 ?>