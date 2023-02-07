<?php

namespace LinkStrategy\Traits;

trait GetList
{
    public function beforeQuery()
    {
        if ($this->getProperty('export')) {
            $this->setProperty('start', 0);
            $this->setProperty('limit', 0);
        }

        return parent::beforeQuery();
    }
    public function prepareQueryBeforeCount(\xPDOQuery $c)
    {
        $c->select($this->modx->getSelectColumns($this->classKey, $this->alias));
        if (isset($this->leftJoin) && is_array($this->leftJoin)) {
            foreach ($this->leftJoin as $class => $alias) {
                if (is_array($alias)) {
                    $class = $alias['class'] ?? $class;
                    $compare = $alias['compare'];
                    if (!empty($alias['property'])) {
                        $compare .= ' = ' . $this->getProperty($alias['property']);
                    }
                    $c->leftJoin($class, $alias['alias'], $compare);
                    $c->select($this->modx->getSelectColumns($class, $alias['alias'], strtolower($alias['alias']).'_'));
                } else {
                    $c->leftJoin($class, $alias);
                    $c->select($this->modx->getSelectColumns($class, $alias, strtolower($alias).'_'));
                }
            }
        }
        if (isset(
            $this->countColumn['class'],
            $this->countColumn['alias'],
            $this->countColumn['column'],
            $this->countColumn['group']
        )
        ) {
            $c->leftJoin($this->countColumn['class'], $this->countColumn['alias']);
            $c->select([
                strtolower($this->countColumn['alias']).'_count' => 'COUNT('.$this->countColumn['column'].')'
            ]);
            $c->groupBy($this->countColumn['group']);
        }

        $where = [];
        if (isset($this->staticFilter) && is_array($this->staticFilter)) {
            foreach ($this->staticFilter as $filterName) {
                $filterValue = (int)$this->getProperty($filterName);

                if (empty($filterValue)) {
                    return $this->failure($this->modx->lexicon('basepackage.err.' . $filterName . '_ns'));
                }

                $where[$filterName] = $filterValue;
            }
        }

        if (isset($this->dynamicFilter) && is_array($this->dynamicFilter)) {
            foreach ($this->dynamicFilter as $key => $value) {
                $filterValue = $this->getProperty($key);
                if (!empty($filterValue) || $filterValue === '0') {
                    // override to allow searching specifically for empty records
                    if ($filterValue === '-') {
                        $filterValue = '';
                    }
                    if (is_array($value)) {
                        $group = [];
                        foreach ($value as $v) {
                            $group[$v] = (strpos($v, 'LIKE') !== false) ? "%{$filterValue}%" : $filterValue;
                        }
                        $where[] = $group;
                    } else {
                        $where[$value] = (strpos($value, 'LIKE') !== false) ? "%{$filterValue}%" : $filterValue;
                    }
                }
            }
        }

        if (isset($this->select) && is_array($this->select)) {
            $c->select($this->select);
        }
        if (!empty($where)) {
            $c->where($where);
        }

        $c = $this->prepareCustomProcessing($c);
        //$c->prepare();
        //$this->modx->log(1, $c->toSql());

        return parent::prepareQueryBeforeCount($c);
    }

    public function prepareCustomProcessing(\xPDOQuery $c): \xPDOQuery
    {
        return $c;
    }

    public function outputArray(array $array, $count = false)
    {
        if ($this->getProperty('export')) {
            $first = $array[0];
            if (is_object($first)) {
                $first = $first->toArray();
            }
            $filename = $this->alias.time() .'.csv';
            $fp = fopen($filename, 'w');
            fputcsv($fp, array_keys($first));
            foreach ($array as $arr) {
                fputcsv($fp, array_values($arr));
            }
            fclose($fp);
            header('Content-type: text/csv');
            header('Content-disposition:attachment; filename="'.$filename.'"');
            readfile($filename);
            return '';
        }

        return parent::outputArray($array, $count);
    }
}
