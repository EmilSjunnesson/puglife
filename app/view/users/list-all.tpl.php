<h1><?=$title?></h1>
<?php if (!empty($users)) : ?>
<table>
	<tr>
   		<th>Id</th>
  		<th>Acronym</th>
  		<th>Email</th>
  		<th>Namn</th>
  		<?php if(isset($status)) : ?>
  			<th>Status</th>
  		<?php endif; ?>
  		<th>Redigera</th>
  	</tr>
<?php foreach ($users as $user) : ?> 
	<tr>
   		<td class="center"><?=$user->id?></td>
  		<td><?=$user->acronym?></td>
  		<td><?=$user->email?></td>
  		<td><?=$user->name?></td>
  		<?php if(isset($status)): ?>
  			<td class="center"><?=$user->deleted == null ? $user->active == null ? "inaktiv" : "aktiv" : "raderad"?></td>
  		<?php endif; ?>
  		<td class="center"><a href="<?=$this->url->create('users/id/' . $user->id)?>"><i class="fa fa-pencil-square-o"></i></a></td>
  	</tr> 
<?php endforeach; ?>
</table>
<?php else : ?>
<p>Det finns inga användare i listan</p>
<?php endif; ?>
<?php if ($this->request->getRoute() != 'users') : ?>
<p><a class="inherit" href='<?=$this->url->create('users')?>'><i class="fa fa-chevron-left"></i> Tillbaka</a></p>
<?php endif; ?>