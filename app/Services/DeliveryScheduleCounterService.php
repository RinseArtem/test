<?php

namespace App\Services;

class DeliveryScheduleCounterService
{

    private int $deliveryDaysCount;
    private int $offsetDaysCount;

    private int $deliveryDaysCounter = 1; // Счетчик дней доставки
    private int $offsetDaysCounter = 0; // Счетчик дней перерыва

    /**
     * @param int $deliveryDaysCount
     * @param int $offsetDaysCount
     */
    public function __construct(int $deliveryDaysCount, int $offsetDaysCount) {
        $this->deliveryDaysCount    = $deliveryDaysCount;
        $this->offsetDaysCount      = $offsetDaysCount;
    }

    public function toNextDay() {
        if ($this->isLimitDeliveryDays() && $this->isLimitOffsetDays()) {
            $this->deliveryDaysCounter = 0;
            $this->offsetDaysCounter = 0;
        }

        $this->calculateOffsetDays();
        $this->calculateDeliveryDay();


    }

    public function isDeliveryDay() {
        $dump = [
            'delivery'      => $this->deliveryDaysCounter,
            'offset'        => $this->offsetDaysCounter,
            'isDelivery'    => $this->deliveryDaysCounter <= $this->deliveryDaysCount && $this->offsetDaysCounter == 0
        ];

        return $this->deliveryDaysCounter <= $this->deliveryDaysCount && $this->offsetDaysCounter == 0;
    }

    private function calculateDeliveryDay() {
        if (!$this->isLimitDeliveryDays()) {
            $this->deliveryDaysCounter++;
        }
    }

    private function calculateOffsetDays() {
        if ($this->isLimitDeliveryDays() && !$this->isLimitOffsetDays()) {
            $this->offsetDaysCounter++;
        }
    }

    /**
     * @return bool
     */
    private function isLimitDeliveryDays() {
        return $this->deliveryDaysCounter >= $this->deliveryDaysCount;
    }

    /**
     * @return bool
     */
    private function isLimitOffsetDays() {
        return $this->offsetDaysCounter >= $this->offsetDaysCount;
    }
}
