<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\MainModel;
use app\service\AcoWork;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($id = null)
    {
        $start_time = microtime(true); 
        $model = new MainModel();
        $service = new AcoWork($model, $id);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Yii::$app->request->post('delete-button')) {
                try {
                    $model->deleteCurrentFile();
                    Yii::$app->session->setFlash('success', Yii::t('app', 'The file has been deleted successfully'));
                } catch(\Exception $e) {
                     Yii::$app->session->setFlash('error', Yii::t('app', 'Error deleting a file, give access:') . ' chmod -R o+w ./web/uploads');
                }   
                return $this->redirect(['site/index']);
            } else {
                
                $id = $service->processValidModel();
                $end_time = microtime(true);
                $time = number_format($end_time - $start_time,10);
                return $this->redirect(['site/index', 'id' => $id,'time' => $time]);
            }
        }
        
        $log = $service->getLog();
        $end_time = microtime(true);
        $time = number_format($end_time - $start_time,10);
        return $this->render('index', ['model' => $model, 'log' => $log,'time' => $time]);
    }

    /**
     * upload action.
     *
     * @return Response|string
     */
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {   
                try {
                    if ($model->file->saveAs('@webroot/uploads/' . $model->file->baseName . '.' . $model->file->extension)) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'New file added successfully'));
                    }
                } catch(\Exception $e) {
                     Yii::$app->session->setFlash('error', Yii::t('app', 'Error uploading a file, give access:') . ' chmod -R o+w ./web/uploads');
                }
                
            }
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    
}
