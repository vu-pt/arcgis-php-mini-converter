<?php

class SpaghettiGeoJsonConverter implements BaseConverter
{
    function getJsonData()
    {
        $polygon_query = <<<EOI
        select pp.idpo, po.name, po.description, p.idp, p.x, p.y, pp.seq 
        from tsp_polygon_point pp
        left join tsp_polygon po on pp.idpo = po.idpo
        left join tsp_point p on pp.idp = p.idp
        order by po.idpo, pp.seq
EOI;
        $polygons = Connection::query($polygon_query);
        $current_polygon_id = null;
        $current_polygon = null;
        foreach ($polygons as $polygon) {
            if ($current_polygon_id != $polygon['idpo']){
                if($current_polygon != null) {
                    $result[] = $current_polygon;
                }
                $current_polygon = GeoJsonUtil::generate2DPolygon($polygon);
                $current_polygon_id = $polygon['idpo'];
            } else {
                $current_polygon = GeoJsonUtil::generate2DPolygon($polygon, $current_polygon);;
            }
        }
        if($current_polygon != null) {
            $result[] = $current_polygon;
        }

        return array (
            "type" => "FeatureCollection",
            "metadata" => array (
                "count" => sizeof($result)
            ),
            "features" => $result
        );
    }
}