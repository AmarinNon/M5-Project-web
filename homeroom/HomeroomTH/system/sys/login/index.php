<?php
include '../../def/defImport.php';

// set to log out
if(isset($_GET['ca']))
{
    User::logout();
    header('Location: index.php');
    exit();
}

$redirect = false;
if(User::getCurrentUsername() !== null)
{
    $redirect = true;
    if(isset($_COOKIE['amst_userid']) || isset($_COOKIE['amst_userhash']))
        $redirect = User::relogin_server($_COOKIE['amst_userid'],$_COOKIE['amst_username'],$_COOKIE['amst_userRole'],$_COOKIE['amst_userhash']);
}

// initial
$invalidLogin = false;

// form action
if(isset($_POST['login']))
{
    $_POST['debugmessage'] = User::login_server($_POST['username'], $_POST['password']);

    if($_POST['debugmessage']=='success')
        $redirect = true;
    else
        $invalidLogin = true;
}
else if(isset($_POST['refreshdb']))
{
    include ROOT_PHP.'/conf/debug/refreshdb.php';
    DBInit::regenerateSQLTable();
}

if($redirect)
{
    if(User::getCurrentUserRole()=='Guardian')
        header('Location: '.ROOT_URL.'/sys/core');
    else if(User::getCurrentUserRole()=='Dev')
        header('Location: '.ROOT_URL.'/sys/dev');
    else if(User::getCurrentUserRole()=='Mod' || User::getCurrentUserRole()=='Admin')
    {
        $userpermissionlist = User::getUserPermission();
        $funclist = Func::getFunction();

        $gotpermission = false;
        foreach($funclist as $func) 
        {
            foreach($userpermissionlist as $userpermission) 
            {
                if(($userpermission['functionid']==$func['id'] && $userpermission['userid']==User::getcurrentUserID()) || User::getCurrentUserRole()=='Admin')
                {
                    $gotpermission = true;
                    header('Location: '.ROOT_URL.'/'. Info::$moduleFile[$func["module"]].'/index.php?c='.$func['code']);
                }

                if($gotpermission) break;
            }
            if($gotpermission) break;
        }
        if(!$gotpermission)
            header('Location: '.ROOT_URL.'/sys/login/index.php?nopermission=1');
    }

    exit();
}

?>

<?php include_once '../../def/defHeader.php'; ?>
<style type="text/css">
body {
    background-color	: #f5f5f5;
}

h3 {
    color           : dimgray;
}

</style>
<body>
    <div class="container">
        <div class="row">
            <br />
            <br />

            <div class="col-sm-4 col-sm-offset-4 text-center">
                <div class="row">
                    <form name="noconfirm" id="login-form" method="POST" action="">
                        <div class="col-sm-8 col-sm-offset-2 well well-xs">
                            <div class="row">
                                <div class="col-xs-8 col-xs-offset-2">
                                    <img id="logo" src="<?php echo ROOT_URL; ?>/conf/logo.png" width="100%" class="img-responsive" />
                                </div>
                            </div>

                            <h3><?php echo Config::sysCustomer; ?></h3>

                            <hr />

                            <?php if(isset($_GET['nopermission'])) { ?>
                            <div class="alert alert-danger text-center">
                                <h4>Warning!</h4>
                                You are not allow to access this point.
                            </div>
                            <?php } ?>

                            <?php if(isset($_GET['timeout'])) { ?>
                            <div class="alert alert-danger text-center">
                                <h4>Warning!</h4>
                                Connection Timeout
                            </div>
                            <?php } ?>

                            <?php if(isset($_GET['debugmessage'])) { ?>
                            <div class="alert alert-danger text-center">
                                <h4>Warning!</h4>
                                <?php echo $_GET['debugmessage']; ?>
                            </div>
                            <?php } ?>

                            <div class="control-group error">
                                <input class="form-control input-lg"  name="username" type="text" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" placeholder=" username" required autofocus>
                                <input class="form-control input-lg"  name="password" type="password" placeholder=" password" required>
                            </div>

                            <button class="btn btn-lg btn-success bg-success btn-block" name="login" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php 
            if(Config::debugMode)
            {
                ?>
                <div class="col-sm-4 text-center">
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <img src="debug.png" width="100%" class="img-responsive" />
                        </div>
                    </div>

                    <p>
                        <b class="text-primary">Developer ?</b> Change localhost DB info at
                        <br /><br />
                        <span class="label label-primary" style="font-size:15px;"><?php echo '/conf/config-localhost.php' ?></span>
                    </p>

                    <h3>DEBUG</h3>

                    <div class="row">
                        <?php 
                        if(file_exists(ROOT_PHP.'/conf/debug/refreshdb.php'))
                        {
                            ?>
                            <form method="POST" action="">
                                <div class="col-sm-8 col-sm-offset-2 well well-xs">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <a href="../core/dbadminer.php" class="btn btn-lg btn-block btn-default"><i class="glyphicon glyphicon-link"></i></a>
                                        </div>
                                        <div class="col-xs-8">
                                            <button class="btn btn-lg btn-info bg-primary btn-block" name="refreshdb" type="submit">Refresh DB</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script type="text/javascript" src="../../src/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../../src/js/bootstrap.min.js"></script>
    <script>
    $( document ).ready(function() {
        $('#logo').addClass('animated bounceIn');

        $('#logo').on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $('#logo').removeClass('animated bounceIn');
            $('#logo').removeClass('animated tada');

            setTimeout(function () {
                $('#logo').addClass('animated tada');
            }, 1000);
        });
    });
    </script>
</body>
</html>