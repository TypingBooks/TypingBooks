<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BookTranslationController;

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

/*
Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/data', function () {
    return view('data');
});

Route::get('/data/download', function () {
    return Storage::download('data/all_data.zip');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@index')->name('profile');
Route::patch('/profile/email', 'HomeController@updateEmail')->name('updateEmail')->middleware('auth');
Route::patch('/profile/password', 'HomeController@updatePassword')->name('updatePassword')->middleware('auth');
Route::patch('/profile/darkmode', 'HomeController@toggleDarkMode')->name('toggleDarkMode')->middleware('auth');
Route::get('/profile/activity/{page}', 'HomeController@allActivity')->name('allActivity')->middleware('auth');

Route::get('/stats/{user}', 'StatisticsController@viewUser')->name('statsForUser');
Route::get('/stats/{user}/languages', 'StatisticsController@viewLanguagesForUser')->name('languagesForUser');
Route::get('/stats/{user}/language/{language}', 'StatisticsController@viewLanguageForUser')->name('languageForUser');
Route::get('/stats/{user}/language/{language}/books', 'StatisticsController@allBooksForUserInLanguage')->name('booksForUserInLanguage');
Route::get('/stats/{user}/books/', 'StatisticsController@viewBooksForUser')->name('booksForUser');
Route::get('/stats/{user}/book/{book}', 'StatisticsController@viewBookForUser')->name('bookForUser');

Route::get('/import', 'ImportController@index')->name('userImportBook')->middleware('auth');
Route::get('/import/added/{page}', 'ImportController@importedBooksForUser')->middleware('auth');
Route::get('/import/format', 'ImportController@guide')->name('importGuide');
Route::post('/import', 'ImportController@saveBook')->name('userSaveBook')->middleware('auth');
Route::get('/import/review/{book}', 'ImportController@reviewBook')->name('userReviewBook')->middleware('auth');
Route::post('/import/review/{book}', 'ImportController@userActivateBook')->name('userActivateBook')->middleware('auth');

Route::get('/', 'IndexController@index')->name('index2');

Route::get('/l', 'LanguageController@index')->name('index');
Route::get('/l/{native_abbreviation}/', 'LanguageController@learnFromLanguage')->name('learnFromLanguage');

Route::get('/l/{native}/{learning}', 'LearningLandingController@learn')->name('learnLanguage');

Route::get('/l/{native}/{learning}/translated/{page}', 'LearningLandingController@learn2');
Route::get('/l/{native}/{learning}/waiting/{page}', 'LearningLandingController@learn3');
Route::get('/l/{native}/{learning}/user/translated/{page}', 'LearningLandingController@learn4');
Route::get('/l/{native}/{learning}/user/waiting/{page}', 'LearningLandingController@learn5');

Route::get('/order/{translation_book_id}', 'BookTranslationController@order')->name('orderBook');
Route::get('/order/{translation_book_id}/checkout', 'OrderController@checkout')->name('checkout');


Route::get('/book/{id}', 'BookTranslationController@viewBook')->name('viewBook');
Route::get('/book/{id}/{part}', 'BookTranslationController@viewChapters')->name('viewBookChapters');

Route::get('/admin', function () {
    return view('admin/index');
})->middleware('auth', 'role:admin');


Route::get('/admin/import', 'BookController@import')->name('import_book')->middleware('auth', 'role:admin');
Route::post('/admin/import', 'BookController@saveBook')->name('save_book')->middleware('auth', 'role:admin');
Route::get('/admin/order', 'BookTranslationController@adminViewAllNotTranslated')->middleware('auth', 'role:admin');
Route::post('/admin/order', 'OrderController@adminOrderBook')->middleware('auth', 'role:admin');
Route::get('/admin/fix/books', 'BookTranslationController@manageBookErrors')->middleware('auth', 'role:admin');
Route::post('/admin/fix/books', 'BookTranslationController@fixBook')->middleware('auth', 'role:admin');
Route::get('/admin/modify/books', 'BookTranslationController@adminModifyAndCreateTranslations')->middleware('auth', 'role:admin');
Route::post('/admin/modify/books', 'BookTranslationController@replaceTextInBook')->middleware('auth', 'role:admin');
Route::get('/admin/languages', 'LanguageController@editLanguages')->middleware('auth', 'role:admin');
Route::get('/admin/language/{language}', 'LanguageController@editLanguage')->middleware('auth', 'role:admin');
Route::post('/admin/language/{language}', 'LanguageController@updateLanguage')->middleware('auth', 'role:admin');
Route::get('/admin/languages/settings', 'SettingsController@index')->middleware('auth', 'role:admin');
Route::post('/admin/languages/settings', 'SettingsController@updateSettings')->middleware('auth', 'role:admin');

Route::get('/api/translation/book/{id}/{paragraph}', 'ParagraphTranslationController@getParagraph');
Route::post('/api/translation/book/{id}/{paragraph}', 'ParagraphTranslationController@saveScore')->middleware('auth');

Route::get('/game/{id}/{paragraph}', 'GameController@loadBookGame');
Route::get('/start/{id}/', 'GameController@loadCurrentGame');

Route::post('/stripe/hooks', 'OrderController@confirmOrder');
Route::get('/purchase/complete', 'OrderController@complete');

Route::get('/purchase/complete/{order}', 'OrderController@complete');



