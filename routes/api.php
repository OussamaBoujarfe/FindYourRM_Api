<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RequestEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RequestController;
use App\Mail\RequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
Route::get('/get-sent-requests/{id}',[RequestController::class,'getSentRequests']);
Route::get('/get-received-requests/{id}',[RequestController::class,'getReceivedRequests']);
Route::get('/get-pending-requests/{id}',[RequestController::class,'getPendingRequests']);
Route::get('/get-accepted-requests/{id}',[RequestController::class,'getAcceptedRequests']);
Route::get('/get-declined-requests/{id}',[RequestController::class,'getDeclinedRequests']);
Route::post('/new-request',[RequestController::class,'createRequest']);
Route::post('/decline-request/{id}',[RequestController::class,'declineRequest']);
Route::post('/accept-request/{id}',[RequestController::class,'acceptRequest']);
Route::get('/get-all-users',[UserController::class,'getAllUsers']);




//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () 
{
Route::post('/products',[ProductController::class,'store']);
Route::put('/products/{id}',[ProductController::class,'update']);
Route::delete('/products/{id}',[ProductController::class,'destroy']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
});

Route::post('/add-room/{id}',[RoomController::class,'add']);
Route::get('/all-room',[RoomController::class,'all']);
Route::get('/matches/{id}',[UserController::class,'matches']);
Route::get('/create-match',[MatchController::class,'create']);
Route::get('/all-user',[UserController::class,'all']);
Route::get('/room/{id}',[RoomController::class,'room']);
Route::get('/delete-room/{id}',[RoomController::class,'delete']);
Route::post('/search-room', [RoomController::class,'search']);

Route::post('/setup-account/{id}',[UserController::class,'setup']);
Route::get('/owner/{id}',[UserController::class,'owner']);
Route::get('/user/{id}',[UserController::class,'user']);
Route::get('/match/{id}', [UserController::class,'match']);

Route::post('/request-email', [RequestEmailController::class,'send']);

Route::post('/send-invitation', [InvitationController::class,'send']);
Route::post('/accept-invitation', [InvitationController::class,'accept']);
Route::get('/invitation-matches/{id}', [InvitationController::class,'matches']);
Route::get('/incoming-invitation/{id}', [InvitationController::class,'incoming']);
Route::get('/accepted-matches/{id}', [InvitationController::class,'accepted_matches']);


/*
;

*/

Route::middleware('auth:sanctum','verified')->get('/user', function (Request $request) {
    return $request->user();
});
