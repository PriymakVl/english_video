<?php 
use yii\helpers\Html;

$this->registerJsFile('@web/js/sounds_words_video.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('@web/css/word/video.css');

?>


<div class="wrapper">
  <div class="view" id="engl">нет слова</div>
  <div class="view" id="ru">нет слова</div>
</div>

<div class="statistics_sounds">
  <p>Всего слов:  <span id="word_all"></span></p>
  <p>Озвучено:  <span id="word_sounded"></span></p>
  <p>Осталось:  <span id="word_rest"></span></p>
</div>

