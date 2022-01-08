<?php
if($user->role === "Teacher") {
  if(System::session('mode') == 'Homeroom') {
    $homeroom_id = System::session('homeroom_id');
    $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
  } else {
    if($current_subject) {
      $homeroom_id = $current_subject->homeroom_id;
      $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
    } else {
      $homeroom = false;
    }
  }
} else if ($user->role === 'Student') {
  $homeroom_id = $user->log_id1;
  $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
} else if ($user->role === 'Parent') {
  $parent_id = $user->user_id;
  $student = Homeroom::parent_student($parent_id);
  $homeroom_id = $student->log_id1;

  $homeroom = Homeroom::homeroom_getbyid($homeroom_id);
}
if($homeroom) {
?>
<div id="content" class="pmd-content inner-page">
  <div class="container-fluid full-width-container">
    <div class="row">
      <div class="col-sm-6">
        <h1 class="section-title">
            <div class="media-top icon-title mr-2">
              <img src="images/svg/icon-05-blue.svg" alt="" class="img-responsive">
            </div>
          <span class="media-middle">Homework Schedule Class <?php echo $homeroom->name;?></span>
        </h1>
        <div class="section-content">
          <div id="calendar"></div>
        </div>
      </div>
      <div class="col-sm-6" style="max-height: 83vh; overflow: auto;">
        <div id="calendar_homework" class="mt-2">
          <div class="text-center pt-5">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> 
            Loading...
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="z-template" id="event_loader">
  <div class="text-center pt-5">
    <i class="fa fa-spinner fa-pulse fa-fw"></i> 
    Loading...
  </div>
</div>
<?php
$source_url = 'async/homework_calendar.php';

$source_url .= '?mode=homeroom&homeroom_id='.$homeroom_id;
?>
<input type="hidden" id="source_url" value="<?php echo $source_url;?>">
<input type="hidden" id="homeroom_id" value="<?php echo $homeroom_id;?>">

<script type="text/javascript">
  $(document).ready(function () {
    var $calendar = $('#calendar');
    var calendar = null;

    var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$calendar.on('click', 'a', function (e){
      // e.preventDefault();
    });

		calendar = $calendar.fullCalendar({
      height: 500,
			locale: 'en',
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month'
			},
			editable: false,
			events: {
        url: $('#source_url').val(),
				type: 'post'
			},
			eventRender: function(event, element) {
				
			},
      eventClick: function(event, jsEvent, view) {
        showEventByDate(date);
      },
      dayClick: function(date, jsEvent, view) {
        showEventByDate(date);
      },
      viewDestroy: function(e) {
        $('#calendar_homework').html(System.compileTemplate('event_loader'));
      },
      viewRender: function(e) {
        // เปลี่ยน ค.ศ. ==> พ.ศ.
        var $title = $calendar.find('.fc-header-toolbar .fc-center h2');
        var title = $title.html();
        title = title.split(' ');
        title = title[0] + ' ' + (parseFloat(title[1]));
        $title.html(title);
        
        var start_date = e.start.format('YYYY-MM-DD');
        var end_date = e.end.format('YYYY-MM-DD');

        $.ajax({
          type: 'POST',
          url: 'async/homework_calendar_list.php',
          data: {
            'homeroom_id': $('#homeroom_id').val(),
            'start': start_date,
            'end': end_date
          },
          dataType: 'html',
          success: function (response) {
            $('#calendar_homework').html(response);
          }
        });
      }
		});

    var showEventByDate = function(date) {
      calendar.fullCalendar('clientEvents', function(event) {
        // match the event date with clicked date if true render clicked date events
        if (moment(date).format('YYYY-MM-DD') == moment(event._start).format('YYYY-MM-DD')) {
          //console.log(event);
        }
      });
    }
  });
</script>
<?php
} else {
  if($user->role === "Teacher") {
    if(System::session('mode') == 'Homeroom') {
      include 'view/nodata/homeroom.php';
    } else {
      include 'view/nodata/subject.php';
    }
  } else {

  }
}
?>