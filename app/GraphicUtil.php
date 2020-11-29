<?php

class GraphicUtil
{
    public static function generate2DPoint($attribute)
    {
        return array(
            "geometry" => array(
                "type" => "point",
                "longitude" => $attribute['x'],
                "latitude" => $attribute['y']
            ),
            "symbol" => array(
                "type" => "simple-marker",
                "color" => [0, 255, 0],
                "outline" => array(
                    "color" => array(255, 255, 255),
                    "width" => 1
                )
            ),
            "attributes" => array(
                "name" => $attribute['name'],
                "location" => $attribute['location']
            ),
            "popupTemplate" => array(
                "title" => "{name}",
                "content" => "<table class='esri-widget__table'><tr><th>Name</th><th>Location</th></tr><tr><td>{name}</td><td>{location}</td></tr></table>"
            )
        );
    }

    public static function generate2DLine($attribute, $exitedLine = null)
    {
        if (!empty($exitedLine)) {
            $exitedLine['geometry']['paths'][] = array($attribute['x'], $attribute['y']);
            return $exitedLine;
        }
        return array (
            "geometry" => array (
                "type"=>"polyline",
                "paths"=> array (
                    array($attribute['x'], $attribute['y'])
                )
            ),
            "symbol" => array(
                "type" => "simple-line",
                "color" => [226, 119, 40],
                "width" => 1
            ),
            "attributes" => array(
                "name" => $attribute['name'],
                "description" => $attribute['description']
            ),
            "popupTemplate" => array(
                "title" => "Line {name}",
                "content" => "<table class='esri-widget__table'><tr><th>Name</th><th>Description</th></tr><tr><td>{name}</td><td>{description}</td></tr></table>"
            )
        );
    }

    public static function generate2DPolygon($attribute, $exitedPolygon = null)
    {
        if (!empty($exitedPolygon)) {
            $exitedPolygon['geometry']['rings'][] = array($attribute['x'], $attribute['y']);
            return $exitedPolygon;
        }
        return array (
            "geometry" => array (
                "type"=>"polygon",
                "rings"=> array (
                    array($attribute['x'], $attribute['y'])
                )
            ),
            "symbol" => array(
                "type" => "simple-fill",
                "color" => [226, 119, 40, 0.5],
                "width" => 1
            ),
            "attributes" => array(
                "name" => $attribute['name'],
                "description" => $attribute['description']
            ),
            "popupTemplate" => array(
                "title" => "Polygon {name}",
                "content" => "<table class='esri-widget__table'><tr><th>Name</th><th>Description</th></tr><tr><td>{name}</td><td>{description}</td></tr></table>"
            )
        );
    }
}