<?php


namespace App\Tests\Controller;


use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseControllerTest extends WebTestCase
{
    use FixturesTrait;

    const BASE_HOST = "http://localhost";

    /**
     * @var array
     */
    protected $entities = [];

    /**
     * @var string[]
     */
    protected $fixturePath = [];

    protected function post(KernelBrowser $client, string $route, array $data, string $tokenId = "authenticate")
    {
        $data["_csrf_token"] = $client->getContainer()->get("security.csrf.token_manager")->getToken($tokenId);
        $client->request('POST', self::BASE_HOST . $client->getContainer()->get("router")->generate($route), $data);
    }

    protected function getFixtures(bool $files = true): void
    {
        // fixtures
        if ($files) {

            $this->entities = $this->loadFixtureFiles($this->fixturePath);
        } else {

            $this->entities = $this->loadFixtures($this->fixturePath);
        }
    }


    protected function url(KernelBrowser $client, string $route)
    {
        return self::BASE_HOST . $client->getContainer()->get("router")->generate($route);
    }
}