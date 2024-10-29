<?php

namespace app\service;

use mgrechanik\imagepointssearcher\Searcher;
use mgrechanik\imagepointssearcher\ImageResult;
use mgrechanik\imagepointssearcher\ChoosenColorStrategy;
use mgrechanik\aco\Manager;
use mgrechanik\aco\City;
use app\models\MainModel;
use Yii;

class AcoWork
{
    protected MainModel $model;
    
    protected array $log = [];
    
    public function __construct(MainModel $model, $id) {
        $this->model = $model;
        $this->model->setFirstFile();
        $this->model->loadFromSession();    
        $session = Yii::$app->session;
        $key = 'result' . $id;
        if ($id && $session->has($key)) {
            if ($data = $session->get($key)) {
                $this->log = unserialize($data);
                $session->remove($key);
            }
        }        
    }
    
    public function processValidModel() {
        
        $model = $this->model; 
        $model->saveToSession();
        $session = Yii::$app->session;
        $id = uniqid();
        $log = [];
        $file = Yii::getAlias('@webroot/uploads/' . $model->file);
        $file_res = Yii::getAlias('@webroot/uploads/result/' . $model->file);
        $log['file_res'] = '/uploads/result/' . $model->file;

        try {
            $strategy = null;
            if ($model->isTypeColor()) {
                $strategy = new ChoosenColorStrategy(intval($model->colorRed), intval($model->colorGreen), intval($model->colorBlue));
            }
            $searcher = new Searcher(
              $file, $strategy, $model->margin
            );
            $count = $searcher->run();
            if ($count < 2 || $count > 250) {
                throw new \Exception(Yii::t('app', 'Amount of nodes found need to be from 2 to 250 when we found on your image this amount of nodes') . ' - ' . $count);
            }
            $log['points_count'] = $count;
            $points = $searcher->getPoints();
            foreach ($points as $point) {
                $cities[] = new City($point['x'], $point['y']);
            }                
            $finder = $model->isElitistType() ? new \mgrechanik\aco\elitist\Finder() : new \mgrechanik\aco\classic\Finder();
            $manager = new Manager(finder : $finder);
            $manager->setCities(...$cities);    
            $finder->setAlpha($model->alpha);
            $finder->setBeta($model->beta);
            $finder->setP($model->p);
            $finder->setC($model->c);
            $finder->setQ($model->q);
            if ($model->mpercent) {
                $finder->setMPercent($model->mpercent);
            } else {
                $finder->setM($model->m);
            }
            if ($model->isElitistType()) {
                if ($model->sigmapercent) {
                    $finder->setSigmaPercent($model->sigmapercent);
                } else {
                    $finder->setSigma($model->sigma);
                }                    
            }
            $res = $manager->run($model->iterations);

            if (!$res) {
                throw new \Exception(Yii::t('app', 'Something went wrong. Unable to build a path'));
            }

            $log['distance'] = $res;
            $log['innerPath'] = $innerPath = $manager->getInnerPath();


            $imageResult = new ImageResult($searcher);

            $imageResult->setLabelsColor(1, 14, 230);
            $imageResult->setLinesColor(255, 33, 73);
            $imageResult->setMarginsColor(255, 106, 0);
            $imageResult->drawLabels();
            $imageResult->drawMargins();
            $imageResult->drawPath($innerPath);
            $imageResult->save($file_res);


            $session->setFlash('success', Yii::t('app', 'The path has been found successfully'));
        } catch (\Exception $e) {
            $id = null;
            $session->setFlash('error', $e->getMessage());
        }            
        if ($id) {
            $log2 = serialize($log);
            
            $session->set('result' . $id, $log2);
        }
        $this->log = $log;
        return $id;
    }
    
    public function getLog() {
        return $this->log;
    }
    
    
}


