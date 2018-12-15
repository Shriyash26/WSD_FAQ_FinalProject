@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Answer
                        <small class="text-muted float-right">
                            &nbsp;| Updated: {{ $answer->updated_at->diffForHumans() }}
                        </small>
                    </div>
                    <div class="card-body">
                        {{$answer->body}}
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Answered By: {{\App\User::find($answer->user_id)->email}}</small>
                        @if(Auth::user()->id ==$answer->user_id)
                        {{ Form::open(['method'  => 'DELETE', 'route' => ['answer.destroy', $question, $answer->id]])}}
                        <button class="btn btn-danger float-right mr-2" value="submit" type="submit" id="submit">Delete
                        </button>
                        {!! Form::close() !!}
                        <a class="btn btn-primary float-right" href="{{ route('answer.edit',['question_id'=> $question, 'answer_id'=> $answer->id, ])}}">
                            Edit Answer
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection