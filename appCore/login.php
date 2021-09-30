<?php
    session_start();
    require_once ('../appGlobals/appGlobalSettings.php');
    require("../appClasses/appGlobal.php");

    use app\System\Tools\appSystemTools;

    if($_REQUEST['checkIndexAccess']!='WelcomeVAS')
    {
        //ToDo
        //Quando link direto, matar todas as sessões antes de redirect
        $v_newIndex = $GLOBALS['g_appRoot'].'/SignIn';
        header('Location: '.$v_newIndex);
    }


    $_SESSION['sesChk'] = session_id();
    $v_lgnError = false;

    if(isset($_SESSION['adminErrCode']))
    {
        $v_lgnError = true;
    }

    // Remember me
    $v_cookieUsername = '%';
    $v_cookieRememberMe = 'F';
    if(isset($_COOKIE["appRememberMe"]))
    {
        $v_cookieRememberMe = $_COOKIE["appRememberMe"];
        if($v_cookieRememberMe == 'T')
        {
            if(isset($_COOKIE["appUsername"]))
            {
                $v_cookieUsername = $_COOKIE['appUsername'];
            }
        }
    }

    $v_bg = new appSystemTools();
    $v_bg->randomBG();
    $v_bgFile = $v_bg->returnImage;
?>
<!DOCTYPE html>
<html lang="<?=$g_appLanguage?>">
<head>
<?php
    include ('appHead.php');
?>

<style>
    .btn-signup {
        position: absolute;
        right: 0;
        z-index: 9999;
        top: 0!important;
        margin: 5px!important;
    }
</style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(<?=$GLOBALS['g_appRoot']?>/appImages/bgImages/<?=$v_bgFile?>);">
        <div class="login-box card">
                <div class="card-body">
                    <form class="form-horizontal form-material" id="adminForm" action="appAccessAPI/loginCheck" method="post" >
                       <a href="javascript:void(0)" class="text-center db"><img src="<?=$GLOBALS['g_appRoot']?>/appImages/sysImages/plenvsDataSystem_logo.svg" style="width: 50%!important;"/></a>
                        
                        <div class="form-group m-t-40">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="text" required="" placeholder="Email" <? if ($v_cookieUsername != "%") { echo 'value="'.$v_cookieUsername.'"'; }?> > </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Password"> 
                                <input type="hidden" id="dataCheck" name="dataCheck" value=<?=$_SESSION['sesChk']?>>
                            </div>
                        </div>
                        <div class="form-group">
							<div class="col-md-12">
								<div class="checkbox checkbox-primary pull-left p-t-0">
									<input id="rememberMe" name="rememberMe" type="checkbox" value="T" <? if ($v_cookieRememberMe == 'T') { echo 'checked'; } ?> >
									<label for="rememberMe"> Remember me </label>
								</div>
								<a href="<?=$GLOBALS['g_appRoot']?>/RecoverMyPassword" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot Password?</a>
							</div>
                    	</div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-md btn-block text-uppercase waves-effect waves-light" style="margin-bottom:15px!important;" type="submit">Log In</button>
                                <br>
                                <a href="<?=$GLOBALS['g_appRoot']?>/SignUp">Join Us! Sign Up NOW!</a>
                            </div>
                        </div>

                    </form>
					<form class="form-horizontal" id="recoverform" action="#">
						<div class="form-group ">
							<div class="col-xs-12">
								<h3>Recover Password</h3>
								<p class="text-muted">Enter your Email and instructions will be sent to you! </p>
							</div>
						</div>
						<div class="form-group ">
							<div class="col-xs-12">
								<input class="form-control" type="text" required="" placeholder="Email">
							</div>
						</div>
						<div class="form-group text-center m-t-20">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
							</div>
						</div>
					</form>                    
                </div>
            </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->

    <script type="text/javascript">
        $(document).ready(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "7000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            <?
               if($v_lgnError ==  true)
               {
            ?>
                toastr["error"]("Wrong username or password. Please try again.", "Ooops!");
            <?
                $v_lgnError = false;
                unset($_SESSION['adminErrCode']);
               }

                if(isset($_SESSION['toasterMsg']))
                {
                    if($_SESSION['toasterMsg'] == 1){
                ?>
                        toastr["success"]("We will send instructions to your email address!", "Success!");
            <?
                    }elseif ($_SESSION['toasterMsg'] == 2){
            ?>
                        toastr["error"]("Something wrong with your email. Please try again.", "Ooops!");
            <?
                    }
                    unset($_SESSION['toasterMsg']);
                }
            ?>



        });
    </script>
    <? include ("appPlugins.php");?>
</body>
</html>