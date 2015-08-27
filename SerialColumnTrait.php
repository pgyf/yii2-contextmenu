<?php
namespace liyunfang\contextmenu;

use Yii;
use Closure;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Description of SerialColumnTrait
 *
 * @author liyunfang <381296986@qq.com>
 * @date 2015-08-27
 */
trait SerialColumnTrait {

    /**
     * Use contextMenu
     */
    public $contextMenu = true;
    private $_isContextMenu = false;
    private $_contextMenuId = '';



    /**
     * The prefix of contextMenu ID
     */
    public $contextMenuPrefix = "context-menu";
    /**
     * contextMenu ID is generated dynamically by the property
     */
    public $contextMenuAttribute = false;



    //if extends \kartik\grid\ActionColumn,
    public $viewOptions = [ 'data' => ['pjax' => '0' ,  'toggle' => 'tooltip']];
    public $updateOptions = [ 'data' => ['pjax' => '0' ,  'toggle' => 'tooltip']];
    public $deleteOptions = [ 'data' => ['pjax' => '0' ,  'toggle' => 'tooltip' , 'method' => 'post' ]];
    
    
    public function init() {
        $this->_isContextMenu = ($this->grid->bootstrap && $this->contextMenu);
        parent::init();

        if($this->_isContextMenu){
            $this->initDefaultButtons();
            $this->registerAssets();           
        }
    }
    
    protected function initDefaultButtons() {
        if(!$this->_isContextMenu){
            parent::initDefaultButtons();
        }
        else{
            if (!isset($this->buttons['view'])) {
                 $this->buttons['view'] = function ($url, $model) {
                    $options = $this->viewOptions;
                    $title = Yii::t('yii', 'View');
                    $icon = '<span class="glyphicon glyphicon-eye-open"></span>';
                    $label = ArrayHelper::remove($options, 'label',  $icon . ' ' . $title );
                    $options = ArrayHelper::merge(['title' => $title], $options);
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                 };
            }
            if (!isset($this->buttons['update'])) {
                 $this->buttons['update'] = function ($url, $model) {
                    $options = $this->updateOptions;
                    $title = Yii::t('yii', 'Update');
                    $icon = '<span class="glyphicon glyphicon-pencil"></span>';
                    $label = ArrayHelper::remove($options, 'label', $icon . ' ' . $title);
                    $options = ArrayHelper::merge(['title' => $title], $options);
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                 };
            }
            if (!isset($this->buttons['delete'])) {
                 $this->buttons['delete'] = function ($url, $model) {
                    $options = $this->deleteOptions;
                    $title = Yii::t('yii', 'Delete');
                    $icon = '<span class="glyphicon glyphicon-trash"></span>';
                    $label = ArrayHelper::remove($options, 'label', $icon . ' ' . $title);
                    $options = ArrayHelper::merge([ 'title' => $title, 'data' => ['confirm' => Yii::t('yii', 'Are you sure you want to delete this item?') ] ],$options);
                    $options['tabindex'] = '-1';
                    return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL;
                 };
            }
        }
    }
    
    
    protected function renderDataCellContent($model, $key, $index) {
        $pageNumContent = parent::renderDataCellContent($model, $key, $index);
        if(!$this->_isContextMenu){
            return  $pageNumContent;
        }
        else{
            $content = $this->actionRenderDataCellContent($model, $key, $index);
            
            $contextMenuId = '';
            if($this->contextMenuPrefix){
                $contextMenuId = $this->contextMenuPrefix.'-';
            }
            if(!$this->contextMenuAttribute){
                $contextMenuId .= $this->grid->getId().'-'.$index;
            }
            else{
                $contextMenuId .= $model->{$this->contextMenuAttribute};
            }
            $this->_contextMenuId = $contextMenuId;
            $dropdown = Html::tag('ul', $content, ['class' => 'dropdown-menu' , 'role' => 'menu']);
            return  $pageNumContent.PHP_EOL . Html::tag('div', $dropdown, [ 'id' => $contextMenuId , 'style' => 'display:block;' ]);
        }
    }
    
    
    /**
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        if(!$this->_isContextMenu){
            return parent::renderDataCell($model, $key, $index);
        }
        else{
            if ($this->contentOptions instanceof \Closure) {
                $options = call_user_func($this->contentOptions, $model, $key, $index, $this);
            } else {
                $options = $this->contentOptions;
            }

            return Html::tag('td', $this->renderDataCellContent($model, $key, $index), $options);
        }
    }
    
    
   /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->grid->getView();
        ContextmenuAsset::register($view);
    }
    
    
    public function getContextMenuId(){
        return $this->_contextMenuId;
    }








    /**
     * @var string the ID of the controller that should handle the actions specified here.
     * If not set, it will use the currently active controller. This property is mainly used by
     * [[urlCreator]] to create URLs for different actions. The value of this property will be prefixed
     * to each action name to form the route of the action.
     */
    public $controller;
    /**
     * @var string the template used for composing each cell in the action column.
     * Tokens enclosed within curly brackets are treated as controller action IDs (also called *button names*
     * in the context of action column). They will be replaced by the corresponding button rendering callbacks
     * specified in [[buttons]]. For example, the token `{view}` will be replaced by the result of
     * the callback `buttons['view']`. If a callback cannot be found, the token will be replaced with an empty string.
     *
     * As an example, to only have the view, and update button you can add the ActionColumn to your GridView columns as follows:
     *
     * ```
     * ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
     * ```
     *
     * @see buttons
     */
    public $template = '{view} {update} {delete}';
    /**
     * @var array button rendering callbacks. The array keys are the button names (without curly brackets),
     * and the values are the corresponding button rendering callbacks. The callbacks should use the following
     * signature:
     *
     * ```php
     * function ($url, $model, $key) {
     *     // return the button HTML code
     * }
     * ```
     *
     * where `$url` is the URL that the column creates for the button, `$model` is the model object
     * being rendered for the current row, and `$key` is the key of the model in the data provider array.
     *
     * You can add further conditions to the button, for example only display it, when the model is
     * editable (here assuming you have a status field that indicates that):
     *
     * ```php
     * [
     *     'update' => function ($url, $model, $key) {
     *         return $model->status === 'editable' ? Html::a('Update', $url) : '';
     *     },
     * ],
     * ```
     */
    public $buttons = [];
    /**
     * @var callable a callback that creates a button URL using the specified model information.
     * The signature of the callback should be the same as that of [[createUrl()]].
     * If this property is not set, button URLs will be created using [[createUrl()]].
     */
    public $urlCreator;
    /**
     * @var array html options to be applied to the [[initDefaultButtons()|default buttons]].
     * @since 2.0.4
     */
    public $buttonOptions = [];




    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the current row index
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index)
    {
        if ($this->urlCreator instanceof Closure) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string) $key];
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }

    /**
     * @inheritdoc
     */
    protected function actionRenderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);

                return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $this->template);
    }
}
