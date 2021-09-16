<?php

namespace app\models;

use app\components\ImageInterface;
use Yii;

class Tags extends \yii\db\ActiveRecord implements ImageInterface
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

    public function getImage(): string
    {
        return '/uploads/tags/' . $this->tag_image;
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
