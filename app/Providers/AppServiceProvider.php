<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Language;
use Illuminate\Support\Facades\Crypt;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //return response('')->withoutCookie('cart');
        /* CART */
        $cart_content = \Cookie::get('cart');

        $cart_count = 0;

        if($cart_content != null)
        {
            $cart_content = json_decode(explode("|",Crypt::decryptString($cart_content))[1], true);
//dd($cart_content);
            if(is_array($cart_content))
            {
                
                foreach($cart_content as $cc)
                {
                    if(!isset($cc['count']))
                        continue;

                    $cart_count += $cc['count'];
                }
            }
        }
        /* FAVORITES*/
        $favorites = \Cookie::get('favorites');

        $favorites_count = 0;

        $favorites_content = [];

        if($favorites != null)
        {
            $favorites_content = json_decode(explode("|",Crypt::decryptString($favorites))[1], true);

            if(is_array($favorites_content))
                $favorites_count = count($favorites_content);
            else
            {
                $favorites_count = 0;
            }
        }
    
        /* COMPARE*/
        $compare = \Cookie::get('compare');

        $compare_count = 0;

        $compare_content = [];

        if($compare != null)
        {
            $compare_content = json_decode(explode("|",Crypt::decryptString($compare))[1], true);

            if(is_array($compare_content))
                $compare_count = count($compare_content);
            else
            {
                $compare_count = 0;
            }
        }
        $site_languages = Language::whereTurnon(1)->orderBy('position')->get();

        $uri = $this->app->request->path();

        $uri_no_locale = str_replace($site_languages->pluck('locale')->all(), '', $uri);

        $languages_buttons = [];

        //dd($site_languages);

        foreach($site_languages as $lang)
        {
            $languages_buttons[] = [
                'title' => $lang->title,
                'locale' => $lang->locale,
                'link' => config('app.fallback_locale') == $lang->locale ? $uri_no_locale : $lang->locale.'/'.$uri_no_locale,
            ];
        }
    


        $segment = $this->app->request->segment(1);

        if(in_array($segment, $site_languages->pluck('locale')->all()))
        {
            \App::setLocale($segment);
            $csl = $segment;
            config(['csl' => $csl]);
        }
        else
            $csl = \App::getLocale();

        $site_optionT = \App\Models\Option::with('languages');
        //если это админка выбираем весь option
        if(strpos($uri, 'option') !== false)
            $site_optionT = $site_optionT->get();
        //если главная страница 
        elseif($uri == '/' || $uri == $csl)
            $site_optionT = $site_optionT->whereIn('place', [1,2])->get();
        else
            $site_optionT = $site_optionT->where('place', 1)->get();

        $site_option = [];

        foreach($site_optionT as $so)
        {
            $site_option[$so->key]['id'] = $so->id;

            $site_option[$so->key]['type'] = $so->type;

            if($so->type == 'image')
            {
                $thumbs = explode(', ', $so->thumbs);

                foreach($thumbs as $t)
                {
                    $site_option[$so->key][$t] = asset('storage/images'.$so->preview_path.$t.'-'.$so->preview_name);
                }
                continue;
            }
            if($so->type == 'file')
            {
                $site_option[$so->key]['url'] = asset('storage/files'.$so->preview_path.$so->preview_name);

                continue;
            } 
            if($so->type == 'video')
            {
                $site_option[$so->key]['url'] = asset('storage/videos'.$so->preview_path.$so->preview_name);

                continue;
            }
            if($so->type == 'array')
            {
                $site_option[$so->key] = unserialize($so->value);

                continue;
            }

            if($so->type == 'nol')
            {
                if(strpos($uri, 'option') !== false)
                {
                    $site_option[$so->key]['place'] = $so->place;
                    $site_option[$so->key]['value'] = $so->value;
                }
                else
                    $site_option[$so->key] = $so->value;
                
                continue;
            }

            if(strpos($uri, 'option') !== false)
            {
                foreach($site_languages as $sl)
                {
                    $site_option[$so->key]['text'][$sl->locale] = $so->languages()->where('language', $sl->locale)->value('value');
                }
                $site_option[$so->key]['place'] = $so->place;
            }
            else
            {
                $site_option[$so->key] = $so->language()->value('value');
            }
        }  
  //      dd($site_option['test_file']);

        $menu_pages = \App\Models\Page::with('language:id,title,page_id,menu')->wherePublic(1)->orderBy('position')->whereType('pages')->get();

        $policy_page = \App\Models\Page::with('language:id,title,page_id,menu')->find(54);

        if($policy_page != null)
        {
            $policy_link = '<a href="'.url($policy_page->alt_title).'">'.$policy_page->language->title.'</a>';
        }
        else
            $policy_link = null;

        $menu_catalogs = \App\Models\Catalog::with([
            'language:id,title,catalog_id,menu',
            'children.language',
            'products:catalog_id',
            'filters.language',
            'filters.fvalues.language',
        ])->withCount('products')->wherePublic(1)->orderBy('position')->get();

        $messengers_links = [];

        foreach($site_option['phones'] as $ph)
        {
            if(isset($ph['viber']))
            {
                $messengers_links[] = [
                    'icon' => asset('images/viber.png'),
                    'link' => 'viber://chat/?number='.preg_replace('/[^0-9]/', '', $ph['phone']),
                ];
            }
            if(isset($ph['whatsapp']))
            {
                $messengers_links[] = [
                    'icon' => asset('images/whatsapp.png'),
                    'link' => 'https://wa.me/'.preg_replace('/[^0-9]/', '', $ph['phone']),
                ];
            }
            if(isset($ph['telegram']))
            {
                $messengers_links[] = [
                    'icon' => asset('images/telegram.png'),
                    'link' => 'https://t.me/'.preg_replace('/[^0-9]/', '', $ph['phone']),
                ];
            }
        }
    
        view()->share([
            'policy_link' => $policy_link,

            'csl' => $csl,

            'languages_buttons' => $languages_buttons,

            'site_languages' => $site_languages,

            'site_option' => $site_option,

            'menu_pages' => $menu_pages,

            'menu_catalogs' => $menu_catalogs,

            'cart_count' => $cart_count,

            'favorites_count' => $favorites_count,

            'favorites_content' => $favorites_content,

            'compare_count' => $compare_count,

            'compare_content' => $compare_content,

            'messengers_links' => $messengers_links
        ]);
    }
}
