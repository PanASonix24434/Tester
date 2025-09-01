<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CfgLicenseController;
use App\Http\Controllers\UserPublicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationProfileController;
use App\Http\Controllers\ProfileVesel\ProfileVeselController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationApprovalController;
use App\Http\Controllers\ApplicationElaunSaraHidup_NDController;


use App\Http\Controllers\Landing\TicketController as LandingTicketController;
use App\Models\Application;
use App\Models\ESH\ApplicationElaunSaraHidup_ND;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('welcome');
    }
    //return view('welcome');
    //Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
});

Route::get('/welcome', [AuthenticatedSessionController::class, 'welcome'])
    ->middleware('guest')
    ->name('welcome');

Route::group(['as' => 'landing.',], function () {
    Route::prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/create', [LandingTicketController::class, 'create'])->name('create');
        Route::post('/', [LandingTicketController::class, 'store'])->name('store');
    });
});

Route::prefix('registerpassword')->name('registerpassword.')->group(function () {
    Route::get('/{id}/registerpassword', [UserController::class, 'registerpassword'])->name('registerpassword');
    Route::post('/{id}/updateregisterpassword', [UserController::class, 'updateregisterpassword'])->name('updateregisterpassword');
});

//Download Pengumuman File
Route::prefix('pengumuman')->name('pengumuman.')->group(function () {
    Route::get('/{id}/downloadDoc', 'Systems\AnnouncementController@downloadDoc')->name('downloadDoc');
});


Route::prefix('complaint')->name('complaint.')->group(function () {
    Route::get('/', 'ComplaintController@index')->name('index');
    Route::get('/create', 'ComplaintController@create')->name('create');
    Route::post('/store', 'ComplaintController@store')->name('store');
});

//Email
Route::get('/sendMailTest/', 'MailController@sendMailTest')->name('sendMailTest');

require __DIR__ . '/auth.php';

