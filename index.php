<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/V/autoload.php";

use V\Gold505\RowWorker;
use V\Gold505\Table;


$RowWorker = new RowWorker();
$output = $RowWorker->getOutput("data.csv", ";");

$Table = new Table();
$Table->setColumns($RowWorker->getData()["names"], ["id"]);
$Table->setRows($output);
$Table->display();