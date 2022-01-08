<?php
$filter = 'all'; 
if(isset($_GET['filter'])) {
  $filter = $_GET['filter'];
}
$homeroom_id = System::session('homeroom_id');
$homeroom = Homeroom::homeroom_getbyid($homeroom_id);

if($homeroom) {
  $where = array('homeroom_id' => $homeroom_id);
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
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-02-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homeroom Class <?php echo $homeroom->name;?></span>
        </h1>
      </div>

      <div class="col-xs-12">
        <a href="homework.php?filter=all" class="btn btn-default pmd-ripple-effect <?php echo ($filter == 'all')? 'active':'' ;?>">All</a>
        <!-- <div class="btn-group"> -->
          <a href="homework.php?filter=today" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'today')? 'active':'' ;?>">Send today</a>
          <a href="homework.php?filter=tomorrow" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'tomorrow')? 'active':'' ;?>">Send tomorrow</a>
          <a href="homework.php?filter=late" class="btn pmd-ripple-effect btn-default <?php echo ($filter == 'late')? 'active':'' ;?>">Over submit date</a>
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
<?php
  } else {
    include 'view/nodata/homeroom.php';
  }
?>