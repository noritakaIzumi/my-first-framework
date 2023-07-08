<?php
/**
 * Created by PhpStorm.
 * User: norit
 * Date: 2022/09/11
 * Time: 19:35
 */

namespace Internal\Component\Database;

use Internal\Component\BaseComponent;

class Connection extends BaseComponent
{
    public ?Dbh $dbh;

    public function __construct(ConnectionInfo $connectionInfo)
    {
        parent::__construct();
        $this->dbh = new Dbh([
            'type' => $connectionInfo->getType(),
            'host' => $connectionInfo->getHost(),
            'database' => $connectionInfo->getDatabase(),
            'username' => $connectionInfo->getUsername(),
            'password' => $connectionInfo->getPassword(),
        ]);
    }
}
