<?php
/**
 * ルートコントローラ
 *
 * トップ関連画面を表示するコントローラクラス
 *
 * @author hiroyuki yahagi
 * @category base
 * @package controller
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ルートコントローラ
 */
class RootController extends Controller
{

    public function __construct(){
    }

    public function index(){
        return view('welcome');
    }


}