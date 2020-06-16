<?php

namespace App;

class GlobalConfig {
    static function getListStatus() {
        return [
            0 => __('global_config.status.not_pickup'),
            1 => __('global_config.status.shipping'),
            2 => __('global_config.status.delivered')
        ];
    }
}