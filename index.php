<?php

require_once 'vendor/autoload.php';

$token = ''; // токен из хаба
$name = 'Урганаев Мустафа Гаджиаттаевич';
$job = 'Программист';
$month = 'Май';
$baseUrl = 'http://youtrack.etpgpb.local';

// Instantiate PSR-7 HTTP Client
$psrHttpClient = new \GuzzleHttp\Client([
  'base_uri' => $baseUrl,
]);

// Instantiate YouTrack API HTTP Client Adapter
$httpClient = new \Cog\YouTrack\Rest\HttpClient\GuzzleHttpClient($psrHttpClient);

// Instantiate YouTrack API Token Authorizer
$authorizer = new \Cog\YouTrack\Rest\Authorizer\TokenAuthorizer($token);

// Instantiate YouTrack API Client
$youtrack = new \Cog\YouTrack\Rest\Client\YouTrackClient($httpClient, $authorizer, 'api');

/*$response = $youtrack->get('/admin/users/me?fields=login,fullName,jabberAccountName,ringId,guest,online,banned,tags(name),avatarUrl');// В этом месяце
$responseArray = json_decode($response->body(), true);
echo '<pre>';
print_r($responseArray);
exit;*/

$response = $youtrack->get('/workItems?fields=duration(minutes,presentation),date,issue(id,summary,numberInProject,project(shortName)),author(id)&author=m.urganaev&startDate=2021-05-01&endDate=2021-06-01');// В этом месяце
$responseArray = json_decode($response->body(), true);

$list = [];
$sumMinutes = 0;
foreach ($responseArray as $timeTracking) {
  $list[date('d.m', ((int) $timeTracking['date']) / 1000)][] = [
    $timeTracking['issue']['summary'],
    $timeTracking['issue']['project']['shortName'] . '-' . $timeTracking['issue']['numberInProject'],
    $timeTracking['duration']['presentation']
  ];

  $sumMinutes += $timeTracking['duration']['minutes'];
}

ksort($list);

echo "<pre>";
print_r($list);
echo ($sumMinutes / 60) . 'ч';
/*echo "\n";
echo json_encode($list);*/





