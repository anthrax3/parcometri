<?php
$lat=$_GET["lat"];
$lon=$_GET["lon"];
$r=$_GET["r"];


//$url1  ="https://docs.google.com/spreadsheets/d/1dAPW1JSr3bQMFNBM3TF7kFGa95KZT5oY-72QjKipbeQ/pub?gid=310374111&single=true&output=csv";

//$urlgd=file_get_contents($url1);

$urlgd="https://goo.gl/1Fng9o";
//echo $urlgd;

//$url ="https://docs.google.com/spreadsheets/d/1x84pu3KF1_II7R8jFGwfzQfY33fOujidBqu_9lGUU_4/pub?gid=0&single=true&output=csv";
$inizio=1;
$homepage ="";
//  echo $url;
$csv = array_map('str_getcsv', file($urlgd));
$latidudine="";
$longitudine="";
$data=0.0;
$data1=0.0;
$count = 0;
$dist=0.0;
  $paline=[];
  $distanza=[];

foreach($csv as $data=>$csv1){
  $count = $count+1;
}

//$count=5;

//  echo $count;
for ($i=$inizio;$i<$count;$i++){

  $homepage .="\n";

  $lat10=floatval($csv[$i][1]);
  $long10=floatval($csv[$i][2]);
  $theta = floatval($lon)-floatval($long10);
  $dist =floatval( sin(deg2rad($lat)) * sin(deg2rad($lat10)) +  cos(deg2rad($lat)) * cos(deg2rad($lat10)) * cos(deg2rad($theta)));
  $dist = floatval(acos($dist));
  $dist = floatval(rad2deg($dist));
  $miles = floatval($dist * 60 * 1.1515 * 1.609344);
//echo $miles;

  if ($miles >1 || $miles == 1){
$data1 =number_format($miles, 2, '.', '');
    $data =number_format($miles, 2, '.', '')." Km";
      $t=floatval($r*1);
  } else {
    $data =number_format(($miles*1000), 0, '.', '')." mt";
$data1 =number_format(($miles*1000), 0, '.', '');
  $t=floatval($r*1000);
  }
  $csv[$i][100]= array("distance" => "value");

  $csv[$i][100]= $dat1;
  $csv[$i][101]= array("distancemt" => "value");

  $csv[$i][101]= $data;



      if ($data < $t)
      {

        $distanza[$i]['distanza'] =$csv[$i][100];
        $distanza[$i]['distanzamt'] =$csv[$i][101];
        $distanza[$i]['id'] =$csv[$i][0];
        $distanza[$i]['lat'] =$csv[$i][1];
        $distanza[$i]['lon'] =$csv[$i][2];
        $distanza[$i]['nome'] =$csv[$i][3];
        $distanza[$i]['topo'] =$csv[$i][4];
        $distanza[$i]['indirizzo'] =$csv[$i][5];
        $distanza[$i]['note'] =$csv[$i][6];
        $distanza[$i]['tariffa'] =$csv[$i][7];
        $distanza[$i]['zona'] =$csv[$i][8];


      }


}
//echo $homepage;

sort($distanza);

$file1 = "mappaf.json";
$original_data="";


$dest1 = fopen($file1, 'w');

//$geostring=geoJson($original_json_string);

$original_data = json_decode($distanza[$tt], true);
if(empty($distanza))
{

  echo "<script type='text/javascript'>alert('Non ci sono parcometri vicino alla tua posizione');</script>";

}
$features = array();

foreach($distanza as $key => $value) {
//  var_dump($value);
    $features[] = array(
            'type' => 'Feature',
            'geometry' => array('type' => 'Point', 'coordinates' => array((float)$value['lon'],(float)$value['lat'])),
            'properties' => array('id' => $value['id'], 'nome' => $value['nome'],'distanza' => $value['distanzamt'],'topo' => $value['topo'],'indirizzo' => $value['indirizzo'],'note' => $value['note'],'zona' => $value['zona'],'tariffa' => $value['tariffa']),
            );
    };

  $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);

$geostring =json_encode($allfeatures, JSON_PRETTY_PRINT);

//echo $geostring;
fputs($dest1, $geostring);


?>

<!DOCTYPE html>
<html lang="it">
  <head>
  <title>Mappa Parcometri LECCE</title>
  <link rel="shortcut icon" href="faviconp.ico" />
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="http://necolas.github.io/normalize.css/2.1.3/normalize.css" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.css" />
        <link rel="stylesheet" href="MarkerCluster.css" />
        <link rel="stylesheet" href="MarkerCluster.Default.css" />
        <meta property="og:image" content="http://www.piersoft.it/parcometri/parking.png"/>
  <script src="http://cdn.leafletjs.com/leaflet-0.7.5/leaflet.js"></script>
   <script src="leaflet.markercluster.js"></script>
<script type="text/javascript">

