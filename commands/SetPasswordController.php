<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Commands
 */

namespace app\commands;

use yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Json;
use app\models\User;
use \Datetime;

/**
 * Sets a new Password for an account
 */
class SetPasswordController extends Controller
{
    /**
     * This command flists all avaiable users.
     */
    public function actionIndex()
    {
        $users = User::find()->all();
        
        $count = 1;
        foreach($users as $user) {
            $this->stdout($count . ": " . $user->username . "\n");
            $count++;
        }        
    }

    /**
     * This command sets a new password for an account
     * @param string $username the user to be changed
     * @param string $newpassword the new password  to be set for the account
     */
    public function actionSet($username, $newpassword)
    {     
        $user = User::findOne(['username' => $username]);
        $user->setPassword( $newpassword );
        $user->generateAuthKey();

        if($user->validate() && $user->save()) {
            $this->stdout("New Password for User successfully saved!\n", Console::BOLD);  
        } else {
            $this->stdout("New Password for User cannot be saved!\n", Console::BOLD);  
        }
    }
}
