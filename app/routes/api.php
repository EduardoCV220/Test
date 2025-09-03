<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;


Route::post('/proposal', [ProposalController::class, 'store']);
