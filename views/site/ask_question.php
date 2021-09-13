<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<content id="ask">
    <p class="upper-title_ask">Новый вопрос</p>

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'ask_form',
        ],
    ]) ?>
        <div class="field_block">
            <p class="field-label">Суть вопроса</p>
            <span class="field-prompt">Сформулируйте вопрос так, чтобы сразу было понятно, о чём речь.</span>
            <?= $form->field($model, 'essence')->input('text', ['class' => 'field', 'autocomplete' => 'off']) ?>
        </div>

        <div class="field_block">
            <p class="field-label">Теги вопроса</p>
            <span class="field-prompt">Укажите от 1 до 5 тегов — предметных областей, к которым вопрос относится.</span>
            <?= $form->field($model, 'tags')->input('text', ['class' => 'field', 'autocomplete' => 'off']) ?>
        </div>

        <div class="field_block">
            <p class="field-label">Сложность вопроса</p>
            <?= 
                $form->field($model, 'difficulty')->dropDownList([
                    'Простой' => 'Простой', 
                    'Средний' => 'Средний', 
                    'Сложный' => 'Сложный',
                ],
                    ['class' => 'field list']) 
            ?>
        </div>

        <div class="field_block">
            <p class="field-label">Детали вопроса</p>
            <span class="field-prompt">Опишите в подробностях свой вопрос, чтобы получить более точный ответ.</span>
            <div class="form">
                <div class="form_helper">
                    <?= Html::button('B') ?>
                    <?= Html::button('B') ?>
                    <?= Html::button('B') ?>
                </div>

                <div class="form_help_block">
                    <?= $form->field($model, 'content')->textarea() ?>
                    <?= Html::submitButton('Опубликовать') ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?> 
</content>