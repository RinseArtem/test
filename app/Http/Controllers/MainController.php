<?php

namespace App\Http\Controllers;

use App\Models\DeliverySchedule;
use App\Models\Order;
use App\Services\DeliveryScheduleCounterService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;


class MainController extends Controller
{
    private int $orderId;
    private array $daysOfWeek = [
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
        7 => 'Воскресенье',
    ];

    /**
     * @param string|null $date
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(string $date = null) {
        $now = $date ? new Carbon($date) : Carbon::now();

        $startOfMonth  = (clone $now)->startOfMonth();
        $endOfMonth    = (clone $now)->lastOfMonth();


        $deliveryDateRange = new CarbonPeriod($startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d'));

        $deliverySchedules = DeliverySchedule::query()
            ->where('delivery_date', '>=', $startOfMonth->format('Y-m-d'))
            ->where('delivery_date', '<=', $endOfMonth->format('Y-m-d'))
            ->get();


        $data = [
            'currentDate'           => $now,
            'currentDate_Ymd'       => $now->format('Y-m-d'),
            'currentDate_dmY'       => $now->format('d.m.Y'),
            'dateRange'             => collect($deliveryDateRange->toArray()),
            'deliverySchedules'     => $deliverySchedules->groupBy('delivery_date'),
        ];


        return view('index', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function new() {

        $data = [
            'days' => $this->daysOfWeek
        ];

        return view('new', $data);
    }

    /**
     * @param Request $request
     */
    public function save(Request $request) {
        $this->orderValidator($request);
        $this->saveOrder($request->all());
        $this->saveDeliverySchedule(
            $request->input('delivery_start'),
            $request->input('delivery_end'),
            $request->input('days_of_week'),
            $request->input('delivery_type'),
        );


        return redirect()->route('index');
    }

    /**
     * @param Request $request
     */
    private function orderValidator(Request $request) {
        $request->validate([
            'full_name'         => 'required',
            'phone'             => 'required',
            'title'             => 'required',
            'delivery_start'    => 'required',
            'delivery_end'      => 'required',
            'delivery_type'     => 'integer',
            'days_of_week'      => 'array',
            'comment'           => 'nullable',
        ]);
    }

    /**
     * @param array $data
     */
    private function saveOrder(array $data) {
       $order = new Order($data);
       $order->save();

       $this->orderId = $order->id;
    }

    private function saveDeliverySchedule(string $startDate, string $endDate, array $daysOfWeek, string $deliveryType) {
        $deliveryType   = str_split($deliveryType);
        $portionsCount  = $deliveryType[2]; // Количество порций на день

        // Формируем расписание
        $deliveryScheduleCounter = new DeliveryScheduleCounterService($deliveryType[0], $deliveryType[1]);
        $schedules = collect([]);
        $deliveryDateRange = new CarbonPeriod($startDate, $endDate);

        // Перебираем даты и
        foreach ($deliveryDateRange as $date) {
            $portionsPerDay = $portionsCount; // Количество порций на текущий день

            /** @var Carbon $date */
            $dayOfWeek = $date->format('N'); // Текущий день недели

            // Проверяем выбран ли текущий день
            if (in_array($dayOfWeek, $daysOfWeek) && $deliveryScheduleCounter->isDeliveryDay()) {

                // Если следующий день недели не обозначен для доставки, убираем одну порцию
                if (!in_array(++$dayOfWeek, $daysOfWeek) && $portionsCount > 1) {
                    $portionsPerDay--;
                }

                // Сохраняем в коллекцию результат
                (new DeliverySchedule([
                    'order_id'              => $this->orderId,
                    'delivery_date'         => $date->format('Y-m-d'),
                    'number_of_portion'     => $portionsPerDay,
                ]))->save();
            }

            $deliveryScheduleCounter->toNextDay();
        }

    }
}
