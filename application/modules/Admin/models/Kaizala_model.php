<?php

class Kaizala_model extends CI_Model
{
    public $application_id;
    public $application_secret;
    public $refresh_token;
    public $access_token_url;
    public $group_id;

    public function __construct()
    {
        $this->application_id = "7930b52c-5c44-4f30-bf86-8eb59185a4b2";
        $this->application_secret = "6WPLN1IOCQ";
        $this->refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTQ3MTA5Njc2NzVcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNzkzMGI1MmMtNWM0NC00ZjMwLWJmODYtOGViNTkxODVhNGIyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcImRhdGFcIjpcIntcXFwiQXBwTmFtZVxcXCI6XFxcImFsdmFyb0Nvbm5lY3RvclxcXCJ9XCJ9IiwidWlkIjoiTW9iaWxlQXBwc1NlcnZpY2U6ZDg2MzY5NzItMzJmNi00N2UxLTkxYjYtNTMzOThlOTQwM2Y2IiwidmVyIjoiMiIsIm5iZiI6MTU0OTk1Mzk1MiwiZXhwIjoxNTgxNDg5OTUyLCJpYXQiOjE1NDk5NTM5NTIsImlzcyI6InVybjptaWNyb3NvZnQ6d2luZG93cy1henVyZTp6dW1vIiwiYXVkIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8ifQ.sSDUZSVWlWEfrdUXObygwFE5J8gipBy4E9bGAWFGpBE";

        // $this->access_token_url = "https://kms.kaiza.la/v1/accessToken";
        //New Mawingu Customers group
        // $this->group_id = "5f35ad9e-8db4-4d2d-a1b4-4dbea41aec5b";

        // $this->application_id = "49d62d2e-346f-4126-a437-6a25f3593232";
        // $this->application_secret = "SLSR38IL0R";
        // $this->refresh_token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1cm46bWljcm9zb2Z0OmNyZWRlbnRpYWxzIjoie1wicGhvbmVOdW1iZXJcIjpcIisyNTY3ODk2MTM1NDdcIixcImNJZFwiOlwiXCIsXCJ0ZXN0U2VuZGVyXCI6XCJmYWxzZVwiLFwiYXBwTmFtZVwiOlwiY29tLm1pY3Jvc29mdC5tb2JpbGUua2FpemFsYWFwaVwiLFwiYXBwbGljYXRpb25JZFwiOlwiNDlkNjJkMmUtMzQ2Zi00MTI2LWE0MzctNmEyNWYzNTkzMjMyXCIsXCJwZXJtaXNzaW9uc1wiOlwiOC40XCIsXCJhcHBsaWNhdGlvblR5cGVcIjotMSxcInRva2VuVmFsaWRGcm9tXCI6MTU1MjY0MDg3MzY1OSxcImRhdGFcIjpcIntcXFwiR3JvdXBJZFxcXCI6XFxcIjgwMGFiZDNjLWQ1ZjEtNDk4My04YmQ2LTE3Y2UxYzRkMjJjMlxcXCIsXFxcIkFwcE5hbWVcXFwiOlxcXCJGVCBBbGxvY2F0aW9uXFxcIn1cIn0iLCJ1aWQiOiJNb2JpbGVBcHBzU2VydmljZTplYWZlZGFiNi1hZGNjLTQyYmEtOTlmZS0yZWVlNDBmOTFlYmUiLCJ2ZXIiOiIyIiwibmJmIjoxNTUyNjQwODczLCJleHAiOjE1ODQxNzY4NzMsImlhdCI6MTU1MjY0MDg3MywiaXNzIjoidXJuOm1pY3Jvc29mdDp3aW5kb3dzLWF6dXJlOnp1bW8iLCJhdWQiOiJ1cm46bWljcm9zb2Z0OndpbmRvd3MtYXp1cmU6enVtbyJ9.ifcYpBjh1FDuzpLpgCyBoCAW01_rbA8qsfSPyDRcbDg";

        $this->access_token_url = "https://kms.kaiza.la/v1/accessToken";
    }

    private function get_access_token()
    {
        // Performing the HTTP request
        $ch = curl_init($this->access_token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array(
                'applicationId: ' . $this->application_id,
                'applicationSecret: ' . $this->application_secret,
                'refreshToken: ' . $this->refresh_token,
                'Content-Type: application/json',
            )
        );
        $response_body = curl_exec($ch);
        curl_close($ch);

        $response_json = json_decode($response_body);
        return $response_json->accessToken;
    }

    public function fetch_groups()
    {
        $access_token = $this->get_access_token();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/groups?fetchAllGroups=true&showDetails=true",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // var_dump(json_decode($response));die();
            $result = json_decode($response);
            if (array_key_exists('groups', $result)) {
                $groups = $result->groups;
                return array(true, $groups);
            } else {
                return array(false, $result);
            }

        }
    }

    public function get_group_users($group_id, $control)
    {
        $curl = curl_init();

        $access_token = $this->get_access_token();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/groups/" . $group_id . "/" . $control,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return array('error' => $err);
        } else {
            $response_obj = json_decode($response);

            if ($control == 'members') {
                if (array_key_exists('members', $response_obj)) {
                    if (count($response_obj->members) > 0) {
                        return $response_obj->members;
                    } else {
                        return false;
                    }
                }

            } else if ($control == 'subscribers') {
                if (array_key_exists('subscribers', $response_obj)) {
                    if (count($response_obj->subscribers) > 0) {
                        return $response_obj->subscribers;
                    } else {
                        return false;
                    }
                }

            }

        }
    }

    public function create_event_webhook($group_unique_id)
    {
        $send_data = array(
            "objectId" => $group_unique_id,
            "objectType" => "Group",
            "eventTypes" => array(
                "ActionCreated",
                "ActionResponse",
                "SurveyCreated",
                "JobCreated",
                "SurveyResponse",
                "JobResponse",
                "Announcement",
                "MemberAdded",
                "MemberRemoved",
            ),
            // "callBackUrl" => "https://mkopa-dev.azurewebsites.net/actions/get-actions",
            "callBackUrl" => "https://webhook.site/d4d037f4-275d-45fd-8a23-b905d83e82c3",
            "callBackToken" => "tokenToBeVerifiedByCallback",
            "callBackContext" => "https://mkopa-dev.azurewebsites.net/actions/get-action-cards",
        );

        $curl = curl_init();

        $access_token = $this->get_access_token();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/webhook",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($send_data),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $error = "cURL Error #:" . $err;
            return array(false, $error);
        } else {
            $obj = json_decode($response);
            if (array_key_exists('webhookId', $obj)) {
                $webhook_id = $obj->webhookId;
                return array(true, $webhook_id);
            }
            return array(false, $obj);
        }
    }

    public function delete_event_webhook($group_unique_id)
    {
        $curl = curl_init();

        $access_token = $this->get_access_token();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/webhook/" . $group_unique_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $error = "cURL Error #:" . $err;
            return array(false, $error);
        } else {
            $obj = json_decode($response);
            if (array_key_exists('message', $obj)) {
                return array(
                    false,
                    $obj,
                );
            } else {
                return array(
                    true,
                    $obj,
                );
            }
        }
    }

    public function all_webhooks($group_id)
    {
        $curl = curl_init();

        $access_token = $this->get_access_token();

        // return array('access' => $access_token);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://kms.kaiza.la/v1/webhook?objectId=" . $group_id . "&objectType=Group",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "accessToken: " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return array(
                false,
                "cURL Error #:" . $err,
            );
        } else {
            $obj = json_decode($response);

            return array(
                true,
                $obj,
            );
        }
    }
}
