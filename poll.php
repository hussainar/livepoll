<?php

//poll.php

include('database_connection.php');



for($i=0;$i<=10;$i++){
if(isset($_POST["poll_".$i]))
{
	$query = "
	INSERT INTO poll 
	(q_id,a_id) VALUES (:q_id,:a_id)
	";
	$data = array(
		':q_id'		=>	$i,
		':a_id'   => $_POST["poll_".$i]
	);
	$statement = $connect->prepare($query);
	$statement->execute($data);
}
}

/*
CREATE TABLE `questions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `qtn` varchar(300) NOT NULL,
  `date` varchar(100) NOT NULL DEFAULT 'NOW()',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

CREATE TABLE `answers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ans` varchar(300) NOT NULL,
  `qtn_id` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK_QtnAns` (`qtn_id`),
  CONSTRAINT `FK_QtnAns` FOREIGN KEY (`qtn_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

CREATE TABLE `poll` (
  `poll_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_id` int(10) NOT NULL,
  `a_id` int(10) NOT NULL,
  PRIMARY KEY (`poll_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

*/
?>