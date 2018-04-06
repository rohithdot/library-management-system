<?php
	session_start();
	
	$conn = new mysqli("localhost","root","rohith","maindb") or die("Unable to connect");
	
 		$checkoutdate=date("Y-m-d");
		$duedate=Date('Y-m-d', strtotime("+15 days"));
	
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
		
	}

	
	
	if($_SERVER["REQUEST_METHOD"]=="POST"){

		 $bookid1=$_POST['index1'];
		 $bookid2=$_POST['index2'];
		 $bookid3=$_POST['index3'];

		 $cardid=$_POST['index4'];

		 $length=$_POST['index5'];

		
			
			$sql1="select loan_id from book_loans where card_id='$cardid' and date_in='0000-00-00';"; 
			$result1=$conn->query($sql1);

			$totalbooks=($length)+($result1->num_rows);
			
			if($totalbooks>3){

				
				
				echo "booklimiterror";
			}
			
			
			else{

				if($bookid1!=''){
					$sql2="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in)
					values ('$bookid1','$cardid','$checkoutdate','$duedate','0000-00-00'); ";

					$sql3="update book set availability='Not available' where ISBN='$bookid1' ;";

					

					$result2=$conn->query($sql2);

					$result3=$conn->query($sql3);


				}

				if($bookid2!=''){
					$sql2="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in)
					values ('$bookid2','$cardid','$checkoutdate','$duedate','0000-00-00'); ";

					$sql3="update book set availability='Not available' where ISBN='$bookid2' ;";

					$result2=$conn->query($sql2);

					$result3=$conn->query($sql3);
				}
				if($bookid3!=''){
					$sql2="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in)
					values ('$bookid3','$cardid','$checkoutdate','$duedate','0000-00-00'); ";

					$sql3="update book set availability='Not available' where ISBN='$bookid3' ;";

					$result2=$conn->query($sql2);

					$result3=$conn->query($sql3);
				}

				$sql4="insert into fines 
					select book_loans.loan_id,'$cardid',0,0 from Book_loans where card_id='$cardid' and date_in='0000-00-00' and date_out=CURRENT_DATE() and loan_id not in (select loan_id from `fines`);
					";
				$result4=$conn->query($sql4);

				
				echo "Successs";
				mysqli_close($conn);
			}
		
		
		
	}

?>