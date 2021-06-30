<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 14/12/2017
 * Time: 14:00
 */

if(isset($_SESSION['userAvatar']) && $_SESSION['userAvatar'] != 'default_avatar.png') {
    $v_avatarInfo = $GLOBALS['g_appRoot'].'/__appFiles/'.$_SESSION['userClnt'].'/_userAvatar/'.$_SESSION['userAvatar'];
}
else {
    $v_avatarInfo = $GLOBALS['g_appRoot'].'/appImages/defaultImages/default_avatar.png';
}
?>
<style>
    #profilePic{
        background-image: url("<?=$v_avatarInfo?>");
        width: 40px;
        height: 40px;
        background-size: cover;
        background-position: center;
    }
    #profilePic2{
        background-image: url("<?=$v_avatarInfo?>");
        width: 60px;
        height: 60px;
        background-size: cover;
        background-position: center;
    }
    .profile-pic{
        height: 30px;
    }
    .dropdown-menu{
        margin-top: 20px;

    }


</style>

<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<nav class="navbar top-navbar navbar-expand-md navbar-light" style="padding: 0!important; height: 55px!important;">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <a href="<?=$GLOBALS['g_appRoot']?>/Welcome">
        <div class="navbar-header plenvs-brand-header plenvs-logo-full"></div>
    </a>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto mt-md-0">
            <!-- This is  -->
            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-light" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
            <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        </ul>
        <!-- ============================================================== -->
        <!-- User profile and search -->
        <!-- ============================================================== -->
        <ul class="navbar-nav my-lg-0">
            <!-- ============================================================== -->
            <!-- Search -->
            <!-- ============================================================== -->
            <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                <form class="app-search">
                    <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
            </li>
            <!-- ============================================================== -->
            <!-- Language -->
            <!-- ============================================================== -->

            <!--
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
            </li>
            -->
            <!-- ============================================================== -->
            <!-- Profile -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div id="profilePic" class="profile-pic"></div></a>
                <div class="dropdown-menu dropdown-menu-right scale-up">
                    <ul class="dropdown-user">
                        <li>
                            <div class="dw-user-box">
                                <div id="profilePic2" class="profile-pic u-img"></div>
                                <div class="u-text">
                                    <h4><?=$_SESSION['userName']?></h4>
                                    <p class="text-muted"><?=$_SESSION['userLogin']?></p>
                                    <a href="<?=$GLOBALS['g_appRoot']?>/MyProfile" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>

                            </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/MyProfile"><i class="ti-user"></i> My Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <!--

                        <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                        <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                        <li role="separator" class="divider"></li>
                        -->
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/appAccessAPI/appQuit"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
