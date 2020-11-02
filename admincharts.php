<?php
 
$today = date("Y-m-d");
$importers = get_all_importer_fetched();
$services  = get_all_service_fetched();
$total_mo_hit = get_count_by_sql(" SELECT count(*) FROM mo_log where charge_status='success' ");
$total_importer = get_count_by_sql(" SELECT count(*) FROM importer  ");
$total_service = get_count_by_sql(" SELECT count(*) FROM service   ");
$today_mo_hit = get_count_by_sql(" SELECT count(*) FROM mo_log where date(datetime)='$today' and charge_status='success'  ");

$importer_hit_sql ="SELECT ";
for($i=0;$i< count($importers) ;$i++){

    $counter =$i;
    $counter++;
   $importer_hit_sql .= " (((SELECT count(*) FROM mo_log WHERE importer_id = '$importers[$i]' and charge_status='success'  )/(SELECT count(*) FROM mo_log where charge_status='success' ))*100) as '".get_importer_name($importers[$i])."' ";
  
            
        if(!($counter==count($importers) )) {
              $importer_hit_sql .=" , ";
        }
}


$hit_res_impoter = mysql_query($importer_hit_sql);
$dataPoints = array();
        
        while($data= mysql_fetch_assoc($hit_res_impoter)){
            
            foreach($data as $key=>$val){
                array_push($dataPoints,array("label"=>$key, "y"=>$val));
                
            }
                
        }
		
        // pie importer
        $dataPointsPieService = array();
        $services_hit_sql ="SELECT ";
        for($i=0;$i< count($services) ;$i++){

            $counter =$i;
            $counter++;
            $services_hit_sql .= " (((SELECT count(*) FROM mo_log WHERE service_id = '$services[$i]' and charge_status='success'  )/(SELECT count(*) FROM mo_log where charge_status='success' ))*100) as '".get_service_name_by_id($services[$i])."' ";

            
            if(!($counter==count($services) )) {
              $services_hit_sql .=" , ";
          }
      }


    $hit_res_service = mysql_query($services_hit_sql);
	
    $dataPointsPieService = array();
        
        while($data= mysql_fetch_assoc($hit_res_service)){
            
            foreach($data as $key=>$val){
                array_push($dataPointsPieService,array("label"=>$key, "y"=>$val));
                
            }
                
        }
//===============================

       
//=========================Start daily service Hits

       $first_day_this_month = date('Y-06-20'); // hard-coded '01' for first day
       $last_day_this_month  = date('Y-m-d');

    // Start date
       $date = $first_day_this_month ;
    // End date
       //$date ="2019-06-01";
       $end_date = $last_day_this_month;

       $op  ="";
       
       $services_hit_sql2="";

    for($i=0;$i< count($services);$i++){
            $counter =$i;
            $counter++;
            ${"service" . $i} = array();

        while(strtotime($date) <= strtotime($end_date)) {
         
        $services_hit_sql2 = " SELECT count(*) as '$date' FROM `mo_log` WHERE date(datetime)='$date' and service_id = '$services[$i]' and charge_status='success'  ";
        
        $hit_daily_service = mysql_query($services_hit_sql2);

        while ($mo=mysql_fetch_assoc($hit_daily_service)) {

            foreach ($mo as $key => $value) {
                array_push(${"service" . $i} , array("label"=>$key , "y"=> (float) $value));

            }
        }
         $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

    }// end while


      $date = $first_day_this_month ;

      $services_hit_sql2 ="";


        $op.='{type: "spline",
        name: "'.get_service_name_by_id($services[$i]).'",
        showInLegend: "true",
        dataPoints:'.json_encode(  ${"service" . $i}  , JSON_NUMERIC_CHECK).'}';
                if(!($counter==count($services) )) {
              $op .=" , ";
          }


      }// end of for loop of daily service line graph
      
