<?php
return array(
    'di' => array(
        'instance' => array(
        'Zend\Db\Adapter\Adapter' => array(
                'parameters' => array(
                    'driver' => 'Zend\Db\Adapter\Driver\Pdo\Pdo',
                ),
            ),
            'Zend\Db\Adapter\Driver\Pdo\Pdo' => array(
                'parameters' => array(
                    'connection' => 'Zend\Db\Adapter\Driver\Pdo\Connection',
                ),
            ),
            'Zend\Db\Adapter\Driver\Pdo\Connection' => array(
                'parameters' => array(
                    'connectionInfo' => array(
                        'dsn'            => "mysql:dbname=instrument_dev;host=localhost",
                        'username'       => 'root',
                        'password'       => 'root123',
                        'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''),
                    ),
                ),
            ),
        ),
    ), 
);

