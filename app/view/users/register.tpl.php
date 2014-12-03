<form method=post>
<fieldset>
	<p><label>Användarnamn:<br><input type=text name='acronym' autocomplete='off' required></label></p>
	<p><label>Namn:<br><input type=text name='name' autocomplete='off' required></label></p>
	<p><label>E-mail:<br><input type=text name='email' autocomplete='off' required></label></p>
	<p><label>Lösenord:<br><input type=password name='password' id='password' required></label></p>
	<p><label>Bekräfta lösenord:<br><input type=password name='confirm_password' id='confirm_password' required> <span id='message'></span></label></p>
	<p><input type='checkbox' name='accept' required> Jag accepterar villkoren</p>
	<p><input type='submit' value='Skicka' name='doRegister' onClick="this.form.action = '<?=$this->url->create('users/register-user')?>'"/> <input type='reset' value='Återställ'/></p>
	<?php if(!empty($output)) : ?>
    	<output>
    	<?php if($output == 'password') : ?>
    		Lösenorden matchar inte
    	<?php elseif ($output == 'acronym') :?>
    		Användarnamnet finns redan
    	<?php else : ?>
    		Något gick fel, du blev inte registrerad
    	<?php endif; ?>
    	</output>
	<?php endif; ?>
</fieldset>
</form>