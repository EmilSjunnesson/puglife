<?php if (isset($get)): ?>
<div class='comment-form'>
	<a name="form"></a> 
    <?=$form?>
</div>
<?php else: ?>
<div style="text-align: center; margin-top: 2em;">
<a href="?comment#form" class="as-button" style="font-size: xx-large;">Kommentera</a>
</div>
<?php endif; ?>