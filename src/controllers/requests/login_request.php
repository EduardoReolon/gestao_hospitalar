<?php
require_once __DIR__ . '/../config/base_request.php';

class Login_request extends Base_request {
    /**
     * pattern email
     */
    public string $username;
    public string $password;
}