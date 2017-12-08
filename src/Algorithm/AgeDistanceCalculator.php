<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class AgeDistanceCalculator
{
    /** @var Person[] */
    private $_personList;

    public function __construct(array $personList)
    {
        $this->_personList = $personList;
    }

    public function calculate(int $ageDistance): AgeComparator
    {
        /** @var AgeComparator[] $ageComparatorList */
        $ageComparatorList = [];

        for ($i = 0; $i < count($this->_personList); $i++) {
            for ($j = $i + 1; $j < count($this->_personList); $j++) {
                $ageComparator = new AgeComparator();
                $ageComparator->comparePersons( $this->_personList[ $i ],
                    $this->_personList[ $j ] );

                $ageComparatorList[] = $ageComparator;
            }
        }

        if (count($ageComparatorList) < 1) {
            return new AgeComparator();
        }

        $ageComparatorToReturn = $this->getComparatorByDistance( $ageDistance,
            $ageComparatorList );

        return $ageComparatorToReturn;
    }

    /**
     * @param int $ageDistance
     * @param $ageComparatorList
     *
     * @return mixed
     */
    public function getComparatorByDistance(
        int $ageDistance,
        $ageComparatorList
    ) {
        $ageComparatorToReturn = $ageComparatorList[0];

        foreach ( $ageComparatorList as $ageComparator ) {

            switch ( $ageDistance ) {
                case AgeDistance::CLOSEST:
                    if ( $ageComparator->ageDifference < $ageComparatorToReturn->ageDifference ) {
                        $ageComparatorToReturn = $ageComparator;
                    }
                    break;

                case AgeDistance::FURTHEST:
                    if ( $ageComparator->ageDifference > $ageComparatorToReturn->ageDifference ) {
                        $ageComparatorToReturn = $ageComparator;
                    }
                    break;
            }
        }

        return $ageComparatorToReturn;
    }
}
