@extends('app')
@section('title', 'Новый заказ')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <form action="{{ route('order.save') }}" method="post">
                    <div class="row">
                        @csrf
                        <div class="col-12 mt-2 mb-2">
                            <label for="full-name" class="form-label">ФИО</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" id="full-name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <label for="phone" class="form-label">Телефон</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <label for="title" class="form-label">Название рациона</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <div class="row">
                                <div class="col-6">
                                    <label for="delivery-start" class="form-label">Период с</label>
                                    <input type="date" name="delivery_start" class="form-control @error('delivery_start') is-invalid @enderror" id="delivery-start" value="{{ old('delivery_start') ?? date('Y-m-d') }}" required>
                                    @error('delivery_start')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="delivery-end" class="form-label">По</label>
                                    <input type="date" name="delivery_end" class="form-control @error('delivery_end') is-invalid @enderror" id="delivery-end" value="{{ old('delivery_end') }}" required>
                                    @error('delivery_end')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <label for="delivery-type" class="form-label">Вариант доставки</label>
                            <select name="delivery_type" class="form-select @error('delivery_type') is-invalid @enderror" id="delivery-type">
                                <option value="101" {{ old('delivery_type') == 101 ? 'selected' : '' }}>Ежедневно</option>
                                <option value="111" {{ old('delivery_type') == 111 ? 'selected' : '' }}>Через день; 1 порция</option>
                                <option value="112" {{ old('delivery_type') == 112 ? 'selected' : '' }}>Через день; 2 порции</option>
                            </select>
                            @error('delivery_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            @foreach($days as $key => $day)
                                <div class="form-check">
                                    <input type="checkbox" name="days_of_week[]" class="form-check-input @error('days_of_week') is-invalid @enderror" value="{{ $key }}" id="days-of-week{{ $key }}" {{ in_array($key, old('days_of_week') ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="days-of-week{{ $key }}">
                                        {{ $day }}
                                    </label>
                                </div>
                            @endforeach
                            @error('days_of_week')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea name="comment" class="form-control" id="comment" rows="3">{{ old('comment') }}</textarea>
                        </div>
                        <div class="col-12 mt-2 mb-2">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

