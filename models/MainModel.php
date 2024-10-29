<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Main model
 */
class MainModel extends Model 
{
    const SOURCE_DIFF = 1;
    const SOURCE_COLOR = 2;
    
    const ANT_CLASSIC = 1;
    const ANT_ELITIST = 2;
    
    public $file = '';
    
    public $sourceType = self::SOURCE_DIFF;
    
    public $colorRed = 0;
    
    public $colorGreen = 0;
    
    public $colorBlue = 0;
    
    public $margin = 15;
    
    public $iterations = 200;
    
    public $anttype = self::ANT_CLASSIC;
    
    public $mpercent = 40;
    
    public $m;
    
    public $sigmapercent = 50;
    
    public $sigma;  
    
    public $alpha = 1;
    
    public $beta = 5;
    
    public $p = 0.1;
    
    public $c = 1;
    
    public $q = 100;
    
    protected $allFiles = [];
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file', 'sourceType', 'margin', 'iterations', 'anttype',
                'alpha', 'beta', 'p', 'c', 'q'], 'required'],
            [['file'], 'in', 'range' => array_keys($this->getAllFiles())],
            [['sourceType'], 'in', 'range' => [self::SOURCE_DIFF, self::SOURCE_COLOR]],
            [['anttype'], 'in', 'range' => [self::ANT_CLASSIC, self::ANT_ELITIST]],
            [['colorRed', 'colorGreen', 'colorBlue'], 'integer', 'min' => 0, 'max' => 255 ],
            [['margin'], 'integer', 'min' => 1, 'max' => 150 ],
            [['iterations'], 'integer', 'min' => 1, 'max' => 1000 ],
            [['colorRed', 'colorGreen', 'colorBlue'], 'required', 
                'when'  => function($model) {
                    return $model->isTypeColor();
                },
                'whenClient' => "function (attribute, value) {
                        return $('input:radio:checked[name=\'MainModel[sourceType]\']').val() == 2;
                 }"                        
            ],
            [['mpercent', 'sigmapercent'], 'integer', 'min' => 1, 'max' => 1000],
            [['m', 'sigma', 'c', 'q'], 'integer', 'min' => 1 ],
            [['p', 'alpha', 'beta'], 'number', 'min' => 0.001 ],
            [['m'], 'required', 
                'when'  => function($model) {
                    return empty($model->mpercent);
                },
                'whenClient' => "function (attribute, value) {
                        return $('#mainmodel-mpercent').val() == '';
                 }"                  
            ],
            [['sigma'], 'required', 
                'when'  => function($model) {
                    return $model->isElitistType() && empty($model->sigmapercent);
                },
                'whenClient' => "function (attribute, value) {
                        return ($('#mainmodel-anttype').val() == 2) && ( $('#mainmodel-sigmapercent').val() == '');
                 }"                  
            ],                        
        ];
    }
    
    public function attributeLabels() {
        return [
            'file' => Yii::t('app', 'Image file with a graph'),
            'sourceType' => Yii::t('app', 'The type of strategy to find the nodes of graph'),
            'colorRed' => Yii::t('app', 'Red value of RGB'),
            'colorGreen' => Yii::t('app', 'Green value of RGB'),
            'colorBlue' => Yii::t('app', 'Blue value of RGB'),
            'margin' => Yii::t('app', 'Margin value between graph nodes'),
            'iterations' => Yii::t('app', 'Amount of iterations'),
            'anttype' => Yii::t('app', 'ACO strategy'),
            'mpercent' => Yii::t('app', 'Percent of ants'),
            'm' => Yii::t('app', 'Amount of ants'),
            'sigmapercent' => Yii::t('app', 'Percent of elitist ants'),
            'sigma' => Yii::t('app', 'Amount of elitist ants'),            
        ];
    }    
    
    public function getAllFiles() {
        if ($this->allFiles) {
            return $this->allFiles;
        }
        $res = [];
        $dir = Yii::getAlias('@webroot/uploads/');
        $glob = glob($dir . '*.{jpg,jpeg}', GLOB_BRACE);
        if ($glob) {
            foreach ($glob as $val) {
                $info = pathinfo($val);
                $res[$info['basename']] = $info['basename'];
            }
        }
        return $this->allFiles = $res;
    }
    
    public function setFirstFile() {
        if ($files = $this->getAllFiles()) {
            $val = array_shift($files);
            $this->file = $val;
        }
    }
    
    public function saveToSession() {
        $session = Yii::$app->session;
        $session->set('mainmodel', serialize($this->attributes));
    }
    
    public function loadFromSession() {
        $session = Yii::$app->session;
        if ($data = $session->get('mainmodel')) {
            $this->setAttributes(unserialize($data));
        }
    }  
    
    public function isTypeColor() {
        return $this->sourceType == self::SOURCE_COLOR;
    }
    
    public function isElitistType() {
        return $this->anttype == self::ANT_ELITIST;
    }    
    
    public function deleteCurrentFile() {
        $dir = Yii::getAlias('@webroot/uploads/');
        $file = $dir . $this->file;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
