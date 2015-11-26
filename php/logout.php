<?php
	unset($_SESSION['temporaryLogin']);
	header("Location: ../login.html");
    exit();