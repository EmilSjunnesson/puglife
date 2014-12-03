<h1><?=$title?></h1>
<?php print_r($questions)?>
<br>
<br>
<?php foreach ($questions as $question) : ?>
	<article>
	<header>
	<a name="<?=$question->id?>"></a>
	<h4><?=$question->title?>
	<span class="ago">- <?=$timeAgo($question->timestamp)?></span>
	</h4>
	</header>
	<div>
	<figure class="left">
		<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($question->emailUser)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
	</figure>
	<p><?=$question->content?></p>
	</div>
	<footer>
	<a href="<?=$this->url->create('comment/edit/' . $question->id)?>">Redigera</a> | 
	<a href="<?=$this->url->create('comment/remove/' . $question->id)?>">Radera</a>
	</footer>
	</article>
<?php endforeach; ?>