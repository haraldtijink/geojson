<?php

namespace GeoJson\Feature;

use ArrayIterator;
use Countable;
use GeoJson\BoundingBox;
use GeoJson\CoordinateReferenceSystem\CoordinateReferenceSystem;
use GeoJson\GeoJson;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

/**
 * Collection of Feature objects.
 *
 * @see http://www.geojson.org/geojson-spec.html#feature-collection-objects
 * @since 1.0
 */
class FeatureCollection extends GeoJson implements Countable, IteratorAggregate
{
    protected string $type = 'FeatureCollection';

    /**
     * @var array<Feature>
     */
    protected array $features;

    /**
     * @param array<Feature> $features
     * @param CoordinateReferenceSystem|BoundingBox $args
     */
    public function __construct(array $features, ... $args)
    {
        foreach ($features as $feature) {
            if ( ! $feature instanceof Feature) {
                throw new InvalidArgumentException('FeatureCollection may only contain Feature objects');
            }
        }

        $this->features = array_values($features);

        $this->setOptionalConstructorArgs($args);
    }

    public function count(): int
    {
        return count($this->features);
    }

    /**
     * Return the Feature objects in this collection.
     *
     * @return array<Feature>
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->features);
    }

    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            array('features' => array_map(
                function(Feature $feature) { return $feature->jsonSerialize(); },
                $this->features
            ))
        );
    }
}
