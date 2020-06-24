@extends('layouts.app')

@section('content')
    <users v-bind:data_init='@json($data_init)'></users>
@endsection

