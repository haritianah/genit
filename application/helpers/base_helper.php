<?php
function get_niv2($niv){
	switch ($niv) {
			case 'L1':
				$niv2='L2';
				break;
			case 'L2':
				$niv2='L3';
				break;
			case 'L3':
				$niv2='M1';
				break;
			case 'M1':
				$niv2='M2';
				break;
			case 'M2':
				$niv2='M2';
				break;
			default:
				$niv2="";
				break;
		}
	return $niv2;
}
function debug($value)
	{
		echo "<pre>". print_r($value	, true) ."</pre>";
	}
function get_niv(){
	return array("L1","L2","L3","M1","M2");
}
function get_nivAnte($niv){
    $niveau;
    switch ($niv){
        case "L1" : $niveau="L1";
            break;
        case "L2" : $niveau="L1";
            break;
        case "L3" : $niveau="L2";
            break;
        case "M1" : $niveau="L3";
            break;
        case "M2" : $niveau="M1";
            break;
    }
    return $niveau;
}
function get_semestre_impair(){
    return array("S1","S3","S5","S7","S9");
}
function get_semestre_pair(){
    return array("S2","S4","S6","S8","S10");
}
function limit($nombre){
    $acquis=60*$nombre/100;
    $acquis=round($acquis);
    return $acquis;
}
function affichecolor($inscrit){
    if ($inscrit==0){
        echo "style ='color : red'";
    }
}
function nonInscrit($inscrit){
    if(!$inscrit){
        die("Non inscrit");
    }
}
function convertir($Montant)
{
    $grade = array(0 => "zero ",1=>" milliards ",2=>" millions ",3=>" mille ");
    $Mon = array(0=>" Euro",1=>" Euros",2=>" Cent",3=>" Cents");

    // Mise au format pour les chéques et le SWI
    $Montant = number_format($Montant,2,".","");

    if ($Montant == 0)
    {
        $result = $grade[0].$Mon[0];
    }else
    {
        $result = "";

        // Calcule des Unités
        $montant = intval($Montant);

        // Calcul des centimes
        $centime = round(($Montant * 100) - ($montant * 100),0);

        // Traitement pour les Milliards
        $nombre = $montant / 1000000000;
        $nombre = intval($nombre);
        if ($nombre > 0)
        {
            if ($nombre > 1)
            {
                $result = $result.cenvtir($nombre).$grade[1];
            }else
            {
                $result = $result." Un ".$grade[1];
                $result = substr($result,0,13)." ";
            }
            $montant = $montant - ($nombre * 1000000000);
        }

        // Traitement pour les Millions
        $nombre = $montant / 1000000;
        $nombre = intval($nombre);
        if ($nombre > 0)
        {
            if ($nombre > 1)
            {
                $result = $result.cenvtir($nombre).$grade[2];
            }else
            {
                $result = $result." Un ".$grade[2];
                $result = substr($result,0,12)." ";
            }
            $montant = $montant - ($nombre * 1000000);
        }

        // Traitement pour les Milliers
        $nombre = $montant / 1000;
        $nombre = intval($nombre);
        if ($nombre > 0)
        {
            if ($nombre > 1)
            {
                $result = $result.cenvtir($nombre).$grade[3];
            }else
            {
                $result = $result.$grade[3];
            }
            $montant = $montant - ($nombre * 1000);
        }

        // Traitement pour les Centaines & centimes
        $nombre = $montant;
        if ($nombre>0)
        {
            $result = $result.cenvtir($nombre);
        }
        // Traitement si le montant = 1
        if ((substr($result,0,7) == " et un " and strlen($result) == 7))
        {
            $result = substr($result,3,3);
            $result = $result;
            if (intval($centime) != 0)
            {
                $differ = cenvtir(intval($centime));
                if (substr($differ,0,7) == " et un ")
                {
                    if ($result == "")
                    {
                        $differ = substr($differ,3);
                    }
                    $result = $result." ".$differ;
                }else
                {
                    $result = $result." et ".$differ;
                }
            }
            // Traitement si le montant > 1 ou = 0
        }else
        {
            if ($result != "")
            {
                $result = $result;
            }
            if (intval($centime) != 0)
            {
                $differ = cenvtir(intval($centime));
                if (substr($differ,0,7) == " et un ")
                {
                    if ($result == "")
                    {
                        $differ = substr($differ,3);
                    }
                    $result = $result." ".$differ;
                }else
                {
                    if ($result != "")
                    {
                        $result = $result." et ".$differ;
                    }else
                    {
                        $result = $differ;
                    }
                }
            }
        }
    }
    return $result;
}
function cenvtir($Valeur)
{

    $code = "";
    //texte en clair
    $SUnit = array(1=>"et un ", 2=>"deux ", 3=>"trois ", 4=>"quatre ", 5=>"cinq ", 6=>"six ", 7=>"sept ", 8=>"huit ", 9=>"neuf ", 10=>"dix ", 11=>"onze ", 12=>"douze ", 13=>"treize ", 14=>"quatorze ", 15=>"quinze ", 16=>"seize ", 17=>"dix-sept ", 18=>"dix-huit ", 19=>"dix_neuf ");
    $sDiz = array(20=> "vingt ", 30=> "trente ", 40=>"quarante ", 50=>"cinquante ", 60=>"soixante ", 70=>"soixante dix ", 80=>"quatre vingt ", 90=>"quatre vingt dix ");

    if ($Valeur>99)
    {
        $N1= intval($Valeur/100);
        if ($N1>1)
        {
            $code = $code.$SUnit[$N1];
        }
        $Valeur = $Valeur - ($N1*100);
        if ($code != "")
        {
            if ($Valeur == 0)
            {
                $code = $code." cents ";
            }else
            {
                $code = $code." cent ";
            }
        }else
        {
            $code = " cent ";
        }
    }
    if ($Valeur != 0)
    {
        if ($Valeur > 19)
        {
            $N1 = intval($Valeur/10)*10;
            $code = $code.$sDiz[$N1];
            if (($Valeur>=70) and($Valeur<80)or($Valeur>=90))
            {
                $Valeur = $Valeur + 10;
            }
            $Valeur = $Valeur - $N1;
        }
        if ($Valeur > 0)
        {
            $code = $code." ".$SUnit[$Valeur];
        }
    }
    return $code;
}
?>
