<?php 
  $user = System::callAPI(System::API_CODE['USER'], 'usergetallstate', null, false);

  if(isset($_POST['action'])){
    if($_POST['action'] == 'ban'){
      $ban_result = System::callAPI(System::API_CODE['USER'], 'userban', array(
        'user_id' => $_POST['user_id']
      ), false);
      System::redirect();
    } else if($_POST['action'] == 'unban'){
      $unban_result = System::callAPI(System::API_CODE['USER'], 'userunban', array(
        'user_id' => $_POST['user_id']
      ), false);
      System::redirect();
    }
  }

?>

<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <h1 class="section-title">
        <div class="media-top icon-title mr-2">
          <img src="images/svg/icon-01-blue.svg" alt="" class="img-responsive">
        </div>
      <span class="media-middle">Manage Teacher</span>
    </h1>

    <div class="section-content">
      <div class="row">
        <div class="col-xs-12">
          <div>
            <span class="btn-with-icon">
              <a href="manageuser.php?action=add" class="btn btn-default">
              <span class="fa fa-plus btn-icon img-circle"></span>Add Teacher</a>
            </span>
            <span class="btn-with-icon">
              <a href="manageuser.php?action=import" class="btn btn-default">
              <span class="fa fa-download btn-icon img-circle"></span>Import</a>
            </span>
          </div>
          <div class="mt-3 pmd-card">
            <div class="table-responsive">
              <table class="table pmd-table pmd-data-table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Name - Surname</th>
                    <th>username</th>
                    <th>Last Login</th>
                    <th>Status</th>
                    <th class="no-sort thin-cell"></th>
                  </tr>
                </thead>
									
                <tbody>
                <?php
                  $order = 1;
                  for($i = 0; $i < count($user) ; $i++) {
                    if($user[$i]->role == 'Teacher'){ ?>
                  <tr class="fadeIn animated">
                    <td><?php echo $order++; ?></td>
                    <td class="text-left"><?php echo $user[$i]->name." ".$user[$i]->surname; ?></td>
                    <td><?php echo $user[$i]->username; ?></td>
                    <td><?php echo ($user[$i]->lastlogin == '0000-00-00 00:00:00')? '-' : System::time_elapsed_string($user[$i]->lastlogin); ?></td>
                    <td>
                    <?php if($user[$i]->status == 'Active') { ?>
                      <span class="text-success bold"><?php echo $user[$i]->status; ?></span>
                    <?php } else { ?>
                      <span class="text-danger bold"><?php echo $user[$i]->status; ?></span>
                    <?php } ?>
                    </td>
                    <td class="thin-cell">
                      <a href="manageuser.php?action=edit&id=<?php echo $user[$i]->user_id; ?>" class="smaller-80 mr-2" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
                      <?php if($user[$i]->status == 'Active') { ?>
                        <form action="" method="POST" class="inline">
                          <input type="hidden" value="<?php echo $user[$i]->user_id; ?>" name="user_id">
                          <input type="hidden" value="ban" name="action">
                          <button type="submit" class="smaller-80 btn-link" data-toggle="tooltip" title="Blocked"><span class="fa fa-lock"></span></button>
                        </form>
                      <?php } else { ?>
                        <form action="" method="POST" class="inline">
                          <input type="hidden" value="<?php echo $user[$i]->user_id; ?>" name="user_id">
                          <input type="hidden" value="unban" name="action">
                          <button type="submit" class="smaller-80 btn-link" data-toggle="tooltip" title="Un blocked"><span class="fa fa-unlock"></span></button>
                        </form>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php 
                    }
                  }
                  ?>
                </tbody>
								</table>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>