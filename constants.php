<?php
    //tabela album
    define('TBL_ALBUM', 'album');
    define('COL_ID_ALBUM', 'idAlbum');
    define('COL_NAZIV_ALBUM', 'naziv');
    define('COL_IZVODJAC_ALBUM', 'izvodjac');
    define('COL_GODINA_ALBUM', 'godIzdanja');
    define('COL_ZANR_ALBUM', 'zanr');
    define('COL_CENA_ALBUM', 'cena');
    define('COL_NA_STANJU_ALBUM', 'brKomNaStanju');
    define('COL_ART_ALBUM', 'albumArtPath');
    define('COL_SPOTIFY_ALBUM', 'albumSpotifyPath');

    //tabela korisnik
    define('TBL_KORISNIK', 'korisnik');
    define('COL_ID_KORISNIK', 'idKorisnik');
    define('COL_IME_KORISNIK', 'ime');
    define('COL_PREZIME_KORISNIK', 'prezime');
    define('COL_USERNAME_KORISNIK', 'username');
    define('COL_PASSWORD_KORISNIK', 'password');
    define('COL_ROLE_KORISNIK', 'role_fk');

    //tabela stavkanarudzbina
    define('TBL_STAVKANARUDZBINA', 'stavkanarudzbina');
    define('COL_ID_STAVKANARUDZBINA', 'idStavkaNarudzbina');
    define('COL_KOLICINA_STAVKANARUDZBINA', 'kolicina');
    define('COL_ALBUM_STAVKANARUDZBINA', 'album_fk');
    define('COL_NARUDZBINA_STAVKANARUDZBINA', 'narudzbina_fk');

    //tabela narudzbina
    define('TBL_NARUDZBINA', 'narudzbina');
    define('COL_ID_NARUDZBINA', 'idNarudzbina');
    define('COL_BRKARTICE_NARUDZBINA', 'brKartice');
    define('COL_IMENAKARTICI_NARUDZBINA', 'imeNaKartici');
    define('COL_ROKVAZENJAKARTICE_NARUDZBINA', 'rokVazenjaKartice');
    define('COL_CVV_NARUDZBINA', 'cvv');
    define('COL_IZNOS_NARUDZBINA', 'iznos');
    define('COL_ADRESA_NARUDZBINA', 'adresa');
    define('COL_KORISNIK_NARUDZBINA', 'korisnik_fk');

    //tabela beat
    define('TBL_BEAT', 'beat');
    define('COL_ID_BEAT', 'idBeat');
    define('COL_BEATPATH_BEAT', 'beatPath');
    define('COL_KORISNIK_BEAT', 'korisnik_fk');