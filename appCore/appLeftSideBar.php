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
                    //FeatureID = 1 - CRM
                    if($v_apiData->checkFeaturePermission(1)){
                ?>
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-lg fa-vcard-o"></i><span class="hide-menu">CRM</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php
                            //FeatureID = 7 - CRM - Clientes
                            if($v_apiData->checkFeaturePermission(7)){
                        ?>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/CRM/Clientes">Clientes</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </li>
                <?php
                }
                //FeatureID = 2 — Configurações
                if($v_apiData->checkFeaturePermission(2)){
                        ?>
                        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                        class="fa fa-lg fa-sliders"></i><span
                                        class="hide-menu">Configurações</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php
                                    //FeatureID = 8 — Configurações — Usuários
                                    if($v_apiData->checkFeaturePermission(8)){
                                ?>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Users">Usuários</a></li>
                                <?php
                                    }

                                    //FeatureID = 9 — Configurações — Instalação Obcon
                                    if($v_apiData->checkFeaturePermission(9)){
                                ?>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Instalacao">Instalações Obcon</a></li>
                                <?php
                                    }

                                    //FeatureID = 10 — Configurações — Câmera Obcon
                                    if($v_apiData->checkFeaturePermission(10)){
                                ?>
                                <li><a href="<?=$GLOBALS['g_appRoot']?>/System/Camera">Câmera Obcon</a></li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
                         <?php
                    }
                //FeatureID = 3 — Relatórios
                if($v_apiData->checkFeaturePermission(3)){
                    ?>
                    <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="fa fa-lg fa-list"></i><span
                                    class="hide-menu">Relatórios</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <?php
                                //FeatureID = 11 — Relatórios — Viper
                                if($v_apiData->checkFeaturePermission(11)){
                            ?>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/Relatorio/Viper">Viper</a></li>
                            <?php
                                }

                            //FeatureID = 12 —  Relatórios — Obcon
                            if($v_apiData->checkFeaturePermission(12)){
                            ?>
                            <li><a href="<?=$GLOBALS['g_appRoot']?>/Relatorio/Obcon">Obcon</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                //FeatureID = 4 — Obcon
                if($v_apiData->checkFeaturePermission(4)){
                ?>

                <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="fa fa-lg fa-calculator"></i><span
                                class="hide-menu">Obcon</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <?php
                        //FeatureID = 13 — Obcon Dashboard
                        if($v_apiData->checkFeaturePermission(13)){
                        ?>
                        <li><a href="<?=$GLOBALS['g_appRoot']?>/Obcon/Dashboard">Dashboard</a></li>
                        <?php
                        }
                        ?>
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

