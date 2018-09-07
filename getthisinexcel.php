<?php
// Connection 

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "KSHB";
    //$query="select ps_nm,ps_idn from prsnl_infrmtn_systm where ps_nm like 'K%' and ps_flg='W'";
		$query="SELECT AcCode,AcName FROM accmaster";

    if (isset($_REQUEST["modq"]))
    	{
    	$str=$_REQUEST["modq"];
    	$str = preg_replace('/\^/', ' ', $str);
  		$str = preg_replace('/__/', '+', $str);
  		$str = preg_replace('/nmn/', '\'', $str);
  		$query=$str;
    	}
    if (isset($_REQUEST["q"]))	
    	{
    	$query=$_REQUEST["q"];
		$query=str_replace('^',' ',$query);
		$query=str_replace(',,','+',$query);
		}
	
	
			$conn = new mysqli($servername, $username, $password, $dbname);
			
			if ($conn->connect_error) {
    			die("Connection failed: " . $conn->connect_error);
				   			  		  } 
			
			$result = $conn->query($query);
 	
	$filename = "Webinfopen4.xls"; // File Name
	
	header("Content-Disposition: attachment; filename=\"$filename\"");
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
			//echo '</table>';
			
?>