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
use App\Services\FaqService;
use Illuminate\Support\Facades\Auth;
use App\Services\ArticleService;
use App\Services\CategoryService;
use App\Services\ClipService;
use App\Services\FavoriteService;
use App\Services\NoticeService;

/**
 * ルートコントローラ
 */
class RootController extends Controller
{
    /**
     * FAQサービス
     * @var App\Services\FaqService
     */
    protected $faqService;

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
     * クリップサービス
     * @var App\Services\ClipService
     */
    protected $clipService;

    /**
     * お気に入りサービス
     * @var App\Services\FavoriteService
     */
    protected $favoriteService;

    /**
     * お知らせサービス
     * @var App\Services\NoticeService
     */
    protected $noticeService;

    /**
     * コンストラクタ
     *
     * @access public
     * @param App\Services\FaqService $faqService FAQサービス
     * @param App\Services\ArticleService $articleService 記事サービス
     * @param App\Services\CategoryService $categoryService カテゴリサービス
     * @param App\Services\ClipService $clipService クリップサービス
     * @param App\Services\FavoriteService $favoriteService お気に入りサービス
     * @param App\Services\NoticeService $noticeService お知らせサービス
     */
    public function __construct(
        FaqService $faqService, ArticleService $articleService, 
        CategoryService $categoryService, ClipService $clipService, 
        FavoriteService $favoriteService, NoticeService $noticeService){
        $this->faqService = $faqService;
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->clipService = $clipService;
        $this->favoriteService = $favoriteService;
        $this->noticeService = $noticeService;
    }

    /**
     * トップページ
     *
     * 認証済みの場合はfavo済みの記事一覧を表示
     * 未認証の婆愛はカテゴリ別に記事を表示
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
    public function index(){
        $tops = $this->articleService->getTops();
        if(Auth::guard("user")->check()){
            $articles = $this->articleService->paginateByUser(Auth::id());
            if(count($articles) > 0) {
                $clips = $this->clipService->latestByUser(Auth::id());
                return view('root.index_authed', [
                    "tops" => $tops,
                    "articles" => $articles,
                    "clips" => $clips,
                ]);    
            }
        }
        $categories = $this->categoryService->getAllWithArticles();
        $notices = $this->noticeService->pagenatePublic();
        return view('root.index', [
            "tops" => $tops,
            "categories" => $categories,
            "notices" => $notices,
        ]);
    }

    /**
     * EATASについて
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
    public function about(){
    	return view('root.about');
    }

    /**
     * よくある質問
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
    public function faq(){
        $faqs = $this->faqService->getAll();
    	return view('root.faq', ["faqs" => $faqs]);
    }

    /**
     * お知らせ一覧
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
    public function notices(){
        $notices = $this->noticeService->pagenatePublic();
        return view('root.notices', ["notices" => $notices]);
    }

    /**
     * 利用規約
     *
     * @access public
     * @return Illuminate\Http\Response 
     */
	public function term(){
		return view('root.term');
    }
}