<?php

namespace frontend\controllers;

use Yii;
use common\models\Ad;
use common\models\AdSearch;
use common\models\SubCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use common\models\Files;
use common\models\FilesUsage;
use yii\helpers\BaseFileHelper;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends Controller
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
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ad model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->id != $model->user_id) {
            throw new ForbiddenHttpException('Вы не можете редактировать чужие объявления!');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ad();
        $picture = new Files();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->identity->id;
            $date = new  \DateTime('now', new \DateTimeZone('Europe/Kiev'));

            $model->created_at = $date->format('Y-m-d H:i:s');
            $model->updated_at = $date->format('Y-m-d H:i:s');

            $model->save();

            if ($picture->load(Yii::$app->request->post()) ) {
                // $picture->first=2;
                $this->UploadFiles($model,$picture);

            }


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'picture' => $picture,
            ]);
        }
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if (Yii::$app->user->identity->id != $model->user_id) {
            throw new ForbiddenHttpException('Вы не можете редактировать чужие объявления!');
        }


        $picture = new Files();
        $files_usage = FilesUsage::find()
            ->where(['entity_id' => $model->id,'entity_type' => 'ad'])
            ->all();

        if ($model->load(Yii::$app->request->post())  ) {
            $date = new  \DateTime('now', new \DateTimeZone('Europe/Kiev'));
            $model->updated_at = $date->format('Y-m-d H:i:s');
            $model->save();


            if ($picture->load(Yii::$app->request->post()) ) {

                if(!empty(UploadedFile::getInstances($picture, 'file'))){


                    $files_usage = FilesUsage::find()
                        ->where(['entity_id' => $id, 'entity_type' => 'ad'])
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
        } else {
            return $this->render('update', [
                'model' => $model,
                'picture' => $picture,
                'files_usage' => $files_usage,
            ]);
        }
    }

    /**
     * Deletes an existing Ad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionSubCatList()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $category_id= explode(":", $data['category_id']);
            $category_id= $category_id[0];



            $subcats=SubCategory::find()
                ->where(['category_id' =>$category_id])
                ->all();
            echo "<option>Выберите подкатегорию</option>";
            foreach($subcats AS $subcat){
                echo "<option value='".($subcat->id)."'>".($subcat->name)." </option>";
            }
        }
    }


    /**
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
            $files_usage->entity_type = 'ad';
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


}
