<h1>Taggar</h1>
<?php foreach ($tags as $tag) : ?>
<div class="tag">
<a href="<?=$this->url->create('questions/list/tag/' . $tag->id)?>"><?=$tag->name?></a> (<?=$tag->count?>)
</div>
<?php endforeach; ?>