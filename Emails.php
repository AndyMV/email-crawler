<?php
/**
 * 
 * @Entity
 * @Table(name="emails")
 */
class Emails
{
    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id")
     
     */
    protected $id;
    /**
     * @Column(type="string", name="email")
     */
    protected $email;
    
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}