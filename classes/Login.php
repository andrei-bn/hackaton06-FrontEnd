<?php

class Login {
    public static function salvarSessaoLogin($result) {
        if (isset($result['token']) && isset($result['aluno'])) {
            $_SESSION['token'] = $result['token'];
            $_SESSION['user'] = $result['aluno'];
            $_SESSION['aluno'] = $result['aluno']; 
            return true;
        }
        return false;
    }
}
