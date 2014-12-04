<p>Svar</p>
<?php print_r($answers)?>
<div class="question-single">
	<h1><?=$question->title?></h1>
	<div class="question-main">
	<div class="rating">
		<p><i class="fa fa-sort-asc"></i><br>
			<?=$question->rating?>
		<br><i class="fa fa-sort-desc"></i></p>
	</div>
	<div class="content"><?=$question->content?></div>
	<div class=tags>
	<?php foreach ($question->tags as $id => $tag) : ?>
	<?php if(!empty($id)) : ?>
		<a href="<?=$id?>"><?=$tag?></a>
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
	<div class="comments">
	<?php foreach ($comments as $comment) : ?>
	<div class="comment">
	<?=$comment->content . ' – <a href="' . $this->url->create('users/id/' . $comment->idUser) . '">' . $comment->nameUser . '</a> ' . $timeAgo($comment->timestamp)?>
	</div>
	<?php endforeach; ?>
	</div>	
</div>
<div class="answers">
<header>

</header>
<?php foreach ($question->tags as $tag) : ?>

<?php endforeach; ?>
</div>