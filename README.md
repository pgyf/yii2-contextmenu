# yii2-contextmenu
yii2 Extended for bootstrap-contextmenu
===============================
yii2 Extended for bootstrap-contextmenu plugin https://github.com/sydcanem/bootstrap-contextmenu

![Effect picture 1](https://github.com/liyunfang/wr/blob/master/images/yii2-contextmenu-1.png "Effect picture 1")  




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
        'contextmenu' => true,
        //'contextMenuAttribute' => 'id',
        //'template' => '{view} {update}', 
   ],
    ....
],
'rowOptions' => function($model, $key, $index, $gird){
     $contextMenuId = $gird->columns[0]->contextMenuId;
     return ['data'=>[ 'toggle' => 'context','target'=> "#".$contextMenuId ]];
 },

 ```
