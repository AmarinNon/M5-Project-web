<?php
$login_error = false;
if(isset($_POST['username']) && isset($_POST['password'])) {
  $login_result = System::callAPIOrigin(System::API_CODE['USER'], 'login', array(
      'username' => $_POST['username'],
      'password' => $_POST['password']
  ), false);

  if($login_result->response_status) {
    System::login($login_result->response_data[0]);
    System::redirect('index.php');
  } else {
    $login_error = true;
    System::notification($login_result->response_message, 'error');
    System::redirect();
  }
}
?>
<!-- particles.js container -->
<div id="particles"></div>

<div class="logincard">
  <div class="pmd-card card-default pmd-z-depth">
    <div class="login-card">
      <form action="" method="post">
	    <div class="col-xs-1">
              <a href="HomeroomTH" type="button" class="btn btn-link text-blue" >
                <p>TH</p>
              </a>
            </div>
        <div class="pmd-card-title card-header-border text-center">
          <div class="loginlogo">
            <?php include 'images/svg/logo-blue.svg';?>
          </div>
        </div>

        <div class="pmd-card-body">
          <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Username" autofocus required>
          </div>

          <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Password" required>
          </div>
        </div>
        <div class="pmd-card-footer card-footer-no-border card-footer-p16 text-center">
          <button type="submit" class="btn btn-link text-blue bigger-120">Login</button>
        </div>

      </form>
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
</script>