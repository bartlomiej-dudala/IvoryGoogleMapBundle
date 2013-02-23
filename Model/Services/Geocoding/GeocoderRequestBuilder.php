<?php

/*
 * This file is part of the Ivory Google Map bundle package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\GoogleMapBundle\Model\Services\Geocoding;

use Ivory\GoogleMapBundle\Model\Base\BoundBuilder,
    Ivory\GoogleMapBundle\Model\Base\CoordinateBuilder,
    Ivory\GoogleMapBundle\Model\AbstractBuilder;

/**
 * Geocoder request builder.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GeocoderRequestBuilder extends AbstractBuilder
{
    /** @var \Ivory\GoogleMapBundle\Model\Base\CoordinateBuilder */
    protected $coordinateBuilder;

    /** @var \Ivory\GoogleMapBundle\Model\Base\BoundBuilder */
    protected $boundBuilder;

    /** @var string */
    protected $address;

    /** @var array */
    protected $coordinate;

    /** @var array */
    protected $bound;

    /** @var string */
    protected $region;

    /** @var boolean */
    protected $sensor;

    /**
     * Creates a geocoder request builder.
     *
     * @param string                                              $class             The class to build.
     * @param \Ivory\GoogleMapBundle\Model\Base\CoordinateBuilder $coordinateBuilder The coordinate builder.
     * @param \Ivory\GoogleMapBundle\Model\Base\BoundBuilder      $boundBuilder      The bound builder.
     */
    public function __construct($class, CoordinateBuilder $coordinateBuilder, BoundBuilder $boundBuilder)
    {
        parent::__construct($class);

        $this->setCoordinateBuilder($coordinateBuilder);
        $this->setBoundBuilder($boundBuilder);
        $this->reset();
    }

    public function getCoordinateBuilder()
    {
        return $this->coordinateBuilder;
    }

    public function setCoordinateBuilder(CoordinateBuilder $coordinateBuilder)
    {
        $this->coordinateBuilder = $coordinateBuilder;

        return $this;
    }

    public function getBoundBuilder()
    {
        return $this->boundBuilder;
    }

    public function setBoundBuilder(BoundBuilder $boundBuilder)
    {
        $this->boundBuilder = $boundBuilder;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function setCoordinate($latitude, $longitude, $noWrap = true)
    {
        $this->coordinate = array($latitude, $longitude, $noWrap);

        return $this;
    }

    public function getBound()
    {
        return $this->bound;
    }

    public function setBound(
        $southWestLatitude,
        $southWestLongitude,
        $northEastLatitude,
        $northEastLongitude,
        $southWestNoWrap = true,
        $northEastNoWrap = true
    )
    {
        $this->bound = array(
            $southWestLatitude,
            $southWestLongitude,
            $southWestNoWrap,
            $northEastLatitude,
            $northEastLongitude,
            $northEastNoWrap,
        );

        return $this;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    public function getSensor()
    {
        return $this->sensor;
    }

    public function setSensor($sensor)
    {
        $this->sensor = $sensor;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->coordinateBuilder->reset();
        $this->boundBuilder->reset();

        $this->address = null;
        $this->coordinate = array();
        $this->bound = array();
        $this->region = null;
        $this->sensor = null;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Ivory\GoogleMap\Services\Geocoding\GeocoderRequest The geocoder request.
     */
    public function build()
    {
        $geocoderRequest = new $this->class();

        if ($this->address !== null) {
            $geocoderRequest->setAddress($this->address);
        }

        if (!empty($this->coordinate)) {
            $geocoderRequest->setCoordinate($this->coordinate[0], $this->coordinate[1], $this->coordinate[2]);
        }

        if (!empty($this->bound)) {
            $geocoderRequest->setBound(
                $this->bound[0],
                $this->bound[1],
                $this->bound[3],
                $this->bound[4],
                $this->bound[2],
                $this->bound[5]
            );
        }

        if ($this->region !== null) {
            $geocoderRequest->setRegion($this->region);
        }

        if ($this->sensor !== null) {
            $geocoderRequest->setSensor($this->sensor);
        }

        return $geocoderRequest;
    }
}
