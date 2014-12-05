<h1>Ställ en fråga</h1>
<form method=post>
	<input type="hidden" value="" name="tags"/>
	<p>Titel:<br><input type="text" name="title" required/></p>
	<p>Fråga:<br><textarea name="content" required></textarea></p>
	<p>Taggar:<br><input type="text" value="" name="tags" data-role="tagsinput" /></p>	
	<p><input type="submit" value="Skicka fråga" name='doAsk' onClick="this.form.action = '<?=$this->url->create('questions/asked')?>'"/></p>
</form>
