<h1 class="users"><?=$title?></h1> 
<?php if(isset($order)) : ?>
<span class="switch" style="display:inline-block; vertical-align:top">Sortera efter: <a <?=$order == 'name COLLATE utf8_swedish_ci' ? 'class="active-sort"' : null?>
 href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery())?>">namn</a>
 <a <?=$order == 'count DESC' ? 'class="active-sort"' : null?> 
 href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery() . '?count=true')?>">popularitet</a></span>
<?php endif; ?> 
<div class="tags">
<?php foreach ($tags as $tag) : ?>
<a class="large" href="<?=$this->url->create('questions/list/tag/' . $tag->id)?>"><?=$tag->name?> (<?=$tag->count?>)</a>
<?php endforeach; ?>
</div>