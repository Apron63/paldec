<?php
require_once 'fpdf.php';

$pdf = new FPDF();

$header = ['Организация', 'Расход'];
$hWidth = [150, 30];
$hHeight = 7;
$dHeight = 7;

$pdf->AddPage();
$pdf->AddFont('Times','','times.php');
$pdf->SetFont('Times','',10);

/* HEADER */

$x_date = yii::$app->request->get('date');
$checkDate = strtotime($x_date);
$firstBreak = true;
$pdf->Cell(45,8,mb_convert_encoding('Сводный акт потребления на дату : ' . $x_date,'CP1251','UTF-8'));
$pdf->Ln();
$cnt = new common\models\Counter;

for($i=0;$i<count($header);$i++)
   $pdf->Cell($hWidth[$i],$hHeight,mb_convert_encoding($header[$i],'CP1251','UTF-8'),1,'','C');
$pdf->Ln();
$tot = 0;
$sum = 0;
$company = 0;

/* DETAIL */
foreach ($cnt::find()
    ->andWhere(['arh' => false])
    ->orderBy('company_id')
    ->each() as $row)
{
    if ($firstBreak) {
        $company = $row->company_id;
        $firstBreak = false;
    }

    if ($row->company_id != $company) {
        $pdf->Cell(150,8,mb_convert_encoding(common\models\Company::findOne(['id' => $company])->short_name, 'CP1251', 'UTF-8'),1);
        $pdf->Cell(30,8,mb_convert_encoding($tot, 'CP1251', 'UTF-8'),1, 0, 'R');
        $pdf->Ln();
        $company = $row->company_id;
        $tot = 0;
    }
    $b = $row->getPrevReading($row->id, $checkDate);
    $e = $row->getCurrentReading($row->id, $checkDate);
    $c = $e - $b;
    $tot += $c;
    $sum += $c;
}

/* TOTAIL */
if (!$firstBreak) {
    $pdf->Cell(150,8,mb_convert_encoding(common\models\Company::findOne(['id' => $company])->short_name, 'CP1251', 'UTF-8'),1);
    $pdf->Cell(30,8,mb_convert_encoding($tot, 'CP1251', 'UTF-8'),1, 0, 'R');
    $pdf->Ln();
}

$pdf->Cell(150,8,mb_convert_encoding('ИТОГО', 'CP1251', 'UTF-8'),1);
$pdf->Cell(30,8,mb_convert_encoding($sum, 'CP1251', 'UTF-8'),1, 0, 'R');
$pdf->Ln();

Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
$headers = Yii::$app->response->headers;
$headers->add('Content-Type', 'application/pdf');

$pdf->Output();
unset($pdf);
unset($cnt);