<?php

	use App\Controllers\UserController;


	// Renders main page
	$app->get('/', UserController::class.':renderMain')->setName('main');

	// Registration
	$app->get('/registration', UserController::class.':renderRegistration')->setName('registration');
	$app->post('/registration/validate', UserController::class.':validateRegistrationData');
	$app->get('/registration/confirm/{token:[a-z0-9]{32}}', UserController::class.':validateRegistrationToken');

	// Login
	$app->get('/login', UserController::class.':renderLogin')->setName('login');
	$app->post('/login/validate', UserController::class.':validateLoginData');

	// Password recover
	$app->get('/recover', UserController::class.':renderRecover')->setName('recover');
	$app->post('/recover/validate', UserController::class.':validateRecoverData');















	$app->get('/users', function ($request, $response) {
		$list = $this->db->query("SELECT login FROM users")->fetchAll(PDO::FETCH_ASSOC);

		//	    var_dump(['list' => $list]); exit;
		return $this->view->render($response, 'users.twig', [
			'list' => $list
		]);
	})->setName('users');