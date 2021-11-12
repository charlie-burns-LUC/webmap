

var map, searchID, featureList,aocTable, ctlSearch, openTopoBasemap, riverHabitatLayer, imageryBasemap, areasOfConservationLayer, ancientWoodlandLayer,riverHabitatSearch = [], areasOfConservationSearch = [], ancientWoodlandSearch = [], boroughSearch = [], theaterSearch = [], museumSearch = [];




$(document).ready(function(){  



  $('#login_button').click(function(){  
       var username = $('#username').val();  
       var password = $('#password').val();  
       if(username != '' && password != '')  
       {  
            $.ajax({  
                 url:"assets/js/action.php",  
                 method:"POST",  
                 data: {username:username, password:password},  
                 success:function(response)                  {  

                      //alert(data);  
                      if($.trim(response) == 'non')                       {  
                           alert("Wrong Data");  
                      }  
                      else if($.trim(response) == 'bien')  
                      {  
                    $('#loginModal').hide();  
                        location.reload();  
                      }  
                 }  
            });  
       }  
       else  
       {  
            alert("Both Fields are required");  
       }  
  });
  
  $('#logout').click(function(){  
    var action = "logout";  
    $.ajax({  
         url:"assets/js/action.php",  
         method:"POST",  
         data:{action:action},  
         success:function()  
         {  
              location.reload();  
         }  
    });  
}); 
});  


$("li .AOCData").click(function() {  
//  adding the layer when the tab is opened stops the error
//  areasOfConservationLayer.addTo(map);

  // Put in URL to AGOL JSON, build using ArcGIS REST endpoint query tool (query 1=1, fields = *)   
  var url = "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Special_Areas_of_Conservation_England/FeatureServer/0/query?where=1=1&outFields=*&f=pjson";

 
  // DataTable settings - for more help see here: https://datatables.net/reference/option/	
   aocTable = $('#landings_table-aoc').DataTable({
    // Change table element ID here       
    dom: 'Bfrtip',
    // Add this to enable export buttons       
    buttons: [
      // Add this to choose which buttons to display           
      'copy', 'csv', 'excel', 'pdf', 'print'], "autoWidth": false,
    // Feature control DataTables' smart column width handling       
    "deferRender": true,
    // Feature control deferred rendering for additional speed of initialisation.       
    "info": true,
    // Display info about table including filtering       
    "lengthChange": false,
    // If pagination is enabled, allow the page length to be changed by user        
    "ordering": true,
    // Toggle user ordering of table columns        
    "paging": false, // Toggle table paging       
    // Toggle "processing" indicator useful when loading large table/filter      
    "scrollX": false,
    // Left/right scrolling option, in pixels or false to disable   
    "scrollY": "400px",
    "sScrollXInner": "100%",

    "searching": true,
    "stateSave": false, "scrollCollapse": true,
    "ajax": { // Load data from AJAX data source (JSON)		
      "url": url,
      
      // JSON URL		
      "dataSrc": "features"
      // Within the JSON, the source for the data. For AGOL tables this will be "features"	
    }, "columns": [ // Location within the JSON of each column to pipe into the HTML table, in order of columns. For AGOL items, fields stored within attributes array of JSON.		
      { data: "attributes.OBJECTID" }, { data: "attributes.SAC_NAME" }, { data: "attributes.SAC_CODE"},
      // Use render to format with commas, see here: https://datatables.net/manual/data/renderers#Number-helper          
      { data: "attributes.Shape__Area"},{            "defaultContent": "<button>Click!</button>"
    }
      // Use render to format as $			
    ], "language": { "emptyTable": "Loading...", "search": "Search all fields:" }
    
  });

});

$('#landings_table-aoc tbody').on( 'click', 'button', function () {
  var data = aocTable.row( $(this).parents('tr') ).data();
 //  console.log(data);
  //alert( data[0] +"'s salary is: "+ data[ 1 ] );

  
  // console.log(areasOfConservationSearch);
  console.log(areasOfConservationSearch);

  searchID = 825;
  var featureBounds = areasOfConservationSearch.find(x => x.id === searchID).bounds;
  // console.log(featureBounds);
  
  map.fitBounds(featureBounds)
} );




