<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class Finder
{
    /** @var Person[] */
    private $allPersons;

    public function __construct(array $allPersons)
    {
        $this->allPersons = $allPersons;
    }

    public function find(int $finderCriteria): PersonsPair
    {
        /** @var PersonsPair[] $allPersonsPairs */
        $allPersonsPairs = [];

        $numberOfPersons = count($this->allPersons);

        for ($i = 0; $i < $numberOfPersons; $i++) {
            for ($j = $i + 1; $j < $numberOfPersons; $j++) {

                if ($this->allPersons[$i]->birthDate()
                    < $this->allPersons[$j]->birthDate()
                ) {
                    $personsPair = new PersonsPair(
                        $this->allPersons[$i], $this->allPersons[$j]
                    );
                } else {
                    $personsPair = new PersonsPair(
                        $this->allPersons[$j], $this->allPersons[$i]
                    );
                }

                $allPersonsPairs[] = $personsPair;
            }
        }

        $thereAreNoPersonsPairs = count($allPersonsPairs) < 1;
        if ($thereAreNoPersonsPairs) {
            throw new NotEnoughPersonsException();
        }

        $personsPairMatchingCriteria = $allPersonsPairs[0];

        foreach ($allPersonsPairs as $personsPair) {
            switch ($finderCriteria) {
                case FinderCriteria::CLOSEST_BIRTHDAYS:
                    if ($personsPair->birthDaysDistanceInSeconds()
                        < $personsPairMatchingCriteria->birthDaysDistanceInSeconds(
                        )
                    ) {
                        $personsPairMatchingCriteria = $personsPair;
                    }
                    break;

                case FinderCriteria::FURTHEST_BIRTHDAYS:
                    if ($personsPair->birthDaysDistanceInSeconds()
                        > $personsPairMatchingCriteria->birthDaysDistanceInSeconds(
                        )
                    ) {
                        $personsPairMatchingCriteria = $personsPair;
                    }
                    break;
            }
        }

        return $personsPairMatchingCriteria;
    }
}
