<?php
$user = System::get_current_user();
$side_menu = array();

if($user->role === 'Admin') {
  $side_menu = array(
    array(
      'text' => 'จัดการรายชื่อครู',
      'icon' => 'images/svg/icon-01.svg',
      'link' => 'manageuser.php',
      'pagename' => array('manageuser')
    )
    );
} else if($user->role === 'Teacher') {
  $mode = System::session('mode');

  if($mode == 'Homeroom') {
    $side_menu = array(
      array(
        'text' => 'จัดการ Homeroom',
        'icon' => 'images/svg/HoT-01.svg',
        'link' => 'teacher_manage.php',
        'pagename' => array('teacher_manage')
      ),
      array(
        'text' => 'ข้อมูลนักเรียน',
        'icon' => 'images/svg/icon-01.svg',
        'link' => 'student.php',
        'pagename' => array('student')
      ),
      array(
        'text' => 'ปฎิทิน',
        'icon' => 'images/svg/icon-05.svg',
        'link' => 'calendar.php',
        'pagename' => array('calendar')
      ),
      array(
        'text' => 'งานของแต่ละวิชา',
        'icon' => 'images/svg/icon-02.svg',
        'link' => 'homework.php',
        'pagename' => array('homework')
      ),
      array(
        'text' => 'คะแนนของทุกวิชา',
        'icon' => 'images/svg/icon-03.svg',
        'link' => 'score.php',
        'pagename' => array('score')
      ),
      array(
        'text' => 'เช็คเข้าชั้นเรียน',
        'icon' => 'images/svg/icon-04.svg',
        'link' => 'attendance.php',
        'pagename' => array('attendance')
      ),
      array(
        'text' => 'ข้อความ',
        'icon' => 'images/svg/icon-06.svg',
        'link' => 'message.php',
        'pagename' => array('message')
      ),
      array(
        'text' => 'ประกาศ',
        'icon' => 'images/svg/icon-07.svg',
        'link' => 'announcement.php',
        'pagename' => array('announcement')
      )
    );
  } else {
    $side_menu = array(
      array(
        'text' => 'จัดการรายวิชา',
        'icon' => 'images/svg/HoT-02.svg',
        'link' => 'teacher_manage.php',
        'pagename' => array('teacher_manage')
      ),
      array(
        'text' => 'ข้อมูลนักเรียน',
        'icon' => 'images/svg/icon-01.svg',
        'link' => 'student.php',
        'pagename' => array('student')
      ),
      array(
        'text' => 'ปฎิทิน',
        'icon' => 'images/svg/icon-05.svg',
        'link' => 'calendar.php',
        'pagename' => array('calendar')
      ),
      array(
        'text' => 'มอบหมายงาน',
        'icon' => 'images/svg/icon-09.svg',
        'link' => 'homework.php',
        'pagename' => array('homework')
      ),
      array(
        'text' => 'กรอกคะแนน',
        'icon' => 'images/svg/icon-03.svg',
        'link' => 'score.php',
        'pagename' => array('score')
      ),
      array(
        'text' => 'เช็คเข้าชั้นเรียน',
        'icon' => 'images/svg/icon-04.svg',
        'link' => 'attendance.php',
        'pagename' => array('attendance')
      ),
      array(
        'text' => 'ข้อความ',
        'icon' => 'images/svg/icon-06.svg',
        'link' => 'message.php',
        'pagename' => array('message')
      ),
      array(
        'text' => 'ประกาศ',
        'icon' => 'images/svg/icon-07.svg',
        'link' => 'announcement.php',
        'pagename' => array('announcement')
      )
    );
  }
} else if($user->role === 'Parent' || $user->role === 'Student') {
  $side_menu = array(
    array(
      'text' => 'ปฎิทิน',
      'icon' => 'images/svg/icon-05.svg',
      'link' => 'calendar.php',
      'pagename' => array('calendar')
    ),
    array(
      'text' => 'งานที่ได้รับมอบหมาย',
      'icon' => 'images/svg/icon-09.svg',
      'link' => 'homework.php',
      'pagename' => array('homework')
    ),
    array(
      'text' => 'คะแนนเก็บ',
      'icon' => 'images/svg/icon-03.svg',
      'link' => 'total-score.php',
      'pagename' => array('total-score')
    ),
    array(
      'text' => 'ข้อความ',
      'icon' => 'images/svg/icon-06.svg',
      'link' => 'message.php',
      'pagename' => array('message')
    ),
    array(
        'text' => 'ประกาศ',
        'icon' => 'images/svg/icon-07.svg',
        'link' => 'announcement.php',
        'pagename' => array('announcement')
      )
  );
}
?>
<!-- Sidebar Starts -->
<div class="pmd-sidebar-overlay"></div>

