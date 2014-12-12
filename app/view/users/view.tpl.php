<div class="profile">
<h1><?=$title?></h1>

<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)));?>.jpg?s=150&amp;d=mm" alt="gravatar bild" />

<p>Poäng: <span class="golden"><i class="fa fa-star"></i></span> <?=$user->score?></p>
<p>Email: <?=$user->email?></p>
<p>Skapad: <?=$user->created?></p>
<p><a class="plain-link" href="<?=$this->url->create($this->request->getLastUrl())?>"><i class="fa fa-chevron-left"></i> Tillbaka</a>
<?php if($user->id == $this->session->get('userId')) : ?>
	 | <a class="plain-link" href="<?=$this->url->create('users/update/' . $user->id);?>"><i class="fa fa-pencil-square-o"></i> Redigera profil</a>
<?php endif; ?>
</p>
<h3>Senaste aktivitet</h3>
<div class="activities">
<?php if(!empty($activeties)) : ?>
	<?=$activeties?>
<?php else : ?>
	<div class="activity">Användaren har inte utfört någon aktivitet ännu</div>	
<?php endif; ?>
</div>
</div>