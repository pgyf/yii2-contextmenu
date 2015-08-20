<?php
namespace liyunfang\contextmenu;

use \yii\web\AssetBundle;
/**
 * Description of ContextmenuAsset
 *
 * @author liyunfang <381296986@qq.com>
 * @date 2015-08-19
 */
class ContextmenuAsset  extends AssetBundle{
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/bootstrap-contextmenu.js']);
        parent::init();
    }
    
  
    public $depends=[
        //'backend\assets\AppAsset',
    ];
    
}
