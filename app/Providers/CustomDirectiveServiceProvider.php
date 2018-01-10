<?php
/**
 * Bladeカスタムディレクティブプロバイダ
 *
 * Bladeカスタムディレクティブを登録するプロバイダ
 *
 * @author hiroyuki yahagi
 * @category base
 * @package provider
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

/**
 * Bladeカスタムディレクティブプロバイダ
 */
class CustomDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     * @todo シンタックスエラー
     */
    public function boot()
    {
        //日時の表示フォーマット
        Blade::directive('datetime', function ($expression) {
            return "<?php echo !is_null($expression) ? (new DateTime($expression))->format('m/d/Y H:i') : null; ?>";
        });

        //日付の表示フォーマット
        Blade::directive('date', function ($expression) {
            return "<?php echo !is_null($expression) ? (new DateTime($expression))->format('Y-m-d') : null; ?>";
        });

        //改行コード込みの文字列を改行して表示する
        Blade::directive('lined', function ($expression) {
            return "<?php echo nl2br($expression); ?>";
        });

        //相対パスの画像URLをstorage配下のパスに書き換える
        Blade::directive('imageUrl', function ($expression) {
            return "<?php echo preg_match('/^http/', $expression) ? $expression : route('storage').'/'.$expression ; ?>";
        });

        //新しい記事であることを判定する
        Blade::if('new', function ($dateStr) {
            if($dateStr == null){
                return false;
            }
            $date = new Carbon($dateStr);
            $threthold = Carbon::now()->subDay(7);
            return $date->gt($threthold);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
