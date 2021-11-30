<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//public routes
//Route::resource('products', ProductController::class);
Route::get('/products/search/{name}',[ProductController::class,'search']);
Route::get('/products',[ProductController::class,'index']);
Route::get('/products/{id}',[ProductController::class,'show']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forgot-password',[NewPasswordController::class,'forgotPassword']);
Route::post('/reset-password',[NewPasswordController::class,'reset']);
Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);



//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () 
{
Route::post('/products',[ProductController::class,'store']);
Route::put('/products/{id}',[ProductController::class,'update']);
Route::delete('/products/{id}',[ProductController::class,'destroy']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});

Route::post('/setup-account/{id}',[UserController::class,'setup']);
Route::post('/add-room/{id}',[RoomController::class,'add']);
Route::get('/all-room',[RoomController::class,'all']);
Route::get('/room/{id}',[RoomController::class,'room']);
Route::get('/delete-room/{id}',[RoomController::class,'delete']);
Route::get('/owner/{id}',[UserController::class,'owner']);
/*
;

*/

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});
