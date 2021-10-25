<?php

include 'assets/control/connection.php';
include 'assets/control/loginControl.php';
session_start();


if(isset($_SESSION['username']))  {
  echo '<script type="text/javascript"> $("#loginModal").modal("show")</script>';

}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="theme-color" content="#000000">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Webmap</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css">
  <link rel="stylesheet"
    href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css">
  <link rel="stylesheet"
    href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css">
  <link rel="stylesheet"
    href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
  <link rel="stylesheet" href="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/opencagedata/leaflet-opencage-search@d4cbd36122efc8d17152b4177ed0e12165305441/dist/css/L.Control.OpenCageData.Search.min.css" />

  <link rel="stylesheet" href="assets/css/app.css">

  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon-76.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon-120.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon-152.png">
  <link rel="icon" sizes="196x196" href="assets/img/favicon-196.png">
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
  <!-- Prebuilt CSS styles for data tables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <!-- CSS styles for export buttons -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
</head>

<body>
  <style type="text/css" class="init">
    tfoot input {
      width: 100%;
      font-size: 8pt;
      padding: 1px;
      box-sizing: border-box;
    }
  </style>
  <!-- Optionally set custom CSS for table here. This CSS center aligns all columnsin all tables. For help see here: https://www.w3schools.com/css/css_table.asp -->
  <style type="text/css" class="custom_table">
    table {
      border-collapse: collapse;
    }

    th {
      text-align: center;
    }

    td {
      text-align: center;
    }
  </style>
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="  background-color: #6dae2b; border-color:#6dae2b
    ">
    <div class="container-fluid">
      <div class="navbar-header">
        <div class="navbar-icon-container">
          <a href="#" class="navbar-icon pull-right visible-xs" id="nav-btn"><i class="fa fa-bars fa-lg white"></i></a>
          <a href="#" class="navbar-icon pull-right visible-xs" id="sidebar-toggle-btn"><i
              class="fa fa-search fa-lg white"></i></a>
        </div>
        <a class="navbar-brand" href="#" style="margin-left: -10px;">Webmap</a>
      </div>
      <div class="navbar-collapse collapse">
        <div class="navbar-right" style = "width: 200px;">
        <div id="custom-map-controls" style = "width: 100%;"></div>
  </div>
        <ul class="nav navbar-nav">
          <?php  
          if(isset($_SESSION['username']))  
          {  
          ?>  
<li class="dropdown">
      <a id="toolsDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"
        style="color: #ffffff;"><i class="glyphicon glyphicon-user white"></i>&nbsp;&nbsp;<?php echo $_SESSION['username']; ?>&nbsp;<b
          class="caret"></b></a>
      <ul class="dropdown-menu" style = "min-width: 100%!important">
        <li>
          <row>
          <a href="#" id="logout">&nbsp;&nbsp;&nbsp;&nbsp;Logout</a>  

          </row>
        </li>

      </ul>
    </li>

          <?php  
          }  
          else  
          {  
          ?>  
          <li align="center">  
               <a href="#" style = "color: white!important; font-size: 14px!important; font-family: Helvetica;"  name="login" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#loginModal"><i
          class="glyphicon glyphicon-user white"></i>&nbsp;&nbsp;Login</a></li></a>  
          </li>  
          <?php  
          }  
          ?>  
          <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="about-btn"><i
                class="fa fa-question-circle white"></i>&nbsp;&nbsp;About</a></li>
          <li class="dropdown">
            <a id="toolsDrop" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"
              style="color: #ffffff;"><i class="fa fa-globe white"></i>&nbsp;&nbsp;Basemap Select <b
                class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>
                <row>

                  <input type="checkbox" id="ImagerySelect" name="scales"
                    onClick="showBaseMap(imageryBasemap, 'ImagerySelect')">
                  <a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="full-extent-btn"><i
                      class="fa fa-globe"></i>&nbsp;&nbsp;Esri World Imagery</a>

                </row>
              </li>
              <row>

                <input type="checkbox" id="TopoSelect" name="scales"
                  onClick="showBaseMap(openTopoBasemap, 'TopoSelect')">
                <a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="full-extent-btn"><i
                    class="fa fa-area-chart"></i>&nbsp;&nbsp;Topographical</a>

              </row>
              <li class="divider hidden-xs"></li>
              <li><a href="#" data-toggle="collapse" data-target=".navbar-collapse.in" id="login-btn"><i
                    class="fa fa-user"></i>&nbsp;&nbsp;Login</a></li>
            </ul>
          </li>
          <li class="hidden-xs"><a href="#" data-toggle="collapse" data-target="" id="list-btn"
              style="color: #ffffff;"><i class="fa fa-list white"></i>&nbsp;&nbsp;Feature List</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" id="downloadDrop" href="#" role="button" data-toggle="dropdown"
              style="color: #ffffff;"><i class="fa fa-cloud-download white"></i>&nbsp;&nbsp;Download <b
                class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="data/boroughs.geojson" download="boroughs.geojson" target="_blank" data-toggle="collapse"
                  data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Ancient Woodland (England)
                  © Natural England</a></li>
              <li><a href="data/subways.geojson" download="subways.geojson" target="_blank" data-toggle="collapse"
                  data-target=".navbar-collapse.in"><i class="fa fa-download"></i>&nbsp;&nbsp;Special Areas of
                  Conservation (England) © Natural England</a></li>
              <li><a href="data/DOITT_THEATER_01_13SEPT2010.geojson" download="theaters.geojson" target="_blank"
                  data-toggle="collapse" data-target=".navbar-collapse.in"><i
                    class="fa fa-download"></i>&nbsp;&nbsp;Priority River Habitat -Headwater Areas © Natural
                  England</a></li>

            </ul>
          </li>
         

        </ul>
      </div>


      <!--/.navbar-collapse
      
      
      -->
    </div>
  </div>

  <div id="container">
    <div class="row">

      <div class="col-md-2" style="background-color: #c5c5c5; height: 800px;">
        <div id="layerSelect" class="col-md-12" style="padding: 20px 0px 0px 20px;">
          <p style="font-weight: bold; margin: 0px; font-size: 16px;">Layer select</p>
          <br>


          <div class="row">
            <div class="col-12" style="padding:0px; font-size: 12px;">
              <div class="row">
                <div class="col-md-2">
                  <input type="checkbox" id="PriorityRiverHabitatSelect" name="scales"
                    onclick="showLayer(riverHabitatLayer, 'PriorityRiverHabitatSelect'), showKey('PriorityRiverHabitatSelect')">
                </div>
                <div class="col-md-10" style="padding: 0px 10px 0px 0px;">
                  <label for="scales">Priority River Habitat -Headwater Areas<br> © Natural
                    England</label>

                </div>

              </div>
              <div class="row">
                <div class="col-md-12 riverHabitatKey" style="display: none; padding: 0px 0px 10px 55px; ">
                  <div class="row"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/194515-200.png" width="40px">
                  </div>
                  <div class="row">
                    <h6 style="margin-top: 0px!important;">Percentage semi-natural<br> vegetation:</h6>
                  </div>
                  <div class="row"><i style="background: #1C3564"></i><span>&gt; 80%</span><br></div>
                  <div class="row"><i style="background: #3F5B96"></i><span>&gt; 65%</span><br></div>
                  <div class="row"> <i style="background: #8299C9"></i><span>&gt; 50%</span><br></div>
                  <div class="row"><i style="background: #DAECF4"></i><span>&gt; 35%</span><br></div>
                  <div class="row"><i style="background: #9D8888"></i><span>&gt; 25%</span><br></div>
                  <div class="row"><i style="background: #D65151"></i><span>&lt; 25%</span><br></div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-2">
                  <input type="checkbox" id="AncientWoodlandSelect" name="horns"
                    onclick="showLayer(ancientWoodlandLayer, 'AncientWoodlandSelect'),showKey('AncientWoodlandSelect')">
                </div>
                <div class="col-md-10" style="padding: 0px 10px 0px 0px;">
                  <label for="horns">Ancient Woodland (England) © Natural England</label>

                </div>

              </div>
              <div class="row">
                <div class="col-md-12 ancientWoodlandKey" style="display: none; padding: 0px 0px 10px 35px; ">
                  <svg overflow="hidden" width="30" height="30" style="touch-action: none;">
                    <defs></defs>
                    <path fill="#b9522f" fill-opacity="1" stroke="rgb(110, 110, 110)" stroke-opacity="1"
                      stroke-width="1.3333333333333333" stroke-linecap="butt" stroke-linejoin="miter"
                      stroke-miterlimit="4" path="M -10,-10 L 10,0 L 10,10 L -10,10 L -10,-10 Z"
                      d="M-10-10L 10 0L 10 10L-10 10L-10-10Z" fill-rule="evenodd" stroke-dasharray="none"
                      dojoGfxStrokeStyle="solid"
                      transform="matrix(1.00000000,0.00000000,0.00000000,1.00000000,15.00000000,15.00000000)"></path>
                  </svg>
                </div>

              </div>
              <div class="row">
                <div class="col-md-2">
                  <input type="checkbox" id="AreasOfConservationSelect" name="horns"
                    onclick="showLayer(areasOfConservationLayer, 'AreasOfConservationSelect'), showKey('AreasOfConservationSelect')">
                </div>
                <div class="col-md-10" style="padding: 0px 10px 0px 0px;">
                  <label for="horns">Special Areas of Conservation (England) © Natural England</label>

                </div>

              </div>
              <div class="row">
                <div class="col-md-12 aocKey" style="display: none; padding: 0px 0px 10px 35px; ">
                  <svg overflow="hidden" width="30" height="30" style="touch-action: none;">
                    <defs></defs>
                    <path fill="#0c963f" fill-opacity="1" stroke="rgb(110, 110, 110)" stroke-opacity="1"
                      stroke-width="1.3333333333333333" stroke-linecap="butt" stroke-linejoin="miter"
                      stroke-miterlimit="4" path="M -10,-10 L 10,0 L 10,10 L -10,10 L -10,-10 Z"
                      d="M-10-10L 10 0L 10 10L-10 10L-10-10Z" fill-rule="evenodd" stroke-dasharray="none"
                      dojoGfxStrokeStyle="solid"
                      transform="matrix(1.00000000,0.00000000,0.00000000,1.00000000,15.00000000,15.00000000)"></path>
                  </svg>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-10">


        <div id="map" style="height: 800px;"></div>

      </div>
    </div>
  </div>

  <!-- <div id="loading">
      <div class="loading-indicator">
        <div class="progress progress-striped active">
          <div class="progress-bar progress-bar-info progress-bar-full"></div>
        </div>
      </div>
    </div>-->

  <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style = "width: 960px;">
        <div class="modal-header">
          <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">LUC data viewer</h4>
        </div>
        <div class="modal-body" >
          <ul class="nav nav-tabs nav-justified" id="aboutTabs">
            <li class="active"><a href="#about" data-toggle="tab"><i class="fa fa-question-circle"></i>&nbsp;About the
                project</a></li>
            <li><a href="#contact" data-toggle="tab"><i class="fa fa-envelope"></i>&nbsp;Contact us</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-globe"></i>&nbsp;Metadata <b
                  class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class = "AncientWoodlandData"><a href="#subway-lines-tab" data-toggle="tab">Ancient Woodland (England)
                    © Natural England</a></li>
                <li class="AOCData"><a href="#theaters-tab" data-toggle="tab">Special Areas of
                    Conservation (England) © Natural England</a></li>
                <li class="RiverHabitatData"><a href="#museums-tab" data-toggle="tab">Priority River Habitat -Headwater
                    Areas © Natural
                    England</a></li>


              </ul>
            </li>
          </ul>
          <div class="tab-content" id="aboutTabsContent">
            <div class="tab-pane fade active in" id="about">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volum.</p>
              <div class="panel panel-primary">
                <div class="panel-heading">Features</div>
                <ul class="list-group">
                  <li class="list-group-item">Suspendisse vitae neque feugiat, posuere arcu sed, cursus dui.
                  </li>
                  <li class="list-group-item">Etiam nec libero et magna sollicitudin congue sit amet ut nibh.</li>
                  <li class="list-group-item">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volum.</li>
                  <li class="list-group-item">Quisque dictum sem scelerisque leo pellentesque, id rutrum tellus aliquet.
                  </li>
                  <li class="list-group-item">Cras eget nisi eu ligula dignissim ornare.</li>
                  <li class="list-group-item">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in volum.</li>
                </ul>
              </div>
            </div>
            <div id="disclaimer" class="tab-pane fade text-danger">
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in volum.</p>

            </div>
            <div class="tab-pane fade" id="contact">
              <form id="contact-form">
                <div class="well well-sm">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="first-name">First Name:</label>
                        <input type="text" class="form-control" id="first-name">
                      </div>
                      <div class="form-group">
                        <label for="last-name">Last Name:</label>
                        <input type="text" class="form-control" id="last-email">
                      </div>
                      <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email">
                      </div>
                    </div>
                    <div class="col-md-8">
                      <label for="message">Message:</label>
                      <textarea class="form-control" rows="8" id="message"></textarea>
                    </div>
                    <div class="col-md-12">
                      <p>
                        <button type="submit" class="btn btn-primary pull-right" data-dismiss="modal">Submit</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane fade" id="boroughs-tab">

            </div>


            <div class="tab-pane fade" id="subway-lines-tab">
             <div> <p>Ancient Woodland (England)
                © Natural England
                <br>
                <a href="https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Ancient_Woodland_England/FeatureServer/0"
                  target="_blank"> ArcGIS REST Services Directory</a>
                </a>
              </p>
            </div>

                  <table id="landings_table_aw" class="stripe cell-border order-column hover" cellspacing="0"
                  >
                  <thead>
                    <tr>
                      <!-- Add the column header names for the table here	-->
                      <th width=10 style="color: #337ab7;">OBJECT_ID</th>
                      <th width=10 style="color: #337ab7;">Name</th>
                      <th width=10 style="color: #337ab7;">Theme</th>
                      <th width=10 style="color: #337ab7;">Area m<sup>2</sup> </th>
                    </tr>
                  </thead><!-- Include tfoot tag if using search fields at bottom of table, and put field names in. -->
  
                  <tbody> </tbody>
                </table>



            </div>

            <div class="tab-pane fade" id="theaters-tab">
             <div style = "color: #555"> <h5>Special Areas of Conservation (England) © Natural England</h5>
              <p style="font-size: 12px">A Special Area of Conservation (SAC) is the land designated under Directive
                92/43/EEC on the Conservation of Natural Habitats and of Wild Fauna and Flora.
                <br>
                Data supplied has the status of "Candidate". The data does not include "Possible" Sites. Boundaries are mapped against Ordnance Survey MasterMap.
                <br>
                Full metadata can be viewed on <a href="https://data.gov.uk/dataset/a85e64d9-d0f1-4500-9080-b0e29b81fbc8/special-areas-of-conservation-england">data.gov.uk</a>.
              </p>
            </div>
              <!-- <table class="table table-hover" id="feature-list-aoc">
  
  
                    <tbody class="list"></tbody>
                  </table> -->

              <table id="landings_table-aoc" class="stripe cell-border order-column hover" cellspacing="0"
              >
                <thead>
                  <tr>
                    <!-- Add the column header names for the table here	-->
                    <th width=4 style="color: #337ab7;">OBJECT_ID</th>
                    <th width=10 style="color: #337ab7;">SAC_NAME</th>
                    <th width=10 style="color: #337ab7;">SAC_CODE</th>
                    <th width=10 style="color: #337ab7;">SAC_AREA</th>
                    <th width=10 style="color: #337ab7;">VIEW</th>

                  </tr>
                </thead><!-- Include tfoot tag if using search fields at bottom of table, and put field names in. -->

                <tbody> </tbody>
              </table>




            </div>
            <div class="tab-pane fade" id="museums-tab" style = " overflow:auto;">
              <p>Priority river data</p>
              <table id="landings_table-prh" class="stripe cell-border order-column hover" cellspacing="0"
             >
              <thead>
                <tr>
                  <!-- Add the column header names for the table here	-->
                  <th width=10 style="color: #337ab7;">OBJECT_ID</th>
                  <th width=10 style="color: #337ab7;">EA_WB_ID </th>
                  <th width=10 style="color: #337ab7;">Comment</th>
                  <th width=10 style="color: #337ab7;">Area m<sup>2</sup></th>
                </tr>
              </thead><!-- Include tfoot tag if using search fields at bottom of table, and put field names in. -->

              <tbody> </tbody>
            </table>
            </div>
          </div>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal fade" id="legendModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Map Legend</h4>
        </div>
        <div class="modal-body">
          <p>Map Legend goes here...</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div id="loginModal" class="modal fade" role="dialog" data-toggle="modal" data-backdrop="static" data-keyboard="false">  
      <div class="modal-dialog"  style = "width: 350px!important; margin-top: 200px;">  
   <!-- Modal content-->  
           <div class="modal-content">  
                <div class="modal-header">  
                     <h4 class="modal-title">Login</h4>  
                </div>  
                <div class="modal-body">  
                     <label>Username</label>  
                     <input type="text" name="username" id="username" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" id="password" class="form-control" />  
                     <br />  
                     <button type="button" name="login_button" id="login_button" class="btn" style = "background-color: #6dae2b; color: #ffffff;" >Login</button>  
                </div>  
           </div>  
      </div>  
 </div> 

 

 

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>

  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
  <!-- Include these references if using export buttons -->
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@3.0.2/dist/esri-leaflet.js"
    integrity="sha512-myckXhaJsP7Q7MZva03Tfme/MSF5a6HC2xryjAM4FxPLHGqlh5VALCbywHnzs2uPoF/4G/QVXyYDDSkp5nPfig=="
    crossorigin=""></script>


  <script src="src/leaflet.markercluster.js"></script>

  <script
    src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
  <script src="assets/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/opencagedata/leaflet-opencage-search@d4cbd36122efc8d17152b4177ed0e12165305441/dist/js/L.Control.OpenCageSearch.min.js"></script>


  <script src="assets/js/app.js"></script>



  <?php			
if(!isset($_SESSION['username'])) {
		// CALL MODAL HERE
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#loginModal").modal("show");
			});
		</script>';
	} 
?>

</body>

</html>