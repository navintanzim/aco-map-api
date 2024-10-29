<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;
use app\models\UploadForm;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);


$uploadModel = new UploadForm();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' =>Yii::t('app', ' Solving the Travelling salesman problem by Ant colony optimization.'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
   

    NavBar::end();
    ?>
    
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        
<div class="row">
    <div class="col-sm-9">
    
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>    
    <div class="col-sm-3">
            <p><?= Yii::t('app', 'Uploading a new image file with a graph') ?></p>
            <?php $form = ActiveForm::begin(['action' => ['site/upload'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($uploadModel, 'file')->fileInput() ?>



            <div class="form-group">
                <div>
                    <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary', 'name' => 'upload-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>        
    </div>
</div>    
        
        
        
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
   
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
