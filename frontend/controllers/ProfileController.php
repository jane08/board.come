<?php

namespace frontend\controllers;

use Yii;
use common\models\Profile;
use common\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\BaseFileHelper;
use common\models\User;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
		  if (!Yii::$app->user->can('admin')) {
			   throw new ForbiddenHttpException('Только администратор может просматривать эту страницу!');
		   }
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);


        if (Yii::$app->user->identity->id != $model->user_id) {
            throw new ForbiddenHttpException('Вы не можете заходить в чужой профиль!');
        }

        $profile=$model;
       // $user = User::find()->where(['id'=>$profile->user_id])->one();
        return $this->render('view', [
            'profile' => $profile,
          //  'user' => $user,
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('admin')) {
            throw new ForbiddenHttpException('Вы не можете создавать профили');
        }
        /*
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        */
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->id != $model->user_id) {
            throw new ForbiddenHttpException('Вы не можете заходить в чужой профиль!');
        }
		
		 $picture = new Files();
         $files_usage = FilesUsage::find()
            ->where(['entity_id' => $model->id,'entity_type' => 'profile'])
            ->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			if ($picture->load(Yii::$app->request->post()) ) {
				
				if(!empty(UploadedFile::getInstances($picture, 'file'))){
				
				
				 $files_usage = FilesUsage::find()
								->where(['entity_id' => $id, 'entity_type' => 'profile'])
								->one();
				 $file = Files::find()
							->where(['id' => $files_usage->file_id])
							->one();
					$basepath =  \Yii::$app->basePath;	
							
						if(isset($files_usage)){
							$files_usage->delete();
						}
						if(isset($file)){
							
							if (file_exists(($basepath).'/web/'.$file->path)) {
								
							unlink(($basepath).'/web/'.$file->path);
						}	
							
							$file->delete();
						}		
						
					$this->UploadFiles($model,$picture);
				}
				
				 return $this->redirect(['view', 'id' => $model->id]);	
			}
				
		}
			
           
         else {
            return $this->render('update', [
                'model' => $model,
				'picture' => $picture,
				'files_usage' => $files_usage,
            ]);
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	
	public function UploadFiles($model,$picture)
    {
		 $obj_id=$model->id;	
		 $picture->file = UploadedFile::getInstances($picture, 'file');
//Creating directory
        $BaseFileHelper=new BaseFileHelper();
        $date = new  \DateTime('now', new \DateTimeZone('Europe/Kiev'));
        $date=$date->format('Y-m-d');
        list($y, $m, $d) = explode("-", $date);
        $BaseFileHelper->createDirectory ((\Yii::$app->basePath).'/web/uploads/'.$obj_id.'_'.$y.'/'.$m.$d.'/', $mode = 0777, $recursive = true );
         $date = new  \DateTime('now', new \DateTimeZone('Europe/Kiev'));
		 $added_date = $date->format('Y-m-d H:i:s');
//--- end of creating directory
            foreach ($picture->file as $file) {
			
			$picture2 = new Files();
			 $files_usage = new FilesUsage();
			$filename= md5(microtime() . rand(0, 9999));
			
			$picture2->load(Yii::$app->request->post());
			$filepath=(\Yii::$app->basePath).'/web/uploads/'.$obj_id.'_'.$y.'/'.$m.$d.'/'. $filename. '.' . $file->extension ;
			
			 $filename=$this->getRandomFileName($filepath,($added_date),$filename);
			
			
			$picture2->path='/uploads/'.$obj_id.'_'.$y.'/'.$m.$d.'/'. $filename. '.' . $file->extension ;
			//$picture2->object_id=$model->id;
			
                $file->saveAs($filepath);
				$picture2->save(false);	




							$files_usage->file_id = $picture2->id;
                            $files_usage->entity_type = 'profile';
                            $files_usage->entity_id = $model->id;
                            $files_usage->status = 1;
                            $files_usage->name = '';
                            $files_usage->save();

				
            }
	}
	
		//Rename files if exist
	public  function getRandomFileName($filepath,$date,$name)
	{
			   if (file_exists ( $filepath )){
	 $filename= md5(microtime() . rand(0, 9999));

	 }
	 else{
	  $filename= $name;  
	 }
	   return $filename;                    

	}
	

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
