<?php

namespace App\Model;

use App\Container\Container;

class Security extends AbtractModel
{
    private \PDOStatement $_statementRegister;
    private \PDOStatement $_statementReadSession;
    private \PDOStatement $_statementReadUser;
    private \PDOStatement $_statementReadUserFromEmail;
    private \PDOStatement $_statementCreateSession;
    private \PDOStatement $_statementDeleteSession;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->_statementRegister = $this->db->prepare(
            'INSERT INTO user VALUES(
                DEFAULT,
                :firstname,
                :lastname,
                :email,
                :password
            )'
        );

        $this->_statementReadSession = $this->db->prepare(
            'SELECT * FROM session WHERE id =:id'
        );
        $this->_statementReadUser = $this->db->prepare(
            'SELECT * FROM user WHERE id= :id'
        );
        $this->_statementReadUserFromEmail = $this->db->prepare(
            'SELECT * FROM user WHERE email= :email'
        );
        $this->_statementCreateSession = $this->db->prepare(
            'INSERT INTO session VALUES (
                :sessionid,
                :userid
            )'
        );
        $this->_statementDeleteSession = $this->db->prepare(
            'DELETE FROM session WHERE id = :id'
        );
    }
    public function login(string $userId): void
    {
        $sessionId = bin2hex(random_bytes(32));
        $this->_statementCreateSession->bindValue(":userid", $userId);
        $this->_statementCreateSession->bindValue(":sessionid", $sessionId);
        $this->_statementCreateSession->execute();
        $signature = hash_hmac('sha256', $sessionId, 'cinq petis chats');
        setcookie(
            'session',
            $sessionId,
            time() + 60 * 60 * 24 * 14,
            '',
            '',
            false,
            true
        );
        setcookie(
            'signature',
            $signature,
            time() + 60 * 60 * 24 * 14,
            '',
            '',
            false,
            true
        );
        return;
    }
    public function register(array $user): void
    {
        $hashedPassword = password_hash($user['password'], PASSWORD_ARGON2I);
        $this->_statementRegister->bindValue(":firstname", $user['firstname']);
        $this->_statementRegister->bindValue(":lastname", $user['lastname']);
        $this->_statementRegister->bindValue(":email", $user['email']);
        $this->_statementRegister->bindValue(":password", $hashedPassword);
        $this->_statementRegister->execute();
    }

    public function isLoggeding(): array | false
    {
        //global $pdo;
        $sessionId = $_COOKIE['session'] ?? '';
        $signature =  $_COOKIE['signature'] ?? '';

        if ($sessionId && $signature) {
            $hash = hash_hmac('sha256', $sessionId, 'cinq petis chats');
            if (hash_equals($hash, $signature)) {
                $this->_statementReadSession->bindValue(':id', $sessionId);
                $this->_statementReadSession->execute();
                $session = $this->_statementReadSession->fetch();
                if ($session) {
                    $this->_statementReadUser->bindValue(':id', $session['userid']);
                    $this->_statementReadUser->execute();
                    $user =  $this->_statementReadUser->fetch();
                }
            }
        }
        return $user ?? false;
    }

    public function logout(string $sessionId): void
    {
        $this->_statementDeleteSession->bindValue(':id', $sessionId);
        $this->_statementDeleteSession->execute();
        setcookie('session', '', time() - 1);
        setcookie('signature', '', time() - 1);
        return;
    }

    public function getUserFromEmail(string $email): array
    {
        $this->_statementReadUserFromEmail->bindValue(":email", $email);
        $this->_statementReadUserFromEmail->execute();
        $row = $this->_statementReadUserFromEmail->fetch();
        $resultat = is_array($row) ? $row : [];
        return $resultat;
    }
}
