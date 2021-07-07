<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dsc', 'MonitoringController@view');
Route::get('/dsc/{id}', 'MonitoringController@viewByID');
Route::get('/dsc/report/all', 'MonitoringController@viewReport');
Route::get('/dsc/report/detail/{id}', 'MonitoringController@viewReportDetail');
Route::get('/dsc/penggajian/all', 'MonitoringController@viewPenggajian');

Route::get('/kelompok/{id}/detailajax', 'Admin\KelompokController@detailKelompokAJAX');
Route::post('/kelompok/{id}/updateGaji', 'Admin\KelompokController@updateGaji');


Route::get('/mentors', 'Mentor\ProfileController@getData')->name("getData");
Route::get('/mentors/export', 'Mentor\ProfileController@export_excel')->name('export_mentor_excel');

Route::get('/mobile', function () {
    return response()->download(public_path() . '/API/mobile/FT_SIBIMA.apk');
});

// Authentication Route
Route::get('/login', 'AuthController@getLogin')->middleware(['htmlmin']);
Route::post('/login', 'AuthController@submitLogin');
Route::get('/logout', 'AuthController@logout');

//--------------- ADMIN ROUTES ---------------//

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {

    // Dashboard Route
    Route::get('/', 'Admin\DashboardController@index');
    Route::get('/dashboard', 'Admin\DashboardController@main');

    // Agenda Route
    Route::get('/agenda', 'Admin\AgendaController@getList');
    Route::post('/agenda', 'Admin\AgendaController@addAgenda');
    Route::post('/agenda/edit', 'Admin\AgendaController@edit');
    Route::get('/agenda/delete/{id}', 'Admin\AgendaController@delete');

    // Berita Mentoring Route
    Route::get('/berita-mentoring', 'Admin\BeritaMentoringController@index');
    Route::get('/berita-mentoring/export/', 'Admin\ExportController@menuExport');
    Route::get('/berita-mentoring/export/data', 'Admin\ExportController@exportData');
    Route::get('/berita-mentoring/input', 'Admin\BeritaMentoringController@inputTelat');
    Route::post('/berita-mentoring/input', 'Admin\BeritaMentoringController@submitTelat');
    Route::get('/berita-mentoring/edit/{id}', 'Admin\BeritaMentoringController@edit');
    Route::post('/berita-mentoring/edit/{id}', 'Admin\BeritaMentoringController@submitEdit');
    Route::get('/berita-mentoring/unreported', 'Admin\BeritaMentoringController@unreported');
    Route::get('/berita-mentoring/delete/{id}', 'Admin\BeritaMentoringController@delete');
    Route::get('/berita-mentoring/{id}', 'Admin\BeritaMentoringController@detail');

    // Kelompok Route
    Route::get('/kelompok', 'Admin\KelompokController@listKelompok');
    Route::get('/kelompok/create-ikhwan', 'Admin\KelompokController@createIkhwan');
    Route::post('/kelompok/create-ikhwan', 'Admin\KelompokController@postCreateIkhwan');
    Route::get('/kelompok/create-akhwat', 'Admin\KelompokController@createAkhwat');
    Route::post('/kelompok/create-akhwat', 'Admin\KelompokController@postCreateAkhwat');
    Route::get('/kelompok/validasi', 'Admin\KelompokController@validasi');
    Route::get('/kelompok/export', 'Admin\KelompokController@exportKelompok');
    Route::get('/kelompok/export/data', 'Admin\KelompokController@exportData');
    Route::get('/kelompok/generate', 'Admin\KelompokController@generate');
    Route::get('/kelompok/{id}', 'Admin\KelompokController@detailKelompok');
    Route::get('/kelompok/delete/{id}', 'Admin\KelompokController@deleteKelompok');
    Route::get('/kelompok/remove/{id_mentee}', 'Admin\KelompokController@removeMentee');
    Route::post('/kelompok/add-mentee/{id}', 'Admin\KelompokController@addMentee');
    Route::post('/kelompok/change/{id}', 'Admin\KelompokController@changeMentorOrAsisten');

    // Kalendar Route
    Route::get('/kalender/', 'Admin\KalenderController@viewKalender');
    Route::get('/kalender/event', 'Admin\KalenderController@index');
    Route::post('/kalender/event', 'Admin\KalenderController@create');
    Route::get('/kalender/event/delete/{id}', 'Admin\KalenderController@delete');

    // Presensi General Route
    Route::get('presensi/general', 'Admin\PresensiController@viewGeneral');
    Route::get('presensi/general/input/{id_agenda}', 'Admin\PresensiController@inputGeneral');
    Route::post('presensi/general/input/{id_agenda}', 'Admin\PresensiController@postInputGeneral');
    Route::get('presensi/general/detail/{id_agenda}', 'Admin\PresensiController@detailGeneral');

    // Presensi General Perizinan
    Route::get('/presensi/perizinan', 'Admin\PerizinanController@perizinan');
    Route::get('/presensi/perizinan/acc/{id}/', 'Admin\PerizinanController@accepted');
    Route::get('/presensi/perizinan/reject/{id}/', 'Admin\PerizinanController@reject');
    Route::get('/presensi/perizinan/delete/{id}', 'Admin\PerizinanController@delete');

    // Presensi Talaqi Route
    Route::get('presensi/talaqi', 'Admin\PresensiController@viewTalaqi');
    Route::get('presensi/talaqi/input/{id_agenda}', 'Admin\PresensiController@inputTalaqi');
    Route::post('presensi/talaqi/input/{id_agenda}', 'Admin\PresensiController@postInputTalaqi');
    Route::get('presensi/talaqi/detail/{id_agenda}', 'Admin\PresensiController@detailTalaqi');
    Route::get('presensi/talaqi/export', 'Admin\PresensiController@viewExport');


    // Manage Data Mentor Mentoring Route
    Route::get('/data/mentor', 'Admin\DataController@listMentor');
    Route::post('/data/mentor', 'Admin\DataController@submitInputMentor');
    Route::post('/data/mentor/reset', 'Admin\DataController@resetPasswordMentor');
    Route::get('/data/mentor/edit/{id}', 'Admin\DataController@editMentor');
    Route::post('/data/mentor/edit/{id}', 'Admin\DataController@submitEditMentor');
    Route::get('/data/mentor/delete/{id}', 'Admin\DataController@deleteMentor');
    Route::get('/data/mentor/{id}', 'Admin\DataController@detailMentor');

    // Manage Data Mentee Route
    Route::get('/data/mentee', 'Admin\DataController@listMentee');
    Route::post('/data/mentee', 'Admin\DataController@submitInputMentee');
    Route::post('/data/mentee/reset', 'Admin\DataController@resetPasswordMentee');
    Route::get('/data/mentee/edit/{id}', 'Admin\DataController@editMentee');
    Route::post('/data/mentee/edit/{id}', 'Admin\DataController@submitEditMentee');
    Route::get('/data/mentee/delete/{id}', 'Admin\DataController@deleteMentee');
    Route::get('/data/mentee/{id}', 'Admin\DataController@detailMentee');

    // Data Upload and Manage DB Route
    Route::get('/data/admin/', 'Admin\DataController@listAdmin');
    Route::get('/data/manage-db', 'Admin\DataController@viewManageDB');
    Route::get('/data/manage-db/remigrate', 'Admin\DataController@remigrateDB');
    Route::get('/data/manage-db/download', 'Admin\DataController@downloadBackup');
    Route::get('/data/manage-db/backup-now', 'Admin\DataController@backupNow');
    Route::get('/data/upload', 'Admin\DataController@viewUpload');
    Route::post('/data/upload', 'Admin\DataController@postUpload');

    // Tugas Besar Route
    Route::get('/tugas-besar', 'Admin\TugasBesarController@index');
    Route::post('/tugas-besar', 'Admin\TugasBesarController@submitTelat'); // submit telat
    Route::get('/api/tugas-besar/submit', 'Admin\TugasBesarController@submit');
    Route::get('/tugas-besar/delete/{id}', 'Admin\TugasBesarController@delete');

    // Materi Route
    Route::get('/materi', 'Admin\MateriController@index');
    Route::post('/materi', 'Admin\MateriController@create');
    Route::get('/materi/delete/{id}', 'Admin\MateriController@delete');

    // Questioner Route
    Route::get('/questioner', 'Admin\QuestionerController@index');
    Route::post('/questioner', 'Admin\QuestionerController@addQuestioner');
    Route::get('/questioner/delete/{id}', 'Admin\QuestionerController@deleteQuestioner');

    // Penggumuman
    Route::get('/pengumuman', 'Admin\PengumumanController@viewPenggumuman');
    Route::post('/pengumuman', 'Admin\PengumumanController@submit');
    Route::get('/pengumuman/delete/{id}', 'Admin\PengumumanController@delete');
    Route::get('/pengumuman/{id}', 'Admin\PengumumanController@detail');

    // ADMIN API LOCAL
    Route::get('/api/get-kelas', 'Admin\KelompokController@apiGetKelas');
    Route::get('/api/get-mentee-ikhwan', 'Admin\KelompokController@apiGetMenteeIkhwan');
    Route::get('/api/get-mentee-akhwat', 'Admin\KelompokController@apiGetMenteeAkhwat');
    Route::get('/api/presensi/get-mentee', 'Admin\PresensiController@apiGetMentee');
    Route::get('/api/presensi/get-mentor', 'Admin\PresensiController@apiGetMentor');
    Route::get('/api/tugas-besar/submit', 'Admin\TugasBesarController@submit');

    // Change Password Route
    Route::get('/password', 'Admin\PasswordController@getPassword');
    Route::post('/password', 'Admin\PasswordController@changePassword');

    // About BIMA Route
    Route::get('/about-bima', 'Admin\DashboardController@about');
});

