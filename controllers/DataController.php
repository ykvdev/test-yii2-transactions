<?php

namespace app\controllers;

use app\Helpers;
use Yii;
use app\models\Data;
use app\models\DataSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DataController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $years = Data::getAvailableYears();
        $months = Helpers::getLocalizedMonths();
        $stats = Data::getYearMonthStats();

        return $this->render('index', compact('searchModel', 'dataProvider', 'years', 'months', 'stats'));
    }
}