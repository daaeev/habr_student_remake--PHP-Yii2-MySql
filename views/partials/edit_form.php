<?php 

use app\components\questions\QuestionHtmlGen;

if (!\Yii::$app->user->isGuest && $this->params['user']->status != 3): 
?>
<?php if ($this->beginCache('edit_form', [
        'variations' => [Yii::$app->language],
        'duration' => 3600 * 24
    ])): 
?>
    <div class="comment_form_block edit_form">
        <div class="form_block">
            <div class="single_form">
                <div class="form_helper">
                    <?= QuestionHtmlGen::generateFormHelpButtons() ?>
                </div>

                <form id="form">
                    <div class="form-group">
                        <textarea name="content" required></textarea>
                        <button type="submit" class="form_edit-btn"><?= Yii::t('main', 'Редактировать') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $this->endCache(); endif ?>
<?php endif ?>