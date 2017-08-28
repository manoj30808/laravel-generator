<?php namespace MspPack\DDSGenerate\Helpers;
use Illuminate\Support\Str;
class EloquentHelper
{

    public function allInOne($query, $params = array())
    {
        if(!empty($params['filter']) && is_array($params['filter'])){
            foreach($params['filter'] as $column => $row){
                if(!empty($column) && !empty($row["value"]) && is_array($row)){
                    //$operator = config("setup.oprators.".$row["oprator"], $row["oprator"]);
                    $operator = '=';
                    $column = (!empty($row["alias"])) ? $row["alias"] : $column;
                    $query->where($column, $operator, $row["value"]);
                }
            }
        }

        if(!empty($params['sort']) && is_array($params['sort'])){
            foreach($params['sort'] as $column => $direction){
                $query->orderBy($column, $direction);
            }
        }

        if(!empty($params['paginate']) && $params['paginate']){
            return $query->paginate(config("setup.par_page", 10));
        }else{
            if(!empty($params['single']) && $params['single']){
                return $query->first();
            }else{
                return $query->get();
            }
        }

        return $query->get();
    }

    // ============================================= 
    /* menthod : updateTableField
    * @param  : array
    * @Description : use for make array as per DBA package require
    */// ==============================================    
    function updateTableField($data=array())
    {
        $table_name = Str::plural($data['name']); 
        $o['name'] = $table_name;
        $o['oldName'] = $table_name;

        foreach ($data['row'] as $key => $value) {
            $o['columns'][$key] = array(
                'name' => $value['field'],
                'oldName' => isset($value['field_old_name'])?$value['field']:'',
                'type' => array(
                    'name' => ($value['input_type']=='string')?'varchar':$value['input_type']
                ),
                'null' => 'YES',
            );
        }
        $o['columns'][] = array(
            'name' => 'deleted',
            'oldName' => 'deleted',
            'type' => array('name' => 'tinyint'),
            'default' => '0'
        );

        $o['columns'][] = self::idColoumn();
        $o['columns'][] = self::created();
        $o['columns'][] = self::updated();
        $o['indexes'] = self::indexesAry($table_name);
        $o['primaryKeyName'] = 'primary';
        $o['foreignKeys'] = array();
        $o['options'] = array();
        
        return $o;
    }

    function idColoumn()
    {
        return array(
            'name' => 'id',
            'type' => array(
                'name' => 'integer',
                'category' => 'Numbers',
                'default' => array(
                    'type' => 'number',
                    'step' => 'any',
                )
            ),
            /*'default' => '',
            'notnull' => 1,
            'length' => '',
            'precision' => '10',
            'scale' => '0',
            'fixed' => '',
            'unsigned' => '1',*/
            'autoincrement' => '1',
            /*'columnDefinition' => '',
            'comment' => '',*/
            'oldName' => 'id',
            'null' => 'NO',
            'extra' => 'auto_increment',
            //'composite' => '',
        );
    }

    function indexesAry($table='')
    {
        $indexs[] = array(
            'name' => 'PRIMARY',
            'oldName' => 'PRIMARY',
            'columns' => array('id'),
            'type' => 'PRIMARY',
            'isPrimary' => 1,
            'isUnique' => 1,
            'isComposite' =>'',
            'flags' => array(),
            'options' => array(),
            'table' => $table
        );
        return $indexs;
    }

    function created()
    {
        return array(
            'name' => 'created_at',
            'type' => array(
                'name' => 'timestamp',
                'category' => 'Date and Time',
            ),
            'default' => '2017-06-16 11:49:50',
            /*'notnull' => '',
            'length' => '',
            'precision' => '10',
            'scale' =>'0',
            'fixed' => '',
            'unsigned' => '',
            'autoincrement' => '',
            'columnDefinition' => '',
            'comment' => '',*/
            'oldName' => 'created_at',
            //'null' => 'YES'
            /*'extra' => '',
            'composite' => '',*/
        );
    }

    function updated()
    {
        return array(
            'name' => 'updated_at',
            'type' => array(
                'name' => 'timestamp',
                'category' => 'Date and Time',
            ),
            'default' => '2017-06-16 11:49:55',
           /* 'notnull' => '',
            'length' => '',
            'precision' => '10',
            'scale' =>'0',
            'fixed' => '',
            'unsigned' => '',
            'autoincrement' => '',
            'columnDefinition' => '',
            'comment' => '',*/
            'oldName' => 'updated_at',
            //'null' => 'YES'
            /*'extra' => '',
            'composite' => '',*/
        );
    }
}