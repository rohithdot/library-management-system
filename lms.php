<?php
	session_start();
	$name=$username	=$password="";
	$conn = new mysqli("localhost","root","rohith","maindb") or die("Unable to connect");
	
 
	
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
		
	}
	
		
	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$srch=$_POST['index'];
		
		
		if($srch=="" ){
			
			echo "blankerror";
			
		}
		else{
			
			$sql1="select a.ISBN,Title,fullname,availability
			       from `book` a, book_authors b, authors c
				   where (a.isbn like '%$srch%' or a.`Title` like '%$srch%' or c.`fullname` like '%$srch%') and a.isbn=b.isbn and b.author_id=c.author_id;"; 
			$result1=$conn->query($sql1);
			
			if($result1->num_rows>0){		
				while($row1=$result1->fetch_assoc()){
					
					$searcharray[]=$row1;

				}
				
				echo json_encode($searcharray);
			}
			else{
				echo "There are no Books with the given Input"."<br>";

			}	

		}
		
	}

	
?>


