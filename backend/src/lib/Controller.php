<?php
/*
    Author: Vincent Feistel
    Student No: 2256777
*/

/**
 * This is a base class that is mainly used as glue between
 * the database and the user of the API. It handles incoming requests
 * as well as responding to said requests
 */
class Controller {
    private $req_data = null;


    /**
     * Sets up HTTP response headers that will be there
     * for every response sent back by the API. This may be
     * modified to include any additional headers that are required
     */
    public function __construct() {
        header("Content-Type: application/json", true);
    }

    /**
     * Checks that the request method is int the list of allowed methods
     *
     * @param array<string> $methods The allowed request methods
     *
     * @throws Exception If the request type is not in the passed in methods, an exception with HTTP code 400 is thrown
     *
     */
    public function allowed_methods($methods) {
        header('Access-Control-Allow-Methods: ' . implode(', ',  $methods), true);
    
        $method = $_SERVER['REQUEST_METHOD'];
        if(in_array($method, $methods)) return; 

        throw new Exception("Invalid request method: $method", 400);
    }
    

    /**
     * Parses the body of the request as JSON data, returning the result
     *
     * @throws Exception If the JSON in the request body cannot be parsed, an exception with HTTP code 400 is thrown
     *
     * @return array Request JSON parsed as associative array
     */
    public function get_post_json() {
        if($this->req_data) return $this->req_data;

        $this->req_data = json_decode(file_get_contents("php://input"), true);
        if(!$this->req_data) throw new exception("Failed to parse json", 400);
        return $this->req_data;
    }
    
    /**
     * Enforces the usage of certain top-level JSON parameters
     *
     * @throws Exception If the body JSON does not contain the passed-in keys, an exception with HTTP code 400 is thrown
     */
    public function assert_params($required) {
        $params = array_keys($this->get_post_json());
        
        $missing = array_values(array_diff($required, $params));
        if(empty($missing)) return;
        
        throw new Exception("missing POST parameters: " . json_encode($missing), 400);
    }

    /**
     * Prepares and formats a JSON response given the error message
     *
     * @param string $msg The error message
     * @param int $code The HTTP response code to send (default: 501)
     *
     * @return string the JSON-encoded error response
     */
    public function error($msg, $code = 501) {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'timestamp' => time(),
            'data' => $msg
        ]);
    }

    /**
     * Prepares and formats a successful JSON response with
     * an HTTP response code of 200
     *
     * @param array $data The data to send with the response
     *
     * @return string the JSON-encoded response
     */
    public function success($data = []) {
        http_response_code(200);
        echo json_encode(array_merge([
            'status' => 'success',
            'timestamp' => time(),
            'data' => $data
        ]));
    }
}
?>
