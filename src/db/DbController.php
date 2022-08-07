<?php
declare(strict_types = 1);

namespace db;

use crypt\Hash;
require_once '..\crypt\Hash.php';

class DbController
{
    private string $FILENAME = 'db.json';

    private function getFileData(): object
    {
        if (file_exists($this->FILENAME)) {
            return json_decode(file_get_contents($this->FILENAME));
        }

        $dbTemplate = json_encode(array('db' => array()));
        file_put_contents($this->FILENAME, $dbTemplate);
        return json_decode(file_get_contents($this->FILENAME));
    }

    public function saveUser(string $userData): bool
    {
        $dbData = $this->getFileData();
        $userData = json_decode($userData);

        $userData->password = Hash::hashPassword($userData->password);

        $dbData->db[] = $userData;

        if(file_put_contents($this->FILENAME, json_encode($dbData))) {
            return true;
        }
        return false;
    }

    public function isInfoExists(string $fieldKey, string $userDataValue): bool
    {
        $dbData = $this->getFileData();
        switch ($fieldKey) {
            case 'login':
                foreach ($dbData->db as $user) {
                    if ($user->login === $userDataValue) {
                        return true;
                    }
                }
                break;

            case 'email':
                foreach ($dbData->db as $user) {
                    if ($user->email === $userDataValue) {
                        return true;
                    }
                }
                break;

            case 'password':
                foreach ($dbData->db as $user) {
                    if (Hash::comparePasswords($userDataValue, $user->password)) {
                        return true;
                    }
                }
                break;

            default: return false;
        }
        return false;
    }
}