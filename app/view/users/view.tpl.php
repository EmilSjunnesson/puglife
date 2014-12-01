<h1><?=$title?></h1>
 
<p>Acronym: <?=$user->acronym?></p>
<p>Email: <?=$user->email?></p>
<p>Status: <?=$user->deleted == null ? $user->active == null ? "inaktiv" : "aktiv" : "raderad"?></p>
<p>Skapad: <?=$user->created?></p>

<p>
<a href="<?=$this->url->create('users/update/' . $user->id);?>">Updatera</a>
<?php if($user->deleted == null) : ?>
<?php if($user->active == null) : ?>
 | <a href="<?=$this->url->create('users/activate/' . $user->id);?>">Aktivera</a>
<?php else : ?> 
 | <a href="<?=$this->url->create('users/deactivate/' . $user->id);?>">Deaktivera</a>
<?php endif; ?>
 | <a href="<?=$this->url->create('users/soft-delete/' . $user->id);?>">Soft delete</a>
<?php else : ?> 
 | <a href="<?=$this->url->create('users/undo-soft-delete/' . $user->id);?>">Återställ delete</a>
<?php endif; ?>
 | <a href="<?=$this->url->create('users/delete/' . $user->id);?>">Radera</a>
</p>
 
<p><a class="inherit" href='<?=$this->url->create('users')?>'><i class="fa fa-chevron-left"></i> Tillbaka</a></p>