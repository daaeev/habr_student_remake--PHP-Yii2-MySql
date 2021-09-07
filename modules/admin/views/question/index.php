<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'title',
            'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],

        ],
    ]); ?>


</div>
