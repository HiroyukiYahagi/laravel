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

use App\Services\ArticleService;
use App\Services\CategoryService;
use Carbon\Carbon;
use App;

/**
 * サイトマップコントローラ
 */
class SiteMapController extends Controller
{
	/**
     * 記事サービス
     * @var App\Services\ArticleService
     */
    protected $articleService;

    /**
     * カテゴリサービス
     * @var App\Services\CategoryService
     */
    protected $categoryService;
  
  	/**
     * コンストラクタ
     *
     * @access public
     * @param App\Services\ArticleService $articleService 記事サービス
     * @param App\Services\CategoryService $categoryService カテゴリサービス
     */
    public function __construct( ArticleService $articleService, 
        CategoryService $categoryService){
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
    }

    /**
     * サイトマップの出力
     *
     * キャッシュに保存し、期限切れになったら再生成する。
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
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
