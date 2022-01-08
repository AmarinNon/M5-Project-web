<?php
$user = System::get_current_user();
$subject_id = System::session('subject_id');
$homeroom_id = Homeroom::homeroom_getbyid($current_subject->homeroom_id)->id;
$homework = Homeroom::homework_getlist(array('subject_id' => $subject_id));

$homework_list_id = array();
for($i = 0; $i < count($homework) ; $i++){
  $homework_list_id[$i] = $homework[$i]->id;
} 

if(isset($_GET['id']) && $_GET['id'] != '' && in_array($_GET['id'], $homework_list_id)){
  $homework_id = $_GET['id'];
} else {
  System::redirect('homework.php?action=view');
}

if(isset($_POST['edit_homework'])){
  $homework_result = Homeroom::homework_edit(array(
    'id' => $homework_id,
    'shortname' => $_POST['shortname'],
    'name' => $_POST['name'],
    'description' => $_POST['description'],
    'homework_type' => $_POST['homework_type'],
    'assign_date' => $_POST['assign_date'],
    'deadline_date' => $_POST['deadline_date'],
    'score' => $_POST['score']
  ));
  
  if(count($homework_result) > 0) {
    System::notification('Edit homework success' ,'success');
    System::redirect();
  } else {
    System::notification('Edit homework unsuccess' ,'danger');
    System::redirect();
  }
}
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-02-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">
            <?php
            echo $current_subject->name;
            echo ' Class ';
            echo Homeroom::homeroom_getbyid($current_subject->homeroom_id)->name;
            ?>
          </span>
        </h1>
      </div>
      <?php
      $homework = Homeroom::homework_getbyid($homework_id);
      $assign_date = date('Y-m-d', strtotime($homework[0]->assign_date));
      $deadline_date = date('Y-m-d', strtotime($homework[0]->deadline_date));
      ?>
      <div class="col-xs-12">
        <div class="pmd-card pmd-z-depth fill-gray">
          <div class="pmd-card-title clearfix">
            <div class="media-left pull-left">
              <h2 class="pmd-card-title-text">Edit homework No. <?php echo $homework[0]->shortname.' : '.$homework[0]->name; ?></h2>
            </div>
          </div>
          <div class="pmd-card-body">
            <div class="row">
              <form action="" method="POST" id="homework_form">
                <div class="form-group col-sm-2">
                  <label for="" class="control-label text-info bigger-110">Work No.</label>
                  <input type="text" name="shortname" id="shortname" class="form-control" required value="<?php echo $homework[0]->shortname; ?>">
                </div>
                <div class="form-group col-sm-5">
                  <label for="" class="control-label text-info bigger-110">Name work</label>
                  <input type="text" name="name" id="name" class="form-control" required value="<?php echo $homework[0]->name; ?>">
                </div>
                <div class="form-group col-xs-12">
                  <label for="" class="control-label">Description</label>
                  <textarea name="description" id="description" class="form-control" rows="10" required><?php echo $homework[0]->description; ?></textarea>
                </div>
                <div class="form-group col-sm-2">
                  <label for="" class="control-label">Assignment type</label>
                  <select name="homework_type" id="homework_type" class="form-control">
                    <option value="1" <?php echo ($homework[0]->homework_type == 1)? 'selected':'' ;?>>Single work</option>
                    <option value="2" <?php echo ($homework[0]->homework_type == 2)? 'selected':'' ;?>>Group work</option>
                  </select>
                </div>
                <div class="form-group col-sm-4">
                  <label for="" class="control-label">Assign Date</label>
                  <input type="date" name="assign_date" id="assign_date" class="form-control" value="<?php echo $assign_date; ?>">
                </div>
                <div class="form-group col-sm-4">
                  <label for="" class="control-label">Deadline</label>
                  <input type="date" name="deadline_date" id="deadline_date" class="form-control" value="<?php echo $deadline_date; ?>">
                </div>
                <div class="form-group col-sm-2">
                  <label for="" class="control-label">Full score</label>
                  <input type="text" name="score" id="score" class="form-control" required value="<?php echo $homework[0]->score; ?>">
                </div>
                <div class="form-group col-xs-12">
                  <div class="clearfix">
                    <div class="mt-4 pull-left">
                      <a href="homework.php?action=view" class="btn btn-default">Previous</a>
                    </div>
                    <div class="mt-4 pull-right">
                      <input type="hidden" name="edit_homework">
                      <button type="submit" class="btn btn-default-fill">Save</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>