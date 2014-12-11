<h1 class="users">Taggar</h1> 
Sortera efter: <a <?=$order == 'name' ? 'class="active-sort"' : null?> 
href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery())?>">namn</a>
 <a <?=$order == 'count DESC' ? 'class="active-sort"' : null?> 
 href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery() . '?count=true')?>">popularitet</a>
<div class="tags">
<?php foreach ($tags as $tag) : ?>
<a class="large" href="<?=$this->url->create('questions/list/tag/' . $tag->id)?>"><?=$tag->name?> (<?=$tag->count?>)</a>
<?php endforeach; ?>
</div>