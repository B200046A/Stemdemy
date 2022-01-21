<script>
  setTimeout(function(){
    if(document.getElementById('status')!=null){
      document.getElementById('status').style.display = 'none';
    }
    if(document.getElementById('success')!=null){
      document.getElementById('success').style.display = 'none';
    }
    if(document.getElementById('danger')!=null){
      document.getElementById('danger').style.display = 'none';
    }
  }, 5000); // 10000ms = 10s

  $('button[id="search_category"]').on('click', function(){
    //$("[name='keyterm']").val(this.value);
    $("[name='nav_category']").val(this.value);
    jQuery("#nav_search_btn").trigger('click');
    return false;
  });

</script>
<footer class="bg-secondary text-white mt-5">
    <!-- Grid container -->
    <div class="container p-4">
    <!--Grid row-->
    <div class="row">
        <!--Grid column-->
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase mb-4">Stemdemy</h5>

        <p class="m-3">
            Learners around the world are launching new careers, advancing in their fields, and enriching their lives.
            We help organizations of all types and sizes prepare for the path ahead — wherever it leads. Our curated collection of business and technical courses help companies, governments, and nonprofits go further by placing learning at the center of their strategies.
        </p>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
              Contact
            </h6>
            <p><i class="bi bi-house-door-fill"></i> New York, NY 10012, US</p>
            <p>
              <i class="bi bi-envelope"></i>
                info@example.com
            </p>
            <p><i class="bi bi-phone"></i> + 01 234 567 88</p>
            <p><i class="bi bi-printer"></i> + 01 234 567 89</p>
          </div>
    </div>
    <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2021 Copyright:
    <a class="text-white" href="#">Stemdemy.com</a>
    </div>
    <!-- Copyright -->
</footer>

</body>
</html>