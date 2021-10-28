@extends('app')
@section('title', 'test')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1>Заказов на {{ $currentDate_dmY }}</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Телефон</th>
                            <th>Наименование блюда</th>
                            <th>Порций</th>
                            <th>Период с</th>
                            <th>По</th>
                            <th>Комментарий</th>
                        </tr>
                    </thead>
                    @foreach($deliverySchedules->get($currentDate_Ymd) ?? [] as $item)
                        <tr>
                            <td>
                                {{ $item->order->full_name }}
                            </td>
                            <td>
                                {{ $item->order->phone }}
                            </td>
                            <td>
                                {{ $item->order->title }}
                            </td>
                            <td>
                                {{ $item->number_of_portion }}
                            </td>
                            <td>
                                {{ $item->order->delivery_start->format('d.m.Y') }}
                            </td>
                            <td>
                                {{ $item->order->delivery_end->format('d.m.Y') }}
                            </td>
                            <td>
                                {{ $item->order->comment }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-4">
                <div class="calendar">
                    <div class="header-calendar">
                        <b class="month">{{ $currentDate->format('F') }}</b>
                        <p class="year">{{ $currentDate->format('Y') }}</p>
                    </div>
                    <div class="calendar-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">ПН</th>
                                    <th class="text-center">ВТ</th>
                                    <th class="text-center">СР</th>
                                    <th class="text-center">ЧТ</th>
                                    <th class="text-center">ПТ</th>
                                    <th class="text-center">СБ</th>
                                    <th class="text-center">ВС</th>
                                </tr>
                            </thead>
                            @foreach($dateRange->chunk(7) as $dateChunk)
                                <tr>
                                    @foreach($dateChunk as $date)
                                        <td class="text-center @if($date->format('d') == $currentDate->format('d')) table-success @endif"
                                            data-bs-toggle="popover"
                                            data-bs-placement="bottom"
                                            data-bs-trigger="hover focus"
                                            title="Заказов: {{ $deliverySchedules->has($date->format('Y-m-d')) ? $deliverySchedules->get($date->format('Y-m-d'))->count() : 0 }}"
                                            data-bs-content="Порций: {{ $deliverySchedules->has($date->format('Y-m-d')) ? $deliverySchedules->get($date->format('Y-m-d'))->sum('number_of_portion') : 0 }}"
                                        >
                                            <a href="{{ route('index', ['date' => $date->format('Y-m-d')]) }}" class="btn btn-link text-decoration-none">
                                                {{ $date->format('d') }}
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

