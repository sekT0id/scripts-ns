<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\web\Controller;

use app\models\LoginForm;

class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
        ];
    }

    public function beforeAction($action)
    {
        // Неавторизованный пользователь перенаправляется
        // на страницу авторизации
        if (parent::beforeAction($action)) {
            if ($action->id != 'login' && Yii::$app->user->isGuest) {
                return $this->redirect(['site/login']);
            }
            return true;
        }
    }

    public function actionIndex()
    {
        return $this->actionView('index');
    }

    public function actionView($alias)
    {
        // хранилище даннх передаваемое во вьюхи
        $data = [];

        // Определяем пользовательские миксины
        $mixinName = 'mixin';

        // Приводим имя миксина к удобоваримому виду
        $words = preg_split('/-|_| /', $alias);

        foreach ($words as $key => $word) {
            $mixinName .= ucfirst($word);
        }

        // Исполняем пользовательские миксины
        if ( $this->hasMethod($mixinName) ) {
            $data = call_user_func([$this, $mixinName], $data);
        }

        // Отрисовываем вьюшку с найденым именем, либо стандартную, если alias не найден
        if (file_exists($this->viewPath . DIRECTORY_SEPARATOR . $alias . '.php')) {
            return $this->render($alias, $data);
        }
        return $this->render('default', $data);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
