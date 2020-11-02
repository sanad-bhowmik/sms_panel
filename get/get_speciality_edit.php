<?php
session_start();
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");

					
	

	if(isset($_GET['docID'])){


			$result2  = get_all_specialist();
			
			$specials = get_doc_specials_by_id($_GET['docID']);
            $docid	 =explode(",",$specials);
            $output ='';
                       
                while ($values=mysqli_fetch_array($result2)) {

              if(in_array($values['OID'], $docid)) {
 $output .="<option selected value='".$values['OID']."'>".strtoupper($values['Specialization'])."</option>";
              } else{
 $output .="<option  value='".$values['OID']."'>".strtoupper($values['Specialization'])."</option>";
              }	
          
                        }



	}else{


						$result2  = get_all_specialist();
                        $output ='';
                       
                        while ($values=mysqli_fetch_array($result2)) {

            $output .="<option value='".$values['OID']."'>".strtoupper($values['Specialization'])."</option>";
                        }


	}
					





                 echo $output; 
                        




					










 ?>