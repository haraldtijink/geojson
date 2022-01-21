<?php

namespace GeoJson\Geometry;

use GeoJson\BoundingBox;
use GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;

/**
 * MultiPoint geometry object.
 *
 * Coordinates consist of an array of positions.
 *
 * @see http://www.geojson.org/geojson-spec.html#multipoint
 * @since 1.0
 */
class MultiPoint extends Geometry
{
    protected string $type = 'MultiPoint';

    /**
     * @param array<Point|array<float|int>> $positions
     * @param CoordinateReferenceSystem|BoundingBox $args
     */
    public function __construct(array $positions, ... $args)
    {
        $this->coordinates = array_map(
            function($point) {
                if ( ! $point instanceof Point) {
                    $point = new Point($point);
                }

                return $point->getCoordinates();
            },
            $positions
        );

        $this->setOptionalConstructorArgs($args);
    }
}
