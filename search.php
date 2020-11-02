<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>HOTMIX</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
		<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script src="lib/jquery-1.4.2.js" type="text/javascript"></script>
<script src="lib/js-func.js" type="text/javascript"></script>
<script src="lib/jquery.jcarousel.js" type="text/javascript"></script>

        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="CalendarControl.js"></script>
<link href="CalendarControl.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js">
</script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		<script>
$(document).ready(function(){
  $("#excell").click(function(){
				
		var stdate = $("#stdate").val();	
		var enddate = $("#enddate").val();
		
    
		document.location.href='k.php?ToDo=ete&stdate=' +stdate + '&enddate=' +enddate; 
  });
});
</script>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                 <!-- <img src = "img/sm2.JPG" alt="logo">-->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
				<div>
                     <h2 style="float:left;text-align:center;text-shadow: 2px 2px 0 #fff;width:70%;color:#768db1;">Sales Tracking System</h2>
                </div>
                
            </nav>
        </header>
		<?php

session_start(); 
include('dbcon.php');


if(!isset($_SESSION['username'])){
?>
<script type="text/javascript">
window.location="index.php";
</script>
<?php
}


$fval = array('stdate'=>'', 'enddate'=>'');
if(isset($_POST['get']))
			{
				
						$fval = array_replace($fval, $_POST);      // add $_POST data in $fval to replace the initial values

			}



