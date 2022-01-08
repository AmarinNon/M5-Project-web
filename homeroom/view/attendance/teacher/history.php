<div class="pmd-card mt-2">
  <?php
  $subject_id = System::session('subject_id');
  $subject = Homeroom::subject_getbyid($subject_id);
  $student = Homeroom::student_getbyhomeroomid($subject->homeroom_id);
  $checkin = Homeroom::checkin_getlist(array(
    'homeroom_id' => $subject->homeroom_id,
    'subject_id' => $subject_id
  ));
  $checkin_detail = Homeroom::checkin_detail_teacher($subject->homeroom_id, $subject_id);
  ?>
  <table class="table pmd-table table-striped table-bordered pmd-data-table" data-paging="false" data-searching="false" data-info="false">
    <thead>
      <tr>
        <th>Number</th>
        <th>Password</th>
        <th>Name - Surname</th>
        <?php
        for($i = 0 ; $i < count($checkin) ; $i++) {
          echo '<th class="no-sort" data-toggle="tooltip" data-placemet="auto" title="'.System::convertDateTHShort($checkin[$i]->insertdatetime).'">';
          echo 'No. '.($i + 1);
          echo '</th>';
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      for($i = 0 ; $i < count($student) ; $i++) {
        $student_id = $student[$i]->user_id;
      ?>
      <tr>
        <td><?php echo $student[$i]->group;?></td>
        <td><?php echo $student[$i]->username;?></td>
        <td class="text-left text-nowarp">
        <?php
        echo $student[$i]->title.' ';
        echo $student[$i]->name.' ';
        echo $student[$i]->surname;
        ?>
        </td>
        <?php
        for($j = 0 ; $j < count($checkin) ; $j++) {
          $date = date('Y-m-d', strtotime($checkin[$j]->insertdatetime));
          $checked = true;
          if(isset($checkin_detail[$date][$student_id])) {
            $checked = false;
          }
          echo '<td>';
          if($checked) {
            echo '<span class="text-success">Attend class</span>';
          } else {
            echo '<span class="text-danger">Absent</span>';
          }
          echo '</td>';
        }
        ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>