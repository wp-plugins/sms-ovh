
        <div id="icon-options-general" class="icon32"></div>
        <h2>Options SMS OVH</h2>
        <form method="post" action="options.php" id="options">
        <?php wp_nonce_field('update-options') ?>
        <div class="metabox-holder">
        
        <div id="message" class="updated"><p>Vous devez avoir un compte client chez <a href="http://www.ovh.com">OVH</a> pour envoyer des SMS.</p></div><br>

            <div class="postbox">
                <h3 class="hndle"><span>Options</span></h3>
                <div style="margin:20px;">
              
               <p><label>Nic Handle OVH</label><br />
 <small>Nic Handle de votre compte OVH (login)</small> </p>
                <p><input type="text" name="smsovh_login" value="<?php echo get_option('smsovh_login'); ?>" />
                </p>
               
                
                 <p>
                   <label>Mot de passe OVH</label><br />
 <small>Indiquez ici votre mot de passe de votre compte OVH</small> </p>
                <p> <input type="text" name="smsovh_passe" value="<?php echo get_option('smsovh_passe'); ?>" />
                </p>
                
                
                 <p>
                   <label>Numéro téléphone expéditeur</label><br />
 <small>Indiquez ici le numéro de téléphon expéditeur, celui-ci doit être déclaré sur le manager SMS OVH</small> </p>
                <p> <input type="text" name="smsovh_expediteur" value="<?php echo get_option('smsovh_expediteur'); ?>" />
                </p>
                
                
                 <p>
                   <label>Identifiant compte SMS</label><br />
 <small>Indiquez le compte SMS (commence par sms-....)</small> </p>
                <p> <input type="text" name="smsovh_sms" value="<?php echo get_option('smsovh_sms'); ?>" />
                </p>
                
                
                <input type="submit" class="button-primary" name="submit" value="Valider">
        </div></div>
          <input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="smsovh_sms,smsovh_passe,smsovh_login,smsovh_expediteur" />
</div>
        </form>
