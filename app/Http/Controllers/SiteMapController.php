<?php
/**
 * サイトマップコントローラ
 *
 * サイトマップを表示するコントローラクラス
 *
 * @author hiroyuki yahagi
 * @category base
 * @package controller
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App;

/**
 * サイトマップコントローラ
 */
class SiteMapController extends Controller
{
    public function __construct(){
    }

    public function index(){
		$sitemap = App::make('sitemap');
		$sitemap->setCache('laravel.sitemap', 60);
		if (!$sitemap->isCached()) {
			//メインページ
			$sitemap->add(route('root.index'), Carbon::now(), '1.0', 'daily');
		}

		return $sitemap->render('xml');
    }
}
