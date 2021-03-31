<?php

namespace app\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UsersTable;
use App\Http\Livewire\ProductsTable;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home2', function () { return view('home2'); } );

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get( '/users'                        ,[UsersTable::class,    'index'   ])->name('users.index'      );
Route::post('/users'                        ,[UsersTable::class,    'store'   ])->name('users.store'      );
Route::get( '/users/create'                 ,[UsersTable::class,    'create'  ])->name('users.create'     );
Route::get( '/users/{user}'                 ,[UsersTable::class,    'show'    ])->name('users.show'       );
Route::get( '/users/{user}/edit'            ,[UsersTable::class,    'edit'    ])->name('users.edit'       );
Route::put( '/users/{user}'                 ,[UsersTable::class,    'update'  ])->name('users.update'     );
Route::get( '/users/{user}/destroy'         ,[UsersTable::class,    'destroy' ])->name('users.destroy'    );

Route::get( '/products'                     ,[ProductsTable::class, 'index'   ])->name('products.index'   );
Route::post('/products'                     ,[ProductsTable::class, 'store'   ])->name('products.store'   );
Route::get( '/products/create'              ,[ProductsTable::class, 'create'  ])->name('products.create'  );
Route::get( '/products/{product}'           ,[ProductsTable::class, 'show'    ])->name('products.show'    );
Route::get( '/products/{product}/edit'      ,[ProductsTable::class, 'edit'    ])->name('products.edit'    );
Route::put( '/products/{product}'           ,[ProductsTable::class, 'update'  ])->name('products.update'  );
Route::get( '/products/{product}/destroy'   ,[ProductsTable::class, 'destroy' ])->name('products.destroy' );

/*
Route::get( '/users'                     ,'UserController@show'       )->name('users.index'   );
Route::post('/users'                     ,'UserController@store'      )->name('users.store'   );
Route::get( '/users/create'              ,'UserController@create'     )->name('users.create'  );
Route::get( '/users/{user}'              ,'UserController@show'       )->name('users.show'    );
Route::get( '/users/{user}/edit'         ,'UserController@edit'       )->name('users.edit'    );
Route::put( '/users/{user}'              ,'UserController@update'     )->name('users.update'  );
Route::get( '/users/{user}/destroy'      ,'UserController@destroy'    )->name('users.destroy' );

Route::get( '/products'                  ,'ProductController@show'    )->name('products.index'   );
Route::post('/products'                  ,'ProductController@store'   )->name('products.store'   );
Route::get( '/products/create'           ,'ProductController@create'  )->name('products.create'  );
Route::get( '/products/{product}'        ,'ProductController@show'    )->name('products.show'    );
Route::get( '/products/{product}/edit'   ,'ProductController@edit'    )->name('products.edit'    );
Route::put( '/products/{product}'        ,'ProductController@update'  )->name('products.update'  );
Route::get( '/products/{product}/destroy','ProductController@destroy' )->name('products.destroy' );
*/
