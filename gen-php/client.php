<?php

class ThriftAutoloader
{
    private static $_rootDir='';

    public static function setRoot($root)
    {
        self::$_rootDir = $root;
    }

    public static function load($className)
    {
        $fileName = self::$_rootDir . str_replace('\\','/',$className) .'.php';
        if(file_exists($fileName)) {
            include $fileName;
        }
    }
}

spl_autoload_register("ThriftAutoloader::load");

$thriftDir = '/home/toshifumi/Download/thrift-0.9.0/lib/php/lib/';
ThriftAutoloader::setRoot($thriftDir);


require_once __DIR__ .'/Types.php';
require_once __DIR__ .'/TinyCalc.php';

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;  
use Thrift\Transport\TSocketPool;  
use Thrift\Transport\TFramedTransport;  
use Thrift\Transport\TBufferedTransport;

$host = 'localhost';
$port = '7911';
$socket = new Thrift\Transport\TSocket($host, $port);
$transport = new TBufferedTransport($socket);
$protocol = new TBinaryProtocol($transport);
$client = new TinyCalcClient($protocol);
$transport->open();
echo "sum: " . $client->sum(2,2)."\n";
