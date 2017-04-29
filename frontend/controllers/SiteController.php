<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Profile;
use common\models\Category;
use common\models\SubCategory;
use common\models\Ad;
use common\models\Rating;
use common\models\User;
use yii\data\Pagination;
use common\models\AuthAssignment;
use yii\web\Session;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($id=0)
    {

       $session = Yii::$app->session;
        $session['subcat_id']=$id;
        $session->open();
        if($session['subcat_id']!=0) {
           // echo "<br><br><br>". $session['subcat_id'];
           // $session->destroy();
            $query = Ad::find()->where(['subcategory_id' =>$session['subcat_id']]);
        }
        else {
            $query = Ad::find();
        }
        //$session->destroy();
		$session->remove('subcat_id');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20]);
        $ads = $query->offset($pagination->offset)
            ->orderBy([
                'updated_at' => SORT_DESC
            ])
            ->limit(20)
            ->all();

        $categories = Category::find()->all();

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $subcat_id= explode(":", $data['subcat_id']);
            $subcat_id= $subcat_id[0];

//             $session = Yii::$app->session;
//             $session->open();
             $session['subcat_id'] = $subcat_id;
            // echo "<br><br><br>". $session['subcat_id'];

            $query = Ad::find()->where(['subcategory_id' =>$subcat_id]);
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>20]);

            $ads = $query->offset($pagination->offset)
                ->orderBy([
                    'updated_at' => SORT_DESC
                ])
                ->limit(20)
                ->all();

            return $this->renderAjax('show_ads', [
                'ads' => $ads,
                'pagination' => $pagination,

            ]);

        }


        return $this->render('index', [
            'ads' => $ads,
            'pagination' => $pagination,
            'categories' => $categories,
        ]);
    }

    public function actionAdDetails($id)
    {

        $ad = Ad::find()->where(['id' => $id ])->one();
        $profile = Profile::find()->where(['user_id' => $ad->user_id ])->one();
        $rating = Rating::find()->where(['entity_id' => $profile->user_id])->all();
		
		if (!Yii::$app->user->isGuest)
        $user=User::find()->where(['id' => Yii::$app->user->identity->id ])->one();
		
		
		if(isset($user)){
        $rateuser = Rating::find()->where(['user_id' => $user->id, 'entity_id' => $profile->user_id, 'entity_type' =>'user'])->one();
		
		}
		else{
			$rateuser=0;
			
		}
		
		
		
        return $this->render('ad_details', [
            'ad' => $ad,
            'profile' => $profile,
            'rating' => $rating,
            'rateuser' => $rateuser,

        ]);
    }


    public function actionShowSubCat()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $category_id= explode(":", $data['category_id']);
            $category_id= $category_id[0];

            $subcats=SubCategory::find()
                ->where(['category_id' =>$category_id])
                ->all();


            return $this->renderAjax('show_subcats', [
                'subcats' => $subcats,


            ]);

        }
    }

    public function ShowAds()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $subcat_id= explode(":", $data['subcat_id']);
            $subcat_id= $subcat_id[0];

           /* $session = Yii::$app->session;

            $session->open();
            $session['subcat_id'] = $subcat_id;
            echo "<br><br><br>". $session['subcat_id'];*/

            $query = Ad::find()->where(['subcategory_id' =>$subcat_id]);
            $count = $query->count();
            $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>5]);

            $ads = $query->offset($pagination->offset)
                ->orderBy([
                    'updated_at' => SORT_DESC
                ])
                ->limit(5)
                ->all();

            return $this->renderAjax('show_ads', [
                'ads' => $ads,
                'pagination' => $pagination,

            ]);

        }
    }


    public function actionProfileAds($id)
    {

        $profile = Profile::find()->where(['id' => $id ])->one();
        $ads = Ad::find()->where(['user_id' => $profile->user_id ])->all();

        return $this->render('profile_ads', [
            'ads' => $ads,
            'profile' => $profile,

        ]);
    }


    public function actionAddRating()
    {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $stars = explode(":", $data['stars']);
            $stars = $stars[0];
            $user_id = explode(":", $data['user_id']);
            $user_id = $user_id[0];
            $status = explode(":", $data['status']);
            $status = $status[0];
            $currentuser = explode(":", $data['currentuser']);
            $currentuser = $currentuser[0];

            if($currentuser!=$user_id) {

                if ($status == 0) {
                    $rating = new Rating();
                    $rating->user_id = Yii::$app->user->identity->id;
                    $rating->entity_id = $user_id;
                    $rating->entity_type = 'user';
                    $rating->rate = $stars;
                    $rating->status = 1;
                    $rating->save();



                    $profile = Profile::find()->where(['user_id' => $user_id ])->one();
                    $rating = Rating::find()->where(['entity_id' => $profile->user_id])->all();
                    $user=User::find()->where(['id' => Yii::$app->user->identity->id ])->one();
                    $rateuser = Rating::find()->where(['user_id' => $user->id, 'entity_id' => $profile->user_id, 'entity_type' =>'user'])->one();

                    return $this->renderAjax('show_rating', [

                        'profile' => $profile,
                        'rating' => $rating,
                        'rateuser' => $rateuser,

                    ]);


                }
            }
        }
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
		
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {


                /*$as = new AuthAssignment();
                $as->user_id = $user->id;
                $as->item_name = 'advertiser';*/
                $sql = 'INSERT INTO `auth_assignment`(`item_name`, `user_id`) VALUES ("advertiser","'.($user->id).'")';
                $command = \Yii::$app->db->createCommand($sql);
                $command->execute();



				$profile = new Profile();
				$profile->user_id = $user->id;
				$profile->save();
				
                if (Yii::$app->getUser()->login($user)) {
					
				
					
                    Yii::$app->response->redirect(['profile/update/'. $profile->id]);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
