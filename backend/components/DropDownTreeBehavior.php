<?php
namespace backend\components;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;

class DropDownTreeBehavior extends Behavior
{
    const POSTFIX = '*';

    /**
     * @var
     */
    private $_list;

    /**
     * @param $model
     * @return array
     */
    public function getTree($model)
    {
        if ($model) {
            $this->_list = [];
            $this->_createList($model);
            return ArrayHelper::map(ArrayHelper::merge([['id' => '0', 'name' => 'Не выбрано']],$this->_list),'id','name');
        }
    }

    /**
     * @param null $items
     * @param int $parent_id
     * @param string $t
     */
    private function _createList($items = null, $parent_id = 0, $t = '-')
    {
        if ($items != null) {
            $t = $t.self::POSTFIX;
            foreach ($items as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $this->_list[$item['id']]['id'] = $item['id'];
                    $this->_list[$item['id']]['name'] = $t.$item['name'];
                    $this->_createList($items, $item['id'], $t);
                }
            }
        }
    }
}