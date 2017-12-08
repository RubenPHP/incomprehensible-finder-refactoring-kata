<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKataTest\Algorithm;

use CodelyTV\FinderKata\Algorithm\AgeDistanceCalculator;
use CodelyTV\FinderKata\Algorithm\AgeDistance;
use CodelyTV\FinderKata\Algorithm\Person;
use PHPUnit\Framework\TestCase;

final class FinderTest extends TestCase
{
    /** @var Person */
    private $sue;

    /** @var Person */
    private $greg;

    /** @var Person */
    private $sarah;

    /** @var Person */
    private $mike;

    protected function setUp()
    {
        $this->sue            = new Person();
        $this->sue->name      = "Sue";
        $this->sue->birthDate = new \DateTime("1950-01-01");

        $this->greg            = new Person();
        $this->greg->name      = "Greg";
        $this->greg->birthDate = new \DateTime("1952-05-01");

        $this->mike            = new Person();
        $this->mike->name      = "Mike";
        $this->mike->birthDate = new \DateTime("1979-01-01");

        $this->sarah            = new Person();
        $this->sarah->name      = "Sarah";
        $this->sarah->birthDate = new \DateTime("1982-01-01");
    }

    /** @test */
    public function should_return_empty_when_given_empty_list()
    {
        $personList   = [];
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::CLOSEST);

        $this->assertEquals(null, $result->oldestPerson);
        $this->assertEquals(null, $result->youngestPerson);
    }

    /** @test */
    public function should_return_empty_when_given_one_person()
    {
        $personList   = [];
        $personList[] = $this->sue;
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::CLOSEST);

        $this->assertEquals(null, $result->oldestPerson);
        $this->assertEquals(null, $result->youngestPerson);
    }

    /** @test */
    public function should_return_closest_two_for_two_people()
    {
        $personList   = [];
        $personList[] = $this->sue;
        $personList[] = $this->greg;
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::CLOSEST);

        $this->assertEquals($this->sue, $result->oldestPerson);
        $this->assertEquals($this->greg, $result->youngestPerson);
    }

    /** @test */
    public function should_return_furthest_two_for_two_people()
    {
        $personList   = [];
        $personList[] = $this->mike;
        $personList[] = $this->greg;
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::FURTHEST);

        $this->assertEquals($this->greg, $result->oldestPerson);
        $this->assertEquals($this->mike, $result->youngestPerson);
    }

    /** @test */
    public function should_return_furthest_two_for_four_people()
    {
        $personList   = [];
        $personList[] = $this->sue;
        $personList[] = $this->sarah;
        $personList[] = $this->mike;
        $personList[] = $this->greg;
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::FURTHEST);

        $this->assertEquals($this->sue, $result->oldestPerson);
        $this->assertEquals($this->sarah, $result->youngestPerson);
    }

    /**
     * @test
     */
    public function should_return_closest_two_for_four_people()
    {
        $personList   = [];
        $personList[] = $this->sue;
        $personList[] = $this->sarah;
        $personList[] = $this->mike;
        $personList[] = $this->greg;
        $ageDistanceCalculator = new AgeDistanceCalculator($personList);

        $result = $ageDistanceCalculator->calculate(AgeDistance::CLOSEST);

        $this->assertEquals($this->sue, $result->oldestPerson);
        $this->assertEquals($this->greg, $result->youngestPerson);
    }
}
