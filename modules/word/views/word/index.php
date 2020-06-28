<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Sound;

$this->title = 'Слова';
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['/text']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить слово', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Создать файл для озвучки', ['/sound/create-file', 'type' => TYPE_WORD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Добавить озвучку', ['/sound/add-sounds', 'type' => TYPE_WORD], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'engl',

            'ru',

            ['attribute' => 'state', 'format' => 'raw', 'value' => function($model) {  
                return Html::a($model->state->valueStr, ['/word/set-state', 'id' => $model->id], 
                    ['class' => $model->state->value ? 'green' : 'red']); }
            ],

            ['attribute' => 'saund', 'format' => 'raw', 'value' => function($model) {return $model->makePlayer();}],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
