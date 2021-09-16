<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tags-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure?',
                ],
            ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tag_name',
            [
                'format' => 'html',
                'label' => 'Image',
                'value' => function($data) {
                    return Html::img($data->getImage(), ['width'=>100]);
                }
            ],
        ],
    ]) ?>

</div>
