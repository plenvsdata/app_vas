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
                if($v_apiData->checkFeaturePermission(4)){
                ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lg fa-vcard-o"></i><span class="hide-menu">CRM</span></a>
                    <ul aria-expanded="false" class="collapse">

                        <?php
                        if($_SESSION['accessProfileID'] == 1){//TODO MUDAR CLNT para ABH
                            ?>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Companies">Companies</a></li>
                        <?php }?>
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Customers">Customers</a></li>
                        <?php
                            if($_SESSION['accessProfileID'] == 1){//TODO MUDAR CLNT para ABH
                        ?>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Individuals">Individuals</a></li>
                            <?php }?>
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Contacts" id="addNewContacts">Contacts</a></li>
                    </ul>
                </li>
                <?php
                }

                if($v_apiData->checkFeaturePermission(10)){
                        ?>
                        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                        class="fa fa-lg fa-sliders"></i><span
                                        class="hide-menu">Configurações</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Products">Products</a></li>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Users">Usuários</a></li>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/LovManagement">LoV Management</a></li>
                                <li><a class="has-arrow" href="#" aria-expanded="false">External Data</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a id="featureImportData" href="<?=$GLOBALS['g_appRoot']?>/System/ImportData">Import Data</a></li>
                                        <li><a href="<?=$GLOBALS['g_appRoot']?>/System/ManageImportedData">Manage Imported Data</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/GlobalSettings">Global Settings</a></li>
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

