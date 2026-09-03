<?php
require __DIR__.'/config.php';
session_destroy();
redirect('index.php');
