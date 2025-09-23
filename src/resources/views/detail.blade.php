@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail_title">
        <h1 class="title">勤怠詳細</h1>
    </div>
    <form class="detail_form" action="/correction/{{$work->id}}" method="post">
        @csrf
        <div class="detail_content">
            <div class="detail_name">
                <p class="detail_content-title">名前</p>
                <p class="detail_name-text">{{$user->name}}</p>
            </div>

            <div class="detail_date">
                <p class="detail_content-title">日付</p>
                <div class="detail_date-content">
                    <p class="detail_date-text">{{ $work && $work->punch_in ? $work->punch_in->format('Y年') : '' }}</p>
                    <p class="detail_date-text">{{ $work && $work->punch_in ? $work->punch_in->format('m月d日') : '' }}</p>
                </div>
            </div>

            <div class="detail_attendance">
                <p class="detail_content-title">出勤・退勤</p>
                <input name="punch_in" type="time" class="detail_attendance-text" value="{{ $work && $work->punch_in ? $work->punch_in->format('H:i') : '' }}">
                <p class="detail_span">～</p>
                <input name="punch_out" type="time" class="detail_attendance-text" value="{{ $work && $work->punch_out ? $work->punch_out->format('H:i') : '' }}">
                <div class="error_message">
                    @error('punch_in')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="detail_rest">
                <div>
                <p class="detail_content-title">休憩</p>
                </div>
                <div class="detail_rest-content">
                    @foreach($rests as $index => $rest)
                    <div class="detail_rest-item">
                    <input name="rests[{{ $rest->id }}][rest_in]" type="time" class="detail_rest-text" value="{{ optional($rest->rest_in)->format('H:i') }}">
                    <p class="detail_span">～</p>
                    <input name="rests[{{ $rest->id }}][rest_out]" type="time" class="detail_rest-text" value="{{ optional($rest->rest_out)->format('H:i') }}">
                    </div>
                    @endforeach
                </div>
                <div class="error_message">
                    @error('rests.*.rest_in')
                        {{ $message }}
                    @enderror
                    @error('rests.*.rest_out')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="detail_rest-input">
                <p class="detail_content-title">休憩2</p>
                <input name="new_rest[rest_in]" type="time" class="detail_rest-input-text">
                <p class="detail_span">～</p>
                <input name="new_rest[rest_out]" type="time" class="detail_rest-input-text">
                <div class="error_message">
                    @error('new_rest.rest_in')
                        {{ $message }}
                    @enderror
                    @error('new_rest.rest_out')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="detail_remarks">
                <p class="detail_content-title">備考</p>
                <textarea name="remark" class="detail_remarks-text" rows="3" cols="35">{{ old('remark') }}</textarea>
                <div class="error_message">
                    @error('remark')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            
        </div>
        <div class="form_button">
            <button class="button" type="submit">修正</button>
        </div>
    </form>
</div>

@endsection