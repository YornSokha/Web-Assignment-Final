<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php include("style.php") ?>
	<title>Index</title>
</head>
<body>
<?php include("header.php"); ?>
<?php include("../helper/db.php"); ?>

<!--container-->
<div class="container py-3">
	<div class="row">
		<div class="col-10 mx-auto">
			<div class="accordion" id="faqExample">
				<?php
				$db_connection = new mysqli($host, $user, $password, $dbname);
				if ($db_connection->connect_errno) {
					echo "Failed to connect to database";
				}

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
				?>
				<?php foreach ($questions

				as $question) {break;
				?>
				<div class="card">
					<div class="card-header p-2" id="heading-<?php echo $question['id'] ?>">
						<h5 class="mb-0">
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse"
									data-target="#collapse-<?php echo $question['id'] ?>"
									aria-expanded="false" aria-controls="collapse-<?php echo $question['id'] ?>">
								Q: <?php echo $question['question'] ?>
							</button>
						</h5>
					</div>

					<div id="collapse-<?php echo $question['id'] ?>" class="collapse"
						 aria-labelledby="heading-<?php echo $question['id'] ?>"
						 data-parent="#faqExample">
						<div class="card-body">
							<?php if (isset($question['answers'][0])) {
								foreach ($question['answers'] as $q_answer) {
									?>
									<b>Answer:</b><span class="editable-field" title="Click to edit"><?php echo $q_answer['answer'] ?></span> <br>
								<?php }
							} else { ?>
							<b>Answer:</b>
							<span class="editable-field" title="Click to edit"><?php echo $question['answers']['answer'] ?> </span>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>

			<script type="text/javascript" language="javascript" >
				$(document).ready(function(){

					function fetch_employee_data()
					{
						$.ajax({
							url:"fetch.php",
							method:"POST",
							dataType:"json",
							success:function(data)
							{
								console.log(data);
								// alert(Object.keys(data).length);
								for(questoin in data)
								{
									var html_data = '<div class="card">';
									html_data += '<div class="card-header p-2" id="heading-"' + questoin;
									html_data += '<h5 class="mb-0">';
									//
									// var html_data = '<tr><td>'+data[count].id+'</td>';
									// html_data += '<td data-name="name" class="name" data-type="text" data-pk="'+data[count].id+'">'+data[count].name+'</td>';
									// html_data += '<td data-name="gender" class="gender" data-type="select" data-pk="'+data[count].id+'">'+data[count].gender+'</td>';
									// html_data += '<td data-name="designation" class="designation" data-type="text" data-pk="'+data[count].id+'">'+data[count].designation+'</td>';
									// html_data += '<td data-name="age" class="age" data-type="text" data-pk="'+data[count].id+'">'+data[count].age+'</td></tr>';
									$('#faqExample').append(html_data);
								}
							}
						})
					}

					fetch_employee_data();

					$('#employee_data').editable({
						container: 'body',
						mode: 'inline',
						selector: 'td.name',
						url: "update.php",
						title: 'Employee Name',
						type: "POST",
						//dataType: 'json',
						validate: function(value){
							if($.trim(value) == '')
							{
								return 'This field is required';
							}
						}
					});

					$('#employee_data').editable({
						container: 'body',
						selector: 'td.gender',
						url: "update.php",
						title: 'Gender',
						type: "POST",
						dataType: 'json',
						source: [{value: "Male", text: "Male"}, {value: "Female", text: "Female"}],
						validate: function(value){
							if($.trim(value) == '')
							{
								return 'This field is required';
							}
						}
					});

					$('#employee_data').editable({
						container: 'body',
						selector: 'td.designation',
						url: "update.php",
						title: 'Designation',
						type: "POST",
						dataType: 'json',
						validate: function(value){
							if($.trim(value) == '')
							{
								return 'This field is required';
							}
						}
					});

					$('#employee_data').editable({
						container: 'body',
						selector: 'td.age',
						url: "update.php",
						title: 'Age',
						type: "POST",
						dataType: 'json',
						validate: function(value){
							if($.trim(value) == '')
							{
								return 'This field is required';
							}
							var regex = /^[0-9]+$/;
							if(! expression.test(value))
							{
								return 'Numbers only!';
							}
						}
					});



				});
			</script>
		</div>
	</div>

	<!--	--><?php
	//	$db_connection = new mysqli($host, $user, $password, $dbname);
	//	if ($db_connection->connect_errno) {
	//		echo "Failed to connect to MySQL: (" . $db_connection->connect_errno . ") " . $db_connection->connect_error;
	//	}else{
	//		echo "SUCCESS";
	//	}
	//	$sql = "INSERT INTO Questions(question) VALUES(\"What is your name?\")";
	//	if ($db_connection->query($sql)){
	//		echo "question INSERTED";
	//	} else {
	//		echo "Error : ". $sql . "<br>". $db_connection->error;
	//	}
	//	$last_id = mysqli_insert_id($db_connection);
	//	$sql = "INSERT INTO Answers(q_id, answer) VALUES($last_id, \"My name is Sokha.\")";
	//	if ($db_connection->query($sql)){
	//		echo "Answer INSERTED";
	//	} else {
	//		echo "Error : ". $sql . "<br>". $db_connection->error;
	//	}
	//	?>
</div>
<?php include("footer.php"); ?>
</body>
</html>