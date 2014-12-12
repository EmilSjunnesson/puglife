<div class="sidebar">
<h1>Flitigaste Användarna</h1>
<?php foreach ($users as $user) : ?>
	<div class="user-home">
		<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
		<a href="<?=$this->url->create('users/id/' . $user->id)?>"><?=$user->name?></a><br>
		<span class="golden"><i class="fa fa-star"></i></span> <?=$user->score?>
	</div>
<?php endforeach; ?>
<h1>Senaste aktivitet</h1>
<div class="smaller">
<?=$activities?>
</div>
</div>
