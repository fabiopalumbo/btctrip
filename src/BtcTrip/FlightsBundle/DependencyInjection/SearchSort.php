<?php
namespace BtcTrip\FlightsBundle\DependencyInjection;

class SearchSort {
    private static $meta;

    static function sort(&$terms, $meta) {
        self::$meta = $meta;
        usort($terms, array("\BtcTrip\FlightsBundle\DependencyInjection\SearchSort", "cmp_method"));
    }

    static function cmp_method($a, $b) {
        $meta = self::$meta; //access meta data
        // do comparison here
        switch($meta['orderBy']) {
            case 'STOPSCOUNT':
                if(is_object($a)) {
                    $aVal = $a->itinerariesBox->outboundRoutes[0]->stopCount + $a->itinerariesBox->inboundRoutes[0]->stopCount;
                } else {
                    $aVal = $a['itinerariesBox']['outboundRoutes'][0]['stopCount'] + $a['itinerariesBox']['inboundRoutes'][0]['stopCount'];
                }
                $aVal = (int) $aVal;

                if(is_object($b)) {
                    $bVal = $b->itinerariesBox->outboundRoutes[0]->stopCount + $b->itinerariesBox->inboundRoutes[0]->stopCount;
                } else {
                    $bVal = $b['itinerariesBox']['outboundRoutes'][0]['stopCount'] + $b['itinerariesBox']['inboudnRoutes'][0]['stopCount'];
                }
                $bVal = (int) $bVal;
            break;
            default:
                if(is_object($a)) {
                    $aVal = $a->itinerariesBox->itinerariesBoxPriceInfoList[0]->total->fare->raw;
                } else {
                    $aVal = $a['itinerariesBox']['itinerariesBoxPriceInfoList'][0]['total']['fare']['raw'];
                }
                $aVal = (float) $aVal;

                if(is_object($b)) {
                    $bVal = $b->itinerariesBox->itinerariesBoxPriceInfoList[0]->total->fare->raw;
                } else {
                    $bVal = $b['itinerariesBox']['itinerariesBoxPriceInfoList'][0]['total']['fare']['raw'];
                }
                $bVal = (float) $bVal;
            break;
        }

        if($aVal == $bVal) {
            return 0;
        } else {
            if($meta['orderDir'] == 'asc') {
                return ($aVal > $bVal) ? 1 : -1;
            } else {
                return ($aVal > $bVal) ? -1 : 1;
            }
        }
    }
}

