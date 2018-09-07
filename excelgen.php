<?php
// Connection 
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




	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "KSHB";
	$conn = new mysqli($servername, $username, $password, $dbname);
    //$query="select ps_nm,ps_idn from prsnl_infrmtn_systm where ps_nm like 'K%' and ps_flg='W'";
		$query="show tables";
		$result = $conn->query($query);
		while($row = $result->fetch_assoc())
		{
		foreach($row as $key=>$val)
		{
		store2debug($val);
		}
		}
		$countt=0;
    foreach (readdb() as $elem)
        {
        	$countt+=1;
        	if ($countt>3) break;
        	$query="select * from ".$elem;
	
			
			
			if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
				   			  		  } 
			
			$result = $conn->query($query);
 	
	$filename = "kshb_file_series"; // File Name
	
	header("Content-Disposition: attachment; filename=\"$filename".$countt.".xls\"");
	header("Content-Type: application/vnd.ms-excel");
	
	
	
	$firstrow=True;
			//echo '<table>';
			while($row = $result->fetch_assoc())
				{   $rowsel=0;
					if ($firstrow)
					{
					//echo '<tr>';
					foreach($row as $key=>$val)
						{
					$rowsel+=1;
					//if (($rowsel%2)==0)									
                    echo $key."\t";
                    	}				
					echo "\r\n";
				    }  
				    $firstrow=False;
				    $rowsel=0;
				    //echo '<tr>';
					foreach($row as $key=>$val)	
						{	
					$rowsel+=1;		
					//if (($rowsel%2)==0)						
                    echo $val."\t";
                    	}				
					echo "\r\n";	
					
				}

		}
			//echo '</table>';
			
?>