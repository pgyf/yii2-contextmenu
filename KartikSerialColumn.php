<?php
namespace liyunfang\contextmenu;
use kartik\helpers\Html;

/**
 * Description of kartikSerialColumn
 * ContextMenu \kartik\grid\SerialColumn
 * @author liyunfang <381296986@qq.com>
 * @date 2015-08-27
 */
class KartikSerialColumn extends \kartik\grid\SerialColumn {
    use SerialColumnTrait;
    
   /**
     * @inheritdoc
     */
    public function renderDataCell($model, $key, $index)
    {
        if(!$this->_isContextMenu){
            return parent::renderDataCell($model, $key, $index);
        }
        else{
            $options = $this->fetchContentOptions($model, $key, $index);
            $this->parseExcelFormats($options, $model, $key, $index);
            $out = $this->renderDataCellContent($model, $key, $index);
            return Html::tag('td', $out, $options);
        }
    }
    
}
