<div class="question-single">
	<h1><?=$question->title?></h1>
	<div class="question-main">
	<div class="rating">
		<p><i class="fa fa-sort-asc"></i><br>
			<?=$question->rating?>
		<br><i class="fa fa-sort-desc"></i></p>
	</div>
	<div class="content"><?=$this->textFilter->doFilter($question->content, 'markdown')?></div>
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
	<?=($comment->rating > 0 ? '<span class="comment-rating">+' . $comment->rating . '</span> ' : null) . $this->textFilter->doFilter($comment->content, 'markdown') . ' – <a href="' . $this->url->create('users/id/' . $comment->idUser) . '">' . $comment->nameUser . '</a> ' . $timeAgo($comment->timestamp)?>
	</div>
	<?php endforeach; ?>
	<div class="reply">
	<a name="questionreply"></a>
	<?php if(!$this->users->isLoggedin()) : ?>
		För att kommentera behöver du <a href="<?=$this->url->create('users/login')?>">logga in</a>.
		 Inte medlem? <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>. 
	<?php else : ?>
	<?php if (!$this->request->getGet('questioncom') == true) : ?>
		<a href="?questioncom=true#questionreply">skriv kommentar</a>
	<?php else : ?>
		<form method=post>
			<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?>#questionreply" name="redirect"/>
			<input type="hidden" value="question" name="type"/>
			<textarea name="content" required></textarea>
			<input type="submit" value="Kommentera" name='doComment' onClick="this.form.action = '<?=$this->url->create('questions/comment/' . $question->id)?>'"/>
		</form>
	<?php endif; ?>
	<?php endif; ?>
	</div>
	</div>	
</div>
<div class="answers">
<header>
<?=$question->countAnswer?> svar
</header>
<?php foreach ($answers as $answer) : ?>
	<div class="question-main">
	<div class="rating">
		<p><i class="fa fa-sort-asc"></i><br>
			<?=$answer->rating?>
		<br><i class="fa fa-sort-desc"></i></p>
	</div>
	<div class="content"><?=$this->textFilter->doFilter($answer->content, 'markdown')?></div>
	<div class="user-info">
		<span class="ago">svarade <?=$timeAgo($answer->timestamp)?></span>
		<div>
			<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($answer->emailUser)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
			<p><a href="<?=$this->url->create('users/id/' . $answer->idUser)?>"><?=$answer->nameUser?></a><br>
			<span class="golden"><i class="fa fa-star"></i></span> <?=$answer->scoreUser?></p>
		</div>
	</div>
	</div>
	<div class="comments">
	<?php foreach ($answer->comments as $comment) : ?>
	<div class="comment">
	<?=($comment->rating > 0 ? '<span class="comment-rating">+' . $comment->rating . '</span> ' : null) . $this->textFilter->doFilter($comment->content, 'markdown') . ' – <a href="' . $this->url->create('users/id/' . $comment->idUser) . '">' . $comment->nameUser . '</a> ' . $timeAgo($comment->timestamp)?>
	</div>
	<?php endforeach; ?>
	<div class="reply">
	<a name="answerreply<?=$answer->id?>"></a>
	<?php if(!$this->users->isLoggedin()) : ?>
		För att kommentera behöver du <a href="<?=$this->url->create('users/login')?>">logga in</a>.
		 Inte medlem? <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>. 
	<?php else : ?>
	<?php if (!$this->request->getGet('answercom' . $answer->id) == true) : ?>
		<a href="?answercom<?=$answer->id?>=true#answerreply<?=$answer->id?>">skriv kommentar</a>
	<?php else : ?>
		<form method=post>
			<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?>#answerreply<?=$answer->id?>" name="redirect"/>
			<input type="hidden" value="answer" name="type"/>
			<textarea name="content" required></textarea>
			<input type="submit" value="Kommentera" name='doComment' onClick="this.form.action = '<?=$this->url->create('questions/comment/' . $answer->id)?>'"/>
		</form>
	<?php endif; ?>
	<?php endif; ?>
	</div>
	</div>	
<?php endforeach; ?>
<a name="bottom"></a>
</div>
<div class="write-answer">
<h3>Skriv Svar</h3>
	<form method=post>
		<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?>#bottom" name="redirect"/>
		<textarea name="content" required></textarea>
		<input type="submit" value="Skicka svar" name='doAnswer' onClick="this.form.action = '<?=$this->url->create('questions/answer/' . $question->id)?>'"/>
	</form>
</div>