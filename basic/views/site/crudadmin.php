
<?php

/* @var $this yii\web\View */

use yii\helpers\Html;



foreach($test_result as $value){
	echo '<div id="" class="'.$value['id'].' row-crud"><div class="internal-box"><div class="read-box"><b>'.$value['book'].', Автора - '.$value['autor'].'</b></div><button class="btn_upd btn btn-success" id="'.$value['id'].'">upd</button><button class="btn-del btn btn-danger" id="'.$value['id'].'">del</button></div></div>';
}
echo '<div class="add-row-a row-crud"><div class="internal-box"><div class="read-box"><form class="crud-form"><input class="book_inj" type="text" name="new_row"></form></div><button class="my-btn btn btn-info">add me</button></div></div>';

$js = <<<JS

$('.btn-del').on('click', function(){
	var id_for_del = this.id;
	$('.'+id_for_del).remove();
	$.ajax({
		type: 'POST',
		url: 'http://localhost/yii2/basic/web/index.php?r=site%2Fcrudadmin',
		data: {del: id_for_del},
		success: function(data){
			//alert(data);
		}
	});
});

$('.btn_upd').on('click', function(){	
	var desired_value = this.id;
	$.ajax({
		type: 'POST', 
		url: 'http://localhost/yii2/basic/web/index.php?r=site%2Fcrudadmin',
		data: {upd: this.id},
		success: function(data){
			var upd_length = data.length;
			if(upd_length => 1){
				$('.'+desired_value+' .internal-box .read-box').html('<b>'+data+', Автора - Новый автор</b>');
			}
		}
	});
});


$('.my-btn').on('click', function(){
	var injection = $('.book_inj').val();
	jQuery.ajax({
		type: 'POST',
		url: 'http://localhost/yii2/basic/web/index.php?r=site%2Fcrudadmin',
		data: {test: injection},
		success: function(data){
			var length = $('.row-crud').length;
			length = length - 2;
		
			$('.row-crud').each(function(i, elem){
				if(i == length){
					var new_elem = $(elem);
					var new_number = new_elem.children('div').parent().attr('class').split(" ")[0].split(" ").join("");
					$('.'+new_number).after('<div id="" class="'+JSON.parse(data).last_id+' row-crud"><div class="internal-box"><div class="read-box"><b>'+JSON.parse(data).last_book+', Автора - '+JSON.parse(data).last_autor+'</b></div><button class="btn_upd btn btn-success" id="'+JSON.parse(data).last_id+'">upd</button><button class="btn-del btn btn-danger" id="'+JSON.parse(data).last_id+'">del</button></div></div>');
				}
			});
		
		
		
			$('.btn-del').on('click', function(){
				var id_for_del = this.id;
				$('.'+id_for_del).remove();
				$.ajax({
					type: 'POST',
					url: 'http://localhost/yii2/basic/web/index.php?r=site%2Fcrudadmin',
					data: {del: id_for_del},
					success: function(data){
						//alert(data);
					}
				});
			});

		}
	});
});

JS;
$this->registerJs($js);
?>