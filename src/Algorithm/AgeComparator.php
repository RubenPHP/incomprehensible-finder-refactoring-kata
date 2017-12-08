<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKata\Algorithm;

final class AgeComparator
{

	/** @var Person */
	private $person1;
	/** @var Person */
	private $person2;

    /** @var Person */
    public $oldestPerson;

    /** @var Person */
    public $youngestPerson;

    /** @var int */
    public $ageDifference;

	public function comparePersons(Person $person1, Person $person2)
	{
		$this->person1 = $person1;
		$this->person2 = $person2;

		$this->setPersonAges();
		$this->setAgeDifference();
	}

	private function setPersonAges()
    {
        $this->oldestPerson   = $this->person1->birthDate < $this->person2->birthDate ? $this->person1 : $this->person2;
        $this->youngestPerson = $this->person1->birthDate > $this->person2->birthDate ? $this->person1 : $this->person2;
    }

	private function setAgeDifference()
	{
		$this->ageDifference = $this->youngestPerson->birthDate->getTimestamp() - $this->oldestPerson->birthDate->getTimestamp();
	}
}
