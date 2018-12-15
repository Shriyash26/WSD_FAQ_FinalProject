@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Question
                        <small class="text-muted float-right">
                            Updated: {{ $question->updated_at->diffForHumans() }}
                        </small>
                    </div>


                    <div class="card-body">

                        {{$question->body}}
                    </div>
                    <div class="card-footer">
                        <small class="text-muted float-left">Question by: {{\App\User::find($question->user_id)->email}}</small>
                        @if(Auth::user()->id ==$question->user_id)
                        <a class="btn btn-primary float-right"
                           href="{{ route('question.edit',['id'=> $question->id])}}">
                            Edit Question
                        </a>
                        {{ Form::open(['method'  => 'DELETE', 'route' => ['question.destroy', $question->id]])}}
                        <button class="btn btn-danger float-right mr-2" value="submit" type="submit" id="submit">Delete
                        </button>
                        {!! Form::close() !!}
                        @endif

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><a class="btn btn-primary float-left"
                                                href="{{ route('answer.create', ['question_id'=> $question->id])}}">
                            Answer Question
                        </a></div>

                    <div class="card-body">
                        @forelse($question->answers as $answer)
                            <div class="card">
                                <div class="card-body">{{$answer->body}}</div>
                                <div class="card-footer">
                                    <small class="text-muted">Answered By: {{\App\User::find($answer->user_id)->email}}</small>
                                    <small class="text-muted">
                                        &nbsp;| Updated: {{ $answer->created_at->diffForHumans() }}
                                    </small>
                                    <a class="btn btn-primary float-right"
                                       href="{{ route('answer.show', ['question_id'=> $question->id,'answer_id' => $answer->id]) }}">
                                        View
                                    </a>

                                </div>
                            </div>
                        @empty
                            <div class="card">

                                <div class="card-body"> No Answers</div>
                            </div>
                        @endforelse


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection