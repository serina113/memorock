<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fes;

class FesController extends Controller
{
    /**
 * Fes投稿一覧を表示する
 * 
 * @param Fes Fesモデル
 * @return array Fesモデルリスト
 */
public function index(Fes $fes)
{
    $fesPosts = $fes->get();
    return view('fes.index', compact('fesPosts'));
}
}