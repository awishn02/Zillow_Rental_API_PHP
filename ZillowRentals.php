<?php

/*
 * @author Aaron Wishnick
 * PHP Class to interact with Zillow Rental API
 */

function curl($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

class Zillow_Rental_API {
  private $api_key;

  public function __construct($api_key = NULL){
    $this->api_key = $api_key;
  }

  /*
   * @param array $params
   *              - allowed values in $params are ad_id
   * @return json array
   */

  public function GetAds($params = NULL){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . "/ads.json";
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["ads"];
  }

  /*
   * @param array $params
   *              - required values in $params are ad_id and action
   *              - action can be either posted or deleted
   */

  public function UpdateAd($params){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    if(!isset($params['action'])){
      throw new Exception('Action parameter is required');
    }
    if(!isset($params['ad_id'])){
      throw new Exception('Ad id parameter is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/ads.update.json?' . http_build_query($params);
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
  }

  /*
   * @param array $params
   *              - allowed values in $params are limit, page, rentjuice_id, has_active_units, query
   * @return json array
   */

  public function GetBuildings($params = NULL){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/buildings.json';
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]); 
    }
    return $result["buildings"];
  }

  /*
   * @param none
   * @return json array
   */

  public function GetFeatures(){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/features.json';
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["features"];
  }

  /*
   * @param array $params
   *              - allowed values are limit, page, rentjuice_id, has_active_units, query
   * @return json array
   */

  public function GetLandlords($params = NULL){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/landlords.json';
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["landlords"]; 
  }

  /*
   * @param array $params
   *              - allowed values are limit, page, rentjuice_id, active,
   *                                   status, name, query, email, phone,
   *                                   agent, min_date_added,
   *                                   max_date_added, updated_since,
   *                                   min_rent, max_rent, neighborhoods,
   *                                   order_by, sort_direction
   * @return json array
   */

  public function GetLeads($params = NULL){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/leads.json';
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["leads"];
  }

  /*
   * @param array $params
   *              - required values are rentjuice_id or name or email
   *              - allowed values are phone, agent, source, neighborhoods,
   *                                   min_rent, max_rent, min_beds,
   *                                   max_beds, move_in_date, email_opt_in,
   *                                   notes, test, listing_id
   * @return none
   */

  public function AddLead($params = NULL){
    $found = false;
    if(isset($params["rentjuice_id"])){
      $found = true;
    }else if(isset($params["name"])){
      $found = true;
    }else if(isset($params["email"])){
      $found = true;
    }
    if(!$found){
      throw new Exception('Rentjuice_id, name, or email must be provided.');
    }
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/leads.add.json';
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
  }

  /*
   * @param array $params
   *              - allowed values are limit, page, rentjuice_id, context, listing_type,
   *                                   address, agent, min_rent, max_rent, fee,
   *                                   tenant_fee, min_beds, max_beds, min_baths,
   *                                   max_baths, neighborhoods, city, zip, features,
   *                                   terms, pets, featured, has_photos, include_mls,
   *                                   include_inactive, shared, mls_number,
   *                                   min_date_available, max_date_available,
   *                                   date_available, updated_since, custom_field,
   *                                   radius, longitude, latitude, bound1latlng,
   *                                   bound2latlng, order_by, order_direction, 
   *                                   received_description, open_house_date
   * @return json array
   */

  public function GetListings($params = NULL){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/listings.json';
    if($params != NULL){
      $url = $url . "?" . http_build_query($params);
    }
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["listings"];
  }

  /*
   * @param none
   * @return json array
   */

  public function GetListingCustomFields(){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/listings.custom_fields.json';
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["fields"];
  }

  /*
   * @param none
   * @return json array
   */

  public function GetNeighborhoods(){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/neighborhoods.json';
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["neighborhoods"];
  }

  /*
   * @param none
   * @return json array
   */

  public function GetProfile(){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/profile.json';
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["profile"];
  }

  /*
   * @param none
   * @return json array
   */

  public function GetTerms(){
    if(empty($this->api_key)){
      throw new Exception('API Key is required');
    }
    $url = "http://api.rentalapp.zillow.com/" . $this->api_key . '/terms.json';
    $result = curl($url);
    $result = json_decode($result,true);
    if($result["status"] == "error"){
      throw new Exception("Error Code " . $result["code"] . ": " . $result["message"]);
    }
    return $result["terms"];
  }
}
?>
