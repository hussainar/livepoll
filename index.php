<?php
//index.php

?>

<html>  
    <head>  
        <title>Live Poll </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
		
    </head>  
    <body>  
        <div class="container" id="container">  
            <br />  
            <br />
			<br />
			<h2 align="center">Live Poll </h2><br />



			<div class="row">
				<div class="col-md-6">
					<form method="post" id="poll_form">
					<?php 

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
						<div class="radio">
							<label><h4><input type="radio" name="<?php echo "poll_".$row["id"] ?>" class="poll_option" value="<?php echo $row['a_id']; ?>" required /> <?php echo $row['ans']; ?></h4></label>
						</div>
	<?php
}



  }
} else {
  echo "0 results";
}
?>




						<!-- <h3>Which is Best PHP Framework in 2018?</h3>
						<br />
						<div class="radio">
							<label><h4><input type="radio" name="poll_option" class="poll_option" value="Laravel" /> Laravel</h4></label>
						</div>
						
						<div class="radio">
							<label><h4><input type="radio" name="poll_option" class="poll_option" value="CodeIgniter" /> CodeIgniter</h4></label>
						</div>
						<div class="radio">
							<label><h4><input type="radio" name="poll_option" class="poll_option" value="CakePHP" /> CakePHP</h4></label>
						</div>
						<div class="radio">
							<label><h4><input type="radio" name="poll_option" class="poll_option" value="Symfony" /> Symfony</h4></label>
						</div>
						<div class="radio">
							<label><h4><input type="radio" name="poll_option" class="poll_option" value="Phalcon" /> Phalcon</h4></label>
						</div>
						<br /> -->
						<input type="submit" name="poll_button" id="poll_button" class="btn btn-primary" />
					</form>
					<br />
				</div>
				<div class="col-md-6">
					<h4>Live Poll Result</h4><br />


					<?php 
$sql = "SELECT id, qtn FROM questions";
$result = $conn->query($sql);
//var_dump($result->fetch_array());
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
<div id="<?php echo "poll_result".$row["id"] ; ?>"></div>
<?php
  }
} else {
  echo "0 results";
}
?>
					<div id="poll_result"></div>
				</div>
			</div>
			
			
			<br />
			<br />
			<br />
		</div>
    </body>  
</html>  
<script>  
$(document).ready(function(){
	openFullscreen();
	fetch_poll_data();

	function fetch_poll_data()
	{
		$.ajax({
			url:"fetch_poll_data.php",
			method:"POST",
			success:function(data)
			{
				$('#poll_result').html(data);
			}
		});
	}
	
	$('#poll_form').on('submit', function(event){
		event.preventDefault();
		// var poll_option = '';
		// $('.poll_option').each(function(){
		// 	if($(this).prop("checked"))
		// 	{
		// 		poll_option = $(this).val();
		// 	}
		// });
		// if(poll_option != '')
		// {
			$('#poll_button').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			//alert(form_data);
			//die();
			$.ajax({
				url:"poll.php",
				method:"POST",
				data:form_data,
				success:function()
				{
					$('#poll_form')[0].reset();
					$('#poll_button').attr('disabled', false);
					fetch_poll_data();
					//alert("Poll Submitted Successfully");
				}
			});
		// }
		// else
		// {
		// 	alert("Please Select Option");
		// }
	});
	
	
	
});  
</script>

<script>

function openFullscreen() {
	var elem = document.getElementById("container");
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
  }
}
</script>