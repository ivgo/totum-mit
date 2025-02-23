<?php
/**
 * Created by PhpStorm.
 * User: tatiana
 * Date: 19.07.17
 * Time: 11:51
 */

namespace totum\common\calculates;

class CalculateSelectValue extends CalculateSelect
{
    protected bool $returnHiddenData = false;

    public function hiddenInPreparedList(bool $val)
    {
        $this->returnHiddenData = $val;
    }

    protected function funcSelectListAssoc($params)
    {
        $params = $this->getParamsArray($params, ['where', 'order']);
        unset($params['section']);
        unset($params['preview']);

        return parent::funcSelectListAssoc($params);
    }

    protected function funcSelectRowListForSelect($params)
    {
        $params = $this->getParamsArray($params, ['where', 'order'], ['previewscode', 'section', 'preview']);
        unset($params['section']);
        unset($params['preview']);

        $params['where'][] = [
            'field' => $params['bfield'] ?? 'id',
            'operator' => '=',
            'value' => $this->newVal['v']
        ];

        return parent::funcSelectRowListForSelect($params);
    }

    protected function getPreparedList($rows)
    {
        $selectList = [];
        unset($rows['previewdata']);

        if ($this->returnHiddenData) {
            foreach ($rows as $row) {
                $selectList[$row['value']] = $row['is_del'] ?? false;
            }
        } else {
            foreach ($rows as $row) {
                $selectList[$row['value']] = $row['title'];
            }
        }
        return $selectList;
    }
}
