<?php

require_once 'AppController.php';
require_once __DIR__."/../../Database.php";

class OwnershipController extends AppController{
    protected $phoneLifeCycle = 2;
    protected $desktopLifeCycle = 5;
    protected $laptopLifeCycle = 3;

    public function calculateDates ($device) {
            $date = [];
            switch($device->getType()){
                case "phone":
                    $amortizationPeriod = $this->phoneLifeCycle;
                    break;
                case "laptop":
                    $amortizationPeriod = $this->laptopLifeCycle;
                    break;
                case "desktop":
                    $amortizationPeriod = $this->desktopLifeCycle;
                    break;
            };


            $date['endOfAmortization'] = (new DateTime($device->getPurchaseDate()))->add(new DateInterval("P{$amortizationPeriod}Y"));

            if ($date['endOfAmortization'] < new DateTime()) {
                $date["timeToReplacement"] = 'Replace your device now !';
            } else {
                $date["timeToReplacement"] = (new DateTime())->diff($date['endOfAmortization'])->days . " days";
            }
        $date['endOfAmortization'] = $date['endOfAmortization']->format('Y-m-d');

        return $date;
    }

    public function calculateUsage($device, $date) {

        $startDate = new DateTime($device->getPurchaseDate());
        $endDate = new DateTime($date['endOfAmortization']);
        $currentDate = new DateTime();

        if ($endDate > $currentDate) {
            $usagePeriod = $currentDate->diff($startDate)->days; // do teraz
        } else {
            $usagePeriod = $endDate->diff($startDate)->days; // do końca amortyzacji
        }

        if ($usagePeriod <= 0) {
            return 0;
        }

        $usageDays = (int)$this->ownershipRepository->getUsageDays($device->getId());

        return (int)(($usageDays / $usagePeriod) * 100);
    }
}