//--------------- MENTEE ROUTES ---------------//

Route::group(['prefix' => 'mentee', 'middleware' => 'auth.mentee'], function () {

    Route::get('/absen', 'Mentee\AbsenQRController@index');

    // Dashboard Route
    Route::get('/', 'Mentee\DashboardController@redirect');
    Route::get('/dashboard', 'Mentee\DashboardController@index');

    // Nilai Route
    Route::get('/nilai', 'Mentee\NilaiController@main');


    // Kelompok Route
    Route::get('/kelompok', 'Mentee\KelompokController@index');

    // Materi Route
    Route::get('/materi', 'Mentee\MateriController@getMateri');

    // Tugas Besar Shining Team Route
    Route::get('/tugas-besar', 'Mentee\TugasBesarController@input');
    Route::post('/tugas-besar', 'Mentee\TugasBesarController@submit');

    // Questioner Route
    Route::get('/questioner', 'Mentee\QuestionerController@getQuestioner');

    // Profile Route
    Route::get('/profile', 'Mentee\ProfileController@getProfile');
    Route::post('/profile', 'Mentee\ProfileController@postProfile');

    // Change Password Route
    Route::get('/password', 'Mentee\PasswordController@getPassword');
    Route::post('/password', 'Mentee\PasswordController@changePassword');

    // About BIMA Route
    Route::get('/about-bima', 'Mentee\DashboardController@about');

    // Perizinan Route
    Route::get('/perizinan', 'Mentee\PerizinanController@perizinan');
    Route::post('/perizinan', 'Mentee\PerizinanController@submit');
});

