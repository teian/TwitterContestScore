<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Controllers
 */

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;
use app\models\Tweet;
use app\models\Entry;

/**
 * TweetController implements the CRUD actions for Tweet model.
 */
class TweetController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Tweet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tweet::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tweet model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tweet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tweet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->UpdateEntry($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tweet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Tweet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionValidate()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tweet::find()->where(['needs_validation' => 1]),
        ]);

        return $this->render('validate', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Tweet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tweet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tweet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates all Entry of the Tweet with votecount and avg rating
     * 
     * @param \app\models\Tweet $Tweet Tweet Object
     */
    private function UpdateEntry($Tweet)
    {
        $Tweet->needs_validation = 0;
        $Tweet->save();

        $Entry = Entry::findOne($Tweet->entry_id);

        $avgQuery = new Query;
        $avgQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0]);
        $avgRating = $avgQuery->average('rating');

        $votestQuery = new Query;
        $votestQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0]);
        $votes = $votestQuery->count();

        $Entry->votes = $votes;
        $Entry->avg_rating = round($avgRating, 2);

        $Entry->save();
    }
}
