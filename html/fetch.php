<?php
//include("helper/db.php");
//$db_connect = new mysqli($host, $user, $password, $dbname);
//$query = "SELECT * FROM employee";
//$result = mysqli_query($db_connect, $query);
//$output = [];
//while ($row = mysqli_fetch_assoc($result)) {
//	$output[] = $row;
//}
//echo json_encode($output);
//?>

<?php
include("../helper/db.php");
$db_connection = new mysqli($host, $user, $password, $dbname);

$sql = "SELECT id, question from questions";
$result = $db_connection->query($sql);
$questions = [];
if ($result->num_rows) {
	while ($question = $result->fetch_assoc()) {
		$questions[$question['id']] = $question;
	}
} else {
	echo "no result";
}

$result = $db_connection->query("select id, q_id, answer from answers");
$last_id_checked = -1;
$reserved_answer = [];
$list_answers = [];
while ($answer = $result->fetch_assoc()) {
	if ($last_id_checked == $answer['q_id']) {
		if (count($list_answers) == 0)
			$list_answers[] = $reserved_answer;
		$list_answers[] = $answer;

		$questions[$answer['q_id']]['answers'] = $list_answers;
	} else {
		$questions[$answer['q_id']]['answers'] = $answer;
	}
	$reserved_answer = $answer;
	$last_id_checked = $answer['q_id'];
}
$db_connection->close();
echo json_encode($questions);