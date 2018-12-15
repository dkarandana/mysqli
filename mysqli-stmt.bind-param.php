<?php

/**
  * @author Dhananjaya Karandana
  * @author @dkarandana <https://twitter.com/@dkarandana>
  */

	include 'views/header.php';
	require 'connections.php';

	$email = 'isurum97@gmail.com';
	// $email = 'dhananjaya.karandana@pace.lk';

	$sql = "SELECT name, email, mobile FROM studentDetails WHERE email=?";

	echo "<pre>mysql> $sql;</pre>";

	$studentRecords = '';

	$statement = $mysqli->prepare( $sql );

	if ( ! $statement ) {

 		// Oh no! The query failed. 
	    echo "<p>Query execution was failed. </p>";
	
	    exit;
	   
	}else{


/* Binding Params */

/**
  * @see http://php.net/manual/en/mysqli-stmt.bind-param.php
  * @see bind_param  mysqli_stmt::bind_param -- mysqli_stmt_bind_param — Binds variables to a prepared statement as parameters
  *
  */

	$statement->bind_param('s', $email );

	$statement->execute();

	/* Store the result (to get properties) */
   	$statement->store_result();

   	/* Get the number of rows */
   	$num_rows = $statement->num_rows;

	$execute = $statement->bind_result($name, $email, $mobile );


		if( $num_rows > 0 ){

			while( $statement->fetch() ) {	

				$classes =  ( ++$row % 2 == 0 ) ? 'even' : 'odd';

$studentRecords .= <<<TABLE
				<tr class="{$classes}">
					<td>{$name}</td>
					<td>{$email}</td>
					<td>{$mobile}</td>
				</tr>
TABLE;
			}

		}else{
			echo "<p>Empty Dataset recieved </p>";
		
		}

		$records = 	( $num_rows > 1 ) ? 'Records' : 'Record' ;

		echo <<<EOD
		<h3>[ $num_rows ] $records Found</h3>
		<table>
			<thead>
				<td>Name</td>
				<td>Email</td>
				<td>Mobile</td>
			</thead>
			<tbody>
				{$studentRecords}
			</tbody>
		</table>
EOD;

	}

	//close connection
	$statement->close();

	include 'views/footer.php';

?>
