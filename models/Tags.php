<?php

namespace app\models;

use Yii;

class Tags extends \yii\db\ActiveRecord
{
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
            [['tag_name', 'tag_image'], 'string', 'max' => 255],
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
            'tag_image' => 'Tag Image',
        ];
    }

    /**
     * Gets query for [[QuestionToTagTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionToTagTags()
    {
        return $this->hasMany(QuestionToTagTags::className(), ['tag_id' => 'id']);
    }

    /**
     * Gets query for [[UserToTagSubs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToTagSubs()
    {
        return $this->hasMany(UserToTagSub::className(), ['tag_id' => 'id']);
    }
}
