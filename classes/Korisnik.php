<?php
    class Korisnik {

        private $idKorisnik;
        private $ime;
        private $prezime;
        private $username;
        private $password;
        private $role;

        /**
         * @param $idKorisnik
         * @param $ime
         * @param $prezime
         * @param $username
         * @param $password
         * @param $role
         */
        public function __construct($ime, $prezime, $username, $password, $role, $idKorisnik = null)
        {
            if($idKorisnik !== null) {
                $this->idKorisnik = $idKorisnik;
            }
            $this->ime = $ime;
            $this->prezime = $prezime;
            $this->username = $username;
            $this->password = $password;
            $this->role = $role;
        }

        public function isProdavac()
        {
            return $this->role == 2;
        }

        /**
         * @return mixed
         */
        public function getIdKorisnik()
        {
            return $this->idKorisnik;
        }

        /**
         * @param mixed $idKorisnik
         */
        public function setIdKorisnik($idKorisnik)
        {
            $this->idKorisnik = $idKorisnik;
        }

        /**
         * @return mixed
         */
        public function getIme()
        {
            return $this->ime;
        }

        /**
         * @param mixed $ime
         */
        public function setIme($ime)
        {
            $this->ime = $ime;
        }

        /**
         * @return mixed
         */
        public function getPrezime()
        {
            return $this->prezime;
        }

        /**
         * @param mixed $prezime
         */
        public function setPrezime($prezime)
        {
            $this->prezime = $prezime;
        }

        /**
         * @return mixed
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @param mixed $username
         */
        public function setUsername($username)
        {
            $this->username = $username;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @return mixed
         */
        public function getRole()
        {
            return $this->role;
        }

        /**
         * @param mixed $role
         */
        public function setRole($role)
        {
            $this->role = $role;
        }


    }