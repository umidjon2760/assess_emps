<?php
use yii\helpers\Html;
use app\models\Users;
use app\models\Slides;
use kartik\editable\Editable;
$this->title = 'Слайдлар';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index card">
    <div class="card-body">
    <?php
        echo "<label>Слайд юклаш</label>";
        echo Html::beginForm(['/site/slide-upload'], 'post',['enctype' => 'multipart/form-data']);
        echo Html::input('file', 'myfile[]', '',['class' => 'myfile-class','id'=>'rasm','multiple'=>true,'required'=>'required','accept'=>'image/*']);
        echo "<br>";
        echo "<br><input type='submit' value='Юклаш'' class='btn btn-success btn-sm' />";
        echo Html::endForm();
        echo "<br>";
        $slides = Slides::find()->orderBy(['ORD'=>SORT_DESC])->all();
        if ($slides) {
            echo "<table class='table table-bordered'>";
            echo "<tr>";
            echo "<th style='width:3%;text-align:center;'>#</th>";
            echo "<th style='width:50%;'>Номи</th>";
            echo "<th style='width:7%;text-align:center;'>Тартиб</th>";
            echo "<th style='width:3%;text-align:center;'>Ўчириш</th>";
            echo "</tr>";
            $n = 1;
            foreach ($slides as $slide) {
                $name = substr($slide->URL,44);
                echo "<tr>";
                echo "<td style='text-align:center;'>".$n."</td>";
                echo "<td><a href='?r=site/download-file&url=".$slide->URL."'>".$name."</a></td>";
                // echo "<td style='text-align:center;'>".$slide->ORD."</td>";
                echo "<td style='text-align:center;'>".
                Editable::widget([
                    'model'=>$slide, 
                    'attribute' => 'ORD',
                    'asPopover' => false,
                    'inputType' => Editable::INPUT_TEXT,
                    'size'=>'lg',
                    'formOptions' => [
                        'action' => '?r=site/saveinfo&id='.$slide->ID,
                        'method' => 'post',
                    ],
                    'options' => [
                        'class'=>'form-control', 
                        'rows'=>5, 
                        'style'=>'width:100px', 
                        'placeholder'=>'Тартиб рақам',
                        'id'=>'slide'.$slide->ID,
                    ]
                ])
                ."</td>";
                echo "<td style='text-align:center;'><a href='?r=site/delete-slide&id=".$slide->ID."' data-confirm='Ростдан хам ўчирмоқчимисиз?' class='btn btn-danger'>Ўчириш</a></td>";
                echo "</tr>";
                $n++;
            }
            echo "</table>";
        }
    ?>

    </div>
</div>


