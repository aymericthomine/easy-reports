<?php

namespace app\Http\Controllers;

use App\Actions\Fortify\ResetUserPassword;
use App\Http\Livewire\CompaniesTable;
use App\Http\Livewire\TrackingsTable;
use App\Mail\MailjetMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UsersTable;
use App\Http\Livewire\ProductsTable;
use App\Http\Livewire\DocumentsTable;
use App\Http\Livewire\ProspectsTable;
use App\Http\Livewire\ContactsTable;
use App\Http\Livewire\CampaignTemplatesTable;
use App\Http\Livewire\CampaignsTable;
use App\Http\Livewire\CampaignNotifsTable;
use App\Http\Livewire\ContactUsController;

/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes(['register' => false]);
// App::setLocale('fr');
// App::setLocale(session('locale'));

/**
 * MailJet: Point d'entree pour les notifications d'evennements sur les envois de mails
 * https://app.mailjet.com/account/triggers
 */
Route::post('/mailjet', function (Request $request) {
    MailjetMessage::storeEvents($request);
    return response('OK', 200)->header('Content-Type', 'text/plain');
});

Route::get('/', function (Request $request) {
    TrackingsTable::store($request);
    return view('public');
});

Route::get('/links/{link}/{id?}', function (Request $request, $link, $id=null) {
    TrackingsTable::store($request, $id);
    return view('links.'. $link );
});

Route::get('/Molitor-Partners-corporate-Feb-21/{id?}', function (Request $request, $id=null) {
    TrackingsTable::store($request, $id);
    return view('Molitor-Partners-corporate-Feb-21');
})->name('Molitor-Partners-corporate-Feb-21');

Route::get('/Active-Solar-Rapport-Jan-21/{id?}', function (Request $request, $id=null) {
    TrackingsTable::store($request, $id);
    return view('Active-Solar-Rapport-Jan-21');
})->name('Active-Solar-Rapport-Jan-21');

Route::get('/RGPD'                      , function () { return view('RGPD');                  })->name('RGPD');
Route::get('/voeux'                     , function () { return view('voeux');                 })->name('voeux');
Route::get('/CGU'                       , function () { return view('CGU');                   })->name('CGU');
Route::get('/presentation-jan-21'       , function () { return view('presentation-jan-21');   })->name('presentation-jan-21');

Route::get(  '/register'                , [ContactUsController::class, 'index' ])->name('contact-us.index'     );
Route::get(  '/contact-us'              , [ContactUsController::class, 'index' ])->name('contact-us.index'     );
Route::post( '/contact-us/send'         , [ContactUsController::class, 'send'  ])->name('contact-us.send'      );

Route::get('/users/unsubscribe/{user}'  , function (User $user, Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    DB::table('contacts')
        ->where('id', $user->id)
        ->update(['email_status' => 'unsub']);
    return ContactsTable::unsubscribeConfirmation($user);
})->name('users.unsubscribe');

Route::get('/forgot-password/{token}'   , function (User $user, Request $request) {
    TrackingsTable::store($request);
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    return UsersTable::setPassword($user);
})->name('auth.forgot-password');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (Request $request) {
    TrackingsTable::store($request);
    return view('dashboard');
})->name('dashboard');

