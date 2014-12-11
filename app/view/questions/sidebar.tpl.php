<div class="sidebar">
<?php if($type === 'view') : ?>
<p><a href="<?=$this->url->create($this->request->getLastUrl())?>"><i class="fa fa-chevron-left"></i> Tillbaka</a></p>
<?php elseif($type === 'list') : ?>
<?php if(isset($tag)) : ?>
<p><a style="color: red;" href="<?=$this->url->create('questions/list?' . parse_url($this->request->getCurrentUrl(), PHP_URL_QUERY))?>"><i class="fa fa-times"></i></a> sluta filtrera efter taggen (<?=$tag?>)</p>
<?php endif; ?>
<p>Sortera efter: <a <?=$order == 'timestamp' ? 'class="active-sort"' : null?> href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery())?>">senaste</a> <a <?=$order == 'rating' ? 'class="active-sort"' : null?> href="<?=$this->url->create($this->request->getCurrentUrlWithoutQuery() . '?rating=true')?>">betyg</a></p>
<?php endif; ?>
<p><a href="<?=$this->url->create('questions/ask')?>">Ställ en egen fråga</a></p>
</div>