?> 
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        
                    </div>
                
                    <ul class="sidebar-menu">
                        <li>
                            <a href="report.php">
                                <i class="fa fa-dashboard"></i> <span>IMEI Report</span>
                            </a>
                        </li>
						<li>
                            <a href="search.php">
                                <i class="fa fa-dashboard"></i> <span>Search BY IMEI & MODEL</span>
                            </a>
                        </li>
						<li>
                            <a href="logout.php">
                                <i class="fa fa-dashboard"></i> <span>Logout</span>
                            </a>
                        </li>
							
                    </ul>
					<?php
		$today = date("Y-m-d");
		?>
								<div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" style="background-color:#FFE9CC;">Todays Activation(<?php echo $today;?>)</th>
                                           
                                        </tr>
										<?php
		
										$sql="select model,count(id) as num from new_mo where date='$today' group by model ";
										$res = mysql_query($sql);
										
										while($row=mysql_fetch_array($res))
										{
											?>
											<tr>
											<td><?php echo $row['model']; ?></td>
											<td><span class="badge bg-yellow"><?php echo $row['num']; ?></span></td>
											</tr>
											<?php
											
										}
										
										?>
                                       
                                        
                                    </table>
                                </div>
								<div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th colspan="2" style="background-color:#FFE9CC;">Overall Activation</th>
                                           
                                        </tr>
										<?php
		
										$sql="select model,count(id) as num from new_mo group by model ";
										$res = mysql_query($sql);
										while($row=mysql_fetch_array($res))
										{
											?>
											<tr class="GridRow" onMouseOver="this.className='GridRowOver'" onMouseOut="this.className='GridRow'">
											<td><?php echo $row['model']; ?></td>
											<td><span class="badge bg-light-blue"><?php echo $row['num']; ?></span></td>
											</tr>
											<?php
											
										}
										
										?>
                                        
                                        
                                    </table>
                                </div>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Search By IMEI & MODEL
                       
                    </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
									
										<table class="table table-bordered">
										
										<tr>
											<form action="" method="post">
												
												<td> IMEI Number :</td>
												<td> <input type="text" name="imei" id="imei"/></td>	
												
												
											<td> Model</td>
											
											<td><select name="model">
												 <option value="" selected="selected" >--Select Model--</option>
												 <?php 
																 $query="SELECT DISTINCT(model) FROM new_mo";
																	  $result=mysql_query($query) or die("database error". mysql_error());                           
																	  $option='';
																	   while($row=mysql_fetch_row($result)){
																		 $option .= '<option value="'.$row[0].'">'.$row[0].'</option>';
																	   } echo $option; 
																			   
															   
											      ?>	</select></td>
											
											
											<td>
											
											<div style="margin-top:4px;">
										<input name='get' type="submit" value="Search" class="btn btn-primary">
										</div>
											</td>
											
											
											
											</form>
										</tr>




										</table>




										</table>
									
                                </div><!-- /.box-header -->
								
									<?php
			if(isset($_POST['update_imei']))
			{
				$imei1=$_POST["imei1"];
				$imei2=$_POST["imei2"];
				$eid=$_POST["eid"];
				$sql = "update new_mo set imei1='$imei1',imei2='$imei2' where id='$eid'";
				$res = mysql_query($sql);
				if($res)
				{
				echo "<h2 style='text-align:center;'>IMEI Updated Successfully</h2>";
				}
			}
			if(isset($_POST['get']))
			{
			$imei=$_POST["imei"];
			$model=$_POST["model"];
			
			
			
			}
			else if (isset($_GET['currentpage']))
			{
			$imei=$_REQUEST["imei"];
			$model=$_REQUEST["model"];
			
		
			}
			else
			{
			$imei="";
			$model="";
			}
			
			
				$arr = array();					
			
			if	(!empty($imei)) {$arr[] ="imei1 LIKE '$imei' or imei2 LIKE '$imei'";}
			if	(!empty($model)) {$arr[] ="model LIKE '$model'";}
			
			$whereClause =   implode(" AND ", $arr );
			if(isset($_POST['get']) || isset($_GET['currentpage']))
			{
				if($whereClause=="")
				{
				$sql="select * from new_mo ORDER BY EventDate DESC";
				}
				else
				{
				$sql="select * from new_mo where $whereClause ORDER BY EventDate DESC";
				}
			}
			
			else
			{
			$sql="select * from new_mo ORDER BY EventDate DESC";
			}
			$results=mysql_query($sql);
			
			
			
			
			
			$sql_test_paging_count = mysql_num_rows($results);
			
			echo "<h3 style='color:green'>Total: ".$sql_test_paging_count."</h3>";
			
			$rowsperpage=10;
			$totalpages = ceil($sql_test_paging_count / $rowsperpage);
			
			
			
			if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
				   
				   $currentpage = (int) $_GET['currentpage'];

				} else {
				  
				   $currentpage = 1;
				}
				
			if ($currentpage >= $totalpages) {
				   
			   $currentpage = $totalpages;
			} 
			if ($currentpage <= 1) {
			  
			   $currentpage = 1;
			} 

			

			$offset = ($currentpage - 1) * $rowsperpage;
			if(isset($_POST['get']) || isset($_GET['currentpage'])){
			
				if($whereClause=="")
					{
			
					$sql_get_data ="select * from new_mo ORDER BY EventDate DESC LIMIT $offset, $rowsperpage";
					}
					else
					{
					$sql_get_data ="select * from new_mo where $whereClause ORDER BY EventDate DESC LIMIT $offset, $rowsperpage";
					}
			}
			else
			{
			$sql_get_data ="select * from new_mo ORDER BY EventDate DESC LIMIT $offset, $rowsperpage";
			}
			$result = mysql_query($sql_get_data);
			?>
								
								
								
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>SL</th>
                                            <th>Mobile Number</th>
                                            <th>Model</th>
											<th>IMEI 1</th>
                                            <th>IMEI 2</th>
                                            <th>Date</th>
                                            
                                        </tr>
										<?php $i=0; while ($rs = mysql_fetch_array($result)) { $i++;?>
						<tr>
							
							
							<td>
								<?php echo $i; ?>
							</td>
							<td>
								<?php echo $rs['mobile_num']; ?>
							</td>
							<td>
								<?php  echo $rs['model']; ?>
							</td>
							<td>
								<?php  echo $rs['imei1']; ?>
							</td>
							<td>
								<?php  echo $rs['imei2']; ?>
							</td>
							<td>
								<?php  echo $rs['EventDate']; ?>
							</td>
						
						
						</tr>
						<?php } ?> 
										
								
                                        
                                    </table>
									<?php
							echo "<div class='paging_link'>";
							
							if ($currentpage > 1) {
						   
									echo " <a class='a_bg' href='{$_SERVER['PHP_SELF']}?currentpage=1&imei=$imei&model=$model'>FIRST</a> ";
						   
								  $prevpage = $currentpage - 1;
						  
									echo " <a class='a_bg' href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage&imei=$imei&model=$model'>PREV</a> ";
							}
							else {
								
								echo " <a class='a_bg_inac' >FIRST</a> ";
								echo " <a class='a_bg_inac' >PREV</a> ";
								
								} 
							
							$range=5;
							
							for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				   
							   if (($x > 0) && ($x <= $totalpages)) {
								
								  if ($x == $currentpage) {
									
									 echo " [<b>$x</b>] ";
								 
								  } else {
									
									 echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x&imei=$imei&model=$model'>$x</a> ";
								  } 
							   } 
							}
							
							
							
							if ($currentpage != $totalpages) {
							  
							   $nextpage = $currentpage + 1;
								
							   echo " <a class='a_bg' href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage&imei=$imei&model=$model'>NEXT</a> ";
							   
							   echo " <a class='a_bg' href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages&imei=$imei&model=$model'>LAST</a> ";
							}
							else {
								
								echo " <a class='a_bg_inac' >NEXT</a> ";
								echo " <a class='a_bg_inac' >LAST</a> ";
								
								} 


						echo '</div>';
					   ?>
                                </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->

                          
                        </div><!-- /.col -->
                        
                    </div><!-- /.row -->
                    
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
    
    </body>
</html>
