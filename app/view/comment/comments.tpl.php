<a name="comments"></a>
<?php if (is_array($comments) && count($comments) > 0) : ?>
<div class='comments'>
<h3><?= count($comments) . " kommentar" . (count($comments)!=1 ? "er" : "") ?></h3>
<?php foreach ($comments as $id => $comment) : ?>
<article>
<header>
<a name="<?=$comment->id?>"></a>
<h4>#<?=$id + 1?> <?=$comment->name?> 
<span class="ago">- <?=$timeAgo($comment->timestamp)?></span>
</h4>
<?php if (!empty($comment->web)) : ?>
<p class="web"><?=$comment->web?></p>
<?php endif; ?>
</header>
<div>
<figure class="left">
	<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($comment->mail)));?>.jpg?s=50&amp;d=mm" alt="gravatar bild" />
</figure>
<p><?=$comment->content?></p>
</div>
<footer>
<a href="<?=$this->url->create('comment/edit/' . $comment->id)?>">Redigera</a> | 
<a href="<?=$this->url->create('comment/remove/' . $comment->id)?>">Radera</a>
</footer>
</article>
<?php endforeach; ?>
</div>
<?php else: ?>
<hr style="margin-top: 2em; border: none; background:  #ccc; height: 1px;">
<?php endif; ?>