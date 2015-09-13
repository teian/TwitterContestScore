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
                        'actions' => ['index'],
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
            'query' => Tweet::find()->where(['needs_validation' => 0, 'old_vote' => 0]),
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
     * Updates an existing Tweet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // remove old entries if any present
            $this->ExcludeOldTweetEntry($model->contest_id, $model->user_id, $model->entry_id, $model->id);

            // all good, set model to validated and rerun Entry Update
            $model->needs_validation = 0;
            $model->old_vote = 0;
            $model->save();

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
            'query' => Tweet::find()->where(['needs_validation' => 1, 'old_vote' => 0]),
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
     * Creates a Tweet Object and saves it to the DB 
     * 
     * @param Array $tweet JSON Tweet structure
     * @param Array $regex regular expression to parse the rating and Entry - http://regex101.com/r/cB6oU6/7
     * @return int id of the tweet or null if an error happened
     */
    private function ExcludeOldTweetEntry($contest_id, $user_id, $entry_id, $tweet_id)
    {
        // Select old tweets of user for this entry and exlude them from the voting
        $TweetCollection = Tweet::findAll([
            'contest_id' => $contest_id, 
            'entry_id' => $entry_id,
            'user_id' => $user_id, 
            'needs_validation' => 0, 
            'old_vote' => 0
        ]);

        foreach($TweetCollection as $Tweet) 
        {
            // don't set oldvote on given tweet id 
            if($Tweet->id != $tweet_id) {
               $Tweet->old_vote = 1;
               $Tweet->save();
            }
        }
    }

    /**
     * Updates all Entry of the Tweet with votecount and avg rating
     * 
     * @param \app\models\Tweet $Tweet Tweet Object
     */
    private function UpdateEntry($Tweet)
    {
        $Entry = Entry::findOne($Tweet->entry_id);

        $avgQuery = new Query;
        $avgQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0, 'old_vote' => 0]);
        $avgRating = $avgQuery->average('rating');

        $votestQuery = new Query;
        $votestQuery->from(Tweet::tableName())->where(['entry_id' => $Entry->id, 'needs_validation' => 0, 'old_vote' => 0]);
        $votes = $votestQuery->count();

        $Entry->votes = $votes;
        $Entry->avg_rating = round($avgRating, 2);

        $Entry->save();
    }
}
