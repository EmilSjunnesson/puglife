<div class="contain">
<?php if($this->users->isLoggedIn()): ?>
<a href="<?=$this->url->create('users/id/' . $this->session->get('userId'))?>"><?=$this->users->Find($this->session->get('userId'))->name?></a> |
 <a href="<?=$this->url->create('users/logout')?>">Logga ut</a>
<?php else: ?> 
<a href="<?=$this->url->create('users/login')?>">Logga in</a> |
 <a href="<?=$this->url->create('users/register')?>">Registrera dig</a>
<?php endif; ?> 
</div>