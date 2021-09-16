<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 16/11/2017
 * Time: 23:38
 */

use app\userAccess\appUserControl;
$v_apiData = new appUserControl();
?>
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <?php if($_SESSION['firstAccess']==0){?>
        <nav class="sidebar-nav NavleftSideBarTop">
            <ul id="sidebarnav">
                <?php
                if($v_apiData->checkFeaturePermission(3)){
                ?>
                <!-- TODO: implement this feature
                <li class="nav-devider leftSideBarTopDivider"></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lg fa-bolt" style="text-align:center!important;"></i><span class="hide-menu">Quick Access</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="javascript:void(0)" id="opportunityWizardLink" class="opportunityWizardLink">Opportunity Wizard</a>
                        </li>
                    </ul>
                </li>
                -->
                <?php }
                if($v_apiData->checkFeaturePermission(1)){
                ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lg fa-vcard-o"></i><span class="hide-menu">CRM</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Clientes">Clientes</a></li>
                    </ul>
                </li>
                <?php
                }

                if($v_apiData->checkFeaturePermission(2)){
                        ?>
                        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                        class="fa fa-lg fa-sliders"></i><span
                                        class="hide-menu">Configurações</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Users">Usuários</a></li>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Instalacao">Instalação Obcon</a></li>
                            </ul>
                        </li>
                         <?php
                    }

                if($v_apiData->checkFeaturePermission(3)){
                    ?>
                    <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="fa fa-lg fa-list"></i><span
                                    class="hide-menu">Relatórios</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/Relatorio/Viper">Viper</a></li>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/Relatorio/Obcon">Obcon</a></li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>
        <?php }?>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

