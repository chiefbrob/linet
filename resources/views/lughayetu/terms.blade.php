@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Masharti</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ol>
                        <li>
                            Mtandao huu umetengenezwa kumnufaisha binadamu kama wewe na unapoitumia wapaswa kuzingatia masharti ya taifa. 
                        </li>

                        <li>
                            Lugha rasmi ya mtandao huu ni Kiswahili. Unapozungumza au kuuliza swali, kama inawezekana, tumia lugha ya Kiswahili.
                        </li>

                        <li>
                            Utumizi mbaya wa mifumo hii ya mawasiliano ni hatia na waweza kuchukuliwa hatua za kisheria iwapo utapatikana umevunja kanuni za nchi.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