//--------------- MENTOR ROUTES ---------------//

Route::group(['prefix' => 'mentor', 'middleware' => 'auth.mentor'], function () {

    // Dasboard Route
    Route::get('/', 'Mentor\DashboardController@redirect');
    Route::get('/dashboard', 'Mentor\DashboardController@index');

    // Berita Mentoring Route
    Route::get('/berita-mentoring', 'Mentor\BeritaMentoringController@getListAgenda');
    Route::get('/berita-mentoring/input/{id_agenda}', 'Mentor\BeritaMentoringController@input');
    Route::post('/berita-mentoring/input/{id_agenda}', 'Mentor\BeritaMentoringController@submit');
    Route::get('/berita-mentoring/edit/{id_agenda}', 'Mentor\BeritaMentoringController@edit');
    Route::post('/berita-mentoring/edit/{id_agenda}', 'Mentor\BeritaMentoringController@submitEdit');
    Route::get('/berita-mentoring/rekap', 'Mentor\BeritaMentoringController@rekap');
    Route::get('/berita-mentoring/export/{id_agenda}', 'Mentor\BeritaMentoringController@export');

    // View Kelompok Route
    Route::get('/kelompok', 'Mentor\KelompokController@index');
    Route::get('/kelompok/asisten', 'Mentor\KelompokController@asisten');

    // View Kehadiran Talaqi Route
    Route::get('kehadiran', 'Mentor\PresensiTalaqiController@index');

    // Materi & Questioner Route
    Route::get('/materi', 'Mentor\MateriController@getMateri');
    Route::get('/questioner', 'Mentor\QuestionerController@getQuestioner');

    // Change Password Route
    Route::get('/password', 'Mentor\PasswordController@getPassword');
    Route::post('/password', 'Mentor\PasswordController@changePassword');

    // Edit Profile Route
    Route::get('/profile', 'Mentor\ProfileController@getProfile');
    Route::post('/profile', 'Mentor\ProfileController@postProfile');
    Route::post('/update-cred', 'Mentor\ProfileController@postCredential');

    //penggumuman
    Route::get('/pengumuman', 'Mentor\PengumumanController@viewPengumuman');

    // About BIMA Route
    Route::get('/about-bima', 'Mentor\DashboardController@about');
});
