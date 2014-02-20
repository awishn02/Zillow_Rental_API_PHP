Zillow Rental API
=================
This is a PHP Library for interacting with Zillow's rental API. All functions supported are:
* GetAds
* UpdateAd
* GetBuildings
* GetFeatures
* GetLandlords
* GetLeads
* AddLead
* GetListings
* GetListingCustomFields
* GetNeighborhoods
* GetProfile
* GetTerms

How to use this library
-----------------------
```
$zillow_rental_api = new Zillow_Rental_API('YOUR_API_KEY');

// Get all listings in South Boston
$params = array('neighborhoods' => 'South Boston', 'city' => 'Boston');
$zillow_rental_api->GetListings($params);
