

<?php
include("../initialize.php");
includeCore();
includeMapFunctions();

$Barangays = getDistinctBarangay();
//var_dump($Barangays);
?>

<!DOCTYPE html>
<html>
  <head>
   
    <?php
        includeHead("PSRMS - Maps");
    ?>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        z-index: 99!important;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding-left: 125px;
      }
    </style>
  </head>
  <body>
            <?php includeNav(); ?>
            
              <div id="map"></div>
           
           <?php includeCommonJS(); ?>
  </body>

   <script>

      function initMap() {

       var Barangays = <?php echo json_encode( $Barangays ) ?>;
       
        
        var lat = [9.175143];
        var lng = [124.2373336];

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: lat[0], lng: lng[0]},

        });
        for( var i = 0; i<Barangays.length; i++){
        var marker = new google.maps.Marker({
          position: {lat: Number(Barangays[i]['Latitude']), lng: Number(Barangays[i]['Longitude'])},
          map: map,
          label:'' + Barangays[i]['count'],    
          title: 'Hello World!'
        });
        }

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFAp9gNrwmudtqEojqtBt--NcfiVUD2KE&callback=initMap"
    async defer></script>
</html>