$("li .RiverHabitatData").click(function() {  

  // Put in URL to AGOL JSON, build using ArcGIS REST endpoint query tool (query 1=1, fields = *)   
  var url = "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Priority_River_Habitat_Headwater_Areas/FeatureServer/0/query?where=1=1&outFields=*&f=pjson";

 
  // DataTable settings - for more help see here: https://datatables.net/reference/option/	
  var table = $('#landings_table-prh').DataTable({
    // Change table element ID here       
    dom: 'Bfrtip',
    // Add this to enable export buttons       
    buttons: [
      // Add this to choose which buttons to display           
      'copy', 'csv', 'excel', 'pdf', 'print'], "autoWidth": false,
    // Feature control DataTables' smart column width handling       
    "deferRender": true,
    // Feature control deferred rendering for additional speed of initialisation.       
    "info": true,
    // Display info about table including filtering       
    "lengthChange": false,
    // If pagination is enabled, allow the page length to be changed by user        
    "ordering": true,
    // Toggle user ordering of table columns        
    "paging": false, // Toggle table paging       
    // Toggle "processing" indicator useful when loading large table/filter      
    "scrollX": false,
    // Left/right scrolling option, in pixels or false to disable   
    "scrollY": "400px",
    "sScrollXInner": "100%",

    "searching": true,
    "stateSave": false, "scrollCollapse": true,
    "ajax": { // Load data from AJAX data source (JSON)		
      "url": url,
      // JSON URL		
      "dataSrc": "features"
      // Within the JSON, the source for the data. For AGOL tables this will be "features"	
    }, "columns": [ // Location within the JSON of each column to pipe into the HTML table, in order of columns. For AGOL items, fields stored within attributes array of JSON.		
      { data: "attributes.OBJECTID" }, { data: "attributes.ea_wb_id" }, { data: "attributes.Comment"},
      // Use render to format with commas, see here: https://datatables.net/manual/data/renderers#Number-helper          
      { data: "attributes.Non_semi_n"}
      // Use render to format as $			
    ], "language": { "emptyTable": "Loading...", "search": "Search all fields:" }
  });

});



$("li .AncientWoodlandData").click(function() {  

  // Put in URL to AGOL JSON, build using ArcGIS REST endpoint query tool (query 1=1, fields = *)   
  var url = "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Ancient_Woodland_England/FeatureServer/0/query?where=1=1&outFields=*&f=pjson";
 
  // DataTable settings - for more help see here: https://datatables.net/reference/option/	
  var table = $('#landings_table_aw').DataTable({
    // Change table element ID here       
    dom: 'Bfrtip',
    // Add this to enable export buttons       
    buttons: [
      // Add this to choose which buttons to display           
      'copy', 'csv', 'excel', 'pdf', 'print'], "autoWidth": false,
    // Feature control DataTables' smart column width handling       
    "deferRender": true,
    // Feature control deferred rendering for additional speed of initialisation.       
    "info": true,
    // Display info about table including filtering       
    "lengthChange": false,
    // If pagination is enabled, allow the page length to be changed by user        
    "ordering": true,
    // Toggle user ordering of table columns        
    "paging": false, // Toggle table paging       
    // Toggle "processing" indicator useful when loading large table/filter      
    "scrollX": false,
    // Left/right scrolling option, in pixels or false to disable   
    "scrollY": "400px",
    "sScrollXInner": "100%",

    "searching": true,
    "stateSave": false, "scrollCollapse": true,
    "ajax": { // Load data from AJAX data source (JSON)		
      "url": url,
      // JSON URL		
      "dataSrc": "features"
      // Within the JSON, the source for the data. For AGOL tables this will be "features"	
    }, "columns": [ // Location within the JSON of each column to pipe into the HTML table, in order of columns. For AGOL items, fields stored within attributes array of JSON.		
      { data: "attributes.OBJECTID" }, { data: "attributes.NAME" }, { data: "attributes.THEME"},
      // Use render to format with commas, see here: https://datatables.net/manual/data/renderers#Number-helper          
      { data: "attributes.Shape__Area"}
      // Use render to format as $			
    ], "language": { "emptyTable": "Loading...", "search": "Search all fields:" }
  });

});

