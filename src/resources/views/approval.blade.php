@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/approval.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail_title">
        <h1 class="title">勤怠詳細</h1>
    </div>
    <form class="detail_form" action="/admin/stamp_correction_request/approve/{{$correction->id}}" method="post">
        @csrf
        <div class="detail_content">
            <div class="detail_name">
                <p class="detail_content-title">名前</p>
                <p class="detail_name-text">{{$user->name}}</p>
            </div>

            <div class="detail_date">
                <p class="detail_content-title">日付</p>
                <div class="detail_date-content">
                    <p class="detail_date-text">{{ $correction && $correction->punch_in ? $correction->punch_in->format('Y年') : '' }}</p>
                    <p class="detail_date-text">{{ $correction && $correction->punch_in ? $correction->punch_in->format('m月d日') : '' }}</p>
                </div>
            </div>

            <div class="detail_attendance">
                <p class="detail_content-title">出勤・退勤</p>
                <input name="punch_in" type="time" class="detail_attendance-text" value="{{ $correction && $correction->punch_in ? $correction->punch_in->format('H:i') : '' }}" readonly>
                <p class="detail_span">～</p>
                <input name="punch_out" type="time" class="detail_attendance-text" value="{{ $correction && $correction->punch_out ? $correction->punch_out->format('H:i') : '' }}" readonly>
            </div>

            <div class="detail_rest">
                <div>
                <p class="detail_content-title">休憩</p>
                </div>
                <div class="detail_rest-content">
                    @foreach($correction->rests ?? [] as $rest)
                    @if(!empty($rest['rest_id']))
                    <div class="detail_rest-item">
                    <input type="time" class="detail_rest-text" value="{{ $rest['rest_in'] ? \Carbon\Carbon::parse($rest['rest_in'])->format('H:i') : '' }}" readonly>
                    <p class="detail_span">～</p>
                    <input type="time" class="detail_rest-text" value="{{ $rest['rest_out'] ? \Carbon\Carbon::parse($rest['rest_out'])->format('H:i') : '' }}" readonly>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="detail_rest-input">
                <p class="detail_content-title">休憩2</p>
                @php
                    $newRests = collect($correction->rests ?? [])->filter(fn($r) => empty($r['rest_id']))->values();
                @endphp
                @if($newRests->isNotEmpty())
                    <input type="text" class="detail_rest-input-text" value="{{ $newRests[0]['rest_in'] ? \Carbon\Carbon::parse($newRests[0]['rest_in'])->format('H:i') : '' }}" readonly>
                    <p class="detail_span">～</p>
                    <input type="text" class="detail_rest-input-text" value="{{ $newRests[0]['rest_out'] ? \Carbon\Carbon::parse($newRests[0]['rest_out'])->format('H:i') : '' }}" readonly>
                @else
                    <input type="time" class="detail_rest-input-text" value="" readonly>
                    <p class="detail_span">～</p>
                    <input type="time" class="detail_rest-input-text" value="" readonly>
                @endif
            </div>

            <div class="detail_remarks">
                <p class="detail_content-title">備考</p>
                <textarea name="remark" class="detail_remarks-text" rows="3" cols="35" readonly>{{ $correction->remark }}</textarea>
            </div>
            
        </div>
        @if($status === 0)
        <div class="form_button">
            <button class="button" type="submit">承認</button>
        </div>
        @else
        <div class="form_button-message">
            <p class="correction_message">承認済み</p>
        </div>
        @endif
    </form>
</div>

@endsection