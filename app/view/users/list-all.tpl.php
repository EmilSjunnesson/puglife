<h1 class="users"><?=$title?></h1> 
Sortera efter: <a <?=$order == 'name' ? 'class="active-sort"' : null?> 
href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery())?>">namn</a>
 <a <?=$order == 'score DESC' ? 'class="active-sort"' : null?> 
 href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery() . '?score=true')?>">poäng</a>
<?php if (!empty($users)) : ?>
<?php foreach ($users as $user) : ?> 
<div class="user-list">
	<div class="user">
		<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
		<a href="<?=$this->url->create('users/id/' . $user->id)?>"><?=$user->name?></a><br>
		<span class="golden"><i class="fa fa-star"></i></span> <?=$user->score?>
	</div>
</div>
<?php endforeach; ?>
<?php else : ?>
<p>Det finns inga användare i listan</p>
<?php endif; ?>