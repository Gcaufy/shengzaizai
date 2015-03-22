<?php
namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\helpers\Json;
use \common\models\File;


/**
 * Use to show or download uploaded file. Add configuration to your application
 *
 * ~~~
 * 'controllerMap' => [
 *     'file' => 'mdm\upload\FileController',
 * ],
 * ~~~
 *
 * Then you can show your file in url `Url::to(['/file','id'=>$file_id])`,
 * and download file in url `Url::to(['/file/download','id'=>$file_id])`
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class FileController extends \yii\web\Controller
{
    public $defaultAction = 'show';

    /**
     * Show file
     * @param integer $id
     */
    public function actionShow($id) {
        $request = Yii::$app->request;
        $thumb = $request->getQueryParam('thumb');
        $model = $this->findModel($id);
        $name = $thumb ? $model->getThumbName($thumb) : $model->filePath;
        if (!$name)
            throw new BadRequestHttpException("创建缩略图出错", 1);

        $response = Yii::$app->getResponse();
        $response->format = \yii\web\Response::FORMAT_RAW;
        $response->getHeaders()->add('content-type', $model->type);
        return file_get_contents($name);
    }

    /**
     * Download file
     * @param integer $id
     * @param mixed $inline
     */
    public function actionDownload($id = 0, $inline = null)
    {
        $model = $this->findModel($id);
        $response = Yii::$app->getResponse();
        $response->format = \yii\web\Response::FORMAT_RAW;
        $response->setDownloadHeaders($model->name, $model->type, !empty($inline), $model->size);
        return file_get_contents($model->filename);
    }

    public function actionUpload() {
        $files = UploadedFile::getInstancesByName('file');
        $errors = [];
        $folder = isset($_GET['folder']) ? $_GET['folder'] : false;
        if (!$folder)
            throw new BadRequestHttpException('缺少参数folder.');

        $ids = [];

        foreach ($files as $i => $file) {
            $model = new File();
            if ($file->hasError) {
                $errros[] = ['name' => $file->name, 'error' => $file->error];
                continue;
            }
            $model->loadFile($file);
            $model->setRelativePath($folder);
            if (!$model->save()) {
                $errros[] = ['name' => $file->name, 'error' => print_r($model->getErrors())];
            }
            $ids[] = $model->id;
        }
        $result = [];
        if ($errors)
            $result['errors'] = $errors;
        if ($ids)
            $result['result'] = $ids;
        return Json::encode($result);
    }

    /**
     * Get model
     * @param integer $id
     * @return FileModel
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}