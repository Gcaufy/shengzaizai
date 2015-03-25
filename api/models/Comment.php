<?php

namespace api\models;

use Yii;

class Comment extends \backend\modules\user\models\UserComment {

    use ApiModelTrait;

    public function fields() {
        $fields = $this->initFields();
        if (Yii::$app->request->get('doctor_id')) {
            unset($fields['insp_id'], $fields['opera_id']);
        }
        if (Yii::$app->request->get('insp_id')) {
            unset($fields['doctor_id'], $fields['opera_id']);
        }
        if (Yii::$app->request->get('opera_id')) {
            unset($fields['insp_id'], $fields['doctor_id']);
        }
        $fields['ctime'] = 'ctime';
        return $fields;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'cid'])
            ->from(User::tableName() . ' user');
    }
}
