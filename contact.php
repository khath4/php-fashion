<?php 
    $open ="contact";
	require_once __DIR__. "/autoload/autoload.php"; 
?>
<?php require_once __DIR__. "/layouts/header.php";  ?>  
		 <div id="contact-page" class="container">
    	<div class="bg">
	    	<div class="row">    		
	    		<div class="col-sm-12">    			   			
					<h2 class="title text-center">Vị Trí</h2>    			    				 			
					<div id="map" class="contact-map">
					</div>
				</div>			 		
			</div>    	
    		<div class="row">  	
	    	  <?php foreach ($contact as $value): ?> 
	    		<div class="col-sm-12">
	    			<div class="contact-info">
	    				<h2 class="title text-center">Thông Tin Liên Hệ</h2>
	    				<address class="text-center">
	    					<p>E-Shopper.</p>
	    					<p>Mobile: <?php echo $value['DienThoai'] ?></p>
							<p>Email: <?php echo $value['Email'] ?></p>
							<p>Địa Chỉ :<?php echo $value['DiaChi'] ?></p>
							<p>Facebook :<a href="<?php echo $value['LinkFace'] ?>"><?php echo $value['LinkFace'] ?></a></p>
							<?php
							    $_SESSION['KinhDo'] = $value['KinhDo'];
							    $_SESSION['ViDo'] = $value['ViDo'];
							?>
	    				</address>
	    			</div>
    			</div>
    			<?php endforeach; ?> 
	    	</div>  
    	</div>	
    </div><!--/#contact-page-->

<?php require_once __DIR__. "/layouts/footer.php";  ?>	
<script>
   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(<?php echo $_SESSION['KinhDo'] ?>,<?php echo $_SESSION['ViDo'] ?>),
          zoom: 17
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl('contact_out.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var DiaChi = markerElem.getAttribute('DiaChi');
              var Email = markerElem.getAttribute('Email');
              var DienThoai = markerElem.getAttribute('DienThoai');

              var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('KinhDo')),
                    parseFloat(markerElem.getAttribute('ViDo')));


               var infowincontent =  
                  '<div class="card-deck">'+
                  '<div class="card">'+
                      '<div class="card-body">' +
                        '<h5 class="card-title">Shop :E-Shopper</h5>'+
                        '<p class="card-text"><b>Điện Thoại :</b>'+DienThoai+'</p>'+
                        '<p class="card-text"><b>Email :</b>'+Email+'</p>'+
                        '<p class="card-text"><b>Địa Chỉ :</b>'+DiaChi+'</p>'+
                      '</div>'+
                  '</div>'+
                  '</div>';
             
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                draggable: true,
                animation: google.maps.Animation.DROP,
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }
        
      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>