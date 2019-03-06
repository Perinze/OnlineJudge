<?php

function change_user_info(array $rel) {
    if (isset($rel['data']['sex'])) {
        if ($rel['data']['sex'] == 1) {
            $rel['data']['sex'] = '男';
        } else {
            $rel['data']['sex'] = '女';
        }

        if ($rel['data']['role'] == SUPER_ADMIN) {
            $rel['data']['role'] = SUPER_ADMIN_NAME;
        } elseif ($rel['data']['role'] == GENERAL_ADMIN) {
            $rel['data']['role'] = GENERAL_ADMIN_NAME;
        } elseif ($rel['data']['role'] == CIVILIAN) {
            $rel['data']['role'] = CIVILIAN_NAME;
        }

        // 义工服务队 队员
        $rel['data']['position'] = $rel['data']['department'].$rel['data']['position'];
    } else {
        foreach ($rel['data'] as $key => $val) {
            if ($rel['data'][$key]['sex'] == 1) {
                $rel['data'][$key]['sex'] = '男';
            } else {
                $rel['data'][$key]['sex'] = '女';
            }
            
            if ($rel['data'][$key]['role'] == SUPER_ADMIN) {
                $rel['data'][$key]['role'] = SUPER_ADMIN_NAME;
            } elseif ($rel['data'][$key]['role'] == GENERAL_ADMIN) {
                $rel['data'][$key]['role'] = GENERAL_ADMIN_NAME;
            } elseif ($rel['data'][$key]['role'] == CIVILIAN) {
                $rel['data'][$key]['role'] = CIVILIAN_NAME;
            }

            $rel['data'][$key]['position'] = $rel['data'][$key]['department'].$rel['data'][$key]['position'];
        }
    }
    return $rel;
}