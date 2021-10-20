<?php

define('PROJECT_ROOT', dirname($_SERVER["DOCUMENT_ROOT"]));
define('VIEWS_ROOT', sprintf("%s/resources/views", PROJECT_ROOT));

define('MAX_MEMBERSHIP', 6);

// set project's root as include path
set_include_path(PROJECT_ROOT);