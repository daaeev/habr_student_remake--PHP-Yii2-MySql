<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\components\questions\QuestionHtmlGen;

?>
<content id="ask">
<?php if ($this->beginCache('ask_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
    <p class="upper-title_ask"><?= Yii::t('main', 'Новый вопрос') ?></p>

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'ask_form',
        ],
    ]) ?>
        <div class="field_block">
            <p class="field-label"><?= Yii::t('main', 'Суть вопроса') ?></p>
            <span class="field-prompt"><?= Yii::t('main', 'Сформулируйте вопрос так, чтобы сразу было понятно, о чём речь') ?></span>
            <?= $form->field($model, 'essence')->input('text', ['class' => 'field', 'autocomplete' => 'off'])->label('') ?>
        </div>

        <div class="field_block">
            <p class="field-label"><?= Yii::t('main', 'Теги вопроса') ?></p>
            <span class="field-prompt"><?= Yii::t('main', 'Укажите через запятую от 1 до 5 тегов — предметных областей') ?></span>
            <?= $form->field($model, 'tags')->input('text', ['class' => 'field', 'autocomplete' => 'off'])->label('') ?>
        </div>

        <div class="field_block">
            <p class="field-label"><?= Yii::t('main', 'Сложность вопроса') ?></p>
            <?= 
                $form->field($model, 'difficulty')->dropDownList([
                    'Простой' => Yii::t('main', 'Простой'), 
                    'Средний' => Yii::t('main', 'Средний'), 
                    'Сложный' => Yii::t('main', 'Сложный'),
                ],
                    ['class' => 'field list'])->label('')
            ?>
        </div>

        <div class="field_block">
            <p class="field-label"><?= Yii::t('main', 'Детали вопроса') ?></p>
            <span class="field-prompt"><?= Yii::t('main', 'Опишите в подробностях свой вопрос, чтобы получить более точный ответ.') ?></span>
            <div class="form">
                <div class="form_helper">
                    <?= QuestionHtmlGen::generateFormHelpButtons() ?>
                </div>
                
                <div id="form">
                    
                    <?= $form->field($model, 'content', [
                        'options' => ['class' => 'form_help_block form-group field-askform-content required has-error']
                    ])->textarea()->label('') ?>

                    <div class="form_help_block">
                        <?= Html::submitButton(Yii::t('main', 'Опубликовать')) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?> 
<?php $this->endCache(); endif ?>
</content>