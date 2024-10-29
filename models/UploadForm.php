<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'image', 'extensions' => 'jpeg, jpg', 'minWidth' => 100, 'minHeight' => 100],
        ];
    }
    
    public function attributeLabels() {
        return ['file' => \Yii::t('app', 'Image file with a graph')];
    }
}
