<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = '我的收藏';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" id="hospital-view">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading custom-tab dark-tab">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#article">收藏的文章</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#hospital">收藏的医院</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#doctor">收藏的医生</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#operation">收藏的手术</a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#inspection">收藏的检查</a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="article" class="tab-pane active">
                        <?php
                            ListView::begin([
                                'dataProvider' => $dp_article,
                                'itemView' => '_list_article',
                                'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                                /*'itemOptions'=>['class'=>'xxx'],*/
                            ]);
                            ListView::end();
                        ?>
                    </div>
                    <div id="hospital" class="tab-pane">
                        <?php
                            ListView::begin([
                                'dataProvider' => $dp_hosp,
                                'itemView' => '_list_hosp',
                                'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                                /*'itemOptions'=>['class'=>'xxx'],*/
                            ]);
                            ListView::end();
                        ?>
                    </div>
                    <div id="doctor" class="tab-pane">
                        <?php
                            ListView::begin([
                                'dataProvider' => $dp_doctor,
                                'itemView' => '_list_doctor',
                                'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                                /*'itemOptions'=>['class'=>'xxx'],*/
                            ]);
                            ListView::end();
                        ?>
                    </div>
                    <div id="operation" class="tab-pane">
                        <?php
                            ListView::begin([
                                'dataProvider' => $dp_insp,
                                'itemView' => '_list_insp',
                                'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                                /*'itemOptions'=>['class'=>'xxx'],*/
                            ]);
                            ListView::end();
                        ?>
                    </div>
                    <div id="inspection" class="tab-pane">
                        <?php
                            ListView::begin([
                                'dataProvider' => $dp_opera,
                                'itemView' => '_list_opera',
                                'layout' => '{items}<div style="text-align:center;">{pager}</div>',
                                /*'itemOptions'=>['class'=>'xxx'],*/
                            ]);
                            ListView::end();
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>














