<?php

namespace app\System\Report;

use app\dbClass\appDBClass;

class appReport
{
    private $dbCon;

    public function __construct()
    {
        $this->dbCon = new appDBClass();
    }


}