<?php

/**
 * Helper class for Qualtrics API Call.
 */
class Qualtricsxm {

  private $apiBaseUrl;
  private $apiToken;

  /**
   * Qualtricsxm constructor.
   */
  public function __construct($apiBaseUrl, $apiToken) {
    $this->api_base_url = $apiBaseUrl;
    $this->api_token = $apiToken;
  }

  /**
   * API call.
   *
   * @param array $url_params
   *   API URL params.
   *
   * @return object
   *   Requested data.
   */
  public function httpRequest(array $url_params) {
    $options = array(
      'method' => 'GET',
      'timeout' => 15,
      'headers' => array('X-API-TOKEN' => $this->api_token),
    );

    $api_req = "/";
    foreach ($url_params as $url => $val) {
      $api_req .= urlencode($url) . "/" . urlencode($val);
    }

    $url = $this->api_base_url . $api_req;

    $request = drupal_http_request($url, $options);
    return $request;
  }

  /**
   * Get survey by surveyID.
   *
   * @param string $survey_id
   *   Survey ID.
   *
   * @return bool|string
   *   FALSE or json data.
   */
  public function getSurvey($survey_id) {
    $survey = $this->httpRequest(array("surveys" => $survey_id));

    if ($survey->code != 200) {
      return FALSE;
    }

    $survey_data = json_decode($survey->data);
    return $survey_data;
  }

  /**
   * Get survey list.
   *
   * @return bool|array
   *   TODO merge into getSurve.
   */
  public function getSurveyList() {
    $survey = $this->httpRequest(array('surveys' => ''));

    if ($survey->code != 200) {
      return FALSE;
    }

    $survey_data = json_decode($survey->data);

    // Make sure the legacy function working, and renderable by theme_table.
    foreach ($survey_data->result->elements as $element) {
      $surveys_array[$element->id]['surveyname'] = $element->name;
      $surveys_array[$element->id]['id'] = $element->id;
      $surveys_array[$element->id]['ownerId'] = $element->ownerId;
      $surveys_array[$element->id]['lastModified'] = $element->lastModified;
      $surveys_array[$element->id]['isActive'] = $element->isActive;
    }
    return $surveys_array;
  }

  /**
   * Get extra submission meta data from API call.
   *
   * @param string $survey_id
   *   Survey ID.
   *
   * @return bool|string
   *   FALSE or json data.
   */
  public function getSubmissions($survey_id) {
    $request_data = $this->getSurvey($survey_id);

    if (!$request_data) {
      return FALSE;
    }
    $response_counts = empty($request_data->result->responseCounts) ? NULL : $request_data->result->responseCounts;
    return $response_counts;
  }

}
