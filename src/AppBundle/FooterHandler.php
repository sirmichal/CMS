<?php

namespace AppBundle;

class FooterHandler {

    // data from form
    public $street = 'vbvb';
    public $city = 'cvxbcxvb';
    public $phone_number = 'uiluhi';
    public $postal_code = 'kuhikhik';
    
    // data from database
    private $data;

    public function __construct($data = null) {
        if(null != $data) {
            $this->data = $data;
            foreach ($data as $singleData) {
                switch ($singleData->getAttr()) {
                    case 'city':
                        $this->city = $singleData->getValue();
                        break;
                    case 'street':
                        $this->street = $singleData->getValue();
                        break;
                    case 'phone_number':
                        $this->phone_number = $singleData->getValue();
                        break;
                    case 'postal_code':
                        $this->postal_code = $singleData->getValue();
                        break;
                }
            }
        }
    }


    public function persistFooterData($em) {
        foreach ($this->data as $singleData) {
            switch ($singleData->getAttr()) {
                case 'city':
                    $singleData->setValue($this->city);
                    break;
                case 'street':
                    $singleData->setValue($this->street);
                    break;
                case 'phone_number':
                    $singleData->setValue($this->phone_number);
                    break;
                case 'postal_code':
                    $singleData->setValue($this->postal_code);
                    break;
            }
        }
        $em->flush();
    }
    
}
