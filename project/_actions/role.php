<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;
use Helpers\HTTP;

$table = new UsersTable(new MySQL);

$id = $_GET['id'];
$role_id = $_GET['role_id'];

$table->changeRole($id, $role_id);

HTTP::redirect("/admin.php");
