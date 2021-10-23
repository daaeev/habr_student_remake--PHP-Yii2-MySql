<?php

namespace app\models;

use Yii;

class Tags extends \yii\db\ActiveRecord
{
    use \app\components\GetImageBehavior;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[QuestionToTagTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTagTags()
    {
        return $this->hasMany(QuestionToTagTags::class, ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[UserToTagSubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToTagSubs()
    {
        return $this->hasMany(UserToTagSub::class, ['tag_id' => 'id']);
    }
}
