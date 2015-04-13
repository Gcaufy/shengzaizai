<?php

namespace api\models;

use Yii;
use yii\helpers\ArrayHelper;


class Favor extends \backend\modules\user\models\UserFavor {

    use ApiModelTrait;


    public function fields() {
        $denied = [];
        if ($this->opera_id) {
            $denied = ['article_id', 'insp_id', 'doctor_id'];
        } else if ($this->insp_id) {
            $denied = ['article_id', 'doctor_id', 'opera_id'];
        } else if ($this->doctor_id) {
            $denied = ['article_id', 'insp_id', 'opera_id'];
        } else if ($this->hosp_id) {
            $denied = ['article_id', 'insp_id', 'opera_id', 'doctor_id'];
        } else if ($this->article_id) {
            $denied = ['hosp_id', 'insp_id', 'opera_id', 'doctor_id'];
        }
        $denied[] = 'user_id';
        $this->deniedFields = ArrayHelper::merge($this->deniedFields, $denied);
        $fields = $this->initFields();
        $fields['cid'] = 'cid';
        $fields['ctime'] = 'ctime';
        return $fields;
    }



    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id'])
            ->from(Article::tableName() . ' article');
    }

    public function getDoctor()
    {
        return $this->hasOne(Doctor::className(), ['id' => 'doctor_id'])
            ->from(Doctor::tableName() . ' doctor');;
    }

    public function getHospital()
    {
        return $this->hasOne(Hospital::className(), ['id' => 'hosp_id'])
            ->from(Hospital::tableName() . ' hosp');;
    }

    public function getInspection()
    {
        return $this->hasOne(Inspection::className(), ['id' => 'insp_id'])
            ->from(Inspection::tableName() . ' insp');;
    }

    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'opera_id'])
            ->from(Operation::tableName() . ' opera');;
    }
}
