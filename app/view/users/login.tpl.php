<form method=post>
    <fieldset>
    <p><label>Användarnamn:<br/><input type='text' name='acronym' required/></label></p>
    <p><label>Lösenord:<br/><input type='password' name='password' required/></label></p>
    <p><input type='submit' name='doLogin' value='Logga in' onClick="this.form.action = '<?=$this->url->create('users/login-user')?>'"/></p>
    <?php if(!empty($output)) : ?>
    <?php if($output == 'registerd') : ?>
    	<output>Grattis! du är nu medlem på Pug Life, logga in!</output>
    <?php else : ?>
    	<output>Kunde inte logga in, fel användarnamn eller lösenord?</output>
    <?php endif; ?>
    <?php endif; ?>
    </fieldset>
</form>