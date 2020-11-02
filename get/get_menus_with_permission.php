<?php
require_once("../include/dbcon.php");
require_once("../include/dasfunctions.php");


if(isset($_POST['role_id'])){

  $role_id = $_POST['role_id'];
 
  $menus =  get_all_menus();
  $role_menus = get_all_menus_by_role_id($role_id);
  $role_sub_menus = get_all_sub_menus_by_role_id($role_id);
  $new_array=array();
  $new_array2=array();
      
      foreach ($role_menus as $value2) {
      $new_array[] = $value2['menu_id']; 
     
    }//end loop

        foreach ($role_sub_menus as $value2) {
      $new_array2[] = $value2['sub_menu_id']; 
     
    }//end loop


    $output ='<div class="row">';

    foreach ($menus as  $value) {
   
    
  
      $checked =in_array($value['menu_id'], $new_array) ? 'checked' : '';
      
      $output .=' <input type="hidden" value="'.$role_id.'" id="role_id" name="role_id">
        <div class="col-md-3">
            <div class="main-card mb-3 card">
                <div class="card-body">
                <div class="card-title"> <input type="checkbox" '.$checked.' class="form-check-input menus"   name="menucheckbox[]" value="'.$value['menu_id'].'"   >  '. $value['menu_name']   .'</div>
                    <hr>';

      
      foreach ($submenus=get_all_sub_menus_by_menu_id($value['menu_id']) as $sub_menu) {

      $checked2 =in_array($sub_menu['sub_menu_id'], $new_array2) ? 'checked' : '';
      $output .= '<p> <input type="checkbox" '.$checked2.' class="form-check-input sub_menus"  
      name="sub_menucheckbox[]" value="'.$sub_menu['menu_id'].'-'.$sub_menu['sub_menu_id'].'"

       > '.$sub_menu['sub_menu_name'] .'</p>';
    }


      $output .='</div> 

      </div>
  </div>';


    


    } //end role menus
    
    $output .='</div>'; // end of row


    echo $output;

}
else{

  echo " Somthing went wrong !!";

}

?>

