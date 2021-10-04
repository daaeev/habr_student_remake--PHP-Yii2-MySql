<?php 

use app\components\QuestionHtmlGen;

if (!\Yii::$app->user->isGuest): 
?>
    <div class="comment_form_block">
        <div class="form_block">
            <div class="single_form">
                <div class="form_helper">
                    <?= QuestionHtmlGen::generateFormHelpButtons() ?>
                </div>

                <form id="edit-form">
                    <textarea name="content" required></textarea>
                    <button type="submit" class="form_edit-btn">Редактировать</button>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>