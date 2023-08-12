<?php


use Illuminate\Support\Facades\Route;

use Intervention\Image\Facades\Image;

use App\Http\Controllers\JanuaryMatrixController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
 
    
});



Route::get('/test', function () {
    // Construct the full image path within the public directory
    $imagePath = public_path('images/foo.jpg');

    // Check if the image file exists
    if (file_exists($imagePath)) {
        // Use Intervention/Image to manipulate the image
        $img = Image::make($imagePath);
        
        // Return the manipulated image as a response with a 'jpg' content type
        return $img->response('jpg');
    } else {
        // If the image doesn't exist, return a 404 response
        abort(404); // Image not found
    }
});





// Route::get('/generate-matrix', [JanuaryMatrixController::class, 'generateMatrix'])->name('generate.matrix');



// Display the form to generate the calendar
Route::view('cal', 'january_matrix');

// Process the form submission and generate the calendar image
Route::post('/insert_calendar', [JanuaryMatrixController::class, 'generateCalendarImage']);

// Display the generated calendar image
Route::view('gen', 'generatedimage');