<?php
class GeoJsonUtil {
    public static function generate2DPolygon($attribute, $exitedPolygon = null)
    {
        if (!empty($exitedPolygon)) {
            $exitedPolygon['geometry']['coordinates'][0][] = array(floatval($attribute['x']), floatval($attribute['y']));
            return $exitedPolygon;
        }
        return array(
            "type" => "Feature",
            "properties" => $attribute,
            "geometry" => array (
                "type" => "Polygon",
                "coordinates" => array(
                    array (
                        array(floatval($attribute['x']), floatval($attribute['y']))
                    )
                )
            ),
            "id" => "pp".$attribute['idpo']
        );
    }
    public static function generate2DLine($attribute, $exitedLine = null) {
        if (!empty($exitedLine)) {
            $exitedLine['geometry']['coordinates'][] = array(floatval($attribute['x']), floatval($attribute['y']));
            return $exitedLine;
        }
        return array(
            "type" => "Feature",
            "properties" => $attribute,
            "geometry" => array (
                "type" => "LineString",
                "coordinates" => array(
                        array(floatval($attribute['x']), floatval($attribute['y']))
                )
            ),
            "id" => "l".$attribute['idl']
        );
    }
}