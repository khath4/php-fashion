<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<?php foreach ($contact as $value): ?> 
							    <p>
							        <i class="fa fa-phone"></i> <?php echo $value['DienThoai'] ?> &nbsp 
							        <i class="fa fa-envelope"></i> <?php echo $value['Email'] ?>
							        </p>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2020 E-SHOPPER || Trần Hoàng Kha . All rights reserved.</p>
					<p class="pull-right">Designed by <span>Trần Hoàng Kha</span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

    <script src="<?php echo base_url() ?>public/fontend/js/jquery.js"></script>
	<script src="<?php echo base_url() ?>public/fontend/js/bootstrap.min.js"></script>
	<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
 <!--   <script type="text/javascript" src="<?php echo base_url() ?>public/fontend/js/gmaps.js"></script>-->
 <!--   <script src="<?php echo base_url() ?>public/fontend/js/contact.js"></script>-->
	<script src="<?php echo base_url() ?>public/fontend/js/jquery.scrollUp.min.js"></script>
	<script src="<?php echo base_url() ?>public/fontend/js/price-range.js"></script>
    <script src="<?php echo base_url() ?>public/fontend/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url() ?>public/fontend/js/starrr.js"></script>
    <script src="<?php echo base_url() ?>public/fontend/js/main.js"></script>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0ZmB1vQyyt1bdXrce2rBztaIMHoabC6o&callback=initMap" type="text/javascript"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="<?php echo base_url() ?>public/fontend/datatables/jquery.dataTables.min.js"></script>
  	<script src="<?php echo base_url() ?>public/fontend/datatables/dataTables.bootstrap4.min.js"></script> -->
   
</body>
</body>
</html>


<script type="text/javascript">
	$(function(){
        $updatecart = $(".updatecart");
        $updatecart.click(function(e) {
            e.preventDefault();
            $number = $(this).parents("tr").find(".SoLuong").val();
            console.log($number);
            $id_Size = $(this).parents("tr").find(".id_Size").val();
            $id = $(this).parents("tr").find(".id").val();
            $key = $(this).attr("data-key");

            $.ajax({
                url: 'cap-nhat-gio-hang.php',
                type: 'GET',
                data: {'SoLuong':$number, 'key':$key , 'id_Size':$id_Size ,  'id':$id},
                success:function(data)
                {
                    if (data == 0) 
                    {
                        location.href='cart.php';
                    }
                    else
                    {
                        
                        location.href='cart.php';
                    }
                }
            });
            
        })
    }) 
</script>
