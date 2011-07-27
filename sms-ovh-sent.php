<?php
global $wpdb;
$table_name = $wpdb->prefix . "sms_ovh_categories";	
$table_name3 = $wpdb->prefix . "sms_ovh_messages";
$table_name2 = $wpdb->prefix . "sms_ovh_numeros";
$table_name4 = $wpdb->prefix . "sms_ovh_historique";
?>
        <div id="icon-upload" class="icon32"></div>
		<h2>Envoyer</h2>
        
        
        <?php
		if ($_REQUEST['action']=="smsovh_post")
			{
			if ($_REQUEST['position']=="")
				{
				$_REQUEST['position']=0;
				
				// crea historique
				$wpdb->query("INSERT INTO ".$table_name4." SET 
									id_message='".$_REQUEST['smsovh_message']."',
									id_base='".$_REQUEST['smsovh_base']."',
									date=NOW()");	
									
				$_REQUEST['id_insert'] = $wpdb->insert_id;
				}

			// recupere le message
			$requete=$wpdb->get_results("SELECT * FROM ".$table_name3." WHERE id='".$_REQUEST['smsovh_message']."'","ARRAY_A");			
			foreach($requete as $resultat=>$contenu)
					{
					$message=$contenu['message'];
					}
			
			// recup le numero du destinataire actuel
			$requete=$wpdb->get_results("SELECT * FROM ".$table_name2." WHERE base='".$_REQUEST['smsovh_base']."' LIMIT ".$_REQUEST['position'].",1","ARRAY_A");				
			foreach($requete as $resultat=>$contenu)
					{
					$numero=$contenu['numero'];
					}
			if ($numero=="")
				{
				?>
                 <div id="message" class="error"><p>Le message a été envoyé à <?php echo $_REQUEST['position']; ?> destinataire(s) ! TERMINE</p></div>
                <?php	
				}
			else
				{

				// envoi le message
				
				
				try 
					{
					$soap = new SoapClient("https://www.ovh.com/soapi/soapi-re-1.24.wsdl");			
					//login
					$session = $soap->login(get_option('smsovh_login'), get_option('smsovh_passe'),"fr", false);		
					}
					catch(SoapFault $fault) { echo "ERREUR. Message : ".$fault;	exit; }
				
				
				
				$destinataire="+33".substr($numero,1,10);
				$expediteur="+33".substr(get_option('smsovh_expediteur'),1,10);
				$message=utf8_encode(stripslashes($message));
				
				try 
					{		
					// envoi du sms				
					$result = $soap->telephonySmsSend($session, get_option('smsovh_sms'), $expediteur, $destinataire, $message, "", "1", "", "");				
				
					} 
					catch(SoapFault $fault) { echo "ERREUR. Message : ".$fault;	exit;  	}
				
				 $soap->logout($session);
				
							
				// MAJ historique nb
				$wpdb->query("UPDATE ".$table_name4." SET 
									nombre=nombre+1
									WHERE
									id='".$_REQUEST['id_insert']."'");	
				
				?>
                 <div id="message" class="updated"><p>Le message a été envoyé à <?php echo $_REQUEST['position']; ?> destinataire(s). Veuillez patienter... redirection en cours....</p></div>
            	
                
               
				
                <SCRIPT LANGUAGE="JavaScript">
					 document.location.href="admin.php?page=<?php echo $_REQUEST['page']; ?>&position=<?php echo $_REQUEST['position']+1; ?>&action=<?php echo $_REQUEST['action']; ?>&smsovh_message=<?php echo $_REQUEST['smsovh_message']; ?>&smsovh_base=<?php echo $_REQUEST['smsovh_base']; ?>&id_insert=<?php echo $_REQUEST['id_insert']; ?>" 
				</SCRIPT>
                <?php
				
				}
			}
		
		
		?>
        
        
         <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle"><span>Historique</span></h3>
                <div style="margin:20px;">
                	
                    
                     <table class="widefat">
                <thead>
                	<tr>
                    	<th>Id</th>
                        <th>Message</th>                      
                        <th>Base</th>
                        <th>Date de l'envoi</th>
                        <th>Nombre</th>
                     </tr>
                </thead>
                <tfoot>
                	<tr>
                    	<th>Id</th>
                        <th>Message</th>                      
                        <th>Base</th>
                        <th>Date de l'envoi</th>
                        <th>Nombre</th>
                     </tr>
                </tfoot>
                <tbody>
                <?php
				$requete=$wpdb->get_results("SELECT * FROM ".$table_name4,"ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					$id_li=$contenu['id'];	
					$id_message=$contenu['id_message'];
					$id_base=$contenu['id_base'];
					$date=$contenu['date'];
					$nombre=$contenu['nombre'];	
					
					// recupere le message
					$requete=$wpdb->get_results("SELECT * FROM ".$table_name3." WHERE id='".$id_message."'","ARRAY_A");			
					foreach($requete as $resultat=>$contenu)
							{
							$message=$contenu['message'];
							}
							
					// recupere le nom de la base
					$requete=$wpdb->get_results("SELECT * FROM ".$table_name." WHERE id_categorie='".$id_base."'","ARRAY_A");			
					foreach($requete as $resultat=>$contenu)
							{
							$base=$contenu['titre_categorie'];
							}
					?>
                    <tr>
                    	<td><?php echo $id_li; ?></td>
                        <td><?php echo $message; ?></td>   
                        <td><?php echo $base; ?></td>                    
                        <td><?php echo $date; ?></td>
                        <td><?php echo $nombre; ?></td>
                    </tr>       
                    <?php	
					}
				
				?>
                
                
                	         
                </tbody>
                </table>
                    
                </div>
            </div>
            
            
            
            
            <div class="postbox">
                <h3 class="hndle"><span>Envoyer</span></h3>
                <div style="margin:20px;">
                 <form id="form1" name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>">
                 <p><label>Message</label><br />
 				 <small>Selectionnez le message à envoyer</small></p>
                <p><select name="smsovh_message" id="smsovh_message">
                   <?php
				   $requete=$wpdb->get_results("SELECT * FROM ".$table_name3,"ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					
					?>
                     <option value="<?php echo $contenu['id']; ?>"><?php echo $contenu['message']; ?></option>
                    <?php	
						
					}
				   
				   ?>
                    
                   </select></p>
                 
                 
                 <p><label>Destinataire</label><br/>
                 <small>Choisissez la base de destinataire</small><br />
                 <p>
                   <select name="smsovh_base" id="smsovh_base">
                   <?php
				   $requete=$wpdb->get_results("SELECT * FROM ".$table_name,"ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					
					?>
                     <option value="<?php echo $contenu['id_categorie']; ?>"><?php echo $contenu['titre_categorie']; ?></option>
                    <?php	
						
					}
				   
				   ?>
                    
                   </select>
                 </p>
                 
                   <input name="action" type="hidden" id="action" value="smsovh_post">
                   <input type="submit" class="button-primary" name="submit" value="Envoyer le message aux destinataires">
                 </form>                
                </div>
            </div>
         </div>


		