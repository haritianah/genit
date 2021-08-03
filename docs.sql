CREATE DEFINER=`root`@`localhost` PROCEDURE `backup_etdiant_maj`()
BEGIN
CREATE TABLE if not exists `tmp_etudiant` (
  `id_etudiant` varchar(250) NOT NULL,
  `num_etudiant` varchar(8) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `sexe` varchar(10) NOT NULL,
  `naissance` date NOT NULL,
  `lieu` varchar(35) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `telephone` int(11) NOT NULL,
  `niveau` varchar(4) NOT NULL,
  `annee_etude` int(4) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `etat` enum('P','Red','Rat') NOT NULL DEFAULT 'P',
  `old` enum('t','f') NOT NULL DEFAULT 'f',
  `inscrit` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`id_etudiant`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

truncate tmp_etudiant;

insert into tmp_etudiant select * from etudiant;
END


#
update login set password = '$2y$12$3S/bhK3iHk7gh/OP10ho5eRhXxoyTzTGVD.JySuCQFvwEp.W26rEq' where id_log=102;