/*$sumMinutes = 80*60;
$list = '{"04.05":[["\u041f\u0440\u0438 \u043f\u043e\u0434\u043f\u0438\u0441\u0430\u043d\u0438\u0438 \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a\u043e\u043c \u0434\u043e\u043f. \u0441\u043e\u0433\u043b\u0430\u0448\u0435\u043d\u0438\u044f \u043e\u0442\u043f\u0440\u0430\u0432\u043b\u044f\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u0435 \u0441\u043e\u043e\u0442\u0432\u0435\u0442\u0441\u0442\u0432\u0443\u044e\u0449\u0438\u0435 \u0441\u043e\u0431\u044b\u0442\u0438\u044e","etpgpb-22257","3\u0447"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","15\u043c"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","4\u0447 45\u043c"]],"05.05":[["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","20\u043c"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","7\u0447 40\u043c"]],"06.05":[["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","15\u043c"],["\u0414\u043e\u0431\u0430\u0432\u0438\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043f\u043e \u043e\u043f\u0435\u0440\u0430\u0446\u0438\u044f\u043c \u0441 \u0430\u043b\u044c\u0442\u0435\u0440\u043d\u0430\u0442\u0438\u0432\u043d\u044b\u043c\u0438 \u0437\u0430\u044f\u0432\u043a\u0430\u043c\u0438","etpgpb-21532","3\u0447"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","2\u0447"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","2\u0447 45\u043c"]],"07.05":[["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","15\u043c"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","7\u0447 45\u043c"]],"11.05":[["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","20\u043c"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","2\u0447"],["\u0414\u043e\u0431\u0430\u0432\u0438\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043f\u043e \u043e\u043f\u0435\u0440\u0430\u0446\u0438\u044f\u043c \u0441 \u0430\u043b\u044c\u0442\u0435\u0440\u043d\u0430\u0442\u0438\u0432\u043d\u044b\u043c\u0438 \u0437\u0430\u044f\u0432\u043a\u0430\u043c\u0438","etpgpb-21532","3\u0447"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","2\u0447 40\u043c"]],"12.05":[["\u041f\u043e\u0447\u0438\u0441\u0442\u0438\u0442\u044c \u043b\u043e\u0433\u0438","etpgpb-22293","15\u043c"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","15\u043c"],["\u042f \u043a\u0430\u043a \u0443\u0447\u0430\u0441\u0442\u043d\u0438\u043a (\u043d\u0435\u0440\u0435\u0437\u0435\u0434\u0435\u043d\u0442) \u043f\u043e\u043b\u0443\u0447\u0430\u044e \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043e\u0431 \u0438\u0441\u0442\u0435\u0447\u0435\u043d\u0438\u0438 \u0441\u0440\u043e\u043a\u0430 \u0442\u0430\u0440\u0438\u0444\u0430","etpgpb-22264","7\u0447 30\u043c"]],"13.05":[["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","20\u043c"],["\u042f \u043a\u0430\u043a \u0437\u0430\u043a\u0430\u0437\u0447\u0438\u043a \u043c\u0435\u043d\u044f\u044e \u0446\u0435\u043d\u0443 \u043f\u043e\u0437\u0438\u0446\u0438\u0438 \u043b\u043e\u0442\u0430 \u043f\u0440\u0438 \u0444\u043e\u0440\u043c\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0438 \u041f\u041f\u0417 \u0443\u0442\u043e\u0440\u0433\u043e\u0432\u044b\u0432\u0430\u043d\u0438\u044f","etpgpb-21264","7\u0447 40\u043c"]],"14.05":[["\u042f \u043a\u0430\u043a \u0443\u0447\u0430\u0441\u0442\u043d\u0438\u043a (\u043d\u0435\u0440\u0435\u0437\u0435\u0434\u0435\u043d\u0442) \u043f\u043e\u043b\u0443\u0447\u0430\u044e \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043e\u0431 \u0438\u0441\u0442\u0435\u0447\u0435\u043d\u0438\u0438 \u0441\u0440\u043e\u043a\u0430 \u0442\u0430\u0440\u0438\u0444\u0430","etpgpb-22264","7\u0447 30\u043c"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","30\u043c"]],"24.05":[["\u0414\u043e\u0440\u0430\u0431\u043e\u0442\u0430\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043f\u043e \u0434\u043e\u0433\u043e\u0432\u043e\u0440\u0430\u043c","etpgpb-22499","7\u0447 40\u043c"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","20\u043c"]],"25.05":[["\u0414\u043e\u0440\u0430\u0431\u043e\u0442\u0430\u0442\u044c \u0443\u0432\u0435\u0434\u043e\u043c\u043b\u0435\u043d\u0438\u044f \u043f\u043e \u0434\u043e\u0433\u043e\u0432\u043e\u0440\u0430\u043c","etpgpb-22499","1\u0447"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","20\u043c"],["\u041e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u043e\u043d\u043d\u044b\u0435 \u0432\u043e\u043f\u0440\u043e\u0441\u044b \u041a\u0440\u0430\u0441\u043d\u044b\u0439 \u041f\u043e\u0440\u0442\u0444\u0435\u043b\u044c ","etpgpb-3173","2\u0447"],["\u042f \u043a\u0430\u043a \u0438\u043d\u0438\u0446\u0438\u0430\u0442\u043e\u0440 \u0441\u043e\u0433\u043b\u0430\u0441\u043e\u0432\u0430\u043d\u0438\u044f \u043f\u0440\u043e\u0446\u0435\u0434\u0443\u0440\u044b \u043c\u043e\u0433\u0443 \u0432\u044b\u0431\u0440\u0430\u0442\u044c \u0441\u043b\u0435\u0434\u0443\u044e\u0449\u0435\u0433\u043e \u0441\u043e\u0433\u043b\u0430\u0441\u0443\u044e\u0449\u0435\u0433\u043e","etpgpb-22733","4\u0447 40\u043c"]]}';

$list = json_decode($list, true);




$header = array('size' => 12, 'bold' => true);
$phpWord = new \PhpOffice\PhpWord\PhpWord();

$fancyTableStyle = array('borderSize' => 6, 'cellMargin' => 80, 'cellMarginRight' => 80, 'cellMarginBottom' => 80, 'cellMarginLeft' => 80);
$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
$cellRowContinue = array('vMerge' => 'continue');
$cellColSpan = array('gridSpan' => 3, 'valign' => 'center');
$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
$cellVCentered = array('valign' => 'center');


$section = $phpWord->addSection();


// Simple text
$section->addText('Отчет о проделанной работе за ' . $month, ['bold' => true, 'size' => 20], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
$section->addTextBreak(3);


$userTableName = 'UserTable';
$phpWord->addTableStyle($userTableName, $fancyTableStyle);
$table = $section->addTable($userTableName);


$table->addRow();
$cell1 = $table->addCell(2000);
$cell1->addText('ФИО');
$cell1->addText('');
$cell1->addText('Дирекция');
$cell1->addText('');
$cell1->addText('Должность');

$cell2 = $table->addCell(7000);
$cell2->addText($name);
$cell2->addText('');$cell2->addText('');$cell2->addText('');
$cell2->addText($job);

$section->addTextBreak(3);

$timeTableName = 'Time';
$phpWord->addTableStyle($timeTableName, $fancyTableStyle);
$table = $section->addTable($timeTableName);

$table->addRow();
$cell1 = $table->addCell(1000, $cellRowSpan);
$textrun1 = $cell1->addTextRun($cellHCentered);
$textrun1->addText('Дата', ['bold' => true]);

$table->addCell(7000, $cellVCentered)->addText('Задача', ['bold' => true]);
$table->addCell(1500, $cellVCentered)->addText('Номер', ['bold' => true]);
$table->addCell(1000, $cellVCentered)->addText('Время', ['bold' => true]);

foreach ($list as $date => $issues) {
  $table->addRow();
  $cell1 = $table->addCell(1000, $cellRowSpan);
  $textrun1 = $cell1->addTextRun($cellHCentered);
  $textrun1->addText($date);

  foreach ($issues as $i => $issue) {
    if ($i != 0) {
      $table->addRow();
      $table->addCell(null, $cellRowContinue);
    }
    $table->addCell(7000, $cellVCentered)->addText($issue[0]);
    $table->addCell(1700, $cellVCentered)->addText($issue[1]);
    $table->addCell(800, $cellVCentered)->addText($issue[2]);
  }
  $table->addCell(null, $cellRowContinue);
}

$table->addRow();
$table->addCell(8000, $cellColSpan)->addText('Всего часов', ['bold'=>true], $cellHCentered);
$table->addCell(1000, ['gridSpan' => 1])->addText(($sumMinutes / 60) . 'ч.', ['bold'=>true]);


$section->addTextBreak(5);
$section->addText('Дата_____            Подпись ____________________');



$phpWord->save('template_fill.docx');*/