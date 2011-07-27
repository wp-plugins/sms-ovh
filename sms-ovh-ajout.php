<?php
global $wpdb;
$table_name = $wpdb->prefix . "sms_ovh_categories";
$table_name2 = $wpdb->prefix . "sms_ovh_numeros";	

?>
        <div id="icon-upload" class="icon32"></div>
		<h2>Ajouter un numéro</h2>
        <?php

if ($_GET['smsovh_supp']>0)
	{
	// supp
	$wpdb->query("DELETE FROM ".$table_name2." WHERE id='".$_GET['smsovh_supp']."'");	
	?>
    <div id="message" class="error"><p>Le numéro a été supprimé de la base !</p></div>
    <?php		
	}

if ($_POST['action']=="smsovh_ajout_numero")
	{
	// verif doublon
	$resultnum=$wpdb->query("SELECT id FROM ".$table_name2." WHERE 
						numero='".$_POST['smsovh_numero']."' AND
						base='".$_POST['smsovh_base']."'");	
		
	if (strlen($_POST['smsovh_numero'])<>10)
		{					
		?>
        <div id="message" class="error"><p>Vous devez saisir un numéro de téléphone de 10 chiffres !</p></div>
        <?php	
		}
	elseif ($resultnum>0)
		{
		?>
        <div id="message" class="error"><p>Le numéro est déjà dans la base de données !</p></div>
        <?php	
		}
	else
		{
		$wpdb->query("INSERT INTO ".$table_name2." SET 
					numero='".$_POST['smsovh_numero']."',
					base='".$_POST['smsovh_base']."'");		
		?>
		<div id="message" class="updated"><p>Le numéro a été ajouté dans la base !</p></div>
		<?php		
		}
	}
	
	?>
         <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle"><span>Ajout un numéro dans une base de données</span></h3>
                <div style="margin:20px;">
                 <form id="form1" name="form1" method="post" action="">
                <p><label>Numéro</label><br />
 				 <small>Numéro de téléphone mobile (10 chiffres)</small></p>
                <p><input  name="smsovh_numero" type="text" id="smsovh_numero" size="10" maxlength="10" /></p>
                 
                 
                <p><label>Base</label><br/>
                 <small>Choisissez la base dans laquelle ajouter le numéro</small><br />
                 <p>
                   <select name="smsovh_base" id="smsovh_base">
                   <?php
				   $requete=$wpdb->get_results("SELECT * FROM ".$table_name,"ARRAY_A");			
				$z=0;
				foreach($requete as $resultat=>$contenu)
					{
					if ($z==0)
						{
						$base_def_id=$contenu['id_categorie'];
						$base_def_nom=$contenu['titre_categorie'];	
						}
					?>
                     <option value="<?php echo $contenu['id_categorie']; ?>" <?php if ($_POST['smsovh_base']==$contenu['id_categorie']) { echo "selected"; } ?>><?php echo $contenu['titre_categorie']; ?></option>
                    <?php	
					if ($_POST['smsovh_base']==$contenu['id_categorie'])
						{
						$base_def_id=$contenu['id_categorie'];
						$base_def_nom=$contenu['titre_categorie'];		
						}
					
						$z=$z+1;
					}
				   
				   ?>
                    
                   </select>
                 </p> 
                 
                 
                 <input type="hidden" name="action" value="smsovh_ajout_numero" />         
            	<div class="submit"><input type="submit" class="button-primary" name="submit" value="Ajouter"></div>
                </form>
                </div>
            </div>
            
            
           
           
             <div class="metabox-holder">
            <div class="postbox">
                <h3 class="hndle"><span>Numéro dans la base "<?php echo $base_def_nom; ?>"</span></h3>
                <div style="margin:20px;">
                
                
               <table class="widefat">
                <thead>
                	<tr>
                    	<th>Id</th>
                        <th>Numéro de téléphone</th>                      
                        <th>Supprimer</th>
                     </tr>
                </thead>
                <tfoot>
                	<tr>
                    	<th>Id</th>
                        <th>Numéro de téléphone</th>                        
                        <th>Supprimer</th>
                     </tr>
                </tfoot>
                <tbody>
                
                 <?php
				$requete=$wpdb->get_results("SELECT * FROM ".$table_name2." WHERE base='".$base_def_id."'","ARRAY_A");			
				
				foreach($requete as $resultat=>$contenu)
					{
					?>
                <tr>                
                <td><?php echo $contenu['id']; ?></td>
                <td><?php echo $contenu['numero']; ?></td>
                <td><a href="?page=<?php echo $_REQUEST['page']; ?>&smsovh_supp=<?php echo $contenu['id']; ?>">Supprimer</a></td>
                </tr><?php
					}
					?>
					
                
                 </tbody>
                </table>
              </div>
            
            
            
            </div>
            