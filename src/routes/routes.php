<?php

Route::group(['prefix' => 'api/layanan', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Layanan\Http\Controllers\LayananController@index',
        'create'    => 'Bantenprov\Layanan\Http\Controllers\LayananController@create',
        'show'      => 'Bantenprov\Layanan\Http\Controllers\LayananController@show',
        'store'     => 'Bantenprov\Layanan\Http\Controllers\LayananController@store',
        'edit'      => 'Bantenprov\Layanan\Http\Controllers\LayananController@edit',
        'update'    => 'Bantenprov\Layanan\Http\Controllers\LayananController@update',
        'destroy'   => 'Bantenprov\Layanan\Http\Controllers\LayananController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('layanan.index');
    Route::get('/create',       $controllers->create)->name('layanan.create');
    Route::get('/{id}',         $controllers->show)->name('layanan.show');
    Route::post('/',            $controllers->store)->name('layanan.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('layanan.edit');
    Route::put('/{id}',         $controllers->update)->name('layanan.update');
    Route::delete('/{id}',      $controllers->destroy)->name('layanan.destroy');
});
