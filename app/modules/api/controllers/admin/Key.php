<?php

defined('BASEPATH') OR exit('No direct script access allowed');

        // This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';
use chriskacerguis\RestServer\RestController;

/**
 * Keys Controller
 * This is a basic Key Management REST controller to make and delete keys
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Key extends RestController
{

    protected $methods = [
        'index_get' => ['level' => 1, 'limit' => 1000],
        'index_put' => ['level' => 1, 'limit' => 100],
        'index_delete' => ['level' => 10],
        'level_post' => ['level' => 10],
        'regenerate_post' => ['level' => 10],
    ];

    /**
     * Insert a key into the database
     *
     * @access public
     * @return void
     */
    public function index_put()
    {
        // Build a new key
        $key = $this->_generate_key();
        $user = $this->_generate_name($this->input->get('instance'));
        //TODO user instance

        // If no key level provided, provide a generic key
        $level = $this->put('level') ? $this->put('level') : 1;
        $ignore_limits = ctype_digit($this->put('ignore_limits')) ? (int)$this->put('ignore_limits') : 1;

        // Insert the new key
        if ($this->_insert_key($key, ['user_id'=>$user, 'level' => $level, 'ignore_limits' => $ignore_limits])) {
            $this->response([
                'status' => TRUE,
                'key' => $key,
                'Instance' => $this->input->request_headers()[$this->config->item('rest_instance_name')],
            ], RestController::HTTP_CREATED);         // CREATED (201) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not save the key'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    public function index_get()
    {
        // Build a new key
        $key = $this->_generate_key();
        $user = $this->_generate_name($this->input->get('instance'));

        // If no key level provided, provide a generic key
        $level = $this->put('level') ? $this->put('level') : 1;
        $ignore_limits = ctype_digit($this->put('ignore_limits')) ? (int)$this->put('ignore_limits') : 1;

        // Insert the new key
        if ($this->_insert_key($key, ['user_id'=>$user, 'level' => $level, 'ignore_limits' => $ignore_limits])) {
            $this->response([
                'status' => TRUE,
                'instance' => $user,
            'key' => $key
            ], RestController::HTTP_CREATED);         // CREATED (201) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not save the key'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Remove a key from the database to stop it working
     *
     * @access public
     * @return void
     */
    public function index_delete()
    {
        $key = $this->delete('key');

        // Does this key exist?
        if (!$this->_key_exists($key)) {
        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid API key'
            ], RestController::HTTP_BAD_REQUEST);         // BAD_REQUEST (400) being the HTTP response code
        }

        // Destroy it
        $this->_delete_key($key);

        // Respond that the key was destroyed
        $this->response([
            'status' => TRUE,
            'message' => 'API key was deleted'
        ], RestController::HTTP_NO_CONTENT);         // NO_CONTENT (204) being the HTTP response code
    }

    /**
     * Change the level
     *
     * @access public
     * @return void
     */
    public function level_post()
    {
        $key = $this->post('key');
        $new_level = $this->post('level');

        //TODO user instance

        // Does this key exist?
        if (!$this->_key_exists($key)) {
        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid API key'
            ], RestController::HTTP_BAD_REQUEST);         // BAD_REQUEST (400) being the HTTP response code
        }

        // Update the key level
        if ($this->_update_key($key, ['level' => $new_level])) {
            $this->response([
                'status' => TRUE,
                'message' => 'API key was updated'
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not update the key level'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Suspend a key
     *
     * @access public
     * @return void
     */
    public function suspend_post()
    {
        $key = $this->post('key');

        // Does this key exist?
        if (!$this->_key_exists($key)) {
        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid API key'
            ], RestController::HTTP_BAD_REQUEST);         // BAD_REQUEST (400) being the HTTP response code
        }

        // Update the key level
        if ($this->_update_key($key, ['level' => 0])) {
            $this->response([
                'status' => TRUE,
                'message' => 'Key was suspended'
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not suspend the user'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /**
     * Regenerate a key
     *
     * @access public
     * @return void
     */
    public function regenerate_post()
    {
        $old_key = $this->post('key');
        $key_details = $this->_get_key($old_key);

        // Does this key exist?
        if (!$key_details) {
        // It doesn't appear the key exists
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid API key'
            ], RestController::HTTP_BAD_REQUEST);         // BAD_REQUEST (400) being the HTTP response code
        }

        // Build a new key
        $new_key = $this->_generate_key();

        // Insert the new key
        if ($this->_insert_key($new_key, ['level' => $key_details->level, 'ignore_limits' => $key_details->ignore_limits])) {
        // Suspend old key
            $this->_update_key($old_key, ['level' => 0]);

            $this->response([
                'status' => TRUE,
                'key' => $new_key
            ], RestController::HTTP_CREATED);         // CREATED (201) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not save the key'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    /* Helper Methods */

    private function _generate_key()
    {
        do {
        // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

        // If an error occurred, then fall back to the previous method
            if ($salt === FALSE) {
                $salt = hash('sha256', time() . mt_rand());
            }

            $new_key = substr($salt, 0, config_item('rest_key_length'));
        } while ($this->_key_exists($new_key));

        return $new_key;
    }

    // TODO check and reformat
    private function _generate_name($instance)
    {
        $digits = 6;
        $length = 8;

        $instance = isset($instance) ? $instance : substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
        $rand_number = rand(pow(10, $digits-1), pow(10, $digits)-1);

        return $instance.$rand_number;
    }

    /* Private Data Methods */

    private function _get_key($key)
    {
        return $this->db
            ->where(config_item('rest_key_column'), $key)
            ->get(config_item('rest_keys_table'))
            ->row();
    }

    private function _key_exists($key)
    {
        return $this->db
                ->where(config_item('rest_key_column'), $key)
                ->count_all_results(config_item('rest_keys_table')) > 0;
    }

    private function _insert_key($key, $data)
    {
        $data[config_item('rest_key_column')] = $key;
        $data['date_created'] = date("Y-m-d H:i:s");

        return $this->db
            ->set($data)
            ->insert(config_item('rest_keys_table'));
    }

    private function _update_key($key, $data)
    {
        return $this->db
            ->where(config_item('rest_key_column'), $key)
            ->update(config_item('rest_keys_table'), $data);
    }

    private function _delete_key($key)
    {
        return $this->db
            ->where(config_item('rest_key_column'), $key)
            ->delete(config_item('rest_keys_table'));
    }

}