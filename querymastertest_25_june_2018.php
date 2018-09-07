<?PHP



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "KSHB1718";

  function store2debug($contentt)
  {
  $file_save=fopen("debugfile.txt","w+");
  flock($file_save,LOCK_EX);
  fputs($file_save,$contentt."\n");
  
  flock($file_save,LOCK_UN);
  fclose($file_save);
  }


  function getdata()
    {
    $susc_file=file("debugfile.txt",FILE_IGNORE_NEW_LINES);
    $resp='';
    for ($i=0;$i<count($susc_file);$i++)	
    	{    	
    	$resp+=$susc_file[$i];    	
    	}
    	
    return $resp;
    }


?>

<head>
	<style>
	#in1
	{
		float:left;
		clear:left;
	}
	table, th, td 
	{
    border: 1px solid black;
     text-align: left;
    }
	th
	{
		align:"left";
	}

	/*Added on 12 June 2018 */
	table#stab 
              {
                width: 100%; 
                background-color: #f1f1c1;
              }
              th
              {
              text-align: left;
              }
              table#stab tr:nth-child(even) 
              {
                background-color: #eee;
              }
              table#stab tr:nth-child(odd) 
              {
                background-color: #fff;
              }
              table#stab th 
              {
                color: white;
                background-color: black;
              }
	/*Added on 12 June 2018 */
	</style>
	<script>
	function hidestuff()
	{
	document.getElementById("form1").style.visibility="hidden";
	document.getElementById("form1").style.position="absolute";
	document.getElementById("form1").style.float="left";
	document.getElementById("q").style.visibility="hidden";
	document.getElementById("q").style.position="absolute";
	document.getElementById("q").style.float="left";
	document.getElementById("varbo").style.float="right";
	}
/*
    function updatequerry()
	{
		
    document.getElementById("q").innerHTML=						;
	}
	*/
</script>

<!-- Jquery script added on 12 June 2018-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(
                  function()
                  {
                  $("#fs").on("keyup", function() {
                                                        var value = $(this).val().toLowerCase();
                                                        $("#tablebody tr").filter(
                                                                                function() {
                                                                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                                                            }
                                                                                );
                                                        }
                                  );

                    }
                  );
</script> 
<!-- Jquery script added on 12 June 2018-->


</head>


<body>






<form method="post" id="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<strong>Type your query here</strong>: <br>
 <textarea id="q" name="q"  rows="30" cols="120" style="visibility:visible;">
 <?php
 if (!( isset($_POST['q']) ) )
 echo "Type your query here";
else echo $_POST['q'];
?>
 </textarea>  <br>
 
 
<input type="submit" name="submit" value="execute" >
<button type="button" onClick="hidestuff()">hide</button>

</form>
<p id='varbo'><a href='index.php'> <f>Main Page</f></a></p>


<?php


if (($_SERVER["REQUEST_METHOD"] == "POST") &&(array_key_exists('q',$_POST)))
			{
            $query=$_POST['q'];
			echo '<script>';
			echo "document.getElementById('q').style.visibilty='hidden';";  //$fgmembersite->SafeDisplay('empnm')
			//echo "document.getElementById('q').innerHTML=\"$query\";";
			echo '</script>';
			
			
			 echo '<br>';
             echo 'Filter:<input type=\'text\' id=\'fs\'>';
   			 echo '<br>';	
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
									  } 
			$query=$_POST['q'];
			// $_SESSION["curquery"]=$query;
			$result = $conn->query($query);
			
			
			
			$firstrow=True;
			echo '<table id=\'stab\'>';
			while($row = $result->fetch_assoc())
				{   $rowsel=0;
					if ($firstrow)
					{
					echo '<thead>';
					echo '<tr>';
					foreach($row as $key=>$val)
						{
					$rowsel+=1;
					//if (($rowsel%2)==0)									
                    echo '<th>'.$key.'</th>';
                    	}				
					echo '</tr>';
					echo '</thead>';
					echo '<tbody id=\'tablebody\'>';
				    }  
				    $firstrow=False;
				    $rowsel=0;
				    echo '<tr>';
					foreach($row as $key=>$val)	
						{	
					$rowsel+=1;		
					//if (($rowsel%2)==0)						
                    echo '<td>'.$val.'</td>';
                    	}				
					echo '</tr>';		
					
				}
			echo '</tbody></table>';
			}
?>

 <?php
if (!(isset($query)))
$query="select ps_nm from prsnl_infrmtn_systm";
$nstr=$query;
  $nstr = preg_replace('/[\r\n\t\s]/', '^', $nstr);
  $nstr = preg_replace('/[+]/', '__', $nstr);
  $nstr = preg_replace('/[\']/', 'nmn', $nstr);
  echo "<a href='getthisinexcel.php?modq=$nstr'>Download as excel</a> ";
?>



</body>