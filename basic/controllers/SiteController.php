<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Test;

class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }



	public function actionCrudadmin(){

		if(Yii::$app->request->isAjax){
			if(isset($_POST['test'])){
				$model = new Test();
				$model->book = $_POST['test'];
				$model->autor = 'Новый автор';
				$model->save();
				$last_id = $model->id;
				$last_book = $model->book;
				$last_autor = $model->autor;
				$last_arr = ['last_id' => $last_id, 'last_book' => $last_book, 'last_autor' => $last_autor];
				return json_encode($last_arr);
				//return 'crt ok';
			}
			
			if(isset($_POST['upd'])){
				$res_for_update = Test::findOne($_POST['upd']);
				$res_for_update->book = 'Книга о Гарри Поттере';
				$res_for_update->save();
				return $res_for_update->book;
				//return 'upd ok';
			}
			
			if(isset($_POST['del'])){
				$del = Test::findOne($_POST['del']);
				$del->delete();
				//return 'del ok';
			}
			
		}
		else{
			$test_result = Test::find()->asArray()->all();
			return $this->render('crudadmin', compact('test_result'));
		}
		
		

	}
}
