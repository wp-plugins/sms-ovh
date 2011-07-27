<?php
global $wpdb;
$table_name3 = $wpdb->prefix . "sms_ovh_messages";
$table_name4 = $wpdb->prefix . "sms_ovh_historique";
?>
        <div id="icon-upload" class="icon32"></div>
		<h2>Ajouter un message</h2>
        
        <?php
		
		if ($_POST['action']=="smsovh_ajout_message")
			{
			$wpdb->query("INSERT INTO ".$table_name3." SET 
					message='".$_POST['smsovh_message']."'");		
			?>
			<div id="message" class="updated"><p>Le message a été enregistré !</p></div>
			<?php			
			}
			
			
		if ($_REQUEST['action']=="smsovh_supp" and $_GET['smsovh_supp']>0)
			{
			// verif si message déjà envoyé	
			$resultnb=$wpdb->query("SELECT id FROM ".$table_name4." WHERE id_message='".$_GET['smsovh_supp']."'");
			if ($resultnb>0)
				{
				// on ne supprime pas	
				?>
				<div id="message" class="error"><p>Le message fait parti de l'historique, impossible de le supprimer !</p></div>
				<?php
				}
			else
				{
				// supp
				$wpdb->query("DELETE FROM ".$table_name3." WHERE id='".$_GET['smsovh_supp']."'");	
				?>
				<div id="message" class="error"><p>Le message a été supprimé de la base !</p></div>
				<?php	
				}
			}
        ?>
        
         <div class="metabox-holder">
            <div class="postbox">
            
                <h3 class="hndle"><span>Messages</span></h3>
                <div style="margin:20px;">
                 <table class="widefat">
                <thead>
                	<tr>
                    	<th>Id</th>
                        <th>Message</th>                      
                        <th>Supprimer</th>
                     </tr>
                </thead>
                <tfoot>
                	<tr>
                    	<th>Id</th>
                        <th>Message</th>                        
                        <th>Supprimer</th>
                     </tr>
                </tfoot>
                <tbody>
                
                 <?php
				$requete=$wpdb->get_results("SELECT * FROM ".$table_name3,"ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					?>
                <tr>                
                <td><?php echo $contenu['id']; ?></td>
                <td><?php echo $contenu['message']; ?></td>
                <td><a href="?page=<?php echo $_REQUEST['page']; ?>&smsovh_supp=<?php echo $contenu['id']; ?>&action=smsovh_supp">Supprimer</a></td>
                </tr><?php
					}
					?>
					
                
                 </tbody>
                </table>
                </div>
            </div>
            
            
            
            
            <div class="postbox">
                <h3 class="hndle"><span>Ajouter un nouveau message</span></h3>
                <div style="margin:20px;">
                 <form id="form1" name="form1" method="post" action="">
                 <p><label>Message</label><br />
 				 <small>Maximum 160 caractères</small></p>
                <p><input name="smsovh_message" type="text" size="60" maxlength="160" /></p>
                 
                 
                 <input type="hidden" name="action" value="smsovh_ajout_message" />
                 <input type="submit" class="button-primary" name="submit" value="Ajouter">
                 
                 </form>                
                </div>
            </div>
         </div>


		