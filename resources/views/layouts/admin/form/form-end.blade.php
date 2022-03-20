<?php
    $title = isset($title) ? $title : 'Сохранить';
?>
    <div class="form-block text-right row">
        <div class=" col-12 p-3 text-right">
            <button type="submit" class="btn btn-outline-primary" {{ $data ?? null }}><i class="far fa-save"></i> @lang($title)</button>
        </div>
    </div>
</form>