<?php

	session_start();

	require_once __DIR__ . '/../bootstrap/app.php';
	require_once __DIR__ . '/../routes/web.php';

	$app->run();

