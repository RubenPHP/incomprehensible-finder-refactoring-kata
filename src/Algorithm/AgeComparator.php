<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class AgeComparator
{
    /** @var Person[] */
    private $_personList;

    public function __construct(array $personList)
    {
        $this->_personList = $personList;
    }

    public function compare(int $ageDistance): AgeDifferenceBetweenTwoPerson
    {
        /** @var AgeDifferenceBetweenTwoPerson[] $ageDifferenceBetweenTwoPersonList */
        $ageDifferenceBetweenTwoPersonList = [];

        for ($i = 0; $i < count($this->_personList); $i++) {
            for ($j = $i + 1; $j < count($this->_personList); $j++) {
                $ageDifferenceBetweenTwoPerson = new AgeDifferenceBetweenTwoPerson();

                if ( $this->_personList[$i]->birthDate < $this->_personList[$j]->birthDate) {
                    $ageDifferenceBetweenTwoPerson->oldestPerson   = $this->_personList[$i];
                    $ageDifferenceBetweenTwoPerson->youngestPerson = $this->_personList[$j];
                } else {
                    $ageDifferenceBetweenTwoPerson->oldestPerson   = $this->_personList[$j];
                    $ageDifferenceBetweenTwoPerson->youngestPerson = $this->_personList[$i];
                }

                $ageDifferenceBetweenTwoPerson->ageDifference = $ageDifferenceBetweenTwoPerson->youngestPerson->birthDate->getTimestamp()
                                    - $ageDifferenceBetweenTwoPerson->oldestPerson->birthDate->getTimestamp();

                $ageDifferenceBetweenTwoPersonList[] = $ageDifferenceBetweenTwoPerson;
            }
        }

        if (count($ageDifferenceBetweenTwoPersonList) < 1) {
            return new AgeDifferenceBetweenTwoPerson();
        }

        $finalAgeDiffereneBetweenTwoPerson = $ageDifferenceBetweenTwoPersonList[0];

        foreach ($ageDifferenceBetweenTwoPersonList as $ageDifferenceBetweenTwoPerson) {
            switch ($ageDistance) {
                case AgeDistance::CLOSEST:
                    if ( $ageDifferenceBetweenTwoPerson->ageDifference < $finalAgeDiffereneBetweenTwoPerson->ageDifference) {
                        $finalAgeDiffereneBetweenTwoPerson = $ageDifferenceBetweenTwoPerson;
                    }
                    break;

                case AgeDistance::FURTHEST:
                    if ( $ageDifferenceBetweenTwoPerson->ageDifference > $finalAgeDiffereneBetweenTwoPerson->ageDifference) {
                        $finalAgeDiffereneBetweenTwoPerson = $ageDifferenceBetweenTwoPerson;
                    }
                    break;
            }
        }

        return $finalAgeDiffereneBetweenTwoPerson;
    }
}
