<?php
if($user->role == 'Teacher') {
  if(isset($_POST['add_homeroom'])) {
    $insert_result = Homeroom::homeroom_add(array(
      'teacher_id' => $user->user_id,
      'name' => $_POST['name']
    ));
    if(count($insert_result) > 0) {
      System::notification('Save Data success', 'success');
    }
    System::redirect();
  }
?>
  <div class="modal fade" id="add-homeroom-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            </div>
          </div>

          <form class="form-horizontal" action="" method="post">
            <div class="form-group">
              <label for="" class="control-label text-info bigger-110">Name Homeroom</label>
              <input name="name" type="text" id="" class="form-control" placeholder="Ex. M.6/1" required>
            </div>
            <div class="form-group text-right">
              <input type="hidden" name="add_homeroom" value="1">
              <button type="submit" class="btn pmd-ripple-effect btn-default-fill">Add Homeroom</button>
              <button type="button" class="btn pmd-ripple-effect btn-link" data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>