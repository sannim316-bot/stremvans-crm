@props(['status'])

@php

$class = match($status){

'Approved'=>'status-approved',

'Rejected'=>'status-rejected',

default=>'status-pending'

};

@endphp

<span class="status {{ $class }}">
{{ $status }}
</span>