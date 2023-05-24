<?php
session_start();
session_destroy();

header("Location: /company.com");
exit();