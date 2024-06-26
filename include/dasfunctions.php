<?php
	

function redirect_to($new_location){

			header("Location: ".$new_location);
			exit;
		}

function check_login($user,$pass){

	$pass = base64_encode($pass);
	$sql = "select * from users where user_name='$user' and password='$pass' ";
	

	$res = mysqli_query($GLOBALS['con'],$sql);
	//$res2 =mysql_num_rows($res);
	return $res;

}

function get_all_service_fetched()
{
	 $sql = "select id,service_name from service order by service_name ASC";

		$res = mysqli_query($GLOBALS['con'],$sql);
	$res2 =array();
	while($res3=mysqli_fetch_assoc($res)){

		
		array_push($res2,$res3['id']);
		
	}
	return $res2;

}
function get_all_importer_fetched()
{
	$sql = "select * from importer ";
		$res = mysqli_query($GLOBALS['con'],$sql);
	$res2 =array();
	while($res3=mysqli_fetch_assoc($res)){

		
		array_push($res2,$res3['id']);
		
	}
	return $res2;
}
	function get_count_by_sql($sql){

		$res = mysqli_query($GLOBALS['con'],$sql);
	// $row = mysqli_fetch_array($res);
	//  return $svc_name = $row["count(*)"];


}

function array_push_assoc($array, $key, $value){
$array[$key] = $value;
return $array;
}




function get_all_category()
{
	 $sql = "select id,cat_name from category order by cat_name ASC";

		$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}

function get_all_company()
{
	 $sql = "select * from company order by company_name ASC";

		$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}


function get_all_home_category()
{
	 $sql = "select id,home_cat_name from home_category order by home_cat_name ASC";

		$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}
function get_all_price()
{
	 $sql = "select id,price,price_name from price order by price ASC";

		$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}

function get_price_by_id($id)
{	

	 $sql = "select price from price where id= '$id' limit 1";
	 
	
		$res = mysqli_query($GLOBALS['con'],$sql);
	$row = mysqli_fetch_array($res);
	 return $name = $row["price"];
}


function get_all_subkeyword()
{
	 $sql = "select id,sub_keyword from subkeyword order by sub_keyword ASC";

	$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}


function get_all_user_role()
{
	 $sql = "select * from user_role where core_id=0 order by id ASC";

	$res = mysqli_query($GLOBALS['con'],$sql);
	return $res;
}




function get_all_menus_by_role_id($id){


 $sql = "SELECT DISTINCT m.menu_id,m.menu_name,m.icon_class,m.notification FROM permission p  INNER join menu m on m.menu_id = p.menu_id WHERE p.role_id='$id' and m.status =1 order by menu_id asc";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	return $res;

}


function get_all_sub_menus_by_role_id($id){


 $sql = "SELECT DISTINCT sm.sub_menu_id,sm.sub_menu_name,sm.notification FROM permission p  INNER join sub_menu sm on sm.sub_menu_id = p.sub_menu_id WHERE p.role_id='$id' and sm.status =1 ";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	return $res;

}

function get_all_menus(){


 $sql = "SELECT *  FROM menu m  WHERE m.status =1 ";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	return $res;

}
function get_all_sub_menus_by_menu_id($id){


 $sql = "SELECT *  FROM sub_menu sm  WHERE sm.status =1  and menu_id='$id' ";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	return $res;

}

function get_all_sub_menus_by_menu_id_role_id($menu_id,$role_id){

 $sql = "SELECT * FROM permission p 
inner join sub_menu sm on sm.sub_menu_id = p.sub_menu_id

WHERE p.role_id ='$role_id' and p.menu_id ='$menu_id' ";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	
	return $res;


}

function get_menus_with_permisson_by_role_id($id){


$sql = "SELECT DISTINCT m.menu_id,m.menu_name FROM menu m left JOIN permission p on p.menu_id=m.menu_id where p.role_id='$id' ";

	$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;
	return $res;



}

function check_permission_with_url_role_id($url,$role_id){


	$sql = "SELECT * FROM sub_menu sm 
inner join permission p on sm.sub_menu_id = p.sub_menu_id

WHERE  page_url like '%$url%' and p.role_id='$role_id'

GROUP by sub_menu_name ";

$res = mysqli_query($GLOBALS['con'],$sql);

	//echo $sql;

	return mysqli_num_rows($res);



}

function update_to_seen_by_id($contentId){

	$sql = "Update applications set flag='seen' where id ='$contentId' limit 1 ;";
	
	$res = mysqli_query($GLOBALS['con'],$sql);

	
	return $res;


}



function get_fetched_content_details_data_by_content_id($id){

	$id = mysqli_real_escape_string($GLOBALS['con'],$id);
	$sql = "select *,a.id as app_id,a.datetime as upload_date,a.icon as app_icon from applications a 
				inner join users u on u.id = a.user_id
				inner join company c on c.id = a.company_id
				inner join category cat on cat.id = a.cat_id
	 where a.id='$id'  limit 1 ";
	
	$res = mysqli_query($GLOBALS['con'],$sql);

	$row = mysqli_fetch_assoc($res);
	return $row;

}
function get_main_categorydata(){
	$sql = "SELECT * FROM main_category ORDER BY cat_name ASC";
	$res = mysqli_query($GLOBALS['con'],$sql);

	return $res;

}


?>