<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");

					

					
						$result2  = get_all_specialist();
                        $output ='';
                       
                        while ($values=mysqli_fetch_array($result2)) {

            $output .="<option value='".$values['OID']."'>".strtoupper($values['Specialization'])."</option>";
                        }
                        echo $output; 
                        




					










 ?>