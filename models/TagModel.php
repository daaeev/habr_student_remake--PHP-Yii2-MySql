<?php

namespace app\models;

use yii\base\Model;
use app\models\Tags;
use app\models\QuestionToTagTags;
use Yii;

class TagModel extends Model
{
    public $image;
    public $tag_name;

    public function rules()
    {
        return [
            ['image', 'required'],
            ['image', 'file', 'extensions' => ['png', 'jpg']],
        ];
    }

    /*
       Splits the input tag string and generates a model for each tag
    */
    public static function generateModels($tags, $question_id)
    {
        $tags_array = explode(',', str_replace(' ', '', $tags));
        $tags_models_array = [];

        for ($i = 0; $i < count($tags_array); $i++) {
            /*
               Uniqueness check
            */
            if ($tag = Tags::findOne(['tag_name' => ucfirst($tags_array[$i])])) {
                if (!QuestionToTagTags::find()->where(['tag_id' => $tag->id, 'question_id' => $question_id])->exists()) {
                    $link = new QuestionToTagTags;
                    $link->question_id = $question_id;
                    $link->tag_id = $tag->id;

                    $link->save();
                }
                continue;
            }

            $tag_model = new TagModel();
            $tag_model->tag_name = ucfirst($tags_array[$i]);
            $tags_models_array[] = $tag_model; 
        }

        return $tags_models_array;
    }

    /*
       Preparing data and creating a tag, along with an adjacent record, using a transaction
    */
    public function createTag($question_id)
    {
        $file_name = $this->createFileName();
        $this->image->saveAs($this->getImageFolder() . $file_name);

        Tags::getDb()->transaction(function () use ($question_id, $file_name) {
            $this->saveInDb($file_name);
            $this->addQtoTagLink($question_id);
        });
    }

    /*
       Creating a tag in a table
    */
    private function saveInDb($file_name)
    {
        $tag = new Tags;
        $tag->tag_name = $this->tag_name;
        $tag->tag_image = $file_name;

        $tag->save(); 
    }

    /*
       Creates a linked entry between the question and the tag
    */
    private function addQtoTagLink($question_id)
    {
        $link = new QuestionToTagTags;
        $link->question_id = $question_id;
        $link->tag_id = (Tags::findOne(['tag_name' => $this->tag_name]))->id;

        $link->save();
    }

    private function createFileName()
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    private function getImageFolder()
    {
        return Yii::getAlias('@web') . 'uploads/tags/';
    }
}