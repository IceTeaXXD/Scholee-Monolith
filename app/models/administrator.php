<?php
class Administrator extends User{
    private string $organization;
    public function __construct(int $userID, string $name, string $email, string $role, string $organization, string $password){
        $this->userID = $userID;
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->password = $password;
        $this->organization = $organization;
    }
}
?>