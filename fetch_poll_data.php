<?php

//fetch_poll_data.php

include('database_connection.php');

$sql = "SELECT id, qtn FROM questions";
$result = $conn->query($sql);
//var_dump($result->fetch_array());
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
						<h3><?php echo $row["qtn"]; ?></h3>
						<br />
<?php

	$query = "SELECT q.id,q.qtn,a.ans,a.id as a_id
	FROM `questions` AS q 
	JOIN `answers` AS a ON q.id = a.qtn_id
	WHERE q.id =  " . $row["id"];

$result2 = $conn->query($query);
while($row = $result2->fetch_assoc()){
	?>
						<div>
							<label><h4><?php //echo $row['ans']; ?></h4></label>
							<?php $total_poll_row = get_total_rows($connect,$row["id"]); 
							//echo $total_poll_row;
							$total_ans = get_total_ans($connect,$row["a_id"]);
		$percentage_vote = round(($total_ans/$total_poll_row)*100);
		$progress_bar_class = '';
		if($percentage_vote >= 40)
		{
			$progress_bar_class = 'progress-bar-success';
		}
		else if($percentage_vote >= 25 && $percentage_vote < 40)
		{
			$progress_bar_class = 'progress-bar-info';
		}
		else if($percentage_vote >= 10 && $percentage_vote < 25)
		{
			$progress_bar_class = 'progress-bar-warning';
		}
		else
		{
			$progress_bar_class = 'progress-bar-danger';
		}
		echo '
		<div class="row">
			<div class="col-md-2" align="right">
				<label>'.$row['ans'].'</label>
			</div>
			<div class="col-md-10">
				<div class="progress">
					<div class="progress-bar '.$progress_bar_class.'" role="progressbar" aria-valuenow="'.$percentage_vote.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage_vote.'%">
						'.$percentage_vote.' % peoples like <b>'.$row["ans"].'</b>
					</div>
				</div>
			</div>
		</div>
		
		';
							?>
						</div>
	<?php
}



  }
} else {
  echo "0 results";
}


echo $output;

function get_total_rows($connect,$id)
{
	$query = "SELECT * FROM poll WHERE q_id =$id";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function get_total_ans($connect,$id)
{
	$query = "SELECT * FROM poll WHERE a_id =$id";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}
?>