//==========================Start of Growth
      $start    = new DateTime(date('Y')."-05-01");
      $end      = new DateTime(date('Y')."-12-31");
      $interval = new DateInterval('P1M');
      $period   = new DatePeriod($start, $interval, $end);
      $op2 ="";

      for($i=0;$i< count($services);$i++){
            $counter =$i;
            $counter++;
            ${"service" . $i} = array();

        foreach ($period as $dt) { 

        $first_of_month = $dt->modify('first day of this month')->format('Y-m-d');
        $end_of_month   = $dt->modify('last day of this month')->format('Y-m-d');    
        $month_year = date("F-Y", strtotime($first_of_month));

        $services_hit_sql2 = " SELECT count(*) as '$month_year' FROM `mo_log` WHERE service_id = '$services[$i]' 
        and charge_status='success'  and (date(`datetime`) BETWEEN '$first_of_month' and '$end_of_month')";
        
        $hit_daily_service = mysql_query($services_hit_sql2);

        while ($mo=mysql_fetch_assoc($hit_daily_service)) {

            foreach ($mo as $key => $value) {
                array_push(${"service" . $i} , array("label"=> (string) $key , "y"=> (float) $value));

            }
        }
         

    }// end forEach

      $services_hit_sql2 ="";


        $op2.='{type: "stackedColumn",
        name: "'.get_service_name_by_id($services[$i]).'",
        showInLegend: "true",
        yValueFormatString: "#,##0 ",
        dataPoints:'.json_encode(  ${"service" . $i}  , JSON_NUMERIC_CHECK).'}';
                if(!($counter==count($services) )) {
              $op2 .=" , ";
          }

      }// end of for loop

	  
?>
<style type="text/css">
	.progress {
      position: relative;
      height: 2px;
      display: block;
      width: 100%;
      background-color: white;
      border-radius: 2px;
      background-clip: padding-box;
      /*margin: 0.5rem 0 1rem 0;*/
      overflow: hidden;

    }
    .progress .indeterminate {
background-color:black; }
    .progress .indeterminate:before {
      content: '';
      position: absolute;
      background-color: #2C67B1;
      top: 0;
      left: 0;
      bottom: 0;
      will-change: left, right;
      -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
              animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite; }
    .progress .indeterminate:after {
      content: '';
      position: absolute;
      background-color: #2C67B1;
      top: 0;
      left: 0;
      bottom: 0;
      will-change: left, right;
      -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
              animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
      -webkit-animation-delay: 1.15s;
              animation-delay: 1.15s; }

    @-webkit-keyframes indeterminate {
      0% {
        left: -35%;
        right: 100%; }
      60% {
        left: 100%;
        right: -90%; }
      100% {
        left: 100%;
        right: -90%; } }
    @keyframes indeterminate {
      0% {
        left: -35%;
        right: 100%; }
      60% {
        left: 100%;
        right: -90%; }
      100% {
        left: 100%;
        right: -90%; } }
    @-webkit-keyframes indeterminate-short {
      0% {
        left: -200%;
        right: 100%; }
      60% {
        left: 107%;
        right: -8%; }
      100% {
        left: 107%;
        right: -8%; } }
    @keyframes indeterminate-short {
      0% {
        left: -200%;
        right: 100%; }
      60% {
        left: 107%;
        right: -8%; }
      100% {
        left: 107%;
        right: -8%; } }














	
</style>

<!--  Start content-->
                    <div class="app-main__inner">
                      <div class="progress" id="PreLoaderBar"> 

                       <div class="indeterminate"></div> 
                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card mb-3 widget-content bg-midnight-bloom">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Hits</div>
                                            <div class="widget-subheading">Over All Hits</div>
                                        </div>
                                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span><?=$total_mo_hit?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							 <div class="col-md-6 col-xl-3">
                                <div class="card mb-3 widget-content bg-plum-plate">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Today <?=$today?></div>
                                            <div class="widget-subheading">Total Hits Today</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?=$today_mo_hit?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card mb-3 widget-content bg-arielle-smile">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Importer</div>
                                            <div class="widget-subheading">Total Active Importer</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?=$total_importer?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card mb-3 widget-content bg-grow-early">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Sevices</div>
                                            <div class="widget-subheading">Total Active Service</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?=$total_service?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                               
								
								   <div class="mb-3 card">
                                    <div class="card-header-tab card-header-tab-animation card-header">
                                        <div class="card-header-title">
                                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                            Hit Report
                                        </div>

                                    </div>
                                    <div class="card-body">
                                     <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                                 </div>
                             </div>
								
								
								
								
								
                            </div>
                          </div>  

                          <div class="row">
                        <div class="col-md-6 col-lg-6">
                                <div class="mb-3 card">
                                    <div class="card-header-tab card-header-tab-animation card-header">
                                        <div class="card-header-title">
                                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                            Hit Report
                                        </div>

                                    </div>
                                    <div class="card-body">
                           <div id="chartContainerPieService" style="height: 370px; width: 100%;"></div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                             
							  <div class="mb-3 card">
                                    <div class="card-header-tab card-header-tab-animation card-header">
                                        <div class="card-header-title">
                                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                            Hit Report
                                        </div>

                                    </div>
                                    <div class="card-body">
                           <div id="chartContainerPieImporter" style="height: 370px; width: 100%;"></div>

                                    </div>
                                </div>
							 
                         </div>
                        </div> <!--end row --> 

                         <div class="row">
                         <div class="col-md-12 col-lg-12">
                            <div class="mb-3 card">
                                <div class="card-header-tab card-header-tab-animation card-header">
                                    <div class="card-header-title">
                                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                                        Growth Report
                                    </div>

                                </div>
                                <div class="card-body">
                                    <div id="chartContainerGrowth" style="height: 370px; width: 100%;"></div>

                               </div>
                           </div>
                       </div>
                   </div> <!--end row -->


             </div>
          </div>  <!--end content -->

