<?php

/**
 * Secure gear
 * 
 * Helps to keep things secure.
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		Secure
 * @subpackage          
 * @version		$Id$
 */
class Secure_Gear extends Gear {

    protected $name = 'Secure';
    protected $description = 'Helps to keep things secure.';
    protected $order = 0;
    protected $hooks = array(
        'gear.request' => 'checkRequest',
    );
    protected $key;
    protected $salt;

    /**
     * Constructor
     */
    public function __contsruct() {
        parent::__construct();
    }

    /**
     * Encrypt data
     * 
     * @param mixed $data 
     */
    public function encrypt($data) {
        return base64_encode(serialize($data));
    }

    /**
     * Decrypt data
     * 
     * @param string $data 
     */
    public function decrypt($data) {
        return unserialize(base64_decode($data));
    }

    /**
     * Gen or check secure key
     * 
     * @param   string  $key
     */
    public function key($key = NULL) {
        if ($key) {
            return $key == $this->key();
        } else {
            if (!$this->key) {
                // Get the key
                $this->key = config('key');
            }
            return $this->key;
        }
    }

    /**
     * Gen or check secure key
     * 
     * @param   string  $key
     */
    public function salt($salt = NULL) {
        if ($salt) {
            return $salt == $this->salt();
        } else {
            if (!$this->salt) {
                // Get the salt
                $salt = config('key', md5(date('H d.m.Y')));
                // Glue salt with current ip
                $salt = md5($salt . $this->request->get('ip'));
                $this->salt = substr($salt, 0, 5);
            }
            return $this->salt;
        }
    }

    /**
     * Generate hash for user
     *
     * @param string $salt
     */
    public function genHash($salt = NULL) {
        $salt OR $salt = $this->session->get('ip');
        return md5($salt . $this->key());
    }

    /**
     * Check request for security hash
     */
    public function checkRequest() {
        if ($s = $this->input->get(Url::SECURE)) {
            if ($s === $this->salt()) {
                return TRUE;
            }
            flash_warning(t('You secret key doesn\'t match the original. Please, try once again.'), t('Warning'));
            back();
        }
    }

}

/**
 * Encrypt data
 * 
 * @param mixed $data
 * @return string 
 */
function encrypt($data) {
    return cogear()->secure->encrypt($data);
}

/**
 * Decrypt data
 * 
 * @param mixed $data
 * @return string 
 */
function decrypt($data) {
    return cogear()->secure->decrypt($data);
}