$(document).ready(function () {

  var newParent = document.getElementById('custom-map-controls');
   var oldParent = document.getElementsByClassName("leaflet-control-ocd-search leaflet-control")
  
          while (oldParent[0].childNodes.length > 0) {
              newParent.appendChild(oldParent[0].childNodes[0]);
          }

  
     //     document.getElementsByClassName("navbar-brand").style.width="300px;"

      /*    var x = document.getElementsByClassName('leaflet-control-ocd-search-form input');
          for(var i=0; i< x.length;i++){
             x[i].style.width = "300px";
             x[i].style.height = "300px";
          }


          var children = document.getElementsByClassName('leaflet-control-ocd-search-form').children;
          
          for (var i = 0; i < children.length; i++) {
             children[i].style.width = "300px";
          }
        
*/
   });


$(window).resize(function() {
  sizeLayerControl();
});

$(document).on("click", ".feature-row", function(e) {
  $(document).off("mouseout", ".feature-row", clearHighlight);
  sidebarClick(parseInt($(this).attr("id")),$(this).attr("layerName"), $(this).attr("lng"));
});

/*
if ( !("ontouchstart" in window) ) {
  $(document).on("mouseover", ".feature-row", function(e) {
    highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
  });
}
*/




$(document).on("mouseout", ".feature-row", clearHighlight);