Route::post('/getIcno', 'UserController@getIcno')->name('getIcno');

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => config('app.url_prefix')], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    //Modul Profil
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {

        Route::post('/update', [UserController::class, 'updateProfile'])->name('update');
        Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])->name('picture.update');

        // Profile Pengguna
        Route::get('/handleProfile', 'ProfileController@handleProfile')->name('handleProfile');
        Route::post('/storeprofileuser', 'ProfileController@storeprofileuser')->name('storeprofileuser');
        Route::get('/{id}/viewprofileuser', 'ProfileController@viewprofileuser')->name('viewprofileuser');
        Route::get('/{id}/editprofileuser', 'ProfileController@editprofileuser')->name('editprofileuser');
        Route::post('/{id}/updateprofileuser', 'ProfileController@updateprofileuser')->name('updateprofileuser');

        //kemasikini katalaluan
        //ikin			
        Route::get('/changepassword', 'Systems\ChangePasswordController@changepassword')->name('changepassword');
        Route::post('/{id}/updatepassword', 'Systems\ChangePasswordController@updatepassword')->name('updatepassword');

        //kemasikini profil
        //ikin			
        Route::get('/updateprofile', 'Systems\UpdateStaffProfileController@updateprofile')->name('updateprofile');    //View blade
        Route::post('/{id}/updateStaffProfile', 'Systems\UpdateStaffProfileController@updateStaffProfile')->name('updateStaffProfile'); //Update data


        // Pengesahan Profil
        Route::get('/verifyProfiles', 'VerificationProfileController@verifyProfiles')->name('verifyProfiles');
        Route::get('/{profile}/showVerification', 'VerificationProfileController@showVerification')->name('showVerification');
        Route::post('/{profile}/submitVerification', 'VerificationProfileController@submitVerification')->name('submitVerification');

        // Nelayan Darat
        Route::get('/kewanganDarat', 'ProfileController@kewanganDarat')->name('kewanganDarat');
        Route::get('/pangkalanDarat', 'ProfileController@pangkalanDarat')->name('pangkalanDarat');
        Route::get('/veselDarat', 'ProfileController@veselDarat')->name('veselDarat');
        Route::get('/aktivitiDarat', 'ProfileController@aktivitiDarat')->name('aktivitiDarat');
        Route::get('/kesalahanDarat', 'ProfileController@kesalahanDarat')->name('kesalahanDarat');

        // Maklumat Syarikat - Maklumat Yang boleh dikemaskini
        Route::get('/indexSyarikat', 'ProfileController@indexSyarikat')->name('indexSyarikat');
        Route::get('/maklumatSyarikat', 'ProfileController@maklumatSyarikat')->name('maklumatSyarikat');
        Route::get('/{id}/editMaklumatSyarikat', 'ProfileController@editMaklumatSyarikat')->name('editMaklumatSyarikat');
        Route::post('/{id}/updateMaklumatSyarikat', 'ProfileController@updateMaklumatSyarikat')->name('updateMaklumatSyarikat');

        // Penglibatan Syarikat (boleh dikemaskini)
        Route::get('/{company_id}/penglibatanSyarikat', 'ProfileController@penglibatanSyarikat')->name('penglibatanSyarikat');
        Route::get('/{company_id}/editPenglibatanSyarikat', 'ProfileController@editPenglibatanSyarikat')->name('editPenglibatanSyarikat');
        Route::post('/{company_id}/updatePenglibatanSyarikat', 'ProfileController@updatePenglibatanSyarikat')->name('updatePenglibatanSyarikat');

        //Maklumat Syarikat  - Maklumat yang tidak boleh dikemaskini
        Route::get('/{company_id}/pendaftaranPerniagaan', 'ProfileController@pendaftaranPerniagaan')->name('pendaftaranPerniagaan');
        Route::get('/{company_id}/pemilikanPentadbiran', 'ProfileController@pemilikanPentadbiran')->name('pemilikanPentadbiran');
        Route::get('/{company_id}/kewanganSyarikat', 'ProfileController@kewanganSyarikat')->name('kewanganSyarikat');
        Route::get('/{company_id}/dokumenSyarikat', 'ProfileController@dokumenSyarikat')->name('dokumenSyarikat');

        // Route Not Used
        Route::post('/userUpdate', 'ProfileController@userUpdate')->name('userUpdate');
        Route::get('/profileCompanyCreate', 'ProfileController@profileCompanyCreate')->name('profileCompanyCreate');
        Route::get('/{id}/profileCompanyAlpList', 'ProfileController@profileCompanyAlpList')->name('profileCompanyAlpList');
        Route::get('/{id}/profileCompanyAlpCreate', 'ProfileController@profileCompanyAlpCreate')->name('profileCompanyAlpCreate');
        Route::get('/{id}/profileCompanyAssetList', 'ProfileController@profileCompanyAssetList')->name('profileCompanyAssetList');
        Route::get('/{id}/profileCompanyAssetCreate', 'ProfileController@profileCompanyAssetCreate')->name('profileCompanyAssetCreate');
        Route::get('/{id}/profileCompanyAccountList', 'ProfileController@profileCompanyAccountList')->name('profileCompanyAccountList');
        Route::get('/{id}/profileCompanyAccountCreate', 'ProfileController@profileCompanyAccountCreate')->name('profileCompanyAccountCreate');
        Route::post('/profileCompanyStore', 'ProfileController@profileCompanyStore')->name('profileCompanyStore');
        Route::post('/profileCompanyAlpStore', 'ProfileController@profileCompanyAlpStore')->name('profileCompanyAlpStore');
        Route::post('/profileCompanyAssetStore', 'ProfileController@profileCompanyAssetStore')->name('profileCompanyAssetStore');
        Route::post('/profileCompanyAccountStore', 'ProfileController@profileCompanyAccountStore')->name('profileCompanyAccountStore');
        Route::get('/{id}/profileCompanyAccountDownload', 'ProfileController@profileCompanyAccountDownload')->name('profileCompanyAccountDownload');
        Route::delete('/{id}/profileCompanyAccountDelete', 'ProfileController@profileCompanyAccountDelete')->name('profileCompanyAccountDelete');


        // Profile Picture
        Route::post('/rotate-profile-picture', 'UserController@rotateProfilePicture')->name('picture.rotate');
        Route::delete('/delete-profile-picture', 'UserController@deleteProfilePicture')->name('picture.delete');
        Route::get('/change-password', 'UserController@changePassword')->name('password.change');
        Route::post('/change-password', 'UserController@postChangePassword')->name('password.change.post');

        //Profile Staff
        Route::get('/stafflist', 'ProfileStaffController@stafflist')->name('stafflist');
        Route::get('/staffcreate', 'ProfileStaffController@staffcreate')->name('staffcreate');
        Route::post('/staffstore', 'ProfileStaffController@staffstore')->name('staffstore');
        Route::get('/{id}/staffedit', 'ProfileStaffController@staffedit')->name('staffedit');
        Route::post('/{id}staffupdate', 'ProfileStaffController@staffupdate')->name('staffupdate');
        Route::delete('/{id}', 'ProfileStaffController@staffdelete')->name('staffdelete');

        // Pengusaha SKL
        Route::get('/projekskl', 'ProfileController@projekskl')->name('projekskl');
        Route::get('/handleprojekskl', 'ProfileController@handleprojekskl')->name('handleprojekskl');
        Route::post('/storeprojekskl', 'ProfileController@storeprojekskl')->name('storeprojekskl');
        Route::get('/{id}/viewprojekskl', 'ProfileController@viewprojekskl')->name('viewprojekskl');
        Route::get('/{id}/editprojekskl', 'ProfileController@editprojekskl')->name('editprojekskl');
        Route::post('/{id}/updateprojekskl', 'ProfileController@updateprojekskl')->name('updateprojekskl');

        // Pengurus Vesel
        Route::prefix('vesselmanager')->name('vesselmanager.')->group(function () {
            Route::put('/{id}/deactivate', 'VesselManager\RegistrationController@deactivate')->name('deactivate');
        });
        Route::resource('/vesselmanager', 'VesselManager\RegistrationController')->except(['destroy']);

        // Pentadbir Harta / Pewaris
        Route::name('inheritance.')->group(function () {
            Route::resource('/inheritance-administrator', 'Inheritance\AdminController', [
                'names' => [
                    'index' => 'admin.index',
                    'create' => 'admin.create',
                    'store' => 'admin.store',
                    'show' => 'admin.show',
                    'edit' => 'admin.edit',
                    'update' => 'admin.update',
                    'destroy' => 'admin.destroy',
                ]
            ]);
        });

        // Vesel Profile
        Route::prefix('vesel')->group(function () {
            Route::get('/', [ProfileVeselController::class, 'index'])->name('veselProfile');
            Route::get('/{id}', [ProfileVeselController::class, 'show'])->name('veselProfile.show');
        });

        Route::prefix('vessel/{id}/tab')->group(function () {
            Route::get('/amvessel', [ProfileVeselController::class, 'show'])->name('am_vessel.tab.show');
            Route::get('/lesen', [ProfileVeselController::class, 'show'])->name('lesen.tab.show');
            Route::get('/kulit', [ProfileVeselController::class, 'show'])->name('kulit.tab.show');
            Route::get('/kulit/{kulitId}', [ProfileVeselController::class, 'kulitTable'])->name('kulittable');
            Route::get('/enjin', [ProfileVeselController::class, 'show'])->name('enjin.tab.show');
            Route::get('/enjin/{enjinId}', [ProfileVeselController::class, 'enjinImage'])->name('enjinimage');
            Route::get('/peralatan', [ProfileVeselController::class, 'show'])->name('peralatan.tab.show');
            Route::get('/pemilikan', [ProfileVeselController::class, 'show'])->name('pemilikan.tab.show');
            Route::get('/pangkalan', [ProfileVeselController::class, 'show'])->name('pangkalan.tab.show');
            Route::get('/pematuhan', [ProfileVeselController::class, 'show'])->name('pematuhan.tab.show');
            Route::get('/pendaftaran_antarabangsa', [ProfileVeselController::class, 'show'])->name('pendaftaran_antarabangsa.tab.show');
            Route::get('/kru', [ProfileVeselController::class, 'show'])->name('kru.tab.show');
            Route::get('/kesalahan', [ProfileVeselController::class, 'show'])->name('kesalahan.tab.show');

            Route::prefix('tabkru')->group(function () {
                Route::get('/kru_tempatan', [ProfileVeselController::class, 'show'])->name('kru_tempatan.tabkru.tab.show');
                Route::get('/penduduk_tetap', [ProfileVeselController::class, 'show'])->name('penduduk_tetap.tabkru.tab.show');
                Route::get('/kru_asing', [ProfileVeselController::class, 'show'])->name('kru_asing.tabkru.tab.show');
            });

            Route::prefix('tabpematuhan')->group(function () {
                Route::get('/vesel', [ProfileVeselController::class, 'show'])->name('vesel.tabpematuhan.tab.show');
                Route::get('/peralatan_pelayaran', [ProfileVeselController::class, 'show'])->name('peralatan_pelayaran.tabpematuhan.tab.show');
                Route::get('/peralatan_keselamatan', [ProfileVeselController::class, 'show'])->name('peralatan_keselamatan.tabpematuhan.tab.show');
                Route::get('/kelengkapan_menangkap_ikan', [ProfileVeselController::class, 'show'])->name('kelengkapan_menangkap_ikan.tabpematuhan.tab.show');
                Route::get('/dokumen', [ProfileVeselController::class, 'show'])->name('dokumen.tabpematuhan.tab.show');
            });
        });
    });

    // Pengesahan Profil (Pengurus Vesel & Pentadbir Harta)
    Route::prefix('profile-verification')->name('profile_verification.')->group(function () {
        Route::resource('/vesselmanager', 'VesselManager\VerificationController')->only(['index', 'edit', 'update']);

        Route::name('inheritance.')->group(function () {
            Route::resource('/inheritance-administrator', 'Inheritance\VerificationController', [
                'names' => [
                    'index' => 'admin.index',
                    'create' => 'admin.create',
                    'store' => 'admin.store',
                    'show' => 'admin.show',
                    'edit' => 'admin.edit',
                    'update' => 'admin.update',
                    'destroy' => 'admin.destroy',
                ]
            ])->only(['index', 'edit', 'update']);
        });
    });

    Route::prefix('attachment')->name('attachment.')->group(function () {
        Route::delete('/{id?}', 'AttachmentController@destroy')->name('destroy');
    });

    Route::prefix('vessel')->name('vessel.')->group(function () {
        Route::prefix('owned')->name('owned.')->group(function () {
            Route::get('/{owner_id}', function ($owner_id) {
                return response()->json(getOwnedVessels($owner_id));
            })->name('by');
        });
    });

    //kruhelper
    Route::group(['prefix' => 'kruhelper', 'as' => 'kruhelper.'], function () {
        Route::get('/{id}/previewReceipt', 'Kru\KruHelperController@previewReceipt')->name('previewReceipt');
        Route::get('/{id}/deleteReceipt', 'Kru\KruHelperController@deleteReceipt')->name('deleteReceipt');

        Route::get('/{id}/previewDoc', 'Kru\KruHelperController@previewDoc')->name('previewDoc');
        Route::delete('/{id}/deleteDoc', 'Kru\KruHelperController@deleteDoc')->name('deleteDoc');

        Route::get('/{id}/previewKruDoc', 'Kru\KruHelperController@previewKruDoc')->name('previewKruDoc');
        Route::delete('/{id}/deleteKruDoc', 'Kru\KruHelperController@deleteKruDoc')->name('deleteKruDoc');

        Route::get('/{id}/previewKruForeignDoc', 'Kru\KruHelperController@previewKruForeignDoc')->name('previewKruForeignDoc');
        Route::delete('/{id}/deleteKruForeignDoc', 'Kru\KruHelperController@deleteKruForeignDoc')->name('deleteKruForeignDoc');

        Route::get('/downloadPKN', 'Kru\KruHelperController@downloadPKN')->name('downloadPKN');
    });

    Route::group(['prefix' => 'crewvessel', 'as' => 'crewvessel.'], function () {
        Route::get('/', 'Kru\CrewVessel\CrewVesselController@index')->name('index');
    });

    Route::group(['prefix' => 'keseluruhanpermohonankru', 'as' => 'keseluruhanpermohonankru.'], function () {
        Route::get('/', 'Kru\KeseluruhanPermohonan\PermohonanController@index')->name('index');
        Route::get('/{id}/showKru01', 'Kru\KeseluruhanPermohonan\PermohonanController@showKru01')->name('showKru01');
        Route::get('/{id}/showKru02', 'Kru\KeseluruhanPermohonan\PermohonanController@showKru02')->name('showKru02');
        Route::get('/{id}/showKru02Kru', 'Kru\KeseluruhanPermohonan\PermohonanController@showKru02Kru')->name('showKru02Kru');
        Route::get('/{id}/showKru03', 'Kru\KeseluruhanPermohonan\PermohonanController@showKru03')->name('showKru03');
        Route::get('/{id}/showKru04', 'Kru\KeseluruhanPermohonan\PermohonanController@showKru04')->name('showKru04');
    });

    //KRU01 - Permohonan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)
    Route::group(['prefix' => 'kadpendaftarannelayan', 'as' => 'kadpendaftarannelayan.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru01\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\PermohonanController@show')->name('show');
            Route::get('/create', 'Kru\Kru01\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru01\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru01\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru01\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru01\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editD', 'Kru\Kru01\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editDAddDoc', 'Kru\Kru01\PermohonanController@editDAddDoc')->name('editDAddDoc');
            Route::get('/{id}/editE', 'Kru\Kru01\PermohonanController@editE')->name('editE');
            Route::post('/{id}update', 'Kru\Kru01\PermohonanController@update')->name('update');
            Route::post('/{id}updateB', 'Kru\Kru01\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateC', 'Kru\Kru01\PermohonanController@updateC')->name('updateC');
            Route::post('/{id}updateE', 'Kru\Kru01\PermohonanController@updateE')->name('updateE');
            Route::post('/{id}updateDAddDoc', 'Kru\Kru01\PermohonanController@updateDAddDoc')->name('updateDAddDoc');
            // Route::get('/{id}/downloadDoc', 'Kru\Kru01\PermohonanController@downloadDoc')->name('downloadDoc');
            // Route::delete('/{id}/deleteDoc', 'Kru\Kru01\PermohonanController@destroyDoc')->name('deleteDoc');
            Route::delete('/{id}', 'Kru\Kru01\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru01\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\SemakanDaerahController@update')->name('update');
        });
        //Sokongan Daerah - KDP
        Route::group(['prefix' => 'sokongandaerah', 'as' => 'sokongandaerah.'], function () {
            Route::get('/', 'Kru\Kru01\SokonganDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\SokonganDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\SokonganDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru01\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\KeputusanDaerahController@update')->name('update');
        });
        //Sokongan Wilayah - PPW
        Route::group(['prefix' => 'sokonganwilayah', 'as' => 'sokonganwilayah.'], function () {
            Route::get('/', 'Kru\Kru01\SokonganWilayahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\SokonganWilayahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\SokonganWilayahController@update')->name('update');
        });
        //Keputusan Wilayah - PPW
        Route::group(['prefix' => 'keputusanwilayah', 'as' => 'keputusanwilayah.'], function () {
            Route::get('/', 'Kru\Kru01\KeputusanWilayahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\KeputusanWilayahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\KeputusanWilayahController@update')->name('update');
        });
        //Semakan Negeri - FA(N)
        Route::group(['prefix' => 'semakannegeri', 'as' => 'semakannegeri.'], function () {
            Route::get('/', 'Kru\Kru01\SemakanNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\SemakanNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\SemakanNegeriController@update')->name('update');
        });
        //Sokongan Negeri - KCSPT(N)
        Route::group(['prefix' => 'sokongannegeri', 'as' => 'sokongannegeri.'], function () {
            Route::get('/', 'Kru\Kru01\SokonganNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\SokonganNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\SokonganNegeriController@update')->name('update');
        });
        //Keputusan Negeri - PPN/JPLS
        Route::group(['prefix' => 'keputusannegeri', 'as' => 'keputusannegeri.'], function () {
            Route::get('/', 'Kru\Kru01\KeputusanNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\KeputusanNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\KeputusanNegeriController@update')->name('update');
        });
        //Terimaan KPN Lama - KDP
        // Route::group(['prefix' => 'terimaankpnlama', 'as' => 'terimaankpnlama.'], function () {
        // 	Route::get('/', 'Kru\Kru01\TerimaanKPNLamaController@index')->name('index');
        // 	Route::get('/{id}/show', 'Kru\Kru01\TerimaanKPNLamaController@show')->name('show');
        // 	Route::post('/{id}/update', 'Kru\Kru01\TerimaanKPNLamaController@update')->name('update');
        // });
        //Terimaan Bayaran - FA(D)
        Route::group(['prefix' => 'terimaanbayaran', 'as' => 'terimaanbayaran.'], function () {
            Route::get('/', 'Kru\Kru01\TerimaanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\TerimaanBayaranController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\TerimaanBayaranController@update')->name('update');
            Route::get('/{id}/createReceipt', 'Kru\Kru01\TerimaanBayaranController@createReceipt')->name('createReceipt');
            Route::post('/{id}/storeReceipt', 'Kru\Kru01\TerimaanBayaranController@storeReceipt')->name('storeReceipt');
        });
        //Pengesahan Bayaran - KDP
        Route::group(['prefix' => 'pengesahanbayaran', 'as' => 'pengesahanbayaran.'], function () {
            Route::get('/', 'Kru\Kru01\PengesahanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\PengesahanBayaranController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru01\PengesahanBayaranController@update')->name('update');
        });
        //Cetakan Kad - KDP
        Route::group(['prefix' => 'cetakankad', 'as' => 'cetakankad.'], function () {
            Route::get('/', 'Kru\Kru01\CetakanKadController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru01\CetakanKadController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru01\CetakanKadController@showKru')->name('showKru');
            Route::post('/{id}/checkPin', 'Kru\Kru01\CetakanKadController@checkPin')->name('checkPin');
            Route::get('/{id}/createSSD', 'Kru\Kru01\CetakanKadController@createSSD')->name('createSSD');
            Route::post('/{id}/updateSSD', 'Kru\Kru01\CetakanKadController@updateSSD')->name('updateSSD');
            Route::post('/{id}/updatePrinted', 'Kru\Kru01\CetakanKadController@updatePrinted')->name('updatePrinted');
            Route::get('/{id}/print', 'Kru\Kru01\CetakanKadController@print')->name('print');
            Route::post('/{id}/updateCompleted', 'Kru\Kru01\CetakanKadController@updateCompleted')->name('updateCompleted');
            // Route::post('/{id}/checkPin', 'Kru\Kru01\CetakanKadController@checkPin')->name('checkPin');
            // Route::get('/{id}/create', 'Kru\Kru01\CetakanKadController@createReceipt')->name('create');
            // Route::get('/{id}/print', 'Kru\Kru01\CetakanKadController@print')->name('print');
            // Route::post('/{id}/saveSSD', 'Kru\Kru01\CetakanKadController@saveSSD')->name('saveSSD');
        });
    });

    //KRU02 - Permohonan Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)
    Route::group(['prefix' => 'pembaharuankadpendaftarannelayan', 'as' => 'pembaharuankadpendaftarannelayan.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru02\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\PermohonanController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\PermohonanController@showKru')->name('showKru');
            Route::get('/create', 'Kru\Kru02\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru02\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru02\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru02\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru02\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editD', 'Kru\Kru02\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru02\PermohonanController@editE')->name('editE');
            // Route::get('/{id}/editEAddDoc', 'Kru\Kru02\PermohonanController@editEAddDoc')->name('editEAddDoc');
            Route::get('/{id}/editF', 'Kru\Kru02\PermohonanController@editF')->name('editF');
            Route::post('/{id}update', 'Kru\Kru02\PermohonanController@update')->name('update');
            Route::post('/{id}updateB', 'Kru\Kru02\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateC', 'Kru\Kru02\PermohonanController@updateC')->name('updateC');
            Route::post('/{id}updateD', 'Kru\Kru02\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru02\PermohonanController@updateE')->name('updateE');
            // Route::post('/{id}updateEAddDoc', 'Kru\Kru02\PermohonanController@updateEAddDoc')->name('updateEAddDoc');
            Route::post('/{id}updateF', 'Kru\Kru02\PermohonanController@updateF')->name('updateF');
            Route::delete('/{id}', 'Kru\Kru02\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru02\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\SemakanDaerahController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\SemakanDaerahController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru02\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru02\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\KeputusanDaerahController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\KeputusanDaerahController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru02\KeputusanDaerahController@update')->name('update');
        });
        //Terimaan Bayaran - FA(D)
        Route::group(['prefix' => 'terimaanbayaran', 'as' => 'terimaanbayaran.'], function () {
            Route::get('/', 'Kru\Kru02\TerimaanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\TerimaanBayaranController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\TerimaanBayaranController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru02\TerimaanBayaranController@update')->name('update');
            Route::get('/{id}/createReceipt', 'Kru\Kru02\TerimaanBayaranController@createReceipt')->name('createReceipt');
            Route::post('/{id}/storeReceipt', 'Kru\Kru02\TerimaanBayaranController@storeReceipt')->name('storeReceipt');
        });
        //Pengesahan Bayaran - KDP
        Route::group(['prefix' => 'pengesahanbayaran', 'as' => 'pengesahanbayaran.'], function () {
            Route::get('/', 'Kru\Kru02\PengesahanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\PengesahanBayaranController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\PengesahanBayaranController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru02\PengesahanBayaranController@update')->name('update');
        });
        //Cetakan Kad - KDP
        Route::group(['prefix' => 'cetakankad', 'as' => 'cetakankad.'], function () {
            Route::get('/', 'Kru\Kru02\CetakanKadController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru02\CetakanKadController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru02\CetakanKadController@showKru')->name('showKru');
            Route::post('/{id}/checkPin', 'Kru\Kru02\CetakanKadController@checkPin')->name('checkPin');
            Route::get('/{id}/createSSD', 'Kru\Kru02\CetakanKadController@createSSD')->name('createSSD');
            Route::post('/{id}/updateSSD', 'Kru\Kru02\CetakanKadController@updateSSD')->name('updateSSD');
            Route::post('/{id}/updatePrinted', 'Kru\Kru02\CetakanKadController@updatePrinted')->name('updatePrinted');
            Route::get('/{id}/print', 'Kru\Kru02\CetakanKadController@print')->name('print');
            Route::post('/{id}/updateCompleted', 'Kru\Kru02\CetakanKadController@updateCompleted')->name('updateCompleted');
        });
    });

    //KRU03 - Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)
    Route::group(['prefix' => 'gantiankadpendaftarannelayan', 'as' => 'gantiankadpendaftarannelayan.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru03\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\PermohonanController@show')->name('show');
            Route::get('/create', 'Kru\Kru03\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru03\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru03\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru03\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru03\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editD', 'Kru\Kru03\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru03\PermohonanController@editE')->name('editE');
            Route::post('/{id}update', 'Kru\Kru03\PermohonanController@update')->name('update');
            Route::post('/{id}updateD', 'Kru\Kru03\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru03\PermohonanController@updateE')->name('updateE');
            // Route::delete('/{id}', 'Kru\Kru01\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru03\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru03\SemakanDaerahController@update')->name('update');
        });
        //Sokongan Daerah - KDP
        Route::group(['prefix' => 'sokongandaerah', 'as' => 'sokongandaerah.'], function () {
            Route::get('/', 'Kru\Kru03\SokonganDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\SokonganDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru03\SokonganDaerahController@update')->name('update');
        });
        // //Sokongan Wilayah - PPW
        // Route::group(['prefix' => 'sokonganwilayah', 'as' => 'sokonganwilayah.'], function () {
        // 	Route::get('/', 'Kru\Kru01\SokonganWilayahController@index')->name('index');
        // 	Route::get('/{id}/show', 'Kru\Kru01\SokonganWilayahController@show')->name('show');
        // 	Route::post('/{id}/update', 'Kru\Kru01\SokonganWilayahController@update')->name('update');
        // });
        //Semakan Negeri - FA(N)
        Route::group(['prefix' => 'semakannegeri', 'as' => 'semakannegeri.'], function () {
            Route::get('/', 'Kru\Kru03\SemakanNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\SemakanNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru03\SemakanNegeriController@update')->name('update');
        });
        //Sokongan Negeri - KCSPT(N)
        Route::group(['prefix' => 'sokongannegeri', 'as' => 'sokongannegeri.'], function () {
            Route::get('/', 'Kru\Kru03\SokonganNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\SokonganNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru03\SokonganNegeriController@update')->name('update');
        });
        //Keputusan Negeri - PPN/JPLS
        Route::group(['prefix' => 'keputusannegeri', 'as' => 'keputusannegeri.'], function () {
            Route::get('/', 'Kru\Kru03\KeputusanNegeriController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\KeputusanNegeriController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru03\KeputusanNegeriController@update')->name('update');
        });
        //Terimaan Bayaran - FA(D)
        Route::group(['prefix' => 'terimaanbayaran', 'as' => 'terimaanbayaran.'], function () {
            Route::get('/', 'Kru\Kru03\TerimaanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\TerimaanBayaranController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru03\TerimaanBayaranController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru03\TerimaanBayaranController@update')->name('update');
            Route::get('/{id}/createReceipt', 'Kru\Kru03\TerimaanBayaranController@createReceipt')->name('createReceipt');
            Route::post('/{id}/storeReceipt', 'Kru\Kru03\TerimaanBayaranController@storeReceipt')->name('storeReceipt');
        });
        //Pengesahan Bayaran - KDP
        Route::group(['prefix' => 'pengesahanbayaran', 'as' => 'pengesahanbayaran.'], function () {
            Route::get('/', 'Kru\Kru03\PengesahanBayaranController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\PengesahanBayaranController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru03\PengesahanBayaranController@showKru')->name('showKru');
            Route::post('/{id}/update', 'Kru\Kru03\PengesahanBayaranController@update')->name('update');
        });
        //Cetakan Kad - KDP
        Route::group(['prefix' => 'cetakankad', 'as' => 'cetakankad.'], function () {
            Route::get('/', 'Kru\Kru03\CetakanKadController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru03\CetakanKadController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru03\CetakanKadController@showKru')->name('showKru');
            Route::post('/{id}/checkPin', 'Kru\Kru03\CetakanKadController@checkPin')->name('checkPin');
            Route::get('/{id}/createSSD', 'Kru\Kru03\CetakanKadController@createSSD')->name('createSSD');
            Route::post('/{id}/updateSSD', 'Kru\Kru03\CetakanKadController@updateSSD')->name('updateSSD');
            Route::post('/{id}/updatePrinted', 'Kru\Kru03\CetakanKadController@updatePrinted')->name('updatePrinted');
            Route::get('/{id}/print', 'Kru\Kru03\CetakanKadController@print')->name('print');
            Route::post('/{id}/updateCompleted', 'Kru\Kru03\CetakanKadController@updateCompleted')->name('updateCompleted');
        });
    });

    //KRU04 - Pembatalan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)
    Route::group(['prefix' => 'pembatalankadpendaftarannelayan', 'as' => 'pembatalankadpendaftarannelayan.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru04\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru04\PermohonanController@show')->name('show');
            Route::get('/create', 'Kru\Kru04\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru04\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru04\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru04\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru04\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editE', 'Kru\Kru04\PermohonanController@editE')->name('editE');
            Route::get('/{id}/editEAddDoc', 'Kru\Kru04\PermohonanController@editEAddDoc')->name('editEAddDoc');
            Route::get('/{id}/editF', 'Kru\Kru04\PermohonanController@editF')->name('editF');
            Route::post('/{id}update', 'Kru\Kru04\PermohonanController@update')->name('update');
            Route::post('/{id}updateF', 'Kru\Kru04\PermohonanController@updateF')->name('updateF');
            // Route::delete('/{id}', 'Kru\Kru02\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru04\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru04\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru04\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru04\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru04\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru04\KeputusanDaerahController@update')->name('update');
        });
    });

    //KRU05 - PERMOHONAN KEBENARAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN
    Route::group(['prefix' => 'kebenaranpenggunaankrubukanwarganegara', 'as' => 'kebenaranpenggunaankrubukanwarganegara.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru05\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru05\PermohonanController@show')->name('show');

            Route::get('/create', 'Kru\Kru05\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru05\PermohonanController@store')->name('store');

            Route::get('/{id}/edit', 'Kru\Kru05\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru05\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru05\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editCAddKru', 'Kru\Kru05\PermohonanController@editCAddKru')->name('editCAddKru');
            Route::get('/{id}/editD', 'Kru\Kru05\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru05\PermohonanController@editE')->name('editE');

            Route::post('/{id}updateB', 'Kru\Kru05\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateCAddKru', 'Kru\Kru05\PermohonanController@updateCAddKru')->name('updateCAddKru');
            Route::delete('/{id}/deleteKru', 'Kru\Kru05\PermohonanController@deleteKru')->name('deleteKru');
            Route::post('/{id}updateD', 'Kru\Kru05\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru05\PermohonanController@updateE')->name('updateE');

            Route::get('{id}/permissionletter.pdf', 'Kru\Kru05\PermohonanController@exportPermissionLetter')->name('exportPermissionLetter');
            // Route::delete('/{id}', 'Kru\Kru05\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru05\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru05\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru05\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru05\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru05\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru05\KeputusanDaerahController@update')->name('update');
        });
    });

    //Kru06 - PERMOHONAN KEBENARAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN
    Route::group(['prefix' => 'kelulusanpenggunaankrubukanwarganegara', 'as' => 'kelulusanpenggunaankrubukanwarganegara.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru06\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru06\PermohonanController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru06\PermohonanController@showKru')->name('showKru');
            Route::get('/create', 'Kru\Kru06\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru06\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru06\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru06\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru06\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editCAddKru', 'Kru\Kru06\PermohonanController@editCAddKru')->name('editCAddKru');
            Route::get('/{id}/editD', 'Kru\Kru06\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru06\PermohonanController@editE')->name('editE');
            Route::post('/{id}update', 'Kru\Kru06\PermohonanController@update')->name('update');
            Route::post('/{id}updateB', 'Kru\Kru06\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateC', 'Kru\Kru06\PermohonanController@updateC')->name('updateC');
            Route::post('/{id}updateCAddKru', 'Kru\Kru06\PermohonanController@updateCAddKru')->name('updateCAddKru');
            Route::delete('/{id}/deleteKru', 'Kru\Kru06\PermohonanController@deleteKru')->name('deleteKru');
            Route::post('/{id}updateD', 'Kru\Kru06\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru06\PermohonanController@updateE')->name('updateE');

            Route::get('{id}/approvalletter.pdf', 'Kru\Kru06\PermohonanController@exportApprovalLetter')->name('exportApprovalLetter');
            // Route::delete('/{id}', 'Kru\Kru06\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru06\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru06\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru06\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru06\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru06\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru06\KeputusanDaerahController@update')->name('update');
        });
    });

    //KRU07 - PERMOHONAN KEBENARAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN
    Route::group(['prefix' => 'pembaharuanpenggunaankrubukanwarganegara', 'as' => 'pembaharuanpenggunaankrubukanwarganegara.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru07\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru07\PermohonanController@show')->name('show');

            Route::get('/create', 'Kru\Kru07\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru07\PermohonanController@store')->name('store');

            Route::get('/{id}/edit', 'Kru\Kru07\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru07\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru07\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editCAddKru', 'Kru\Kru07\PermohonanController@editCAddKru')->name('editCAddKru');
            Route::get('/{id}/editD', 'Kru\Kru07\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru07\PermohonanController@editE')->name('editE');

            Route::post('/{id}update', 'Kru\Kru07\PermohonanController@update')->name('update');
            Route::post('/{id}updateB', 'Kru\Kru07\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateC', 'Kru\Kru07\PermohonanController@updateC')->name('updateC');
            Route::post('/{id}updateCAddKru', 'Kru\Kru07\PermohonanController@updateCAddKru')->name('updateCAddKru');
            Route::delete('/{id}/deleteKru', 'Kru\Kru07\PermohonanController@deleteKru')->name('deleteKru');
            Route::post('/{id}updateD', 'Kru\Kru07\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru07\PermohonanController@updateE')->name('updateE');

            Route::get('{id}/permissionletter.pdf', 'Kru\Kru07\PermohonanController@exportPermissionLetter')->name('exportPermissionLetter');
            // Route::delete('/{id}', 'Kru\Kru07\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru07\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru07\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru07\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru07\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru07\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru07\KeputusanDaerahController@update')->name('update');
        });
    });

    //Kru08 - PERMOHONAN PEMBATALAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN
    Route::group(['prefix' => 'pembatalanpenggunaankrubukanwarganegara', 'as' => 'pembatalanpenggunaankrubukanwarganegara.'], function () {
        //Permohonan - Pemohon
        Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
            Route::get('/', 'Kru\Kru08\PermohonanController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru08\PermohonanController@show')->name('show');
            Route::get('/{id}/showKru', 'Kru\Kru08\PermohonanController@showKru')->name('showKru');
            Route::get('/create', 'Kru\Kru08\PermohonanController@create')->name('create');
            Route::post('/store', 'Kru\Kru08\PermohonanController@store')->name('store');
            Route::get('/{id}/edit', 'Kru\Kru08\PermohonanController@edit')->name('edit');
            Route::get('/{id}/editB', 'Kru\Kru08\PermohonanController@editB')->name('editB');
            Route::get('/{id}/editC', 'Kru\Kru08\PermohonanController@editC')->name('editC');
            Route::get('/{id}/editCAddKru', 'Kru\Kru08\PermohonanController@editCAddKru')->name('editCAddKru');
            Route::get('/{id}/editD', 'Kru\Kru08\PermohonanController@editD')->name('editD');
            Route::get('/{id}/editE', 'Kru\Kru08\PermohonanController@editE')->name('editE');
            Route::post('/{id}update', 'Kru\Kru08\PermohonanController@update')->name('update');
            Route::post('/{id}updateB', 'Kru\Kru08\PermohonanController@updateB')->name('updateB');
            Route::post('/{id}updateC', 'Kru\Kru08\PermohonanController@updateC')->name('updateC');
            Route::post('/{id}updateCAddKru', 'Kru\Kru08\PermohonanController@updateCAddKru')->name('updateCAddKru');
            Route::delete('/{id}/deleteKru', 'Kru\Kru08\PermohonanController@deleteKru')->name('deleteKru');
            Route::post('/{id}updateD', 'Kru\Kru08\PermohonanController@updateD')->name('updateD');
            Route::post('/{id}updateE', 'Kru\Kru08\PermohonanController@updateE')->name('updateE');

            Route::get('{id}/permissionletter.pdf', 'Kru\Kru08\PermohonanController@exportPermissionLetter')->name('exportPermissionLetter');
            // Route::delete('/{id}', 'Kru\Kru08\PermohonanController@destroy')->name('delete');
        });
        //Semakan Daerah - FA(D)
        Route::group(['prefix' => 'semakandaerah', 'as' => 'semakandaerah.'], function () {
            Route::get('/', 'Kru\Kru08\SemakanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru08\SemakanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru08\SemakanDaerahController@update')->name('update');
        });
        //Keputusan Daerah - KDP
        Route::group(['prefix' => 'keputusandaerah', 'as' => 'keputusandaerah.'], function () {
            Route::get('/', 'Kru\Kru08\KeputusanDaerahController@index')->name('index');
            Route::get('/{id}/show', 'Kru\Kru08\KeputusanDaerahController@show')->name('show');
            Route::post('/{id}/update', 'Kru\Kru08\KeputusanDaerahController@update')->name('update');
        });
    });

    //Hebahan
    Route::group(['prefix' => 'hebahan', 'as' => 'hebahan.'], function () {

        //Kemasukan Hebahan
        Route::group(['prefix' => 'hebahanlist', 'as' => 'hebahanlist.'], function () {
            Route::get('/', 'Systems\HebahanController@index')->name('index');
            Route::get('/create', 'Systems\HebahanController@create')->name('create');
            Route::post('/store', 'Systems\HebahanController@store')->name('store');
            Route::get('/{id}/edit', 'Systems\HebahanController@edit')->name('edit');
            Route::post('/{id}update', 'Systems\HebahanController@update')->name('update');
            Route::delete('/{id}', 'Systems\HebahanController@destroy')->name('delete');
        });

        //Kelulusan Hebahan
        Route::group(['prefix' => 'hebahanapprovelist', 'as' => 'hebahanapprovelist.'], function () {
            Route::get('/', 'Systems\HebahanApproveController@index')->name('index');
            Route::get('/create', 'Systems\HebahanApproveController@create')->name('create');
            Route::post('/store', 'Systems\HebahanApproveController@store')->name('store');
            Route::get('/{id}/edit', 'Systems\HebahanApproveController@edit')->name('edit');
            Route::get('/{id}/editApprove', 'Systems\HebahanApproveController@editApprove')->name('editApprove');
            Route::get('/{id}/editReject', 'Systems\HebahanApproveController@editReject')->name('editReject');
            Route::post('/{id}update', 'Systems\HebahanApproveController@update')->name('update');
            Route::post('/{id}updateApprove', 'Systems\HebahanApproveController@updateApprove')->name('updateApprove');
            Route::post('/{id}updateReject', 'Systems\HebahanApproveController@updateReject')->name('updateReject');
            Route::delete('/{id}', 'Systems\HebahanApproveController@destroy')->name('delete');
        });
    });

    //Modul Pentadbir
    Route::group(['prefix' => 'administration', 'as' => 'administration.'], function () {

        //Pengumuman
        Route::group(['prefix' => 'announcement', 'as' => 'announcement.'], function () {
            Route::get('/', 'Systems\AnnouncementController@index')->name('index');
            Route::get('/create', 'Systems\AnnouncementController@create')->name('create');
            Route::post('/store', 'Systems\AnnouncementController@store')->name('store');
            Route::get('/{id}/edit', 'Systems\AnnouncementController@edit')->name('edit');
            Route::post('/{id}update', 'Systems\AnnouncementController@update')->name('update');
            Route::delete('/{id}', 'Systems\AnnouncementController@destroy')->name('delete');
            Route::get('/{id}/downloadDoc', 'Systems\AnnouncementController@downloadDoc')->name('downloadDoc');
        });

        //Pekeliling
        Route::group(['prefix' => 'pekeliling', 'as' => 'pekeliling.'], function () {
            Route::get('/', 'Systems\PekelilingController@index')->name('index');
            Route::get('/create', 'Systems\PekelilingController@create')->name('create');
            Route::post('/store', 'Systems\PekelilingController@store')->name('store');
            Route::get('/{id}/edit', 'Systems\PekelilingController@edit')->name('edit');
            Route::post('/{id}update', 'Systems\PekelilingController@update')->name('update');
            Route::delete('/{id}', 'Systems\PekelilingController@destroy')->name('delete');
            Route::get('/{id}/downloadDoc', 'Systems\PekelilingController@downloadDoc')->name('downloadDoc');
        });

        Route::resource('/roles', 'Auth\RoleController');
        Route::resource('/users', 'UserController');
        Route::resource('/audit-logs', 'Systems\AuditLogController')->only(['index', 'show']);

        Route::group(['prefix' => 'caches', 'as' => 'caches.'], function () {
            Route::get('/', 'Systems\CacheController@index')->name('index');
            Route::post('/clear-all', 'Systems\CacheController@clearAll')->name('clear.all');
            Route::post('/clear', 'Systems\CacheController@clear')->name('clear');
            Route::post('/clear-config', 'Systems\CacheController@clearConfig')->name('clear.config');
            Route::post('/clear-event', 'Systems\CacheController@clearEvent')->name('clear.event');
            Route::post('/clear-bootstrap', 'Systems\CacheController@clearBootstrap')->name('clear.bootstrap');
            Route::post('/clear-route', 'Systems\CacheController@clearRoute')->name('clear.route');
            Route::post('/clear-view', 'Systems\CacheController@clearView')->name('clear.view');
        });

        Route::group(['prefix' => 'download'], function () {
            Route::get('/users.xlsx', 'UserController@exportExcel')->name('users.export.excel');
            Route::get('/users.pdf', 'UserController@exportPdf')->name('users.export.pdf');
        });
    });

    Route::group(['prefix' => 'application', 'as' => 'application.'], function () {
        Route::get('/', 'ApplicationController@index')->name('index');
        Route::get('/form', 'ApplicationController@form')->name('form');
        Route::get('/formlist', 'ApplicationController@formlist')->name('formlist');
        Route::get('/{id}/update', 'ApplicationController@update')->name('update');
    });

    //Modul Aduan
    Route::group(['prefix' => 'complaint2', 'as' => 'complaint2.'], function () {
        Route::get('/', 'Complaint2Controller@index')->name('index');
        Route::get('/complaintlist', 'Complaint2Controller@complaintlist')->name('complaintlist');
        Route::get('/{id}/complaintview', 'Complaint2Controller@complaintview')->name('complaintview');
        Route::get('/{id}/editAssign', 'Complaint2Controller@editAssign')->name('editAssign');
        Route::get('/{id}/editSolve', 'Complaint2Controller@editSolve')->name('editSolve');
        Route::post('/{id}/updateAssign', 'Complaint2Controller@updateAssign')->name('updateAssign');
        Route::post('/{id}/updateSolve', 'Complaint2Controller@updateSolve')->name('updateSolve');
        Route::get('/{id}/downloadDoc', 'Complaint2Controller@downloadDoc')->name('downloadDoc');
    });

    Route::group(['prefix' => 'master-data', 'as' => 'master-data.'], function () {

        Route::group(['prefix' => 'states', 'as' => 'states.'], function () {
            Route::get('/', 'MasterData\StateController@index')->name('index');
            Route::get('/add', 'MasterData\StateController@create')->name('create');
            Route::post('/', 'MasterData\StateController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\StateController@edit')->name('edit');
            Route::put('/{id}', 'MasterData\StateController@update')->name('update');
            Route::delete('/{id}', 'MasterData\StateController@destroy')->name('delete');
        });

        Route::group(['prefix' => 'districts', 'as' => 'districts.'], function () {
            Route::get('/', 'MasterData\DistrictController@index')->name('index');
            Route::get('/add', 'MasterData\DistrictController@create')->name('create');
            Route::post('/', 'MasterData\DistrictController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\DistrictController@edit')->name('edit');
            Route::put('/{id}', 'MasterData\DistrictController@update')->name('update');
            Route::delete('/{id}', 'MasterData\DistrictController@destroy')->name('delete');
        });

        Route::group(['prefix' => 'aduns', 'as' => 'aduns.'], function () {
            Route::get('/', 'MasterData\ParliamentSeatController@index')->name('index');
            Route::get('/add', 'MasterData\ParliamentSeatController@create')->name('create');
            Route::post('/', 'MasterData\ParliamentSeatController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\ParliamentSeatController@edit')->name('edit');
            Route::post('/{id}', 'MasterData\ParliamentSeatController@update')->name('update');
            Route::delete('/{id}', 'MasterData\ParliamentSeatController@destroy')->name('delete');
        });

        Route::group(['prefix' => 'parliaments', 'as' => 'parliaments.'], function () {
            Route::get('/', 'MasterData\ParliamentController@index')->name('index');
            Route::get('/create2', 'MasterData\ParliamentController@create2')->name('create2');
            Route::get('/{id}', 'MasterData\ParliamentController@getParliament')->name('getParliament');
            Route::get('/create', 'MasterData\ParliamentController@create')->name('create');
            Route::post('/', 'MasterData\ParliamentController@store')->name('store');
            Route::get('/{id}/edit', 'MasterData\ParliamentController@edit')->name('edit');
            Route::put('/{id}', 'MasterData\ParliamentController@update')->name('update');
            Route::delete('/{id}', 'MasterData\ParliamentController@destroy')->name('delete');
        });

        //Asyraf - Konfigurasi Lesen
        Route::group(['prefix' => 'licenses', 'as' => 'licenses.'], function () {
            Route::get('/', 'CfgLicenseController@index')->name('index');
            Route::get('/add', 'CfgLicenseController@create')->name('create');
            Route::post('/', 'CfgLicenseController@store')->name('store');
            Route::get('/{id}/edit', 'CfgLicenseController@edit')->name('edit');
            Route::post('/{id}/update', 'CfgLicenseController@update')->name('update');
            Route::delete('/{id}', 'CfgLicenseController@destroy')->name('delete');
        });


        // Faris - Jeti Pangkalan
        Route::group(['prefix' => 'jetty-base', 'as' => 'jetty-base.'], function () {
            Route::get('/', 'MasterData\JettyBaseController@index')->name('index');
            Route::get('/create', 'MasterData\JettyBaseController@create')->name('create');
            Route::get('/getDistricts/{state_id}', 'MasterData\JettyBaseController@getDistricts')->name('getDistricts');
            Route::get('/getParliaments/{state_id}', 'MasterData\JettyBaseController@getParliaments')->name('getParliaments');
            Route::get('/getDuns/{parliament_id}', 'MasterData\JettyBaseController@getDuns')->name('getDuns');
            Route::post('/store', 'MasterData\JettyBaseController@store')->name('store');
        });

        // Faris - Sungai jeti
        Route::group(['prefix' => 'river-lake', 'as' => 'river-lake.'], function () {
            Route::get('/', 'MasterData\RiverLakeController@index')->name('index');
            Route::get('/create', 'MasterData\RiverLakeController@create')->name('create');
            Route::get('/getDistricts/{state_id}', 'MasterData\RiverLakeController@getDistricts')->name('getDistricts');
            Route::post('/store', 'MasterData\RiverLakeController@store')->name('store');
        });

        // Faris - Pejabat perikanan
        Route::group(['prefix' => 'fisheries-office', 'as' => 'fisheries-office.'], function () {
            Route::get('/', 'MasterData\FisherisOfficeController@index')->name('index');
            Route::get('/create', 'MasterData\FisherisOfficeController@create')->name('create');
            Route::get('/getDistricts/{state_id}', 'MasterData\FisherisOfficeController@getDistricts')->name('getDistricts');
            Route::post('/store', 'MasterData\FisherisOfficeController@store')->name('store');
        });

        Route::get('/{slug}', 'CodeMasterController@index')->name('index');
        Route::get('/{slug}/add', 'CodeMasterController@create')->name('add');
        Route::post('/{slug}', 'CodeMasterController@store')->name('store');
        Route::get('/{slug}/{id}/edit', 'CodeMasterController@edit')->name('edit');
        Route::put('/{slug}/{id}', 'CodeMasterController@update')->name('update');
        Route::delete('/{slug}/{id}', 'CodeMasterController@destroy')->name('delete');
    });

    //tempvessel
    Route::group(['prefix' => 'tempvessel', 'as' => 'tempvessel.'], function () {
        Route::get('/', 'TempVesselController@index')->name('index');
        Route::get('/add', 'TempVesselController@create')->name('create');
        Route::post('/', 'TempVesselController@store')->name('store');
        Route::get('/{id}/edit', 'TempVesselController@edit')->name('edit');
        Route::post('/{id}/update', 'TempVesselController@update')->name('update');
        Route::delete('/{id}', 'TempVesselController@destroy')->name('delete');
    });

    //ikin - watikah_pelantikan
    Route::group(['prefix' => 'appointment', 'as' => 'appointment.'], function () {

        //Kemasukan watikah pelantikan
        Route::group(['prefix' => 'search', 'as' => 'search.'], function () {
            Route::get('/', 'Systems\AppointmentController@index')->name('index');
            Route::get('/create', 'Systems\AppointmentController@create')->name('create');
            Route::post('/store', 'Systems\AppointmentController@store')->name('store');
            Route::get('/{id}/edit2', 'Systems\AppointmentController@edit2')->name('edit2');
            Route::get('/{id}/edit3', 'Systems\AppointmentController@edit3')->name('edit3');
            Route::get('/{id}/view', 'Systems\AppointmentController@view')->name('view');
            Route::post('/{id}/update', 'Systems\AppointmentController@update')->name('update');
            Route::post('/{id}/updateappt', 'Systems\AppointmentController@updateappt')->name('updateappt');
            Route::delete('/{id}', 'Systems\AppointmentController@destroy')->name('delete');
        });

        //Kelulusan watikah pelantikan
        Route::group(['prefix' => 'approval', 'as' => 'approval.'], function () {
            Route::get('/', 'Systems\AppointmentApproveController@indexapprove')->name('indexapprove');
            Route::get('/create', 'Systems\AppointmentApproveController@create')->name('create');
            Route::post('/store', 'Systems\AppointmentApproveController@store')->name('store');
            Route::get('/{id}/edit', 'Systems\AppointmentApproveController@edit')->name('edit');
            Route::get('/{id}/editApprove', 'Systems\AppointmentApproveController@editApprove')->name('editApprove');
            Route::get('/{id}/editApprove2', 'Systems\AppointmentApproveController@edit2Approve')->name('edit2Approve');
            Route::get('/{id}/appointments.approval.pdf', 'Systems\AppointmentApproveController@exportPdf')->name('appointments.approval.export.pdf');
            Route::get('/{id}/editReject', 'Systems\AppointmentApproveController@editReject')->name('editReject');
            Route::post('/{id}update', 'Systems\AppointmentApproveController@update')->name('update');
            Route::post('/{id}updateApprove', 'Systems\AppointmentApproveController@updateApprove')->name('updateApprove');
            Route::post('/{id}updateReject', 'Systems\AppointmentApproveController@updateReject')->name('updateReject');
            Route::delete('/{id}', 'Systems\AppointmentApproveController@destroy')->name('delete');
            Route::get('/{id}/downloadDoc', 'Systems\AppointmentApproveController@downloadDoc')->name('downloadDoc');
            Route::get('/{id}/letterDownloadDoc', 'Systems\AppointmentApproveController@letterDownloadDoc')->name('letterDownloadDoc');
        });

        //Download watikah pelantikan
        Route::group(['prefix' => 'download', 'as' => 'download.'], function () {
            Route::get('/', 'Systems\AppointmentDownloadController@index')->name('index');
            Route::get('/appointments.download.pdf', 'Systems\AppointmentDownloadController@exportPdf')->name('appointments.download.export.pdf');
            Route::get('/{id}/downloadDoc', 'Systems\AppointmentDownloadController@downloadDoc')->name('downloadDoc');
        });
    });

    // Faris ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
   Route::group(['prefix' => 'lesenBaharu', 'as' => 'lesenBaharu.'], function () {

        Route::group(['prefix' => 'permohonan-01', 'as' => 'permohonan-01.'], function () {

            Route::get('/', [lesenBaharu\permohonanController::class, 'index'])->name('index');
            Route::get('/create', [lesenBaharu\permohonanController::class, 'create'])->name('create');
            Route::post('/store', [lesenBaharu\permohonanController::class, 'store'])->name('store');
            Route::post('/store_tab-4', [lesenBaharu\permohonanController::class, 'store_tab4'])->name('store_tab4');
            Route::post('/store_tab-5', [lesenBaharu\permohonanController::class, 'store_tab5'])->name('store_tab5');
            Route::post('/store_tab-6', [lesenBaharu\permohonanController::class, 'store_tab6'])->name('store_tab6');
            Route::get('/print_application', [lesenBaharu\permohonanController::class, 'printApplication'])->name('printApplication');
            Route::get('/view-temp-document', [lesenBaharu\permohonanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-equipment', [lesenBaharu\permohonanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/{id}/negative-feedback', [lesenBaharu\permohonanController::class, 'negativeFeedback'])->name('negativeFeedback');
            Route::get('/{id}/appeal-feedback', [lesenBaharu\permohonanController::class, 'appealFeedback'])->name('appealFeedback');
            Route::post('/{id}/store-appeal', [lesenBaharu\permohonanController::class, 'storeAppeal'])->name('storeAppeal');
            Route::post('/submi-negative-feedback', [lesenBaharu\permohonanController::class, 'submitNegativeFeedback'])->name('submitNegativeFeedback');
        });

        Route::group(['prefix' => 'semakanDokumen-01', 'as' => 'semakanDokumen-01.'], function () {

            Route::get('/', [lesenBaharu\semakanDokumenController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\semakanDokumenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\semakanDokumenController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\semakanDokumenController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\semakanDokumenController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\semakanDokumenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\semakanDokumenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\semakanDokumenController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'pindaLpi-01', 'as' => 'pindaLpi-01.'], function () {

            Route::get('/', [lesenBaharu\pindaTarikhController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\pindaTarikhController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\pindaTarikhController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\pindaTarikhController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\pindaTarikhController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\pindaTarikhController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\pindaTarikhController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\pindaTarikhController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'laporanLpi-01', 'as' => 'laporanLpi-01.'], function () {

            Route::get('/', [lesenBaharu\laporanLpiController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\laporanLpiController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\laporanLpiController::class, 'store'])->name('store');
            Route::post('/store-vessel-info/{id}', [lesenBaharu\laporanLpiController::class, 'storeMaklumatVesel'])->name('storeMaklumatVesel');
            Route::post('/store-engine-info/{id}', [lesenBaharu\laporanLpiController::class, 'storeMaklumatEnjin'])->name('storeMaklumatEnjin');
            Route::post('/store-safety-equipement/{id}', [lesenBaharu\laporanLpiController::class, 'storePeralatanKeselamatan'])->name('storePeralatanKeselamatan');
            Route::post('/store-inspection-info/{id}', [lesenBaharu\laporanLpiController::class, 'storePengesahanPemeriksaan'])->name('storePengesahanPemeriksaan');
            Route::post('/store-fishing-equipment/{id}', [lesenBaharu\laporanLpiController::class, 'storePeralatanMenangkapIkan'])->name('storePeralatanMenangkapIkan');
            Route::get('/view-inspection', [lesenBaharu\laporanLpiController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\laporanLpiController::class, 'viewEquipment'])->name('viewEquipment');

        });

        Route::group(['prefix' => 'sokonganUlasan-01', 'as' => 'sokonganUlasan-01.'], function () {

            Route::get('/', [lesenBaharu\sokonganUlasanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\sokonganUlasanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\sokonganUlasanController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\sokonganUlasanController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\sokonganUlasanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\sokonganUlasanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\sokonganUlasanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\sokonganUlasanController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'semakanUlasan-01', 'as' => 'semakanUlasan-01.'], function () {

            Route::get('/', [lesenBaharu\semakanUlasanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\semakanUlasanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\semakanUlasanController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\semakanUlasanController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\semakanUlasanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\semakanUlasanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\semakanUlasanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\semakanUlasanController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'sokonganUlasan-1-01', 'as' => 'sokonganUlasan-1-01.'], function () {

            Route::get('/', [lesenBaharu\sokonganUlasan2Controller::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenBaharu\sokonganUlasan2Controller::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\sokonganUlasan2Controller::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\sokonganUlasan2Controller::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\sokonganUlasan2Controller::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\sokonganUlasan2Controller::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\sokonganUlasan2Controller::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\sokonganUlasan2Controller::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'keputusan-01', 'as' => 'keputusan-01.'], function () {

            Route::get('/', [lesenBaharu\keputusanController::class, 'index'])->name('index');
            Route::get('/create/{id}', [lesenBaharu\keputusanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\keputusanController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\keputusanController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\keputusanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\keputusanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\keputusanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\keputusanController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'resitBayaran-01', 'as' => 'resitBayaran-01.'], function () {

            Route::get('/', [lesenBaharu\resitPembayaranController::class, 'index'])->name('index');
            Route::get('/create/{id}', [lesenBaharu\resitPembayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\resitPembayaranController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\resitPembayaranController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\resitPembayaranController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\resitPembayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\resitPembayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\resitPembayaranController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-receipt', [lesenBaharu\resitPembayaranController::class, 'viewReceipt'])->name('viewReceipt');
            Route::post('/submit/{id}', [lesenBaharu\resitPembayaranController::class, 'submit'])->name('submit');
        });

        Route::group(['prefix' => 'semakanBayaran-01', 'as' => 'semakanBayaran-01.'], function () {

            Route::get('/', [lesenBaharu\semakanBayaranController::class, 'index'])->name('index');
            Route::get('/create/{id}', [lesenBaharu\semakanBayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\semakanBayaranController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\semakanBayaranController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\semakanBayaranController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\semakanBayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\semakanBayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\semakanBayaranController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-receipt', [lesenBaharu\semakanBayaranController::class, 'viewReceipt'])->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-01', 'as' => 'cetakLesen-01.'], function () {

            Route::get('/', [lesenBaharu\cetakLesenController::class, 'index'])->name('index');
            Route::get('/create/{id}', [lesenBaharu\cetakLesenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenBaharu\cetakLesenController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenBaharu\cetakLesenController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenBaharu\cetakLesenController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenBaharu\cetakLesenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenBaharu\cetakLesenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenBaharu\cetakLesenController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-receipt', [lesenBaharu\cetakLesenController::class, 'viewReceipt'])->name('viewReceipt');
            Route::post('/pin_check/{id}', [lesenBaharu\cetakLesenController::class, 'semakPin'])->name('semakPin');
        });
    });

    // 

     Route::group(['prefix' => 'lesenTahunan', 'as' => 'lesenTahunan.'], function () {

        Route::group(['prefix' => 'permohonan-02', 'as' => 'permohonan-02.'], function () {

            Route::get('/', [lesenTahunan\permohonanController::class, 'index'])->name('index');
            Route::get('/create', [lesenTahunan\permohonanController::class, 'create'])->name('create');
            Route::get('/store', [lesenTahunan\permohonanController::class, 'store'])->name('store');
            Route::get('/print_application', [lesenTahunan\permohonanController::class, 'printApplication'])->name('printApplication');
            Route::get('/view-temp-document', [lesenTahunan\permohonanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-equipment', [lesenTahunan\permohonanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/{id}/negative-feedback', [lesenTahunan\permohonanController::class, 'negativeFeedback'])->name('negativeFeedback');
            Route::get('/{id}/appeal-feedback', [lesenTahunan\permohonanController::class, 'appealFeedback'])->name('appealFeedback');
            Route::post('/store-appeal', [lesenTahunan\permohonanController::class, 'storeAppeal'])->name('storeAppeal');
            Route::post('/submi-negative-feedback', [lesenTahunan\permohonanController::class, 'submitNegativeFeedback'])->name('submitNegativeFeedback');
        });

        Route::group(['prefix' => 'semakanDokumen-02', 'as' => 'semakanDokumen-02.'], function () {

            Route::get('/', [lesenTahunan\semakanDokumenController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\semakanDokumenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\semakanDokumenController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenTahunan\semakanDokumenController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\semakanDokumenController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\semakanDokumenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\semakanDokumenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\semakanDokumenController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'pindaLpi-02', 'as' => 'pindaLpi-02.'], function () {

            Route::get('/', [lesenTahunan\pindaTarikhController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\pindaTarikhController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\pindaTarikhController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenTahunan\pindaTarikhController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\pindaTarikhController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\pindaTarikhController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\pindaTarikhController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\pindaTarikhController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'laporanLpi-02', 'as' => 'laporanLpi-02.'], function () {
            Route::get('/', [lesenTahunan\laporanLpiController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\laporanLpiController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\laporanLpiController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenTahunan\laporanLpiController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\laporanLpiController::class, 'viewEquipment'])->name('viewEquipment');
            Route::post('/store-fishing-equipment/{id}', [lesenTahunan\laporanLpiController::class, 'storePeralatanMenangkapIkan'])->name('storePeralatanMenangkapIkan');
            Route::post('/store-inspection-info/{id}', [lesenTahunan\laporanLpiController::class, 'storePengesahanPemeriksaan'])->name('storePengesahanPemeriksaan');
            Route::post('/store-safety-equipment/{id}', [lesenTahunan\laporanLpiController::class, 'storePeralatanKeselamatan'])->name('storePeralatanKeselamatan');
            Route::post('/store-vesel-info/{id}', [lesenTahunan\laporanLpiController::class, 'storeMaklumatEnjin'])->name('storeMaklumatEnjin');
            Route::post('/store-engine-info/{id}', [lesenTahunan\laporanLpiController::class, 'storeMaklumatVesel'])->name('storeMaklumatVesel');
        });

        // Keputusan
        Route::group(['prefix' => 'keputusan-02', 'as' => 'keputusan-02.'], function () {

            Route::get('/', [lesenTahunan\keputusanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\keputusanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\keputusanController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenTahunan\keputusanController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\keputusanController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\keputusanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\keputusanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\keputusanController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'resitBayaran-02', 'as' => 'resitBayaran-02.'], function () {

            Route::get('/', [lesenTahunan\resitPembayaranController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\resitPembayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\resitPembayaranController::class, 'store'])->name('store');
            Route::post('/submit/{id}', [lesenTahunan\resitPembayaranController::class, 'submit'])->name('submit');
            Route::get('/view-inspection', [lesenTahunan\resitPembayaranController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\resitPembayaranController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\resitPembayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\resitPembayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\resitPembayaranController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-reciept', [lesenTahunan\resitPembayaranController::class, 'viewReceipt'])->name('viewReceipt');
        });

        Route::group(['prefix' => 'semakanBayaran-02', 'as' => 'semakanBayaran-02.'], function () {

            Route::get('/', [lesenTahunan\semakanBayaranController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\semakanBayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\semakanBayaranController::class, 'store'])->name('store');
            Route::post('/submit/{id}', [lesenTahunan\semakanBayaranController::class, 'submit'])->name('submit');
            Route::get('/view-inspection', [lesenTahunan\semakanBayaranController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\semakanBayaranController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\semakanBayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\semakanBayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\semakanBayaranController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-reciept', [lesenTahunan\semakanBayaranController::class, 'viewReceipt'])->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-02', 'as' => 'cetakLesen-02.'], function () {

            Route::get('/', [lesenTahunan\cetakLesenController::class, 'index'])->name('index');
            Route::get('/create/{id}', [lesenTahunan\cetakLesenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\cetakLesenController::class, 'store'])->name('store');
            Route::get('/view-inspection', [lesenTahunan\cetakLesenController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\cetakLesenController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\cetakLesenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\cetakLesenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [lesenTahunan\cetakLesenController::class, 'createFaultRecord'])->name('createFaultRecord');
            Route::get('/view-receipt', [lesenTahunan\cetakLesenController::class, 'viewReceipt'])->name('viewReceipt');
            Route::post('/pin_check/{id}', [lesenTahunan\cetakLesenController::class, 'semakPin'])->name('semakPin');
        });

        Route::group(['prefix' => 'sokonganUlasanR-02', 'as' => 'sokonganUlasanR-02.'], function () {

            Route::get('/', [lesenTahunan\sokonganUlasanRController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\sokonganUlasanRController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\sokonganUlasanRController::class, 'store'])->name('store');
            Route::post('/submit/{id}', [lesenTahunan\sokonganUlasanRController::class, 'submit'])->name('submit');
            Route::get('/view-inspection', [lesenTahunan\sokonganUlasanRController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\sokonganUlasanRController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\sokonganUlasanRController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\sokonganUlasanRController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'semakanUlasanR-02', 'as' => 'semakanUlasanR-02.'], function () {

            Route::get('/', [lesenTahunan\semakanUlasanRController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\semakanUlasanRController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\semakanUlasanRController::class, 'store'])->name('store');
            Route::post('/submit/{id}', [lesenTahunan\semakanUlasanRController::class, 'submit'])->name('submit');
            Route::get('/view-inspection', [lesenTahunan\semakanUlasanRController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\semakanUlasanRController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\semakanUlasanRController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\semakanUlasanRController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        // Keputusan
        Route::group(['prefix' => 'keputusanR-02', 'as' => 'keputusanR-02.'], function () {

            Route::get('/', [lesenTahunan\keputusanRController::class, 'index'])->name('index');
            Route::get('/{id}/create', [lesenTahunan\keputusanRController::class, 'create'])->name('create');
            Route::post('/store/{id}', [lesenTahunan\keputusanRController::class, 'store'])->name('store');
            Route::post('/submit/{id}', [lesenTahunan\keputusanRController::class, 'submit'])->name('submit');
            Route::get('/view-inspection', [lesenTahunan\keputusanRController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [lesenTahunan\keputusanRController::class, 'viewEquipment'])->name('viewEquipment');
            Route::get('/view-temp-document', [lesenTahunan\keputusanRController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [lesenTahunan\keputusanRController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });
    });

    // 

    Route::group(['prefix' => 'pindahPangkalan', 'as' => 'pindahPangkalan.'], function () {

        Route::group(['prefix' => 'permohonan-03', 'as' => 'permohonan-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\pindahPangkalan\permohonanController@create')->name('create');
            Route::get('/create2', 'NelayanDarat\pindahPangkalan\permohonanController@create2')->name('create2');
            Route::post('/store', 'NelayanDarat\pindahPangkalan\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\pindahPangkalan\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab3', 'NelayanDarat\pindahPangkalan\permohonanController@store_tab3')->name('store_tab3');
            Route::post('/store_tab6', 'NelayanDarat\pindahPangkalan\permohonanController@store_tab6')->name('store_tab6');
            Route::get('/{id}/negativeFeedback', 'NelayanDarat\pindahPangkalan\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/{id}/appealFeedback', 'NelayanDarat\pindahPangkalan\permohonanController@appealFeedback')->name('appealFeedback');

            Route::get('/viewEquipmentFile', 'NelayanDarat\pindahPangkalan\permohonanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\permohonanController@viewDocument')->name('viewDocument');

            Route::get('/get-districts/{stateId}', 'NelayanDarat\pindahPangkalan\permohonanController@getDistricts')->name('getDistricts');
            Route::get('/get-jetty-river/{districtId}', 'NelayanDarat\pindahPangkalan\permohonanController@getJettyAndRiver')->name('getJettyAndRiver');
        });

        Route::group(['prefix' => 'semakanDokumen-03', 'as' => 'semakanDokumen-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\semakanDokumenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'pindaLpi-03', 'as' => 'pindaLpi-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\pindaTarikhController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        // Laporan LPI
        Route::group(['prefix' => 'laporanLpi-03', 'as' => 'laporanLpi-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\pindahPangkalan\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\pindahPangkalan\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\pindahPangkalan\laporanLpiController@viewEquipmentFile')->name('viewEquipmentFile');
        });

        Route::group(['prefix' => 'sokonganUlasan-03', 'as' => 'sokonganUlasan-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'semakanUlasan-03', 'as' => 'semakanUlasan-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\semakanUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\semakanUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\semakanUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\semakanUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\pindahPangkalan\semakanUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\semakanUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\semakanUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\semakanUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'sokonganUlasan-1-03', 'as' => 'sokonganUlasan-1-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\sokonganUlasan2Controller@viewFaultDocument')->name('viewFaultDocument');
        });
        // Keputusan
        Route::group(['prefix' => 'keputusan-03', 'as' => 'keputusan-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\keputusanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\pindahPangkalan\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\keputusanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaran-03', 'as' => 'resitBayaran-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\resitPembayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\resitPembayaranController@store')->name('store');
            Route::post('/saveReceiptData/{application}', 'NelayanDarat\pindahPangkalan\resitPembayaranController@saveReceiptData')->name('saveReceiptData');
            Route::post('/submit/{id}', 'NelayanDarat\pindahPangkalan\resitPembayaranController@submit')->name('submit');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\resitPembayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\resitPembayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'semakanBayaran-03', 'as' => 'semakanBayaran-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\semakanBayaranController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-03', 'as' => 'cetakLesen-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\pindahPangkalan\cetakLesenController@semakPin')->name('semakPin');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'keputusanBaru-03', 'as' => 'keputusanBaru-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\keputusanBaruController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\keputusanBaruController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\keputusanBaruController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\pindahPangkalan\keputusanBaruController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\pindahPangkalan\keputusanBaruController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\keputusanBaruController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\keputusanBaruController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\keputusanBaruController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaranBaru-03', 'as' => 'resitBayaranBaru-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@store')->name('store');
            Route::post('/saveReceiptData/{application}', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@saveReceiptData')->name('saveReceiptData');
            Route::post('/submit/{id}', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@submit')->name('submit');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\resitPembayaranBaruController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'semakanBayaranBaru-03', 'as' => 'semakanBayaranBaru-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@store')->name('store');
            Route::get('/fetchData/{id}', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@fetchData')->name('fetchData');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\semakanBayaranBaruController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesenBaru-03', 'as' => 'cetakLesenBaru-03.'], function () {
            Route::get('/', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@semakPin')->name('semakPin');
            Route::get('/viewInspectionDocument', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\pindahPangkalan\cetakLesenBaruController@viewReceipt')->name('viewReceipt');
        });
    });

    // 

    Route::group(['prefix' => 'tukarPeralatan', 'as' => 'tukarPeralatan.'], function () {

        Route::group(['prefix' => 'permohonan-04', 'as' => 'permohonan-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\tukarPeralatan\permohonanController@create')->name('create');
            Route::post('/store', 'NelayanDarat\tukarPeralatan\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\tukarPeralatan\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab4', 'NelayanDarat\tukarPeralatan\permohonanController@store_tab4')->name('store_tab4');
            Route::post('/store_tab6', 'NelayanDarat\tukarPeralatan\permohonanController@store_tab6')->name('store_tab6');

            Route::get('/negativeFeedback', 'NelayanDarat\tukarPeralatan\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/appealFeedback', 'NelayanDarat\tukarPeralatan\permohonanController@appealFeedback')->name('appealFeedback');

            Route::get('/viewOffEquipment', 'NelayanDarat\tukarPeralatan\permohonanController@viewOffEquipment')->name('viewOffEquipment');
            Route::get('/viewTempEquipment', 'NelayanDarat\tukarPeralatan\permohonanController@viewTempEquipment')->name('viewTempEquipment');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\permohonanController@viewDocument')->name('viewDocument');
        });

        Route::group(['prefix' => 'semakanDokumen-04', 'as' => 'semakanDokumen-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\semakanDokumenController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'pindaLpi-04', 'as' => 'pindaLpi-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\pindaTarikhController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'laporanLpi-04', 'as' => 'laporanLpi-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\tukarPeralatan\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\tukarPeralatan\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\laporanLpiController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewFile/{id}/{field}', 'NelayanDarat\tukarPeralatan\laporanLpiController@viewFile')->name('viewFile');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusan-04', 'as' => 'keputusan-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\keputusanController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\keputusanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaran-04', 'as' => 'resitBayaran-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\resitPembayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\resitPembayaranController@store')->name('store');
            Route::post('/submit/{id}', 'NelayanDarat\tukarPeralatan\resitPembayaranController@submit')->name('submit');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\resitPembayaranController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewOffEquipment', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewOffEquipment')->name('viewOffEquipment');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarPeralatan\resitPembayaranController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        Route::group(['prefix' => 'semakanBayaran-04', 'as' => 'semakanBayaran-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\semakanBayaranController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\semakanBayaranController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\semakanBayaranController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarPeralatan\semakanBayaranController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        //Cetak Lesen
        Route::group(['prefix' => 'cetakLesen-04', 'as' => 'cetakLesen-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\tukarPeralatan\cetakLesenController@semakPin')->name('semakPin');
            Route::post('/updateFault', 'NelayanDarat\tukarPeralatan\cetakLesenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\cetakLesenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarPeralatan\cetakLesenController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarPeralatan\cetakLesenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarPeralatan\cetakLesenController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarPeralatan\cetakLesenController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        Route::group(['prefix' => 'sokonganUlasanR-04', 'as' => 'sokonganUlasanR-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\sokonganUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\sokonganUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\sokonganUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarPeralatan\sokonganUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\sokonganUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'semakanUlasanR-04', 'as' => 'semakanUlasanR-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\semakanUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\semakanUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\semakanUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarPeralatan\semakanUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\semakanUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusanR-04', 'as' => 'keputusanR-04.'], function () {
            Route::get('/', 'NelayanDarat\tukarPeralatan\keputusanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarPeralatan\keputusanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarPeralatan\keputusanRController@store')->name('store');
            Route::get('/fetchData/{id}', 'NelayanDarat\tukarPeralatan\keputusanRController@fetchData')->name('fetchData');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarPeralatan\keputusanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarPeralatan\keputusanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });
    });

    // 

    Route::group(['prefix' => 'tukarEnjin', 'as' => 'tukarEnjin.'], function () {

        Route::group(['prefix' => 'permohonan-05', 'as' => 'permohonan-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\tukarEnjin\permohonanController@create')->name('create');
            Route::post('/store', 'NelayanDarat\tukarEnjin\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\tukarEnjin\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab5', 'NelayanDarat\tukarEnjin\permohonanController@store_tab5')->name('store_tab5');
            Route::post('/store_tab6', 'NelayanDarat\tukarEnjin\permohonanController@store_tab6')->name('store_tab6');
            Route::get('/negativeFeedback', 'NelayanDarat\tukarEnjin\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/appealFeedback', 'NelayanDarat\tukarEnjin\permohonanController@appealFeedback')->name('appealFeedback');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\permohonanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\permohonanController@viewDocument')->name('viewDocument');
        });

        Route::group(['prefix' => 'semakanDokumen-05', 'as' => 'semakanDokumen-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\semakanDokumenController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        // //Pinda LPI
        Route::group(['prefix' => 'pindaLpi-05', 'as' => 'pindaLpi-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\pindaTarikhController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'laporanLpi-05', 'as' => 'laporanLpi-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\tukarEnjin\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\tukarEnjin\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/viewEquipment', 'NelayanDarat\tukarEnjin\laporanLpiController@viewEquipment')->name('viewEquipment');
            Route::get('/viewFile/{id}/{field}', 'NelayanDarat\tukarEnjin\laporanLpiController@viewFile')->name('viewFile');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusan-05', 'as' => 'keputusan-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\keputusanController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\keputusanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaran-05', 'as' => 'resitBayaran-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\resitPembayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\resitPembayaranController@store')->name('store');
            Route::post('/submit/{id}', 'NelayanDarat\tukarEnjin\resitPembayaranController@submit')->name('submit');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\resitPembayaranController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewReceipt', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewReceipt')->name('viewReceipt');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarEnjin\resitPembayaranController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        Route::group(['prefix' => 'semakanBayaran-05', 'as' => 'semakanBayaran-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\semakanBayaranController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\semakanBayaranController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\semakanBayaranController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarEnjin\semakanBayaranController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        Route::group(['prefix' => 'cetakLesen-05', 'as' => 'cetakLesen-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\tukarEnjin\cetakLesenController@semakPin')->name('semakPin');
            Route::post('/updateFault', 'NelayanDarat\tukarEnjin\cetakLesenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\cetakLesenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\tukarEnjin\cetakLesenController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\tukarEnjin\cetakLesenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\tukarEnjin\cetakLesenController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceiptDocument', 'NelayanDarat\tukarEnjin\cetakLesenController@viewReceiptDocument')->name('viewReceiptDocument');
        });

        Route::group(['prefix' => 'sokonganUlasanR-05', 'as' => 'sokonganUlasanR-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@store')->name('store');
            Route::get('/fetchData/{id}', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@fetchData')->name('fetchData');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\sokonganUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'semakanUlasanR-05', 'as' => 'semakanUlasanR-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\semakanUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\semakanUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\semakanUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarEnjin\semakanUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\semakanUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusanR-05', 'as' => 'keputusanR-05.'], function () {
            Route::get('/', 'NelayanDarat\tukarEnjin\keputusanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\tukarEnjin\keputusanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\tukarEnjin\keputusanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\tukarEnjin\keputusanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\tukarEnjin\keputusanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });
    });

    // 

    Route::group(['prefix' => 'gantiKulit', 'as' => 'gantiKulit.'], function () {

        Route::group(['prefix' => 'permohonan-06', 'as' => 'permohonan-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\gantiKulit\permohonanController@create')->name('create');
            Route::get('/create2', 'NelayanDarat\gantiKulit\permohonanController@create2')->name('create2');
            Route::post('/store', 'NelayanDarat\gantiKulit\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\gantiKulit\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab7', 'NelayanDarat\gantiKulit\permohonanController@store_tab7')->name('store_tab7');
            Route::post('/store_tab6', 'NelayanDarat\gantiKulit\permohonanController@store_tab6')->name('store_tab6');
            Route::get('/{id}/negativeFeedback', 'NelayanDarat\gantiKulit\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/{id}/appealFeedback', 'NelayanDarat\gantiKulit\permohonanController@appealFeedback')->name('appealFeedback');
            Route::get('/viewEquipmentFile', 'NelayanDarat\gantiKulit\permohonanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\permohonanController@viewDocument')->name('viewDocument');
            Route::get('/get-districts/{stateId}', 'NelayanDarat\gantiKulit\permohonanController@getDistricts')->name('getDistricts');
            Route::get('/get-jetty-river/{districtId}', 'NelayanDarat\gantiKulit\permohonanController@getJettyAndRiver')->name('getJettyAndRiver');
        });

        Route::group(['prefix' => 'semakanDokumen-06', 'as' => 'semakanDokumen-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\gantiKulit\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\semakanDokumenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'pindaLpi-06', 'as' => 'pindaLpi-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\gantiKulit\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\pindaTarikhController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'laporanLpi-06', 'as' => 'laporanLpi-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\gantiKulit\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\gantiKulit\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\gantiKulit\laporanLpiController@viewEquipmentFile')->name('viewEquipmentFile');
        });

        Route::group(['prefix' => 'sokonganUlasan-06', 'as' => 'sokonganUlasan-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\sokonganUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\sokonganUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\sokonganUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\sokonganUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\gantiKulit\sokonganUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\sokonganUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\sokonganUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\sokonganUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'semakanUlasan-06', 'as' => 'semakanUlasan-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\semakanUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\semakanUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\semakanUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\semakanUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\gantiKulit\semakanUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\semakanUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\semakanUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\semakanUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'sokonganUlasan-1-06', 'as' => 'sokonganUlasan-1-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@store')->name('store');
            Route::get('/fetchData/{id}', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@fetchData')->name('fetchData');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\sokonganUlasan2Controller@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'keputusan-06', 'as' => 'keputusan-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\gantiKulit\keputusanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\gantiKulit\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\keputusanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'semakanBayaran-06', 'as' => 'semakanBayaran-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\semakanBayaranController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\gantiKulit\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });


        Route::group(['prefix' => 'keputusan-06', 'as' => 'keputusan-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\keputusanController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\keputusanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\keputusanController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\gantiKulit\keputusanController@viewReceipt')->name('viewReceipt');
            Route::get('/viewInspectionDisposal', 'NelayanDarat\gantiKulit\keputusanController@viewInspectionDisposal')->name('viewInspectionDisposal');
        });

        Route::group(['prefix' => 'resitBayaran-06', 'as' => 'resitBayaran-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\resitPembayaranController@create')->name('create');
            Route::post('/submit/{id}', 'NelayanDarat\gantiKulit\resitPembayaranController@submit')->name('submit');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\resitPembayaranController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\resitPembayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\resitPembayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\gantiKulit\resitPembayaranController@viewReceipt')->name('viewReceipt');
            Route::get('/viewInspectionDisposal', 'NelayanDarat\gantiKulit\resitPembayaranController@viewInspectionDisposal')->name('viewInspectionDisposal');
        });

        Route::group(['prefix' => 'cetakLesen-06', 'as' => 'cetakLesen-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\gantiKulit\cetakLesenController@semakPin')->name('semakPin');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\cetakLesenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\cetakLesenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\cetakLesenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\cetakLesenController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\gantiKulit\cetakLesenController@viewReceipt')->name('viewReceipt');
            Route::get('/viewInspectionDisposal', 'NelayanDarat\gantiKulit\cetakLesenController@viewInspectionDisposal')->name('viewInspectionDisposal');
        });

        Route::group(['prefix' => 'laporanLpiLupus-06', 'as' => 'laporanLpiLupus-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\laporanLpiLupusController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\laporanLpiLupusController@create')->name('create');
            Route::post('/store_tab1/{id}', 'NelayanDarat\gantiKulit\laporanLpiLupusController@store_tab1')->name('store_tab1');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\laporanLpiLupusController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\laporanLpiLupusController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'semakanLupus-06', 'as' => 'semakanLupus-06.'], function () {
            Route::get('/', 'NelayanDarat\gantiKulit\semakLupusController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\gantiKulit\semakLupusController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\gantiKulit\semakLupusController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\gantiKulit\semakLupusController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\gantiKulit\semakLupusController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\gantiKulit\semakLupusController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\gantiKulit\semakLupusController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\gantiKulit\semakLupusController@viewReceipt')->name('viewReceipt');
        });
    });

    // 

    Route::group(['prefix' => 'lebihTahun', 'as' => 'lebihTahun.'], function () {

        Route::group(['prefix' => 'permohonan-07', 'as' => 'permohonan-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\lebihTahun\permohonanController@create')->name('create');
            Route::post('/store', 'NelayanDarat\lebihTahun\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\lebihTahun\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab6', 'NelayanDarat\lebihTahun\permohonanController@store_tab6')->name('store_tab6');
            Route::get('/{id}/negativeFeedback', 'NelayanDarat\lebihTahun\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/{id}/appealFeedback', 'NelayanDarat\lebihTahun\permohonanController@appealFeedback')->name('appealFeedback');
            Route::get('/viewEquipmentFile', 'NelayanDarat\lebihTahun\permohonanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\permohonanController@viewDocument')->name('viewDocument');
        });

        Route::group(['prefix' => 'semakanDokumen-07', 'as' => 'semakanDokumen-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\lebihTahun\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\semakanDokumenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'pindaLpi-07', 'as' => 'pindaLpi-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\lebihTahun\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\pindaTarikhController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'laporanLpi-07', 'as' => 'laporanLpi-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\lebihTahun\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\lebihTahun\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/viewInspectionDocument', 'NelayanDarat\lebihTahun\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\kadPendaftaran\laporanLpiController@viewEquipmentFile')->name('viewEquipmentFile');
        });

        Route::group(['prefix' => 'sokonganUlasan-07', 'as' => 'sokonganUlasan-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\sokonganUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\sokonganUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\sokonganUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\sokonganUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\lebihTahun\sokonganUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\sokonganUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\sokonganUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\sokonganUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'semakanUlasan-07', 'as' => 'semakanUlasan-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\semakanUlasanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\semakanUlasanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\semakanUlasanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\semakanUlasanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\lebihTahun\semakanUlasanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\semakanUlasanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\semakanUlasanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\semakanUlasanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'sokonganUlasan-1-07', 'as' => 'sokonganUlasan-1-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\sokonganUlasan2Controller@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'keputusan-07', 'as' => 'keputusan-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\lebihTahun\keputusanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\lebihTahun\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\keputusanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaran-07', 'as' => 'resitBayaran-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\resitPembayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\resitPembayaranController@store')->name('store');
            Route::post('/saveReceiptData/{application}', 'NelayanDarat\lebihTahun\resitPembayaranController@saveReceiptData')->name('saveReceiptData');
            Route::post('/submit/{id}', 'NelayanDarat\lebihTahun\resitPembayaranController@submit')->name('submit');
            Route::get('/viewInspectionDocument', 'NelayanDarat\lebihTahun\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\resitPembayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\resitPembayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\lebihTahun\resitPembayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'semakanBayaran-07', 'as' => 'semakanBayaran-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\semakanBayaranController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\lebihTahun\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-07', 'as' => 'cetakLesen-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\lebihTahun\cetakLesenController@semakPin')->name('semakPin');
            Route::get('/viewInspectionDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\lebihTahun\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\lebihTahun\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\lebihTahun\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'sokonganUlasanR-07', 'as' => 'sokonganUlasanR-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\sokonganUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\sokonganUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\sokonganUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\lebihTahun\sokonganUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\lebihTahun\sokonganUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'semakanUlasanR-07', 'as' => 'semakanUlasanR-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\semakanUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\semakanUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\semakanUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\lebihTahun\semakanUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\lebihTahun\semakanUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusanR-07', 'as' => 'keputusanR-07.'], function () {
            Route::get('/', 'NelayanDarat\lebihTahun\keputusanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\lebihTahun\keputusanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\lebihTahun\keputusanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\lebihTahun\keputusanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\lebihTahun\keputusanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });
    });

    // 

    Route::group(['prefix' => 'kadPendaftaran', 'as' => 'kadPendaftaran.'], function () {

        Route::group(['prefix' => 'permohonan-08', 'as' => 'permohonan-08.'], function () {

            Route::get('/', [kadPendaftaran\permohonanController::class, 'index'])->name('index');
            Route::get('/create', [kadPendaftaran\permohonanController::class, 'create'])->name('create');
            Route::post('/store', [kadPendaftaran\permohonanController::class, 'store'])->name('store');
            Route::post('/store_tab-1', [kadPendaftaran\permohonanController::class, 'store_tab1'])->name('store_tab1');
            Route::post('/store_tab-2', [kadPendaftaran\permohonanController::class, 'store_tab2'])->name('store_tab2');
            Route::post('/store_tab-3', [kadPendaftaran\permohonanController::class, 'store_tab3'])->name('store_tab3');
            Route::post('/store_tab-4', [kadPendaftaran\permohonanController::class, 'store_tab4'])->name('store_tab4');
            Route::post('/store_tab-5', [kadPendaftaran\permohonanController::class, 'store_tab5'])->name('store_tab5');
            Route::post('/store_tab-6', [kadPendaftaran\permohonanController::class, 'store_tab6'])->name('store_tab6');
            Route::post('/store_tab-7', [kadPendaftaran\permohonanController::class, 'store_tab7'])->name('store_tab7');
            Route::get('/print_application', [kadPendaftaran\permohonanController::class, 'printApplication'])->name('printApplication');
            Route::get('/view-temp-document', [kadPendaftaran\permohonanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-equipment', [kadPendaftaran\permohonanController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/{id}/negative-feedback', [kadPendaftaran\permohonanController::class, 'negativeFeedback'])->name('negativeFeedback');
            Route::get('/{id}/appeal-feedback', [kadPendaftaran\permohonanController::class, 'appealFeedback'])->name('appealFeedback');
            Route::post('/{id}/store-appeal', [kadPendaftaran\permohonanController::class, 'storeAppeal'])->name('storeAppeal');
            Route::post('/submi-negative-feedback', [kadPendaftaran\permohonanController::class, 'submitNegativeFeedback'])->name('submitNegativeFeedback');
            Route::get('/getDistricts/{state_id}', [kadPendaftaran\permohonanController::class, 'getDistricts'])->name('getDistricts');
            Route::get('/getJetties/{district_id}', [kadPendaftaran\permohonanController::class, 'getJetties'])->name('getJetties');
            Route::get('/getRivers/{district_id}', [kadPendaftaran\permohonanController::class, 'getRivers'])->name('getRivers');
        });

        Route::group(['prefix' => 'semakanDokumen-08', 'as' => 'semakanDokumen-08.'], function () {

            Route::get('/', [kadPendaftaran\semakanDokumenController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\semakanDokumenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\semakanDokumenController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\semakanDokumenController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\semakanDokumenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\semakanDokumenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/create-fault-record', [kadPendaftaran\semakanDokumenController::class, 'createFaultRecord'])->name('createFaultRecord');
        });

        Route::group(['prefix' => 'pindaLpi-08', 'as' => 'pindaLpi-08.'], function () {

            Route::get('/', [kadPendaftaran\pindaTarikhController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\pindaTarikhController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\pindaTarikhController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\pindaTarikhController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\pindaTarikhController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\pindaTarikhController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'laporanLpi-08', 'as' => 'laporanLpi-08.'], function () {

            Route::get('/', [kadPendaftaran\laporanLpiController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\laporanLpiController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\laporanLpiController::class, 'store'])->name('store');
            Route::get('/view-inspection', [kadPendaftaran\laporanLpiController::class, 'viewInspection'])->name('viewInspection');
            Route::get('/view-equipment', [kadPendaftaran\laporanLpiController::class, 'viewEquipment'])->name('viewEquipment');
            Route::post('/store-fishing-equipment/{id}', [kadPendaftaran\laporanLpiController::class, 'storePeralatanMenangkapIkan'])->name('storePeralatanMenangkapIkan');
            Route::post('/store-inspection-info/{id}', [kadPendaftaran\laporanLpiController::class, 'storePengesahanPemeriksaan'])->name('storePengesahanPemeriksaan');
            Route::post('/store-safety-equipment/{id}', [kadPendaftaran\laporanLpiController::class, 'storePeralatanKeselamatan'])->name('storePeralatanKeselamatan');
            Route::post('/store-vesel-info/{id}', [kadPendaftaran\laporanLpiController::class, 'storeMaklumatEnjin'])->name('storeMaklumatEnjin');
            Route::post('/store-engine-info/{id}', [kadPendaftaran\laporanLpiController::class, 'storeMaklumatVesel'])->name('storeMaklumatVesel');
        });

        Route::group(['prefix' => 'sokonganUlasan-08', 'as' => 'sokonganUlasan-08.'], function () {

            Route::get('/', [kadPendaftaran\sokonganUlasanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\sokonganUlasanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\sokonganUlasanController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\sokonganUlasanController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\sokonganUlasanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\sokonganUlasanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'semakanUlasan-08', 'as' => 'semakanUlasan-08.'], function () {

            Route::get('/', [kadPendaftaran\semakanUlasanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\semakanUlasanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\semakanUlasanController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\semakanUlasanController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\semakanUlasanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\semakanUlasanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'sokonganUlasan-1-08', 'as' => 'sokonganUlasan-1-08.'], function () {

            Route::get('/', [kadPendaftaran\sokonganUlasan2Controller::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\sokonganUlasan2Controller::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\sokonganUlasan2Controller::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\sokonganUlasan2Controller::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\sokonganUlasan2Controller::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\sokonganUlasan2Controller::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'keputusan-08', 'as' => 'keputusan-08.'], function () {

            Route::get('/', [kadPendaftaran\keputusanController::class, 'index'])->name('index');
            Route::get('/{id}/create', [kadPendaftaran\keputusanController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\keputusanController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\keputusanController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\keputusanController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\keputusanController::class, 'viewFaultRecord'])->name('viewFaultRecord');
        });

        Route::group(['prefix' => 'resitBayaran-08', 'as' => 'resitBayaran-08.'], function () {

            Route::get('/', [kadPendaftaran\resitPembayaranController::class, 'index'])->name('index');
            Route::get('/create/{id}', [kadPendaftaran\resitPembayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\resitPembayaranController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\resitPembayaranController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\resitPembayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\resitPembayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/view-receipt', [kadPendaftaran\resitPembayaranController::class, 'viewReceipt'])->name('viewReceipt');
            Route::post('/submit/{id}', [kadPendaftaran\resitPembayaranController::class, 'submit'])->name('submit');
        });

        Route::group(['prefix' => 'semakanBayaran-08', 'as' => 'semakanBayaran-08.'], function () {

            Route::get('/', [kadPendaftaran\semakanBayaranController::class, 'index'])->name('index');
            Route::get('/create/{id}', [kadPendaftaran\semakanBayaranController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\semakanBayaranController::class, 'store'])->name('store');
            Route::get('/view-temp-equipment', [kadPendaftaran\semakanBayaranController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\semakanBayaranController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\semakanBayaranController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/view-receipt', [kadPendaftaran\semakanBayaranController::class, 'viewReceipt'])->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-08', 'as' => 'cetakLesen-08.'], function () {

            Route::get('/', [kadPendaftaran\cetakLesenController::class, 'index'])->name('index');
            Route::get('/create/{id}', [kadPendaftaran\cetakLesenController::class, 'create'])->name('create');
            Route::post('/store/{id}', [kadPendaftaran\cetakLesenController::class, 'store'])->name('store');
            Route::post('/pin-check/{id}', [kadPendaftaran\cetakLesenController::class, 'semakPin'])->name('semakPin');
            Route::get('/view-temp-equipment', [kadPendaftaran\cetakLesenController::class, 'viewTempEquipment'])->name('viewTempEquipment');
            Route::get('/view-temp-document', [kadPendaftaran\cetakLesenController::class, 'viewTempDocument'])->name('viewTempDocument');
            Route::get('/view-fault-record', [kadPendaftaran\cetakLesenController::class, 'viewFaultRecord'])->name('viewFaultRecord');
            Route::get('/view-receipt', [kadPendaftaran\cetakLesenController::class, 'viewReceipt'])->name('viewReceipt');
        });
    });

    // 

    Route::group(['prefix' => 'baharuKadNelayan', 'as' => 'baharuKadNelayan.'], function () {

        Route::group(['prefix' => 'permohonan-09', 'as' => 'permohonan-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\permohonanController@index')->name('index');
            Route::get('/create', 'NelayanDarat\baharuKadNelayan\permohonanController@create')->name('create');
            Route::post('/store', 'NelayanDarat\baharuKadNelayan\permohonanController@store')->name('store');
            Route::post('/storeAppeal', 'NelayanDarat\baharuKadNelayan\permohonanController@storeAppeal')->name('storeAppeal');
            Route::post('/store_tab6', 'NelayanDarat\baharuKadNelayan\permohonanController@store_tab6')->name('store_tab6');
            Route::get('/{id}/negativeFeedback', 'NelayanDarat\baharuKadNelayan\permohonanController@negativeFeedback')->name('negativeFeedback');
            Route::get('/{id}/appealFeedback', 'NelayanDarat\baharuKadNelayan\permohonanController@appealFeedback')->name('appealFeedback');
            Route::get('/viewEquipmentFile', 'NelayanDarat\baharuKadNelayan\permohonanController@viewEquipmentFile')->name('viewEquipmentFile');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\permohonanController@viewDocument')->name('viewDocument');
        });

        Route::group(['prefix' => 'semakanDokumen-09', 'as' => 'semakanDokumen-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\baharuKadNelayan\semakanDokumenController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'pindaLpi-09', 'as' => 'pindaLpi-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@updateFault')->name('updateFault');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\baharuKadNelayan\pindaTarikhController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'laporanLpi-09', 'as' => 'laporanLpi-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\laporanLpiController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\laporanLpiController@create')->name('create');
            Route::get('/{id}/create2', 'NelayanDarat\baharuKadNelayan\laporanLpiController@create2')->name('create2');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@store')->name('store');
            Route::post('/storeMaklumatVesel/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@storeMaklumatVesel')->name('storeMaklumatVesel');
            Route::post('/storeMaklumatEnjin/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@storeMaklumatEnjin')->name('storeMaklumatEnjin');
            Route::post('/storePeralatanKeselamatan/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@storePeralatanKeselamatan')->name('storePeralatanKeselamatan');
            Route::post('/storePengesahanPemeriksaan/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@storePengesahanPemeriksaan')->name('storePengesahanPemeriksaan');
            Route::post('/storePeralatanMenangkapIkan/{id}', 'NelayanDarat\baharuKadNelayan\laporanLpiController@storePeralatanMenangkapIkan')->name('storePeralatanMenangkapIkan');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\laporanLpiController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipmentFile', 'NelayanDarat\baharuKadNelayan\laporanLpiController@viewEquipmentFile')->name('viewEquipmentFile');
        });

        Route::group(['prefix' => 'keputusan-09', 'as' => 'keputusan-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\keputusanController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\keputusanController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\keputusanController@store')->name('store');
            Route::post('/updateFault', 'NelayanDarat\baharuKadNelayan\keputusanController@updateFault')->name('updateFault');
            Route::get('viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\keputusanController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\keputusanController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\keputusanController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\baharuKadNelayan\keputusanController@viewFaultDocument')->name('viewFaultDocument');
        });

        Route::group(['prefix' => 'resitBayaran-09', 'as' => 'resitBayaran-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@store')->name('store');
            Route::post('/submit/{id}', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@submit')->name('submit');
            Route::get('/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewCrime', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@viewCrime')->name('viewCrime');
            Route::get('/viewReceipt', 'NelayanDarat\baharuKadNelayan\resitPembayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'semakanBayaran-09', 'as' => 'semakanBayaran-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@store')->name('store');
            Route::get('/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewEquipment')->name('viewEquipment');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewDocument')->name('viewDocument');
            Route::get('/viewFaultDocument', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewReceipt', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'cetakLesen-09', 'as' => 'cetakLesen-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\cetakLesenController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\cetakLesenController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\cetakLesenController@store')->name('store');
            Route::post('/{id}/semakPin', 'NelayanDarat\baharuKadNelayan\cetakLesenController@semakPin')->name('semakPin');
            Route::get('/viewFaultDocument', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewFaultDocument')->name('viewFaultDocument');
            Route::get('/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\semakanBayaranController@viewInspectionDocument')->name('viewInspectionDocument');
            Route::get('/viewDocument', 'NelayanDarat\baharuKadNelayan\cetakLesenController@viewDocument')->name('viewDocument');
            Route::get('/viewEquipment', 'NelayanDarat\baharuKadNelayan\cetakLesenController@viewEquipment')->name('viewEquipment');
            Route::get('/viewReceipt', 'NelayanDarat\baharuKadNelayan\cetakLesenController@viewReceipt')->name('viewReceipt');
        });

        Route::group(['prefix' => 'sokonganUlasanR-09', 'as' => 'sokonganUlasanR-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\sokonganUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\sokonganUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\sokonganUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\baharuKadNelayan\sokonganUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\sokonganUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'semakanUlasanR-09', 'as' => 'semakanUlasanR-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\semakanUlasanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\semakanUlasanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\semakanUlasanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\baharuKadNelayan\semakanUlasanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\semakanUlasanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });

        Route::group(['prefix' => 'keputusanR-09', 'as' => 'keputusanR-09.'], function () {
            Route::get('/', 'NelayanDarat\baharuKadNelayan\keputusanRController@index')->name('index');
            Route::get('/{id}/create', 'NelayanDarat\baharuKadNelayan\keputusanRController@create')->name('create');
            Route::post('/store/{id}', 'NelayanDarat\baharuKadNelayan\keputusanRController@store')->name('store');
            Route::get('/{id}/viewDocument', 'NelayanDarat\baharuKadNelayan\keputusanRController@viewDocument')->name('viewDocument');
            Route::get('/{id}/{field}/viewInspectionDocument', 'NelayanDarat\baharuKadNelayan\keputusanRController@viewInspectionDocument')->name('viewInspectionDocument');
        });
    });

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

});

// Define the route
Route::post('/button-action', [AppointmentController::class, 'handleButton'])->name('button.action');
