<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Query';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?php
        if (isset($str)) {
        	$value = $str;
        }
        else{
        	$value = '';
        }
        ?>
       	<input type="text" id="zapros" class="form-control" name="zapros" value="<?=$value?>"><br>
        <div class="form-group">
            <?= Html::submitButton('Query', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php
        if (isset($str)) {
        	$rows = Yii::$app->db->createCommand($str)->queryAll();
        	if (isset($rows[0])) {
        		$col_arr = [];
        		foreach ($rows[0] as $key => $value) {
        			$col_arr[] = $key;
        		}
    			echo "<table border='1'>";
	        	echo "<tr style='background:#F0F0F0;'>";
	        	echo "<td style='position: sticky; top: 0;background:#F0F0F0;'><b>#</b></td>";
	        	foreach ($col_arr as $column) {
	        		echo "<td style='position: sticky; top: 0;background:#F0F0F0;'><b>".$column."</b></td>";
	        	}
	        	echo "</tr>";
	        	$n = 1;
	        	$check = 0;
	        	foreach ($rows as $key) {
	        		$color = '#E5FFE5';
	        		echo "<tr >";
	        		echo "<td style='background:".$color.";'>".$n."</td>";
	        		foreach ($col_arr as $col) {
	        			if (strlen($key[$col])>0) {
	        				echo "<td style='background:".$color.";'>".$key[$col]."</td>";
	        			}
	        			else{
	        				echo "<td style='background:#FFFFE5;'>".$key[$col]."</td>";
	        			}
	        		}
	        		echo "</tr>";
	        		$n++;
	        	}
	        	echo "</table>";
        	}
        	else{
        		echo "<h3><i>Маълумот топилмади!</i></h3>";
        	}
        }
        ?>
    </div>
</div>
<style type="text/css">
	td{
		font-family: 'Times New Roman';
		font-size: 9pt;
		padding-left: 5px;
	}
</style>