<!-- Left sidebar -->
<aside class="pmd-sidebar sidebar-default pmd-sidebar-slide-push pmd-sidebar-left sidebar-with-icons pmd-z-depth-3 pmd-sidebar-open"
  role="navigation" id="sidebar">
  <ul class="nav pmd-sidebar-nav">

    <li class="">
      <div style="width: 80%; margin: auto;">
        <?php include 'images/svg/logo.svg';?>
      </div>
    </li>

    <li class="swap-mode">
      <?php if($user->role === 'Teacher') { ?>
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 text-center">
          <a href="swap_module.php?mode=Homeroom&url=<?php echo urlencode(CURRENT_URL);?>" class="no-padding" data-toggle="tooltip" data-placement="auto" title="สลับไปยัง Homeroom">
            <img src="images/svg/HoT-01.svg" class="pulse-hover" style="width: 35%; min-width: 28px;">
          </a>
          <img src="images/svg/HoT-arrow.svg" style="width: 20%;" class="hide-on-collapse">
          <a href="swap_module.php?mode=Teacher&url=<?php echo urlencode(CURRENT_URL);?>" class="no-padding" data-toggle="tooltip" data-placement="auto" title="สลับไปยังรายวิชา">
            <img src="images/svg/HoT-02.svg" class="pulse-hover" style="width: 35%; min-width: 28px;">
          </a>
        </div>
      </div>
      <?php } ?>
    </li>
        
    <li class="user-status text-center"><span class="bold bigger-120 text-white hide-on-collapse">Status: <?php echo ($user->role === 'Teacher')? System::session('mode') : $user->role;?><span></li>

    <?php for($i = 0 ; $i < count($side_menu) ; $i++) { ?>
    <li>
      <a class="pmd-ripple-effect <?php echo in_array(PAGE_NAME, $side_menu[$i]['pagename'])? 'active':'';?>" href="<?php echo $side_menu[$i]['link'];?>">
        <i class="media-left media-middle">
          <img src="<?php echo $side_menu[$i]['icon'];?>"class="img-responsive">
        </i>
        <span class="media-body"><?php echo $side_menu[$i]['text'];?></span>
      </a>
    </li>
    <?php } ?>

    <li>
      <a class="pmd-ripple-effect btn-logout" href="#">
        <i class="media-left media-middle">
          <img src="images/svg/icon-08.svg"class="img-responsive">
        </i>
        <span class="media-body">ออกจากระบบ</span>
      </a>
    </li>
  </ul>
</aside>
<!-- End Left sidebar -->
<!-- Sidebar Ends -->

<div class="z-template" id="side-item-template">
  <a class="pmd-ripple-effect {{custom_class}}" href="{{link}}" {{custom_attr}}>
    <i class="media-left media-middle">
      <img src="{{icon}}"class="img-responsive">
      <?php //include $side_menu[$i]['icon'];?>
    </i>
    <span class="media-body">{{text}}</span>
  </a>
</div>

<script>
  $(document).ready(function () {
    var $sidebar = $('.pmd-sidebar');
    var $navbar = $('.pmd-navbar');
    var $topnav = $('.copy-to-side');

    var pushTopNav = function () {
      var sidebar_width = $sidebar[0].getClientRects()[0].width;
      if(window.innerWidth < 768) {
        sidebar_width = 0;
      }
      $navbar.css('margin-left', sidebar_width + 'px');
      setTimeout(function () {
        pushTopNav();
      });
    };

    setTimeout(function () {
      pushTopNav();
    });

    var html = '';
    $topnav.children('li').each(function(idx, el) {    
      if($(el).hasClass('dropdown')) {
        html += '<li class="visible-xs text-center">';
        html += $(el).html();
        html += '</li>';
      } else {
        html += '<li class="visible-xs">';
        var link = $(el).children('a').attr('href');
        var icon = $(el).children('a').find('img').attr('src');
        var text = $(el).children('a').find('span').html();
        if($(el).children('a').hasClass('toggle-modal')) {
          html += System.compileTemplate('side-item-template', {
            'custom_class': 'toggle-modal',
            'link': link,
            'icon': icon,
            'text': text,
            'custom_attr': 'data-target="' + $(el).children('a').data('target') + '"'
          });
        } else {
          html += System.compileTemplate('side-item-template', {
            'custom_class': '',
            'link': link,
            'icon': icon,
            'text': text,
            'custom_attr': ''
          });
        }
        html += '</li>';
      }
    });
    $sidebar.find('.user-status').after(html);

    $(document).on('click', '.btn-logout', function(e) {
      e.preventDefault();
      System.confirm('', 'คุณต้องการออกจากระบบ?', function() {
        window.location = 'logout.php';
      }, function() {});
    });

    var window_width = window.innerWidth;
    if(window_width > 1200) {
      $sidebar.addClass('pmd-sidebar-open');
    }
  });
</script>