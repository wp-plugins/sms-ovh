<?php
global $wpdb;
$table_name = $wpdb->prefix . "sms_ovh_categories";
$table_name2 = $wpdb->prefix . "sms_ovh_numeros";	
$table_name4 = $wpdb->prefix . "sms_ovh_historique";
?>
        <div id="icon-themes" class="icon32"></div>
		<h2>Base de données</h2>
  <?php
  	
if ($_POST['action']=="smsovh_ajout_cat")
			{			
			$wpdb->query("INSERT INTO ".$table_name." SET titre_categorie='".$_POST['smsovh_categorie']."'");		
			?>
            <div id="message" class="updated"><p>La base de données a été crée !</p></div>
            <?php														
			}

if ($_GET['smsovh_supp']>0)
	{
		
	// verif si message déjà envoyé	
	$resultnb=$wpdb->query("SELECT id FROM ".$table_name4." WHERE id_base='".$_GET['smsovh_supp']."'");
	if ($resultnb>0)
		{
		// on ne supprime pas	
		?>
		<div id="message" class="error"><p>La base fait partie de l'historique, impossible de le supprimer !</p></div>
		<?php
		}
	else
		{
		?>
		<div id="message" class="error"><p>Vous devez confirmer la suppression de cette base de données et de son contenu : <a href="?page=<?php echo $_REQUEST['page']; ?>&smsovh_supp2=<?php echo $_GET['smsovh_supp']; ?>">CONFIRMEZ LA SUPPRESSION</a> ou <a href="?page=<?php echo $_REQUEST['page']; ?>">ANNULER</a></p></div>
		<?php	
		}
	}
	
if ($_GET['smsovh_supp2']>0)
	{
	// supression
	$wpdb->query("DELETE FROM ".$table_name2." WHERE base='".$_GET['smsovh_supp2']."'");	
	$wpdb->query("DELETE FROM ".$table_name." WHERE id_categorie='".$_GET['smsovh_supp2']."'");	
	
	?>
    <div id="message" class="error"><p>La base de données et son contenu a été supprimé !</p></div>
    <?php			
	}
		?>
 
        <form id="form1" name="form1" method="post" action="">
         <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle"><span>Ajouter une base de données</span></h3>
                <div style="margin:20px;">
                
                <ul>
                
                <li>
                    <label for="smsovh_categorie">Nom de la base de données </label>
                    <input type="text" name="smsovh_categorie" id="smsovh_categorie" /></li>             
               
                </ul>

                 <input type="hidden" name="action" value="smsovh_ajout_cat" />         
            	<div class="submit"><input type="submit" class="button-primary" name="submit" value="Ajouter"></div>
            
           
                
                </div>
            </div> 
         </div>
         </form>  
   
        
        
        
        <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle"><span>Base de données</span></h3>
                <div style="margin:20px;"> 
                
                <table class="widefat">
                <thead>
                	<tr>
                    	<th>Id</th>
                        <th>Nom de la base de données</th>                      
                        <th>Supprimer</th>
                     </tr>
                </thead>
                <tfoot>
                	<tr>
                    	<th>Id</th>
                        <th>Nom de la base de données</th>                        
                        <th>Supprimer</th>
                     </tr>
                </tfoot>
                <tbody>
                <?php
				$requete=$wpdb->get_results("SELECT * FROM ".$table_name,"ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					?>
                    <tr>
                    	<td><?php echo $contenu['id_categorie']; ?></td>
                        <td><?php echo $contenu['titre_categorie']; ?></td>                       
                        <td><a href="?page=<?php echo $_REQUEST['page']; ?>&smsovh_supp=<?php echo $contenu['id_categorie']; ?>">Supprimer</a></td>
                    </tr>       
                    <?php	
					}
				
				?>
                
                
                	         
                </tbody>
                </table>
               
               
                
                </div>
            </div> 
         </div> 
