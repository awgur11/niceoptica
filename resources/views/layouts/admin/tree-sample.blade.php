<style type="text/css">
    .page-string{
        margin-top: 15px;
    }
	.item-block {
		padding: 5px;
        background-color: #f9f9f9;
        border:1px solid #999;
        //cursor: grab;
        position: relative;
        z-index: 9;
        max-width: 250px;
        display: inline-block;
	}
    .item-block:after{
        position: absolute;
        content: "";
        width: 100%;
        height: 15px;
        background-color: #fdd;
        top: 0;
        transform: translateY(-100%);
        left: 0;
        opacity: 0;
        transition: 0.3s;
        border-radius: 10px;
    }
    .item-block.over:after{
        opacity: 1;
    }
    .item-block:before{
        position: absolute;
         border-radius: 10px;
        content: "";
        width: 20px;
        height: 100%;
        background-color: #fdd;
        right: 0;
        transform: translateX(100%);
        top: 0;
        opacity: 0;
        transition: 0.3s;
    }
    .item-block.back:before{
        opacity: 1;
    }
    .item-block:not(.ui-draggable-dragging){
        transition: 0.3s;
    }
    li{
        list-style-type: none; /* Убираем маркеры */
    }
    .item-title{
        display: inline-block;
        width: 150px!important;
        margin-right: 10px;
        overflow: hidden;
        white-space: nowrap;
        cursor: grab;
        width: 250px;
        overflow: hidden;
        transition: 0.3s;
    }
    .item-title:active {
        cursor: grabbing;
        cursor: -moz-grabbing;
        cursor: -webkit-grabbing;
    }
    .item-parent{
        transition: 0.3s;
    }
</style>

<script type="text/javascript">
$(document).ready(function(){
	$( "ul.select-parent li .item-block:not(.not-draggable)" ).draggable({
        opacity: 0.6,
        revert: true,
        cursor: "grab",
        containment: '.page-content',
        start: function(){
            $(this).css({
                'z-index': 9999,
                'width' : '100px',
            });
        },
        stop: function(event, ui){
            $(this).css({
                'z-index': 1,
                'width' : '250px',
        });
        },
        drag: function(event, ui){
          //  $(this).css({'cursor': 'grabbing'});
        }
    });
    $( "ul.select-parent li .item-block .item-title").droppable({

        over: function() {
            $(this).css({         
          //      backgroundColor: "#ddf"
            });
            $(this).parent().addClass('over');
            $(this).css({
            //    transform: 'translateY(-10px)'
            });
        },

        out: function() {
            $(this).css({
           //    backgroundColor: "#f9f9f9",
            });
            $(this).parent().removeClass('over');
            $(this).css({
                transform: 'translateY(0)'
            });
        },

        drop: function(event, ui){
            var data = {};
            data.value = $(this).data('value');
            data.table = $(this).data('table');
            data.column = 'position';
            data.id = ui.draggable.children('.item-position').data('id');
            change_cell(data);

            data = {};
            data.value = $(this).data('parent_id');
            data.table = $(this).data('table');
            data.column = 'parent_id';
            data.id = ui.draggable.children('.item-position').data('id');
            change_cell(data);


            setTimeout(reload, 500);

            function reload()
            {
                location.reload();
            }
        }
    });
    $( "ul.select-parent li .item-block .item-parent").droppable({

        over: function() {
            $(this).css({         
          //      backgroundColor: "#ddf"
            });
            $(this).parent().addClass('back');
            $(this).css({
              //  transform: 'translateX(10px)'
            });
        },

        out: function() {
            $(this).css({
           //    backgroundColor: "#f9f9f9",
            });
            $(this).parent().removeClass('back');
            $(this).css({
               // transform: 'translateX(0)'
            });
        },

        drop: function(event, ui){
            var data = {};
            data.value = $(this).data('value');
            data.table = $(this).data('table');
            data.column = 'parent_id';
            data.id = ui.draggable.children('.item-position').data('id');
            console.log(data);
            change_cell(data);
            setTimeout(reload, 500);

            function reload()
            {
                location.reload();
            }
        }
    });
});
</script>
<ul class="select-parent">
    <li class="page-string this-is-root"  id="item-0" data-id="item-0">
        <span class="item-block not-draggable  " style="z-index: 9" >
            <span class="btn btn-info btn-xs item-position item-parent"  data-table="pages" data-value="0" data-column="parent_id" title='@lang("You cant move this row")' style="width: 200px;">Корневой каталог</span> 
        </span>
        {!! $tree !!}
    </li>
</ul>
