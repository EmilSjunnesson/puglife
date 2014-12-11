<div class="profile-sidebar">
<h3>Senast ställda frågor</h3>
<?php foreach ($questions As $question) : ?>
	<p><a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->title?></a> <span class="smaller">- <?=$this->time->ago($question->timestamp)?></span></p>
<?php endforeach;?>
</div>
<div class="profile-sidebar">
<h3>Senast givna svar</h3>
<?php foreach ($answers As $answer) : ?>
	<p><a href="<?=$this->url->create('questions/id/' . $answer->idQuestion)?>"><?=$answer->title?></a> <span class="smaller">- <?=$this->time->ago($answer->timestamp)?></span></p>
<?php endforeach;?>
</div>