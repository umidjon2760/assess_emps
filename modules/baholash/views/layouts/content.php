<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use app\models\AccessMatrix;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="mb-2 text-dark">
                        <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-12">
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => [
                            'class' => 'float-sm-left'
                        ]
                    ]);
                    ?>
                    <div class="scroll-div-right fl-right">
                        <div id="up" class="ontopup"><p class="pPageScroll"><i class="fas fa-arrow-up"></i></p></div>
                        <div id="down" class="ontopdown"><p class="pPageScroll"><i class="fas fa-arrow-down"></i></p></div>
                    </div>
                    <?php
                    //if (!AccessMatrix::getAccess('admin',Yii::$app->user->ID)) {
                    
                    //   echo '<div class="onbottomdown1" id="up1">
                    //   <a class="button"  href="/test/" role="button">Сўровномада қатнашинг</a>
                    // </div>';
                    //}
                    ?>
                    
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<style type="text/css">


/*html, body {
  height: 100%;
}*/

.wrap {
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.button {
  min-width: 300px;
  min-height: 60px;
  font-family: 'Nunito', sans-serif;
  font-size: 22px;
  text-transform: uppercase;
  letter-spacing: 1.3px;
  font-weight: 700;
  color: #313133;
  background: #4FD1C5;
background: linear-gradient(90deg, rgba(129,230,217,1) 0%, rgba(79,209,197,1) 100%);
  border: none;
  border-radius: 1000px;
  box-shadow: 12px 12px 24px rgba(79,209,197,.64);
  transition: all 0.3s ease-in-out 0s;
  cursor: pointer;
  outline: none;
  position: relative;
  padding: 10px;
  }

.button::before {
content: '';
  border-radius: 1000px;
  min-width: calc(300px + 12px);
  min-height: calc(60px + 12px);
  border: 6px solid #00FFCB;
  box-shadow: 0 0 60px rgba(0,255,203,.64);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  opacity: 0;
  transition: all .3s ease-in-out 0s;
}

.button:hover, .button:focus {
  color: #313133;
  transform: translateY(-6px);
}

.button:hover::before, .button:focus::before {
  opacity: 1;
}

.button::after {
  content: '';
  width: 30px; height: 30px;
  border-radius: 100%;
  border: 6px solid #00FFCB;
  position: absolute;
  z-index: -1;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation: ring 1.5s infinite;
}

.button:hover::after, .button:focus::after {
  animation: none;
  display: none;
}

@keyframes ring {
  0% {
    width: 30px;
    height: 30px;
    opacity: 1;
  }
  100% {
    width: 300px;
    height: 300px;
    opacity: 0;
  }
}


    .content-wrapper>.content{
        padding-bottom: 50px;
    }
    #up1
{

position:fixed;

z-index: 1050;
}
.onbottomdown1{
top:880px;
right:60px;
/*display: none;*/
}
    #up
{
width:30px;
height:30px;
position:fixed;
background-color:#28a745;
border-radius:30px;
z-index: 1050;
}
.ontopup{
top:60px;
right:20px;
display: none;
}
.onbottomup{
bottom:60px;
right:20px;
}
#down
{
width:30px;
height:30px;
position:fixed;
background-color:#28a745;
border-radius:30px;
z-index: 1050;
}
.ontopdown{
top:60px;
right:20px;
}
.onbottomdown{
bottom:60px;
right:60px;
display: none;
}
.pPageScroll
{
color:#FFFFFF;
font-size:14px;
text-align:center;
padding-top: 5px;
}
</style>
<script src="js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
//Обработка нажатия на кнопку "Вверх"
$("#up").click(function(){
//Необходимо прокрутить в начало страницы
var curPos=$(document).scrollTop();
var scrollTime=curPos/7.73;
$("body,html").animate({"scrollTop":0},scrollTime);
$("#up").addClass("ontopup");
$("#up").removeClass("onbottomup");
$("#down").addClass("ontopdown");
$("#down").removeClass("onbottomdown");
});

//Обработка нажатия на кнопку "Вниз"
$("#down").click(function(){
//Необходимо прокрутить в конец страницы
var curPos=$(document).scrollTop();
var height=$("body").height();
var scrollTime=(height-curPos)/7.73;
$("body,html").animate({"scrollTop":height},scrollTime);
$("#up").removeClass("ontopup");
$("#up").addClass("onbottomup");
$("#down").removeClass("ontopdown");
$("#down").addClass("onbottomdown");
});
});
</script>