<?php
$filter = 'all'; 
$filter_subject_id = '';
if(isset($_GET['subject_id'])) {
  $filter_subject_id = $_GET['subject_id'];
}
if(isset($_GET['filter']) && $_GET['filter'] != '') {
  $filter = $_GET['filter'];
}

if($user->role == 'Student') {
  $homeroom_id = $user->log_id1;
} else {
  $student = Homeroom::parent_student($user->user_id);
  $homeroom_id = $student->log_id1;
}
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);

$where = array('homeroom_id' => $homeroom_id);
if(isset($filter_subject_id) && $filter_subject_id != '') {
  $where['subject_id'] = $filter_subject_id;
}
if($filter == 'today') {
  $where['deadline_date'] = date('Y-m-d');
} else if($filter == 'tomorrow') {
  $today = strtotime(date('Y-m-d'));
  $tomorrow = $today + 86400;
  $where['deadline_date'] = date('Y-m-d', $tomorrow);
} else if($filter == 'late') {
  $where['deadline_date{{<}}'] = date('Y-m-d');
}
$homework = Homeroom::homework_getlist(
  $where,
  array('deadline_date' => 'DESC')
);

$homework_subject = Homeroom::subject_getlist(array('homeroom_id' => $homeroom_id));
$curr_subject_name = 'All';
if(isset($filter_subject_id) && $filter_subject_id != '') {
  $filter_subject = Homeroom::subject_getbyid($filter_subject_id);
  $curr_subject_name = $filter_subject->subject_code.' : '.$filter_subject->name;
}
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <!-- if have announcement -->
      <?php
        $prakard_limit = 2;
        include_once 'view/announcement/student.php';
      ?>

      <div class="col-xs-12">
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-09-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Work assignment</span>
        </h1>
      </div>

      <div class="col-xs-12">
        <span class="dropdown pmd-dropdown ">
          <a href="#" class="btn btn-default pmd-ripple-effect active dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          <?php echo $curr_subject_name; ?>
          </a>
          <ul role="menu" class="dropdown-menu scrollable-menu">
            <li role="presentation">
              <a href="<?php echo System::assignURL(CURRENT_URL, array('subject_id' => ''));?>" tabindex="-1" role="menuitem">All</a>
            </li>
            <?php
            for($i = 0 ; $i < count($homework_subject) ; $i++) {
              echo '<li role="presentation">
                <a href="'.System::assignURL(CURRENT_URL, array('subject_id' => $homework_subject[$i]->id)).'" tabindex="-1" role="menuitem">'.$homework_subject[$i]->subject_code.' : '.$homework_subject[$i]->name.'</a>
              </li>';
            }
            ?>
          </ul>
        </span>

        <!-- <div class="btn-group"> -->
          <a href="<?php echo System::assignURL(CURRENT_URL, array('subject_id' => $filter_subject_id, 'filter' => 'today'));?>" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'today')? 'active':'' ;?>">Send today</a>
          <a href="<?php echo System::assignURL(CURRENT_URL, array('subject_id' => $filter_subject_id, 'filter' => 'tomorrow'));?>" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'tomorrow')? 'active':'' ;?>">Send tomorrow</a>
          <a href="<?php echo System::assignURL(CURRENT_URL, array('subject_id' => $filter_subject_id, 'filter' => 'late'));?>" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'late')? 'active':'' ;?>">Over deadline</a>
        <!-- </div> -->
        <div class="mt-3 pmd-card">
          <div class="table-responsive">
            <table class="table pmd-table pmd-data-table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Submit Date</th>
                  <th>Assign Date</th>
                  <th>Subjects</th>
                  <th>No.</th>
                  <th>Description</th>
                  <th class="no-sort thin-cell"></th>
                </tr>
              </thead>
              <tbody>
              <?php
              for($i = 0; $i < count($homework) ; $i++){
                $deadline_date = date('d/m/', strtotime($homework[$i]->deadline_date));
                $deadline_date .= date('Y', strtotime($homework[$i]->deadline_date));
                $deadline_date .= ' ('.System::dayofweek_thai($homework[$i]->deadline_date).')';

                $assign_date = date('d/m/', strtotime($homework[$i]->assign_date));
                $assign_date .= date('Y', strtotime($homework[$i]->assign_date));
                $assign_date .= ' ('.System::dayofweek_thai($homework[$i]->assign_date).')';

              ?>
                <tr class="fadeIn animated">
                  <td><?php echo $deadline_date;?></td>
                  <td><?php echo $assign_date;?></td>
                  <td class="text-left">
                    <?php
                    $subject = Homeroom::subject_getbyid($homework[$i]->subject_id);
                    $subject_teacher = Homeroom::user_getbyid($homework[$i]->teacher_id);
                    echo $subject->name;
                    echo ' (';
                    echo $subject_teacher->name.' '.$subject_teacher->surname;
                    echo ')';
                    ?>
                  </td>
                  <td><?php echo $homework[$i]->shortname; ?></td>
                  <td class="text-left"><?php echo $homework[$i]->name; ?></td>
                  <td class="thin-cell">
                    <a href="homework.php?action=view&id=<?php echo $homework[$i]->id; ?>" class="smaller-80" data-toggle="tooltip" title="See this work"><span class="fa fa-search"></span></a>
                  </td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>