
<footer class="page-footer font-small unique-color-dark bg-dark text-white">
  <?php if(!(isset($_SESSION['id']))){ ?>
  <div class="bg-dark">
    <div class="container">

      <!-- Grid row-->
      <div class="row py-4 d-flex align-items-center">

        <!-- Grid column -->
        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
          <h6 class="mb-0">Want to join us ? </h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-6 col-lg-7 text-center text-md-right">

          <!-- Facebook -->
          <a class="btn btn-light" href="?page=register">Create an account</a>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->

    </div>
  </div>
  <?php } ?>
<hr>
  <!-- Footer Links -->
  <div class="container text-center text-md-left mt-5 bg-dark text-white">

    <!-- Grid row -->
    <div class="row mt-3">

      <!-- Grid column -->
      <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

        <!-- Content -->
        <h6 class="text-uppercase font-weight-bold"><?php echo $_Config_['General']['name']; ?></h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p><?php echo $_Config_['General']['description']; ?></p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Pages</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <?php 
        	while($s = $listpages->fetch()){
        ?>
	        <p>
	          <a href="<?php echo $s['LINK']; ?>"><?php echo $s['NAME']; ?></a>
	        </p>
        <?php } ?>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Useful links</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <?php 
        	while($s = $listlinks->fetch()){
        ?>
	        <p>
	          <a href="<?php echo $s['LINK']; ?>"><?php echo $s['NAME']; ?></a>
	        </p>
        <?php } ?>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

        <!-- Links -->
        <h6 class="text-uppercase font-weight-bold">Contact</h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <?php 
        	while($s = $listcontacts->fetch()){
        ?>
        	<p>
        		<?php if(!empty($s['LINK'])){ echo "<a class='text-white' href='".$s['LINK']."'>"; }?><i class="<?php echo $s['ICON']; ?> mr-3"></i> <?php echo $s['NAME']; ?><?php if(!empty($s['LINK'])){ echo "</a>"; }?>
      		</p>
        <?php } ?>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3"><?php echo date("Y"); ?> © Powered by <a href="https://domcord.dommioss.fr/"> DomCord</a> <i>(<?php echo $_Config_['version']; ?>)</i> using theme <i><?php echo $_Config_['General']['theme']; ?></i>

  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->