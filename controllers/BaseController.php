<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\Controller;

use app\models\Users;
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
        if (parent::beforeAction($action)) {
            // Неавторизованный пользователь перенаправляется
            // на экшн авторизации
            if ($action->id != 'login' && Yii::$app->user->isGuest) {
                return $this->redirect(['/site/login']);
            }

            // Если находимся не в рамках звонковой сессии
            // то разрушаем php сессию
            if ($action->controller->id != 'script' and $action->id != 'view' ||
                $action->controller->id != 'session') {
                $this->destroySession();
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
        if ($this->hasMethod($mixinName)) {
            $data = call_user_func([$this, $mixinName], $data);
        }

        // Отрисовываем вьюшку с найденым именем,
        // либо стандартную, если alias не найден
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
        $users = new Users;

        // Получаем ip адрес пользователя
        $users->userIp = Yii::$app->request->userIP;

        // Ищем пользователя с таким ip в базе
        // и если не находим, то добавляем нового.
        if (!$users->getUser()) {
            $users->authKey = Yii::$app->security->generateRandomString();
            $users->accessToken = Yii::$app->security->generateRandomString();
            $users->insert();
        }

        // Логинимся текущим пользователем.
        Yii::$app->user->login($users->getUser(), 3600*24*30);

        // Перекидываем на главную страницу
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
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

    public function destroySession()
    {
        $session = Yii::$app->session;

        // проверяем наличие открытой сессии
        if ($session->isActive) {
            // очищаем данные сессии
            $session->destroy();
            // закрываем сессию
            $session->close();
        }
    }
}
