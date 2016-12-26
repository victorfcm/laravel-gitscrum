@section('title',  trans('Welcome to GitScrum - Step 1'))

@extends('layouts.master')

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-6">
        <h3>{{trans('Welcome to')}} {{trans('GitScrum')}}</h3>
    </div>
    <div class="col-lg-6">
        <h3 class="ptn mtn mbn pbn pull-right">{{trans('Choose repositories')}}</h3>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    <form action="{{route('wizard.call', ['provider' => \Session::get('provider'), 'step' => 'step2'])}}" method="post">
        {{ csrf_field() }}

        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

        <div class="text-center">
            <button class="btn btn-lg btn-success">{{trans('Confirm to add repositories into the')}} <strong>{{trans('GitScrum')}}</strong></button>
        </div>

    </form>

</div>
@endsection
