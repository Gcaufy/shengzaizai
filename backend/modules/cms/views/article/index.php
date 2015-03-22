<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\cms\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
                    ListView::begin([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_list',
                        'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                        /*'itemOptions'=>['class'=>'xxx'],*/
                    ]);

                    ListView::end();
                ?>
