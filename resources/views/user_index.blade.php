@extends('layouts.app')

@section('content')
    <example-component v-bind:data_init='@json($data_init)'></example-component>
@endsection

