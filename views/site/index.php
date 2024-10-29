<?php

/** @var yii\web\View $this */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\MainModel;

$this->title = 'ACO ';
?>
<div class="site-index">


    <div class="body-content">

                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'action' => ['site/index']]); ?>
        <div class="row source-part">
            <div class="col-sm-4">
                <?= $form->field($model, 'file')->listBox($model->getAllFiles(), ['style' =>['height' => '160px;']]) ?>
                <?= Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-outline-danger btn-sm', 'name' => 'delete-button', 'value'=>1,'style'=>'margin-bottom:5px;' ,
                    'disabled' => empty($model->getAllFiles()) , 'title' => Yii::t('app', 'Delete current image file'),
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this file?'),
                                    ]
                    ]) ?>
            </div>
            <div class="col-sm-8">
                <!-- <div style="display: none;"> -->
                <?= $form->field($model, 'sourceType')->radioList([
                        MainModel::SOURCE_DIFF => Yii::t('app', 'The colors of nodes on a graph are different from background color'),
                        MainModel::SOURCE_COLOR => Yii::t('app', 'We specify the color of nodes on a graph') 
                    ]) ?>
                <!-- </div> -->
                    
                <div id="our_color" style="float:right; height: 30px;width: 30px; background-color: white;"></div>
                <div class="row colors">
                      <div class="col-sm-4"> <?= $form->field($model, 'colorRed')->textInput() ?></div>
                      <div class="col-sm-4"><?= $form->field($model, 'colorGreen')->textInput() ?></div>
                      <div class="col-sm-4"><?= $form->field($model, 'colorBlue')->textInput() ?></div>
                   </div> 

                    <div style="display: none;">
                    <?= $form->field($model, 'margin')->textInput()->hint(Yii::t('app', 'When we find a pixel we need we ignore other pixels within it\'s margins')) ?> 
                    </div>
                                 
            </div>
        </div>
        <div class="aco-part row" style="display:none">
            <?php 
            $url = Yii::$app->language == 'en-US' ? 'https://github.com/mgrechanik/ant-colony-optimization?tab=readme-ov-file#terminology--' 
                    : 'https://github.com/mgrechanik/ant-colony-optimization/blob/main/docs/README_ru.md#terminology';
            ?>
                 <div class="col-sm-3"> <?= $form->field($model, 'iterations')->textInput() ?></div>
                 <div class="col-sm-3"> <?= $form->field($model, 'anttype')->dropDownList([
                    MainModel::ANT_CLASSIC => Yii::t('app', 'Classic'),
                    MainModel::ANT_ELITIST => Yii::t('app', 'Elitist ants'),
                 ]) ?></div>
                 
                 <div class="col-sm-3 "> 
                     <?php 
                        print Html::activeLabel($model, 'mpercent', ['class' => 'form-label']);                 
                        print $field = $form->field($model, 'mpercent', [
                            'template' => "{input}\n<span class=\"input-group-text\">%</span>\n{hint}\n{error}",
                            'options' => [ 'class' => 'mb3 input-group']
                        ])->textInput();
                      ?>                 
                 </div>
                 <div class="col-sm-3"> <?= $form->field($model, 'm')->textInput() ?></div>
                 
                 <div class="col-sm-2 sigma"> 
                     <?php 
                        print Html::activeLabel($model, 'sigmapercent', ['class' => 'form-label']);                 
                        print $field = $form->field($model, 'sigmapercent', [
                            'template' => "{input}\n<span class=\"input-group-text\">%</span>\n{hint}\n{error}",
                            'options' => [ 'class' => 'mb3 input-group']
                        ])->textInput();
                      ?>
                 </div>
                 <div class="col-sm-2 sigma"> <?= $form->field($model, 'sigma')->textInput() ?></div>                 
        </div>
        <div class="aco-part row" style="display:none">
                 <div class="col-sm-2"> <?= $form->field($model, 'alpha')->textInput() ?></div>
                 <div class="col-sm-2"> <?= $form->field($model, 'beta')->textInput() ?></div>
                 <div class="col-sm-2"> <?= $form->field($model, 'p')->textInput() ?></div>
                 <div class="col-sm-2"> <?= $form->field($model, 'c')->textInput() ?></div>
                 <div class="col-sm-2"> <?= $form->field($model, 'q')->textInput() ?></div>
        </div>        
        

                    <div class="form-group" style="padding-top: 20px;">
                        <?= Html::submitButton(Yii::t('app', 'Build a path'), ['class' => 'btn btn-primary', 'name' => 'process-button']) ?>
                    </div>        
                    

        <table class="imagedemo">
            <tr>
                <th><?= Yii::t('app', 'Source image') ?></th><th>&nbsp;</th><th><?= Yii::t('app', 'Result image') ?></th>
            </tr>
            <tr>
                <td id=""><a id="a-source" href="#" target="_blank"><img id="img-source" width="400"></a></td><td style="font-size: 72px;">&#8680</td>
                <td class="img-res">
                    <?php 
                        if (isset($log['file_res'])) {
                            print Html::a(Html::img($log['file_res'], ['width' => 400]), $log['file_res'], ['target' => '_blank']);
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td  class="img-res">
                    <?php 
                        if (isset($log['distance'])) {
                            print Yii::t('app', 'Distance ');
                            print ' - <strong>' . $log['distance'] . '</strong>';
                        }
                        if (isset($log['innerPath'])) {
                            print '<hr>' . Yii::t('app', 'Calculated Path');
                            print ' - <strong>' . implode(', ', $log['innerPath']) . '</strong>';
                            
                            print '<hr>' . Yii::t('app', 'Calculation Time (in microseconds)');
                            print ' - <strong>' . $time . '</strong>';
                        }                      
                    ?>
                </td>
            </tr>            
        </table>

                <?php ActiveForm::end(); ?>

    </div>
</div>