function microAjax(B,A){this.bindFunction=function(E,D){return function(){return E.apply(D,[D])}};this.stateChange=function(D){if(this.request.readyState==4 ){this.callbackFunction(this.request.responseText)}};this.getRequest=function(){if(window.ActiveXObject){return new ActiveXObject("Microsoft.XMLHTTP")}else { if(window.XMLHttpRequest){return new XMLHttpRequest()}}return false};this.postBody=(arguments[2]||"");this.callbackFunction=A;this.url=B;this.request=this.getRequest();if(this.request){var C=this.request;C.onreadystatechange=this.bindFunction(this.stateChange,this);if(this.postBody!==""){C.open("POST",B,true);C.setRequestHeader("X-Requested-With","XMLHttpRequest");C.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");C.setRequestHeader("Connection","close")}else{C.open("GET",B,true)}C.send(this.postBody)}};

</script>
  <style>
  #mapdiv{
        position:fixed;
        top:0;
        right:0;
        left:0;
        bottom:0;
}
#infodiv{
background-color: rgba(255, 255, 255, 0.70);

font-family: Titillium Web, Arial, Sans-Serif;
padding: 2px;


font-size: 12px;
bottom: 12px;
left:0px;


max-height: 50px;

position: fixed;

overflow-y: auto;
overflow-x: hidden;
}
#loader {
    position:absolute; top:0; bottom:0; width:100%;
    background:rgba(255, 255, 255, 1);
    transition:background 1s ease-out;
    -webkit-transition:background 1s ease-out;
}
#loader.done {
    background:rgba(255, 255, 255, 0);
}
#loader.hide {
    display:none;
}
#loader .message {
    position:absolute;
    left:50%;
    top:50%;
    font-family: Titillium Web, Arial, Sans-Serif;
    font-size: 15px;
}
</style>
  </head>

<body>

  <div data-tap-disabled="true">

  <div id="mapdiv"></div>
<div id="infodiv" style="leaflet-popup-content-wrapper">
  <p><b>Parcometri di Lecce ubicati nelle vicinanze<br></b>
  Mappa con ubicazione Parcometri di Lecce, nel raggio di 200mt dalla tua posizione. By @piersoft. Fonte dati Lic. CC-BY <a href="http://dati.comune.lecce.it/dataset/parcometri-citta-di-lecce">openData Lecce</a></p>
</div>
<div id='loader'><span class='message'>loading</span></div>
</div>
  <script type="text/javascript">
		var lat=parseFloat('<?php printf($_GET['lat']); ?>'),
        lon=parseFloat('<?php printf($_GET['lon']); ?>'),
        zoom=16;



        var osm = new L.TileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {maxZoom: 20, attribution: 'Map Data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});
		var mapquest = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png', {subdomains: '1234', maxZoom: 18, attribution: 'Map Data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'});

        var map = new L.Map('mapdiv', {
                    editInOSMControl: true,
            editInOSMControlOptions: {
                position: "topright"
            },
            center: new L.LatLng(lat, lon),
            zoom: zoom,
            layers: [osm]
        });

        var baseMaps = {
    "Mapnik": osm,
    "Mapquest Open": mapquest
        };
        L.control.layers(baseMaps).addTo(map);
        var markeryou = L.marker([parseFloat('<?php printf($_GET['lat']); ?>'), parseFloat('<?php printf($_GET['lon']); ?>')]).addTo(map);
        markeryou.bindPopup("<b>Sei qui</b>");
       var ico=L.icon({iconUrl:'parking_small.png', iconSize:[15,23],iconAnchor:[7.5,0]});
       var markers = L.markerClusterGroup({spiderfyOnMaxZoom: false, showCoverageOnHover: true,zoomToBoundsOnClick: true});

        function loadLayer(url)
        {
                var myLayer = L.geoJson(url,{
                        onEachFeature:function onEachFeature(feature, layer) {
                          var popup = '';
                          var str = ".jpg";
                          //var title = bankias.getPropertyTitle(clave);
                          popup += 'Dista: '+feature.properties.distanza+'</b><br />';
                          popup += feature.properties.nome+'</b><br />';
                          popup += feature.properties.topo+' '+feature.properties.indirizzo+'</b><br />';;
popup += 'Tariffa: '+feature.properties.tariffa+'</b><br />';
popup += feature.properties.zona+'</b><br />';
                          popup += feature.properties.note+'</b><br />';



                                if (feature.properties && feature.properties.id) {
                                }
layer.bindPopup(popup);
                        },
                        pointToLayer: function (feature, latlng) {
                        var marker = new L.Marker(latlng, { icon: ico });

                        markers[feature.properties.id] = marker;
                      //  marker.bindPopup('<img src="http://www.piersoft.it/dae/ajax-loader.gif">',{maxWidth:50, autoPan:true});

                      //  marker.on('click',showMarker());
                        return marker;
                        }
                }).addTo(map);

              //  markers.addLayer(myLayer);
              //  map.addLayer(markers);
              //  markers.on('click',showMarker);
        }

microAjax('mappaf.json',function (res) {
var feat=JSON.parse(res);
loadLayer(feat);
  finishedLoading();
} );
function startLoading() {
    loader.className = '';
}

function finishedLoading() {
    // first, toggle the class 'done', which makes the loading screen
    // fade out
    loader.className = 'done';
    setTimeout(function() {
        // then, after a half-second, add the class 'hide', which hides
        // it completely and ensures that the user can interact with the
        // map again.
        loader.className = 'hide';
    }, 500);
}
</script>

</body>
</html>
