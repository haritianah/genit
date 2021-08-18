  
#Update ID

update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'RAKM97512401',
    rm.id_etudiant = 'RAKM97512401',
    d.id_etudiant = 'RAKM97512401',
    e.id_etudiant = 'RAKM97512401'
    
    where e.id_etudiant ='RAKM57512401';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'SANF98591501',
    rm.id_etudiant = 'SANF98591501',
    d.id_etudiant = 'SANF98591501',
    e.id_etudiant = 'SANF98591501'
    
    where e.id_etudiant ='SANF58551501';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'ROBA98601301',
    rm.id_etudiant = 'ROBA98601301',
    d.id_etudiant = 'ROBA98601301',
    e.id_etudiant = 'ROBA98601301'
    
    where e.id_etudiant ='ROBA986011301';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'NOAN97560901',
    rm.id_etudiant = 'NOAN97560901',
    d.id_etudiant = 'NOAN97560901',
    e.id_etudiant = 'NOAN97560901'
    
    where e.id_etudiant ='NOAN95560901';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'RAJM01082901',
    rm.id_etudiant = 'RAJM01082901',
    d.id_etudiant = 'RAJM01082901',
    e.id_etudiant = 'RAJM01082901'
    
    where e.id_etudiant ='RAJM01082801';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'RANN01580801',
    rm.id_etudiant = 'RANN01580801',
    d.id_etudiant = 'RANN01580801',
    e.id_etudiant = 'RANN01580801'
    
    where e.id_etudiant ='RANM01580801';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'RAZA99092101',
    rm.id_etudiant = 'RAZA99092101',
    d.id_etudiant = 'RAZA99092101',
    e.id_etudiant = 'RAZA99092101'
    
    where e.id_etudiant ='RAZA99052101';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'RAVM97572701',
    rm.id_etudiant = 'RAVM97572701',
    d.id_etudiant = 'RAVM97572701',
    e.id_etudiant = 'RAVM97572701'
    
    where e.id_etudiant ='RAVM';
update etudiant e inner join notes n on e.id_etudiant = n.id_etudiant 
 inner join resultat_matiere rm on rm.id_etudiant = e.id_etudiant 
    inner join decision d on e.id_etudiant = d.id_etudiant 
    set n.id_etudiant = 'ANDN00552501',
    rm.id_etudiant = 'ANDN00552501',
    d.id_etudiant = 'ANDN00552501',
    e.id_etudiant = 'ANDN00552501'
    
    where e.id_etudiant ='ANDN005852501';
    
#to mikajy
update etudiant set annee_etude = 2020 where id_etudiant = 'ANDT89110401';

#K3 to redoub L2

delete from notes where id_etudiant = 'MIAR99121901' and annee_etude = 2020 and id_matiere in (select id_matiere from matiere m join unites u
	on u.id_unite = m.id_unite where u.niveau_unite  ='L3');

delete from resultat_matiere where id_etudiant = 'MIAR99121901' and annee_etude = 2020 and id_matiere in (select id_matiere from matiere m join unites u
	on u.id_unite = m.id_unite where u.niveau_unite  ='L3');

delete from decision where id_etudiant = 'MIAR99121901' and niveau_des ='L3';    
    
update etudiant set niveau = 'L2', etat = 'Red' where id_etudiant = 'MIAR99121901';    
