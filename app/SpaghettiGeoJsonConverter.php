<?php

class SpaghettiGeoJsonConverter implements BaseConverter
{

    function getJsonData($type = null)
    {
        $result = null;
        switch (strtolower($type)) {
            case "line":
                $result = $this->getJsonDataLines();
                break;
            case "polygon":
                $result = $this->getJsonDataPolygons();
                break;
            default:
        }
        return $result;
    }

    function getJsonDataPolygons()
    {   
        $param = array();
        $criteria = DatabaseUtil::build_filters($param);
        $polygon_query = <<<EOI
                select pp.idpo, po.name, po.description, p.idp, p.x, p.y, pp.seq 
                from tsp_polygon_point pp
                left join tsp_polygon po on pp.idpo = po.idpo
                left join tsp_point p on pp.idp = p.idp
                $criteria
                order by po.idpo, pp.seq
EOI;
        $polygons = Connection::query($polygon_query, $param);
//         echo json_encode($polygons);
//         exit();
        $current_polygon_id = null;
        $current_polygon = null;
        foreach ($polygons as $polygon) {
            if ($current_polygon_id != $polygon['idpo']) {
                if ($current_polygon != null) {
                    $result[] = $current_polygon;
                }
                $current_polygon = GeoJsonUtil::generate2DPolygon($polygon);
                $current_polygon_id = $polygon['idpo'];
            } else {
                $current_polygon = GeoJsonUtil::generate2DPolygon($polygon, $current_polygon);
            }
        }
        if ($current_polygon != null) {
            $result[] = $current_polygon;
        }

        return array(
            "type" => "FeatureCollection",
            "metadata" => array(
                "count" => sizeof($result)
            ),
            "features" => $result
        );
    }

    function getJsonDataLines()
    {
        $param = array();
        $criteria = DatabaseUtil::build_filters($param);
        $line_query = <<<EOI
        select lp.idl, l.name, l.description, p.idp, p.x, p.y, lp.seq 
        from tsp_line_point lp 
        left join tsp_line l on lp.idl = l.idl
        left join tsp_point p on lp.idp = p.idp
        $criteria
        order by l.idl, lp.seq
EOI;
        $lines = Connection::query($line_query, $param);
        $current_line_id = null;
        $current_line = null;
        foreach ($lines as $line) {
            if ($current_line_id != $line['idl']) {
                if ($current_line != null) {
                    $result[] = $current_line;
                }
                $current_line = GeoJsonUtil::generate2DLine($line);
                $current_line_id = $line['idl'];
            } else {
                $current_line = GeoJsonUtil::generate2DLine($line, $current_line);
            }
        }
        if ($current_line != null) {
            $result[] = $current_line;
        }
        
        return array(
            "type" => "FeatureCollection",
            "metadata" => array(
                "count" => sizeof($result)
            ),
            "features" => $result
        );
    }
}