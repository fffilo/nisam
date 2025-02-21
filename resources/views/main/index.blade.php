@extends('layouts.base')

@section('body')
            <div class="component">
                <h2>Ko zove danas?</h2>
                <button class="cn-button" id="cn-button">NISAM!</button>
                <div class="cn-wrapper" id="cn-wrapper">
                    <ul>
                        @foreach ($users as $user)
                            <li><a href="#"><span>{{ $user->name }}<small>({{ $user->countOrders }})</small></span></a></li>
                        @endforeach
                     </ul>
                </div>
            </div>

            <header>
                <h1>{{$nextUser->name}}...
                    <span>Idemo u {{$place->name}}. Na tebi je red da <a href="#">nazoveš!</a></span>
                </h1>
                <nav class="codrops-demos">
                    {!! Form::open(array('route' => 'main.order','id' => 'order-form')) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <textarea class="area_better" rows="4" cols="50" type="text" name="desc" id="desc">{{$myorder}}</textarea><br>
                     <a href="#" onclick="document.getElementById('order-form').submit();">Naruci!</a>
                    {!! Form::close() !!}
                </nav>
            </header>

            <section>
                <h2><a href="{{$place->link}}">{{$place->short}}</a> ({{$place->phone}})</h2>
                @foreach ($orders as $order)
                    <p>{{$order->userFull->name}} - {{$order->desc}}</p>
                @endforeach
            </section>

        <script src="js/demo2.js"></script>
@stop
