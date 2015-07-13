@extends('layouts.main')

@section('title')
    Capitulo
@stop
@section('body')

    <div class="container">
        <div class="jumbotron">
            <h2 class="text-center">Capitulo</h2>
            @if(session('message'))
                <div class="alert alert-success">
                    {{Session::get('message')}}
                </div>

            @endif
            {!! Form::open( array('url'=> 'capitulo')) !!}
            <a href="{{URL::to('capitulo_list')}}"  class="">Clique aqui para ver a lista dos capitulos</a>

                <div class="form-group">
                    {!! Form::label('disciplinas','Escolha a disciplina',['class'=>'text-primary']) !!}
                    {!! Form::select('disciplinas', $disciplinas , Input::old('disciplinas'),['class'=>'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('nome','Introduza o nome do capitulo:',['class'=>'text-primary']) !!}
                    {!! Form::textarea('nome','',['class'=>'form-control', 'placeholder'=>'Introduza o capitulo','rows'=>'1'])  !!}

                </div>

                <div>  <button type="submit" name="Gravar" class="btn btn-primary">Gravar</button>
                </div>



            {!! Form::close() !!}
        </div>
    </div>
@stop