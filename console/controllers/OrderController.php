<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;

use \backend\modules\order\models\Number;
use \backend\modules\hospital\models\Hospital;
use \backend\modules\doctor\models\Doctor;
use \backend\modules\inspection\models\InspectionHospitalMap;
use \backend\modules\Operation\models\OperationHospitalMap;


class OrderController extends Controller
{


    public function actionNumber() {
        $tbl_hosp = Hospital::tableName();
        $tbl_order_num = Number::tableName();
        $tbl_doctor = Doctor::tableName();
        $date = date("Y-m-d");
        $sql = "
            update $tbl_hosp sh
            inner join (
                select sh.id,
                sum(if(order_num is null, 0, order_num)) as order_num,
                sum(if(active_order_num is null, 0, active_order_num)) as active_order_num
                from $tbl_hosp sh
                left join $tbl_order_num son
                on sh.id = son.hosp_id
                and son.date > '$date'
                where sh.status = 1
                and son.status = 1
                group by sh.id
            ) cte
            on sh.id = cte.id
            set opened_order = order_num,
            active_opened_order = active_order_num;
        ";

        $command = Yii::$app->db->createCommand($sql);
        $rst = $command->execute();
        $sql = "
            update $tbl_doctor sd
            inner join (
                select sd.id,
                sum(if(son.order_num is null, 0, son.order_num)) as order_num,
                sum(if(son.active_order_num is null, 0, son.active_order_num)) as active_order_num
                from $tbl_doctor sd
                left join $tbl_order_num son
                on sd.id = son.doctor_id
                and son.opera_id is null
                and son.date > '$date'
                where sd.status = 1
                and son.status = 1
                group by sd.id
            ) cte
            on sd.id = cte.id
            set sd.order_num = cte.order_num,
            sd.active_order_num = cte.active_order_num;
        ";

        $command = Yii::$app->db->createCommand($sql);
        $rst += $command->execute();

        $this->stdout("Today is $date.\n");
        $this->stdout("Updated affected rows: $rst.\n");
        return static::EXIT_CODE_NORMAL;
    }

}
