<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
        $api->resource('config','App\\Api\\V1\\Controllers\\ConfigController');
        
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        //admin routes
        $api->group(['prefix'=>'admin','middleware'=>'admin'],function (Router $api){
          $api->resource('customers','App\\Api\\V1\\Controllers\\AdminUserController');
          $api->resource('verification','App\\Api\\V1\\Controllers\\CompanyUserVerificationController');
        });

        //admin routes
        $api->group(['prefix'=>'partners','middleware'=>'partners'],function (Router $api){
            $api->resource('cards','App\\Api\\V1\\Controllers\\PartnersCardController');
            $api->resource('card_request_approval','App\\Api\\V1\\Controllers\\CardRequestApprovalController');
        });

        $api->resource('region_city','App\\Api\\V1\\Controllers\\RegionCityController');
        $api->resource('company','App\\Api\\V1\\Controllers\\CompanyController');
        $api->resource('address','App\\Api\\V1\\Controllers\\AddressController');
        $api->resource('card_request','App\\Api\\V1\\Controllers\\CardRequestController');
        $api->resource('card_price','App\\Api\\V1\\Controllers\\CardPriceController');
        $api->resource('card_type','App\\Api\\V1\\Controllers\\CardTypeController');
        $api->resource('connect','App\\Api\\V1\\Controllers\\ConnectionController');
        $api->resource('finances','App\\Api\\V1\\Controllers\\FinanceController');
        $api->resource('near_by','App\\Api\\V1\\Controllers\\NearByPartnerAndAgentController');
        $api->resource('bank_account','App\\Api\\V1\\Controllers\\BankAccountController');
        $api->resource('banks','App\\Api\\V1\\Controllers\\BankController');
    });

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });

    $api->resource('region_city','App\\Api\\V1\\Controllers\\RegionCityController');

});
