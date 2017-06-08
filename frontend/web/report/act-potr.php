<?php
require_once 'fpdf.php';

$pdf = new FPDF();

$header = ['Место установки', 'Модель', 'Номер', 'Поверка',];
$hWidth = [90, 25, 50, 25];
$hHeight = 7;
$dHeight = 7;

$pdf->AddPage();
$pdf->AddFont('Times','','times.php');
$pdf->SetFont('Times','',10);

/* HEADER */

$x_date = yii::$app->request->get('date');
$checkDate = strtotime($x_date);
$company = common\models\Company::findOne(['id' => Yii::$app->session->get('companyId')]);
$pdf->Cell(45,8,mb_convert_encoding('Акт потребления на дату : ' . $x_date,'CP1251','UTF-8'));
$pdf->Ln();
$pdf->Cell(45,8,mb_convert_encoding($company->short_name,'CP1251','UTF-8'));
$pdf->Ln();
$cnt = new common\models\Counter;

for($i=0;$i<count($header);$i++)
   $pdf->Cell($hWidth[$i],$hHeight,mb_convert_encoding($header[$i],'CP1251','UTF-8'),1,'','C');
$pdf->Ln();

/* DETAIL */
//foreach ($cnt::find()->where(['date_verification' => time()])->orderBy('company_id')->each() as $row)
foreach ($cnt::find()->where(['company_id' => Yii::$app->session->get('companyId')])->each() as $row)
{
    $pdf->Cell(90,8,mb_convert_encoding($row->place, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(25,8,mb_convert_encoding($row->modelName, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(50,8,mb_convert_encoding( $row->num, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(25,8,mb_convert_encoding(date('d.m.Y', $row->date_verification), 'CP1251', 'UTF-8'),1);
    $pdf->Ln();
}

/* TOTAIL */

$pdf->Ln();

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
$headers = Yii::$app->response->headers;
$headers->add('Content-Type', 'application/pdf');

$pdf->Output();
unset($pdf);
unset($cnt);