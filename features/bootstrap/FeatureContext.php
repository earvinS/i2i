<?php

use Behat\Behat\Context\Context;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    protected $response;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }


    /**
     * @Given I am an unauthenticated user
     */
    public function iAmAnUnauthenticatedUser()
    {
        $httpClient = HttpClient::create();
        $this->response = $httpClient->request("GET", "http://localhost:8000/ads");

        if ($this->response->getStatusCode() != 200) {
            throw new Exception("Not able to access");
        }

        return true;    }

    /**
     * @When I request a list of ads from :arg1
     */
    public function iRequestAListOfAdsFrom($arg1)
    {
        $httpClient = HttpClient::create();
        $this->response = $httpClient->request("GET", $arg1);

        $responseCode = $this->response->getStatusCode();

        if ($responseCode != 200) {
            throw new Exception("Expected a 200, but received " . $responseCode);
        }

        return true;
    }

    /**
     * @Then The results should include an ad with title :arg1
     */
    public function theResultsShouldIncludeAnAdsWithId($arg1)
    {
        $ad = json_decode($this->response->getContent());

        foreach($ad as $ads) {
            print($ad);
            if ($ads->title == $arg1) {
                return true;
            }
        }

        throw new Exception('Expected to find ad with an ID of ' . $arg1 . ' , but didnt');
    }
}