$("#about-btn").click(function() {
  $("#aboutModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});



$("#legend-btn").click(function() {
  $("#legendModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#login-btn").click(function() {
  $("#loginModal").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});

$("#list-btn").click(function() {
  animateSidebar();
  return false;
});

$("#nav-btn").click(function() {
  $(".navbar-collapse").collapse("toggle");
  return false;
});

$("#sidebar-toggle-btn").click(function() {
  animateSidebar();
  return false;
});

$("#sidebar-hide-btn").click(function() {
  animateSidebar();
  return false;
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
  $($.fn.dataTable.tables(true)).DataTable()
     .columns.adjust();
});
$("#login-btn").click(function() {
  $("#loginModal2").modal("show");
  $(".navbar-collapse.in").collapse("hide");
  return false;
});
$("#dialog-ok").on("click", function() {
  $("#loginModal").modal("hide");
  $("#dialog2").modal("show");
});


function sidebarClick(id, layer, lng) {

  if (layer == 'AOC'){
  var featureBounds = areasOfConservationSearch.find(x => x.id === id).bounds;
  map.fitBounds(featureBounds)

  }
  if (layer == 'river habitat'){
     // works   var featureBounds = riverHabitatSearch.find(x => x.id === "GB104027062520").bounds;
    var featureBounds = riverHabitatSearch.find(x => x.id === lng).bounds;
    map.fitBounds(featureBounds)
  
    }
  /* Hide sidebar and go to the map on small screens */
  if (document.body.clientWidth <= 767) {
    $("#sidebar").hide();
    map.invalidateSize();
  }
}






 function showBaseMap(basemap, divID) {
         var checkBox = document.getElementById(divID);
         if (checkBox.checked == true){
         console.log("checked")
         map.addLayer(basemap);
         
        } else {
            map.removeLayer(basemap);

    }
  }



  function showLayer(lyr, layerDivID) {
    var checkBox = document.getElementById(layerDivID);
     // if checkbox is ticked
      if (checkBox.checked == true){

        if (layerDivID === 'AreasOfConservationSelect'){
      $( "#feature-list-aoc tbody" ).empty();
      areasOfConservationSearch = [];
      areasOfConservationLayer = L.esri.featureLayer({
        url: "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Special_Areas_of_Conservation_England/FeatureServer/0", simplifyFactor: 0.7,
        precision: 4, onEachFeature: processAreasOfConservation,
      
        style: function (feature) {
            return { color: "#0c963f", weight: 3 };
        }
        
      })
      areasOfConservationLayer.addTo(map);
       }
       if (layerDivID === 'PriorityRiverHabitatSelect'){
        $( "#feature-list tbody" ).empty();
        riverHabitatLayer = L.esri.featureLayer({
          url: "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Priority_River_Habitat_Headwater_Areas/FeatureServer/0",
          simplifyFactor: 0.2,
          precision: 7, onEachFeature: processRiverHabitat,
          style: function (feature) {
        
              if (feature.properties.Semi_natur > 80) {
                  return { color: '#1C3564', weight: 2, dashArray: "5,10" };
              } else if (feature.properties.Semi_natur > 65) {
                  return { color: '#3F5B96', weight: 2, dashArray: "5,10" };
              } else if (feature.properties.Semi_natur > 50) {
                  return { color: '#8299C9', weight: 2, dashArray: "5,10" };
              } else if (feature.properties.Semi_natur > 35) {
                  return { color: '#DAECF4', weight: 2, dashArray: "5,10" };
              }
              else if (feature.properties.Semi_natur > 25) {
                  return { color: '#9D8888', weight: 2, dashArray: "5,10" }
              }
        
              else {
                  return { color: '#D65151', weight: 2, dashArray: "5,10" };
              }
          }
        })
        riverHabitatLayer.addTo(map);
         }
    }
        // if checkbox is unticked
      if (checkBox.checked == false) {
     
      console.log(layerDivID)
       if (layerDivID === 'AreasOfConservationSelect'){
         console.log("aoc layer unticked so clear sidebar of aoc features")
     $( "#feature-list-aoc tbody" ).empty();
     areasOfConservationSearch = [];
     map.removeLayer(areasOfConservationLayer);
      }
      if (layerDivID === 'PriorityRiverHabitatSelect'){
        console.log("river habitat layer unticked so clear sidebar of river habitat features")
    $( "#feature-list tbody" ).empty();
     }
     if (layerDivID === 'AncientWoodlandSelect'){
      console.log("ancient woodland layer unticked so clear sidebar of ancient woodland features")
  $( "#feature-list-aw tbody" ).empty();
   }
      map.removeLayer(lyr);
     
      }
    }
  
  function showKey(layerDivID) {
    var checkBox = document.getElementById(layerDivID);
    if (layerDivID === "PriorityRiverHabitatSelect"){
      console.log("river habitat key selected")

      // if checkbox is ticked
    if (checkBox.checked == true){
      $( ".riverHabitatKey" ).show();
  }
      // if checkbox is unticked
     else {
        // remove the key
        $( ".riverHabitatKey" ).hide();
    }
  }

  else if (layerDivID === "AreasOfConservationSelect"){

    // if checkbox is ticked
  if (checkBox.checked == true){
    $( ".aocKey" ).show();
}
    // if checkbox is unticked
   else {
      // remove the key
      $( ".aocKey" ).hide();
  }
}

else if (layerDivID === "AncientWoodlandSelect"){
  console.log("Ancient Woodland selected")

  // if checkbox is ticked
if (checkBox.checked == true){
  $( ".ancientWoodlandKey" ).show();
}
  // if checkbox is unticked
 else {
    // remove the key
    $( ".ancientWoodlandKey" ).hide();
}
}
  }

function animateSidebar() {
  $("#sidebar").animate({
    width: "toggle"
  }, 350, function() {
    map.invalidateSize();
  });
}

function sizeLayerControl() {
  $(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
}

function clearHighlight() {
  highlight.clearLayers();
}

function processAreasOfConservation(feature, layer) {

  var att = layer.feature.properties;
  areasOfConservationSearch.push({
    name: att.SAC_NAME,
    id: att.OBJECTID,
    bounds: layer.getBounds()
  });

// console.log(layer.getBounds())
// map.fitBounds(layer.getBounds())
// console.log(areasOfConservationSearch);

  layer.bindTooltip("<span style = 'font-size: 16px;'>" + att.SAC_NAME +   "</span><br>ID: " + att.OBJECTID +
      "<br>Latitude: " + att.LATITUDE + "<span style = 'font-size: 12px;'><br>Longitude:" + att.LONGITUDE +
      "<br>Area m<sup>2</sup>:" + att.Shape__Area + "<br>Status:" + att.STATUS + "</span>", layer.feature.properties);

// start filling the sidebar with a row for each feature. Also get the bounds of each feature and store as an attribute in the table 
// so that we can zoom there when it is clicked on

      /*  $("#feature-list-aoc tbody").append
        ('<tr class="feature-row" bounds = "'+ layer.getBounds() +'" id="' + att.OBJECTID + '" layerName="' + "AOC"  + '" lng="' + att.LONGITUDE + '" ><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/AOC.png"></td> <td class="feature-name">' + att.OBJECTID + '</td>   <td class="feature-name">' + att.SAC_NAME + '</td>  <td class="feature-name">' + att.SAC_CODE + '</td>   <td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>'); */
        
}

function processAncientWoodland(feature, layer) {

  var att = layer.feature.properties;

  areasOfConservationSearch.push({
    name: att.NAME,
    id: att.OBJECTID ,
    bounds: layer.getBounds()
  });

  if (map.getBounds().contains(layer.getBounds())) {
     
    $("#feature-list-aw tbody").append
    ('<tr class="feature-row" bounds = "'+ layer.getBounds() +'" id="' + att.OBJECTID + '" layerName="' + "AOC"  + '" lng="' + "att.LONGITUDE" + '" ><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/ancient_woodland.png"></td><td class="feature-name">' + att.NAME + '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
    
  }

}

function processRiverHabitat (feature, layer){
  var att = layer.feature.properties;


  riverHabitatSearch.push({
    id: att.ea_wb_id,
    bounds: layer.getBounds()
  });
 // console.log(riverHabitatSearch);


  if (map.getBounds().contains(layer.getBounds())) {
     
    $("#feature-list tbody").append
    ('<tr class="feature-row" bounds = "'+ layer.getBounds() +'" id="' + att.ea_wb_id + '" layerName="' + "river habitat" + '" lng="' + att.ea_wb_id + "11"+ '" ><td style="vertical-align: middle;"><img width="16" height="18" src="assets/img/river.png"></td><td class="feature-name">' + att.ea_wb_id+  '</td><td style="vertical-align: middle;"><i class="fa fa-chevron-right pull-right"></i></td></tr>');
    
 //   ('<tr class="feature-row" bounds = "'+ layer.getBounds() +'" id="' + att.ea_wb_id + '"</tr>');
    
  }
  
}

/* Basemap Layers */
imageryBasemap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
});

openTopoBasemap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
	maxZoom: 17,
	attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
});

var cartoLight = L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}.png", {
  maxZoom: 19,
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, &copy; <a href="https://cartodb.com/attributions">CartoDB</a>'
});
var usgsImagery = L.layerGroup([L.tileLayer("http://basemap.nationalmap.gov/arcgis/rest/services/USGSImageryOnly/MapServer/tile/{z}/{y}/{x}", {
  maxZoom: 15,
}), L.tileLayer.wms("http://raster.nationalmap.gov/arcgis/services/Orthoimagery/USGS_EROS_Ortho_SCALE/ImageServer/WMSServer?", {
  minZoom: 16,
  maxZoom: 19,
  layers: "0",
  format: 'image/jpeg',
  transparent: true,
  attribution: "Aerial Imagery courtesy USGS"
})]);

