<?php

class UserDAO extends \struktal\ORM\GenericUserDAO {
    public function customRegister(string $username, string $password, string $email, int $permissionLevel, string $oneTimePassword): User {
        $user = new User();
        $user->generateApiKeyPair();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setEmailVerified(false);
        $user->setPermissionLevel($permissionLevel);
        $user->setOneTimePassword($oneTimePassword);
        $user->setOneTimePasswordExpiration(null);
        $this->save($user);

        return $user;
    }
}
