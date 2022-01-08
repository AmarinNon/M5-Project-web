<?php
if($user->role === 'Student') {
  $student_id = $user->user_id;
  $homeroom_id = $user->log_id1;
} else if ($user->role === 'Parent') {
  $parent_id = $user->user_id;
  $student = Homeroom::parent_student($parent_id);
  $student_id = $student->user_id;
  $homeroom_id = $student->log_id1;
} else {

}

// get subject_list by student_id
$where = array('homeroom_id' => $homeroom_id);
$subject_list = Homeroom::subject_getlist($where);
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-xs-12">
        <h1 class="section-title">
          <div class="media-top icon-title mr-2">
            <img src="images/svg/icon-03-blue.svg" alt="" class="img-responsive">
          </div>
          <span class="media-middle">คะแนนเก็บ</span>
        </h1>
      </div>
    </div>
    <div class="row">
      <?php
      for($i = 0; $i < count($subject_list) ; $i++){ 
        $subject_id = $subject_list[$i]->id;

        $subject = $subject_list[$i];
        $homework_list = Homeroom::homework_getlist(array('subject_id' => $subject_id));
        $total_score = Homeroom::score_getbystudentid($subject_id, $student_id);

        $subject_bg_color = $subject->color;
        $color_code = Homeroom::color_index($subject_bg_color);
        $subject_color = Homeroom::FONT_COLORS[$color_code];

        // calc % late work
        $total_work = 0;
        $total_late = 0;
        foreach ($total_score as $homework_id => $score) {
          if(isset($score)) {
            $total_work++;
            if($score->late_send == 1) {
              $total_late++;
            }
          }
        }
        if($total_work > 0) {
          $late_percent = ($total_late / $total_work) * 100;
          $nolate_percent = 100 - $late_percent;
        } else {
          $late_percent = 0;
          $nolate_percent = 0;
        }

        // calc % checkin
        $checkin_detail = Homeroom::checkin_detail_teacher($homeroom_id, $subject_id);
        $total_checkin = 0;
        $total_checkin_late = 0;
        foreach ($checkin_detail as $checkin_date => $checkin_list) {
          $total_checkin++;
          if(isset($checkin_list[$student_id])) {
            $total_checkin_late++;
          }
        }
        if($total_checkin > 0) {
          $checkin_late_percent = ($total_checkin_late / $total_checkin) * 100;
          $checkin_percent = 100 - $checkin_late_percent;
        } else {
          $checkin_late_percent = 0;
          $checkin_percent = 0;
        }
        ?>
          <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="card-score fadeIn animated">
              <div class="card-header title" style="background-color: <?php echo $subject_bg_color; ?>; color: <?php echo $subject_color; ?>;">
                  <h2 class="title"><?php echo $subject->subject_code.' : '.$subject->name; ?></h2>
              </div>
              <div class="card-body">
                <div class="progress-table">
                  <div class="static-progress">
                    <div class="header clearfix">
                      <p class="pull-left">ส่งงานตรงเวลา</p>
                      <p class="pull-right"><?php echo number_format($nolate_percent);?>%</p>
                    </div>
                    <div class="progress-rounded progress">
                      <div class="progress-bar progress-bar-info" style="width: <?php echo number_format($nolate_percent);?>%;"></div>
                    </div>
                  </div>
                  <div class="static-progress">
                    <div class="header clearfix">
                      <p class="pull-left">ส่งงานล่าช้า</p>
                      <p class="pull-right"><?php echo number_format($late_percent);?>%</p>
                    </div>
                    <div class="progress-rounded progress">
                      <div class="progress-bar progress-bar-danger" style="width: <?php echo number_format($late_percent);?>%;"></div>
                    </div>
                  </div>
                  <div class="static-progress">
                    <div class="header clearfix">
                      <p class="pull-left">เข้าเรียน</p>
                      <p class="pull-right"><?php echo number_format($checkin_percent);?>%</p>
                    </div>
                    <div class="progress-rounded progress">
                      <div class="progress-bar progress-bar-success" style="width: <?php echo number_format($checkin_percent);?>%;"></div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="score-table">
                <?php 
                /*<div class="total clearfix">
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="total-mid">
                        <div class="header">
                          <span>Mid</span>
                        </div>
                        <div class="body">
                          <span>78</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-6">
                      <div class="total-final">
                        <div class="header">
                          <span>Final</span>
                        </div>
                        <div class="body">
                          <span>81</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                */
                ?>
                  <div class="homework clearfix mt-2">
                    <div class="row">
                    <?php
                      $nwork = count($homework_list);
                      $n_col1 = ceil($nwork/2);
                      $n_col2 = floor($nwork/2);
                      if($nwork > 0) {
                      ?>
                      <div class="col-xs-12">
                        <ul class="double-columns">
                        <?php for($j = 0; $j < $n_col1 ; $j++) {
                        // left column
                        $homework_id = $homework_list[$j]->id;
                        $score = '-';
                        if(isset($total_score[$homework_id])) {
                          $score = $total_score[$homework_id]->score;
                        }
                        ?>
                        <li data-toggle="tooltip" title="<?php echo $homework_list[$j]->name; ?>">งานที่ <?php echo $homework_list[$j]->shortname; ?></li>
                        <?php
                          $text_class = 'text-info';
                          $max_score = '';
                          if($score != '-') {
                            $max_score = '/'.number_format($homework_list[$j]->score, 2);
                            if($score < ($homework_list[$j]->score / 2.0)) {
                              $text_class = 'text-danger';
                            }
                          }
                          $late_html = '';
                          if(isset($total_score[$homework_id])) {
                            if($total_score[$homework_id]->late_send == '1') {
                              $late_html = '';
                            }
                          }
                          echo '<li class="text-right '.$text_class.'">'.$late_html.' '.$score.$max_score.'</li>';
                        } ?>
                        </ul>
                      </div>
                      <div class="col-xs-12">
                        <ul class="double-columns">
                        <?php for($j = $n_col1; $j < $n_col1+$n_col2 ; $j++) {
                        // right column
                        $homework_id = $homework_list[$j]->id;
                        $score = '-';
                        if(isset($total_score[$homework_id])) {
                          $score = $total_score[$homework_id]->score;
                        }
                        ?>
                        <li data-toggle="tooltip" title="<?php echo $homework_list[$j]->name; ?>">งานที่ <?php echo $homework_list[$j]->shortname; ?></li>
                        <?php
                          $text_class = 'text-info';
                          $max_score = '';
                          if($score != '-') {
                            $max_score = '/'.number_format($homework_list[$j]->score, 2);
                            if($score < ($homework_list[$j]->score / 2.0)) {
                              $text_class = 'text-danger';
                            }
                          }
                          $late_html = '';
                          if(isset($total_score[$homework_id])) {
                            if($total_score[$homework_id]->late_send == '1') {
                              $late_html = '';
                            }
                          }
                          echo '<li class="text-right '.$text_class.'">'.$late_html.' '.$score.$max_score.'</li>';
                        }
                        ?>
                        </ul>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php
          if($i > 0 && ($i+1)%4 == 0){
            echo '<div class="clearfix visible-lg"></div>';
          } if($i > 0 && ($i+1)%3 == 0) {
            echo '<div class="clearfix visible-md"></div>';
          } if($i > 0 && ($i+1)%2 == 0) {
            echo '<div class="clearfix visible-sm"></div>';
          }
        }
      ?>
    </div>
  </div>
</div>