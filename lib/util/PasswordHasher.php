<?php

class PasswordHasher {

    function salt() {
        mt_srand(microtime(true) * 100000 + memory_get_usage(true));
        return '' . md5(uniqid(mt_rand(), true));
    }

    function create($password) {
        // Create a 256 bit (64 characters) long random salt and the 
        // username to the salt as well for added security
        $salt = hash('sha256', $this->salt());

        // Prefix the password with the salt
        $hash = $salt . $password;

        // Hash the salted password a bunch of times
        for ($i = 0; $i < 1000; $i++) {
            $hash = hash('sha256', $hash);
        }

        // Prefix the hash with the salt so we can find it back later
        $hash = $salt . $hash;

        return $hash;
    }

    function check($password, $hash) {
        // The first 64 characters of the hash is the salt
        $salt = substr($hash, 0, 64);
        $hash_check = $salt . $password;

        // Hash the password as we did before
        for ($i = 0; $i < 1000; $i++) {
            $hash_check = hash('sha256', $hash_check);
        }
        
        $hash_check = $salt . $hash_check;

        if ($hash_check == $hash) {
            return true;
        }
        else {
            return false;
        }
    }

}
