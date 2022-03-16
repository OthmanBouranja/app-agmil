CREATE TABLE `sma_controle` (
  `id` int(11) NOT NULL,
  `date` timestamp NULL,
  `immatriculation` int(11) NULL,
  `marque` varchar(100),
  `kilometrage` int (100) NULL,
  `dealtis_car` varchar(100) NOT NULL,
  `entretien` varchar(100) NULL,
  `piece` varchar(100) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sma_controle` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);


CREATE TABLE `sma_controle_car` (
  `id` int(11) NOT NULL,
  `id_controle` int (11) NULL,
  `pneu_avd` varchar(30) NULL,
  `pneu_avg` varchar(30) NULL ,
  `pneu_ard` varchar(30) NULL ,
  `pneu_arg` varchar(30) NULL ,
  `jante_avd` varchar(30) NULL ,
  `jante_avg` varchar(30) NULL ,
  `jante_ard` varchar(30) NULL ,
  `jante_arg` varchar(30) NULL ,
  `siege_avg` varchar(30) NULL ,
  `siege_avd` varchar(30) NULL ,
  `siege_arg` varchar(30) NULL ,
  `siege_ard` varchar(30) NULL ,
  `banquettes` varchar(30) NULL ,
  `moquettes` varchar(30) NULL ,
  `ciel_de_toit` varchar(30) NULL ,
  `niv_carburant` varchar(30) NULL ,
  `phare_avant` varchar(30) NULL ,
  `anti_brouillard` varchar(30) NULL ,
  `clignotant_retro` varchar(30) NULL ,
  `optique_arriere` varchar(30) NULL ,
  `vitre_avant` varchar(30) NULL ,
  `vitre_arriere` varchar(30) NULL ,
  `carte_grise` varchar(30) NULL ,
  `assurance` varchar(30) NULL ,
  `carnet_entretien` varchar(30) NULL ,
  `livre_bord` varchar(30) NULL ,
  `constat` varchar(30) NULL ,
  `kit_secours` varchar(30) NULL ,
  `double_clefs` varchar(30) NULL ,
  `roue_secours` varchar(30) NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sma_controle_car` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);



CREATE TABLE `sma_controle_abimes` (
  `id` int(11) NOT NULL,
  `id_controle` int (11) NULL,
  `pv_av` varchar(30) NULL,
  `capot` varchar(30) NULL ,
  `aile_avg` varchar(30) NULL ,
  `porte_avg` varchar(30) NULL ,
  `porte_arg` varchar(30) NULL ,
  `aile_arg` varchar(30) NULL ,
  `bas_caisse_g` varchar(30) NULL ,
  `jante_avg2` varchar(30) NULL ,
  `jante_arg2` varchar(30) NULL ,
  `retroviseur_g` varchar(30) NULL,
  `enjoliveur_pc_av` varchar(30) NULL ,
  `baguette_porte_avg` varchar(30) NULL ,
  `baguette_porte_arg` varchar(30) NULL ,
  `enjoliveur_aile_avg` varchar(30) NULL ,
  `enjoliveur_aile_arg` varchar(30) NULL ,
  `pare_brise` varchar(30) NULL ,
  `lunette_arriere` varchar(30) NULL ,
  `balais_essuie_glace_av` varchar(30) NULL ,
  `pc_ar` varchar(30) NULL ,
  `coffre` varchar(30) NULL ,
  `aile_avd` varchar(30) NULL ,
  `porte_avd` varchar(30) NULL ,
  `porte_ard` varchar(30) NULL ,
  `aile_ard` varchar(30) NULL ,
  `bas_de_caisse_jante` varchar(30) NULL ,
  `avd` varchar(30) NULL ,
  `jante_ard2` varchar(30) NULL ,
  `retriviseur_d` varchar(30) NULL ,
  `calandre` varchar(30) NULL ,
  `baguette_porte_avd` varchar(30) NULL ,
  `baguette_porte_ard` varchar(30) NULL ,
  `baguette_aile_avd` varchar(30) NULL ,
  `baguette_aile_ard` varchar(30) NULL ,
  `toit_ouvrant` varchar(30) NULL ,
  `toit_panoramique` varchar(30) NULL ,
  `balais_essuie_glace_av_2` varchar(30) NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `sma_controle_abimes` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);



