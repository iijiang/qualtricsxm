<?php

  class qualtricsxm {

    private $api_base_url;
    private $api_token;

    public function __construct ($api_base_url, $api_token) {
      $this->api_base_url = $api_base_url;
      $this->api_token = $api_token;
    }

    /**
     * API call.
     *
     * @param array $url_params
     * @return object
     */
    public function httpRequest($url_params) {
     $options = array(
        'method' => 'GET',
        'timeout' => 15,
        'headers' => array('X-API-TOKEN' => $this->api_token),
      );

      $api_req = "/" ;
      foreach ($url_params as $url => $val) {
        $api_req .= urlencode($url) . "/" . urlencode($val);
      }

      $url = $this->api_base_url . $api_req;

      $request = drupal_http_request($url, $options);
      return $request;
    }


    /**
     * Get survey by surveyID
     * @param $survey_id
     * @return bool|mixed
     */
    public function getSurvey ($survey_id) {
      $survey =  $this->httpRequest(array("surveys" => $survey_id));

      if ($survey->code != 200) {
        return FALSE;
      }

      $survey_data = json_decode($survey->data);
      return $survey_data;
    }


    /**
     * Get survey list.
     * @return bool|array
     * TODO merge into getSurve.
     */
    public function getSurveyList() {
      $survey = $this->httpRequest(array('surveys' => ''));

      if ($survey->code != 200) {
        return FALSE;
      }

      $survey_data = json_decode($survey->data);

      //Make sure the legacy function working, and renderable by theme_table.
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
     * @param $survey_id
     * @return mixed
     */
    public function getSubmissions($survey_id) {
      $request_data = $this->getSurvey($survey_id);
      $response_counts =  $request_data->result->responseCounts;
      return $response_counts;
    }


  }