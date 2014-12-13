<?php if($this->users->isLoggedIn()) : ?>
<div class="contain smaller">
<a href="<?=$this->url->create('users/id')?>"><?=$this->users->find($this->session->get('userId'))->name?></a> |
 <a href="<?=$this->url->create('users/logout')?>">Logga ut</a>
<?php else: ?> 
<div class="contain smaller">
<a href="<?=$this->url->create('users/login')?>">Logga in</a> |
 <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>
<?php endif; ?> 
</div>