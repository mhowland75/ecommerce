<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::group(['middleware'=>'trackUser'], function(){
  Route::get('/', function () {
      return view('welcome');
  });
  Route::get('/restrictedAccess', function () {
      return view('restrictedAccess');
  });
  Route::resource('products', 'productsController', ['only' => ['create','edit','delete','update']]);
  Route::get('/orders/unpick/{order_id}', 'OrdersController@unpickOrder');
  Route::get('/products/images/manage/{id}', 'imageController@manageImages');
  Route::get('/products/images/manage/remove/{id}', 'imageController@removeImage');
  Route::post('/products/images/manage/add', 'imageController@addImage');
  Route::get('/products/lowstock', 'productsController@lowStock');
  Route::get('/products/timesViewed', 'productsController@timesViewed');
    Route::post('/products/addproduct', 'productsController@addProduct');
    Route::get('/products/activateProduct/{id}', 'productsController@activateProduct');
     Route::get('/products/activateProduct/size/{id}', 'productsController@activateProductSize');
     Route::get('/products/size/edit/{id}', 'productsController@editProductSize');
     Route::post('/products/size/update', 'productsController@updateProductSize');
     Route::get('/products/size/{product_id}', 'productsController@manageProductSize');
     Route::post('/products/size/add', 'productsController@addProductSize');

  Route::get('/products/ajaxSize/{id}', 'productsController@ajaxSize');
  Route::get('/logout', 'Auth\LoginController@logout');
  Route::get('/products/search', 'productsController@productSearch');
  Route::get('/users/backendUsersSearch', 'userController@backendUserSearch');
  Route::get('/users/password/edit', 'userController@changePassword');
  Route::post('/users/password/update', 'userController@updatePassword');
  Route::get('/reviews/backendReviewsSearch', 'reviewsController@backendReviewsSearch');
  Route::get('/products/DetailedSearch', 'productsController@productDetailedSearch');
  Route::get('/products/primary/{primary_category}/secondary/{secondary_category}', 'productsController@index');
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('/checkout/address', 'CheckoutController@address');
  Route::post('/checkout/specialInstructions', 'CheckoutController@specialInstructions');
  Route::post('basket/basketUpdate','basketController@basketUpdate');
  Route::get('basket/remove/{product}','basketController@removeBasketItem');
  Route::post('address/delete/{address}','addressController@destroy');
  Route::get('user/edit','userController@edit');
  Route::get('user/update','userController@update');

  Route::resource('basket', 'basketController');
  Route::resource('address', 'addressController');

  Route::resource('users', 'userController');

  Route::resource('reviews', 'reviewsController');
  Route::get('/review/visability/{review}', 'ReviewsController@activateReview');
});


Route::group(['middleware'=>'authenticated'], function(){

    Route::resource('address', 'addressController');
    Route::get('/checkout/delivery', 'CheckoutController@deliveryMethod');
    Route::get('/checkout/payment', 'CheckoutController@payment');
    Route::get('/checkout/placeOrder', 'CheckoutController@placeOrder');
    Route::get('/checkout/orderConfirmation', 'CheckoutController@orderConfirmation');
    Route::get('/checkout/delivery/{method}', 'CheckoutController@deliveryMethodSave');
    Route::get('/checkout/address/{address}', 'CheckoutController@addressSave');

    Route::get('reviews/create/{product}','reviewsController@create');
});
Route::group(['middleware'=>'AdminAccessLevel3'], function(){
  Route::get('/orders/orders', 'OrdersController@orders');
  Route::get('/orders', 'OrdersController@index');
  Route::get('/order/{orderid}', 'OrdersController@view');
  Route::get('/orders/picking/{order_id}', 'OrdersController@picking');

});
Route::group(['middleware'=>'AdminAccessLevel2'], function(){
    Route::get('/myecommerce', 'HomeController@backendAdmin');
    Route::get('/products/view', 'productsController@view');
    Route::resource('products', 'productsController');

});

Route::group(['middleware'=>'AdminAccessLevel1'], function(){
    Route::get('/administrator/onlineUsers', 'AdministratorController@whosOnline');
    Route::get('/administrator/manage', 'AdministratorController@manageAdministration');
    Route::post('/administrator/insert', 'AdministratorController@insertAdministrator');
    Route::post('/administrator/update', 'AdministratorController@updateAdministrator');
    Route::get('/administrator/remove/{id}', 'AdministratorController@removeAdministrator');
    Route::get('/administrator/userActivity/{id}', 'AdministratorController@userActivity');
    Route::get('/products/csv', 'productsController@crateProductCSV');
    Route::get('/products/uploadcsv', 'productsController@uploadProductCSV');
    Route::get('/delivery/addDeliveryMethod', 'deliveryController@addDeliveryMethod');
    Route::get('/delivery/updateDeliveryMethod/{id}', 'deliveryController@updateDeliveryMethod');
    Route::get('/delivery/update', 'deliveryController@update');
    Route::get('/delivery/viewDeliveryMethod', 'deliveryController@viewDeliveryMethods');
    Route::get('/delivery/activateDeliveryMethod/{id}', 'deliveryController@activateDeliveryMethod');


});