/* Overlay Layers */

 riverHabitatLayer = L.esri.featureLayer({
  url: "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Priority_River_Habitat_Headwater_Areas/FeatureServer/0",
  simplifyFactor: 0.2,
  precision: 7, onEachFeature: processRiverHabitat,
  style: function (feature) {

      if (feature.properties.Semi_natur > 80) {
          return { color: '#1C3564', weight: 2, dashArray: "5,10" };
      } else if (feature.properties.Semi_natur > 65) {
          return { color: '#3F5B96', weight: 2, dashArray: "5,10" };
      } else if (feature.properties.Semi_natur > 50) {
          return { color: '#8299C9', weight: 2, dashArray: "5,10" };
      } else if (feature.properties.Semi_natur > 35) {
          return { color: '#DAECF4', weight: 2, dashArray: "5,10" };
      }
      else if (feature.properties.Semi_natur > 25) {
          return { color: '#9D8888', weight: 2, dashArray: "5,10" }
      }

      else {
          return { color: '#D65151', weight: 2, dashArray: "5,10" };
      }
  }
})


riverHabitatLayer.bindPopup(function (e) {
  return L.Util.template("<div style = 'padding:0px;'><span style = 'font-size: 16px;'>ID:{ea_wb_id}</span><br>Percentage semi-natural vegetation: {Semi_natur}<br>Area:{Shape__Area}<br>Urban class:{URBAN_CLAS}</div>", e.feature.properties)
});


