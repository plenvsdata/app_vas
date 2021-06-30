<?php
/**
 * Created by PhpStorm.
 * User: Mauricio
 * Date: 22/09/17
 * Time: 23:47
 */

namespace app\homeData;
use app\dbClass\appDBClass;

class appHomePage
{
    private $dbCon;
    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }

    public function activeBlocks()
    {
        return $this->dbCon->dbSelect("SELECT block_id, block_order, block_title, block_file, block_status FROM %appDBprefix%_home_block WHERE block_status = true ORDER BY block_order ASC");
    }

    public function activeSlides()
    {
        return $this->dbCon->dbSelect("SELECT slide_id, clnt, slide_order, slide_file, slide_title, slide_text, slide_link_01_title, slide_link_01_url, slide_link_02_title, slide_link_02_url, slide_status FROM %appDBprefix%_home_slider WHERE slide_status = true ORDER BY slide_order ASC, slide_order ASC");
    }
}