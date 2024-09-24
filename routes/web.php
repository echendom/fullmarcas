<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\TransbankController;

/**
 * Application routes.
 */
// Route::get('/centro-de-ayuda', function () {
//     return view('pages.help-center');
// });
Route::match(['get', 'post'], '/pay_confirmation', [TransbankController::class, 'confirmation'])
    ->name('tbk.webpay.confirmation');
Route::get('/registro-gracias', function () {
    return view('pages.trademark-registration-typ');
});
Route::get('/registra-tu-marca', function () {
    return view('pages.trademark-registration');
});
Route::get('/registra-tu-marca/subcategorias', function () {
    return view('pages.trademark-registration');
});
Route::get('/registra-tu-marca/resultados', function () {
    return view('pages.trademark-registration');
});
Route::get('/registra-tu-marca/facturacion', function () {
    return view('pages.trademark-registration');
});
Route::get('/registra-tu-marca/categorias', function () {
    return view('pages.trademark-registration');
});
Route::get('/error', function () {
    return view('pages.payment-error');
});
Route::get('/not-found', function () {
    return view('pages.not-found');
});
// Route::get('/politicas-de-privacidad', function () {
//     return view('pages.privacy-policies');
// });
// Route::get('/terminos-y-condiciones', function () {
//     return view('pages.terms-and-conditions');
// });
// Route::get('/contacto-gracias', function () {
//     return view('pages.contact-typ');
// });
// Route::get('/centro-de-ayuda', function () {
//     return view('pages.help-center');
// });
// Route::get('/blog/marca-tu-exito-el-abc-del-registro-de-marcas-en-chile', function () {
//     return view('pages.blog-single');
// });
Route::get('/blog-empty-state', function () {
    return view('pages.blog-empty-state');
});
// Route::get('/blog-listing-page', function () {
//     return view('pages.blog');
// });
// Route::get('/que-hacemos', function () {
//     return view('pages.what-we-do');
// });
// Route::get('/quienes-somos', function () {
//     return view('pages.about-us');
// });
// Route::get('/', function () {
//     return view('pages.home');
// });



Route::get('singular', ['page', 'uses' => 'PageController@detail']);
Route::get('singular', ['blog', 'uses' => 'BlogController@detail']);

