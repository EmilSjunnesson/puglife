<h1><?=$title?></h1>
<?php foreach ($questions as $question) : ?>
<div class="question">
	<a name="<?=$question->id?>"></a>
	<div class="numbers">
		<p><?=$question->rating?><br>betyg</p>
		<p style="padding-top: 0.125em;"><?=$question->countAnswer?><br>svar</p>
	</div>
	<h4><a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->title?></a></h4>
	<div class=tags>
	<?php foreach ($question->tags as $id => $tag) : ?>
	<?php if(!empty($id)) : ?>
		<a href="<?=$this->url->create('questions/list/tag/' . $id)?>"><?=$tag?></a>
	<?php endif; ?>
	<?php endforeach; ?>
	</div>
	<div class="user-info">
		<span class="ago">frågade <?=$timeAgo($question->timestamp)?></span>
		<div>
			<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($question->emailUser)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
			<p><a href="<?=$this->url->create('users/id/' . $question->idUser)?>"><?=$question->nameUser?></a><br>
			<span class="golden"><i class="fa fa-star"></i></span> <?=$question->scoreUser?></p>
		</div>
	</div>	
</div>
<?php endforeach; ?>