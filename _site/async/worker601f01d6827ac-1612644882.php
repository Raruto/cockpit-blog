<?php

// include cockpit
include('D:/htdocs/cockpit-blog/admin/bootstrap.php');
const ASYNC_PARAMS = NULL;

?><?php cockpit()->helper('jobs')->stopRunner();cockpit()->helper('jobs')->run();

// delete script after execution
unlink(__FILE__);
