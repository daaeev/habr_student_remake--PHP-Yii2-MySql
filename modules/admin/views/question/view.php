<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Question */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (\Yii::$app->user->can('assignment')): ?>
        <?=
            Html::a('Approve', ['approve', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure?',
                    'method' => 'post',
                ],
            ]);
        ?>

        <?=
            Html::a('Ban', ['ban', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure?',
                    'method' => 'post',
                ],
            ]);
        ?>
        <?php endif ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'author_id',
            'status',
            'viewed',
        ],
    ]) ?>

</div>
