<?php
class DatabaseUtil {
    public static function build_filters(&$param) {
        $criteria = "where 1";
        $param = array();
        if (isset($_REQUEST['filters'])) {
            $filters = json_decode($_REQUEST['filters'], true);
            foreach ($filters as $filter) {
                $key = $filter['key'];
                $ekey = preg_replace("/\./", "_", $key);
                $value = $filter['value'];
                $criteria .= " and $key = :$ekey";
                $param[$ekey] = $value;
            }
        }
//         echo $criteria;
//         echo json_encode($param);
        return $criteria;
    }
}