<script>
document.onreadystatechange = function () {
            if (document.readyState === "complete") {
                console.log(document.readyState);
                document.getElementById("PreLoaderBar").style.display = "none";
            }
        }


window.onload = function() {



/////////////////
var chartGrowth = new CanvasJS.Chart("chartContainerGrowth", {
    title: {
        text: "Growth of Services",
        fontSize:14
    },
    theme: "dark2",
    animationEnabled: true,
    toolTip:{
        shared: true,
        reversed: true
    },
    axisY: {
        title: "Services Total",
        suffix: "Hits"
    },
        legend: {
        cursor: "pointer",
        itemclick:  toggleDataSeriesGrowth
    },
    data: [
        <?php



        echo $op2;


       ?> 
    ]
});
 
chartGrowth.render();
function toggleDataSeriesGrowth(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    chartGrowth.render();
}




/////////////////













var chart = new CanvasJS.Chart("chartContainer", {

    animationEnabled: true,
    theme: "light2",
    title:{
        
        text: "HITS Daily Basis of Year: " + <?= date('Y') ?>  + " ",
        fontSize: 15
    },
    axisX:{
        crosshair: {
            enabled: true,
            snapToDataPoint: true
        }
    },
    axisY:{
        title: "in Numbers",
        crosshair: {
            enabled: true,
            snapToDataPoint: true
        }
    },
    toolTip:{
        enabled: false
    },
    legend: {
        cursor: "pointer",
        itemclick:  toggleDataSeries
    },
        data: [
    
       <?php



        echo $op;


       ?> 
  
    ]
});


chart.render();
 
function toggleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else{
        e.dataSeries.visible = true;
    }
    chart.render();
}



 
 
var chartPieService = new CanvasJS.Chart("chartContainerPieService", {
    animationEnabled: true,
    theme: "light2",
    title: {
        text: " Hits Service Wise :("+ <?php echo $total_mo_hit; ?> +")",
        fontSize: 16
    },
      //  subtitles: [{
    //    text: " "+ <?php echo date("Y"); ?> +" ",
     //   fontSize: 14
   // }],
   
    data: [{
        type: "pie",
        indexLabel: "{y}",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabelPlacement: "inside",
        indexLabelFontColor: "#36454F",
        indexLabelFontSize: 16,
        indexLabelFontWeight: "bolder",
        showInLegend: true,
        legendText: "{label}",
        dataPoints: <?php echo json_encode($dataPointsPieService, JSON_NUMERIC_CHECK); ?>
    }]
});
chartPieService.render();
 

 
 
var chartPieImporter = new CanvasJS.Chart("chartContainerPieImporter", {
    animationEnabled: true,
    theme: "dark2",
    title: {
        text: " Hits Importer Wise :("+ <?php echo $total_mo_hit; ?> +")",
        fontSize: 16
    },
       
   
    data: [{
        type: "pie",
        indexLabelFontSize: 10,
        yValueFormatString: "#,##0.00\"%\"",
        indexLabel: "{label} ({y})",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chartPieImporter.render();



<?php $output ='

var chart = new CanvasJS.Chart("chartContainer", {
    theme: "light2",
    animationEnabled: true,
    title: {
        text: "World Energy Consumption by Sector - 2012"
    },
    data: [{
        type: "pie",
        indexLabel: "{y}",
        yValueFormatString: "#,##0.00\"%\"",
        indexLabelPlacement: "inside",
        indexLabelFontColor: "#36454F",
        indexLabelFontSize: 18,
        indexLabelFontWeight: "bolder",
        showInLegend: true,
        legendText: "{label}",
        dataPoints: '. json_encode($dataPoints, JSON_NUMERIC_CHECK) .'
    }]
});
chart.render();
 

';

?>

}// end windows on load
</script>