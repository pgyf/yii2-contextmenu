# yii2-contextmenu
yii2 Extended for bootstrap-contextmenu
===============================
yii2 Extended for bootstrap-contextmenu plugin https://github.com/sydcanem/bootstrap-contextmenu

Gird right - click operation, you can remove the operation column

![Effect picture 1](https://github.com/liyunfang/wr/blob/master/images/yii2-contextmenu-1.png "Effect picture 1")  

![Effect picture 2](https://github.com/liyunfang/wr/blob/master/images/yii2-contextmenu-2.png "Effect picture 2")  




Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
 composer require --prefer-dist liyunfang/yii2-contextmenu
```

or add

```
"liyunfang/yii2-contextmenu": "*"
```

to the require section of your `composer.json` file.

Requirements
------------
This extension require twitter-bootstrap

Usage
-----

Once the extension is installed, simply use it in your code by  :

GridView options
```php
 'columns' => [
    [
        'class' => \liyunfang\contextmenu\SerialColumn::className(),
        'contextMenu' => true,
        //'contextMenuAttribute' => 'id',
        'template' => '{view} {update} <li class="divider"></li> {story}', 
        'buttons' => [
             'story' => function ($url, $model) {
                 $title = Yii::t('app', 'Story');
                 $label = '<span class="glyphicon glyphicon-film"></span> ' . $title;
                 $url = \Yii::$app->getUrlManager()->createUrl(['/user/story','id' => $model->id]);
                 $options = ['tabindex' => '-1','title' => $title, 'data' => ['pjax' => '0' ,  'toggle' => 'tooltip']];
                 return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
              }
         ],
   ],
    ....
],
'rowOptions' => function($model, $key, $index, $gird){
     $contextMenuId = $gird->columns[0]->contextMenuId;
     return ['data'=>[ 'toggle' => 'context','target'=> "#".$contextMenuId ]];
 },

 ```
 
 or use KartikSerialColumn,But this requires the installation of grid Kartik extension.
 Please see https://github.com/kartik-v/yii2-grid
 
 GridView options
```php
 'columns' => [
    [
        'class' => \liyunfang\contextmenu\KartikSerialColumn::className(),
        'contextMenu' => true,
        //'contextMenuAttribute' => 'id',
        //'template' => '{view} {update}', 
        'contentOptions'=>['class'=>'kartik-sheet-style'],
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'urlCreator' => function($action, $model, $key, $index) { 
                if('update' == $action){
                    return \Yii::$app->getUrlManager()->createUrl(['/user/index','id' => $model->id]);
                }
                if('view' == $action){
                    return \Yii::$app->getUrlManager()->createUrl(['/user/view','id' => $model->id]);
                }
                return '#'; 
        },
   ],
    ....
],
'rowOptions' => function($model, $key, $index, $gird){
     $contextMenuId = $gird->columns[0]->contextMenuId;
     return ['data'=>[ 'toggle' => 'context','target'=> "#".$contextMenuId ]];
 },

 ```


该扩展为gird行右击菜单，可以省去操作列。
提供了继承yii2 grid的SerialColumn 和 继承 Kartik gird的SerialColumn。
