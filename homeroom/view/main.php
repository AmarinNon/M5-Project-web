<!-- particles.js container -->
<div id="particles"></div>

<div id="teacher-role-picker" class="logincard">
  <div class="pmd-card card-default">
    <div class="login-card">
        <div class="pmd-card-title card-header-border text-center">
          <div class="loginlogo">
            <?php include 'images/svg/logo-blue.svg';?>
          </div>
        </div>
        <div class="pmd-card-body text-center">
          <div class="row">
            <div class="col-xs-6">
              <a href="swap_module.php?mode=Homeroom&url=teacher_manage.php" type="button" class="btn btn-link text-blue">
                <img src="images/svg/homeroom-blue.svg" alt="" class="img-responsive pulse-hover">
                <p class="bigger-110 mt-3">Homeroom</p>
              </a>
            </div>
            <div class="col-xs-6">
              <a href="swap_module.php?mode=Teacher&url=student.php" type="button" class="btn btn-link text-blue">
                <img src="images/svg/teach-blue.svg" alt="" class="img-responsive pulse-hover">
                <p class="bigger-110 mt-3">Subjects</p>
              </a>
            </div>
            <div class="col-xs-12">
              <a href="#" class="btn btn-link btn-logout text-blue">Sign out</a>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<style>
  #particles {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
	background-color: lightblue;
  }
</style>

<script>
  $(document).ready(function () {
    particlesJS('particles', particle_config);
  });

  $(document).on('click', '.btn-logout', function(e) {
      e.preventDefault();
      System.confirm('', 'Do you want to sign out?', function() {
        window.location = 'logout.php';
      }, function() {});
    });
</script>