<h1><?=$title?></h1>
<div class="home">
<?php foreach ($questions as $question) : ?>
<p><?=$question->title?></p>
<?php endforeach; ?>
</div>