<?php

namespace App\Http\Services;

use App\Models\Product;

class ProductService
{
	public $array;

	public $catalog;

	public $product;

	public function __construct()
	{
 
	}

	public static function call()
	{
		return new ProductService();
	}

	public function getArray($array)
	{
		$array['user_id'] = auth()->id();

		$this->array = $array;

		return $this;
	}

	public function altTitle()
	{
		$this->array['alt_title'] = alt_title($this->array['languages'][0]['title']);

		return $this;
	}

	public function params()
	{
		foreach($this->array['languages'] as $k => $v)
        {
        	if(isset($this->array['languages'][$k]['params']))
                $this->array['languages'][$k]['params'] = serialize($v['params']); 
        }
        return $this;
	}

	public function getCatalog($catalog)
	{
		$this->catalog = $catalog;

		return $this;
	}

	public function getProduct($product)
	{
		$this->product = $product;

		$this->catalog = $product->catalog;

		return $this;
	}

	public function catalogParams()
	{
		foreach($this->catalog->languages as $k => $v)
        {
            $this->catalog->languages[$k]->params = explode(PHP_EOL, $v->params);
        }
        return $this;
	}

	public function productParams()
	{
		foreach($this->product->languages as $k => $lang)
        {
            $this->product->languages[$k]->params = unserialize($lang->params);
        }
        return $this;
	}


}