<?php
/*
Plugin Name: SMS OVH
Plugin URI: http://wordpress.org/extend/plugins/sms-ovh/
Description: SMS OVH.
Author: Loïc PIQUARD
Version: 0.1
Author URI: http://www.elyazalee.com/
*/

if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX )) 
	{
	add_action('admin_menu', 'smsovh_voir_options');	
	
	function smsovh_voir_options() 
		{		
		// ajout des options		
		add_option('smsovh_login', '');		
		add_option('smsovh_sms', '');
		add_option('smsovh_passe', '');
		add_option('smsovh_expediteur', '');
		// creation menu
		add_menu_page('SMS OVH', 'SMS OVH', 'manage_options', 'sms-ovh-general', 'sms_ovh_options');
		add_submenu_page('sms-ovh-general', 'Bases de données', 'Bases de données','manage_options', 'sms_ovh_menu_cat', 'sms_ovh_categorie');
		add_submenu_page('sms-ovh-general', 'Numéros', 'Numéros','manage_options', 'sms_ovh_menu_ajout', 'sms_ovh_ajout');
		add_submenu_page('sms-ovh-general', 'Messages', 'Messages','manage_options', 'sms_ovh_ajoutmsg', 'sms_ovh_ajoutmsg');
		add_submenu_page('sms-ovh-general', 'Envoyer', 'Envoyer','manage_options', 'sms_ovh_menu_sent', 'sms_ovh_sent');
		
		// tables		
		function create_table_wp_sms_ovh () 
			{
			global $wpdb;
			// On construit le nom de la table avec le préfixe de WordPress
			$table_name = $wpdb->prefix . "sms_ovh_categories";
			$table_name2 = $wpdb->prefix . "sms_ovh_numeros";
			$table_name3 = $wpdb->prefix . "sms_ovh_messages";
			$table_name4 = $wpdb->prefix . "sms_ovh_historique";
			// On teste la présence de la table
			if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
				{
				// On construit la requête SQL avec le nom de la table
				$sql = "
						
						CREATE TABLE  " . $table_name . " (
						`id_categorie` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						`titre_categorie` TINYTEXT NOT NULL ,
						`description_categorie` TEXT NOT NULL ,
						`ordre_categorie` INT NOT NULL ,
						INDEX (  `ordre_categorie` )
						) ENGINE = MYISAM ;
						";
						
						// On crée la seconde table
				$sql2 = "
						CREATE TABLE  " . $table_name2 . " (
						`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
						`base` INT NOT NULL ,
						`numero` TINYTEXT NOT NULL ,
						INDEX (  `base` )
						) ENGINE = MYISAM ;
						";	
						// et la troisieme... 
				$sql3 = "
						CREATE TABLE  " . $table_name3 . "  (
						`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,						
						`message` TINYTEXT NOT NULL
						) ENGINE = MYISAM ;
						";	
						// bon et une quatrième...	c'est gratuit... alors on profite...					
				$sql4 = "
					CREATE TABLE  " . $table_name4 . "  (
					`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`id_message` INT NOT NULL ,
					`id_base` INT NOT NULL ,
					`date` DATETIME NOT NULL ,
					`nombre` INT NOT NULL,
					INDEX (  `id_message` ,  `id_base` )
					) ENGINE = MYISAM ;
					";
						
						// On inclut une librairie de WordPress contenant la fonction dbDelta.
						//La librairie n'est pas lancée depuis la partie client, raison pour laquelle
						//on prend cette précaution.
						require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
						// On exécute la requête SQL.
						dbDelta($sql);
						dbDelta($sql2);
						dbDelta($sql3);
						dbDelta($sql4);
				}
				
	
			}
		
		create_table_wp_sms_ovh();

		}


	function sms_ovh_options()
		{
		include_once dirname( __FILE__ ) . '/sms-ovh-options.php';
		}
		
	function sms_ovh_categorie()
		{
		include_once dirname( __FILE__ ) . '/sms-ovh-categorie.php';		
		}
		
	function sms_ovh_ajout()
		{
		include_once dirname ( __FILE__) . '/sms-ovh-ajout.php';			
		}
	function sms_ovh_ajoutmsg()
		{
		include_once dirname ( __FILE__) . '/sms-ovh-ajoutmsg.php';			
		}
	function sms_ovh_sent()
		{
		include_once dirname( __FILE__ ) . '/sms-ovh-sent.php';
		}
	}

?>