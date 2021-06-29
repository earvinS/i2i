Feature: List of Ads
  In order to retrieve the list of Ads
  As an ad
  I must visit the ads page

  Scenario: I want a list of ads
    Given I am an unauthenticated user
    When I request a list of ads from "http://localhost:8000/ads"
    Then The results should include an ad with title "Tempore ut totam deserunt dicta inventore."