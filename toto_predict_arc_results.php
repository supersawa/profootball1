<?

error_reporting(7);
@ini_set('display_errors', true);
@ini_set('html_errors', false);

///////////
$langdateweekdays = array("Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
$langdateshortweekdays = array("вс","пн","вт","ср","чт","пт","сб");
$langdatemonths = array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
$langdateshortmonths = array("января","февраля","марта","апреля","мая","июня","июля","августа","сентября","октября","ноября","декабря");
///////////

// Соединение с Базой Данных
define('DATALIFEENGINE', true);
$main_path = "/var/www/vhosts/new1.profootball.com.ua";
$dl_path = "/var/www/vhosts/new1.profootball.com.ua/content";
require_once $dl_path.'/engine/inc/mysql.php';
require_once $dl_path.'/engine/data/dbconfig.php';
require_once $dl_path.'/engine/inc/functions.inc.php';

$curr_date_time = date("Y-m-d H:i:s", time());


$ranking_archive = $db->query("
SELECT tm.id as id, tm.result1 as result1, tm.result2 as result2
FROM dle_toto_matches tm, dle_toto_predict_ranking_arc tpra
WHERE tm.id = tpra.match_id
AND tpra.result1 = ''
AND tm.result1 != ''
AND tm.begin_date > NOW()-INTERVAL 1 DAY
");

while($row = $db->get_row($ranking_archive)){
  $sql_update = "UPDATE dle_toto_predict_ranking_arc SET result1 = '".$row['result1']."', result2 = '".$row['result2']."' WHERE match_id = ".$row['id'];
//  echo $sql_update.'<br>';
  $db->query($sql_update);
}

//echo "Archived successfully";


$db->close();


?>