<?php


    function searchData($array, $search, $value) {
        $jsonArray = json_decode($array, true);

        // find data
        $foundData = null;
        foreach($jsonArray as $data) {
            if($data[$search] === $value) {
                $foundData = $data;
                break;
            }
        }

        return $foundData;
    }

    function username($role) {
        if($role === 'admin') {
            return auth()->user()->admin->nama;
        } else {
            return auth()->user()->pegawai->nama;
        }
    }