ancientWoodlandLayer = L.esri.featureLayer({
  url: "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Ancient_Woodland_England/FeatureServer/0",
  simplifyFactor: 5,
  precision: 4, onEachFeature: processAncientWoodland,
  style: function () {
      return { color: "#b9522f", weight: 2 };
  }
})

ancientWoodlandLayer.bindPopup(function (layer) {
  return L.Util.template("<div style = 'padding:0px;'><span style = 'font-size: 16px;'>Name:{NAME}</span><br>ID: {OBJECTID}<br>Theme:{THEME}<br>Status:{STATUS}</div>", layer.feature.properties)
});


areasOfConservationLayer = L.esri.featureLayer({
  url: "https://services.arcgis.com/JJzESW51TqeY9uat/ArcGIS/rest/services/Special_Areas_of_Conservation_England/FeatureServer/0", simplifyFactor: 0.7,
  precision: 4, onEachFeature: processAreasOfConservation,

  style: function (feature) {
      return { color: "#0c963f", weight: 3 };
  }
  
})



var highlight = L.geoJson(null);
var highlightStyle = {
  stroke: false,
  fillColor: "#00FFFF",
  fillOpacity: 0.7,
  radius: 10
};


map = L.map("map", {
  zoom: 10,
  center: [53.505, -2.09],
  layers: [cartoLight],
  zoomControl: false,
  attributionControl: false
});

/* Layer control listeners that allow for a single markerClusters layer 
map.on("overlayadd", function(e) {
  if (e.layer === areasOfConservationLayer) {
    console.log("added")
  }
 else {

 console.log("no")
  }
});

*/

/* Clear feature highlight when map is clicked */
map.on("click", function(e) {
  highlight.clearLayers();
  console.log("click")
});

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({
  position: "bottomright",
  drawCircle: true,
  follow: true,
  setView: true,
  keepCurrentZoomLevel: true,
  markerStyle: {
    weight: 1,
    opacity: 0.8,
    fillOpacity: 0.8
  },
  circleStyle: {
    weight: 1,
    clickable: false
  },
  icon: "fa fa-location-arrow",
  metric: false,
  strings: {
    title: "My location",
    popup: "You are within {distance} {unit} from this point",
    outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
  },
  locateOptions: {
    maxZoom: 18,
    watch: true,
    enableHighAccuracy: true,
    maximumAge: 10000,
    timeout: 10000
  }
}).addTo(map);

ctlSearch = L.Control.openCageSearch({ key: '3c38d15e76c02545181b07d3f8cfccf0', limit: 10 }).addTo(map);


/* Larger screens get expanded layer control and visible sidebar */
if (document.body.clientWidth <= 767) {
  var isCollapsed = true;
} else {
  var isCollapsed = false;
}


var baseLayers = {
  "Street Map": cartoLight,
  "Aerial Imagery": usgsImagery
};



