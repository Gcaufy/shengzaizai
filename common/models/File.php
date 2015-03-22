<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use \common\components\Thumb;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $type
 * @property string $ext
 * @property string $size
 * @property string $path
 * @property integer $status
 * @property string $cid
 * @property string $ctime
 * @property string $uid
 * @property string $utime
 */
class File extends \common\components\MyActiveRecord
{

    protected $dataRootDir; // as: /var/www
    protected $dataPathDir = 'data'; // as: data/dir

    private $_relativePath = '';
    private $_file;


    public function init() {
        parent::init();
        $this->dataRootDir = FileHelper::normalizePath(Yii::$app->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $this->dataPathDir);
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'saveFile']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['size', 'status', 'cid', 'ctime', 'uid', 'utime'], 'integer'],
            [['name', 'type'], 'string', 'max' => 50],
            [['desc', 'path'], 'string', 'max' => 200],
            [['ext'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Desc',
            'type' => 'Type',
            'ext' => 'Ext',
            'size' => 'Size',
            'path' => 'Path',
            'status' => 'Status',
            'cid' => 'Cid',
            'ctime' => 'Ctime',
            'uid' => 'Uid',
            'utime' => 'Utime',
        ];
    }

    public function getFilePath($thumb = '') {
        if ($thumb)
            $thumb = '_' . $thumb;
        return $this->path . DIRECTORY_SEPARATOR . $this->name . $thumb . '.' . $this->ext;
    }

    public function generateName() {
        $this->name = sprintf('%s%s%d',
                md5($this->desc . Yii::$app->request->userIP),
                microtime(true) * 10000,
                mt_rand(1111, 9999));
    }


    public function loadFile($file) {
        $this->_file = $file;
        $this->desc = $file->name;
        $this->generateName();
        $this->type = $file->type;
        $this->size = $file->size;
        $pathinfo = pathinfo($file->name);
        $this->ext = strtolower($pathinfo["extension"]);  // Get extend
    }

    public function setRelativePath($folder, $userId = null) {
        $this->_relativePath = $folder;
        if (!$userId)
            $userId = Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->id;
        $this->path = $this->dataRootDir . DIRECTORY_SEPARATOR . $userId . DIRECTORY_SEPARATOR . $folder;
    }


    public static function download($url, $userId, $folder = 'download') {
        $file = new static();
        $file->generateName();
        $file->setRelativePath($folder, $userId);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //不显示网页内容
        curl_setopt($curl, CURLOPT_ENCODING, ''); //允许执行gzip
        curl_setopt($curl, CURLOPT_BINARYTRANSFER,1);

        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return null;
        }
        $info = curl_getinfo($curl);
        $file->type = $info['content_type'];
        $file->size = $info['size_download'];
        $ext = FileHelper::getExtensionsByMimeType($file->type);
        if (is_array($ext))
            $ext = $ext[count($ext) - 1];
        $file->ext = $ext;
        $file->desc = 'download';
        $file->_file = $data;
        return $file->save() ? $file : null;
    }

    protected function saveFile($event) {
        $model = $event->sender;
        $event->isValid = false;
        if (!$model->_file)
            return;
        if (!FileHelper::createDirectory($model->path))
            return;
        $filename = $model->path . DIRECTORY_SEPARATOR . $model->name . '.' . $model->ext;
        if ($model->_file instanceof \yii\web\UploadedFile) {
            $model->_file->saveAs($filename);
        } else {
            $fp = fopen($filename,'w');
            fwrite($fp, $model->_file);
            fclose($fp);
        }
        $event->isValid = true;
    }


    public function getThumbName($thumb) {
        $filePath = $this->getFilePath($thumb);
        if (file_exists($filePath))
            return $filePath;
        list($width, $height) = explode('x', $thumb);
        if ($this->createThumb($width, $height))
            return $filePath;
        return null;
    }

    public function createThumb($width = 30, $height = null) {
        $this->thumb ++;
        if (!$this->save()) {
            throw new ErrorException('保存缩略图出错.');
        }
        if (!$height)
            $height = $width;
        $thumb = new Thumb();
        $thumb->image = $this->filePath;
        $thumb->width = $width;
        $thumb->height = $height;
        $thumb->directory = $this->path . DIRECTORY_SEPARATOR;
        $thumb->defaultName = $this->name . '_' . $width .'x' . $height;
        $thumb->createThumb();
        return $thumb->save();
    }
}
