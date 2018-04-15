<?php
$app->post('auth/login', ['uses' => 'AuthController@authenticate']);