<?php

class SpaghettiJsonConverter implements BaseConverter
{
    function getJsonData()
    {
        $result  = array();
        $point_query = <<<EOI
            select p.* from tsp_point p
            left join tsp_line_point lp on lp.idp = p.idp
            left join tsp_polygon_point pp on pp.idp = p.idp
            where lp.idp is null and pp.idp is null
EOI;
        $points = Connection::query($point_query);
        foreach ($points as $point) {
            $result[] = GraphicUtil::generate2DPoint($point);
        }
        $line_query = <<<EOI
        select lp.idl, l.name, l.description, p.idp, p.x, p.y, lp.seq 
        from tsp_line_point lp 
        left join tsp_line l on lp.idl = l.idl
        left join tsp_point p on lp.idp = p.idp
        order by l.idl, lp.seq
EOI;
        $lines = Connection::query($line_query);
        $current_line_id = null;
        $current_line = null;
        foreach ($lines as $line) {
            if ($current_line_id != $line['idl']){
                if($current_line != null) {
                    $result[] = $current_line;
                }
                $current_line = GraphicUtil::generate2DLine($line);
                $current_line_id = $line['idl'];
            } else {
                $current_line = GraphicUtil::generate2DLine($line, $current_line);;
            }
        }
        if($current_line != null) {
            $result[] = $current_line;
        }

//         $polygon_query = <<<EOI
//         select pp.idpo, po.name, po.description, p.idp, p.x, p.y, pp.seq 
//         from tsp_polygon_point pp
//         left join tsp_polygon po on pp.idpo = po.idpo
//         left join tsp_point p on pp.idp = p.idp
//         order by po.idpo, pp.seq
// EOI;
//         $polygons = Connection::query($polygon_query);
//         $current_polygon_id = null;
//         $current_polygon = null;
//         foreach ($polygons as $polygon) {
//             if ($current_polygon_id != $polygon['idpo']){
//                 if($current_polygon != null) {
//                     $result[] = $current_polygon;
//                 }
//                 $current_polygon = GraphicUtil::generate2DPolygon($polygon);
//                 $current_polygon_id = $polygon['idpo'];
//             } else {
//                 $current_polygon = GraphicUtil::generate2DPolygon($polygon, $current_polygon);;
//             }
//         }
//         if($current_polygon != null) {
//             $result[] = $current_polygon;
//         }

        return $result;
    }
}