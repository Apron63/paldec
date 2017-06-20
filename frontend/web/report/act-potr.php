<?php
require_once 'fpdf.php';

$company_id = Yii::$app->session->get('companyId');
if(!isset($company_id)) return;

$pdf = new FPDF();

$header = ['Место установки', 'Модель', 'Номер счетчика', 'Номер пломбы','Нач', 'Кон', 'Расход'];
$hWidth = [40, 25, 35, 35, 15, 15, 15];
$hHeight = 7;
$dHeight = 7;

$pdf->AddPage();
$pdf->AddFont('Times','','times.php');
$pdf->SetFont('Times','',10);

/* HEADER */

$x_date = yii::$app->request->get('datex');
$checkDatex = strtotime($x_date);
$y_date = yii::$app->request->get('datey');
$checkDatey = strtotime($y_date);

$company = common\models\Company::findOne(['id' => $company_id]);
$pdf->Cell(45,8,mb_convert_encoding('Акт потребления с : ' . $x_date . ' по : ' . $y_date,'CP1251','UTF-8'));
$pdf->Ln();
$pdf->Cell(45,8,mb_convert_encoding($company->short_name,'CP1251','UTF-8'));
$pdf->Ln();
$cnt = new common\models\Counter;

for($i=0;$i<count($header);$i++)
   $pdf->Cell($hWidth[$i],$hHeight,mb_convert_encoding($header[$i],'CP1251','UTF-8'),1,'','C');
$pdf->Ln();
$tot = 0;

/* DETAIL */
//foreach ($cnt::find()->where(['date_verification' => time()])->orderBy('company_id')->each() as $row)
foreach ($cnt::find()
    ->where(['company_id' => Yii::$app->session->get('companyId')])
    ->andWhere(['arh' => false])
    ->each() as $row)
{
    $b = $row->getPrevReading($row->id, $checkDatex);
    $e = $row->getCurrentReading($row->id, $checkDatey);
    $c = $e - $b;
    $tot += $c;

    $pdf->Cell(40,8,mb_convert_encoding($row->place, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(25,8,mb_convert_encoding($row->modelName, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(35,8,mb_convert_encoding( $row->num, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(35,8,mb_convert_encoding($row->seal, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(15,8,mb_convert_encoding($b, 'CP1251', 'UTF-8'),1,0,'R');
    $pdf->Cell(15,8,mb_convert_encoding($e, 'CP1251', 'UTF-8'),1, 0, 'R');
    $pdf->Cell(15,8,mb_convert_encoding($c, 'CP1251', 'UTF-8'),1, 0, 'R');
    $pdf->Ln();
}

/* TOTAIL */

$pdf->Cell(165,8,mb_convert_encoding('ИТОГО', 'CP1251', 'UTF-8'),1);
$pdf->Cell(15,8,mb_convert_encoding($tot, 'CP1251', 'UTF-8'),1, 0, 'R');
$pdf->Ln();

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
$headers = Yii::$app->response->headers;
$headers->add('Content-Type', 'application/pdf');

$pdf->Output();
unset($pdf);
unset($cnt);