<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\AccessMatrix;

use app\models\Emp;
use app\models\AdminNotes;
use app\models\JoriyVazifa;
use app\models\Users;
use app\models\Period;
use app\models\NmBbKirit;
use app\models\NmBbSend;
use app\modules\mj\models\JoriyEmp;
use app\modules\depupr\models\DepuprSession;
use app\modules\depupr\models\DepuprSend;
use app\modules\depupr\models\DepuprHodimlar;
use app\models\BahoKpiMalumot;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CrontabController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    /*
    30 5 1,20 * * php /var/www/html/hamkor.hr/yii crontab/zagr-otchet
    9 9 * * * php /var/www/html/hamkor.hr/yii crontab/send-nm-bb
    8 8 * * * php /var/www/html/hamkor.hr/yii crontab/send-dep-upr
    * * * * * php /var/www/html/hamkor.hr/yii crontab/send-mail
    */
    public function actionCronTest()
    {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO cron_test VALUES(NULL,'{$date}')";
        Yii::$app->db1->createCommand($query)->execute();
        echo "ok";
    }

    public function actionSendMail()
    {
        $date = date('H:i:s d.m.Y');
        Yii::$app->mailer->compose()->setFrom(['webmaster@hamkorbank.uz'=>'Тест'])->setTo('u.ahmadjonov@hamkorbank.uz')->setSubject('Soat : '.$date)->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>Soat : '.$date.'</b></p>')->send();
        Users::SendSms('+998905362760',$date);
        // echo "ok";
    }

    public function actionZagrOtchet()
    {
        ////////////////////////----zagr download----  “At 05:30 on day-of-month 1 and 20.”///////////////////////////////////
        $yesterday = date('d.m.Y',strtotime("-1 days"));
        $yesterday_database_format = date('d-M-Y',strtotime("-1 days"));
        $sql = "select * from prm_zagr where kun='{$yesterday}'";
        $row = Yii::$app->db1->createCommand($sql)->queryAll();
        if (!count($row)>0) {
            $today = date('d_m_Y');
            $sql1 = "INSERT INTO prm_zagr VALUES(NULL,'{$yesterday}')";
            $row1 = Yii::$app->db1->createCommand($sql1)->execute();
            $sqlls = "CALL PRM_TEST_ZAGR.zagrauto('".$yesterday_database_format."')";
            Yii::$app->db->createCommand($sqlls)->execute();
            $text = date('d.m.Y H:i:s').' vaqtda zagr yuklandi (cron)';
            Users::SendSms('+998905362760',$text);
        };
        ////////////////////////---- end zagr download----///////////////////////////////////
    }

    public function actionSendNmBb()
    {
        ////////////////////////---- send nmbbsend----///////////////////////////////////
        $armids = NmBbKirit::getKiritArmids();
        foreach ($armids as $armid) {
            $cbid = JoriyEmp::getCbidByArm($armid);
            if ($cbid!='no cbid') {
                if (!NmBbKirit::hasNMinArm($cbid)) {
                    $email = Users::getEmail($cbid);
                    Yii::$app->mailer->compose()->setFrom(['webmaster@hamkorbank.uz'=>'Эътироф этиш'])->setTo($email)->setSubject('Ассалому алайкум, утган ой якунлари буйича йуналишга белгиланган вазифаларни бажаришда фаол бўлган йўналиш рахбарлари ва ходимларни эътироф этишингизни сўраймиз.')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>Ассалому алайкум, утган ой якунлари буйича йуналишга белгиланган вазифаларни бажаришда фаол бўлган йўналиш рахбарлари ва ходимларни эътироф этишингизни сўраймиз.Ходимларни ушбу <a href="https://web-portal.hamkorbank.uz/hamkor.hr/web/index.php?r=nm-bb-kirit/nmemps">Эътироф этиш</a> тугмаси ёки Ўзгарувчан иш ҳақи ҳисоблаш тизими Номоддий рағбатлантириш бўлими орқали эътироф этишингиз мумкин.</b></p>')->send();
                    $send = new NmBbSend;
                    $send->arm_id = $armid;
                    $send->kun = date('Y-m-d');
                    $send->save(false);
                }
                else{
                    continue;
                }
            }
            else{
                continue;
            }
        }
        $text = "Nomoddiy jonatildi";
        Yii::$app->mailer->compose()->setFrom(['webmaster@hamkorbank.uz'=>'Эътироф этиш'])->setTo('u.ahmadjonov@hamkorbank.uz')->setSubject('Nomoddiy jonatildi')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>Nomoddiy jonatildi</b></p>')->send();
        // Users::SendSms('+998905362760',$text);
        ////////////////////////---- end send nmbbsend----///////////////////////////////////
    }

    public function actionSendDepUpr()
    {
        ////////////////////////---- send depupr----///////////////////////////////////
        $cbids = DepuprSession::geAlltSessionOne1();
        foreach ($cbids as $cbid => $baholash_id) {
            $email = Users::getEmail($cbid);
            $lokal = DepuprHodimlar::getLocalCode($baholash_id,$cbid);
            if ($lokal=='00000') {
                $matn = 'Ўтган чорак якунлари буйича филиал бошқарувчиларини бахолашингиз сўралади.';
            }
            else{
                $matn = 'Ўтган чорак якунлари буйича Бош банкдаги департамент директорлари ва алохида йуналиш рахбарларини бахолашингиз сўралади.';
            }
            Yii::$app->mailer->compose()->setFrom(['webmaster@hamkorbank.uz'=>'Рахбарларни бахолаш'])->setTo($email)->setSubject($matn)->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>'.$matn.'</b><br><b>Қуйидаги тугма ёки манзил орқали кирилади:<br>1. <a href="https://web-portal.hamkorbank.uz/hamkor.hr/web/index.php?r=depupr%2Fdepupr-baholash%2Fuprviewplus">Рахбарларни бахолаш</a><br>2. https://web-portal.hamkorbank.uz/hamkor.hr/web/index.php?r=depupr%2Fdepupr-baholash%2Fuprviewplus</b></p>')->send();
            $send = new DepuprSend;
            $send->cbid = $cbid;
            $send->baholash_id = $baholash_id;
            $send->date = date('Y-m-d');
            $send->save(false);
        }
        $text = "Raxbarlarni baholash jonatildi";
        Yii::$app->mailer->compose()->setFrom(['webmaster@hamkorbank.uz'=>'Рахбарларни бахолаш'])->setTo('u.ahmadjonov@hamkorbank.uz')->setSubject('Raxbarlarni baholash jonatildi')->setHtmlBody('<p style="font-size:16pt; color:green;font-family:Century Gothic;"><b>Raxbarlarni baholash jonatildi</b></p>')->send();
        // Users::SendSms('+998905362760',$text);
        ////////////////////////---- end send depupr----///////////////////////////////////
    }
}
