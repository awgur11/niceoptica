<?php 

namespace App\Http\Services;

class TreeService
{
	public $model;

	public $table;

	public $type;

	public static function call($model, $table, $type = NULL)
	{
		return new TreeService($model, $table, $type);
	}

	public function __construct($model, $table, $type)
	{
		$this->model = $model;

		$this->table = $table;

		$this->type = $type;
	}

	public function html($parent_id = 0)
	{
		$full_model =  '\App\Models\\'.$this->model;

        $full_model = new $full_model;

        $table_id = strtolower($this->model).'_id';

        $items =  $full_model::with('language:id,title,'.$table_id)
            ->where('parent_id', $parent_id)
            ->orderBy('position')
            ->get();

        if($items->count() == 0)
            return '';;

        $tree = '<ul class="select-parent sortable-list" data-id="'.$parent_id.'">';

        foreach($items as $k => $item)
        {
            $tree .= '<li class="page-string item-position '.($k == 0 ? ' item-position-first' : '').'" data-column="position" data-table="'.$this->table.'" data-position="'.$item->position.'" id="item-'.$item->id.'" data-id="'.$item->id.'">
                <div class="item-block d-flex align-items-center">
                    <div class="item-position"  data-table="'.$this->table.'" data-id="'.$item->id.'" data-column="parent_id"  title="Вы можете перемещать данную строку"><i class="fas fa-arrows-alt"></i>
                    </div> 
                    <div class="item-title ml-1" data-table="'.$this->table.'" data-value="'.($item->position-1).'"  data-parent_id="'.$item->parent_id.'">'.$item->language->title.'
                    </div> 
                    <div class="item-parent d-flex" data-table="'.$this->table.'" data-value="'.($item->id).'" data-column="parent_id">
                        <a href="'.route($this->table.'.edit', ['id' => $item->id]).'" class="btn btn-outline-primary btn-sm mr-1"><i class="fas fa-pencil-alt"></i>
                        </a>
                        <div class="btn btn-outline-danger delete-item btn-sm" data-url="'.route($this->table.'.delete', ['id' => $item->id]).'" data-id="'. $item->id.'"><i class="far fa-trash-alt"></i> 
                        </div> 
                    </div>

                </div>';

            $tree .= $this->html($item->id);

            $tree .= '</li>';
        }  
        $tree .= '</ul>';

        return $tree;
	}
}