
$(document).ready(function(){
	$("#tableid").hide();
	$("#div3").hide();
	$("#checkoutb").hide();


	$("#searchbutton").click(function(e){
		e.preventDefault();
		$("#tbody0").html("");
		$("#div3").hide();
		$("#checkoutb2").hide();

		var data1=$("#search1").val();


		$.ajax({

			url:"lms.php",
			type:"POST",
			data:{index: data1},


			success:function(data){
				if(data=="blankerror"){
					alert("Please enter a non null value to search");
				}

				data=$.parseJSON(data);
				
				
				var rowid=0;
				$.each(data,function(key,value){
					var bookid=value.ISBN;
					var titles=value.Title;
					var authors=value.fullname;
					var available=value.availability;
					if(available=="Not available"){	
						var tablerow= '<tr><td>'+bookid+'</td><td>'+titles+'</td><td>'+authors+'</td><td>'+available+'</td><td><input type="checkbox" disabled="disabled"/></td></tr>';
					}
					else{
						var tablerow= '<tr><td>'+bookid+'</td><td>'+titles+'</td><td>'+authors+'</td><td>'+available+'</td><td><input type="checkbox"/></td></tr>';
					}	
					$("#tableid").append(tablerow);
					$("#tableid").show();
					rowid++;
				});
				
				$("td").click(function(){
					$("#checkoutb").show();

				});


				$("#checkoutb").click(function(){
					var isbnarray=[];
					$("#tableid").find("tr").each(function(){
						
						if($(this).find('input[type=checkbox]').is(":checked")){

							var vamsi=$(this).find("td").eq(0).html();

							var title1=$(this).find("td").eq(1).html();
							var author1=$(this).find("td").eq(2).html();

							

							isbnarray.push(vamsi);
							
						}
					});

					
					if(isbnarray.length>3){
						alert("Sorry u cant check out more than 3");
					}
					else{
						$("#div3").show();
						$("#checkoutb").html("Checkout");
						$("#checkoutb").attr("id","checkoutb2");
						
						
						$("#checkoutb2").click(function(){

							var isbnarray1=[];
							$("#tableid").find("tr").each(function(){
						
								if($(this).find('input[type=checkbox]').is(":checked")){

									var vamsi1=$(this).find("td").eq(0).html();

									var title2=$(this).find("td").eq(1).html();
									var author2=$(this).find("td").eq(2).html();

							

									isbnarray1.push(vamsi1);
							
								}
							});
							
							var libraryid=$("#libid").val();
							if(libraryid==''){
								alert("Please input valid Libraryid");
							}
						 	var length1=isbnarray1.length;
						 	
							$.ajax({
								url:"lms2.php",
								type:"POST",
								data:{index1: isbnarray1[0],index2:isbnarray1[1],index3:isbnarray1[2],index4:libraryid,index5:length1},


								success:function(data1){

									
									
									if(data1=="Successs"){
										alert("Checked Out Successfully");
									}
									else{

										alert("Book limit error");
									}
								}


							});


						});

					}

					
				});



				



			},
			error:function(){
				alert("Error Loading the file\n");
			}
			

		});


	});






});
