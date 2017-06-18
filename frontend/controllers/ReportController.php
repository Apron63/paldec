<?php
namespace frontend\controllers;
require_once ('report/fpdf.php');

use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionCounterExpired()
    {
        require 'report/document.php';
    }

    public function actionActPotr()
    {
        require 'report/act-potr.php';
    }

    public function actionActSvod()
    {
        require 'report/act-svod.php';
    }
}
