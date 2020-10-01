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

function datatable_response($code, $where, $data, $model)
{
    $response = array(
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => ''
    );
    if($code === CODE_SUCCESS){
        $count = $model->where($where)->count();
        $response['recordsTotal'] = $count;
        $response['recordsFiltered'] = $count;
        $response['data'] = $data;
    }
    return json_encode($response);
}