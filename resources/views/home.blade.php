@extends('layouts.app')
@section('content')
    <style type="text/css">
        #messages{
            border: 1px solid black;
            height: 300px;
            margin-bottom: 8px;
            overflow: scroll;
            padding: 5px;
        }
    </style>
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Message Module</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-8" >
                                <div id="messages" ></div>
                            </div>
                            <div class="col-lg-8" >
                                <form action="/sendmessage" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                    <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                    <textarea class="form-control msg"></textarea>
                                    <br/>
                                    <input type="button" value="Send" class="btn btn-success send-msg">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var socket = io.connect('http://localhost:8890');
        socket.on('message', function (data) {
            console.log('socket listen');
            data = JSON.parse(data);
            $( "#messages" ).append( "<strong>"+data.user+":</strong><p>"+data.message+"</p>");
        });

        $(".send-msg").click(function(e) {
            e.preventDefault();
            var token = '{{csrf_token()}}';
            var user = $("input[name='user']").val();
            var msg = $(".msg").val();
            console.log(msg);
            if(msg != '') {
                $.ajax({
                    type: "POST",
                    url: '/sendmessage',
                    dataType: "json",
                    data: {'_token':token,'message':msg,'user':user},
                    success:function(data) {
                        console.log(data);
                        $(".msg").val('');
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }else{
                alert("Please Add Message.");
            }
        })
    </script>
@endsection

@push('head')
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
@endpush