// routes nécessitant une authentification
Route::group(['middleware' => 'auth']   , function () {

//    Route::get('/',                     function () { return view('dashboard');                })->name('dashboard');
    Route::get('/profile'           , function () { return view('profile/show'); });

    Route::get( '/users'                          ,[UsersTable::class,    'index'                ])->name('users.index'        );
    Route::post('/users'                          ,[UsersTable::class,    'store'                ])->name('users.store'        );
    Route::get( '/users/create'                   ,[UsersTable::class,    'create'               ])->name('users.create'       );
    Route::get( '/users/{user}'                   ,[UsersTable::class,    'show'                 ])->name('users.show'         );
    Route::get( '/users/{user}/edit'              ,[UsersTable::class,    'edit'                 ])->name('users.edit'         );
    Route::put( '/users/{user}'                   ,[UsersTable::class,    'update'               ])->name('users.update'       );
    Route::get( '/users/{user}/destroy'           ,[UsersTable::class,    'destroy'              ])->name('users.destroy'      );

    Route::get( '/products'                       ,[ProductsTable::class, 'index'                ])->name('products.index'     );
    Route::post('/products'                       ,[ProductsTable::class, 'store'                ])->name('products.store'     );
    Route::get( '/products/create'                ,[ProductsTable::class, 'create'               ])->name('products.create'    );
    Route::get( '/products/{product}'             ,[ProductsTable::class, 'show'                 ])->name('products.show'      );
    Route::get( '/products/{product}/edit'        ,[ProductsTable::class, 'edit'                 ])->name('products.edit'      );
    Route::put( '/products/{product}'             ,[ProductsTable::class, 'update'               ])->name('products.update'    );
    Route::get( '/products/{product}/destroy'     ,[ProductsTable::class, 'destroy'              ])->name('products.destroy'   );

    Route::get( '/documents'                      ,[DocumentsTable::class, 'index'               ])->name('documents.index'    );
    Route::post('/documents'                      ,[DocumentsTable::class, 'store'               ])->name('documents.store'    );
    Route::get( '/documents/create'               ,[DocumentsTable::class, 'create'              ])->name('documents.create'   );
    Route::get( '/documents/{document}'           ,[DocumentsTable::class, 'show'                ])->name('documents.show'     );
    Route::get( '/documents/{document}/edit'      ,[DocumentsTable::class, 'edit'                ])->name('documents.edit'     );
    Route::put( '/documents/{document}'           ,[DocumentsTable::class, 'update'              ])->name('documents.update'   );
    Route::get( '/documents/{document}/destroy'   ,[DocumentsTable::class, 'destroy'             ])->name('documents.destroy'  );
    Route::post('/documents/dragAndDrop'          ,[DocumentsTable::class, 'dragAndDrop'         ])->name('documents.drop'     );

    Route::get( '/prospects'                      ,[ProspectsTable::class, 'index'               ])->name('prospects.index'    );
    Route::post('/prospects'                      ,[ProspectsTable::class, 'store'               ])->name('prospects.store'    );
    Route::get( '/prospects/create'               ,[ProspectsTable::class, 'create'              ])->name('prospects.create'   );
    Route::get( '/prospects/{prospect}'           ,[ProspectsTable::class, 'show'                ])->name('prospects.show'     );
    Route::get( '/prospects/{prospect}/edit'      ,[ProspectsTable::class, 'edit'                ])->name('prospects.edit'     );
    Route::put( '/prospects/{prospect}'           ,[ProspectsTable::class, 'update'              ])->name('prospects.update'   );
    Route::get( '/prospects/{prospect}/destroy'   ,[ProspectsTable::class, 'destroy'             ])->name('prospects.destroy'  );
    Route::post('/prospects/dragAndDrop'          ,[ProspectsTable::class, 'dragAndDrop'         ])->name('prospects.drop'     );

    Route::get( '/contacts'                       ,[ContactsTable::class, 'index'                ])->name('contacts.index'     );
    Route::post('/contacts'                       ,[ContactsTable::class, 'store'                ])->name('contacts.store'     );
    Route::get( '/contacts/create'                ,[ContactsTable::class, 'create'               ])->name('contacts.create'    );
    Route::get( '/contacts/{contact}'             ,[ContactsTable::class, 'show'                 ])->name('contacts.show'      );
    Route::get( '/contacts/{contact}/edit'        ,[ContactsTable::class, 'edit'                 ])->name('contacts.edit'      );
    Route::put( '/contacts/{contact}'             ,[ContactsTable::class, 'update'               ])->name('contacts.update'    );
    Route::get( '/contacts/{contact}/destroy'     ,[ContactsTable::class, 'destroy'              ])->name('contacts.destroy'   );
    Route::post('/contacts/dragAndDrop'           ,[ContactsTable::class, 'dragAndDrop'          ])->name('contacts.drop'      );

    Route::get( '/companies'                      ,[CompaniesTable::class, 'index'               ])->name('companies.index'    );
    Route::post('/companies'                      ,[CompaniesTable::class, 'store'               ])->name('companies.store'    );
    Route::get( '/companies/create'               ,[CompaniesTable::class, 'create'              ])->name('companies.create'   );
    Route::get( '/companies/{company}'            ,[CompaniesTable::class, 'show'                ])->name('companies.show'     );
    Route::get( '/companies/{company}/edit'       ,[CompaniesTable::class, 'edit'                ])->name('companies.edit'     );
    Route::put( '/companies/{company}'            ,[CompaniesTable::class, 'update'              ])->name('companies.update'   );
    Route::get( '/companies/{company}/destroy'    ,[CompaniesTable::class, 'destroy'             ])->name('companies.destroy'  );
    Route::post('/companies/dragAndDrop'          ,[CompaniesTable::class, 'dragAndDrop'         ])->name('companies.drop'     );

    Route::get( '/templates'                      ,[CampaignTemplatesTable::class, 'index'       ])->name('templates.index'    );
    Route::post('/templates'                      ,[CampaignTemplatesTable::class, 'store'       ])->name('templates.store'    );
    Route::get( '/templates/create'               ,[CampaignTemplatesTable::class, 'create'      ])->name('templates.create'   );
    Route::get( '/templates/{notif}'              ,[CampaignTemplatesTable::class, 'show'        ])->name('templates.show'     );
    Route::get( '/templates/{notif}/edit'         ,[CampaignTemplatesTable::class, 'edit'        ])->name('templates.edit'     );
    Route::put( '/templates/{notif}'              ,[CampaignTemplatesTable::class, 'update'      ])->name('templates.update'   );
    Route::get( '/templates/{notif}/destroy'      ,[CampaignTemplatesTable::class, 'destroy'     ])->name('templates.destroy'  );
    Route::post('/templates/dragAndDrop'          ,[CampaignTemplatesTable::class, 'dragAndDrop' ])->name('templates.drop'     );

    Route::get( '/campaigns'                      ,[CampaignsTable::class, 'index'               ])->name('campaigns.index'    );
    Route::post('/campaigns'                      ,[CampaignsTable::class, 'store'               ])->name('campaigns.store'    );
    Route::get( '/campaigns/create'               ,[CampaignsTable::class, 'create'              ])->name('campaigns.create'   );
    Route::get( '/campaigns/{notif}'              ,[CampaignsTable::class, 'show'                ])->name('campaigns.show'     );
    Route::get( '/campaigns/{notif}/edit'         ,[CampaignsTable::class, 'edit'                ])->name('campaigns.edit'     );
    Route::put( '/campaigns/{notif}'              ,[CampaignsTable::class, 'update'              ])->name('campaigns.update'   );
    Route::get( '/campaigns/{notif}/destroy'      ,[CampaignsTable::class, 'destroy'             ])->name('campaigns.destroy'  );
    Route::post('/campaigns/dragAndDrop'          ,[CampaignsTable::class, 'dragAndDrop'         ])->name('campaigns.drop'     );

    Route::get( '/notifs'                         ,[CampaignNotifsTable::class, 'index'          ])->name('notifs.index'       );
    Route::post('/notifs'                         ,[CampaignNotifsTable::class, 'store'          ])->name('notifs.store'       );
    Route::get( '/notifs/create'                  ,[CampaignNotifsTable::class, 'create'         ])->name('notifs.create'      );
    Route::get( '/notifs/{notif}'                 ,[CampaignNotifsTable::class, 'show'           ])->name('notifs.show'        );
    Route::get( '/notifs/{notif}/edit'            ,[CampaignNotifsTable::class, 'edit'           ])->name('notifs.edit'        );
    Route::put( '/notifs/{notif}'                 ,[CampaignNotifsTable::class, 'update'         ])->name('notifs.update'      );
    Route::get( '/notifs/{notif}/destroy'         ,[CampaignNotifsTable::class, 'destroy'        ])->name('notifs.destroy'     );
    Route::post('/notifs/dragAndDrop'             ,[CampaignNotifsTable::class, 'dragAndDrop'    ])->name('notifs.drop'        );

    Route::get( '/trackings'                      ,[TrackingsTable::class, 'index'               ])->name('trackings.index'    );
    Route::post('/trackings'                      ,[TrackingsTable::class, 'store'               ])->name('trackings.store'    );
    Route::get( '/trackings/create'               ,[TrackingsTable::class, 'create'              ])->name('trackings.create'   );
    Route::get( '/trackings/{tracking}'           ,[TrackingsTable::class, 'show'                ])->name('trackings.show'     );
    Route::get( '/trackings/{tracking}/edit'      ,[TrackingsTable::class, 'edit'                ])->name('trackings.edit'     );
    Route::put( '/trackings/{tracking}'           ,[TrackingsTable::class, 'update'              ])->name('trackings.update'   );

});

/**
 * Old notation

Route::get( '/users'                     ,'UserController@show'       )->name('users.index'   );
Route::post('/users'                     ,'UserController@store'      )->name('users.store'   );
Route::get( '/users/create'              ,'UserController@create'     )->name('users.create'  );
Route::get( '/users/{user}'              ,'UserController@show'       )->name('users.show'    );
Route::get( '/users/{user}/edit'         ,'UserController@edit'       )->name('users.edit'    );
Route::put( '/users/{user}'              ,'UserController@update'     )->name('users.update'  );
Route::get( '/users/{user}/destroy'      ,'UserController@destroy'    )->name('users.destroy' );
 */
