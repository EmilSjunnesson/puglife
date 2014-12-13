<div class="question-single">
	<h1><?=$question->title?></h1>
	<a name="questionreply"></a>
	<div class="question-main">
	<div class="rating">
		<p><?=$loggedIn ? '<a class="plain-link" href="' . $this->url->create('questions/vote/question/' . $question->id . '/up') . '">' : null ?><i class="fa fa-sort-asc"></i><?=$loggedIn ? '</a>' : null ?><br>
			<span style="color: #333333;"><?=$question->rating?></span>
		<br><?=$loggedIn ? '<a class="plain-link" href="' . $this->url->create('questions/vote/question/' . $question->id . '/down') . '">' : null ?><i class="fa fa-sort-desc"></i><?=$loggedIn ? '</a>' : null ?></p>
	</div>
	<div class="content"><?=$this->textFilter->doFilter($question->content, 'markdown')?></div>
	<div class=tags>
	<?php foreach ($question->tags as $id => $tag) : ?>
	<?php if(!empty($id)) : ?>
		<a href="<?=$this->url->create('questions/list/tag/' . $id)?>"><?=$tag?></a>
	<?php endif; ?>
	<?php endforeach; ?>
	</div>
	<div class="user-info">
		<span class="ago">frågade <?=$this->time->ago($question->timestamp)?></span>
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
	<?=($loggedIn ? '<a href="' . $this->url->create('questions/vote/questioncom/' . $comment->id . '/up')
	 . '"><i class="fa fa-thumbs-up"></i></a> | ' : null)
	 . ($comment->rating > 0 ? '<span class="comment-rating">+' . $comment->rating . ' | </span> ' : null)
	 . $this->textFilter->doFilter($comment->content, 'markdown') . ' – <a href="'
	 . $this->url->create('users/id/' . $comment->idUser) . '">' . $comment->nameUser . '</a> '
	 . $this->time->ago($comment->timestamp)?>
	</div>
	<?php endforeach; ?>
	<div class="reply">
	<?php if(!$loggedIn) : ?>
		För att kommentera behöver du <a href="<?=$this->url->create('users/login')?>">logga in</a>.
		 Inte medlem? <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>. 
	<?php else : ?>
	<?php if (!$this->request->getGet('questioncom') == true) : ?>
		<a href="?<?=$this->request->getGet('rating', 0) ? 'rating=true&' : null?>questioncom=true#questionreply">skriv kommentar</a>
	<?php else : ?>
		<form method=post>
			<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?><?=$this->request->getGet('rating', 0) ? '?rating=true' : null?>#questionreply" name="redirect"/>
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
<span class="count"><?=$question->countAnswer?> svar</span>
<span class="order-answers"><a <?=$this->request->getGet('rating', 0) ? 'class="active"' : null?> href="<?=$this->request->getCurrentUrlWithoutQuery() . '?rating=true'?>#questionreply">Högst rankade</a><a <?=$this->request->getGet('rating', 0) ? null : 'class="active"'?> href="<?=$this->request->getCurrentUrlWithoutQuery()?>#questionreply">Senaste</a></span>
</header>
<?php foreach ($answers as $answer) : ?>
<div class="answer">
	<div class="question-main">
	<a name="answerreply<?=$answer->id?>"></a>
	<div class="rating">
		<p><?=$loggedIn ? '<a class="plain-link" href="' . $this->url->create('questions/vote/answer/' . $answer->id . '/up') . '">' : null ?><i class="fa fa-sort-asc"></i><?=$loggedIn ? '</a>' : null ?><br>
			<span style="color: #333333;"><?=$answer->rating?></span>
		<br><?=$loggedIn ? '<a class="plain-link" href="' . $this->url->create('questions/vote/answer/' . $answer->id . '/down') . '">' : null ?><i class="fa fa-sort-desc"></i><?=$loggedIn ? '</a>' : null ?><br>
			<?php if ($answer->accepted == true) : ?>
				<span class="accept-green" title="Frågeställaren har accpeterat detta svar"><i class="fa fa-check"></i></span>
			<?php else : ?>
			<?php if ((!$question->hasAcceptedAnswer == true) && ($question->idUser === $this->session->get('userId'))) : ?>
				<span class="accept-link" title="Acceptera detta svar"><a class="plain-link" href="<?=$this->url->create('questions/accept/' . $answer->id)?>"><i class="fa fa-check"></i></a></span>
			<?php endif; ?>
			<?php endif; ?>
		</p>
	</div>
	<div class="content"><?=$this->textFilter->doFilter($answer->content, 'markdown')?></div>
	<div class="user-info">
		<span class="ago">svarade <?=$this->time->ago($answer->timestamp)?></span>
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
	<?=($loggedIn ? '<a href="' . $this->url->create('questions/vote/answercom/' . $comment->id . '/up')
	 . '"><i class="fa fa-thumbs-up"></i></a> | ' : null)
	 . ($comment->rating > 0 ? '<span class="comment-rating">+' . $comment->rating . ' | </span> ' : null)
	 . $this->textFilter->doFilter($comment->content, 'markdown') . ' – <a href="'
	 . $this->url->create('users/id/' . $comment->idUser) . '">' . $comment->nameUser . '</a> '
	 . $this->time->ago($comment->timestamp)?>
	</div>
	<?php endforeach; ?>
	<div class="reply">
	<?php if(!$loggedIn) : ?>
		För att kommentera behöver du <a href="<?=$this->url->create('users/login')?>">logga in</a>.
		 Inte medlem? <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>. 
	<?php else : ?>
	<?php if (!$this->request->getGet('answercom' . $answer->id) == true) : ?>
		<a href="?<?=$this->request->getGet('rating', 0) ? 'rating=true&' : null?>answercom<?=$answer->id?>=true#answerreply<?=$answer->id?>">skriv kommentar</a>
	<?php else : ?>
		<form method=post>
			<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?><?=$this->request->getGet('rating', 0) ? '?rating=true' : null?>#answerreply<?=$answer->id?>" name="redirect"/>
			<input type="hidden" value="answer" name="type"/>
			<textarea name="content" required></textarea>
			<input type="submit" value="Kommentera" name='doComment' onClick="this.form.action = '<?=$this->url->create('questions/comment/' . $answer->id)?>'"/>
		</form>
	<?php endif; ?>
	<?php endif; ?>
	</div>
	</div>	
</div>
<?php endforeach; ?>
<a name="bottom"></a>
</div>
<div class="write-answer">
<h3>Skriv Svar</h3>
<?php if(!$loggedIn) : ?>
	<div class="reply">För att svara behöver du <a class="plain-red" href="<?=$this->url->create('users/login')?>">logga in</a>.
		 Inte medlem? <a class="plain-red" href="<?=$this->url->create('users/register')?>">Registrera dig</a>.</div>
<?php else : ?>
	<form method=post>
		<input type="hidden" value="<?=$this->request->getCurrentUrlWithoutQuery()?><?=$this->request->getGet('rating', 0) ? '?rating=true' : null?>#bottom" name="redirect"/>
		<textarea name="content" required></textarea>
		<input type="submit" value="Skicka svar" name='doAnswer' onClick="this.form.action = '<?=$this->url->create('questions/answer/' . $question->id)?>'"/>
	</form>
<?php endif; ?>
</div>
<?php if (isset($popup)) : ?>
	<script type='text/javascript'>alert('Du kan bara rösta en gång!');var url = document.URL;window.location = url.replace("/denied", "");</script>;
<?php endif; ?>