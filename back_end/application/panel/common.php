<?php

function aoDataFormat($aoData, $column)
{
    $aoData = json_decode($aoData, false);
    $data['offset'] = 0;
    $data['limit'] = 10;
    $data['where'] = [];
    foreach ($aoData as $key => $val) {
        if ($val->name === 'iDisplayStart') {
            $data['offset'] = $val->value;
        }
        if ($val->name === 'iDisplayLength'){
            $data['limit']= $val->value;
        }
        if ($val->name === 'sSearch' && $val->value !== '') {
            $data['where'][$column] = ['like', '%' . $val->value . '%'];
        }
    }
    return $data;
}