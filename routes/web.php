<?php

use Illuminate\Support\Facades\Route;
 
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FvalueController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\NovaPochtaController;
use App\Http\Controllers\JustinController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;



Route::get('/auth/google/redirect', [GoogleController::class, 'redirectToGoogle'])->name('redirect.to.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook/redirect', [FacebookController::class, 'redirectToFacebook'])->name('redirect.to.facebook');
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);


    
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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/


Route::group(['prefix'=>'adminzone', 'middleware' => ['auth']], function(){

    Route::get('/admin/password/update', [AdminController::class, 'password_update'])->name('admin.password.update');
    Route::get('/admin/sorting', [AdminController::class, 'sorting'])->name('admin.sorting');

    Route::get('/make_link', function(){
        symlink(base_path().'/storage/app/public',base_path().'/public_html/storage');
        return redirect()->route('index');
    });

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/change_cell', [AdminController::class, 'change_cell'])->name('change.cell');
    Route::get('/change_pivot', [AdminController::class, 'change_pivot'])->name('change.pivot');
    Route::get('/transfer-pictures', [AdminController::class, 'transfer_pictures'])->name('transfer_pictures');

//OPTION
    Route::get('option/edit', [OptionController::class, 'get'])->name('option.get');
    Route::get('option/{page}', [OptionController::class, 'index'])->name('option.index');
    Route::post('option/update', [OptionController::class, 'update'])->name('option.update');
    Route::post('option/update_preview', [OptionController::class, 'update_preview'])->name('option.update.preview');
    Route::post('option/delete_preview', [OptionController::class, 'delete_preview'])->name('option.delete.preview');

    //Languages
    Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::post('languages/store', [LanguageController::class, 'store'])->name('languages.store');
    Route::post('languages/update/{id}', [LanguageController::class, 'update'])->name('languages.update');
    Route::get('languages/delete/{id}', [LanguageController::class, 'destroy'])->name('languages.delete');
    //PAGES 
    Route::get('/pages/{type}', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/tree/{type}', [PageController::class, 'index_tree'])->name('pages.index.tree');
    Route::get('/pages/create/{type}', [PageController::class, 'create'])->name('pages.create');
    Route::post('/pages/store/{type}', [PageController::class, 'store'])->name('pages.store');
    Route::get('/pages/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
    Route::post('/pages/update/{id}', [PageController::class, 'update'])->name('pages.update');
    Route::get('/pages/delete/{id}', [PageController::class, 'destroy'])->name('pages.delete');
    //UPLOADING PICTURES BY AJAX
    Route::post('/upload-picture-ajax', [PictureController::class, 'upload_picture_ajax']);
    Route::get('/rotate-picture-ajax', [PictureController::class, 'rotate'])->name('picture.rotate');
    Route::get('/delete-picture-ajax/{id}', [PictureController::class, 'destroy'])->name('picture.delete');
    Route::get('/edit-picture-ajax/{id}', [PictureController::class, 'edit'])->name('picture.edit');
    Route::post('/update-picture-ajax', [PictureController::class, 'update'])->name('picture.update');
    Route::get('/attach-colour-picture-ajax/{id}/{colour_id}', [PictureController::class, 'attach_colour'])->name('picture.attach.colour');
    //ITEMS 
    Route::get('/items/{type}', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/tree/{type}', [ItemController::class, 'index_tree'])->name('items.index.tree');
    Route::get('/items/create/{type}', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store/{type}', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    Route::post('/items/update/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::get('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.delete');
    //TRANSLATION
    Route::get('/translations/scan-views', [TranslationController::class, 'scanViews'])->name('translations.scan.views');
    Route::post('/translations/translate-one-phrase', [TranslationController::class, 'translate_one_phrase'])->name('translate.one.phrase');
    Route::post('/translations/save-file', [TranslationController::class, 'saveFile'])->name('translations.save.file');
    //COMMENTS
    Route::get('/comments/delete/{id}', [CommentController::class, 'destroy'])->name('comments.delete');
    Route::get('/comments/unchecked', [CommentController::class, 'unchecked'])->name('comments.unchecked');
    Route::get('/comments/checked', [CommentController::class, 'checked'])->name('comments.checked');

    // CATALOGS
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::get('/catalogs/tree', [CatalogController::class, 'index_tree'])->name('catalogs.index.tree');
    Route::get('/catalogs/create', [CatalogController::class, 'create'])->name('catalogs.create');
    Route::post('/catalogs/store', [CatalogController::class, 'store'])->name('catalogs.store');
    Route::get('/catalogs/edit/{id}', [CatalogController::class, 'edit'])->name('catalogs.edit');
    Route::post('/catalogs/update/{id}', [CatalogController::class, 'update'])->name('catalogs.update'); 
    Route::get('/catalogs/delete/{id}', [CatalogController::class, 'destroy'])->name('catalogs.delete');
    Route::get('/catalogs/store/delete', [CatalogController::class, 'deleteStore'])->name('delete.store');

    // PRODUCTS
    Route::get('/products/{catalog_id}', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create/{catalog_id}', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store/{parser?}', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    Route::get('/products/delete-all/{catalog_id}', [ProductController::class, 'delete_all'])->name('products.delete.all');
    //FILTERS
    Route::get('/filters',[FilterController::class, 'index'])->name('filters.index');
    Route::post('/filters/update/{id}',[FilterController::class, 'update'])->name('filters.update');
    Route::post('/filters/store{parser?}',[FilterController::class, 'store'])->name('filters.store');
    Route::get('/filters/edit/{id}',[FilterController::class, 'edit'])->name('filters.edit');
    Route::post('/filters/update/{id}',[FilterController::class, 'update'])->name('filters.update');
    Route::get('/filter/delete/{id}',[FilterController::class, 'destroy'])->name('filters.delete');
    //FVALUES
    Route::post('/fvalues/store{parser?}', [FvalueController::class, 'store'])->name('fvalues.store');
    Route::post('/fvalues/store_ajax', [FvalueController::class, 'store_ajax'])->name('fvalues.store.ajax');
    Route::get('/fvalues/edit/{id}', [FvalueController::class, 'edit'])->name('fvalues.edit');
    Route::post('/fvalues/update/{id}', [FvalueController::class, 'update'])->name('fvalues.update');
    Route::get('/fvalues/delete/{id}', [FvalueController::class, 'destroy'])->name('fvalues.delete');
    Route::get('/fvalues/get-by-ajax', [FvalueController::class, 'get_by_ajax'])->name('fvalues.get.by.ajax');
    Route::get('/fvalues/arrange-auto', [FvalueController::class, 'arrange_auto'])->name('fvalues.arrange.auto');
    //PARSING
    Route::get('/parser/index', [ParserController::class, 'index'])->name('parser.index');
    Route::get('/parser/get-links', [ParserController::class, 'get_links'])->name('parser.get.links'); 
    Route::get('/parser/save-product', [ParserController::class, 'save_product'])->name('parser.save.product');
    Route::get('/parser/monitor', [ParserController::class, 'monitor'])->name('parser.monitor');
    Route::get('/parser/pause-proceed', [ParserController::class, 'pause_procceed'])->name('parser.pause.proceed');
    Route::get('/parser/process', [ParserController::class, 'process'])->name('parser.process');

    Route::get('order/index', [OrderController::class, 'index'])->name('orders.index');
    Route::get('order/delete/{id}', [OrderController::class, 'destroy'])->name('orders.delete');

});

 



/*FAVORITES*/
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::get('/favorites/add_remove', [FavoriteController::class, 'add_remove'])->name('favorite.add.remove');
/*COMPARE*/
Route::get('/compare/add_remove', [CompareController::class, 'add_remove'])->name('compare.add.remove'); 
Route::get('compare', [CompareController::class, 'index'])->name('compare.index');
Route::get('compare/{catalog_id}', [CompareController::class, 'catalog'])->name('compare.catalog');
Route::get('compare/delete/all', [CompareController::class, 'delete_all'])->name('compare.delete.all');
/* NOVA POCHTA*/
Route::get('nova-pochta/get-cities', [NovaPochtaController::class, 'get_cities'])->name('nova.pochta.get.cities');
Route::get('nova-pochta/get-warehouses', [NovaPochtaController::class, 'get_warehouses'])->name('nova.pochta.get.warehouses');
Route::get('nova-pochta/get-streets', [NovaPochtaController::class, 'get_streets'])->name('nova.pochta.get.streets');
/* JUSTIN  */
Route::get('justin/get-cities', [JustinController::class, 'get_cities'])->name('justin.get.cities');
Route::get('justin/get-warehouses', [JustinController::class, 'get_warehouses'])->name('justin.get.warehouses');
/*DELIVERY*/
Route::post('/delivery/store', [DeliveryController::class, 'store'])->name('delivery.store');
Route::get('/delivery/delete/{id}', [DeliveryController::class, 'delete'])->name('delivery.delete');
Route::get('/delivery/select-main/{id}', [DeliveryController::class, 'select_main'])->name('delivery.select.main');



// проверка актуальности csrf-token
Route::post('check-csrf-token', [SiteController::class, 'checkToken']);


Route::group(['prefix' => config('csl'), 'middleware' => ['locale']], function(){
    // ajax перевод для js 
Route::post('lang', [SiteController::class, 'lang']);
require __DIR__.'/auth.php';
    /* CART */
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/auth', [CartController::class, 'auth'])->name('cart.auth');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/content', [CartController::class, 'content'])->name('cart.content');
Route::get('/cart/change-count', [CartController::class, 'change_count'])->name('cart.change_count');       
Route::get('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/get-price-params-block/{product_id}', [CartController::class, 'get_data_for_cart_modal'])->name('cart.add.modal'); 

/* CABINET*/
    Route::get('cabinet/user-data', [CabinetController::class, 'user_data'])->name('cabinet.user.data'); 
    Route::get('cabinet/loyalty', [CabinetController::class, 'loyalty'])->name('cabinet.user.loyalty');
    Route::get('cabinet/delivery', [CabinetController::class, 'delivery'])->name('cabinet.user.delivery');
    Route::get('cabinet/orders', [CabinetController::class, 'orders'])->name('cabinet.user.orders');
    Route::get('cabinet/favorites', [CabinetController::class, 'favorites'])->name('cabinet.user.favorites');
//    Route::post('cabinet/change-password', [CabinetController::class, 'change_password'])->name('cabinet.change.password');
    Route::post('cabinet/change-user-data', [CabinetController::class, 'change_user_data'])->name('cabinet.change.user.data');
  
Route::get('/', [SiteController::class, 'index'])->name('index');

Route::get('/search/ajax', [SiteController::class, 'search_ajax'])->name('search.ajax');
//Route::get('/search', [SiteController::class, 'search'])->name('site.search');

Route::get('/send-email', [SiteController::class, 'send_email'])->name('send.email');

Route::get('/products/{id}-{alt_title}', [SiteController::class, 'products'])->name('products');

Route::get('/products/{id_catalog}-{alt_catalog}/{id}-{alt_title}', [SiteController::class, 'product'])->name('product');
/* some update */
Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');


Route::post('order/store', [OrderController::class, 'store'])->name('order.store');

Route::any('order/success/{order_id}', [OrderController::class, 'success'])->name('order.success');
Route::get('order/fail', [OrderController::class, 'fail'])->name('order.fail');
Route::any('/order/liqpay/success', [OrderController::class, 'liqpay_success'])->name('liqpay.success');

/* USER */ 
Route::get('user/socialtes/untie/{soc}', [UserController::class, 'untie'])->name('user.untie');
//Route::post('user/login', [UserController::class, 'login'])->name('user.login');
//Route::post('user/register', [UserController::class, 'register'])->name('user.register');
//Route::post('user/logout', [UserController::class, 'logout'])->name('user.logout');

 


Route::post('/adminzone/upload-image', function(
    \Illuminate\Http\Request $request,
    Illuminate\Contracts\Validation\Factory $validator
) {
    $v = $validator->make($request->all(), [
        'upload' => 'required|image',
    ]);

    $funcNum = $request->input('CKEditorFuncNum');

    if ($v->fails()) {
        return response(
            "<script>
                window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$v->errors()->first()}');
            </script>"
        );
    }

    $image = $request->file('upload');
    $f_name = $image->hashName();
    $image->move(storage_path('app/public').'/images/upload/',$f_name);
    $url = '/storage/images/upload/'.$f_name;

    return response(
        "<script>
            window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}', 'Изображение загружено');
        </script>"
    );

}); 

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

Route::get('/create-page', [SiteController::class, 'create_page'])->name('create.page');

Route::get('/google-merchant/feed', [SiteController::class, 'google_feed'])->name('google.merchant.feed');

Route::get('/{alt_title}', [SiteController::class, 'page'])->name('page');

});



