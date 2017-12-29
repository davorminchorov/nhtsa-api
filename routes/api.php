<?php

$this->get('/vehicles/{modelYear}/{manufacturer}/{model}', 'VehicleController@index');
$this->post('/vehicles', 'VehicleController@index');
