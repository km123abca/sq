<head>
<?php
 if (isset($_REQUEST['start']))
 {
$file_save=fopen("listofiles.txt","w+");
  flock($file_save,LOCK_EX);
  fputs($file_save,"");
  fclose($file_save);
}
function store2debug($contentt)
  {
  

  $file_save=fopen("listofiles.txt","a+");
  flock($file_save,LOCK_EX);
  fputs($file_save,$contentt."\n");
  
  flock($file_save,LOCK_UN);
  fclose($file_save);
  }

  function readdb($fil="listofiles.txt")
	{
		$entire_file=file($fil,FILE_IGNORE_NEW_LINES);
		return $entire_file;
	}

 
 if (isset($_REQUEST['start']))
 {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "KSHB";

	$query="show tables";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {	die("Connection failed: " . $conn->connect_error);  } 
	$result = $conn->query($query);
	while($row = $result->fetch_assoc())
	{
		foreach($row as $key=>$val)
		{
		store2debug($val);
		}
	}
	echo "<h1>Check the output</h1>";
 }

 if (isset($_REQUEST['lisst']))
 	{
 		$conto=readdb();
 		//echo $conto[0];
 		foreach ($conto as $elem)
 		{
 			echo "<h2>select * from ".$elem."</h2><br>";
 		}

 	}




?>

 
	<script>
	function acction(st)
		{
			window.location.href='filelister.php?'+st+'=yes';
		}
	</script>
 </head>

 <body>
<button type='button' id='su' name='su' onclick="acction('start')"> execute</button>
<button type='button' id='su' name='su' onclick="acction('lisst')"> execute</button>

<a href='excelgen.php'>press</a>
 </body>