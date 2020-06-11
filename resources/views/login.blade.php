@extends('layouts.app')

@section('content_no_nav')
<b-container class="login-container">
    <b-row class="h-100 justify-content-center">
        <b-col cols="6" class="align-self-center h-50">
            <login_page v-bind:data_init='@json($data_init)'> </login_page>
        </b-col>
    </b-row>
</b-container>	
@endsection